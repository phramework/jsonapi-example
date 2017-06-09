# Simple API example using [phramework/jsonapi](https://github.com/phramework/jsonapi) 1.x

[![Build Status](https://travis-ci.org/phramework/jsonapi-example.svg?branch=1.x)](https://travis-ci.org/phramework/jsonapi-example)

## Endpoints
Available endpoints:
- `GET /article/`
- `GET /article/{id}/`
- `GET /article/{id}/relationships/tag/`
- `GET /article/{id}/relationships/creator/`
- `POST /article/`
```json
{
  "data": [
    {
      "type": "article",
      "attributes": {
        "title": "Sample title",
        "body": "Sample body"
      },
      "relationships": {
        "creator": {
          "data": {
            "id": "1",
            "type": "user"
          }
        }
      }
    }
  ]
}
```
- `PATCH /article/{id}/`
```json
{
  "data": 
    {
      "type": "article",
      "id": "{id}",
      "attributes": {
        "title": "Updated title",
        "body":  "Updated body"
      }
    }
}
```
- `DELETE /article/{id}/`
- `GET /tag/`
- `GET /tag/{id}/`
- `GET /tag/{id}/relationships/article/`
- `GET /user/`
- `GET /user/{id}/`

### /administrator/ API

- `GET /administrator/user/`
- `GET /administrator/user/{id}/`
- `POST /administrator/user/`
```json
{
  "data": [
    {
      "type": "user",
      "attributes": {
        "username": "stark 123",
        "email": "nohponex+stark123@gmail.com",
        "name": "Stark 123",
        "status": 1,
        "password": "1234"
      }
    }
  ]
}
```
- `PATCH /administrator/user/{id}/`
```json
{
  "data": {
    "type": "user",
    "id": "{id}",
    "attributes": {
      "name": "New name"
    }
  }
}
```
- `DELETE /administrator/user/{id}/`

## Install
Requirements:
- git
- PHP (>=7)
- [Composer](https://getcomposer.org)
- [SQLite](https://secure.php.net/manual/en/book.sqlite.php) for PHP
- Web server with PHP support

To download dependencies
```bash
composer update
```

It is also recommended to install and configure [Xdebug](https://xdebug.org/)

## Run

To initialize the SQLite database schema and records (required to run only once).
You can reuse the command to reset the data.
```bash
php ./tools/database.php
```

To start local web server at port `8004` execute using php build-in server

```bash
php -S localhost:8004 -t ./public/
```

You can access the `article` collection using `GET http://localhost:8004/article/` request.

You can also expose `/public` to your web server, **NOTE** we are using an `.htaccess` file to rewrite the urls.

## Test
To run all available tests (syntax check, unit and request tests)

```bash
composer test
```

- Unit tests available at `/tests/phpunit/` directory using [PHPUnit](https://phpunit.de/)
- Request tests available at `/tests/testphase/` directory using [phramework/testphase](https://github.com/phramework/testphase)

### Testphase

To execute only testphase tests
```bash
composer testphase
```

To generate an overview for testphase tests execute
```bash
composer testphase-report
```

More about writing testphase tests at https://github.com/phramework/testphase

## Lint code
Lint code using [PSR-2](http://www.php-fig.org/psr/psr-2/) coding style

```bash
composer lint
```

## Local settings
Read localsettings.example.php if you need to modify any of the settings localy, without committing the changes.