# Symfony Docker Application

A fully dockerized Symfony 6.4 application with PostgreSQL database, Nginx web server, and Mailpit for email testing.

## Features

- **Symfony 6.4** - Modern PHP framework
- **PHP 8.1-FPM** - Fast and efficient PHP processor
- **PostgreSQL 16** - Reliable relational database
- **Nginx** - High-performance web server
- **Mailpit** - Email testing tool for development
- **Docker Compose** - Easy container orchestration
- **Doctrine ORM** - Database abstraction layer
- **KnpPaginatorBundle** - Pagination support

## Prerequisites

Before you begin, ensure you have the following installed:

- [Docker](https://docs.docker.com/get-docker/) (version 20.10 or higher)
- [Docker Compose](https://docs.docker.com/compose/install/) (version 2.0 or higher)

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd <project-directory>
```

### 2. Configure Environment Variables

Copy the example environment file and update the values:

```bash
cp .env.example .env
```

Edit `.env` and update these important values:

```env
APP_ENV=dev
APP_SECRET=your_random_secret_key_here
POSTGRES_PASSWORD=your_secure_password_here
```

**⚠️ Important:** Change `APP_SECRET` and `POSTGRES_PASSWORD` in production!

### 3. Create Required Directories

```bash
mkdir -p nginx
```

### 4. Build and Start Containers

```bash
# Build Docker images
docker-compose build

# Start all services in detached mode
docker-compose up -d
```

### 5. Install Dependencies

```bash
# Install Composer dependencies
docker-compose exec php composer install
```

### 6. Setup Database

```bash
# Create the database
docker-compose exec php php bin/console doctrine:database:create --if-not-exists

# Run migrations
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

# (Optional) Load fixtures for sample data
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

### 7. Clear Cache

```bash
docker-compose exec php php bin/console cache:clear
```

## Accessing the Application

Once everything is running, you can access:

- **Web Application**: [http://localhost](http://localhost)
- **Application Homepage**: [http://localhost/acceuil](http://localhost/acceuil)
- **Mailpit Interface**: [http://localhost:8025](http://localhost:8025)
- **PostgreSQL**: `localhost:5433` (from host machine)

### Database Connection Details

- **Host**: `localhost` (from host) or `database` (from containers)
- **Port**: `5433` (from host) or `5432` (from containers)
- **Database**: `app`
- **Username**: `app`
- **Password**: `!ChangeMe!` (or your configured password)

## Project Structure

```
.
├── config/              # Symfony configuration files
├── migrations/          # Database migrations
├── nginx/              
│   └── default.conf    # Nginx configuration
├── public/             # Public web directory
│   └── index.php       # Application entry point
├── src/
│   ├── Controller/     # Application controllers
│   ├── Entity/         # Doctrine entities
│   ├── Repository/     # Doctrine repositories
│   └── ...
├── templates/          # Twig templates
├── var/
│   ├── cache/          # Application cache
│   └── log/            # Application logs
├── vendor/             # Composer dependencies
├── .env                # Environment variables
├── .dockerignore       # Docker ignore file
├── composer.json       # PHP dependencies
├── docker-compose.yml  # Docker services configuration
├── Dockerfile          # PHP container configuration
└── README.md           # This file
```

## 🐛 Troubleshooting

### Port Already in Use

If you get a "port already allocated" error:

```bash
# For PostgreSQL (port 5432/5433)
sudo lsof -i :5432
# Stop the service using the port or change the port in docker-compose.yml

# For Nginx (port 80)
sudo lsof -i :80
# Stop the service or change the port mapping
```

## License

This project is licensed under the [MIT License](LICENSE).