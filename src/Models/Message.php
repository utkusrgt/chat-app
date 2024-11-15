<?php
namespace Src\Models;

use Src\Database;
use PDOException;

class Message {
    // Create a new message
    public static function create($user_id, $group_id, $content) {
        $db = Database::connect();

        // Prepare the SQL statement
        $stmt = $db->prepare("INSERT INTO messages (user_id, group_id, content) VALUES (:user_id, :group_id, :content)");

        try {
            // Execute the query
            $stmt->execute([
                ':user_id' => $user_id,
                ':group_id' => $group_id,
                ':content' => $content
            ]);
            return $db->lastInsertId(); // Return the last inserted ID
        } catch (PDOException $e) {
            // Handle any errors during the execution
            throw new \Exception('Failed to create message: ' . $e->getMessage());
        }
    }

    // Get all messages for a group
    public static function findByGroup($group_id) {
        $db = Database::connect();

        // Prepare the query to fetch messages
        $stmt = $db->prepare("SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.id WHERE group_id = :group_id ORDER BY created_at ASC");

        try {
            // Execute the query and return the results
            $stmt->execute([':group_id' => $group_id]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Return all the messages as an associative array
        } catch (PDOException $e) {
            // Handle any errors during the query execution
            throw new \Exception('Failed to fetch messages: ' . $e->getMessage());
        }
    }
}
