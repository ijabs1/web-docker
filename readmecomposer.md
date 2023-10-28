# Docker Compose Setup for PHP Web Application with MySQL and phpMyAdmin

This Docker Compose configuration sets up a development environment for a PHP web application, along with a MySQL database and phpMyAdmin for database management.

## Prerequisites

Before you begin, make sure you have the following installed on your system:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Usage

1. Clone this repository to your local machine:

   git clone <repository-url>

2. Navigate to the project directory:
 
     cd <project-directory>

3. Build and start the Docker containers:
 
     docker-compose up -d
4. Access the PHP web application in your web browser at http://localhost:8080.

5. Access phpMyAdmin for database management at http://localhost:8081. Use the following credentials:
    


 Configuration
* The PHP web application code should be placed in the src directory. It is mounted into the PHP container.
* The MySQL database is configured with the following credentials:
  
    * 

Stopping the Containers
To stop the containers, run the following command in the project directory:

docker-compose down
