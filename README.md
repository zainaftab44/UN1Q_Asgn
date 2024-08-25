This is a Laravel-based web application running in Docker containers using Nginx as the web server and PHP-FPM for PHP processing. The application is set up with CI/CD in mind, automatically running migrations and tests in test database upon updates.



### Build and start the Docker containers:

```bash

docker-compose up --build
```

**Access the application**:

    The application should now be accessible at `http://localhost:8000`.


    
## Docker Setup

### Building and Running Containers

- **Build the Docker containers**:

    ```bash
    docker-compose build
    ```

- **Start the Docker containers**:

    ```bash
    docker-compose up
    ```

- **Stop the Docker containers**:

    ```bash
    docker-compose down
    ```