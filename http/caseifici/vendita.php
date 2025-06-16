<?php

require_once 'libs/mysql.php';

function salva_vendita($data, $latte_raccolto, $latte_utilizzato, $forme_prodotte) {
    $conn = get_connection();
    
    $stmt = $conn->prepare("INSERT INTO ProduzioneLatte (data, quantita_latte_raccolta, quantita_latte_usata, forme_prodotte) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $data, $latte_raccolto, $latte_utilizzato, $forme_prodotte);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

$data = date("Y-m-d");
$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $latte_raccolto = $_POST['latte_raccolto'];
    $latte_utilizzato = $_POST['latte_utilizzato'];
    $forme_prodotte = $_POST['forme_prodotte'];
    $forme_vendute = $_POST['forme_vendute'];

    salva_vendita($data, $latte_raccolto, $latte_utilizzato, $forme_prodotte, $forme_vendute);

    $output = 'Produzione giornaliera salvata correttamente!';
}
?><DOCTYPE html>
    <html lang="it">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Produzione Giornaliera</title>
        <link rel="stylesheet" href="css/main.css">
    </head>

    <body>
        <div class="container">
            <h1>Produzione Giornaliera</h1>
            <form action="produzione_giornaliera.php" method="POST">
                <div>
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data" value="<?php echo $data; ?>" required>
                </div>
                <div>
                    <label for="latte_raccolto">Litri di latte raccolto:</label>
                    <input type="number" id="latte_raccolto" name="latte_raccolto" required>
                </div>
                <div>
                    <label for="latte_utilizzato">Litri di latte utilizzato:</label>
                    <input type="number" id="latte_utilizzato" name="latte_utilizzato" required>
                </div>
                <div>
                    <label for="forme_prodotte">Forme prodotte:</label>
                    <input type="number" id="forme_prodotte" name="forme_prodotte" required>
                </div>
                <div>
                    <label for="forme_vendute">Forme vendute:</label>
                    <input type="number" id="forme_vendute" name="forme_vendute" required>
                </div>
                <div>
                    <button type="submit">Invia</button>
                    <p><?php echo $output; ?></p>
                </div>
            </form>
        </div>
    </body>

    </html>