<?php
session_start();
/* Include the app file to get acces to the PDO object */
include('../app/app.php');

/* Check if the POST variable is set and isn't empty */
if(isset($_POST['search-username']) && $_POST['search-username'] != ""){
  /* Create a variable that acts as the search arguments*/
  $searchName = "%".$_POST['search-username']."%";

  /* Search for the $searchName contents in the database */
  $stmnt = $container->database->prepare("SELECT account_id, account_name FROM accounts WHERE account_name LIKE :searchName");
  $stmnt->execute([':searchName' => $searchName]);

  $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
  if(count($result) > 0){
    foreach ($result as $data) {
      /* Display all of the found accounts */
      echo "<div class='row center-align'>";
        echo "<p>".$data['account_name']."</p>";
        echo "<input type='hidden' id='search_user_id' value='$data[account_id]'/>";
        if(CheckFriendRequestId($data['account_id'], $_POST['search_thisUser'], $container->database) == "false"){
          $arguments = array('userSearches' => $_POST['search_thisUser'], 'searchedUser' => $data['account_id']);
          $functionFill = htmlentities(json_encode($arguments));
          echo "<button type='button' onclick='AddFriend($functionFill)' id='$data[account_id]' class='btn friend-button'>"."Add Friend"."</button>";
          echo "<input type='hidden' class='myId' value='$_POST[search_thisUser]'>";
        }
      echo "</div>";
    }
  }else{
    echo "<p class='center-align'>"."No accounts found."."</p>";
  }
}else{
  echo "<p class='center-align'>Please enter the name of the account you want to search for</p>";
}

/*C*/
function CheckFriendRequestId($searchedId, $nameOfSearcher, $db){
  /* Check if the user searches himself*/
  if($searchedId != $nameOfSearcher){
    /* Check if the user has send a friend request*/
    if(CheckFriendRequests($searchedId, $nameOfSearcher, $db) == "false"){
      if(CheckIfFriends($searchedId, $nameOfSearcher, $db) == "false"){
        return "false";
      }
    }else{
      return "true";
    }
  }else if($searchedId == $nameOfSearcher){
    return "true";
  }
}

function CheckFriendRequests($searchedId, $nameOfSearcher, $db){
  $stmnt = $db->prepare("SELECT current_user_id, other_user_id FROM friend_request WHERE other_user_id = :otherId AND current_user_id = :currentId");
  $stmnt->execute([
    'otherId' => $searchedId,
    'currentId' => $nameOfSearcher
  ]);
  $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
  if(count($result) > 0){
    return "true";
  }else{
    return "false";
  }
}

function CheckIfFriends($searchedId, $nameOfSearcher, $db){
  $stmnt = $db->prepare("SELECT * FROM friends WHERE account_id = :accId AND account_friended = :accFr");
  $stmnt->execute([
    'accId' => $searchedId,
    'accFr' => $nameOfSearcher
  ]);
  $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
  if(count($result) > 0){
    foreach ($result as $data) {
      /* THIS DOES NOT WORK, I AM GOING TO FIX IT - Guylian */
      if($data['accountId'] == $searchedId && $data['account_friended'] == $nameOfSearcher ||
         $data['accountId'] == $nameOfSearcher && $data['account_friended'] == $searchedId){
           return "false";
      }else {
        return "true";
      }
    }
  }else{
    return "false";
  }
}
