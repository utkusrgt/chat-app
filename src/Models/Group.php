<?php
namespace Src\Models;

use Src\Database;
use PDOException;

class Group {
    // Create a new group
    public static function create($name) {
        $db = Database::connect();

        // Prepare the SQL statement
        $stmt = $db->prepare("INSERT INTO groups (name) VALUES (:name)");

        try {
            // Execute the query
            $stmt->execute([':name' => $name]);
            return $db->lastInsertId(); // Return the last inserted ID
        } catch (PDOException $e) {
            // Handle the exception if there is an error with the query
            throw new \Exception('Failed to create group: ' . $e->getMessage());
        }
    }

    // Get all groups
    public static function findAll() {
        $db = Database::connect();

        // Prepare and execute the query
        $stmt = $db->query("SELECT * FROM groups");

        try {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Return the result as an associative array
        } catch (PDOException $e) {
            // Handle potential errors in the query
            throw new \Exception('Failed to fetch groups: ' . $e->getMessage());
        }
    }
}
