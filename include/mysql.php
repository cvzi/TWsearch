<?php
// Verbinden mit MySQL
$sql_host = "";
$sql_user = "";
$sql_password = "";
$sql_database = "";


$db_link =  @mysql_connect($sql_host,$sql_user,$sql_password);
    if($db_link) {
        $debug['mysql'] = 1;
    } else {
        $debug['mysql'] = 0;
    }
// MySQL Datenbank auswählen
    if(mysql_select_db($sql_database, $db_link)) {
        $debug['mysqlDB'] = 1;
    } else {
        $debug['mysqlDB'] = 0;
    }
?>