<?php
namespace Src\Models;

use Src\Database;
use PDOException;

class User {
    // Create a new user
    public static function create($username) {
        $db = Database::connect();

        // Prepare the SQL statement
        $stmt = $db->prepare("INSERT INTO users (username) VALUES (:username)");

        try {
            // Execute the query
            $stmt->execute([':username' => $username]);
            return $db->lastInsertId(); // Return the last inserted ID
        } catch (PDOException $e) {
            // Handle any errors during the execution
            throw new \Exception('Failed to create user: ' . $e->getMessage());
        }
    }

    // Find a user by username
    public static function findByUsername($username) {
        $db = Database::connect();

        // Prepare the query to fetch a user by username
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");

        try {
            // Execute the query and fetch the result
            $stmt->execute([':username' => $username]);
            return $stmt->fetch(\PDO::FETCH_ASSOC); // Return the user data as an associative array
        } catch (PDOException $e) {
            // Handle any errors during the query execution
            throw new \Exception('Failed to fetch user: ' . $e->getMessage());
        }
    }
}
