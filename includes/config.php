<?php
const DBNAME = "student_passwords";
const DBHOST = "localhost";
const DBUSER = "passwords_user";
//This allows for no password
const DBPASS = "";

try {
    $db = new PDO(
        "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4",
        DBUSER,
        DBPASS
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
