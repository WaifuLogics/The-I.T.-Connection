<?php
use Slim\Http\{
    Request, Response
};

// route: /chat[/{room_id}]
$app->get('/chat[/{room_id}]', function (Request $request, Response $response, $args) {

    if (checkLoginStatus($response)) {
        return checkLoginStatus($response);
    }

    if (isset($args['room_id']) && !empty($args['room_id'])) {

        $query = "SELECT * FROM chat_participants WHERE chat_room_id = :roomId AND account_id = :accountId";
        $result = ReturnQueryResult($query, $this->database, [
            'roomId' => $args['room_id'],
            'accountId' => $_SESSION['user_key']
        ]);

        if(count($result) < 1) {
            return $response->withRedirect($this->router->pathFor("chat"));
        }

        return $this->view->render($response, 'chat/chatpage.twig', [
            'roomId' => $args['room_id']
        ]);
    } else {

        $rooms = [];

        $query = "SELECT * FROM chat_participants WHERE account_id = :id";
        $result = ReturnQueryResult($query, $this->database, [
            'id' => $_SESSION['user_key']
        ]);

        var_dump($rooms);

        foreach ($result as $res) {
            $rooms[$res['chat_room_id']]['users'][] = $res['account_id'];
        }

        die();

        return $this->view->render($response, 'chat/chatlist.twig', [
            'rooms' => $result
        ]);
        //return 'list chats that the user is in and give option to create new chats, PETER DESIGN THIS PAGE';
    }

})->setName("chat");

$app->post('/chat-create', function (Request $request, Response $response, $args){
    if(isset($_POST['users'])){
        /* Decode the json object back to a php asociative array (hence the true) */
        $users = json_decode(base64_decode($_POST['users']), true);
        $roomId = "chat_".time();
        foreach($users['users'] as $user){
            /* Insert every user into the chat_participants table */
            $query = "INSERT INTO chat_participants (account_id, chat_room_id, chat_room_name)
                      VALUES(:userId, :roomId, :roomName)";
            $queryArgs = [
                'userId' => $user,
                'roomId' => $roomId,
                'roomName' => $_POST['roomName']
            ];
            ExecuteQuery($query, $this->database, $queryArgs);
        }
        return $response->withJson(['response' => 'success']);
    }else{
        return $response->withJson(['response' => "access denied"]);
    }
})->setName("chat-create");

$app->get('/chat-retrieve', function (Request $request, Response $response, $args){
    $query = "SELECT * FROM friends WHERE account_id = :id OR account_friended = :id";
    $result = ReturnQueryResult($query, $this->database, ['id' => $_SESSION['user_key']]);
    return $response->withJson(['response' => $result]);
})->setName("chat-retrieve");