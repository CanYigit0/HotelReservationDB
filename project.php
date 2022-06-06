<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "can_yigit";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

mysqli_query($conn, "DROP DATABASE IF EXISTS can_yigit");
mysqli_query($conn, "CREATE DATABASE can_yigit");


// Creating Tables

$dvc = "CREATE TABLE IF NOT EXISTS DvC (
city_id INT,
cityname VARCHAR(30) NOT NULL,
district_Id INT,
districtname VARCHAR(30) NOT NULL,
PRIMARY KEY (city_id)
)ENGINE=InnoDB;";


$hotel = "CREATE TABLE IF NOT EXISTS Hotels (
city_id int,
Hotel_Id int NOT NULL AUTO_INCREMENT,
HotelName VARCHAR(30) NOT NULL,
Facilitie_id int(11) NOT NULL,
PRIMARY KEY (Hotel_Id),
FOREIGN KEY(city_id) REFERENCES DvC(city_id),
FOREIGN KEY(Facilitie_id) REFERENCES FACILITIES(Facilitie_id)
)ENGINE=InnoDB;";


$client = "CREATE TABLE IF NOT EXISTS CLIENT (
Client_id int NOT NULL AUTO_INCREMENT,
ClientName VARCHAR(50) NOT NULL,
PRIMARY KEY(Client_id)
)ENGINE=InnoDB;";


$facilities = "CREATE TABLE IF NOT EXISTS FACILITIES (
Facilitie_id int(11) NOT NULL AUTO_INCREMENT,
FacilitieName VARCHAR(50) NOT NULL,
PRIMARY KEY(Facilitie_id)
)ENGINE=InnoDB;";


$travelagent = "CREATE TABLE IF NOT EXISTS TRAVELAGENTS (
Travelagent_id int(11) NOT NULL,
TravelagentName VARCHAR(50) NOT NULL,
PRIMARY KEY(Travelagent_id)
)ENGINE=InnoDB;";


$room = "CREATE TABLE IF NOT EXISTS ROOMS (
Hotel_Id int NOT NULL,
roomnumber int(11) NOT NULL AUTO_INCREMENT,
roomtype_id int(11) NOT NULL,
PRIMARY KEY (roomnumber),
FOREIGN KEY(Hotel_Id) REFERENCES Hotels(Hotel_Id),
FOREIGN KEY(roomtype_id) REFERENCES ROOMTYPES(roomtype_id)
)ENGINE=InnoDB;";


$roomtype = "CREATE TABLE IF NOT EXISTS ROOMTYPES (
roomtype_id int(11) NOT NULL,
roomtype VARCHAR(30) NOT NULL,
price int(11) NOT NULL,
PRIMARY KEY (roomtype_id)
)ENGINE=InnoDB;";


$booking = "CREATE TABLE IF NOT EXISTS BOOKING (
booking_id int(11) NOT NULL AUTO_INCREMENT,
bookingdate date,
checkin date,
checkout date,
roomnumber int(11) NOT NULL,
Travelagent_id int(11) NOT NULL,
Client_id int(11) NOT NULL,
PRIMARY KEY (booking_id),
FOREIGN KEY(roomnumber) REFERENCES ROOMS(roomnumber),
FOREIGN KEY(Travelagent_id) REFERENCES TRAVELAGENTS(Travelagent_id),
FOREIGN KEY(Client_id) REFERENCES CLIENT(Client_id)
)ENGINE=InnoDB;";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_query($conn, $dvc);
mysqli_query($conn, $facilities);
mysqli_query($conn, $hotel);
mysqli_query($conn, $client);		
mysqli_query($conn, $travelagent);	
mysqli_query($conn, $roomtype);	
mysqli_query($conn, $room);	
if(mysqli_query($conn, $booking)){
				} else{
					echo "ERROR: Could not able to execute $booking. " . mysqli_error($conn);
				}	

// District and Cities

$row = 0;
$filename = "DvC.csv";



if(!file_exists($filename) || !is_readable($filename))
		return FALSE;
	
	$header = NULL;
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
				$sql ="INSERT INTO DvC VALUES ($row[0],'$row[1]',$row[2],'$row[3]')";
				if(mysqli_query($conn, $sql)){
				} else{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				}
			}
		}
		echo "Records inserted successfully.";
		fclose($handle);
	}

//FACILITIES


$sql ="INSERT INTO FACILITIES (FacilitieName) VALUES ('Swimming Pool'),('Parking Lot'),('Spa'),('Gym'),('Conference Center')";
	if(mysqli_query($conn, $sql)){
		echo "Records inserted successfully.";
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
	}	

