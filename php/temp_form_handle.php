<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['PHP_RESPONSE'] = array(
        'status' => 'success',
        'title' => 'success',
        'message' => 'Form submitted successfully!',
        'data' => $_POST
    );

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}