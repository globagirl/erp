<?php
    $dateM1=$_POST['dateM1'];
    $dateM1= strtotime($dateM1);
  
    $dateM1=date("Y-m-d",$dateM1);
	echo $dateM1;
?>