<?php

use Slim\Http\{
    Request, Response
};

$app->group('/register', function () {
    $this->get('[/]', function ($request, $response, $args) {
        return $this->view->render($response, 'register.twig');
    })->setName('register');

    $this->post('[/]', function ($request, $response, $args) {
        if ($_POST['register-password'] == $_POST['register-passconfirm']) {
            /*Check if the user already exists*/
            $stmnt = $this->database->prepare("SELECT user_email FROM users WHERE user_email = :user");
            $stmnt->execute([
                'user' => $_POST['register-email']
            ]);
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($stmnt->rowCount() == 0) {
                /*Register Variables*/
                $username = $_POST['register-username'];
                $email = $_POST['register-email'];
                $password = password_hash($_POST['register-password'], PASSWORD_BCRYPT);
                $userId = "user_" . rand(-1000, 1000);
                /*Timestamp when the mail is sent*/
                $time = time();
                /*Generate the authorization code*/
                $authCode = rand(0, 5000);

                /*Mail Details*/
                $to = $email;
                $from = 'theitconnection@duncte123.me';
                $subject = "The I.T. Connection Authorization Code";
                $txt = "Thank you for registering on The I.T. Connection!\n\nThis code expires after 5 minutes\nIf your code expires, please register again at our website.\n\nAuthorization code: " . $authCode;
                //$headers = "From: theitconnection@gmail.com" . "\r\n";

                /*Send the mail*/
                $c = $GLOBALS['config'];
                $mailer = getMailer();

                $mailer->Subject = $subject;
                $mailer->addAddress($to);
                $mailer->CharSet = 'UTF-8';
                $mailer->msgHTML($txt);
                $mailer->send();

                /*Insert the authorization details in the database with PDO*/
                $stmt = $this->database->prepare("INSERT INTO authorization
          (auth_code, auth_user, auth_username, user_password, auth_time) VALUES(:code, :userid, :username, :pass,:t)");
                /*Execute the statement and bind the params in it*/
                $stmt->execute([
                    'code' => $authCode,
                    'pass' => $password,
                    'userid' => $userId,
                    'username' => $_POST['register-username'],
                    't' => $time
                ]);

                /*Prepare a statement with the database routing*/
                $stmt = $this->database->prepare("INSERT INTO users (user_id, user_firstname, user_lastname ,user_email) VALUES(:id, 'unset', 'unset',:email)");
                /*Execute the statement and bind the params in it*/
                $stmt->execute([
                    'id' => $userId,
                    'email' => $email
                ]);
                echo 0;
                /*Redirect the user*/
                return $response->withRedirect($this->router->pathFor('thanks', [
                    'message' => 'register'
                ]), 302);
            } else {
                /*Redirect the user*/
                return $response->withRedirect($this->router->pathFor('thanks', [
                    'message' => 'noaccount'
                ]), 302);
            }
        }
        return null;
    });
});

$app->post('/login', function ($request, $response, $args) {
    $stmnt = $this->database->prepare("SELECT account_id, account_name, user_email, user_password
                                       FROM accounts NATURAL JOIN users WHERE user_email = :email");
    $stmnt->execute(['email' => $_POST['login-email']]);
    $data = $stmnt->fetchAll(PDO::FETCH_ASSOC);
    if (count($data) > 0) {
        foreach ($data as $d) {
            if (password_verify($_POST['login-pass'], $d['user_password'])) {
                $_SESSION['user_name'] = $d['account_name'];
                $_SESSION['user_key'] = $d['account_id'];
                return $response->withRedirect($this->router->pathFor('home'));
            } else {
                $_SESSION['error'] = "user-crednotcorrect";
                return $response->withRedirect($this->router->pathFor('error', ['error' => 'password']));
            }
        }
    } else {
        $_SESSION['error'] = "user-notexist";
        return $response->withRedirect($this->router->pathFor('error', ['error' => 'noaccount']));
    }

})->setName('login');

$app->group('/authorization', function () {
    $this->get('[/]', function (Request $request, Response $response, $args) {
        return $this->view->render($response, 'authorization.twig');
    })->setName('authorization');

    $this->post('[/]', function (Request $request, Response $response, $args) {
        $stmnt = $this->database->prepare("SELECT auth_code, user_password FROM authorization WHERE
                                           auth_code = :code");
        $stmnt->execute([
            'code' => $_POST['auth-code']
        ]);

        if ($stmnt->rowCount() > 0) {
            $stmnt = $this->database->prepare("SELECT auth_code, auth_user, auth_username, user_password, auth_time
                                           FROM authorization WHERE auth_code = :code");
            $stmnt->execute([
                'code' => $_POST['auth-code']
            ]);
            $data = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            if (count($data) > 0) {
                foreach ($data as $d) {
                    if (password_verify($_POST['auth-pass'], $d['user_password'])) {
                        $accountId = "account_" . rand(-1000, 1000);
                        $stmnt = $this->database->prepare("INSERT INTO accounts (account_id, account_name, user_id, user_password) VALUES (:accid, :accname, :userid, :userpass)");
                        $success = $stmnt->execute([
                            'accid' => $accountId,
                            'accname' => $d['auth_username'],
                            'userid' => $d['auth_user'],
                            'userpass' => $d['user_password']
                        ]);
                        if (!$success) {
                            return $response->withRedirect($this->router->pathFor('error'));
                        } else {
                            $stmnt = $this->database->prepare("DELETE FROM authorization WHERE auth_code = :code");
                            $stmnt->execute(['code' => $_POST['auth-code']]);
                            return $response->withRedirect($this->router->pathFor('thanks', [
                                'message' => 'authorized'
                            ]));
                        }
                    } else {
                        return $response->withRedirect($this->router->pathFor('error', ['error' => 'password']));
                    }

                }
            } else {
                return $response->withRedirect($this->router->pathFor('error', [
                    'error' => 'noauth'
                ]));
            }
        } else {
            return $response->withRedirect($this->router->pathFor('error', [
                'error' => 'noauth'
            ]));
        }

    });
});
