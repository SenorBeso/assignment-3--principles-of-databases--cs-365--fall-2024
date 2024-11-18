<?php
global $db;
require_once "includes/config.php";
require_once "includes/helpers.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? null;

    switch ($action) {
        case 'search':
            $query = $_POST['search_query'] ?? '';
            if ($query !== '') {
                $results = search($db, $query);
            } else {
                echo "<p>Please enter a search query.</p>";
            }
            break;

        case 'insert':
            $data = [
                'website_name' => $_POST['website_name'],
                'site_url' => $_POST['site_url'],
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
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
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 3</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Manage Passwords</h1>
<form method="POST">
    <h2>Insert</h2>
    <input type="hidden" name="action" value="insert">
    <input type="text" name="website_name" placeholder="Website Name" required>
    <input type="url" name="site_url" placeholder="URL" required>
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <textarea name="comment" placeholder="Comment"></textarea>
    <button type="submit">Insert</button>
</form>
</body>
<body>
<header>
</header>
<form id="clear-results" method="post"
      action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input id="clear-results__submit-button" type="submit" value="Clear Results">
</form>
<body>
<h3>Search</h3>
<form method="POST">
    <input type="hidden" name="action" value="search">
    <label for="search_query">Search:</label>
    <input type="text" id="search_query" name="search_query" placeholder="" required>
    <button type="submit">Search</button>
</form>
</body>
</html>
