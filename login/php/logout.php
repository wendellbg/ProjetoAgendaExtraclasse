<?php
session_start();
unset($_SESSION['tipo_vinculo']);
session_destroy();
header("location: /");
exit;
