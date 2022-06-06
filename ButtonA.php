<!DOCTYPE html>
<html>
<body>

<?php

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

$sql = "SELECT distinct(cityname) FROM DvC ";
$result = mysqli_query($conn,$sql) or die("Error");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    echo "<h1>Choose City</h1>";
	echo "<form action='FilterHotelsByCityDate.php' method='post'>";
	echo '<select name="city_Name">';
    while($row = mysqli_fetch_array($result)) {
		echo "<option value='" . $row["cityname"] . "'>";
        echo $row["cityname"];
		echo "</option>";
    }
	echo '<label for="date">Date:</label>';
	echo '<input type="date" name="check_in">';
	echo '<label for="date">Date:</label>';
	echo '<input type="date" name="check_out">';
	echo '</select>';
	echo '<input type="submit" value="Submit">';
	echo "</form>";
} else {
    echo "0 results";
}



	

mysqli_close($conn);

?>

</body>
</html>