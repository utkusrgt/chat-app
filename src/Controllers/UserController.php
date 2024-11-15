<?php
namespace Src\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Models\User;
use Slim\Psr7\Response as SlimResponse;

class UserController {
    // Create a new user
    public function create(Request $request, Response $response) {
        // Get the parsed body of the request
        $data = $request->getParsedBody();

        
        var_dump($data); 

        // Check if the 'username' field is in the parsed body
        $username = $data['username'] ?? null;

        // Validate if username is provided
        if (!$username) {
            return $this->jsonResponse($response, ['error' => 'Username is required'], 400);
        }

        // Check if username is empty
        if (empty($username)) {
            return $this->jsonResponse($response, ['error' => 'Username is required'], 400);
        }

        try {
            // Create the user and get the user ID
            $userId = User::create($username);

            // Return the user ID in the response
            return $this->jsonResponse($response, ['id' => $userId]);
        } catch (\Exception $e) {
            // Return error if there was an issue creating the user
            return $this->jsonResponse($response, ['error' => 'Error creating user', 'message' => $e->getMessage()], 500);
        }
    }

    // Get a user by username
    public function findByUsername(Request $request, Response $response, $args) {
        $username = $args['username'];

        // Validate if username is provided
        if (empty($username)) {
            return $this->jsonResponse($response, ['error' => 'Username is required'], 400);
        }

        try {
            $user = User::findByUsername($username);
            if ($user) {
                return $this->jsonResponse($response, $user);
            } else {
                return $this->jsonResponse($response, ['error' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            return $this->jsonResponse($response, ['error' => 'Error fetching user', 'message' => $e->getMessage()], 500);
        }
    }

    // Helper function to return JSON responses
    private function jsonResponse(Response $response, array $data, int $status = 200): Response {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
