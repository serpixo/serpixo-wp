# serpixo

## General

If you want to install the project, you must first create a copy of `.env.example` and rename them to `.env`. Then use can put credentials into those files and start with `composer install`.

## Minimum requirements

- PHP 8.0
- MariaDB 10.7 or MySQL 5.7
- Git LFS

## Update

When you update WordPress, you should run the script `after-update-wp.sh`, which will remove unnecessary files.

## Docker

Docker is currently recommended only for the local environment. As a localhost, use `database`.

### Docker Commands

#### Start Containers

**Development:**
```
docker-compose -f docker/development/docker-compose.yml -p serpixo-dev up --build
```
