<?php

function get_connection() {
    // Create a new MySQLi connection
    $conn = new mysqli("localhost", "root", "", "caseificio");
    
    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}