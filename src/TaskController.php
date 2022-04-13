<?php
  class TaskController{
    private TaskGateway $gateway;
    public function __construct(TaskGateway $gateway){
      $this->gateway = $gateway;
    }
    public function processRequest(string $method,?string $id):void{
      if($id == null){
        if($method==="GET"){
          echo json_encode($this->gateway->getAll());
        }elseif($method==="POST"){
          $data = (array)json_decode(file_get_contents("php://input"),true);
          $id = $this->gateway->create($data);
          $this->responseCreated($id);
        }else{
          $this->responseMethodNotAllowed("GET,POST");
        }
      }else{
        $task = $this->gateway->get($id);
        if($task!==false){
          switch($method){
            case "GET":
              echo json_encode($task);
              break;
            case "PATCH":
              echo "edit $id";
              break;
            case "DELETE":
              echo "delete $id";
              break;
            default:
              $this->responseMethodNotAllowed("GET,PATCH,POST");
        }
      }else{
        $this->responseNotFound($id);
        return;
      }
    }
  }
  function responseMethodNotAllowed($allowed){
    http_response_code(405);
    header("Allow: $allowed");
  }
  function responseNotFound(string $id){
    http_response_code(404);
    echo json_encode([
      "message" => "Task with id $id cannot be found."
    ]);
  }
  function responseCreated(string $id):void{
    http_response_code(201);
    echo json_encode([
      "message" => "Task with id $id is successfully created."
    ]);
  }
}
?>