# ITckets

ITckets is a simple IT support ticket system built with PHP and MySQL/MariaDB. It allows users to create, view, and manage their support requests, while providing an interface for administrators to track, assign, and resolve tickets.

## The application is online at: https://iticket.42web.io/src/auth/register.php

## Features

### User Features
*   **Authentication:** Secure registration and login system.
*   **Ticket Management:**
    *   Create new support tickets with a subject, description, and contact phone number.
    *   View a list of their own submitted tickets, along with current status and responsible admin.
    *   Cancel tickets that are no longer needed.

### Administrator Features
*   **Authentication:** Secure login.
*   **Dashboard:** View key metrics and different ticket categories at a glance.
*   **Ticket Management:**
    *   View all tickets submitted by users.
    *   View tickets specifically assigned to them ("Tickets to solve").
    *   View a history of all closed tickets.
    *   View detailed information about a specific ticket, including the creator and responsible admin.
    *   Assign themselves to unassigned tickets.
    *   Close tickets once the issue is resolved.
*   **User Management:** View a list of all registered clients.

## Prerequisites
To run ITckets locally, you will need:

*   **PHP** (Version 8.2 or higher recommended)
*   **MySQL or MariaDB** database server
*   **Web Server** (e.g., Apache, Nginx) capable of running PHP

## Installation

1.  **Clone the repository:**
    ```bash
    git clone <repository_url>
    cd <repository_directory>
    ```

2.  **Database Setup:**
    *   Create a new database in your MySQL/MariaDB server (e.g., `auth_system`).
    *   Import the provided SQL schema file.
        ```bash
        mysql -u your_user -p auth_system < Database/users.sql
        ```
    *   *Note: Ensure the `tickets` table is also created if it is not present in the initial SQL dump. The application expects a `tickets` table with columns like `tid` (Primary Key, Auto Increment), `subject`, `description`, `uid` (Foreign Key to users), `responsible` (Admin UID), `status` (e.g., 'pending', 'closed'), and `phone`.*

3.  **Configuration:**
    *   Copy the example configuration file:
        ```bash
        cp config/db_data_example.php config/db_data.php
        ```
    *   Edit `config/db_data.php` with your database credentials:
        ```php
        <?php
        define("HOSTNAME", "localhost");
        define("USERNAME", "your_db_username");
        define("DATABASE", "auth_system"); // Or your chosen database name
        define("PASSWORD", "your_db_password");
        ?>
        ```

4.  **Running the Application:**
    *   Place the project directory in your web server's document root (e.g., `/var/www/html/ITckets` for Apache).
    *   Access the application via your web browser (e.g., `http://localhost/ITckets/src/auth/login.php`).

## Database Structure

The application relies on two primary tables:

*   **`users`**: Stores user account information (ID, username, email, password hash, role, creation timestamp). The `email` field is unique.
*   **`tickets`**: Stores the support requests. It links to the `users` table via `uid` (the creator) and `responsible` (the admin assigned to solve it). It tracks the `status` of each request.

## Technologies Used

*   **Backend:** PHP
*   **Frontend:** HTML, CSS (Bootstrap 5 via CDN), Material Symbols
*   **Database:** MySQL / MariaDB

## Security Notes

*   Ensure your web server is configured to prevent direct access to sensitive directories like `config/` or `includes/` (e.g., using `.htaccess` or server block rules).
*   The application uses prepared statements (`$conn->prepare()`) to mitigate SQL injection vulnerabilities.
*   Passwords should be stored securely (e.g., using `password_hash()` in PHP).
