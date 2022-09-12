# DOT API

## Installation

1. Clone this repository.
2. Install the dependencies. Run `composer install` command, then run `npm install` command.
3. Create `.env` file by simply copying the `.env.example` file and rename it.
4. Make sure you have a database created and the database server is running.
5. Configure the `.env` file with your **database connection**, etc.
6. Generate the application key with `php artisan key:generate` command.
7. Generate the database structure with this commands based on your preferences:
   - Use **`php artisan migrate`** for [creating / updating the database](https://laravel.com/docs/9.x/migrations).
   - Use **`php artisan db:seed`** for [seeding the database](https://laravel.com/docs/9.x/seeding#running-seeders).
   - Use `php artisan migrate:fresh` for fresh installation.
   - Use `php artisan migrate:fresh --seed` for fresh installation and seeding the database.

> **Warning!** If you use `php artisan migrate:fresh` command, all tables will be dropped and recreated. **All data in the tables will be lost**.

8. Finally, start the application with `php artisan serve` command.

## Fetching data

You can fetch data from the external source API by following these steps:

1. Configure the `.env` file with your **external source API connection**:
   - `EXTERNAL_SOURCE_URL` - The URL of the external source API.
   - `EXTERNAL_SOURCE_KEY` - The API key of the external source API.
   - `EXTERNAL_SOURCE_DATA_PATH` - The path of the data in the external source API response, separated by dot (e.g. `data.data`).
2. Make sure the database server is running.
3. Run `php artisan fetch` command to start fetch the data from the external source API.

> **Warning!**
>
> `php artisan fetch` command will fetch the data from the external source API and store it in the database. **All existing data will be lost**.

## API Documentation

The base URL of the API is `http://localhost:8000/api`.

### Authentication

#### Login

```http
POST /login
```

| Body Parameter | Type     | Required | Description |
| :------------- | :------- | :------- | :---------- |
| `email`        | `string` | Yes      | The email of the user. |
| `password`     | `string` | Yes      | The password of the user. |

### Provinces

#### 1. Get all provinces

```http
GET /provinces
```

#### 2. Get specific province by Id

```http
GET /provinces?id={id}
```

| Parameter | Type     | Required | Description |
| :-------- | :------- | :------- | :---------- |
| `id`      | `string` | Yes      | The Id of the province. |

### Cities

#### 1. Get all cities

```http
GET /cities
```

#### 2. Get specific city by Id

```http
GET /cities?id={id}
```

| Parameter | Type     | Required | Description |
| :-------- | :------- | :------- | :---------- |
| `id`      | `string` | Yes      | The Id of the city. |
