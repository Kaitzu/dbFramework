<?php
include("./assets/php/db.php");
$data = array('field1' => 'data1', 'field2'=> 'data2');
insertArr("databaseName.tableName", $data);
?>