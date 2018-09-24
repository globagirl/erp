 <?php
include('../connexion/connexionDB.php');
$article=@$_POST['article'];

$sq=mysql_query("SELECT * FROM article1 where code_article='$article'");
if (mysql_num_rows($sq)<= 0) {
echo 0; 
}else{
$A1=mysql_fetch_object($sq);
   
    $stock=$A1->stock;
    $unit=$A1->unit;    
 

echo $stock.' '.$unit ;


}
?>