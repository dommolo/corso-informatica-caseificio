<?php

session_start();

if (!array_key_exists('login', $_SESSION) || $_SESSION['login'] != '1') {
    echo 'Non sei autorizzato!';
    exit(0);
}

require_once 'libs/mysql.php';

function get_lista_caseifici() {
    $conn = get_connection();
    $res = mysqli_query($conn, 'SELECT * FROM Caseificio ORDER BY nome;');
    $caseifici = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $caseifici[] = $row;
    }
    $conn->close();
    return $caseifici;
}

function salva_produzione_giornaliera($data, $caseificio, $latte_raccolto, $latte_utilizzato, $forme_prodotte) {
    $conn = get_connection();
    $stmt = $conn->prepare("INSERT INTO ProduzioneLatte (data, id_caseificio, quantita_latte_raccolta, quantita_latte_usata, forme_prodotte) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data, $caseificio, $latte_raccolto, $latte_utilizzato, $forme_prodotte);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

$data = date("Y-m-d");
$caseifici = get_lista_caseifici();
$output = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $caseificio = $_POST['caseificio'];
    $latte_raccolto = $_POST['latte_raccolto'];
    $latte_utilizzato = $_POST['latte_utilizzato'];
    $forme_prodotte = $_POST['forme_prodotte'];

    salva_produzione_giornaliera($data, $caseificio, $latte_raccolto, $latte_utilizzato, $forme_prodotte);

    $output = 'Produzione giornaliera salvata correttamente!';
}
?><!DOCTYPE html>
    <html lang="it">

    <?php include('parts/head.php'); ?>

    <body>
        <div class="container">
            <h1>Produzione Giornaliera</h1>
            <form method="POST">
                <div>
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data" value="<?php echo $data; ?>" required>
                </div>
                <div>
                    <label for="caseificio">Caseificio:</label>
                    <select id="caseificio" name="caseificio" required>
                        <?php foreach ($caseifici as $caseificio): ?>
                            <option value="<?php echo $caseificio['id_caseificio']; ?>"><?php echo $caseificio['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
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
                    <button type="submit">Invia</button>
                    <p><?php echo $output; ?></p>
                </div>
            </form>
        </div>
    </body>

    </html>