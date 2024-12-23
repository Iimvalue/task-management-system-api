# Task Management System API

A Laravel-based RESTful API designed to streamline task management processes.

## Features

-   **User Roles:** Supports Admin, Manager, and Employee roles with specific permissions.
-   **Task Management:** Create, assign, update, and resolve tasks with status tracking.
-   **Task Filtering:** Managers and employees can filter tasks by their status.
-   **Notifications:** Notifications for task assignment and resolution, stored in the database.
-   **PDF Reporting:** Generate and download task reports with timestamps and employee assignments.
-   **Authentication:** Token-based authentication using Laravel Sanctum.

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/Iimvalue/task-management-system-api.git
    cd task-management-system-api
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Configure environment:**

    - Copy the `.env.example` file and rename it to `.env`.
    - Set up your database credentials and other configurations in the `.env` file.
    - Use a cross-platform web server like XAMPP, or any alternative method you prefer.

4. **Run database migrations:**

    ```bash
    php artisan migrate
    ```

5. **Seed the database:**
   Run the following command to insert predefined users:

    ```bash
    php artisan db:seed --class=UserSeeder
    ```

    **Seeded Users:**

    - **Admin:**
        - Email: admin@example.com
        - Password: password
    - **Manager:**
        - Email: manager@example.com
        - Password: password
    - **Employee 1:**
        - Email: employee1@example.com
        - Password: password
    - **Employee 2:**
        - Email: employee2@example.com
        - Password: password

6. **Authenticate and Test API:**
    - Use the `/api/login` route to generate a token.
    - Use Postman or another API testing tool to interact with the API endpoints by adding the `Authorization: Bearer <token>` header.

## API Routes

-   **Authentication:**

    -   `POST /api/login`: Login and retrieve token

-   **Tasks Admin:**

    -   All what manager can do
    -   `GET /reports/tasks`: Generate PDF report for tasks

-   **Tasks Management:**

    -   `GET /api/tasks`: List all tasks
    -   `GET /api/tasks?status=...`: List all tasks with filtration (Assigned, Not Assigned,Resolved)
    -   `POST /api/tasks`: Create a task
    -   `PUT /api/tasks/{taskId}`: Update a task
    -   `PUT /api/tasks/{taskId}/assign`: Assign a task
    -   `POST /api/tasks/{taskId}/resolve`: Mark a task as resolved
    -   `Delete /api/tasks/{taskId}`: Delete a task

-   **Tasks Employee:**
    -   `GET /api/employee/tasks.`: List tasks
    -   `GET /api/employee/tasks`: List tasks with filtration (Resolved, Not Resolved)
    -   `POST /api/employee/tasks/{taskId}/resolve`: Mark a task as Resolved

-   **Notifications:**

    -   `GET /api/notifications`: Get notifications filtered by read status
    -   `PUT /api/notifications/{id}/read`: Mark a notification as read

## Notes

-   **PDF Reporting:** The `barryvdh/laravel-dompdf` package is used for generating PDFs.
