Laravel Task Manager APP
Build Status Gitter GitHub stars GitHub license

Example Laravel codebase containing real world examples (CRUD, auth, advanced patterns and more) that adheres to the ECOMMERCE spec and API.
This repo is functionality complete — PRs and issues welcome!

Getting started
Installation
Please check the official laravel installation guide for server requirements before you start. Official Documentation

Alternative installation is possible without local dependencies relying on Docker.

Clone the repository

git clone https://github.com/AmjadGhzlangit/Laravel-Task-Manager.git
Switch to the repo folder

cd Laravel-Task-Manager
Install all the dependencies using composer

composer install
Copy the example env file and make the required configuration changes in the .env file

cp .env.example .env
Generate a new application key

php artisan key:generate
Run the database migrations (Set the database connection in .env before migrating)

php artisan migrate
Start the local development server

php artisan serve
You can now access the server at http://localhost:8000

TL;DR command list

git clone  https://github.com/AmjadGhzlangit/Laravel-Task-Manager.git
cd Laravel-Task-Manager
composer install
cp .env.example .env
php artisan key:generate
Make sure you set the correct database connection information before running the migrations Environment variables

php artisan migrate
php artisan serve
Database seeding
Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.

Run the database seeder and you're done

php artisan db:seed
Docker
To install with Docker, run following commands:

git clone https://github.com/AmjadGhzlangit/Laravel-Task-Manager.git
cd Laravel-Task-Manager
- Docker Compose
    - UP
        ``` bash
        docker compose up -d 
        ```
    - Down
        ``` bash
        docker compose down
        ```
    - Build
        ```bash
        docker compose up -d --build
        ```
    - Update
        ```bash
        docker compose run --rm composer update
        ```
    - npm run Dev
        ```bash
        docker compose run --rm npm run dev
        ```
    - Migrate
        ```bash
        docker compose run --rm artisan migrate
        ```

- Documentation Generate
    ```bash
    docker compose run --rm artisan enum:docs  && docker compose run --rm artisan scribe:generate --force
    ```
- IDE Helper Generate
    ```bash
    docker compose run --rm artisan migrate:fresh --seed && docker compose run --rm artisan ide-helper:generate && docker compose run --rm artisan ide-helper:models --write --reset --write-mixin && docker compose run --rm artisan ide-helper:meta
    ```
- Deployer unlock
    ```bash
    docker compose run --rm php vendor/bin/dep deploy:unlock
Code overview
Folders
app - Contains all the Eloquent models
app/Http/API/V1/Controllers - Contains all the api controllers
app/Http/Middleware - Contains the JWT auth middleware
app/Http/API/V1/Requests - Contains all the api form requests
app/Http/API/V1/Repositories - Contains all the api form Repositories
app/Filters - Contains the query filters used for filtering api requests
config - Contains all the application configuration files
database/factories - Contains the model factory for all the models
database/migrations - Contains all the database migrations
database/seeds - Contains the database seeder
routes - Contains all the api routes defined in api.php file
tests - Contains all the application tests
tests/API/V1/controllers - Contains all the api tests
Environment variables
.env - Environment variables can be set in this file
Note : You can quickly set the database information and other variables in this file and have the application fully working.

Testing API
Run the laravel development server

php artisan serve
The api can now be accessed at

http://localhost:8000/api/v1
Request headers

Required	Key	Value
Yes	Content-Type	application/json
Yes	X-Requested-With	XMLHttpRequest
Optional	Authorization	Bearer Token
Refer the api specification for more info.
