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
            echo "<p>Entry inserted into the password manager</p>";
            break;

        case 'update':
            updateEntry($db, $_POST['column'], $_POST['pattern'], $_POST['new_value']);
            echo "<p>Entry updated</p>";
            break;

        case 'delete':
            deleteEntry($db, $_POST['column'], $_POST['pattern']);
            echo "<p>Entry deleted</p>";
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
<h2>Search</h2>
<form method="POST">
    <input type="hidden" name="action" value="search">
    <label for="search_query">Search:</label>
    <input type="text" id="search_query" name="search_query" placeholder="" required>
    <button type="submit">Search</button>
</form>
</body>
<h2>Update</h2>
<form method="POST">
    <input type="hidden" name="action" value="update">
    <label for="attribute-select">Choose an attribute:</label>
    <select name="column" id="attribute-select">
        <option value="website_name">Website Name</option>
        <option value="site_url">URL</option>
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
        <option value="email">Email</option>
        <option value="username">Username</option>
        <option value="password">Password</option>
        <option value="comment">Comment</option>
    </select>
    <label>
        <input type="text" name="pattern" placeholder="Pattern to match" required>
    </label>
    <label>
        <input type="text" name="new_value" placeholder="New value" required>
    </label>
    <button type="submit">Update</button>
</form>
<h2>Delete</h2>
<form method="POST">
    <input type="hidden" name="action" value="delete">
    <label for="attribute-select">Choose an attribute:</label>
    <select name="column" id="attribute-select">
        <option value="website_name">Website Name</option>
        <option value="site_url">URL</option>
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
        <option value="email">Email</option>
        <option value="username">Username</option>
        <option value="password">Password</option>
        <option value="comment">Comment</option>

    </select>
    <input type="text" name="pattern" placeholder="Pattern to match" required>
    <button type="submit">Delete</button>
</form>
</body>
</html>
