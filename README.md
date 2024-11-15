# chat-app
# Chat Application Backend for bunq Assessment (PHP)

This is a simple chat application backend built using the Slim Framework in PHP. Users can create chat groups, join groups, and send messages within them. All data is stored in an SQLite database, and communication happens over a RESTful JSON API.

# Developer Notes

This is my first PHP project and this is as simple as it gets as a chat-app. You can create users, and rooms and send messages to the rooms with their respected id's.
Keep the keys in the methods exactly as shown in the below examples.

This app already included several users, a room named "Developers" and several messages.

## Requirements

- PHP 7.4 or higher
- Composer
- SQLite database (a `chat.db` file will be created in the project directory)

## Installation

1. **Clone the repository**:

```bash
   git clone <repository-url>
   cd chat-app
```
2. **Install dependencies using Composer**:

```bash
   composer install
```
3. **Create the SQLite database**:

This application holds every data in the sqlite3, chat.db is already created and included

4. **Start the application**:

You can start the Slim app using PHP's built-in server, please run this command from the root directory:

```bash
php -S localhost:8000 -t public
```
This will serve the application at http://localhost:8000.

API Endpoints
User Routes
Create a New User

POST /users

Request body:
```
json

{
  "username": "newuser"
}
Response:

json

{
  "id": 1
}
```
Find User by Username

GET /users/{username}
Response:
```
json

{
  "id": 1,
  "username": "newuser"
}
```
Group Routes
Create a New Group

POST /groups

Request body:
```

json

{
  "name": "New Group"
}
Response:

json

{
  "id": 1
}
```
List All Groups

GET /groups
Response:
```
json

[
  {
    "id": 1,
    "name": "New Group"
  }
]
```
Message Routes

Send a Message to a Group

POST /messages

Request body:
```
json

{
  "user_id": 1,
  "group_id": 1,
  "content": "Hello, world!"
}
Response:

json

{
  "id": 1
}
```
List Messages for a Specific Group

GET /groups/{group_id}/messages
Response:

```
json

[
  {
    "id": 1,
    "user_id": 1,
    "group_id": 1,
    "content": "Hello, world!",
    "created_at": "2024-11-15T00:00:00Z"
  }
]
```
Testing with Postman
You can use Postman to test the API endpoints. Below are instructions for testing the key functionality.

1. Create a New User
Method: POST
```
URL: http://localhost:8000/users
```
Body: Choose raw and set type to JSON. Use the following JSON:
json
```
{
  "username": "john_doe"
}
```
2. Get User by Username
Method: GET
```
URL: http://localhost:8000/users/john_doe
```
You should get a response with the user's details:
```
json

{
  "id": 1,
  "username": "john_doe"
}
```
3. Create a New Group
Method: POST
```
URL: http://localhost:8000/groups
```
Body: Choose raw and set type to JSON. Use the following JSON:
```
json

{
  "name": "General Chat"
}
```
4. List All Groups
Method: GET
```URL: http://localhost:8000/groups```
You should get a response with all groups:
```
json

[
  {
    "id": 1,
    "name": "General Chat"
  }
]
```
5. Send a Message to a Group
Method: POST
```URL: http://localhost:8000/messages```
Body: Choose raw and set type to JSON. Use the following JSON:
```
json

{
  "user_id": 1,
  "group_id": 1,
  "content": "Hello, everyone!"
}
```
6. List Messages in a Group
Method: GET
```URL: http://localhost:8000/groups/1/messages```
You should get a response with the messages in the specified group:
```
json

[
  {
    "id": 1,
    "user_id": 1,
    "group_id": 1,
    "content": "Hello, everyone!",
    "created_at": "2024-11-15T00:00:00Z"
  }
```

# Developer Notes

This is my first PHP project and this is as simple as it gets as a chat-app. You can create users and rooms and send messages to the rooms with the room's respective ID.

License
This project is licensed under the MIT License - see the LICENSE file for details.
