<?php
header('Content-Type: application/json');

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'day10';
 // je n'ai pas fait les messages d'erreur .....
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

    if (isset($_GET['search']) && $_GET['search'] === 'true') {
        $sql = "SELECT * FROM products WHERE 1";

        if (isset($_GET['type']) && $_GET['type'] !== '') {
            $sql .= " AND type = :type";
        }

        if (isset($_GET['brand']) && $_GET['brand'] !== '') {
            $sql .= " AND brand = :brand";
        }

        if (isset($_GET['price']) && $_GET['price'] !== '') {
            $sql .= " AND price = :price";
        }

        if (isset($_GET['number']) && $_GET['number'] !== '') {
            $sql .= " AND stock >= :number";
        }

        $stmt = $pdo->prepare($sql);

        if (isset($_GET['type']) && $_GET['type'] !== '') {
            $stmt->bindParam(':type', $_GET['type']);
        }

        if (isset($_GET['brand']) && $_GET['brand'] !== '') {
            $stmt->bindParam(':brand', $_GET['brand']);
        }

        if (isset($_GET['price']) && $_GET['price'] !== '') {
            $stmt->bindParam(':price', $_GET['price']);
        }

        if (isset($_GET['number']) && $_GET['number'] !== '') {
            $stmt->bindParam(':number', $_GET['number']);
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = array('products' => $results);
        echo json_encode($response);
        exit;
    }
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Erreur de connexion à la db.'));
}
?>
