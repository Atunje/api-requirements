## Installation

Clone the repository

    git clone git@github.com:Atunje/api-requirements.git

Switch to the repo folder

    cd api-requirements

Install dependencies using composer

    composer install

Copy the example env file and set the database configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeder to seed the database with the provided dataset

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the endpoint at http://localhost:8000/api/products

**TL;DR command list**

    git clone git@github.com:Atunje/api-requirements.git
    cd api-requirements
    composer install
    cp .env.example .env
    php artisan key:generate

**Make sure you set the correct database connection information before running the migrations**

    php artisan migrate
    php artisan db:seed
    php artisan serve

**Run Tests**

    php artisan test

### Dev Dependencies

- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- [nunomaduro/larastan](https://github.com/nunomaduro/larastan)
- [nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights)

### ✨ PHP Insights Analysis


                92.2%                   88.5%                   100 %                   93.9%                 
                                                                                                              
                                                                                                              
                 Code                 Complexity             Architecture               Style                 


