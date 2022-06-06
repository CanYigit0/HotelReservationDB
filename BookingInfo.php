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



if(isset($_REQUEST['Roomtypes'])){

$sql = "SELECT roomtypes.roomtype, COUNT(booking_id)
		FROM BOOKING
		LEFT JOIN rooms ON BOOKING.roomnumber = rooms.roomnumber
		LEFT JOIN roomtypes ON rooms.roomtype_id = roomtypes.roomtype_id
		LEFT JOIN Hotels ON rooms.Hotel_Id = Hotels.Hotel_Id
        WHERE Hotels.HotelName = '" . $_SESSION['transferHotel_Name'] . "'
        GROUP BY roomtypes.roomtype";

$result = mysqli_query($conn,$sql) or die("Error");


$data = array();

while($row = mysqli_fetch_array($result)){        
    $point = array("label" => $row['roomtype'] , "y" => $row['COUNT(booking_id)']);
    array_push($data, $point);        
}

$title = $_SESSION['transferHotel_Name'];

}

if(isset($_REQUEST['Agency'])){

$sql = "SELECT travelagents.TravelagentName,sum(roomtypes.price*DATEDIFF(BOOKING.checkout, BOOKING.checkin))
		FROM BOOKING
		LEFT JOIN rooms ON BOOKING.roomnumber = rooms.roomnumber
		LEFT JOIN roomtypes ON rooms.roomtype_id = roomtypes.roomtype_id
		LEFT JOIN Hotels ON rooms.Hotel_Id = Hotels.Hotel_Id
		LEFT JOIN travelagents ON BOOKING.Travelagent_id = travelagents.Travelagent_id
        WHERE Hotels.HotelName = '" . $_SESSION['transferHotel_Name'] . "'
        GROUP BY TravelagentName";

$result = mysqli_query($conn,$sql) or die("Error");


$data = array();

while($row = mysqli_fetch_array($result)){        
    $point = array("label" => $row['TravelagentName'] , "y" => $row['sum(roomtypes.price*DATEDIFF(BOOKING.checkout, BOOKING.checkin))']);
    array_push($data, $point);        
}

$title = $_SESSION['transferHotel_Name'];

}

if(isset($_REQUEST['chooseAgency'])){

$sql = "SELECT booking_id,bookingdate,checkin,checkout,BOOKING.roomnumber,travelagents.TravelagentName,Client.ClientName
		FROM BOOKING
		LEFT JOIN rooms ON BOOKING.roomnumber = rooms.roomnumber
		LEFT JOIN Hotels ON rooms.Hotel_Id = Hotels.Hotel_Id
		LEFT JOIN Client ON BOOKING.Client_id = Client.Client_id
		LEFT JOIN travelagents ON BOOKING.Travelagent_id = travelagents.Travelagent_id
        WHERE Hotels.HotelName = '" . $_SESSION['transferHotel_Name'] . "' AND travelagents.TravelagentName = '" . $_POST['chooseAgency'] . "'
        ";

$result = mysqli_query($conn,$sql) or die("Error");

$title = $_SESSION['transferHotel_Name'];

if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<table border='1'>";
        echo "<h1>" . $title . "</h1>";
        echo "<tr><td>Booking ID</td><td>Booking Date</td><td>Check-in Date</td><td>Check-in Date</td><td>Room No</td><td>Travel Agent Name</td><td>Client Name</td></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["booking_id"]. "</td><td>" . $row["bookingdate"]. "</td><td>" . $row["checkin"]. "</td><td>" . $row["checkout"] . "</td><td>" . $row["roomnumber"] . "</td><td>" . $row["TravelagentName"] . "</td><td>" . $row["ClientName"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

}

if(isset($_REQUEST['chooseClientName'])){

$sql = "SELECT booking_id,bookingdate,checkin,checkout,BOOKING.roomnumber,travelagents.TravelagentName,Client.ClientName,roomtypes.price*DATEDIFF(BOOKING.checkout, BOOKING.checkin)
		FROM BOOKING
		LEFT JOIN rooms ON BOOKING.roomnumber = rooms.roomnumber
		LEFT JOIN roomtypes ON rooms.roomtype_id = roomtypes.roomtype_id
		LEFT JOIN Hotels ON rooms.Hotel_Id = Hotels.Hotel_Id
		LEFT JOIN Client ON BOOKING.Client_id = Client.Client_id
		LEFT JOIN travelagents ON BOOKING.Travelagent_id = travelagents.Travelagent_id
        WHERE Hotels.HotelName = '" . $_SESSION['transferHotel_Name'] . "' AND CLIENT.ClientName = '" . $_POST['chooseClientName'] . "'
        ";

$result = mysqli_query($conn,$sql) or die("Error");

$title = $_SESSION['transferHotel_Name'];

if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<table border='1'>";
        echo "<h1>" . $title . "</h1>";
        echo "<tr><td>Booking ID</td><td>Booking Date</td><td>Check-in Date</td><td>Check-in Date</td><td>Room No</td><td>Travel Agent Name</td><td>Client Name</td><td>Cost Of Vacation</td></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["booking_id"]. "</td><td>" . $row["bookingdate"]. "</td><td>" . $row["checkin"]. "</td><td>" . $row["checkout"] . "</td><td>" . $row["roomnumber"] . "</td><td>" . $row["TravelagentName"] . "</td><td>" . $row["ClientName"] . "</td><td>" . $row["roomtypes.price*DATEDIFF(BOOKING.checkout, BOOKING.checkin)"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <html lang="en"> 
    <meta charset="UTF-8">
    <title></title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script type="text/javascript">
        window.onload = function () {
            var newTitle = "<?php echo $title ?>"; 
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title:{
                    text: newTitle   
                },
                axisY:{
                    title: "Number of Booked RoomTypes",
                    interval: 1000
                },
                data: [              
                {
                    type: "bar",
                    legendText: "{label}",
                    toolTipContent: "{label}: <strong>{y}</strong>",
                    indexLabelFontSize: 16,
                    //yValueFormatString: "฿#,##0",
                    dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
                }
            ]
            });
            chart.render();
        };
    </script>
</head>
<body>

    <div id="chartContainer" style="width: 100%; height: 700px;"></div>

</body>
</html>