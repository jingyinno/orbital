<?php
include 'db_connection.php';

$conn = OpenCon();

$query="SELECT ALL FROM <DBNAME>";
$result=mysqli_query($conn, $query);

echo "Connected Successfully";

if(! $result ) {
	die('Could not get data: ' . mysql_error());
}
   
while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
	echo "Student ID :{$row[\userID\]}";
}

CloseCon($conn);

?>