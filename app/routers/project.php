<?php
use Slim\Http\{
    Request, Response
};

$app->group('/project', function () {
    $this->post('/create', function (Request $request, Response $response, $args){
        if(isset($_POST['project_title']) && isset($_POST['project_link'])){
            $query = "INSERT INTO projects (project_id, project_name, project_link, project_creator)
                      VALUES(:id, :project_name, :link, :creator)";
            $id = "project_".time();
            $queryArgs = [
                    'id' => $id,
                    'project_name' => $_POST['project_title'],
                    'link' => $_POST['project_link'],
                    'creator' => $_POST['user_id']
            ];
            ExecuteQuery($query, $this->database, $queryArgs);
            return $response->withJson(['response' => 'success']);
        }
    })->setname('project-create');

    $this->post('/retrieve', function (Request $request, Response $response, $args){
        $query = "SELECT * FROM projects";
        $result = ReturnQueryResult($query, $this->database);
        $data = ['data' => $result];
        return $response->withJson($data);
    })->setname('project-retrieve');

    $this->post('/delete', function (Request $request, Response $response, $args){
        $user = $_POST['creator'];
        $project = $_POST['project'];

        $query = 'SELECT * FROM projects WHERE project_id = :id AND project_creator = :user';
        $queryArgs = ['id' => $project, 'user' => $user];
        $result = ReturnQueryResult($query, $this->database, $queryArgs);

        if(count($result) > 0){
            $query = 'DELETE FROM projects WHERE project_id = :id AND project_creator = :user';
            $result = ReturnQueryResult($query, $this->database, $queryArgs);

            return $response->withJson(['response' => 'success']);
        }else{
            return $response->withJson(['response' => 'fail']);
        }
    })->setname('project-delete');
});