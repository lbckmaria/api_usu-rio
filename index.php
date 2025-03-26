<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true,true,true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class,function (
    Request   $request,
    Throwable $exception, 
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails                                     
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response ->getBody()->write('{"error": "Recurso não foi encontrado"}');
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->get('/tarefas', function (Request $request, Response $response, array $args) {
    $tarefas = [
        ["id" => 1, "titulo" => "Ler a Documentação do Slim", "concluido" => false],
        ["id" => 3, "titulo" => "Ler a Documentação do composer", "concluido" => true],
        ["id" => 4, "titulo" => "Faer um lanche", "concluido" => true],
        ["id" => 5, "titulo" => "Limpar o quarto", "concluido" => false],
    ];
    $response->getBody()->write(json_enode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/tarefas', function(Request $request, Response $response, array $args){

    return $response->withStatus(201);

});
  
app->delete('/tarefas', function(Request $request, Response $response, array $args){

    return $response->withStatus(204);

});

app->put('/tarefas', function(Request $request, Response $response, array $args){

    return $response->withStatus(201);

});

$app->run();