<?php
if (!function_exists('ReturnQueryResult')) {
    /* Function that executes a sql query and returns the result */
    function ReturnQueryResult($query, $dbObject, $arguments = [])
    {
        $stmnt = $dbObject->prepare($query);
        $stmnt->execute($arguments);
        return $stmnt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('ExecuteQuery')) {
    /* Function that executes a sql query and doesn't return the result */
    function ExecuteQuery($query, $dbObject, $arguments = [])
    {
        $stmnt = $dbObject->prepare($query);
        $stmnt->execute($arguments);
    }
}

if (!function_exists('CheckIfFriends')) {

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

if (!function_exists('getMailer')) {
    function getMailer()
    {
        $c = $GLOBALS['config'];

        $mailer = new \PHPMailer\PHPMailer\PHPMailer();

        $mailer->IsSMTP();
        $mailer->Host       = $c['mail']['host'];

        $mailer->SMTPSecure = $c['mail']['protocol'];
        $mailer->Port       = $c['mail']['port'];
        $mailer->SMTPDebug  = 0;
        $mailer->SMTPAuth   = true;

        $mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mailer->Username   = $c['mail']['username'];
        $mailer->Password   = $c['mail']['pass'];

        $mailer->SetFrom($c['mail']['username'], 'The IT Connection');
        $mailer->Hostname = $c['mail']['hostname'];

        return $mailer;
    }
}