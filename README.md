# La Casa de la guía

### Final grupal project of the FemCoders Bootcamp 😍

# 🗂️Index

### 1. Discription

### 2.Guide of intallation

### 3.Technologies used

### 4.Authors

# 📝Description

The web platform will be an informative and participatory resource for a shelter, providing information about its services and encouraging the community to contribute in different ways. It will include sections for donations, membership application, volunteering opportunities and a contact form for further enquiries. The design will be clear and attractive, ensuring data confidentiality and offering secure options for online transactions. It will be actively promoted to maximise outreach and community involvement.

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone https://github.com/vallefarinha/back-casa.git

Switch to the repo folder

    cd back-casa

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**Tool;DR command list**

    git clone  https://github.com/vallefarinha/back-casa.git
    cd back-casa
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

**_Note_** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

## Environment variables

-   `.env` - Environment variables can be set in this file

**_Note_** : You can quickly set the database information and other variables in this file and have the application fully working.

# 💻Technologies used:

## 🛠️ Skills

[![My Skills](https://skillicons.dev/icons?i=html,js,tailwind,git,github,figma,php,laravel,mysql)](https://skillicons.dev)

# 📚 Licence

### This project is licensed under the MIT License.

# ✒️ Authors

### This project has been created by:

-   [Gabriela Farinha](https://github.com/vallefarinha)

-   [Nathalia Ruiz](https://github.com/NathaRuiz)

-   [Maria Cao Caamaño](https://github.com/maicaocaa)

-   [Diana Alonso](https://github.com/dialomt)

-   [Atefa Mahmoodi](https://github.com/Atefa1234)
