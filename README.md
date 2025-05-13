<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 🎉 Project Setup

First, set your environment variables:

```
cp .env.example .env
```

## 🫙 Docker Usage

> This Dockerfile has been set to use PostgreSQL only. Using SQLite3, MYSQL, or any other database will NOT work.

### 🚶‍♀️‍➡ Getting Started

To get started, you need [Docker](https://docker.com) on your computer. Next, you need to tell your PHP project how to connect to the database. Open your project's `.env` file (or the file where you keep your database settings).

```env
DB_CONNECTION=pgsql
DB_HOST=sijinak-db
DB_PORT=5432
DB_DATABASE= # Your database name
DB_USERNAME= # Your database username
DB_PASSWORD= # Your database password (cannot be empty)
```

### 🚗 Starting the Services 

After setting your `.env` variables, you can now start runnning your Docker container using:

```
docker compose up -d --build 
```

The first time you run this, it will take a few minutes to build and download everything. After that, it will be much faster.

### 🥀 Final Steps

Once the containers are running, you need to set up your database tables and set your project's unique key. Run this command:

```
docker compose exec app php artisan migrate
docker-compose exec app php artisan key:generate
```

You only need to run the `php artisan migrate` and `php aritsan key:generate` commands the first time you set up your project. Afterwards, to start your project, you'll just need to run the `docker compose up -d --build` command mentioned earlier.

### ✈️ Opening your Project

Your laravel project should now be running at:

[http://localhost:8000](http://localhost:8000)

When you're done working and want to stop the Docker containers, use this command:

```
docker-compose down
```
