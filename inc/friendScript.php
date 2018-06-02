<?php
include('../app/app.php');
/* Assign the PDO object to a local variable */

if(isset($_POST['type']) && $_POST['type'] != ""){
  switch ($_POST['type']){
    case "request":
      /* Get's activated when someone sends a friend request */
      $curUser = $_POST['curUser'];
      $othUser = $_POST['othUser'];

      $stmnt = $container->database->prepare("INSERT INTO friend_request (current_user_id, other_user_id, request_time)
                       VALUES (:curUs, :othUs, :reqTim);");
      $stmnt->execute([
        'curUs' => $curUser,
        'othUs' => $othUser,
        'reqTim' => date("y-m-d H:i:s"),
      ]);
      echo "success";
      break;
    case "accept":
      /* Get's activated when someone accepts a friend request */
      break;
    default:
      echo "<p>"."Failed to resolve request"."</p>";
  }
}else{
  echo "<p>"."Access Denied"."</p>";
}
