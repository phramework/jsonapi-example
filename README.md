# Simple API example using phramework's implementation of JSONAPI
## Endpoints
Available endpoints:
- `GET /article/`
- `GET /article/{id}`
- `GET /article/{id}/relationships/tag`
- `GET /article/{id}/relationships/author`
- `GET /tag/`
- `GET /tag/{id}`
- `GET /user/`
- `GET /user/{id}`

## Install

```bash
composer update
```

## Run
You can execute `composer run` to start a local php server at port `8004`

```
composer run
```

You can access the `article` collection using `GET http://localhost:8004/article/` request.

You can also expose `/public` to your web server, **NOTE** we are using an `.htaccess` file to rewrite the urls.

## Test
Test code for errors

```
composer test
```

## Lint code
Lint code using PSR-2 coding style

```
composer lint
```
