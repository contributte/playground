# datagrid-sandbox (v6)

This project is here for super-simple demonstration how to create a project with `contributte/datagrid`. People are mailing me "This thing is broken - can you fix it please?" and I am responding: "Sure. Please create a sandbox-like repository where I can reproduce you issue and I will have a look at it". Well that's the purpose of this repository. I prepared you a database, presenter and a template. Use it. 🙌

## How to run project:

### composer dependencies 🤪

```bash
composer install
```

### database with dummy data 🗂

```bash
docker-compose -f docker-compose-dev.yml up -d
```

- Create database "datagrid"
- Import dummy data from data/dummy.sql

### Download assets using bower 🌐

```bash
cd www
bower install ublaboo-datagrid
bower install bootstrap-select # multi-select filters
bower install popper.js --save # columns status
```

### Run PHP server ⚡️

```bash
php -S localhost:8000 -t www # with /www root directory
php -S localhost:8000 # when your are in /www
```

### Go to http://localhost:8000/ 👍
