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
        echo "<button type='button' onclick='AddFriendButton()' class='btn'>"."Add Friend"."</button>";
        echo "<input type='hidden' id='myId' value='$_POST[search_thisUser]'>";
      echo "</div>";
    }
  }else{
    echo "<p class='center-align'>"."No accounts found."."</p>";
  }
}else{
  echo "<p class='center-align'>Please enter the name of the account you want to search for</p>";
}
