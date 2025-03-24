<?php


function guard($value = [])
{

    $tipoUsuario = strtolower($_SESSION['tipo_vinculo'] ?? '');

    if (!in_array($tipoUsuario, array_map('strtolower', $value))) {
        echo "<script>window.location.href='/pages/erro';</script>";
        exit; // Interrompe a execução do script após o redirecionamento
    }
}
