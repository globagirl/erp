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

/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/  
// jours un tableau qui contient les jours 
$long = array(); 

$UPM3 = array(); 


$sql= mysql_query("SELECT DISTINCT longueur FROM produit1 where longueur > '0' and longueur < '50'  order by longueur ASC");
while($data=@mysql_fetch_array($sql)){
$L=$data['longueur'];

$long[] =(string)$L; 

//CAT 6
$sql222 = mysql_query("SELECT * FROM produit1 WHERE longueur='$L' and categorie LIKE 'UPM3'");

$totalTC=0;
$totalP=0;
$x=1;
//takilfa
while($data2=@mysql_fetch_array($sql222)){

$produit=$data2['code_produit'];

$prix=$data2['prix'];
//

$TC=0;
$req333= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
while($data3=@mysql_fetch_object($req333)){
	 $qteB=$data3->qte;	 
	 $article=$data3->IDarticle;
	
	 $req444= mysql_query("SELECT * FROM article1 where code_article='$article'");
	 $data4=mysql_fetch_object($req444);
	 $prixA=$data4->prix;	 
	 $prixTItem=$prixA*$qteB;
	 $TC=$TC+$prixTItem;
	 
}
$totalTC=$totalTC+$TC;
$totalP=$totalP+$prix;
$x++;
}//END takilfa
 
$profit=($totalP-$totalTC)/$x;
$UPM3[] =$profit; 
//END 


}


////

 $MyData->addPoints($UPM3,"UPM3 ");


 $MyData->setSerieWeight("UPM3");
 $MyData->setAxisName(0,"Gross margin ");

/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/
 $MyData->addPoints($long,"Labels");
 $MyData->setSerieDescription("Labels","Length");
 $MyData->setAbscissa("Labels");
 $MyData->setSerieWeight("Labels");
 $MyData->setPalette("UPM3",array("R"=>47,"G"=>129,"B"=>138));



/* Je crée l'image qui contiendra mon graphique précédemment crée */
 $myPicture = new pImage(1460,330,$MyData);
 //$myPicture->Antialias = FALSE; 
/* Je crée une bordure à mon image */
//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$tableau); 
 $myPicture->drawRectangle(0,0,1450,329,array("R"=>0,"G"=>0,"B"=>0));

/* J'indique le titre de mon graphique, son positionnement sur l'image et sa police */ 
 $myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
 $myPicture->drawText(200,25,"Items accounting per length (UPM3)",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Je choisi le fond de mon graphique */
 $myPicture->setFontProperties(array("FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>6));

/* Je détermine la taille du graphique et son emplacement dans l'image */
 $myPicture->setGraphArea(60,40,1400,310);

/* Paramètres pour dessiner le graphique à partir des deux abscisses */
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
 $myPicture->drawScale($scaleSettings);

/* J'insère sur le côté droit le nom de l'auteur et les droits */ 
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
 $myPicture->setFontProperties(array("FontSize"=>13,"R"=>30,"G"=>30,"B"=>30));

 $myPicture->drawLegend(830,60,array("Style"=>LEGEND_NOBORDER,"R"=>173,"G"=>163,"B"=>83,"Surrounding"=>20,"Family"=>LEGEND_FAMILY_LINE,"BoxWidth"=>30));

//Chart1

 
 $MyData->setSerieDrawable("UPM3",TRUE); 
 $myPicture->drawLineChart(); 
$myPicture->drawPlotChart(array("DisplayValues"=>FALSE,"PlotBorder"=>FALSE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>60));





/* J'indique le chemin où je souhaite que mon image soit créée */

 $myPicture->Render("img/UPM3.png");
  echo('<br><br><center><img src="../pChart/img/UPM3.png"  alt="Print" style="cursor:pointer;" width="1500" height="450"  /></center>');
?>