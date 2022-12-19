<?php

$pdo = new PDO('mysql:host=localhost;dbname=projet_hotel', 'root', '',
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// var_dump($pdo);

$content = '';

session_start();

define('URL', 'http://localhost/projet_hotel/');

define('RACINE', $_SERVER['DOCUMENT_ROOT'] . '/projet_hotel/');