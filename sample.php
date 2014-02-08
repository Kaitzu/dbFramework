<?php
// Insert data to db

include("./assets/db.php");
$data = array('field1' => 'data1', 'field2'=> 'data2');
$id = insertArr("dbFramework.test", $data);

echo $id;

// Update data where id is 1 AND field1 is data1

$data = array('field1' => 'data3', 'field2'=> 'data4');
$conditions = array('id' => '1', 'field1' => 'data1');
updateArr("dbFramework.test", $data, $conditions);

// Update data where id is 2 test

$data = array('field1' => 'data3single', 'field2'=> 'data4single');
$conditions = array('id' => '2');
updateArr("dbFramework.test", $data, $conditions);

// Get field1 data where id 1

$query = "id = '1'";
$result = selectArr("dbFramework.test", $query);
$row = mysql_fetch_assoc($result);

echo $row['field1'];

// Get row data where id is 1

$conditions = "id = '1' ORDER BY `id` DESC";
$result = selectArr("dbFramework.test", $conditions);
$row = mysql_fetch_assoc($result);

foreach ( $row as $value ) echo $value;

// Get all id's where field1 value is data1

$conditions = "field1 = 'data1' ORDER BY `id` DESC";
$result = selectArr("dbFramework.test", $conditions);

while ( $row = mysql_fetch_assoc($result) ) echo $row['id']; 

// Get all
unset($conditions);
$result = selectArr("dbFramework.test", $conditions);
$row = mysql_fetch_assoc($result);

while ( $row = mysql_fetch_assoc($result) ) echo $row['field2'];

?>