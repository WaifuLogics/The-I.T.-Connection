<?php

use Slim\Http\{
    Request, Response
};

$app->get('/', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'home.twig', [
        //an array of variables that can be used in twig
        'color' => 'Jemoeder',
        'name' => 'Guylian',
        'items' => array_merge(range('A', 'Z'), range('a', 'z'))
    ]);
})->setName('home');

$app->group('/register', function () {
    $this->get('[/]', function ($request, $response, $args) {
        return $this->view->render($response, 'register.twig', []);
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
                $time = date("Y/m/d h:i:s");
                /*Generate the authorization code*/
                $authCode = rand(0, 5000);

                /*Mail Details*/
                $to = $email;
                $subject = "The I.T. Connection Authorization Code";
                $txt = "Thank you for registering on The I.T. Connection!\n\nThis code expires after 5 minutes\nIf your code expires, please register again at our website.\n\nAuthorization code: " . $auth;
                $headers = "From: theitconnection@gmail.com" . "\r\n";

                /*Send the mail*/
                mail($to, $subject, $txt, $headers);

                /*Insert the authorization details in the database with PDO*/
                $stmt = $this->database->prepare("INSERT INTO authorization
          (auth_code, auth_user, user_password, auth_time) VALUES(:code, :user, :pass,:t)");
                /*Execute the statement and bind the params in it*/
                $stmt->execute([
                    'code' => $authCode,
                    'pass' => $password,
                    'user' => $userId,
                    't' => $time
                ]);

                /*Prepare a statement with the database routing*/
                $stmt = $this->database->prepare("INSERT INTO users (user_id, user_firstname, user_lastname ,user_email) VALUES(:id, 'unset', 'unset',:email)");
                /*Execute the statement and bind the params in it*/
                $stmt->execute([
                    'id' => $userId,
                    'email' => $email
                ]);
                /*Redirect the user*/
                return $response->withRedirect('/thanks', 301);
            } else {
                /*Redirect the user*/
                return $response->withRedirect('/error', 301);
            }
        }
        return null;
    });
});

$app->get('/thanks', function (Request $request, Response $response, $args) {
    var_dump($request);
//    return $this->view->render($response, 'thanks.twig', []);
})->setName('thanks');

$app->get('/error', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'error.twig', []);
})->setName('error');

$app->get('/authorization', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'authorization.twig', []);
})->setName('authorization');
