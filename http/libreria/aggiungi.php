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

function salva_libro($codice, $titolo, $autore, $casaEditrice, $ISBN, $genere, $immagine)
{
    $conn = get_connection();
    $stmt = $conn->prepare("INSERT INTO libri (codice, titolo, autore, casa_editrice, isbn, genere, immagine) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $codice, $titolo, $autore, $casaEditrice, $ISBN, $genere, $immagine);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}


$output = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codice = $_POST['codice'];
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $casaEditrice = $_POST['casa_editrice'];
    $ISBN = $_POST['isbn'];
    $genere = $_POST['genere'];
    $immagine = $_POST['immagine'];

    salva_libro($codice, $titolo, $autore, $casaEditrice, $ISBN, $genere, $immagine);

    $output = 'Libro salvato correttamente!';
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Libreria - Aggiungi libro</title>
    <link rel="stylesheet" href="/libreria/stile.css" />
</head>

<body>
    <div class="menu">
        <a href="/libreria/admin.php">Lista libri</a>
        -
        <a href="/libreria/logout.php">Esci</a>
    </div>
    <h1>Aggiungi un nuovo libro</h1>

    <form method="POST">
        <div>
            <label for="codice">Codice interno:</label>
            <input type="text" id="codice" name="codice" required>
        </div>
        <div>
            <label for="titolo">Titolo:</label>
            <input type="text" id="titolo" name="titolo" required>
        </div>
        <div>
            <label for="autore">Autore:</label>
            <input type="text" id="autore" name="autore" required>
        </div>
        <div>
            <label for="casa_editrice">Casa editrice:</label>
            <input type="text" id="casa_editrice" name="casa_editrice" required>
        </div>
        <div>
            <label for="isbn">Codice ISBN:</label>
            <input type="text" id="isbn" name="isbn" required>
        </div>
        <div>
            <label for="genere">Genere:</label>
            <input type="text" id="genere" name="genere" required>
        </div>
        <div>
            <label for="immagine">URL immagine copertina:</label>
            <input type="text" id="immagine" name="immagine" required>
        </div>
        <div>
            <button type="submit">Salva</button>
            <p><?php echo $output; ?></p>
        </div>
    </form>
</body>

</html>