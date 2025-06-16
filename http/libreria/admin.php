<?php

session_start();

if (!array_key_exists('login_libreria', $_SESSION) || $_SESSION['login_libreria'] != '1') {
    echo 'Non sei autorizzato!';
    exit(0);
}

function get_connection() {
    $conn = new mysqli("localhost", "root", "", "libreria");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

function get_lista_libri() {
    $conn = get_connection();
    $res = mysqli_query($conn, 'SELECT * FROM libri ORDER BY titolo;');

    $output = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    $conn->close();
    return $output;
}

$libri = get_lista_libri();


?>

<html>

<head>
    <title>Libreria - Amminisrazione</title>
    <link rel="stylesheet" href="/libreria/stile.css" />
</head>

<body>
    <div class="menu">
        <a href="/libreria/aggiungi.php">Aggiungi libro</a>
        -
        <a href="/libreria/logout.php">Esci</a>
    </div>
    <h1>Lista dei libri presenti</h1>

    <table>
        <thead>
            <tr>
                <th>Codice</th>
                <th>Titolo</th>
                <th>Autore</th>
                <th>Casa editrice</th>
                <th>ISBN</th>
                <th>Genere</th>
                <th>Immagine di copertina</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libri as $x) : ?>
            <tr>
                <td>
                    <?php echo $x['codice']; ?>
                </td>
                <td>
                    <?php echo $x['titolo']; ?>
                </td>
                <td>
                    <?php echo $x['autore']; ?>
                </td>
                <td>
                    <?php echo $x['casa_editrice']; ?>
                </td>
                <td>
                    <?php echo $x['isbn']; ?>
                </td>
                <td>
                    <?php echo $x['genere']; ?>
                </td>
                <td>
                    <img class="copertina" src="<?php echo $x['immagine']; ?>" />
                </td>
                <td>
                    <a href="/libreria/modifica.php?id=<?php echo $x['id_libro']; ?>">Modifica</a>
                    <a href="/libreria/elimina.php?id=<?php echo $x['id_libro']; ?>" onclick="return confirm('Sei sicuro?');">Elimina</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>