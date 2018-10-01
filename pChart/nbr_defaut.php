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
$DF=$_POST['date2'];
$J1=$_POST['J1'];

$J2=@$_POST['J2'];
$J3=@$_POST['J3'];
$J4=@$_POST['J4'];
$J5=@$_POST['J5'];
$J6=@$_POST['J6'];

/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/
// jours un tableau qui contient les jours
$tableau = array();
$tableau[] = $J1;
$tableau[] = $J2;
$tableau[] = $J3;
$tableau[] = $J4;
$tableau[] = $J5;
$tableau[] = $J6;
/*while($J)
{
$nbr_def=0;
$sql21 = mysql_query ("SELECT * FROM decoup WHERE date_debut LIKE '$DD%'");
$sql22 = mysql_query ("SELECT * FROM pro_assem WHERE date_debut LIKE '$DD%'");
$sql23 = mysql_query ("SELECT * FROM pro_sertiss WHERE date_debut LIKE '$DD%'");
$sql24 = mysql_query ("SELECT * FROM pro_test_pol WHERE date_debut LIKE '$DD%'");
$sql25 = mysql_query ("SELECT * FROM pro_emb WHERE date_debut LIKE '$DD%'");
//decoup
while($data21=@mysql_fetch_array($sql21)){
$qte21=$data21['q_reb'];
$nbr_def=$nbr_def+$qte21;
}
//assemblage
while($data22=@mysql_fetch_array($sql22)){
$qte22=$data22['nbr_def'];
$nbr_def=$nbr_def+$qte22;
}
//sertissage
while($data23=@mysql_fetch_array($sql23)){
$qte23=$data23['nbr_def'];
$nbr_def=$nbr_def+$qte23;
}
//Test pol
while($data24=@mysql_fetch_array($sql24)){
$qte24=$data24['nbr_def'];
$nbr_def=$nbr_def+$qte24;
}
//emballage

while($data25=@mysql_fetch_array($sql25)){
$qteE=$data25['qte_e'];
$qteS=$data25['qte_s'];
$qty=$qteE-$qteS;
$nbr_def=$nbr_def+$qty;
}

$tableau[] = $nbr_def;

//
$dateNext= strtotime($DD."+ 1 day");

$DD= date('Y-m-d', $dateNext);

} */
////

$MyData->addPoints($tableau,"Nombre des défauts");

$MyData->setSerieWeight("Nombre des défauts",2);
$MyData->setAxisName(0,"Nombre des défauts");

/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/
$MyData->addPoints(array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),"Labels");
$MyData->setSerieDescription("Labels","Jours");
$MyData->setAbscissa("Labels");
$MyData->setPalette("Nombre des défauts",array("R"=>225,"G"=>44,"B"=>32));
//$MyData->setPalette("objectif (%)",array("R"=>113,"G"=>240,"B"=>121));

/* Je crée l'image qui contiendra mon graphique précédemment crée */
$myPicture = new pImage(900,330,$MyData);
//$myPicture->Antialias = FALSE;
/* Je crée une bordure à mon image */
//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$tableau);
$myPicture->drawRectangle(0,0,899,329,array("R"=>0,"G"=>0,"B"=>0));

/* J'indique le titre de mon graphique, son positionnement sur l'image et sa police */
$myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
$myPicture->drawText(200,25,"Nombre des défauts par jour",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Je choisi le fond de mon graphique */
$myPicture->setFontProperties(array("FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>6));

/* Je détermine la taille du graphique et son emplacement dans l'image */
$myPicture->setGraphArea(60,40,800,310);

/* Paramètres pour dessiner le graphique à partir des deux abscisses */
$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
$myPicture->drawScale($scaleSettings);

/* J'insère sur le côté droit le nom de l'auteur et les droits */
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
$myPicture->drawLegend(650,40,array("Style"=>LEGEND_ROUND,"Alpha"=>20,"Mode"=>LEGEND_HORIZONTAL));

//Chart1

$MyData->setSerieDrawable("Nombre des défauts",TRUE);
$myPicture->drawBarChart();
$myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>FALSE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>60));

$randX=rand().rand(1,999);
$myPicture->Render("img/nbrD".$DF.".png");
$myPicture->Render("img/x".$randX."x".$DF.".png");
echo('<br><br><center><img src="../pChart/img/x'.$randX.'x'.$DF.'.png"  alt="Print" style="cursor:pointer;" width="900" height="450"  /></center>');
?>