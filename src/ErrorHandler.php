<?php
  class ErrorHandler{
    public static function handleError(
      int $errno,
      string $errstr,
      string $errfile,
      int $errline
    ):void{
      throw new ErrorException($errstr,0,$errno,$errfile,$errline);
    }
    public static function handleException(Throwable $e):void{
      http_response_code(500);
      echo json_encode([
        "code"=>$e->getCode(),
        "message"=>$e->getMessage(), 
        "file"=>$e->getFile(), 
        "line"=>$e->getLine(), 
      ]);
    }
  }
?>