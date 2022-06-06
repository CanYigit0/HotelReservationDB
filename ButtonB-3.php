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

//Agency Button	

$sql = "SELECT distinct(CLIENT.ClientName)
            FROM BOOKING
			LEFT JOIN rooms ON BOOKING.roomnumber = rooms.roomnumber
			LEFT JOIN Hotels ON rooms.Hotel_Id = Hotels.Hotel_Id
			LEFT JOIN Client ON BOOKING.Client_id = Client.Client_id
            ";
    $sql .= "WHERE Hotels.HotelName = '" . $_SESSION['transferHotel_Name'] . "'";
	$result = mysqli_query($conn,$sql) or die("Error");

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    echo "<h1>Choose Client Name</h1>";
		echo "<form action='BookingInfo.php' method='post'>";
		echo '<select name="chooseClientName">';
	    while($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["ClientName"] . "'>";
	        echo $row["ClientName"];
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