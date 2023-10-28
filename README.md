# README for DockerFile#

# Dockerized PHP Web Application with MySQL Extension

This Docker setup allows you to run a PHP web application with MySQL extension support in a containerized environment. This README provides instructions on how to use this Docker image.

## Prerequisites

Before you begin, ensure that you have the following installed on your system:

- [Docker](https://docs.docker.com/get-docker/)

## Usage

1. **Clone the Repository:**

   Clone this repository to your local machine:

   git clone <repository-url>


Build the Docker Image:

Navigate to the directory containing the Dockerfile and run the following command to build the Docker image. This will create an image with PHP and the MySQL extension installed.

docker build -t my-app .

Run the Docker Container: Once the image is built, you can run a Docker container from it. Use the following command:

docker run -d -p 8080:8080 my-app

Access the PHP Web Application: Open a web browser and go to http://localhost:8080 to access your PHP web application running in the Docker container.

Stop the Docker Container: To stop the Docker container, you can use the following command:

Replace <container-id> with the ID of the running container, which you can find using docker ps.