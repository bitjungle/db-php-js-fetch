<?php
/**
 * Database live search with Javascript fetch() and a PHP backend
 * 
 * Copyright (C) 2021 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */
require_once 'Database.php';
try {
    $db = new Database('/var/www/db-php-js-fetch-settings.ini');
    if (strlen($_POST['str']) > 0) {
        echo json_encode($db->searchData($_POST['str']));
    } else if (strlen($_GET['str']) > 0) {
        echo '<!DOCTYPE html>
              <html>
              <head><meta charset="UTF-8"><title>search</title></head>
              <body><data id="response" style="font-family: monospace">';
        echo json_encode($db->searchData($_GET['str']));
        echo '</data></body></html>';
    } else {
        echo '{}';
    }
} catch (exception $e) {
    http_response_code(503); // Service Unavailable
    echo '{}';
    exit($e->getMessage());
}
?>
