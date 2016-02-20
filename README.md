# Simple API example using [phramework/jsonapi](https://github.com/phramework/jsonapi) 1.x

[![Build Status](https://travis-ci.org/phramework/jsonapi-example.svg?branch=1.x)](https://travis-ci.org/phramework/jsonapi-example)

## Endpoints
Available endpoints:
- `GET /article/`
- `GET /article/{id}/`
- `GET /article/{id}/relationships/tag/`
- `GET /article/{id}/relationships/author/`
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
- `GET /tag/`
- `GET /tag/{id}/`
- `GET /tag/{id}/relationships/article/`
- `GET /user/`
- `GET /user/{id}/`

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

## Run

To initialize the SQLite database schema and records (required to run only once)
```bash
php ./tools/database.db
```

To  start local web server at port `8004` execute using php build-in server

```bash
composer run
```

or 

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

## Lint code
Lint code using [PSR-2](http://www.php-fig.org/psr/psr-2/) coding style

```bash
composer lint
```
