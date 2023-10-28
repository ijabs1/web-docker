<?php
ob_start();
// Set sessions
if(!isset($_SESSION["loggedin"])) {
    session_start();
}
//These are the defined authentication environment in the db service
//server
// The MySQL service named in the docker-compose.yml.
$host = 'db';

// Database user name
$user = 'root';

//database user password
$pass = 'csym019';

// database name
$database = 'recipe_db';

// mysql connection string
$conn = new mysqli($host, $user, $pass, $database);

// check the MySQL connection status
$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySQL server successfully!";
}
?>