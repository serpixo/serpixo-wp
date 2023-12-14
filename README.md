# serpixo WordPress Main Structure

## General

If you want to install the project, you must first create a copy of `.env.example` and `auth.json.example` and rename them to `.env` and `auth.json`. Then use can put credentials into those files and start with `composer install`.

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

**Production:**
```
docker-compose -p serpixo-prod up --build
```

#### Open Bash in Containers

```
docker exec -it [name of container] bash
```

#### Logs from Containers

```
docker logs [name of container]
```

#### Backup Database

```
docker exec [name of container] /usr/bin/mysqldump -u wordpress --password=wordpress wordpress > backup.sql
```

#### Restore Database

```
cat backup.sql | docker exec -i [name of container] /usr/bin/mysql -u wordpress --password=wordpress wordpress
```
