<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use MariaLembeck\Service\TarefasService;
use MariaLembeck\Math\Basic;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
//  middleware é um evento que ocorre antes da requisição chegar na rota
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDatails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "Recurso não foi encontrado"}');
    return $response->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
});

$app->get("/math/soma/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->soma($args['num1'], $args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/subtrai/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->subtrai($args['num1'], $args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/multiplica/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->multiplica($args['num1'], $args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/divide/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->divide($args['num1'], $args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/eleva/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->eleva($args['num1'], $args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});


$app->get("/math/raiz/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->raiz($args['num1'], $args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

 $app->get('/tarefas', function (Request $request, Response $response, array $args) {
    $tarefa_service = new TarefasService();
    $tarefas =  $tarefa_service->getAllTarefas();
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
}); 


 
$app->post('/tarefas', function(Request $request, Response $response, array $args){
    $parametros = (array) $request->getParsedBody();
    if(!array_key_exists('titulo', $parametros) || empty($parametros['titulo'])){
    $response->getBody()->write(json_encode([
        "mensagem" => "titulo é obrigatório"
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    $tarefa = array_merge(['titulo' => '', 'concluido' => false], $parametros);
    $tarefa_service = new TarefaService();
    $tarefa_service->createTarefa($tarefa);
    $tarefa_service->withStatus(201);
});

$app->delete('/tarefas/{id}', function(Request $requets, Response $response, array $args) {
    $id = $args['id'];
    $tarefa_service = new TarefasService();
    $tarefa_services->deleteTarefa($id);
    return $response->withStatus(204);
});

$app->put('/tarefas/{id}', function(Request $requets, Response $response, array $args) {
  $id = $args['id'];
  $dados_para_atualizar = json_decode($request->getBody()->getContents(), true);
  if (array_key_exists('titutlo', $dados_para_atualizar) && empty($dados_para_atualizar['titulo'])){
    $response->getBody()->write(json_encode([
        "mensagem" => "título é obrigatório"
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
  }
  $tarefa_service = new TarefaService();
  $tarefa_service->updateTarefa($id,$dados_para_atualizar);
  return $response->withStatus(201);

});


$app->run();