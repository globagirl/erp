<?php
include('../connexion/connexionDB.php');
include("class/pData.class.php");
include("class/pDraw.class.php");
include("class/pImage.class.php");
include("class/pPie.class.php");
include("class/pIndicator.class.php");

// Je créer un nouvel objet contenant mes données pour le graphique 
 $MyData = new pData();
 $nbr_def=$_POST['nbrDef'];
 $DD=$_POST['date1'];
 $DF=$_POST['date2'];
/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/  
// jours un tableau qui contient les jours 
//$tableau = array();

$prod=0; 
while($DF>=$DD) 
{ 

$sql25 = mysql_query ("SELECT * FROM pro_emb WHERE date_debut LIKE '$DD%'");
//decoup

while($data25=@mysql_fetch_array($sql25)){
$qteS=$data25['qte_s'];
$prod=$prod+$qteS;
}

//$tableau[] = $nbr_def; 

//
$dateNext= strtotime($DD."+ 1 day");

$DD= date('Y-m-d', $dateNext);

} 
////
 $taux=($nbr_def*100)/$prod;
 $taux=round($taux,2);
 ///////////////
  $MyData = new pData();   
 
 $MyData->addPoints(array(1),"Limite (%)"); 
 $MyData->addPoints(array($taux),"Pourcentage des défauts (%) "); 

 $MyData->addPoints(array("",""),"Months"); 
 $MyData->setSerieDescription("Months","Month"); 
 $MyData->setAbscissa("Months"); 

 /* Create the pChart object */ 
 $myPicture = new pImage(700,230,$MyData); 

 /* Turn of Antialiasing */ 
 $myPicture->Antialias = FALSE; 
 /* Add a border to the picture */ 
 //$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100)); 
 //$myPicture->drawGradientArea(0,0,700,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20)); 
 $myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0)); 

 /* Set the default font */ 


 /* Define the chart area */ 
 $myPicture->setGraphArea(60,40,650,200); 

 /* Draw the scale */ 
 $scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode" => SCALE_MODE_START0); 
 $myPicture->drawScale($scaleSettings); 

 /* Write the chart legend */ 
 $myPicture->drawLegend(380,80,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
 
 ////
$myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
 $myPicture->drawText(290,25,"Pourcentage des défauts par semaine ",array("FontSize"=>17,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
 /* Turn on shadow computing */  


 /* Draw the chart */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
 $settings = array("DisplayValues"=>TRUE,"Surrounding"=>-20,"InnerSurrounding"=>30); 
 //$graph->drawScale(array("Mode" => SCALE_MODE_START0));
 $myPicture->drawBarChart($settings); 
 $file="img/Def1".$DF.".png";
 //unlink ($file);
 $randX=rand().rand(1,999);
 $myPicture->Render("img/Def1".$DF.".png");
 $myPicture->Render("img/x1".$randX."x1".$DF.".png");
 echo('<br><br><center><img src="../pChart/img/x1'.$randX.'x1'.$DF.'.png"  alt="Print" style="cursor:pointer;" width="900" height="450"  /></center>');
 mysql_close();
?>