# datagrid-sandbox
ublaboo/datagrid playground with docker-compose to easily run the project

## How to run project:

### composer dependencies

```
composer install
```

### database with dummy data

```
docker-compose -f docker-compose-dev.yml up -d
```

- Create database "datagrid"
- Import dummy data from data/dummy.sql

### Run PHP server

```
php -S localhost:8000 -t www # with /www root directory
php -S localhost:8000 # when your are in /www
```
