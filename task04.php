<?php
header('Content-Type: application/json');

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'day10';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

    $type = $_POST['type'];
    $brand = $_POST['brand'];

    $typeRegex = '/^[A-Za-z-]{3,10}$/';
    $brandRegex = '/^[A-Za-z0-9&-]{2,20}$/';

    $typeIsValid = preg_match($typeRegex, $type);
    $brandIsValid = preg_match($brandRegex, $brand);
    $response = array();

    if (!$typeIsValid) {
        $response['typeMessage'] = 'Invalid type.';
    }

    if (!$brandIsValid) {
        $response['brandMessage'] = 'Invalid brand.';
    }

    if ($typeIsValid && $brandIsValid) {
        $stmt = $pdo->prepare("INSERT INTO products (type, brand) VALUES (:type, :brand)");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':brand', $brand);
        $stmt->execute();
        $response['message'] = 'Brand added successfully.';
    } else {
        $response['message'] = 'Brand could not be added.';
    }

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Database connection error.'));
}
?>
