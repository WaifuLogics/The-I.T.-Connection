<?php

use Slim\Http\{
    Request, Response
};

$app->get('/', function (Request $request, Response $response, $args) {
    if (isset($_SESSION['user_name']) && isset($_SESSION['user_key'])) {
        return $this->view->render($response, 'homepage.twig');
    } else {
        return $this->view->render($response, 'home.twig');
    }

})->setName('home');

$app->get('/logout', function ($request, $response, $args) {
    unset($_SESSION['user_name']);
    unset($_SESSION['user_key']);
    return $response->withRedirect($this->router->pathFor('home'));
})->setName('logout');

$app->get('/thanks/{message}', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'thanks.twig', ['message' => $args['message']]
    );
})->setName('thanks');

$app->get('/error', function (Request $request, Response $response, $args) {
    return $this->view->render($response->withStatus(200), 'error.twig');
})->setName('error');

$app->get('/account', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'account.twig');
})->setName('account');

$app->get('/projects', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'projectpage.twig');
})->setName('projects');

$app->get('/js/global.js', function (Request $request, Response $response, $args) {
    return $this->view->render(
        $response->withHeader('Content-type', 'application/javascript'), 'js/global.js');
});

/* --- Functions --- */
function checkLoginStatus(Response $request)
{
    global $app;
    if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_key'])) {
        return $request->withRedirect($app->getContainer()->router->pathFor('home'));
    } else return false;
}

