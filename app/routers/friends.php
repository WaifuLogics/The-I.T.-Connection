<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/friends', function () {
    $this->post('/request', function (Request $request, Response $response, $args) {
        $curUser = $_POST['curUser'];
        $othUser = $_POST['othUser'];

        $friendAddName = "unset";

        /* Get the account name from the requester */
        $result = ReturnQueryResult("SELECT account_name, account_id FROM accounts WHERE account_id = :accId", $this->database, ['accId' => $curUser]);
        if (count($result) > 0) {
            foreach ($result as $data) {
                $friendAddName = $data['account_name'];
            }
        }
        /* Preset the query arguments */
        if ($friendAddName != "unset") {
            $queryArguments = array(
                'curUs' => $curUser,
                'othUs' => $othUser,
                'friReq' => $friendAddName,
                'reqTim' => date("y-m-d H:i:s")
            );
            /* Insert a friend request into a table */
            ExecuteQuery("INSERT INTO friend_request (current_user_id, other_user_id, friend_requester, request_time)
                          VALUES (:curUs, :othUs, :friReq, :reqTim);", $this->database, $queryArguments);
            echo "success";
        }
    })->setName('friend-request');

    $this->post('/accept', function (Request $request, Response $response, $args) {
        /* Gets activated when someone accepts a friend request */
        $requester = str_replace("'", "", $_POST['requester']);
        $accepter = str_replace("'", "", $_POST['accepter']);

        $friendAddName = "unset";

        $result = ReturnQueryResult("SELECT account_name, account_id FROM accounts WHERE account_id = :accId", $this->database, ['accId' => $requester]);
        if (count($result) > 0) {
            foreach ($result as $data) {
                $friendAddName = $data['account_name'];
            }
        }
        if ($friendAddName != "unset") {
            /* Preset the query arguments*/
            $queryArguments = array(
                'accId' => $accepter,
                'accFri' => $requester,
                'friSinc' => date("y-m-d H:i:s")
            );

            /* Insert new friends into the friends table */
            ExecuteQuery("INSERT INTO friends (account_id, account_friended, friends_since)
                          VALUES(:accId, :accFri, :friSinc)", $this->database, $queryArguments);

            /* Preset the query arguments*/
            $queryArguments = array(
                'cuid' => $requester,
                'otuid' => $accepter,
                'frireq' => $friendAddName
            );

            /* Delete friend request from the friend_request table */
            ExecuteQuery("DELETE FROM friend_request WHERE current_user_id = :cuid AND other_user_id = :otuid AND
                          friend_requester = :frireq", $this->database, $queryArguments);
            echo "success";
        }
    })->setName('friend-accept');

    $this->post('/check', function (Request $request, Response $response, $args) {
        /* Gets activated when someone goes into their friend tab */
        if (isset($_POST['userId'])) {
            $result = ReturnQueryResult("SELECT * FROM friend_request WHERE other_user_id = :uid;", $this->database, [
                "uid" => $_POST['userId']
            ]);
            if (count($result) > 0) {
                $requester = $result['0']['friend_requester'];
                $accepter = str_replace("'", "", $_POST['userId']);
                if ($result['0']['current_user_id'] != str_replace("'", "", $_POST['userId'])) {
                    echo "<div class='row friend-request'>";
                    echo "<p>" . $result['0']['friend_requester'] . "</p>";
                    $array = array('requester' => $result['0']['current_user_id'],
                        'accepter' => $accepter);
                    $functionArgs = json_encode($array);
                    echo "<button type='button' onclick='AcceptRequest(" . $functionArgs . ")'
                        class='btn-flat white-text blue waves-effect waves-light'>" . "<i class='material-icons'>done</i>" . "</button>";
                    echo "</div>";
                } else {
                    echo "<p>" . "No friend requests found" . "</p>";
                }

            } else {
                echo "<p>" . "No friend requests found" . "</p>";
            }
        } else {
            echo "Failed to find friend requests";
        }
    })->setName('friend-check');

    $this->post('/retrieve', function (Request $request, Response $response, $args) {
        //header('Content-Type: application/json');
        $data = ['friends' => []];
        if (isset($_POST['userId'])) {
            $userId = StripPostQuotes($_POST['userId']);
            /*Get all the data i need from the friends table*/
            $queryArguments = ['id' => $userId];
            $result = ReturnQueryResult("SELECT * FROM friends WHERE account_id = :id ",
                $this->database, $queryArguments);
            if (count($result) <= 0) {
                /*Get all the data i need from the friends table*/
                $result2 = ReturnQueryResult("SELECT * FROM friends WHERE account_friended = :id ",
                    $this->database, $queryArguments);
                if (count($result) > 0) {
                    $data = ['friends' => $result2 ];
                }
            } else {
                $data = ['friends' => $result ];
            }
        }
        return $response->withJson($data);
    })->setName('friend-retrieve');

    $this->post('/getUserId', function (Request $request, Response $response, $args) {
        /*Execute a query that returns the user id of the requested post variable*/
        if (isset($_POST['userId'])) {
            $id = $_POST['userId'];
            $query = "SELECT account_name FROM accounts WHERE account_id = :id";
            $result = ReturnQueryResult($query, $this->database, ['id' => $id]);
            /* Return the JSON array of the result and give it back as a response */
            $array = ['account_name' => $result['0']['account_name']];
            echo json_encode($array);
        }
    })->setName('friend-getUserId');
});

function CheckUserId($name, $db)
{
    $queryArguments = array('name' => $name);
    $result = ReturnQueryResult("SELECT account_id FROM accounts WHERE account_name = :name", $db, $queryArguments);
    return $result['0']['account_id'];
}

function StripPostQuotes($str)
{
    return str_replace("'", "", $str);
}