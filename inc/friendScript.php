<?php
session_start();
include('../app/app.php');
require('globalFunctions.php');

if (isset($_POST['type']) && $_POST['type'] != "") {
    switch ($_POST['type']) {
        case "request":
            /* Gets activated when someone sends a friend request */
            $curUser = $_POST['curUser'];
            $othUser = $_POST['othUser'];

            $friendAddName = "unset";

            /* Get the account name from the requester */
            $result = ReturnQueryResult("SELECT account_name, account_id FROM accounts WHERE account_id = :accId", $container->database, ['accId' => $curUser]);
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
                              VALUES (:curUs, :othUs, :friReq, :reqTim);", $container->database, $queryArguments);
                echo "success";
            }
            break;
        case "accept":
            /* Gets activated when someone accepts a friend request */
            $requester = str_replace("'", "", $_POST['requester']);
            $accepter = str_replace("'", "", $_POST['accepter']);

            $friendAddName = "unset";

            $result = ReturnQueryResult("SELECT account_name, account_id FROM accounts WHERE account_id = :accId", $container->database, ['accId' => $requester]);
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
                              VALUES(:accId, :accFri, :friSinc)", $container->database, $queryArguments);

                /* Preset the query arguments*/
                $queryArguments = array(
                    'cuid' => $requester,
                    'otuid' => $accepter,
                    'frireq' => $friendAddName
                );

                /* Delete friend request from the friend_request table */
                ExecuteQuery("DELETE FROM friend_request WHERE current_user_id = :cuid AND other_user_id = :otuid AND 
                              friend_requester = :frireq", $container->database, $queryArguments);
                echo "success";
            }
            break;
        case "check":
            /* Gets activated when someone goes into their friend tab */
            if (isset($_POST['userId'])) {
                $result = ReturnQueryResult("SELECT * FROM friend_request WHERE other_user_id = :uid;", $container->database, [
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
            break;
        case 'retrieve':
            header('Content-Type: application/json');
            if (isset($_POST['userId'])) {
                $userId = StripPostQuotes($_POST['userId']);
                /*Get all the data i need from the friends table*/
                $queryArguments = ['id' => $userId];
                $result = ReturnQueryResult("SELECT * FROM friends WHERE account_id = :id ",
                    $container->database, $queryArguments);
                if (count($result) > 0) {
                    echo json_encode($result);
                    // whoops something died
                } else {
                    $userId = StripPostQuotes($_POST['userId']);
                    /*Get all the data i need from the friends table*/
                    $queryArguments = ['id' => $userId];
                    $result = ReturnQueryResult("SELECT * FROM friends WHERE account_friended = :id ",
                        $container->database, $queryArguments);
                    if(count($result) > 0){
                        echo json_encode($result);
                    }else{
                        echo json_encode(['friends' => []]);
                    }
                }
            }
            break;
        default:
            echo "<p>" . "Failed to resolve request" . "</p>";
            break;
    }
} else {
    echo "<p>" . "Access Denied" . "</p>";
}

function CheckIfFriends($accId, $accFriended, $db)
{
    $accountId = CheckUserId($accId, $db);
    $queryArguments = array(
        'accId' => $accFriended,
        'accFriended' => $accountId
    );
    $result = ReturnQueryResult("SELECT account_id, account_friended FROM friends
                                        WHERE account_id = :accId AND account_friended = :accFriended",
        $db, $queryArguments);
}

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