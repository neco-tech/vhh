<?php

require_once "functions.php";

session_start();
if(!el($_SESSION, "token")) $_SESSION["token"] = get_csrf_token();

define("ROOT", realpath(dirname(__DIR__)));

set_error_handler(
  function ($errno, $errstr, $errfile, $errline) {
    // エラーが発生した場合、ErrorExceptionを発生させる
    throw new ErrorException(
      $errstr, 0, $errno, $errfile, $errline
    );
  }
);
