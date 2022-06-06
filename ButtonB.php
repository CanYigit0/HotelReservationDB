<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "can_yigit";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

$sql = "SELECT distinct(HotelName) FROM Hotels ";
	$result = mysqli_query($conn,$sql) or die("Error");

	if (mysqli_num_rows($result) > 0) {
	    echo "<h1>Choose Hotel</h1>";
		echo "<form action='ButtonB-2.php' method='post'>";
		echo '<select name="Hotel_Name">';
	    while($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["HotelName"] . "'>";
	        echo $row["HotelName"];
			echo "</option>";
	    }
		echo '</select>';
		echo '<input type="submit" value="Submit">';
		echo "</form>";
	} else {
	    echo "0 results";
	}

	

mysqli_close($conn);

?>