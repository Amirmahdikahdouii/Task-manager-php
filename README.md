# Task Manager

This Application is a task manager that users can register and use application for manage their daily tasks.

# Task Management Application Documentation

## Table of Contents

- [Site Map](#site-map)
- [API Endpoints](#api-endpoints)
    - [User Authentication](#user-authentication)
        - [Sign Up](#sign-up)
        - [Log In](#log-in)
        - [Log Out](#log-out)
    - [Task Management](#task-management)
        - [Get All Tasks](#get-all-tasks)
        - [Add a Task](#add-a-task)
        - [Get a Single Task](#get-a-single-task)
        - [Update a Task](#update-a-task)
        - [Delete a Task](#delete-a-task)

---

## Site Map

1. **Home Page**
    - URL: `task-manager/index.php`
    - Description: The landing page for the application. Provides an overview and options to sign up or log in.

2. **Sign Up Page**
    - URL: `task-manager/users/signUp.php`
    - Description: The page where new users can register an account.

3. **Login Page**
    - URL: `task-manager/users/login.php`
    - Description: The page where existing users can log in to their account.

4. **Dashboard**
    - URL: `task-manager/users/dashboard.php`
    - Description: The main dashboard where users can view and manage their tasks. This page is accessible only to
      authenticated users.

5. **Task Management**
    - **Add Task Page**
        - URL: `task-manager/tasks/addNewTask.php`
        - Description: A form for users to add a new task.
    - **Edit Task Page**
        - URL: `task-manager/tasks/editTask.php?=task_id={task_id}`
        - Description: A form for users to edit or delete an existing task.
    - **List Task Page**
        - URL: `task-manager/tasks/taskList.php`
        - Description: Endpoint for list all task, here also user can filter tasks or search throw them.

6. **Logout**
    - URL: `task-manager/users/logout.php`
    - Description: Logs the user out of their account and redirects to the home page.

---

## API Endpoints

### User Authentication

#### Delete Task API

- **Endpoint**: `task-manager/api/deleteTask.php`
- **Method**: `POST`
- **Description**: Delete an existing task of a user.
- **Notation**: User must be authenticated because api endpoint get user id from session.
- **Request Body**:
  ```json
  {
    "task_id": "int"
  }
  
#### Username validation

- **Endpoint**: `task-manager/api/usernameValidation.php`
- **Method**: `POST`
- **Description**: Return status of a username is valid for taken or not.
- **Notation**: This endpoint check if username is already taken or not. Used in signUp.php .
- **Request Body**:
  ```json
  {
    "username": "string"
  }


# PHP Task Management Application Setup and Structure

## Table of Contents

- [Directory Structure](#directory-structure)
    - [Assets](#assets)
    - [Database](#database)
    - [Components](#components)
- [Configuration](#configuration)
    - [Database Configuration](#database-configuration)
- [Initial Setup](#initial-setup)

---

## Directory Structure

The application is organized into the following key directories:

### Assets

- **Directory**: `assets/`
- **Description**: This directory contains all static files used by the application, including images, CSS, and JavaScript files.
    - **CSS Files**: Store all your stylesheet files (`.css`) under `assets/css/`.
    - **JavaScript Files**: Store all your JavaScript files (`.js`) under `assets/js/`.
    - **Images**: Store all your image files (`.png`, `.jpg`, `.svg`, etc.) under `assets/img/`.

### Database

- **Directory**: `database/`
- **Description**: This directory contains SQL files necessary for setting up and initializing the database.
    - **Initial SQL Files**: Place the initial SQL scripts for creating tables and seeding the database within this directory. For example, `database/init.sql`.
    - **DDL for store data in database tables**: Place the SQL scripts for Add, Edit, DELETE tables and seeding the database within this directory. For example, `database/ddl.sql`.

### Components

- **Directory**: `components/`
- **Description**: This directory contains reusable PHP components like headers, footers, and other common elements used across different pages.
    - **Header**: Store the header component in `components/header.php`.
    - **Footer**: Store the footer component in `components/footer.php`.

  These components can be included in different pages using `include` or `require` statements in PHP.

---

## Configuration

### Database Configuration

- **File**: `core/db_config.php`
- **Location**: Root directory of the application.
- **Description**: This file contains the database configuration settings necessary for connecting to the MySQL database.

  Below is an example of how the `db_config.php` file should be structured:

  ```php
  <?php
  // Database configuration
  define("DB_HOST", "localhost");
  define("DB_USER", "root");
  define("DB_PASSWORD", "Alimardani33");
  define("DB_NAME", "task_manager");
  ?>
    ```

- **File**: `core/db.php`
- **Location**: Root directory of the application.
- **Description**: This file contains the database setup for creating database or database table if they are not exist.

- **File**: `core/config.php`
- **Location**: Root directory of the application.
- **Description**: This file setup important variable for authenticate users.

# PHP Task Management Application - Permission and Messaging Framework

## Table of Contents

- [Permission Middleware](#permission-middleware)
    - [login_required.php](#login_requiredphp)
- [Message Framework](#message-framework)
    - [messageScript.php](#messagescriptphp)
    - [messages.php](#messagesphp)
    - [messagesAssets.php](#messagesassetsphp)
    - [Session Keys](#session-keys)

---

## Permission Middleware

### `login_required.php`

- **Directory**: `permission/`
- **Description**: This file acts as a middleware to check if a user is logged in before allowing access to specific pages. It should be included at the beginning of any page that requires user authentication.

- **Usage**:
    - Include `login_required.php` at the top of your PHP files where you want to enforce login protection.
    - Example:
      ```php
      <?php
      include 'permission/login_required.php';
      // Rest of your page code
      ?>
      ```

- **Functionality**:
    - The script checks if the user session is active. If not, it redirects the user to the login page or displays an appropriate message.

---

## Message Framework

The message framework is designed to provide a consistent way to display user messages across the application. The framework is implemented through three files: `messageScript.php`, `messages.php`, and `messagesAssets.php`.

### `messageScript.php`

- **Directory**: `message/`
- **Description**: This script is responsible for invoking the message framework to display messages to the user. It checks for messages stored in the session and triggers their display.

- **Usage**:
    - Include this script in any file where you want to display session-based messages.
    - Example:
      ```php
      <?php
      include 'message/messageScript.php';
      ?>
      ```

### `messages.php`

- **Directory**: `message/`
- **Description**: This module contains the HTML structure for displaying messages. It should be included whenever there is a message present in the session.

- **Usage**:
    - Include `messages.php` in your files to render the message HTML structure.
    - Example:
      ```php
      <?php
      include 'message/messages.php';
      ?>
      ```
    - The module will check the session for messages and display them using the appropriate styling based on the `message_icon` session key.

### `messagesAssets.php`

- **Directory**: `message/`
- **Description**: This file contains the necessary `<link>` and `<script>` tags to include the CSS and JavaScript required for the message framework. It simplifies the inclusion process in other files.

- **Usage**:
    - Include `messagesAssets.php` in your HTML files to ensure the required CSS and JS for the messages are loaded.
    - Example:
      ```php
      <?php
      include 'message/messagesAssets.php';
      ?>
      ```

### Session Keys

The message framework relies on specific session keys to function correctly. These keys determine the content and appearance of the messages displayed to the user.

- **Session Keys**:
    - **`message`**: This key holds the message text that will be displayed to the user.
    - **`message_icon`**: This key determines the type of message to display. It can have one of the following values:
        1. `error`: Indicates an error message.
        2. `warning`: Indicates a warning message.
        3. `success`: Indicates a success message.

- **Example Usage**:
    - To set a message in the session:
      ```php
      $_SESSION['message'] = "Task successfully created!";
      $_SESSION['message_icon'] = "success";
      ```
    - After setting these session values, include `messageScript.php` and `messages.php` in your file to display the message.

---

**Last Updated**: [Aug 12 2024]

