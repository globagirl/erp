<?php
include('../connexion/connexionDB.php');
//Je charge les librairies de pChart qui se trouve dans le dossier class pour qu'il puisse afficher un graphique
include("class/pData.class.php");
include("class/pDraw.class.php");
include("class/pImage.class.php");
include("class/pPie.class.php");
include("class/pIndicator.class.php");
//

$sqlG= mysql_query("SELECT DISTINCT produit FROM produit1 where categorie LIKE 'CAT 5%'");
while($dataG=@mysql_fetch_array($sqlG)){
$produit=$dataG['produit'];
// Je créer un nouvel objet contenant mes données pour le graphique 
 $MyData = new pData();

/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/  
// jours un tableau qui contient les jours 
$long = array(); 
$CAT5 = array(); 


$sql= mysql_query("SELECT * FROM produit1 where longueur > '0' and produit='$produit' and categorie LIKE 'CAT 5%'  order by longueur ASC");
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
$CAT5[] = $profit; 
$L=$data['longueur'];
$long[] =(string)$L; 
}
}


////
 $MyData->addPoints($CAT5,$produit);



 $MyData->setSerieWeight($produit);
 $MyData->setAxisName(0,"Gross margin ");

/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/
 $MyData->addPoints($long,"Labels");
 $MyData->setSerieDescription("Labels","Length");
 $MyData->setAbscissa("Labels");
 $MyData->setSerieWeight("Labels");

 $MyData->setPalette($produit,array("R"=>191,"G"=>10,"B"=>46));


/* Je crée l'image qui contiendra mon graphique précédemment crée */
 $myPicture = new pImage(1460,330,$MyData);
 //$myPicture->Antialias = FALSE; 
/* Je crée une bordure à mon image */
//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$tableau); 
 //$myPicture->drawRectangle(0,0,1450,329,array("R"=>0,"G"=>0,"B"=>0));

/* J'indique le titre de mon graphique, son positionnement sur l'image et sa police */ 
 $myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
 $myPicture->drawText(200,25,"Item : ".$produit.".",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Je choisi le fond de mon graphique */
 $myPicture->setFontProperties(array("FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>6));

/* Je détermine la taille du graphique et son emplacement dans l'image */
 $myPicture->setGraphArea(60,40,1400,310);

/* Paramètres pour dessiner le graphique à partir des deux abscisses */
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
 $myPicture->drawScale($scaleSettings);

/* J'insère sur le côté droit le nom de l'auteur et les droits */ 
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

/*
 $myPicture->drawLegend(830,60,array("Style"=>LEGEND_NOBORDER,"R"=>173,"G"=>163,"B"=>83,"Surrounding"=>20,"Family"=>LEGEND_FAMILY_LINE,"BoxWidth"=>30));
*/
//Chart1

  $myPicture->setFontProperties(array("FontSize"=>10,"R"=>30,"G"=>30,"B"=>30));
 $MyData->setSerieDrawable($produit,TRUE); 
 $myPicture->drawLineChart(); 
$myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>FALSE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>60));





/* J'indique le chemin où je souhaite que mon image soit créée */

 $myPicture->Render("img/".$produit.".png");

  echo('<br><br><center><img src="../pChart/img/'.$produit.'.png"  alt="Print" style="cursor:pointer;" width="1500" height="450"  /></center>');
}
?>