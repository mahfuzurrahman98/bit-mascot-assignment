# Bit Mascot Task Assignmet

## Description

A simple user portal using basic Laravel, where only registered users can login using email and password. The project was assigned by Bit Mascot as part of the evaluation process for the Software Engineer position.

## Prerequisites

Before running the system locally, make sure you have the following prerequisites installed:

- PHP
- Composer
- Node.js
- npm
- MySQL

## Setup

Follow these steps to set up the Inventory Management System locally:

1. Clone the repository:

   ```
   git clone https://github.com/mahfuzurrahman98/bit-mascot-assignment.git
   ```
2. Navigate into the server directory:

   ```
   cd server
   ```
3. Install the PHP dependencies:

   ```
   composer update
   ```
4. Edit the database variables in the `.env` file.
5. Run the database migrations:

   ```
   php artisan migrate
   ```
6. Seed the database:

   ```
   php artisan db:seed --class=UserSeeder
   ```
7. Create symbolic link:

   ```
   php artisan storage:link
   ```
8. Set up SMTP credentials for email. If you do not have any SMTP setup, use the one provided in `.env.example`
9. In a new terminal window, navigate into the client directory:

    ```
    cd client
    ```
10. Install the Node.js dependencies:

    ```
    npm install
    ```
11. Start the development server:

```
   npm run dev
```
12. Start the PHP server:

   ```
   php artisan serve
   ```

Now, you should be able to access the Inventory Management System in your web browser.

## Technologies Used

- **Backend:**

  - PHP
  - Laravel
  - MySQL
- **Frontend:**

  - JavaScript
  - JQuery
  - HTML/CSS
  - Laravel Blade
  - Bootstrap5
- **Authentication:**

  - Laravel's Built-in Browser Authentication Services
- **Development Tools:**

  - Composer (PHP package manager)
  - npm (Node Package Manager)
  - Git
