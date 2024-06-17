<?php

namespace Config;

use Exception;
use SQLite3;

try {
    $db = new SQLite3('task3.db');

    $db->exec('
    CREATE TABLE IF NOT EXISTS user (
        username TEXT PRIMARY KEY,
        password TEXT NOT NULL,
        count INT default 0)
    ');

} catch (Exception $e) {
    echo "Error initializing database: " . $e->getMessage();
} finally {
    if (isset($db)) {
        $db->close();
    }
}