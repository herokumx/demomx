<?php 

$host = "ec2-107-20-223-116.compute-1.amazonaws.com";
$port = "5432";
$dbname = "d31r0cgdueumjf";
$user = "uqphasfcijtgrg";
$password = "lCwnoVxA3zJgIhomgB6mq9Xsqt";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";
$db = pg_connect($connection_string);


if($db){
    echo "Connected to ". pg_host($dbconn); 
}else{
    echo "Error in connecting to database.";
}

echo "<br />";


$statement = $db->prepare("SELECT * FROM questions");
$statement->execute( array(18) );
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
$personsTable = "";
if(count($rows) > 0)
{
    $table = new View_Generator_Table( array("question","question_type","id") );
    foreach($rows as $row)
    {
        $table->addCell( $row["question"] );
        $table->addCell( $row["question_type"] );
        $table->addCell( $row["id"] );
    }
    $personsTable = $table->generate();
}
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>An example with a table</title>
</head>
<body>
RANDOM
    <br />
    <?=$personsTable?>
</body>
</html>
<?php
    /**
     * A very simple view component generator for tables 
     */
    class View_Generator_Table
    {
        private $headers = array();
        private $cells = array();
        /**
         * Array of the table headers
         * @param array of strings $headers
         */
        public function __construct($headers)
        {
            $this->headers = $headers;
        }
        /**
         * Adds a cell to the table
         * @param string $cell
         */
        public function addCell($cell = "")
        {
            $this->cells[] = $cell;
        }
        /**
         * Generates and returns the table html in a  string
         * @return string
         */
        public function generate()
        {
            $re = "";
            $columns = count($this->headers);
            if($columns  > 0)
            {
                $re .= "<table><thead><tr>";
                // Adding the headers
                foreach($this->headers as $header)
                {
                    $re .= "<th>".$header."</th>";
                }
                $re .= "</thead></tr>";
                $totalCells = count($this->cells);
                if($totalCells > 0)
                {
                    // Adding the data cells 
                    $re .= "<tbody>";
                    for($i=0;  $i < $totalCells; $i++)
                    {
                        $currentColumn = $i % $columns;
                        if($currentColumn == 0)
                        {
                            $re .= "<tr>";
                        }
                        $re .= "<td>".$this->cells[$i]."</td>";
                        if($currentColumn == $columns - 1)
                        {
                            $re .= "</tr>";
                        }
                    }
                    // If there the number of the cells don't much the number of the 
                    // columns then we add some empty cells 
                    if($currentColumn !== $columns - 1)
                    {
                        for($i = $currentColumn ;  $i < $columns - 1; $i++)
                        {
                            $re .= "<td></td>";
                        }
                        $re .= "</tr>";
                    }
                    $re .= "</tbody>";
                }
                $re .= "</table>";
            }
            return $re;
        }
    }
?>