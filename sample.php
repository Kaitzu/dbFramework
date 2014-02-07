<?php
// Insert data to db test
include("./assets/db.php");
$data = array('field1' => 'data1', 'field2'=> 'data2');
$id = insertArr("dbFramework.test", $data);

echo "Item id: " . $id . " inserted to the database";

// Update data where id is 1 AND field1 is data1 test
$data = array('field1' => 'data3', 'field2'=> 'data4');
$conditions = array('id' => '2', 'field1' => 'data1');
updateArr("dbFramework.test", $data, $conditions);

?>