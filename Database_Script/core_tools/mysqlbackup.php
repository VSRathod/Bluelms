<?php

// Error reporting and ini settings
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database credentials
$dbUser = 'root';
$dbPass = '';
$dbName = 'moodle_lms';
$dbHost = 'localhost';

// Directories for schema and data

$schemaDir = 'c:\DB_BACKUP\schema';
$dataDir = 'c:/DB_BACKUP/data/';

// Configuration file path
$configFile = __DIR__ . '/my.cfg';

// Connect to the database
$cnn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$cnn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to handle SQL errors
function handleSqlError($cnn, $message = "") {
    $err = mysqli_error($cnn);
    echo "SQL Error: $message - $err" . PHP_EOL;
    exit;
}

// Function to execute SQL query and handle errors
function executeQuery($cnn, $sql, $errorMessage = "") {
    $result = mysqli_query($cnn, $sql);
    if (!$result) {
        handleSqlError($cnn, $errorMessage);
    }
    return $result;
}

// Function to export table schema
function exportSchema($cnn, $tableName, $schemaDir) {
    $sql = "SHOW CREATE TABLE `$tableName`";
    $result = executeQuery($cnn, $sql, "Error getting table schema for $tableName");
    $row = mysqli_fetch_assoc($result);
    $statement = end($row);
    $statement = preg_replace('/AUTO_INCREMENT=\d+ /', '', $statement);
    $path = "$schemaDir/{$tableName}.sql";
    file_put_contents($path, $statement);
}

// Function to export table data
function exportData($cnn, $tableName, $dataDir) {
    $path2 = "$dataDir/{$tableName}.sql";
    $sql = "SELECT * INTO OUTFILE '$path2' FROM `$tableName`";
    $result = executeQuery($cnn, $sql, "Error exporting data for $tableName");
}

// Loop through tables and export schema and data
$sql = 'SHOW TABLES';
$result = executeQuery($cnn, $sql, "Error retrieving tables");
while ($row = mysqli_fetch_row($result)) {
    $tableName = $row[0];
    exportSchema($cnn, $tableName, $schemaDir);
    exportData($cnn, $tableName, $dataDir);
}

// Close the database connection
mysqli_close($cnn);

// Remove the temporary configuration file
//unlink($configFile);

echo "Done!";
