<?php
require_once "includes/config.php";
require_once "includes/helpers.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? null;

    switch ($action) {
        case 'search':
            $query = $_POST['search_query'] ?? '';
            if ($query !== '') {
                $results = search($db, $query);
                include "php/templates/search-results.php";
            } else {
                echo "<p>Please enter a search query.</p>";
            }
            break;

        case 'insert':
            $data = [
                'website_name' => $_POST['website_name'],
                'site_url' => $_POST['site_url'],
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'comment' => $_POST['comment'],
            ];
            insertEntry($db, $data);
            echo "<p>Entry inserted successfully!</p>";
            break;

        case 'update':
            updateEntry($db, $_POST['column'], $_POST['pattern'], $_POST['new_value']);
            echo "<p>Entry updated successfully!</p>";
            break;

        case 'delete':
            deleteEntry($db, $_POST['column'], $_POST['pattern']);
            echo "<p>Entry deleted successfully!</p>";
            break;

        default:
            echo "<p>Invalid action.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Manage Passwords</h1>
    <!-- Insert Form -->
    <form method="POST">
        <input type="hidden" name="action" value="insert">
        <input type="text" name="website_name" placeholder="Website Name" required>
        <input type="url" name="site_url" placeholder="URL" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <textarea name="comment" placeholder="Comment"></textarea>
        <button type="submit">Insert</button>
    </form>
</html>
