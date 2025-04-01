<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'extra_classe');

$conn = new mysqli(HOST, USER, PASS, BASE);


if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Definir charset (opcional, mas recomendado)
$conn->set_charset("utf8");

echo "Conexão bem-sucedida!";