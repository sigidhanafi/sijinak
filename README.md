<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Docker Setup

To get started, you need [Docker](https://docker.com) on your computer.

First, get the Laradock files:

```
git clone --recurse-submodules https://github.com/Laradock/laradock.git
cd laradock
cp .env.example .env
```

Next, you need to tell your PHP project how to connect to the database.
Open your project's `.env` file (or the file where you keep your database settings).
Change the `DB_HOST` setting to `mysql`:

```
DB_HOST=mysql
```

You can use the default database username and password that Laradock provides. You can find these in Laradock's `.env` file (look for `MYSQL_USER=`, for example).
If you want to use different credentials, you can change them in Laradock's `.env` file and then rebuild the Docker container.
For more details, check out [Laradock's Documentation](https://laradock.io/docs/getting-started/#Usage).

Now, start the Docker containers for Nginx (the web server) and MySQL (the database), and make sure you are in the `/laradock` directory:

```
docker-compose up -d nginx mysql
```

The first time you run this, it will take a few minutes to build everything. After that, it will be much faster.

Once the containers are running, you need to set up your database tables. Run this command:

```
docker-compose exec workspace php artisan migrate
```

You only need to run the `php artisan migrate` command the first time you set up your project. Afterwards, to start your project, you'll just need to run the `docker-compose up -d nginx mysql` command mentioned earlier.

Your laravel project should now be running at:

[http://localhost](http://localhost)

When you're done working and want to stop the Docker containers, use this command:

```
docker-compose down
```
