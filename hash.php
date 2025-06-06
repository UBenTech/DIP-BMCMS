<?php
// hash.php - Hash a password using BCRYPT

$password = 'BenTech@#5428';

// Create a BCRYPT hash
$hash = password_hash($password, PASSWORD_BCRYPT);

// Display the result new
echo "Hashed password: " . $hash;
?>
