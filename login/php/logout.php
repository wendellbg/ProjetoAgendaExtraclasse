<?php
session_start();
if ($_SESSION) {
    unset($_SESSION['tipo_vinculo']);
    unset($_SESSION['matricula']);
    session_destroy();
    header("location: /");
    exit;
}
