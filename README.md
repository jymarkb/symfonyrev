# symfonyrev
symfony 7 review

how to run the application `composer docker`

start clean image/data `docker-compose down -v`

## use `command.sh` for docker container

create database: `./command.sh doctrine:database:create`

update database scheme: `./command make:migration`

populate database with sample data: `./command.sh doctrine:migration:migrate`
