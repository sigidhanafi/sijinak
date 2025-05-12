<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 🫙 Docker Setup

Make sure you have [Docker](https://docker.com) installed on your system.

```
git clone --recurse-submodules https://github.com/Laradock/laradock.git
cd laradock
cp .env.example .env
```

Open your PHP project's `.env` file or whichever configuration file you are reading from, and set the database host DB_HOST to mysql:

```
DB_HOST=mysql
```

You need to use the Laradock's default DB credentials which can be found in the `.env` file (ex: MYSQL_USER=). Or you can change them and rebuild the container. See [Laradock's Documentation](https://laradock.io/docs/getting-started/#Usage) for more information.

```
docker-compose up -d nginx mysql
```

First time building the image will take a few minutes, but subsequent builds will be cached. Now migrate the database with:

```
docker-compose exec workspace bash
php artisan migrate
```

Your website will be hosted on:

[http://localhost](http://localhost)

To stop running the containers, use

```
docker-compose down
```
