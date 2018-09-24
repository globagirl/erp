<?php
include('../connexion/connexionDB.php');
//Je charge les librairies de pChart qui se trouve dans le dossier class pour qu'il puisse afficher un graphique
include("class/pData.class.php");
include("class/pDraw.class.php");
include("class/pImage.class.php");
include("class/pPie.class.php");
include("class/pIndicator.class.php");
//

$sqlG= mysql_query("SELECT DISTINCT longueur FROM produit1 where longueur>0  order by longueur ASC");
while($dataG=@mysql_fetch_array($sqlG)){
$long=$dataG['longueur'];
// Je créer un nouvel objet contenant mes données pour le graphique 
 $MyData = new pData();

/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/  
// jours un tableau qui contient les jours 
$prdTab = array(); 
$profitTab = array(); 


$sql= mysql_query("SELECT * FROM produit1 where longueur ='$long'");
while($data=@mysql_fetch_array($sql)){


$IDproduit=$data['code_produit'];
$prix=$data['prix'];
//

$TC=0;
$req3= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$IDproduit'");
while($data3=@mysql_fetch_object($req3)){
	 $qteB=$data3->qte;	 
	 $article=$data3->IDarticle;
	
	 $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
	 $data4=mysql_fetch_object($req4);
	 $prixA=$data4->prix;	 
	 $prixTItem=$prixA*$qteB;
	 $TC=$TC+$prixTItem;
	 
}

if($prix>0 && $TC>0){
$profit=$prix-$TC;
$profit=round($profit,2);
$profitP=($profit/$prix)*100;
$profitP=round($profitP,2);
$cat=$data['categorie'];
$profitTab[] = $profitP;
$prd=$IDproduit.' '.$cat;
$prdTab[] =$prd; 
}

}


////
 $MyData->addPoints($profitTab,$long);



 $MyData->setSerieWeight($long);
 $MyData->setAxisName(0,"Gross margin %");

/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/
 $MyData->addPoints($prdTab,"Labels");
 $MyData->setSerieDescription("Labels","Length");
 $MyData->setAbscissa("Labels");
 $MyData->setSerieWeight("Labels");

 $MyData->setPalette($long,array("R"=>191,"G"=>10,"B"=>46));


/* Je crée l'image qui contiendra mon graphique précédemment crée */
 $myPicture = new pImage(1520,480,$MyData);
 //$myPicture->Antialias = FALSE; 
/* Je crée une bordure à mon image */
//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$tableau); 
 //$myPicture->drawRectangle(0,0,1450,329,array("R"=>0,"G"=>0,"B"=>0));

/* J'indique le titre de mon graphique, son positionnement sur l'image et sa police */ 
 $myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
 $myPicture->drawText(200,25,"Length :".$long."m",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Je choisi le fond de mon graphique */
 $myPicture->setFontProperties(array("FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>10));

/* Je détermine la taille du graphique et son emplacement dans l'image */
 $myPicture->setGraphArea(110,30,1400,400);

/* Paramètres pour dessiner le graphique à partir des deux abscisses */
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,'LabelRotation'=>30);
 $myPicture->drawScale($scaleSettings);

/* J'insère sur le côté droit le nom de l'auteur et les droits */ 

$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
/*
 $myPicture->setFontProperties(array("FontSize"=>13,"R"=>30,"G"=>30,"B"=>30));

 $myPicture->drawLegend(830,60,array("Style"=>LEGEND_NOBORDER,"R"=>173,"G"=>163,"B"=>83,"Surrounding"=>20,"Family"=>LEGEND_FAMILY_LINE,"BoxWidth"=>30));
*/
//Chart1

  $myPicture->setFontProperties(array("FontSize"=>10,"R"=>30,"G"=>30,"B"=>30));
 $MyData->setSerieDrawable($long,TRUE); 
 $myPicture->drawLineChart(); 
$myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>FALSE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>60));





/* J'indique le chemin où je souhaite que mon image soit créée */

 $myPicture->Render("img/MP".$long.".png");

  echo('<br><br><center><img src="../pChart/img/MP'.$long.'.png"  alt="Print" style="cursor:pointer;" width="1500" height="450"  /></center>');
}
?>