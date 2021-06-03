<?php
//include_once("db_connect.php");
include("connection.php");
$sqlEvents = "SELECT id, title,priority, start_date, end_date FROM events LIMIT 20";
$resultset = mysqli_query($con, $sqlEvents) or die("database error:". mysqli_error($conn));
$calendar = array();
while( $rows = mysqli_fetch_assoc($resultset) ) {	
	// convert  date to milliseconds
  /*  $priority = $rows['priority'];
    if($priority == "High")
    {

    }
    else{

    }*/
	$start = strtotime($rows['start_date']) * 1000;
	$end = strtotime($rows['end_date']) * 1000;	
	$calendar[] = array(
        'id' =>$rows['id'],
        'title' => $rows['title'],
        'prioriy'=> $rows['priority'],
        'url' => "#",
		"class" => 'event-important',
        'start' => "$start",
        'end' => "$end"
    );
}
$calendarData = array(
	"success" => 1,	
    "result"=>$calendar);
echo json_encode($calendarData);
exit;
?>