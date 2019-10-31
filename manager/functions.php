<?php // -*- mode: php; -*-

function view($name, $params=[]){
  extract($params);
  include "views/{$name}.php";
}

function view_error($error){
  include "views/error.php";
  exit;
}

function el($array, $key, $default=null){
  return isset($array[$key]) ? $array[$key] : $default;
}

function get_csrf_token(){
  return substr(base_convert(bin2hex(openssl_random_pseudo_bytes(40)), 16, 36), 0, 40);
}

function _mkdir($dir){
  mkdir($dir, 0777, true);
  chmod($dir, 0777);
}

function mkdir_if_not_exists($dir){
  if(!file_exists($dir)) _mkdir($dir);
}

function force_delete($dir){
  $files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::CHILD_FIRST
  );

  foreach($files as $file){
    $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
  }

  rmdir($dir);
}

function is_my_env(){
  return in_array($_SERVER['HTTP_HOST'], ['127.0.0.1:60000', 'localhost:60000']);
}

function get_next_port(){
  for($p=60001; $p<=65535; $p++){
    if(!file_exists(ROOT . "/.port-map/{$p}")) return $p;
  }
  return null;
}

function get_sites(){
  $sites = array_map(function($d){
    $root = readlink($d);
    $slug = preg_replace("@^.+/sites/(.*?)$@", '$1', $root);
    $port = intval(preg_replace('@^.+/(\d+)$@', '$1', $d));

    $data = explode("\n", file_get_contents(ROOT . "/.db/{$port}"));

    return [
      "name" => $data[0],
      "description" => implode("\n", array_slice($data, 1)),
      "slug" => $slug,
      "port" => $port,
      "path" => $d
    ];
  }, glob(ROOT . "/.port-map/[0-9]*", GLOB_ONLYDIR));

  usort($sites, function($a,$b){
    return filemtime($b["path"]) - filemtime($a["path"]);
  });

  return $sites;
}
