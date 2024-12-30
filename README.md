<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Project

## Overview

This Laravel application offers essential user functionalities, including:

-   User Registration
-   Login
-   Password Reset
-   Update Profile

---

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/ZeroKnowledge-dev/Inventory_Project
    cd Inventory_Project
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm i
    ```

3. **Copy the `.env` file**

    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**

    ```bash
    php artisan key:generate
    ```

5. **Set up the database**

    - Update the `.env` file with your database credentials.

6. **Run migrations**

    ```bash
    php artisan migrate
    ```

7. **Run the development server**
    ```bash
    composer run dev
    ```

---

## Features

-   User Registration
-   Login
-   Password Reset
-   Update Profile

---

## License

This project is licensed under the [MIT License](LICENSE).
