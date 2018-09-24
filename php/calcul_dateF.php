<?php
    $dateM1=$_POST['dateM1'];
    $dateM1= strtotime($dateM1);
    $dateM2= strtotime("next month",$dateM1);
    $dateM2=strtotime("-1 day",$dateM2);
    $dateM2=date("Y-m-d",$dateM2);
	echo $dateM2;
?>