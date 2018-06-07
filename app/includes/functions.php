<?php
if(!function_exists('ReturnQueryResult')) {
    /* Function that executes a sql query and returns the result */
    function ReturnQueryResult($query, $dbObject, $arguments = [])
    {
        $stmnt = $dbObject->prepare($query);
        $stmnt->execute($arguments);
        return $stmnt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if(!function_exists('ExecuteQuery')) {
    /* Function that executes a sql query and doesn't return the result */
    function ExecuteQuery($query, $dbObject, $arguments = [])
    {
        $stmnt = $dbObject->prepare($query);
        $stmnt->execute($arguments);
    }
}

if(!function_exists('CheckIfFriends')) {

    function CheckIfFriends($searchedId, $idOfSearcher, $db)
    {

        $queryArguments = array(
            'accId' => $searchedId,
            'accFr' => $idOfSearcher
        );
        $result = ReturnQueryResult("SELECT * FROM friends WHERE account_id = :accId AND
                                        account_friended = :accFr", $db, $queryArguments);
        return count($result) > 0;
    }
}