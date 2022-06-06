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
$date1 = $_POST['check_in'];
$date2 = $_POST['check_out'];

$sql = "SELECT Hotels.HotelName, COUNT(BOOKING.booking_id)
		FROM BOOKING
		LEFT JOIN rooms ON BOOKING.roomnumber = rooms.roomnumber
		LEFT JOIN Hotels ON rooms.Hotel_Id = Hotels.Hotel_Id
		LEFT JOIN DvC ON Hotels.city_id = DvC.city_id
		";
$sql .= "WHERE DvC.cityname = '" . $_POST['city_Name'] . "' AND BOOKING.checkin >= '$date1' AND BOOKING.checkout <= '$date2'";
$sql .= "GROUP BY Hotels.HotelName";

$result = mysqli_query($conn,$sql) or die("Error");


$data_hotels = array();

while($row = mysqli_fetch_array($result)){        
    $point = array("label" => $row['HotelName'] , "y" => $row['COUNT(BOOKING.booking_id)']);
    array_push($data_hotels, $point);        
}

$title = $_POST['city_Name'];



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
                    title: "Number of Booked Room",
                    interval: 1
                },
                data: [              
                {
                    type: "bar",
                    legendText: "{label}",
                    toolTipContent: "{label}: <strong>{y}</strong>",
                    indexLabelFontSize: 16,
                    //yValueFormatString: "฿#,##0",
                    dataPoints: <?php echo json_encode($data_hotels, JSON_NUMERIC_CHECK); ?>
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