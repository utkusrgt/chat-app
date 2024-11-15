<?php
// Autoload the dependencies using Composer
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Src\Controllers\UserController;
use Src\Controllers\GroupController;
use Src\Controllers\MessageController;
use Slim\Middleware\BodyParsingMiddleware;

// Create the Slim app instance
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Remove the base path if you're running from the public directory directly
// $app->setBasePath('/chat-app/public');

// Define the routes

// User routes
$app->post('/users', [UserController::class, 'create']); // Create a new user
$app->get('/users/{username}', [UserController::class, 'findByUsername']); // Find user by username

// Group routes
$app->post('/groups', [GroupController::class, 'create']); // Create a new group
$app->get('/groups', [GroupController::class, 'list']); // List all groups

// Message routes
$app->post('/messages', [MessageController::class, 'create']); // Send a message to a group
$app->get('/groups/{group_id}/messages', [MessageController::class, 'list']); // List messages for a specific group

// Run the app
$app->run();
