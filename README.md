# Ticket Booking System

## Description

This project is a **Ticket Booking System** developed with Laravel 9. It allows users to browse available matches, purchase tickets, manage transactions, and engage in a community forum.

## Features

### Ticketing System

- View available matches and stadium details.
- Select seats from a stadium seating map.
- Secure payment processing and transaction management.
- Download purchased tickets in PDF format.
- Resell tickets securely through the platform.
- Admins can manage match schedules, ticket prices, and generate sales reports.

### Match & Team Management

- Browse teams and their details.
- View live match scores and schedules.
- Follow teams and receive notifications.

### Community Forum

- Register and log in to participate in discussions.
- Create, comment, and like posts.
- Report inappropriate content.
- Admin moderation tools for content management.

### Payment Management

- Secure credit card storage for quick payments.
- Receive detailed receipts after transactions.
- Admin fraud detection and monitoring tools.

## Installation

### Prerequisites

Ensure you have the following installed:

- PHP >= 8.0
- Composer
- Laravel 9
- MySQL or PostgreSQL
- Node.js & NPM (for frontend assets)

### Setup

1. **Clone the repository**

   ```sh
   git clone https://github.com/ayoubbr/Atlas30
   cd Atlas30
   ```

2. **Install dependencies**

    ```sh
    composer install
   npm install && npm run dev
    ```

3. **Create environment file**

    ```sh
    cp .env.example .env
    ```

4. **Set up the database**

    Update .env with your database credentials.

    Run migrations and seed data:

    ```sh
    php artisan migrate --seed
    ```

5. **Generate application key**

    ```sh
    php artisan key:generate
    ```

6. **Serve the application**

    ```sh
    php artisan serve
    ```

7. **Open your browser and visit:**

    ```sh
    http://127.0.0.1:8000
    ```

## Technologies Used

- Backend: Laravel 9, Eloquent ORM, MySQL
- Frontend: Blade, TailwindCSS, Alpine.js
- Payments: Stripe API
- Notifications: Laravel Notifications
- Docker: Laravel Sail
