<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];
    $response = array();

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["valid"] = true;
    } else {
        $response["valid"] = false;
        http_response_code(400);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $error = 'Invalid request.';
    $response = array('error' => $error);
    http_response_code(400); 
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
