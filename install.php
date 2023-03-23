<?php
include("db.php");
include("settings.php");
use yusovmax\database;

$db = new database($host, $dbname, $username, $password);
//var_dump($db);
$tables = [
  "category" => "mycache_category",
  "check" => "mycache_check"
];

if ($db->CheckTable($tables["category"])) {
    echo ("В базе данных уже имеется таблица: ".$tables["category"]);
} else {
    $fields = "
    `category_id` INT NOT NULL AUTO_INCREMENT ,
    `category_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
    `ru_name` VARCHAR(222) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
    PRIMARY KEY (`category_id`),
    UNIQUE `name` (`category_name`),
    INDEX `ru_name` (`ru_name`)
    ";
    var_dump($db->CreateTable($tables["category"], $fields));
}
echo("<br>");
if ($db->CheckTable($tables["check"])) {
    echo ("В базе данных уже имеется таблица: ".$tables["check"]);
} else {
    $fields = 
    "`check_id` INT NOT NULL AUTO_INCREMENT ,
    `product_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
    `category_id` INT NOT NULL ,
    `sum` DECIMAL(10,2) NOT NULL ,
    `date` DATE NOT NULL ,
    PRIMARY KEY (`check_id`),
    INDEX `product_name` (`product_name`)";
    var_dump($db->CreateTable($tables["check"], $fields));
}
