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

        var_dump($result);

        die();

        return $this->view->render($response, 'chat/chatpage.twig', [
            'roomId' => $args['room_id']
        ]);
    } else {

        $query = "SELECT * FROM chat_participants WHERE account_id = :id";
        $result = ReturnQueryResult($query, $this->database, [
            'id' => $_SESSION['user_key']
        ]);

        return $this->view->render($response, 'chat/chatlist.twig', [
            'rooms' => $result
        ]);
        //return 'list chats that the user is in and give option to create new chats, PETER DESIGN THIS PAGE';
    }

})->setName("chat");

$app->post('/chat-create', function (Request $request, Response $response, $args){
})->setName("chat-create");

$app->get('/chat-retrieve', function (Request $request, Response $response, $args){
    $query = "SELECT * FROM friends WHERE account_id = :id OR account_friended = :id";
    $result = ReturnQueryResult($query, $this->database, ['id' => $_SESSION['user_key']]);
    return $response->withJson(['response' => $result]);
})->setName("chat-retrieve");