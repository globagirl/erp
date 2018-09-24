<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
}
?>
<html>
<head>
<meta charset="utf-8" />
<!--<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<!--<script type="text/javascript" src="tablecloth/tablecloth.js"></script> -->
<link rel="stylesheet" type="text/css" href="../css/style.css"/> 
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

<title>
Prévision du stock
</title>
<SCRIPT> 

$(document).ready(function(){
    $("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
    });
});


function afficheItemsOA(X){
$.ajax({
        type: 'POST',
        data: 'IDordre='+X,	
        url: '../php/prevision_stockOA.php',		
        success: function(data) {
		bootbox.dialog({
        title: "Ordre d'achat N° "+X,
        message: data
       });
		 }});
 }
 //
 function afficheItemsPO(YY){
 var y =$("#tbody2").scrollTop();	
$.ajax({
        type: 'POST',
        data: 'IDproduit='+YY,	
        url: '../php/prevision_stockPO.php',		
        success: function(data) {
		
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		
		//alert(data);
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
       }});
 }

/// 
   function resetALL(){
   location.reload();
   }

//
   function prevision_stockItem(){

  var valeur = document.getElementById('IDart').value;
   var y =$("#tbody2").scrollTop();	
 
$.ajax({
        type: 'POST',
        data: 'article='+valeur,	
        url: '../php/prevision_stockItem.php',		
        success: function(data) {
		
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		
		//alert(data);
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
       }});
	   
}
//
function nextART(val){

  var valeur = document.getElementById('IDart').value;
   var y =$("#tbody2").scrollTop();	
 
$.ajax({
        type: 'POST',
        data: 'article='+valeur+'&pos='+val,	
        url: '../php/prevision_stockNum.php',		
        success: function(data) {
		
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		
		//alert(data);
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
       }});
	   
}
//
function addStock(){
bootbox.dialog({
                title: "Stock supplémentaire:",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form class="form-horizontal"> ' +
                    '<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="stk">Stock</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="stk" name="stk" type="text" placeholder="Stock" class="form-control input-md"> ' +                    
                    '</div> ' +
                    '</div> ' +
					'<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="D">Date</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="D" name="D" type="date" placeholder="Stock" class="form-control input-md"> ' +                    
                    '</div> ' +
                    '</div> ' +
                   
                    '</form> </div>  </div>',
                buttons: {
                    success: {
                        label: "Save",
                        className: "btn-success",
                        callback: function () {
                            var stk = $('#stk').val();
                            var D = $('#D').val();
                            
                            ///////////////////
							val = parseFloat(stk);              
  if (!isNaN(val)) {                                             
   //
   var valeur = document.getElementById('IDart').value;
   var y =$("#tbody2").scrollTop();	
 
$.ajax({
        type: 'POST',
        data: 'article='+valeur+'&newStock='+val+'&dateP='+D,	
        url: '../php/prevision_stockAdd.php',		
        success: function(data) {
		
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		
		//alert(data);
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
       }});
//
  }else{
		bootbox.alert("Le stock doit étre un FLOAT SVP ");
       
		}	/////////////////////
                        }
                    }
                }
            }
        );

}
//
function resetStock(){

   var valeur = document.getElementById('IDart').value;
   var y =$("#tbody2").scrollTop();	
 var val=0;
$.ajax({
        type: 'POST',
        data: 'article='+valeur+'&newStock='+val,	
        url: '../php/prevision_stockAdd.php',		
        success: function(data) {
		
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		
		//alert(data);
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
       }});


   //

	   
}

 

</SCRIPT> 
</head>

<body>

<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php 
include('../include/logOutIMG.php');
?>	
</div>
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Prévision du stock</p>

<br>
<br>
<br>

<div class="container">



<div class="row">
 <div class="col-lg-12" >
 <button type="button" class="btn btn-default" style="float:right" onClick="resetALL()">
  <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span>
</button>
                
				<br><br>
				</div>
                              
                                <div class="col-lg-7" >
								<table class="table table-fixed table table-bordered" id="table1">
								<thead>
             <tr>
                <th style="width:20%;height:110px" class="degraD"><br>Date expedition</th>
				<th style="width:20%;height:110px" class="degraD"><br>Date entrée</th>
				<th style="width:25%;height:110px" class="degraD"><br>P0</th>
			  <th style="width:22%;height:110px" class="degraD"><br>Produit</th>
			  <th style="width:13%;height:110px" class="degraD"><br>Qty</th>
            </tr>
          </thead>
		   <tbody id="tbody1">
