<?php


if (!defined('HOST')) define('HOST', 'localhost');
if (!defined('USER')) define('USER', 'root');
if (!defined('PASS')) define('PASS', '');
if (!defined('BASE')) define('BASE', 'extra_classe');

$conn = new mysqli(HOST, USER, PASS, BASE);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
$conn->set_charset("utf8");
