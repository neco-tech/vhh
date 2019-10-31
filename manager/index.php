<?php

require_once "initialize.php";

switch($_SERVER["REQUEST_METHOD"]){
case "GET":
  try{
    mkdir_if_not_exists(ROOT . "/.db");
    mkdir_if_not_exists(ROOT . "/.port-map");
    mkdir_if_not_exists(ROOT . "/logs");
    mkdir_if_not_exists(ROOT . "/sites");
  }catch(Exception $e){
    view_error(ROOT . "/に書き込み権限がありません。");
  }

  view("index");
  break;

case "POST":
  if(el($_POST, "token") !== el($_SESSION, "token") || !is_my_env()){
    view_error("Invalid request");
  }

  switch(el($_POST, "action")){
  case "add":
    $name = el($_POST, "name", "");
    $slug = el($_POST, "slug", "");
    $port = el($_POST, "port", "");
    $description = el($_POST, "description", "");

    if($name == "" || $slug == "" || $port == ""){
      view_error("入力項目に不備があります。");
    }

    if(file_exists(ROOT . "/sites/{$slug}")){
      view_error("そのディレクトリ名は既に使用されています。");
    }

    if($port < 60001 || 65535 < $port){
      view_error("ポート番号は60001〜65535で指定してください。");
    }

    if(file_exists(ROOT . "/.port-map/{$port}")){
      view_error("そのポートは既に使用されています。");
    }

    _mkdir(ROOT . "/sites/{$slug}");
    file_put_contents(ROOT . "/.db/{$port}", "{$name}\n{$description}");
    symlink(ROOT . "/sites/{$slug}", ROOT . "/.port-map/{$port}");
    break;

  case "delete":
    $port = el($_POST, "port");
    if($port < 60001 || 65535 < $port){
      view_error("ポート番号は60001〜65535で指定してください。");
    }

    $symlink = ROOT . "/.port-map/{$port}";
    $site = readlink($symlink);

    unlink($symlink);
    unlink(ROOT . "/.db/{$port}");
    if(preg_match("@".ROOT."/sites/[^\\/]+@", $site)){
      force_delete($site);
    }

    break;
  }

  echo "<script>location.href = './';</script>";
}