<?php 

include('../connexion/connexionDB.php');

$reqD1= mysql_query("SELECT max(date_exped) FROM commande2 ");
$reqD2= mysql_query("SELECT  max(date_demand_starz) FROM ordre_achat2 ");

$dateMaxC=mysql_result($reqD1,0);
$dateMaxO=mysql_result($reqD2,0);

if($dateMaxC > $dateMaxO){
$dateMax=$dateMaxC;
}else{
$dateMax=$dateMaxO;
}
  $dateMax1=$dateMax;
  $dateJ=date('Y-m-d');
  $dateJ1=$dateJ;
 
  while($dateMax >= $dateJ){
  //Les ordres d'achat
   $req4= mysql_query("SELECT * FROM ordre_achat2 where date_demand_starz='$dateJ' and statut='waiting'");
   while($a4=mysql_fetch_object($req4))
    {
    $IDordre=$a4->IDordre;
    $date_crt=$a4->date_creation;
    $date_demand=$a4->date_demand_starz;
    $fournisseur=$a4->fournisseur;
	
   if($fournisseur=="TYCO ELECTRONIC LOGI"){ 
  echo '<tr>
 <td style="width:20%;background-color:#FBF5EF"> '.$date_demand.'</td>
  <td style="width:20%;background-color:#FBF5EF">'.$date_crt.'</td>
  <td style="width:25%;background-color:#FBF5EF">';
  echo "<input class=\"inputBorder\" value=\"".$IDordre."\" onClick=afficheItemsOA('".$IDordre."') size=\"13\" READONLY>";
  echo '</td>
  
  <td style="width:22%;background-color:#FBF5EF">---</td>
  <td style="width:13%;background-color:#FBF5EF">---</td></tr>';
 
 
 }
  }
  
  //Les commande
  $req2= mysql_query("SELECT * FROM commande2 where date_exped='$dateJ'");
   while($a2=mysql_fetch_object($req2))
    {
    $PO=$a2->PO;
    $date_ent=$a2->date_ent_cmd;
    $date_exped=$a2->date_exped;
    $req3= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	$data=mysql_fetch_array($req3);	
	
  echo' <tr>
  <td style="width:20%;background-color:#F2F2F2">'.$date_exped.'</td>
  <td style="width:20%;background-color:#F2F2F2">'.$date_ent.'</td>
  <td style="width:25%;background-color:#F2F2F2">'.$data['POitem'].'</td>
 <td style="width:22%;background-color:#F2F2F2">';
 echo "<input class=\"inputBorder\" value=\"".$data['produit']."\" onClick=afficheItemsPO('".$data['produit']."') size=\"13\" READONLY>";
 echo '</td> 
  <td style="width:13%;background-color:#F2F2F2">'.$data['qty'].'</td></tr>';

 
  }

   $dateJ = strtotime($dateJ."+ 1 day");
  $dateJ= date('Y-m-d', $dateJ);
  
  }
  
  //Determiner les articles
  
   $req1= mysql_query ("SELECT * FROM article1 where catA='Production' or catA LIKE 'Production' order by typeA ASC");
  $i=0;
  $req121= mysql_query ("DELETE FROM article_prevision");
  while($a=mysql_fetch_object($req1))
    {
	 $i++;
	 
	 $article=$a->code_article;
    $stock =$a->stock;
	$req11= mysql_query ("INSERT INTO article_prevision(numART, idART, stockART) VALUES ('$i','$article','$stock') ");
	 
	 } 
	  
	 $req12= mysql_query ("SELECT * FROM article_prevision where numART='1'");
	 $data12=mysql_fetch_array($req12);
	 $req101=mysql_query ("SELECT max(numArt) FROM article_prevision");
     $max=mysql_result($req101,0);
?>
  </tbody>
  
  
  </table>
                               </div>
                             
                         
							


