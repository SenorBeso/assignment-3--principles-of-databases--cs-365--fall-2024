<?php
const DBNAME = "student_passwords";
const DBHOST = "localhost";
const DBUSER = "passwords_user";
//This allows for no password
const DBPASS = "";

const key_str = 'secret password';
const initvector = '0123456789123456';


try {
    $db = new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4",
        DBUSER,
        DBPASS
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set encryption parameters
    $db->exec("SET block_encryption_mode = 'aes-256-cbc'");
    $db->exec("SET @key_str = UNHEX(SHA2('" . key_str . "', 256))");
    $db->exec("SET @init_vector = '" . initvector . "'");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
