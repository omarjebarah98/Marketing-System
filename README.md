## Project Description

Marketing Management System allows users to manage campaigns and templates.

--------------------------------

## Features:

Campaign CRUD (create, read, update, delete)

Template CRUD with dynamic variables

Soft deletes for campaigns and templates

Real-time notifications for campaign status changes

CSV/PDF export of campaign statistics

Scheduler for automatic status updates

Admin dashboard with campaign statistics

API + web dashboard

--------------------------------

## Setup Steps

Clone the repository:

git clone https://github.com/omarjebarah98/Marketing-System.git

--------------------------------

## Install PHP dependencies:

composer install

npm install

--------------------------------

## Copy the environment file :

cp .env.example .env

--------------------------------

## Run database migrations and seeders:

php artisan migrate --seed

--------------------------------

## Start Laravel server:

npm run dev (for echo and pusher)

php artisan queue:work

php artisan serve

--------------------------------

## Scheduler Command

Run manually:

php artisan campaigns:update-statuses

--------------------------------

## Api Collections

[api's collection.postman_collection.json](https://github.com/user-attachments/files/24074952/api.s.collection.postman_collection.json)

