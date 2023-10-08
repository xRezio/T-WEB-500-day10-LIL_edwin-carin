<?php

if(isset($_GET['name'])) {
    $name = $_GET['name'];
    $response = array('name' => $name);
    echo json_encode($response);
} else {
    $error = 'Il manque le nom dans la request.';
    $response = array('error' => $error);
    echo json_encode($response);
}
?>
