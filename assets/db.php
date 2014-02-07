<?php
/**
 * Thanks to circuitry http://stackoverflow.com/questions/10054633/insert-array-into-mysql-database-with-php
 * 
 * The MIT License (MIT)
 * Copyright (c) 2014 Werraton Consulting
 *
 * Class to initiate a new MySQL connection based on $dbInfo settings found in dbSettings.php
 *
 * @example
 *    $db = new database(); // Initiate a new database connection
 *    mysql_close($db->get_link());
 */

class database{
    protected $databaseLink;
    function __construct(){
        include "dbSettings.php";
        $this->database = $dbInfo['host'];
        $this->mysql_user = $dbInfo['user'];
        $this->mysql_pass = $dbInfo['pass'];
        $this->openConnection();
        return $this->get_link();
    }
    function openConnection(){
    $this->databaseLink = mysql_connect($this->database, $this->mysql_user, $this->mysql_pass);
    }

    function get_link(){
    return $this->databaseLink;
    }
}

/**
 * Insert an associative array into a MySQL database
 *
 * @example
 *    $data = array('field1' => 'data1', 'field2'=> 'data2');
 *    insertArr("databaseName.tableName", $data);
 */
function insertArr($tableName, $insData){
    $db = new database();
    
    $columns = implode(", ",array_keys($insData));
    $escaped_values = array_map('mysql_real_escape_string', array_values($insData));
    foreach ($escaped_values as $idx=>$data) $escaped_values[$idx] = "'".$data."'";
    $values  = implode(", ", $escaped_values);
    
    $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
    
    // For debug uncomment echo statement
    // echo $query . "<br>";
    
    mysql_query($query) or die(mysql_error());
    
    // Get last id for geneal purposes
    $id = mysql_insert_id();
    mysql_close($db->get_link());
    
    // Return last id for future usage
    return $id;
}

/**
 * Update an associative array with conditions into a MySQL database
 *
 * @example
 *    $data = array('field1' => 'data1', 'field2'=> 'data2');
 *    $conditions = array('key1' => 'id1', 'key2' => 'id2');
 *    updateArr("tableName", $data, $conditions);
 */
function updateArr($tableName, $insData, $conditions = array()) {
    $db = new database();
    
    $valueStrings = array();
    foreach ($insData as $name => $value) {
        $valueStrings[] = $name . " = '" . $value . "'";
    }
    $conditionStrings = array();
    foreach ($conditions as $column => $value) {
        $conditionString = $column;
        $conditionString .= is_array($value)
            ? ("IN ('" . implode("','", $value) . "')")
            : (" = '" . $value . "'")
        ;
        $conditionStrings[] = $conditionString;
    }
    $query  = 'UPDATE ' . $tableName
        . ' SET ' . implode(', ', $valueStrings)
        . ' WHERE ' . implode(' AND ', $conditionStrings)
    ;
    
    // For debug uncomment echo statement
    // echo $query . "<br>";
    
    mysql_query($query) or die(mysql_error());
    mysql_close($db->get_link());
}
?>