# Laravel REST API Users

## Requirements

- PHP 8.0
- MySQL 8
- Composer

## Installation

1. Clone the repo:
   ```bash
   git clone git@github.com:iHoooK/Laravel-11-api-crud.git
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Copy .env and set DB credentials:
   ```bash
   cp .env.example .env
   ```
4. Run migrations and seed:
   ```bash
   php artisan migrate --seed
   ```
5. Start the server:
   ```bash
   php artisan serve
   ```

## API Endpoints

- `GET /api/users` — get paginated users list (query params: search, sort)
- `GET /api/users/{id}` — get single user by ID
- `POST /api/users` — create new user (JSON: name, email, password, ip, comment)
- `PUT /api/users/{id}` — update user by ID
- `DELETE /api/users/{id}` — delete user by ID

### Search and Sort Example
- `GET /api/users?search=John`
- `GET /api/users?sort=asc`
- `GET /api/users?search=John&sort=desc`

### Creating a New User (POST)
Endpoint: `POST /api/users`

Request Body `(JSON)`:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secretpass",
  "ip": "192.168.1.10",
  "comment": "New user comment"
}
```

Example with `curl`:
```bash
curl -X POST \
  http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "secretpass",
    "ip": "192.168.1.10",
    "comment": "New user comment"
  }'
```

### Updating an Existing User (PUT)
Endpoint: `PUT /api/users/{id}`

For example, to update the user with ID=1, changing their name, password, and comment:

Request Body `(JSON)`:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secretpass",
  "ip": "192.168.1.10",
  "comment": "New user comment"
}
```
Example with `curl`:
```bash
curl -X POST \
  http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "secretpass",
    "ip": "192.168.1.10",
    "comment": "New user comment"
  }'
```
###Deleting a User (DELETE)
Endpoint: `DELETE /api/users/{id}`

For example, to delete the user with ID=1:

Request Body `(JSON)`:
```json
{
"message": "User deleted successfully"
}
```

Example with `curl`:
```bash
curl -X DELETE http://localhost:8000/api/users/1
```
