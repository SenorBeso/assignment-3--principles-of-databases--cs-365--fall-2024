<?php
function insertEntry($pdo, $data) {
    try {
        $stmt = $pdo->prepare("INSERT INTO website (website_name, site_url) VALUES (:website_name, :site_url)");
        $stmt->execute([
            ':website_name' => $data['website_name'],
            ':site_url' => $data['site_url']
        ]);
        $website_id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO account_info (first_name, last_name, email, username, password, comment)
         VALUES (:first_name, :last_name, :email, :username, :password, :comment)");
        $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':password' => $data['password'],
            ':comment' => $data['comment']
        ]);
        $account_id = $pdo->lastInsertId();
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

function search($pdo, $query) {
    try {
        $stmt = $pdo->prepare("
            SELECT
                w.website_name,
                w.site_url,
                a.first_name,
                a.last_name,
                a.email,
                a.username,
                a.comment
            FROM
                register r
            INNER JOIN
                website w ON r.website_id = w.id
            INNER JOIN
                account_info a ON r.account_id = a.id
            WHERE
                w.website_name LIKE :query OR
                w.site_url LIKE :query OR
                a.first_name LIKE :query OR
                a.last_name LIKE :query OR
                a.email LIKE :query OR
                a.username LIKE :query OR
                a.comment LIKE :query
        ");

        $stmt->execute([':query' => '%' . $query . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            echo "<p>No results found for '$query'.</p>";
        } else {
            echo "<table border='1'>";
            echo "<tr>
                    <th>Website Name</th>
                    <th>Website URL</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Comment</th>
                  </tr>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['website_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['site_url']) . "</td>";
                echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
    } catch (PDOException $e) {
        echo "<p>Error during search: " . $e->getMessage() . "</p>";
    }
}
?>
