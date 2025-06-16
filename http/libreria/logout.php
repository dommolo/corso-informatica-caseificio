<?php

session_start();

$_SESSION['login_libreria'] = '0';

header('Location: /libreria/index.php');