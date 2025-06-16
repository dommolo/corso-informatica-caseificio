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

function aggiorna_libro($id, $codice, $titolo, $autore, $casaEditrice, $ISBN, $genere, $immagine)
{
    $conn = get_connection();
    $stmt = $conn->prepare("UPDATE libri SET codice = ?, titolo = ?, autore = ?, casa_editrice = ?, isbn = ?, genere = ?, immagine = ? WHERE id_libro = ?;");
    $stmt->bind_param("ssssssss", $codice, $titolo, $autore, $casaEditrice, $ISBN, $genere, $immagine, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function cerca_libro($id) {
    $conn = get_connection();
    $res = mysqli_query($conn, "SELECT * FROM libri WHERE id_libro = $id;");

    if (mysqli_num_rows($res) == 0) {
        print('Libro non esistente!');
        exit(0);
    }

    $output = mysqli_fetch_assoc($res);

    $conn->close();
    return $output;
}

$output = '';
$id = intval($_GET['id']);
$libro = cerca_libro($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codice = $_POST['codice'];
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $casaEditrice = $_POST['casa_editrice'];
    $ISBN = $_POST['isbn'];
    $genere = $_POST['genere'];
    $immagine = $_POST['immagine'];

    aggiorna_libro($id, $codice, $titolo, $autore, $casaEditrice, $ISBN, $genere, $immagine);

    $output = 'Libro aggiornato correttamente!';
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Libreria - Aggiorna libro</title>
    <link rel="stylesheet" href="/libreria/stile.css" />
</head>

<body>
    <div class="menu">
        <a href="/libreria/admin.php">Lista libri</a>
        -
        <a href="/libreria/logout.php">Esci</a>
    </div>
    <h1>Modifica libro <i><?php echo $libro['titolo']; ?><i></h1>

    <form method="POST">
        <div>
            <label for="codice">Codice interno:</label>
            <input type="text" id="codice" name="codice" value="<?php echo $libro['codice']; ?>" required>
        </div>
        <div>
            <label for="titolo">Titolo:</label>
            <input type="text" id="titolo" name="titolo" value="<?php echo $libro['titolo']; ?>" required>
        </div>
        <div>
            <label for="autore">Autore:</label>
            <input type="text" id="autore" name="autore" value="<?php echo $libro['autore']; ?>" required>
        </div>
        <div>
            <label for="casa_editrice">Casa editrice:</label>
            <input type="text" id="casa_editrice" name="casa_editrice" value="<?php echo $libro['casa_editrice']; ?>" required>
        </div>
        <div>
            <label for="isbn">Codice ISBN:</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo $libro['isbn']; ?>" required>
        </div>
        <div>
            <label for="genere">Genere:</label>
            <input type="text" id="genere" name="genere" value="<?php echo $libro['genere']; ?>" required>
        </div>
        <div>
            <label for="immagine">URL immagine copertina:</label>
            <input type="text" id="immagine" name="immagine" value="<?php echo $libro['immagine']; ?>" required>
        </div>
        <div>
            <button type="submit">Salva</button>
            <p><?php echo $output; ?></p>
        </div>
    </form>
</body>

</html>