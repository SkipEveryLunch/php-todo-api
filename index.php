<?php
  declare(strict_types=1);
  require dirname(__DIR__)."/todo-api/vendor/autoload.php";
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
  header("content-type:application/json; charset:UTF-8");
  $controller = new TaskController;
  $controller->processRequest($method,$id);
?>