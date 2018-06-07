<?php

use Slim\Http\{
    Request, Response
};

$app->group('/search', function () {
    $this->get('[/]', function (Request $request, Response $response, $args) {
        return $this->view->render($response, 'search.twig');
    })->setName('search');

    $this->post('[/]', function (Request $request, Response $response, $args) {


    });
});

/* Check if the POST variable is set and isn't empty */
/*if (isset($_POST['search-username']) && $_POST['search-username'] != "") {
    /* Create a variable that acts as the search arguments *
    $searchName = "%" . $_POST['search-username'] . "%";

    /* Preset the query arguments *
    $queryArguments = array(':searchName' => $searchName);
    /* Search for the $searchName contents in the database *
    $result = ReturnQueryResult("SELECT account_id, account_name FROM accounts
                                        WHERE account_name LIKE :searchName", $container->database, $queryArguments);
    if (count($result) > 0) {
        foreach ($result as $data) {
            /* Display all of the found accounts *
            echo "<div class='row center-align'>";
            echo "<p>" . $data['account_name'] . "</p>";
            echo "<input type='hidden' id='search_user_id' value='$data[account_id]'/>";
            if (CheckFriendRequestId($data['account_id'], $_POST['search_thisUser'], $searchName, $container->database) == "false") {
                $arguments = array('userSearches' => $_POST['search_thisUser'], 'searchedUser' => $data['account_id']);
                $functionFill = htmlentities(json_encode($arguments));
                echo "<button type='button' onclick='AddFriend($functionFill)' id='$data[account_id]' class='btn friend-button'>" . "Add Friend" . "</button>";
                echo "<input type='hidden' class='myId' value='$_POST[search_thisUser]'>";
            }
            echo "</div>";
        }
    } else {
        echo "<p class='center-align'>" . "No accounts found." . "</p>";
    }
} else {
    echo "<p class='center-align'>Please enter the name of the account you want to search for</p>";
}*/

/*C*/
function CheckFriendRequestId($searchedId, $idOfSearcher, $nameOfSearcher, $db)
{
    /* Check if the user searches himself*/
    if ($searchedId != $idOfSearcher) {
        /* Check if the user has send a friend request*/
        if (CheckFriendRequests($searchedId, $idOfSearcher, $nameOfSearcher, $db) == "false") {
            if (CheckIfFriends($searchedId, $idOfSearcher, $db) == "false") {
                return "false";
            }
        } else {
            return "true";
        }
    } else if ($searchedId == $idOfSearcher) {
        return "true";
    }
}

function CheckFriendRequests($searchedId, $idOfSearcher, $nameOfSearcher, $db)
{
    $queryArguments = array(
        'otherId' => $searchedId,
        'currentId' => $idOfSearcher
    );
    $result = ReturnQueryResult("SELECT current_user_id, other_user_id FROM friend_request
                                        WHERE other_user_id = :otherId AND current_user_id = :currentId", $db, $queryArguments);
    if (count($result) > 0) {
        return "true";
    } else {
        return "false";
    }
}


