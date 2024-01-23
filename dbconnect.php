<?php
$host = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$host;dbname=test", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?> 
