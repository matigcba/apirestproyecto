<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Guardar un escaneo
$app->post('/apirest/escanear', function (Request $request, Response $response) {

    $idAsignatura = $request->getParam('idAsignatura');
    $seccion = $request->getParam('seccion');
    $asignatura = $request->getParam('asignatura');
    $docente = $request->getParam('docente');
    $correo = $request->getParam('correo');
    $fecha = $request->getParam('fecha');

    $consulta = "INSERT INTO escaneos (idAsignatura, seccion, asignatura, docente, correo, fecha) VALUES
    ('$idAsignatura', '$seccion', '$asignatura', '$docente', '$correo', '$fecha')";
    try {

        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->connect();
        $ejecutar = $db->prepare($consulta);
        $result =  $ejecutar->execute();
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
