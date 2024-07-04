# How to Run the Website

This guide provides instructions on how to set up and run the website locally on your machine.

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP
- Composer
- MySQL
- Node.js and NPM

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/ShoyebWritesCode/Product-Catalog-Laravel.git
   cd Product-Catalog-Laravel

2. **Install PHP Dependencies:**

    ```bash
    composer install

3. **Install Node Dependencies:**

    ```bash
    npm install

 4. **Generate .env file and APP_KEY:**

    ```bash
    cp .env.example .env
    php artisan key:generate

 5. **Configure Database:**

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=product_catalogue
    DB_USERNAME=root
    DB_PASSWORD=

 6. **Setup Google smtp:**

    ```bash
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=465
    MAIL_USERNAME=yourmail@gmail.com
    MAIL_PASSWORD="your-generated-password"
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="no-reply-youraddress@gmail.com"
    MAIL_FROM_NAME="Yoursite.com"

 6. **Run Database Migrations and Seeders:**

    ```bash
    php artisan migrate --seed

 7. **Setup Storage Link:**

    ```bash
    php artisan storage:link
    cp -R public/images public/storage

 8. **Build Front-end Assets:**

    ```bash
    # Option 1: Build for production
    npm run build
    
    # Option 2: Build for development
    npm run dev

 9. **Start the Development Server:**

    ```bash
    php artisan serve

## Login Credentials

### Admin:
- **Username:** `admin@gmail.com`
- **Password:** `admin 1234`

### User:
- **Option 1: Existing User**
  - **Username:** `user@gmail.com`
  - **Password:** `user 1234`

- **Option 2: Register as a New User**
  - Visit the registration page and create a new account.
  - After registration, use the credentials you created to log in.


    

