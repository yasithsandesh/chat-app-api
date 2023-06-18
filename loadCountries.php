<?php

require "connection.php";

$countryTable =  Database::search("SELECT * FROM `country`");

$country_array = array();

for($x=0;$x<$countryTable->num_rows;$x++){
    $countryTableRow = $countryTable->fetch_assoc();
    array_push($country_array,$countryTableRow["name"]);
}

$json_text = json_encode($country_array);

echo($json_text);

?>