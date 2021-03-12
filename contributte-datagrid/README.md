# datagrid-sandbox (v6)

This project is here for super-simple demonstration how to create a project with `contributte/datagrid`. People are mailing me "This thing is broken - can you fix it please?" and I am responding: "Sure. Please create a sandbox-like repository where I can reproduce you issue and I will have a look at it". Well that's the purpose of this repository. I prepared you a database, presenter and a template. Use it. 🙌

## Installation

```bash
composer install
```

### database with dummy data 🗂

```bash
docker-compose -f docker-compose.yml up -d
```

- Create database "datagrid"
- Import dummy data from data/dummy.sql

```bash
docker exec -it contributte-datagrid-mysql /usr/share/datagrid/db-init.sh
```

### Run PHP server ⚡️

```bash
php -S localhost:8000 -t www # with /www root directory
php -S localhost:8000 # when your are in /www
```

### Go to http://localhost:8000/ 👍