// Hotels

$HotelNameArray = array("a","Hilton","Rixos","Divan","Dedeman","Marriott","Wyndham","Voyage","Anemon","Crystal","Barut");
$numbers = range(1, 10);
for($i=1; $i<=81; $i++){
	shuffle($numbers);
	for($j=0; $j<5; $j++){
		$f = rand(1, 5);
		$a = $numbers[$j];
		$sql ="INSERT INTO Hotels(city_id,HotelName,Facilitie_id) VALUES ($i,'$HotelNameArray[$a]',$f)";
		if(mysqli_query($conn, $sql)){
				} else{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				}
	}
}	
//CLIENT
	
//Names	

$nameArray = [];
$row = 0;
$filename = "Names.csv";

if(!file_exists($filename) || !is_readable($filename))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename, 'r')) !== FALSE)
{
	//echo '<table border=1>';
	//echo '<tr><td>Name</td><tr/>';
	while (($row = fgetcsv($handle, 100000, ';')) !== FALSE)
	{
		//echo '<tr><td>'.$row[0].'</td><tr/>';
		array_push($nameArray,"$row[0]");

	}
	echo '</table>';
	fclose($handle);
}

//Surnames

$surnameArray = [];
$row = 0;
$filename = "Surnames.csv";

if(!file_exists($filename) || !is_readable($filename))
	return FALSE;

$header = NULL;
if (($handle = fopen($filename, 'r')) !== FALSE)
{
	//echo '<table border=1>';
	//echo '<tr><td>Surname</td><tr/>';
	while (($row = fgetcsv($handle, 100000, ';')) !== FALSE)
	{
		//echo '<tr><td>'.$row[0].'</td><tr/>';
		array_push($surnameArray,"$row[0]");
	}
	echo '</table>';
	fclose($handle);
}


for($i=0; $i<1620; $i++){

	$a = rand(0, 499);
	$b = rand(0, 499);

	$first_name = $nameArray[$a];
	$last_name = $surnameArray[$b];

	$fullName[$i] = $first_name . ' ' . $last_name;
}

for($i=0;$i<1620;$i++){
		$sql = "INSERT INTO CLIENT (ClientName) VALUES ('$fullName[$i]');";
		mysqli_query($conn, $sql);

}

	
//TRAVELAGENTS

$row = 0;
$filename = "Travelagents.csv";



if(!file_exists($filename) || !is_readable($filename))
		return FALSE;
	
	$header = NULL;
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
				$sql ="INSERT INTO TRAVELAGENTS VALUES ($row[0],'$row[1]')";
				if(mysqli_query($conn, $sql)){
				} else{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				}
			}
		}
		echo "Records inserted successfully.";
		fclose($handle);
	}

//ROOMTYPE

$row = 0;
$filename = "RoomTypes.csv";



if(!file_exists($filename) || !is_readable($filename))
		return FALSE;
	
	$header = NULL;
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
				$sql ="INSERT INTO ROOMTYPES VALUES ($row[0],'$row[1]',$row[2])";
				if(mysqli_query($conn, $sql)){
				} else{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				}
			}
		}
		echo "Records inserted successfully.";
		fclose($handle);
	}


//ROOMS
for($i=1;$i<406;$i++){
$row = 0;
$filename = "Rooms.csv";


if(!file_exists($filename) || !is_readable($filename))
		return FALSE;
	
	$header = NULL;
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
			while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
			{
				if(!$header)
					$header = $row;
				else{
					$sql ="INSERT INTO ROOMS(Hotel_Id,roomtype_id) VALUES ($i,$row[1])";
					if(mysqli_query($conn, $sql)){
					} else{
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
			}
		}
		fclose($handle);
	}
echo "Records inserted successfully.";

//BOOKING



for($i=1; $i<=1620; $i++){
		$int= mt_rand(1641016367,1672379567);
		$ta = mt_rand(1,10);
		$rn = mt_rand(1,12150);
		$date1 = date('Y-m-d',$int);
		$date2 = date('Y-m-d', strtotime($date1. ' + 10 days'));
		$date3 = date('Y-m-d', strtotime($date2. ' + 7 days'));
		$sql ="INSERT INTO BOOKING(bookingdate,checkin,checkout,roomnumber,Travelagent_id ,Client_id) VALUES ('$date1','$date2','$date3',$rn,$ta,$i)";
		if(mysqli_query($conn, $sql)){
				} else{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				}
}



	mysqli_close($conn);
?>