<?php
require_once("vendor/autoloader.php");
// include("db.php");
// include("settings.php");
// use yusovmax\database;
$db = new \yusovmax\database();
header("Content-Type: application/json; charset=UTF-8");
echo(json_encode($db->addCheck($_POST), JSON_UNESCAPED_UNICODE));