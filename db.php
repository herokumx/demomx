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

$result = pg_query($dbconn, "SELECT * FROM users");
if (!$result) {
    echo "An error occurred.\n";
    exit;
}


echo "Fetch row: <br>";


while ($row = pg_fetch_row($result)) {
 print_r($row[1]);
}
?>