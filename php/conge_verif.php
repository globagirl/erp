<?php
    
	//Code vérifié
	include('../connexion/connexionDB.php');    
    $valeur = $_POST['valeur'];	
	$recherche=$_POST['recherche'];	    
    $dateD=$_POST['dateD'];
    $dateF=$_POST['dateF'];
	$nbr=$_POST['nbr'];	
    $year=strftime('%Y',strtotime($dateD));
   
    $sql2=mysql_query("select matricule from personnel_info where $recherche='$valeur'");
    $mat=mysql_result($sql2,0);
    $req=@mysql_query("select sum(nbrH) from personnel_conge where matricule='$mat' and dateD Like '$year%'");
	$tot=@mysql_result($req,0);
	
	//
	$nbrH=0;
	$dateX=$dateD;
    while($dateX <= $dateF){ 
        $D=strtotime($dateX);
        $D=strftime ( "%a",$D);
	    if($D != "Sun"){	      
	        $nbrH=$nbrH+8;
	      
	    }
	    $dateX=strtotime($dateX);
        $dateX=strtotime("+1 day",$dateX);
        $dateX=date("Y-m-d",$dateX);
	}
	$totH=($tot+$nbrH)-$nbr;
	//
	if($totH >= 168){
		$tot=$tot/8;
		echo $tot;
	}else{
      $req1=@mysql_query("select matricule,dateD from personnel_conge where matricule='$mat' and dateD='$dateD' and dateF='$dateF'");	
	  if(mysql_num_rows($req1)>0){
        echo '1';
      }else{
	    echo '0';
	  }
	}
	mysql_close();
?>