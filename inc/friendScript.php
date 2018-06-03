<?php
session_start();
include('../app/app.php');
require('globalFunctions.php');

if(isset($_POST['type']) && $_POST['type'] != ""){
  switch ($_POST['type']){
    case "request":
      /* Gets activated when someone sends a friend request */
      $curUser = $_POST['curUser'];
      $othUser = $_POST['othUser'];

      $friendAddName = "unset";

      /* Get the account name from the requester */
      $result = ReturnQueryResult("SELECT account_name, account_id FROM accounts WHERE account_id = :accId", ['accId' => $curUser], $container->database);
      if(count($result) > 0){
        foreach($result as $data){
          $friendAddName = $data['account_name'];
        }
      }
      /* Preset the query arguments */
      if($friendAddName != "unset"){
        $queryArguments = array(
          'curUs' => $curUser,
          'othUs' => $othUser,
          'friReq' => $friendAddName,
          'reqTim' => date("y-m-d H:i:s")
        );
        /* Insert a friend request into a table */
        ExecuteQuery("INSERT INTO friend_request (current_user_id, other_user_id, friend_requester, request_time)
        VALUES (:curUs, :othUs, :friReq, :reqTim);", $queryArguments, $container->database);
        echo "success";
      }
      break;
    case "accept":
      /* Gets activated when someone accepts a friend request */
      $requester = str_replace("'", "", $_POST['requester']);
      $accepter = str_replace("'", "", $_POST['accepter']);

      $friendAddName = "unset";

      $result = ReturnQueryResult("SELECT account_name, account_id FROM accounts WHERE account_id = :accId", ['accId' => $requester], $container->database);
      if(count($result) > 0){
        foreach($result as $data){
          $friendAddName = $data['account_name'];
        }
      }
      if($friendAddName != "unset"){
        /* Preset the query arguments*/
        $queryArguments = array(
          'accId' => $accepter,
          'accFri' => $requester,
          'friSinc' => date("y-m-d H:i:s")
        );

        /* Insert new friends into the friends table */
        ExecuteQuery("INSERT INTO friends (account_id, account_friended, friends_since)
        VALUES(:accId, :accFri, :friSinc)", $queryArguments, $container->database);

        /* Preset the query arguments*/
        $queryArguments = array(
          'cuid' => $requester,
          'otuid' => $accepter,
          'frireq' => $friendAddName,
        );

        /* Delete friend request from the friend_request table */
        ExecuteQuery("DELETE FROM friend_request WHERE current_user_id = :cuid AND other_user_id = :otuid AND friend_requester = :frireq"
                     , $queryArguments, $container->database);
        echo "success";
      }
      break;
    case "check":
      /* Gets activated when someone goes into their friend tab */
      if(isset($_POST['userId'])){
        $result = ReturnQueryResult("SELECT * FROM friend_request;", [], $container->database);
        if(count($result) > 0){
            foreach($result as $data){
              if($_POST['userId'] != $data['friend_requester']){
                echo "<div class='row friend-request'>";
                echo "<p>".$data['friend_requester']."</p>";
                $array = array('requester' => $data['current_user_id'],
                 'accepter' => str_replace("'", "", $_POST['userId']));
                $functionArgs = json_encode($array);
                echo "<button type='button' onclick='AcceptRequest(".$functionArgs.")' class='btn-flat white-text blue waves-effect waves-light'>"."<i class='material-icons'>done</i>"."</button>";
                echo "</div>";
              }
            }
        }else{
          echo "<p>"."No friend requests found"."</p>";
        }
      }else{
        echo "Failed to find friend requests";
      }
      break;
    default:
      echo "<p>"."Failed to resolve request"."</p>";
  }
}else{
  echo "<p>"."Access Denied"."</p>";
}
