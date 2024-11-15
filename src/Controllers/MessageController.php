<?php
namespace Src\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Models\Message;

class MessageController {
    // Create a new message
    public function create(Request $request, Response $response) {
        $data = $request->getParsedBody();
        $user_id = $data['user_id'] ?? null;
        $group_id = $data['group_id'] ?? null;
        $content = $data['content'] ?? null;

        // Check if any required fields are missing
        if (empty($user_id) || empty($group_id) || empty($content)) {
            return $this->jsonResponse($response, ['error' => 'User ID, Group ID, and Content are required'], 400);
        }

        try {
            // Create message and get the message ID
            $messageId = Message::create($user_id, $group_id, $content);
            return $this->jsonResponse($response, ['id' => $messageId]);
        } catch (\Exception $e) {
            return $this->jsonResponse($response, ['error' => 'Error creating message', 'message' => $e->getMessage()], 500);
        }
    }

    // List all messages for a given group
    public function list(Request $request, Response $response, $args) {
        $group_id = $args['group_id'];

        // Check if group_id is valid
        if (empty($group_id)) {
            return $this->jsonResponse($response, ['error' => 'Group ID is required'], 400);
        }

        try {
            $messages = Message::findByGroup($group_id);
            return $this->jsonResponse($response, $messages);
        } catch (\Exception $e) {
            return $this->jsonResponse($response, ['error' => 'Error fetching messages', 'message' => $e->getMessage()], 500);
        }
    }

    // Helper function to return JSON responses
    private function jsonResponse(Response $response, array $data, int $status = 200): Response {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
