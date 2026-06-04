<?php

session_start();

require 'db.php';

$pdo = connectDB();


$tableTypes =
    $pdo
        ->query("
            SELECT *
            FROM table_types
            ORDER BY name
        ")
        ->fetchAll();

$messages = [];

include
    'templates/reservation_form.php';
