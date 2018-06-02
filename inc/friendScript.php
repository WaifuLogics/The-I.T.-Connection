<?php
session_start();
include('../app/app.php');
/* Assign the PDO object to a local variable */

if(isset($_POST['type']) && $_POST['type'] != ""){
  switch ($_POST['type']){
    case "request":
      /* Gets activated when someone sends a friend request */
      $curUser = $_POST['curUser'];
      $othUser = $_POST['othUser'];

      $stmnt = $container->database->prepare("INSERT INTO friend_request (current_user_id, other_user_id, friend_requester, request_time)
                       VALUES (:curUs, :othUs, :friReq, :reqTim);");
      $stmnt->execute([
        'curUs' => $curUser,
        'othUs' => $othUser,
        'friReq' => $curUser,
        'reqTim' => date("y-m-d H:i:s"),
      ]);
      echo "success";
      break;
    case "accept":
      /* Gets activated when someone accepts a friend request */
      $requester = str_replace("'", "", $_POST['requester']);
      $accepter = str_replace("'", "", $_POST['accepter']);

      $stmnt = $container->database->prepare("INSERT INTO friends (account_id, account_friended, friends_since)
                                              VALUES(:accId, :accFri, :friSinc)");
      $stmnt->execute([
        'accId' => $accepter,
        'accFri' => $requester,
        'friSinc' => date("y-m-d H:i:s")
      ]);

      $stmnt = $container->database->prepare("DELETE FROM friend_request WHERE current_user_id = :cuid AND other_user_id = :otuid AND friend_requester = :frireq");
      $stmnt->execute([
        'cuid' => $requester,
        'otuid' => $accepter,
        'frireq' => $requester,
      ]);

      echo "success";
      break;
    case "check":
      /* Gets activated when someone goes into their friend tab */
      if(isset($_POST['userId'])){
        $stmnt = $container->database->prepare("SELECT * FROM friend_request;");
        $stmnt->execute();
        $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            foreach($result as $data){
              if($_POST['userId'] != $data['friend_requester']){
                echo "<div class='row friend-request'>";
                echo "<p>".$data['friend_requester']."</p>";
                $array = array('requester' => $data['friend_requester'],
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
