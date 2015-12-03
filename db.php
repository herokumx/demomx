<?php 

$host = "ec2-107-20-223-116.compute-1.amazonaws.com";
$port = "5432";
$dbname = "d31r0cgdueumjf";
$user = "uqphasfcijtgrg";
$password = "lCwnoVxA3zJgIhomgB6mq9Xsqt";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";
$dbconn = pg_connect($connection_string);


if($dbconn){
    echo "Connected to ". pg_host($dbconn); 
}else{
    echo "Error in connecting to database.";
}

echo "<br />";

require_once 'index.php';

$result = pg_query($dbconn, "SELECT * FROM users");
if (!$result) {
    echo "An error occurred.\n";
    exit;
}

$arr = pg_fetch_all($result);

echo "<pre>";
print_r($arr);
echo "</pre>";
?>