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
          echo "created";
        }else{
          $this->responseMethodNotAllowed("GET,POST");
        }
      }else{
        switch($method){
          case "GET":
            echo json_encode($this->gateway->get($id));
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
      }
    }
    function responseMethodNotAllowed($allowed){
      http_response_code(405);
      header("Allow: $allowed");
    }
  }
?>