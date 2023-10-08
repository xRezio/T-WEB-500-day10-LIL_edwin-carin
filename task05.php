<?php
header('Content-Type: application/json');

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'day10';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

    $type = $_GET['type'];
    $brand = $_GET['brand'];
    $price = $_GET['price'];
    $number = $_GET['number'];

    $typeRegex = '/^[A-Za-z-]{3,10}$/';
    $brandRegex = '/^[A-Za-z0-9&-]{2,20}$/';
    $priceRegex = '/^[><]?[0-9]{2,5}$/';
    $numberRegex = '/^[1-9][0-9]*$/';

    $typeIsValid = preg_match($typeRegex, $type);
    $brandIsValid = preg_match($brandRegex, $brand);
    $priceIsValid = preg_match($priceRegex, $price);
    $numberIsValid = preg_match($numberRegex, $number);

    $response = array();

    // Clear the content of the array
    $response['data'] = array();

    if (!$typeIsValid) {
        $response['typeMessage'] = 'Error ($type): ';
        if (strlen($type) < 3) {
            $response['typeMessage'] .= 'this type does not have enough characters.';
        } elseif (strlen($type) > 10) {
            $response['typeMessage'] .= 'this type has too many characters.';
        } elseif (!preg_match('/^[A-Za-z-]*$/', $type)) {
            $response['typeMessage'] .= 'this type has non-alphabetical characters (different from '-').';
        } elseif (!$typeExistsInShop) {
            $response['typeMessage'] .= "this type doesn't exist in our shop.";
        }
    }

    if (!$brandIsValid) {
        $response['brandMessage'] = 'Error ($brand): ';
        if (strlen($brand) < 2) {
            $response['brandMessage'] .= 'this brand does not have enough characters.';
        } elseif (strlen($brand) > 20) {
            $response['brandMessage'] .= 'this brand has too much characters.';
        } elseif (!preg_match('/^[A-Za-z0-9&-]*$/', $brand)) {
            $response['brandMessage'] .= 'this brand has invalid characters.';
        } elseif (!$brandExistsInDatabase) {
            $response['brandMessage'] .= "this brand doesn't exist in our database.";
        }
    }

    if (!$priceIsValid) {
        $response['priceMessage'] = 'Error ($price): ';
        if (strlen($price) < 2) {
            $response['priceMessage'] .= 'this price does not have enough characters.';
        } elseif (strlen($price) > 5) {
            $response['priceMessage'] .= 'this price has too many characters.';
        } elseif (!preg_match('/^[><]?[0-9]{2,5}$/', $price)) {
            $response['priceMessage'] .= 'we cannot define a price - string invalid.';
        } elseif (!$productExistsAtPrice) {
            $response['priceMessage'] .= 'no products found at this price.';
        }
    }

    if (!$numberIsValid) {
        $response['numberMessage'] = 'Error ($number): ';
        if (!is_numeric($number)) {
            $response['numberMessage'] .= 'not a positive number.';
        } elseif ($number <= 0) {
            $response['numberMessage'] .= 'not a positive number.';
        } elseif (!$enoughStockAvailable) {
            $response['numberMessage'] .= "sorry, we don't have enough stock, we only have $stock in stock.";
        }
    }

    if ($typeIsValid && $brandIsValid && $priceIsValid && $numberIsValid) {
        // Perform database operations here
        // Insert the product into the database or perform any other required actions
        $stmt = $pdo->prepare("INSERT INTO products (type, brand, price, stock) VALUES (:type, :brand, :price, :number)");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':number', $number);
        $stmt->execute();

        $response['message'] = 'Product added successfully.';
    } else {
        $response['message'] = 'Product could not be added.';
    }

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Database connection error.'));
}
?>
