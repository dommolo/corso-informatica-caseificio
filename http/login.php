<?php

session_start();

function check_password($username, $password) {
    return $username == 'martina' && $password == 'giuseppe';
}

$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $ok = check_password($username, $password);

    if ($ok) {
        $output = 'Credenziali corrette';
        $_SESSION['login'] = '1';

        header('Location: /produzione.php');
        exit(0);
    } else {
        $output = 'Password sbagliata';
        $_SESSION['login'] = '0';
    }
}
?><!DOCTYPE html>
    <html lang="it">

    <?php include('parts/head.php'); ?>

    <body>
        <div class="container">
            <h1>Login</h1>
            <form method="POST">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <button type="submit">Entra</button>
                    <p><?php echo $output; ?></p>
                </div>
            </form>
        </div>
    </body>

    </html>