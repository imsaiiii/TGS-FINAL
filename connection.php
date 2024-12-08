 <?php

$servername = 'localhost';
$username = 'u350259501_thegoodshot';
$password = '8Njs?JKs>Dm';
$dbname = 'u350259501_tgs_inventory';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


    
?>