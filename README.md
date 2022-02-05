<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Gate Tech Assignment API

This is a simple articles API to be consumed using any front-end framework.

## Installation
In order to install the project follow the steps below:

First, we have to clone the repository using the `git clone command`

`git clone https://github.com/crayon1337/Gatetech.git`

Second, let's navigate to project directory and install the application using the `composer intall command`

`cd Gatetech` <br>
`composer install`

Third, let's clone the .env file

If you are on Windows execute `copy .env.example .env` or if you are on linux execute `cp .env.example .env`

Fourth, let's migrate the database

Make sure you have created a database called 'gatetech' or whatever the name you set in .env then execute the following command

`php artisan migrate`

Fifth, we need to have an initial administrator account so let's create that using `Laravel Seeders`

`php artisan db:seed`

Sixth, let's run the server

`php artisan serve`

Voila! Now we are ready to consume the API

## API Consumption
I have created a VueJS application to consume this API with simple design. Find it [here](http://github.com/crayon1337/gatetechvuejs)

## Thoughts
I have had a lot of fun working on this mini-project. However, I have a lot of improvements to apply. Keep in mind, I started working on it 2~3 days later I received the assignment email. I hope you find it convenient and looking forward to hearing your feedback.
