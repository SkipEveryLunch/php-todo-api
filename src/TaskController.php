<?php
  class TaskController{
    public function processRequest(string $method,?string $id):void{
      if($id == null){
        if($method==="GET"){
          echo "index";
        }elseif($method==="POST"){
          echo "created";
        }else{
          $this->responseMethodNotAllowed("GET,POST");
        }
      }else{
        switch($method){
          case "GET":
            echo "show $id";
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