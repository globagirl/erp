<?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=$_POST['valeur'];
//$nbrP=$_POST['nbrP'];
$sql = mysql_query("SELECT produit,PO,OF FROM ordre_fabrication1 where $recherche='$valeur'");
if(mysql_num_rows($sql)>0){
    $data=mysql_fetch_array($sql);
    $produit=$data['produit'];
    $OF=$data['OF'];
    $sql1 = mysql_query("SELECT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
    /*$sql2 = mysql_query("SELECT sum(nbr_defaut) FROM plan1 where OF='$OF'");
    $nbr_defaut=@mysql_result($sql2,0);*/
    $x=0;
    echo '<hr><h4>Product Code : '.$produit.'</h4><hr>

   <div class="form-group form-inline">
     <label>Total defects: </label>
     <input type="text"  name="nbrP" id="nbrP" class="form-control" required="required"> 
     </div>
	<hr>';
    while($data1=mysql_fetch_array($sql1)){
        $x++;
        $article=$data1['IDarticle'];
        $sq = mysql_query("SELECT description FROM article1 where code_article='$article'");
        $desc=@mysql_result($sq,0);
        $art="art".$x;
        $qte="qte".$x;
        $chek="chek".$x;
        echo "<div class=\"well form-inline\">
        <input type=\"text\" class=\"form-control\" name=".$art." id=".$art." value=".$article." readonly> 
        <input type=\"checkbox\" class=\"form-control\" name=".$chek." id=".$chek." onClick=affiche_zone('".$x."') > 
        <input type=\"text\" name=".$qte." id=".$qte." placeholder=\"QTY\" class=\"form-control\" readonly > 
        <p class=\"help-block\">".$desc."</p>
        </div>";
    }
    echo '<div class="well"><input type="submit" class="btn btn-primary" Value="Submit >>">
<input type="text"  name="nbr" value='.$x.' style="visibility:hidden"> </div>';
}else{
    echo '1';
}
mysql_close();
?>