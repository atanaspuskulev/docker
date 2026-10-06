<?php

try {
    $l = new \PDO("mysql:host=mariadb;dbname=test", "db", "secret");
} catch(\PDOException $e) {
    die("Error: " . $e->getMessage());
}

echo "Connection ready!";
