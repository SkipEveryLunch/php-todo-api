<?php
  declare(strict_types=1);
  require dirname(__DIR__)."/todo-api/vendor/autoload.php";
  $dotenv=Dotenv\Dotenv::createImmutable(dirname(__DIR__)."/todo-api");
  $dotenv->load();
  set_error_handler("ErrorHandler::handleError");
  set_exception_handler("ErrorHandler::handleException");

  $method = $_SERVER["REQUEST_METHOD"];
  $path =  parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);
  $paths = explode("/",$path);
  $resource = $paths[2];
  $id = $paths[3] ?? null;
  if($resource !== "tasks"){
    http_response_code(404);
    exit;
  }
  $db = new Database($_ENV["DB_HOST"],$_ENV["DB_NAME"],$_ENV["DB_USER"],$_ENV["DB_PASS"]);
  $task_gateway = new TaskGateway($db);
  $controller = new TaskController($task_gateway);
  header("content-type:application/json; charset:UTF-8");
  $controller->processRequest($method,$id);
?>