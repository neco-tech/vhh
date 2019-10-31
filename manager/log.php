<?php

require_once "initialize.php";

$port = intval(el($_GET, "p"));
$path1 = ROOT . "/logs/{$port}_access.log";
$path2 = ROOT . "/logs/{$port}_error.log";

if(!file_exists($path1) || !file_exists($path2)){
  exit;
}

try{
  $access_log = file_get_contents($path1);
  $error_log = file_get_contents($path2);
  view("log", ["access_log" => $access_log, "error_log" => $error_log]);
}catch(Throwable $e){
  view_error("ログファイルの読み込みに失敗しました。閲覧権限を確認してください。");
}
