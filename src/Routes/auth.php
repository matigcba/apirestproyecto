<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Login admins
$app->post('/apirest/login', function (Request $request, Response $response) {

    $username = $request->getParam('username');
    $password = $request->getParam('password');
    $consulta = "SELECT * FROM usuarios WHERE username = '$username' and password = '$password'";
    try {

        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $conn = $db->connect();
        $stmt = $conn->prepare($consulta);
        $stmt->execute();
        $result = $stmt->fetchObject();
        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);;
    }
});
