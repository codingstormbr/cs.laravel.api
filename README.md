# CS LARAVEL - Laravel 11.x #

## Sobre CS LARAVEL API

Este projeto é desenvolvido e mantido por Coding Storm.

### Stack utilizada

- PHP
- Laravel
- Nginx
- Docker

### Ambiente de desenvolvimento

- Instale o Docker no Ubuntu LTS, podendo utilizá-lo no WSL (Windows Subsystem for Linux) com Ubuntu LTS, em uma máquina virtual com Ubuntu ou diretamente em um servidor Ubuntu.

### Construindo container

Criar rede padrao no docker.

```bash
sudo docker network create --subnet=192.168.10.0/24 enetwork
```

Criando containers

```bash
sudo docker compose up -d
```

Concedendo permissão localmente

```bash
sudo chmod -R 777 .
```

### Configurando aplicação

Copie o arquivo .env para o ambiente que está implantando (Desenvolvimento, Homologação ou Produção).

DEV

```bash
cp src/.env.dev src/.env
```

HML

```bash
cp src/.env.hml src/.env
```

PRD

```bash
cp src/.env.prd src/.env
```

Instalando as dependências do Laravel

```bash
sudo docker exec -it cs.laravel.api.php bash -c "composer install"
```

Atualize as variáveis de ambiente no arquivo .env

```dotenv
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=my_database
DB_USERNAME=my_user
DB_PASSWORD=my_password
```


## Autores

- [Paulo Teixeira](https://codingstorm.com.br/biografia)# CS LARAVEL - Laravel 11.x #

## Sobre CS LARAVEL API

Este projeto é desenvolvido e mantido por Coding Storm.

### Stack utilizada

- PHP
- Laravel
- Nginx
- Docker

### Ambiente de desenvolvimento

- Instale o Docker no Ubuntu LTS, podendo utilizá-lo no WSL (Windows Subsystem for Linux) com Ubuntu LTS, em uma máquina virtual ou diretamente em um servidor.

### Construindo container

Criar rede padrao no docker.

```bash
sudo docker network create --subnet=192.168.10.0/24 enetwork
```

Criando containers

```bash
sudo docker compose up -d
```

Concedendo permissão localmente

```bash
sudo chmod -R 777 .
```

### Configurando aplicação

Copie o arquivo .env para o ambiente que está implantando (Desenvolvimento, Homologação ou Produção).

DEV

```bash
cp src/.env.dev src/.env
```

HML

```bash
cp src/.env.hml src/.env
```

PRD

```bash
cp src/.env.prd src/.env
```

Instalando as dependências do Laravel

```bash
sudo docker exec -it cs.laravel.api.php bash -c "composer install"
```

Atualize as variáveis de ambiente no arquivo .env

```dotenv
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=my_database
DB_USERNAME=my_user
DB_PASSWORD=my_password
```


## Autores

- [Paulo Teixeira](https://codingstorm.com.br/biografia)