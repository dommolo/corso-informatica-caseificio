<?php

session_start();

if (!array_key_exists('login_libreria', $_SESSION) || $_SESSION['login_libreria'] != '1') {
    echo 'Non sei autorizzato!';
    exit(0);
}

function get_connection()
{
    $conn = new mysqli("localhost", "root", "", "libreria");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

$id = intval($_GET['id']);

$conn = get_connection();
mysqli_query($conn, "DELETE FROM libri WHERE id_libro = $id;");

header('Location: /libreria/admin.php');