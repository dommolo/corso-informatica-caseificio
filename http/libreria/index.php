<?php

function get_connection() {
    $conn = new mysqli("localhost", "root", "", "libreria");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

function get_lista_libri() {
    $conn = get_connection();
    $res = mysqli_query($conn, 'SELECT * FROM libri ORDER BY genere;');

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
    <title>Libreria - Home</title>
    <link rel="stylesheet" href="/libreria/stile.css" />
</head>

<body>
    <div class="menu">
        <a href="/libreria/login.php">Login</a>
    </div>
    <h1>Gestione dei libri presenti</h1>


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
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>