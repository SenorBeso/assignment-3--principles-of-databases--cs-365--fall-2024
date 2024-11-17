<?php
function insertEntry($pdo, $data) {
    try {
        // Insert into the 'website' table
        $stmt = $pdo->prepare("INSERT INTO website (website_name, site_url) VALUES (:website_name, :site_url)");
        $stmt->execute([
            ':website_name' => $data['website_name'],
            ':site_url' => $data['site_url']
        ]);

        // Get the ID of the newly inserted website
        $website_id = $pdo->lastInsertId();

        // Insert into the 'account_info' table
        $stmt = $pdo->prepare("INSERT INTO account_info (email, username, password, comment) VALUES (:email, :username, :password, :comment)");
        $stmt->execute([
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':password' => $data['password'],
            ':comment' => $data['comment']
        ]);

        // Get the ID of the newly inserted account
        $account_id = $pdo->lastInsertId();

        // Insert into the 'register' junction table to link the account to the website
        $stmt = $pdo->prepare("INSERT INTO register (website_id, account_id) VALUES (:website_id, :account_id)");
        $stmt->execute([
            ':website_id' => $website_id,
            ':account_id' => $account_id
        ]);

        echo "Website and account successfully added.";
    } catch (PDOException $e) {
        echo "Error inserting data: " . $e->getMessage();
    }
}
?>
