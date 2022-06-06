<?php

session_start();

$_SESSION['transferHotel_Name'] = $_POST['Hotel_Name'];

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


//RoomType Button
	echo "<h1>RoomTypes</h1>";
	echo "<form action='BookingInfo.php' method='post'>";	
	echo "<input type='submit' value='Roomtypes' name='Roomtypes'>";
	echo "</form>";
	
	echo "<br>";
	
//Agency Button	

echo "<h1>Agency</h1>";
echo "<form action='BookingInfo.php' method='post'>";	
	echo "<input type='submit' value='Agency' name='Agency'>";
	echo "</form>";
	
	echo "<br>";
	
//Agency Button	

$sql = "SELECT distinct(travelagents.TravelagentName)
            FROM BOOKING
			LEFT JOIN travelagents ON BOOKING.Travelagent_id = travelagents.Travelagent_id
			LEFT JOIN rooms ON BOOKING.roomnumber = rooms.roomnumber
			LEFT JOIN Hotels ON rooms.Hotel_Id = Hotels.Hotel_Id
            ";
    $sql .= "WHERE Hotels.HotelName = '" . $_SESSION['transferHotel_Name'] . "'";
	$result = mysqli_query($conn,$sql) or die("Error");

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    echo "<h1>Choose Agency</h1>";
		echo "<form action='BookingInfo.php' method='post'>";
		echo '<select name="chooseAgency">';
	    while($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["TravelagentName"] . "'>";
	        echo $row["TravelagentName"];
			echo "</option>";
	    }
		echo '</select>';
		echo '<input type="submit" value="Submit">';
		echo "</form>";
	} else {
	    echo "0 results";
	}
	
//Invoice Button	

echo "<h1>Invoice</h1>";
echo "<form action='part2-3.php' method='post'>";	
	echo "<input type='submit' value='Invoice' name='Invoice'>";
	echo "</form>";
	
	echo "<br>";

mysqli_close($conn);

?>
