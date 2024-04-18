<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_STRICT);

define('CLI_SCRIPT', 1);

$currPath = dirname(dirname(__FILE__));

$dbHost = 'localhost';
$dbUser = $argv[2];
$dbPass = $argv[3];
$dbName = $argv[1];


$schemaDir = "{$currPath}/core_db/phoenix/schema";
$dataDir = "{$currPath}/core_db/phoenix/data";

$eol = PHP_EOL;

$cnn = mysqli_init();
mysqli_options($cnn, MYSQLI_OPT_LOCAL_INFILE, true);
mysqli_real_connect($cnn, $dbHost, $dbUser, $dbPass, $dbName);

// get current tables
echo $eol;
echo "Getting current existing tables in database `$dbName` $eol";

$sql = "SHOW TABLES";
$result = mysqli_query($cnn, $sql);
$currentTables = array();
while(($row = mysqli_fetch_assoc($result)))
{
   $tableName = current($row);
   $currentTables[$tableName] = $tableName;
}

$count = count($currentTables);
echo "Found $count existing tables in database `$dbName` $eol";

// create non existing tables
echo $eol . $eol;

echo "CREATING NON EXISTING TABLES... $eol";

echo $schemaDir ;

foreach(glob("$schemaDir/*.sql") as $item)
{
   $filename = pathinfo($item, PATHINFO_BASENAME);
   $exploded = explode('.', $filename);
   $tableName = current($exploded);

   echo "Creating table `$tableName`";

   if(0 == filesize($item))
   {
       echo "- Error. 0 bites file  $eol";
       continue;
   }

   if(!isset($currentTables[$tableName]))
   {
      $sql = file_get_contents($item);
      mysqli_query($cnn, $sql);

      echo "- Done $eol";
   }
   else
   {
      echo "Table `$tableName` already exists $eol";
   }
}
echo "CREATING NON EXISTING TABLES $eol";
echo $eol . $eol;


// truncate and restore data
echo "RESTORING DATA... $eol";

foreach(glob("$dataDir/*.sql") as $item)
{
   $item = str_replace('\\', '/', $item);

   $filename = pathinfo($item, PATHINFO_BASENAME);
   $exploded = explode('.', $filename);
   $tableName = current($exploded);

   echo "Truncate table $tableName... ";
   $sql = "TRUNCATE `$tableName`";
   mysqli_query($cnn, $sql);
   echo " - Done $eol";
   echo "Loading data into $tableName ...";
   if(0 == filesize($item))
   {
       echo " - No data found $eol";
       continue;
   }

   mysqli_options($cnn, MYSQLI_OPT_LOCAL_INFILE, true);
   $sql = "LOAD DATA LOCAL INFILE '$item' INTO TABLE `$tableName`";
   $result = mysqli_query($cnn, $sql);
   if(!$result)
   {
      echo $item;
      echo $eol;
      $err = mysqli_error($cnn);
      echo ("sql error 1 $err");
      echo PHP_EOL;
      exit;
   }

   echo " - Done $eol";
   echo $eol;
}
echo "DONE RESTORING DATA $eol";

