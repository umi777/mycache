<?php

function my_autoloader($class)
{
  // $class = strtolower(str_replace('\\', '/', $class));
  if ($class == "yusovmax\databaseSettings") {
    include 'settings.php';
  }
  if ($class == "yusovmax\database") {
    include 'db.php';
  }
}

spl_autoload_register('my_autoloader');
