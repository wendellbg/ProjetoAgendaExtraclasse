<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($_POST as $cadastro) {
        echo $cadastro . '<br>';
    }
}
