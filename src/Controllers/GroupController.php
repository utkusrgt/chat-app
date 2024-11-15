<?php
namespace Src\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Models\Group;

class GroupController {
    // Create a new group
    public function create(Request $request, Response $response) {
        $data = $request->getParsedBody();
        $name = $data['name'] ?? null;

        // Check if name is provided
        if (!$name) {
            return $this->jsonResponse($response, ['error' => 'Group name is required'], 400);
        }

        try {
            // Create group and get the group ID
            $groupId = Group::create($name);
            return $this->jsonResponse($response, ['id' => $groupId]);
        } catch (\Exception $e) {
            return $this->jsonResponse($response, ['error' => 'Error creating group', 'message' => $e->getMessage()], 500);
        }
    }

    // List all groups
    public function list(Request $request, Response $response) {
        try {
            $groups = Group::findAll();
            return $this->jsonResponse($response, $groups);
        } catch (\Exception $e) {
            return $this->jsonResponse($response, ['error' => 'Error fetching groups', 'message' => $e->getMessage()], 500);
        }
    }

    // Helper function to return JSON responses
    private function jsonResponse(Response $response, array $data, int $status = 200): Response {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
