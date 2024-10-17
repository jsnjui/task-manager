## Table of Contents
1.Requirements
2.Installation
3.Database Setup
4.Environment Configuration
5.Running the Application

## Requirements
Ensure that your local machine meets the following requirements:

PHP >= 8.1
Composer
PostgreSQL
Laravel 10.x
Git

## Installation
Clone the Repository

Clone this repository to your local machine:

bash
Copy code
git clone https://github.com/jsnjui/task-manager
cd task-manager
Install Composer Dependencies

Run the following command to install all required PHP packages:

composer install

Database Setup
This application uses PostgreSQL as its database. Ensure you have PostgreSQL installed and running on your local machine.

Create a Database

Create a new PostgreSQL database with the name task_management

Run Database Migrations

Run the following command to migrate the database tables:

php artisan migrate

This will ensure all the tables include those used by passport have been migrated.

Please laravel documentation on using passport for authenticating apis requests.

https://laravel.com/docs/11.x/passport

**The above can be skipped if you directly import the database within the repo**


# Seeding 

run the `php artisan db:seed` command to create a default user to be used to simulate tasks for the user.

The created user can be used to obtain an acces token :

## Environment Configuration
Copy .env.example file

Create a copy of the .env.example file and name it .env:

cp .env.example .env

Configure Database Settings

In your .env file, update the database connection settings for PostgreSQL:

env
Copy code
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=task_management
DB_USERNAME=postgres
DB_PASSWORD=********

Generate Application Key

Run this command to generate an application encryption key:


php artisan key:generate

Running the Application
Start the Laravel development server:


php artisan serve
The application will be available at http://localhost:8000.