<div class="col-lg-5">
<div class="table-responsive">
<table class="table table-fixed table-bordered" id="table2">
<thead style="width:96.8%">
            <tr>
               <th style="width:20%;height:40px" class="degraD">
			   <input type="button" value="<<" DISABLED>
			   <input type="button" value="<" DISABLED>
			   
			   </th>
				<th style="width:60%;height:40px" class="degraD"><center>
				<input type="text" id="IDart" value="<?php echo $data12['idART'];?>" onBlur="prevision_stockItem();" size="10">
				<b>1/<?php echo $max; ?></b>
				
				</center></th>
				<th style="width:20%;height:40px" class="degraD">
				<input type="button" value=">" onClick="nextART('1')">
			   <input type="button" value=">>" onClick="nextART('FIN')">
				
				</th>			  
            </tr>
			<tr><th style="width:100%;height:40px" class="degraD">
			<center><input type="text" id="STOCKart" value="<?php echo $data12['stockART']; ?>" size="10" READONLY><input type="button" value="+" onClick="addStock()">
			   <input type="button" value="Reset" onClick="resetStock()"></center></th>
			</tr>
			<tr>
               <th style="width:32%;height:30px" class="degraD">IN</th>
				<th style="width:32%;height:30px" class="degraD">OUT</th>
				<th style="width:36%;height:30px" class="degraD">Stock</th>			  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">
		   <?php
		   $art=$data12['idART'];
		   $stockART=$data12['stockART'];
		     while($dateMax1 >= $dateJ1){
			 
  //Les ordres d'achat
   $req4= mysql_query("SELECT * FROM ordre_achat2 where date_demand_starz='$dateJ1' and statut='waiting'");
   while($a4=mysql_fetch_object($req4))
    {
    $IDordre=$a4->IDordre;
    $date_crt=$a4->date_creation;
    $date_demand=$a4->date_demand_starz;
    $fournisseur=$a4->fournisseur;
	
   if($fournisseur=="TYCO ELECTRONIC LOGI"){ 
  
	$req42= mysql_query("SELECT * FROM ordre_achat_article1 where IDordre ='$IDordre' and IDarticle='$art'");
	if(mysql_num_rows($req42)>0){
    while($a42=mysql_fetch_object($req42)){
      
    $qteD=$a42->qte_demande;
	
	$stockART=$stockART+$qteD;
		
	echo('<tr><td style="width:32%">'.$qteD.'</td>
	<td style="width:32%">0</td>
	<td style="width:32%">'.$stockART.'</td></tr>');
	}
	}else{	
	echo('<tr><td style="width:32%">0</td>
	<td style="width:32%">0</td>
	<td style="width:32%">'.$stockART.'</td></tr>');
	}	
	} 
 }
  
  
  //Les commande
  $req2= mysql_query("SELECT * FROM commande2 where date_exped='$dateJ1'");
   while($a2=mysql_fetch_object($req2))
    {
    $PO=$a2->PO;
    $date_ent=$a2->date_ent_cmd;
    $date_exped=$a2->date_exped;
    $req3= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	$data=mysql_fetch_array($req3);	
	$prd=$data['produit'];
    $qty=$data['qty'];
	$req42= mysql_query("SELECT * FROM produit_article1 where IDproduit ='$prd' and IDarticle='$art'");
	if(mysql_num_rows($req42)>0){
   $a42=mysql_fetch_object($req42);     
    $qteB=$a42->qte;
    $qteS=$qteB*$qty;
	$stockART=$stockART-$qteS;
   
	if($stockART<0){
	$col="#F7819F";
	}else{
	$col="#81BEF7";
	}
	echo('<tr><td  style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td style="width:32%;text-align:center ;background-color:'.$col.'">'.$qteS.'</td>
	<td style="width:32%;text-align:center ;background-color:'.$col.'">'.$stockART.'</td></tr>');
	
	}else{	
	if($stockART<0){
	$col="#F7819F";
	}else{
	$col="#E0F8F1";
	}
	echo('<tr><td style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td style="width:32%;text-align:center ;background-color:'.$col.'">'.$stockART.'</td></tr>');
	}
	}
  
   $dateJ1 = strtotime($dateJ1."+ 1 day");
  $dateJ1= date('Y-m-d', $dateJ1);
  
  }
		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div> 
 
</div> 

	</div>
                    </div>
               
             
     

</body>

</html>