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
    echo json_encode($db->getDbInfo());
} catch (exception $e) {
    echo '{}';
}
?>