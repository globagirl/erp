<?php
include('../connexion/connexionDB.php');
//Je charge les librairies de pChart qui se trouve dans le dossier class pour qu'il puisse afficher un graphique
include("class/pData.class.php");
include("class/pDraw.class.php");
include("class/pImage.class.php");
include("class/pPie.class.php");
include("class/pIndicator.class.php");

// Je créer un nouvel objet contenant mes données pour le graphique 
 $MyData = new pData();
 $DD=$_POST['date1'];
 $DF=$_POST['date2'];
/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/  
// jours un tableau qui contient les jours 

$def_long=0;
$def_denud=0;
$def_emplacement=0;
$def_dist_pair=0;
$def_long_pair=0;
$def_acc_manq=0;
$def_qual=0;
$def_court_cir=0;
$def_cont=0;
$def_pair_inv=0;
while($DF>=$DD) 
{ 

$sql21 = mysql_query ("SELECT * FROM decoup WHERE date_debut LIKE '$DD%'");
//$sql22 = mysql_query ("SELECT * FROM pro_assem WHERE date_debut LIKE '$DD%'");
$sql23 = mysql_query ("SELECT * FROM pro_sertiss WHERE date_debut LIKE '$DD%'");
$sql24 = mysql_query ("SELECT * FROM pro_test_pol WHERE date_debut LIKE '$DD%'");
$sql25 = mysql_query ("SELECT * FROM pro_emb WHERE date_debut LIKE '$DD%'");


//decoup
while($data21=@mysql_fetch_array($sql21)){
$def_long=$def_long+$data21['def_long'];
$def_denud=$def_denud+$data21['def_den'];

}
//assemblage
/*
while($data22=@mysql_fetch_array($sql22)){
$def_emplacement=$def_emplacement+$data22['emp_cmp'];
$def_dist_pair=$def_dist_pair+$data22['dist_p'];
$def_denud=$def_denud+$data22['denud'];
$def_long_pair=$def_long_pair+$data22['long_p'];
$def_acc_manq=$def_acc_manq+$data22['acc_mqt'];

}
*/
//sertissage
while($data23=@mysql_fetch_array($sql23)){
$long_pair=$data23['long_pair'];
$def_long_pair=$def_long_pair+$long_pair;
$def_qual=$def_qual+$data23['prod_s']+$data23['sh_end']+$data23['boots_end']+$data23['ang_pl_end']+$data23['pin_end']+$data23['cable_r'];

}
//Test pol
while($data24=@mysql_fetch_array($sql24)){
$qlty=$data24['qlty'];
$def_qual=$def_qual+$qlty;
$def_court_cir=$def_court_cir+$data24['p_cc'];
$def_cont=$def_cont+$data24['cntn'];
$def_pair_inv=$def_pair_inv+$data24['p_inv'];

}
//emballage
/*
while($data25=@mysql_fetch_array($sql25)){
$qteE=$data25['qte_e'];
$qteS=$data25['qte_s'];
$prod=$prod+$qteS;
$qty=$qteE-$qteS;
$nbr_def=$nbr_def+$qty;
}
*/

$dateNext= strtotime($DD."+ 1 day");

$DD= date('Y-m-d', $dateNext);

} 
////
 $MyData = new pData(); 
$MyData->addPoints(array($def_emplacement,$def_dist_pair,$def_long_pair,$def_acc_manq,$def_qual,$def_court_cir,$def_cont,$def_pair_inv,$def_long,$def_denud),"Series");


/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/

 $MyData->addPoints(array("Emplacement des composants","Distribution des paires","Longueur paire","Accesoire manquant","Défauts qualité","Paire courcircuité","Continuité","Paire inversé","Longueur cable","Denudage"),"Labels");
 $MyData->setSerieDescription("Labels");


 /* Define the absissa serie */ 

 $MyData->setAbscissa("Labels"); 
 $myPicture = new pImage(700,230,$MyData); 

 /* Draw a solid background */ 
 
 //$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237); 
 $Settings = array("R"=>245, "G"=>240, "B"=>240); 
 $myPicture->drawFilledRectangle(0,0,700,230,$Settings); 

 /* Draw a gradient overlay */ 
 
 $Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>111, "EndG"=>3, "EndB"=>255, "Alpha"=>50); 
 //$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$Settings); 
 //$myPicture->drawGradientArea(0,0,700,32,DIRECTION_VERTICAL,array("StartR"=>255,"StartG"=>255,"StartB"=>255,"EndR"=>50,"EndG"=>50,"EndB"=>20,"Alpha"=>100)); 

 
/* J'indique le titre de mon graphique, son positionnement sur l'image et sa police */ 
$myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
 //$myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11,"R"=>80,"G"=>80,"B"=>80));
 $myPicture->drawText(200,25,"Pourcentage de chaque défaut",array("FontSize"=>17,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
 /* Create the pPie object */  
 $PieChart = new pPie($myPicture,$MyData); 


 /* Draw a splitted pie chart */  
 $PieChart->draw2DPie(160,120,array("WriteValues"=>PIE_VALUE_PERCENTAGE,"DataGapAngle"=>10,"DataGapRadius"=>10,"Border"=>TRUE,"BorderR"=>201,"BorderG"=>201,"BorderB"=>201,"FontSize"=>11,"R"=>80,"G"=>80,"B"=>80)); 
 //$PieChart->draw2DPie(190,160,array("WriteValues"=>PIE_VALUE_PERCENTAGE,"Radius"=>70,"DrawLabels"=>TRUE,"LabelStacked"=>TRUE,"Border"=>TRUE));
 $myPicture->setShadow(FALSE); 
 $PieChart->drawPieLegend(405,50,array("Alpha"=>20)); 

 $myPicture->Render("img/D2".$DF.".png");
  echo('<br><br><center><img src="../pChart/img/D2'.$DF.'.png"  alt="Print" style="cursor:pointer;" width="900" height="450"  /></center>');
  mysql_close();
?>