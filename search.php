<?php
/**
 * Database live search with Javascript fetch() and a PHP backend
 * 
 * Copyright (C) 2021 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */
require_once('DB.php');
try {
    $db = new DB();
    if (strlen($_POST['str']) > 0) {
        echo json_encode($db->searchData($_POST['str']));
    } else {
        echo '{}';
    }
} catch (exception $e) {
    http_response_code(503); // Service Unavailable
    echo '{}';
    exit($e->getMessage());
}
?>