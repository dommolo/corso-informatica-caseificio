<?php

function get_connection() {
    $conn = new mysqli("localhost", "root", "", "caseificio");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

function get_lista_caseifici() {
    $conn = get_connection();
    $res = mysqli_query($conn, 'SELECT * FROM Caseificio ORDER BY nome;');

    $output = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    $conn->close();
    return $output;
}

$caseifici = get_lista_caseifici();


?>

<html>

<head>
    <title>Lista caseifici</title>
    <style>
        table, tr, td, th {
            border: 1px solid red;
        }

        th {
            color: #333;
            background-color: #ddd;
        }

        td, th {
            padding: 10px;
        }
    </style>
</head>

<body>
    <h1>Lista dei caseifici</h1>
    <h2>Presa dal database</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Indirizzo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($caseifici as $x) : ?>
            <tr>
                <td>
                    <?php echo $x['id_caseificio']; ?>
                </td>
                <td>
                    <?php echo $x['nome']; ?>
                </td>
                <td>
                    <?php echo $x['indirizzo']; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>