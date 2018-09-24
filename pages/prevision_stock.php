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
<script src="../theme/dist/js/sb-admin-2.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
 <script src="../theme/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<script src="../JScolor/jscolor.js"></script>
<!--<script src="../ContextMenu/jquery.contextmenu.js"></script> 
<link rel="stylesheet" href="../ContextMenu/jquery.contextmenu.css">-->
<title>
Prévision du stock
</title>
<SCRIPT> 


var num="";
var num2="";
var col2="";
var PO="";

function scrollMOVE(){
var x =$("#tbody2").scrollTop();
$("#tbody1").scrollTop(x);
}
     //
	 function moveUP(){
	 //
	 bootbox.dialog({
                title: "Ponsitioner..",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form class="form-horizontal"> ' +
                    '<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="step">Steps</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="step" name="step" type="text" placeholder="Steps" class="form-control input-md"> ' +
                    '<span class="help-block">Rementer le PO X pas </span> </div> ' +
                    '</div> ' +
                    '<hr><div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="priority">Priority</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="priority"" name="priority"" type="text" placeholder="Priority"" class="form-control input-md"> ' +
                    '<span class="help-block">Définir la priorité du PO  </span> </div> ' +
                    '</div>'+
                    '</form> </div>  </div>',
                buttons: {
                    success: {
                        label: "Save",
                        className: "btn-success",
                        callback: function () {
                            var step= $('#step').val();
                            var pr = $("#priority").val();
                           //Traitement
						   $.ajax({
							type: 'POST',
							data: 'PO='+PO+'&step='+step+'&pr='+pr,	
							url: '../php/prevision_moveUP.php',		
							success: function(data) {
							if(data==0){
							window.location.reload();
							bootbox.alert(PO);
							}else{
							
							bootbox.alert(data);
							}
							}});
						   
						   
						   ///
                        }
                    }
                }
            }
        );
		/////
	 }
     //  
	 function moveDown(){
	 //
	 bootbox.dialog({
                title: "Ponsitioner..",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form class="form-horizontal"> ' +
                    '<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="step">Steps</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="step" name="step" type="text" placeholder="Steps" class="form-control input-md"> ' +
                    '<span class="help-block">Descendre le PO X pas </span> </div> ' +
                    '</div> ' +
                    '<hr><div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="priority">Priority</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="priority"" name="priority"" type="text" placeholder="Priority"" class="form-control input-md"> ' +
                    '<span class="help-block">Définir la priorité du PO  </span> </div> ' +
                    '</div>'+
                    '</form> </div>  </div>',
                buttons: {
                    success: {
                        label: "Save",
                        className: "btn-success",
                        callback: function () {
                            var step= $('#step').val();
                            var pr = $("#priority").val();
                           //Traitement
						   $.ajax({
							type: 'POST',
							data: 'PO='+PO+'&step='+step+'&pr='+pr,	
							url: '../php/prevision_moveDown.php',		
							success: function(data) {
							if(data==0){
							window.location.reload();
							bootbox.alert(PO);
							}else{
							
							bootbox.alert(data);
							}
							}});
						   
						   
						   ///
                        }
                    }
                }
            }
        );
		/////
	 }
     //
	 function contextM(N) {
	 event.preventDefault();
	 num2=N;
	 var nn="#inputBorder"+N;	
	 var pos = $(nn).offset();
     var top = pos.top;
     top=top-90;
     var left = pos.left ;
	 $('#contextMenu').css({
	 position:'absolute',
	 top:top,
	 left:left
	 });
	 $('#contextMenu').show();
	 } 
	 //
	  function contextM2(N,P) {
	 event.preventDefault();
	 num2=N;
	 PO=P;
	 var nn="#inputBorder"+N;	
	 var pos = $(nn).offset();
     var top = pos.top;
     top=top-90;
     var left = pos.left ;
	 $('#contextMenu2').css({
	 position:'absolute',
	 top:top,
	 left:left
	 });
	 $('#contextMenu2').show();
	 } 
	 //
	 function hideContext(){
	 $('#contextMenu').hide();
	 $('#contextMenu2').hide();
	 }
	 //
	 function ordre1(){
	 bootbox.confirm("Are you sure?", function(result) {
	 if(result==true){
	 $.ajax({
        type: 'POST',
        data: 'num='+num2,	
        url: '../php/prevision_ordC.php',		
        success: function(data) {
		window.location.reload();
		}});
	 }
	 }); 
	 }
	 //
	 function ordre2(){
	 //
	 
	 bootbox.dialog({
                title: "Reception partiel:",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form class="form-horizontal"> ' +
                    '<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="stk">QTY reçue</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="stk" name="stk" type="text" placeholder="QTY" class="form-control input-md"> ' +                    
                    '</div> ' +
                    '</div> ' +
					'<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="D">Prochaine reception</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="D" name="D" type="date" class="form-control input-md"> ' +                    
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
							$.ajax({
							type: 'POST',
							data: 'num='+num2+'&qte='+val+'&dateN='+D,	
							url: '../php/prevision_ordRP.php',		
							success: function(data) {
							window.location.reload();
							}});//
							}else{
							bootbox.alert("Verifier vos valeurs SVP ");
							}	/////////////////////
                        }
                    }
                }
            }
        );
	 
	 
	 //
	 }
	 //
	 function ordre3(){
	  bootbox.dialog({
                title: "Reception Rapporté:",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form class="form-horizontal"> ' +
					'<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="D">Prochaine reception</label> ' +
                    '<div class="col-md-4"> ' +
                    '<input id="D" name="D" type="date" class="form-control input-md"> ' +                    
                    '</div> ' +
                    '</div> ' +
                   
                    '</form> </div>  </div>',
                buttons: {
                    success: {
                        label: "Save",
                        className: "btn-success",
                        callback: function () {
                            
                            var D = $('#D').val();
                            
                            ///////////////////
							           
                           if (D != "") {                                             
                            //
							$.ajax({
							type: 'POST',
							data: 'num='+num2+'&dateN='+D,	
							url: '../php/prevision_ordR.php',		
							success: function(data) {
							window.location.reload();
							}});//
							}else{
							bootbox.alert("Verifier vos valeurs SVP ");
							}	/////////////////////
                        }
                    }
                }
            }
        );
	 }
	 //
	 function pickCol(x) {
	
	 document.getElementById("foo").jscolor.show();
	 num=x;
	
	 }
	 //
	 function update(jscolor) {
	 var idNum="."+num+"cl";
	 var classNum="."+num;
	 var col="#"+jscolor;
      $(classNum).css("background-color", col);     
      $(idNum).css("background-color", col);     
	   col2=col;
     $.ajax({
        type: 'POST',
        data: 'num='+num+'&couleur='+col,	
        url: '../php/prevision_couleur.php',		
        success: function(data) {
		//$('#table2').load();
		}});
     
	 
	 }
	 //
	 function mySearch() {
    var searchTerm = $(".search").val();
    var listItem = $('.results tbody').children('tr');
  
 
	 var jobCount = $('.results tbody').children('tr').length;
	 
 for (var iter = 1; iter <= jobCount; iter++) {
 var nIter1="."+iter;
 var nIter2="#"+iter;
 var val=$(nIter1).html();
 if (val.indexOf(searchTerm) >= 0){
$(nIter1).attr('visible','true');
$(nIter2).attr('visible','true');

}else{
$(nIter1).attr('visible','false');
$(nIter2).attr('visible','false');
}
  }
 }
     //
	 function afficheItemsOA(X){
	 var dateH = document.getElementById('dateH').value;
 var y =$("#tbody2").scrollTop();	
  
$.ajax({
        type: 'POST',
        data: 'IDordre='+X+'&dateH='+dateH,
        url: '../php/prevision_stockOA.php',		
        success: function(data) {
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 mySearch();
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		//
		idNum="."+num+"cl";
		$(idNum).css("background-color", col2); 
		//
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
		 }});
 }
     //
     function afficheItemsPO(YY,TT){
	 var dateH = document.getElementById('dateH').value;
  var y =$("#tbody2").scrollTop();	
 if(TT=='PO'){

$.ajax({
        type: 'POST',
        data: 'IDproduit='+YY+'&dateH='+dateH,	
        url: '../php/prevision_stockPO.php',		
        success: function(data) {
		
		if(data != 0){
		
		
		
		 $('#table2').html(data);
		 mySearch();
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		//
		idNum="."+num+"cl";
		$(idNum).css("background-color", col2); 
		//
		
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
       }});
 }else{
  //Par item
$.ajax({
        type: 'POST',
        data: 'article='+YY,	
        url: '../php/prevision_stockItem.php',		
        success: function(data) {
		
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 mySearch();
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		
		//
		idNum="."+num+"cl";
		$(idNum).css("background-color", col2); 
		//
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
       }});
	   
 }
}
     /// 
     function resetALL(){
        
 var y =$("#tbody2").scrollTop();	
  
$.ajax({
        type: 'POST',        
        url: '../php/prevision_stockReset.php',		
        success: function(data) {
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 mySearch();
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
        var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		//
		idNum="."+num+"cl";
		$(idNum).css("background-color", col2); 
		//
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
		 }});
	
     }
     //
     function prevision_stockItem(){
    var dateH = document.getElementById('dateH').value;
  var valeur = document.getElementById('IDart').value;
   var y =$("#tbody2").scrollTop();	
 
$.ajax({
        type: 'POST',
        data: 'article='+valeur+'&dateH='+dateH,	
        url: '../php/prevision_stockItem.php',		
        success: function(data) {
		
		if(data != 0){
		
		
		//$("#tbody1").scrollTop(y);
		 $('#table2').html(data);
		 mySearch();
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		//
		idNum="."+num+"cl";
		$(idNum).css("background-color", col2); 
		//
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
		 mySearch();
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		
		//
		idNum="."+num+"cl";
		$(idNum).css("background-color", col2); 
		//
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
		 mySearch();
		 $("#tbody2").scrollTop(y);
		$("#tbody2").scroll(function(){
       var x =$("#tbody2").scrollTop();
		$("#tbody1").scrollTop(x);
        });
		
		//
		idNum="."+num+"cl";
		$(idNum).css("background-color", col2); 
		//
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
     function realStock(){

   var valeur = document.getElementById('IDart').value;
   var y =$("#tbody2").scrollTop();	
   var val=0;
    $.ajax({
        type: 'POST',
        data: 'article='+valeur,	
        url: '../php/prevision_stockReal.php',		
        success: function(data) {
		
		if(data != 0){
		
		bootbox.alert(data);
		//
		}else{
		bootbox.alert("Vérifier le code article SVP");
       
		}
       }});


   //

	   
}
      //
     function pop_up(url){
     window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=500,height=900,directories=no,location=no') 
     } 
	 //
     function addMonth(){
     document.getElementById('dateH').value='2016-08-08';
	 document.form1.submit(); 
     }
	 function updateDateH(){

	
     }
///

</SCRIPT> 
</head>

<body >

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
elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<div class="container" onClick="hideContext();">


   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Prevision du stock</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
            Client: TYCO      
 </div>
 <div class="panel-body" >
 <?php 
include('../connexion/connexionDB.php');

$dateJ=date('Y-m-d');
 $dateJ = strtotime($dateJ."- 15 days");
  $dateJ= date('Y-m-d', $dateJ);
$dateJ1=$dateJ;
/*
if(! isset($_session['dateH'])){

$dateHH = strtotime($dateJ."-15 days");
$_session['dateH']= date('Y-m-d', $dateHH);

}*/
?>
 <div class="row">
          <div class="col-lg-12" >
		  <div class="pull-left col-lg-6">
		  <div class="row">
		  <form id="formX" method="POST">
		  <div class="col-lg-5">
    <input type="text" class="search form-control"  placeholder="Search " onkeyup="mySearch()">
	</div>
	<div class="col-lg-4">
    <input type="date" class="form-control" style="float:right" id="dateH" name="dateH">
	</div>
	<div class="col-lg-3">
	 <button type="submit"  class="btn btn-default"  target="_blank" >
	 
     <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
     </button>
   
	<input class="jscolor" id="foo" onchange="update(this.jscolor)" HIDDEN>
	</div>
	</form>
          </div>
          </div>
<div class="pull-Right col-lg-6">

<button type="button" class="btn btn-default" style="float:right" onClick="resetALL()">
  <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span>
</button>
</div>
</div>

                          <div class="col-lg-12" id="ALLprevision"> 
						  <form action="prevision_stock.php"  id="form1" name="form1">
						  
  <br><br>						  
                                <div class="col-lg-7" >
								<table class="table table-fixed table table-bordered results" id="table1">
								<thead>
             <tr>
                <th style="width:7%;height:110px" class="degraD"><br>#</th>
                <th style="width:20%;height:110px" class="degraD"><br>Expedition</th>
				<th style="width:20%;height:110px" class="degraD"><br>Date entrée</th>
				<th style="width:20%;height:110px" class="degraD"><br>P0  </th>
			  <th style="width:20%;height:110px" class="degraD">Produit <br>& <br> Article</th>
			  <th style="width:13%;height:110px" class="degraD"><br>Qty</th>
            </tr>
          </thead>
		   <tbody id="tbody1">
<?php 

if(isset($_POST['dateH'])){
$dateH= $_POST['dateH'];
//$_session['dateH']=$dateH;
}else{
$dateH= $dateJ;
//$_session['dateH']=$dateH;
}
$dateH1= $dateH;
$reqD= mysql_query("DELETE FROM po_prevision ");
$reqD1= mysql_query("SELECT max(date_exped) FROM commande2 ");
$reqD2= mysql_query("SELECT  max(date_demand_starz) FROM ordre_achat2 ");
$reqMAX= mysql_query("SELECT PO FROM commande2 WHERE date_ent_cmd=(SELECT max(date_ent_cmd) FROM commande2)");
$dateMaxENT=mysql_result($reqMAX,0);
$dateMaxC=mysql_result($reqD1,0);
$dateMaxO=mysql_result($reqD2,0);

if($dateMaxC > $dateMaxO){
$dateMax=$dateMaxC;
}else{
$dateMax=$dateMaxO;
}

  $y=0;
//Avant dateJ //REception & sortie 
  while($dateJ >= $dateH){
  
  //Les ordres d'achat
   $req4= mysql_query("SELECT * FROM ordre_prevision where dateP='$dateH'");
   while($a4=mysql_fetch_object($req4))
    {
	
    $IDordre=$a4->IDordre;
    $IDarticle=$a4->IDarticle;   
    $dateP=$a4->dateP;
    $statut=$a4->statut;
    $qty=$a4->qty;
    $col=$a4->col;
    if($statut !='C' ){
	$col="#EC6868";
	}
	if($dateH != $dateJ){
	$y++;
	$req41=mysql_query("INSERT INTO po_prevision(num, po,item,qty,dateEX,typeP,col,etat) VALUES ('$y','$IDordre','$IDarticle','$qty','$dateP','OA','$col','H')");
 
    }
 
   }
  
  //Les commande
  $req2= mysql_query("SELECT * FROM commande2 where date_exped='$dateH' and client LIKE 'TYCO%' order by PR ASC");
  
   while($a2=mysql_fetch_object($req2))
    {
	
    $PO=$a2->PO;
    $date_ent=$a2->date_ent_cmd;
    $date_exped=$a2->date_exped;
    $col=$a2->col;
	
    $req3= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	$data=mysql_fetch_array($req3);	
	$qty=$data['qty'];
	$prd=$data['produit'];
	$statut=$data['statut'];
	
	if($date_exped != $dateJ){
	$y++;
	if($statut !='closed' ){
	$col="#EC6868";
	}
	$req41=mysql_query("INSERT INTO po_prevision(num, po,item,qty,dateEX,dateE,typeP,col,etat) VALUES ('$y','$PO','$prd','$qty','$date_exped','$date_ent','PO','$col','H')");
    }else if (($statut != 'waiting')and ($statut != 'planned')){
	$y++;
	$req41=mysql_query("INSERT INTO po_prevision(num, po,item,qty,dateEX,dateE,typeP,col,etat) VALUES ('$y','$PO','$prd','$qty','$date_exped','$date_ent','PO','$col','H')");
	}
  }

   $dateH = strtotime($dateH."+ 1 day");
  $dateH= date('Y-m-d', $dateH);
  
  }
  
  //Prevision
  while($dateMax >= $dateJ){
  
  //Les ordres d'achat
   $req4= mysql_query("SELECT * FROM ordre_prevision where dateP='$dateJ' and statut != 'C'");
   while($a4=mysql_fetch_object($req4))
    {
	$y++;
    $IDordre=$a4->IDordre;
    $IDarticle=$a4->IDarticle;   
    $dateP=$a4->dateP;
    $qty=$a4->qty;
    $col=$a4->col;
  
	$req41=mysql_query("INSERT INTO po_prevision(num, po,item,qty,dateEX,typeP,col) VALUES ('$y','$IDordre','$IDarticle','$qty','$dateP','OA','$col')");
 
 
 
  }
  
  //Les commande
  $req2= mysql_query("SELECT * FROM commande2 where date_exped='$dateJ' and client LIKE 'TYCO%' order by PR ASC");
  
   while($a2=mysql_fetch_object($req2))
    {
	
    $PO=$a2->PO;
    $date_ent=$a2->date_ent_cmd;
    $date_exped=$a2->date_exped;
    $col=$a2->col;
	
    $req3= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	$data=mysql_fetch_array($req3);	
	$qty=$data['qty'];
	$prd=$data['produit'];
	$statut=$data['statut'];
	if($statut=='waiting' or $statut=='planned' or $statut=='incomplete'){
	$y++;
	$req41=mysql_query("INSERT INTO po_prevision(num, po,item,qty,dateEX,dateE,typeP,col) VALUES ('$y','$PO','$prd','$qty','$date_exped','$date_ent','PO','$col')");
    }else if($dateJ != $dateJ1 and $statut !='waiting' and $statut !='planned'){
	$y++;	
	$req41=mysql_query("INSERT INTO po_prevision(num, po,item,qty,dateEX,dateE,typeP,col,etat) VALUES ('$y','$PO','$prd','$qty','$date_exped','$date_ent','PO','$col','H')");
	}
   }

   $dateJ = strtotime($dateJ."+ 1 day");
  $dateJ= date('Y-m-d', $dateJ);
  
  }
  
  
  //Affichage 
    $reqA= mysql_query("SELECT * FROM po_prevision");
   while($A1=mysql_fetch_object($reqA))
    {
    $num=$A1->num;
    $PO=$A1->po;
    $item=$A1->item;
    $dateEX=$A1->dateEX;
    $dateE=$A1->dateE;
    $typeP=$A1->typeP;
    $qty=$A1->qty;
    $col=$A1->col;
   
    
	if($dateMaxENT ==$PO){
	$col='#A5FBA7';
	}
	if($typeP=="OA"){
	$dateE="-----";
	}
	$inputID="inputBorder".$num;
  echo' <tr class='.$num.'>';
  echo "<td style=\"width:7%;background-color:".$col."\" onclick=pickCol('".$num."'); class=".$num.">".$num."</td>";
  echo '<td style="width:20%;background-color:'.$col.'" class='.$num.'>'.$dateEX.'</td>
  <td style="width:20%;background-color:'.$col.'" class='.$num.'>'.$dateE.'</td>
  <td style="width:20%;background-color:'.$col.'" class='.$num.'>';
  if($typeP=='OA'){
  echo "<input class=\"inputBorder\" value=\"".$PO."\" id=\"".$inputID."\"  onClick=afficheItemsOA('".$PO."') size=\"13\"  oncontextmenu=\"contextM('".$num."');\" READONLY>";
  }else{
  echo  "<input class=\"inputBorder\" value=\"".$PO."\" id=\"".$inputID."\" oncontextmenu=\"contextM2('".$num."','".$PO."');\" size=\"13\" READONLY >";
  }
  echo '</td>
 <td style="width:20%;background-color:'.$col.'" class='.$num.'>';
 echo "<input class=\"inputBorder\" value=\"".$item."\" onClick=afficheItemsPO('".$item."','".$typeP."') size=\"13\" READONLY>";
 echo '</td> 
  <td style="width:13%;background-color:'.$col.'" class='.$num.'>'.$qty.'</td></tr>';

 
  }
  
  //Determiner les articles
  $req121= mysql_query ("DELETE FROM article_prevision");
   $req1= mysql_query ("SELECT code_article,stock FROM article1 where catA='Production' or catA LIKE 'Production' order by stock DESC");
  $i=0;
  
  while($a=mysql_fetch_object($req1))
    {
	 $i++;
	 
	$article=$a->code_article;
    $ss =$a->stock;
	$pak=$article."/";
	
	//stock OUT
	$sumOUT=0;
	$sumIN=0;
	$reqSUM1= mysql_query ("SELECT PO FROM commande2 where date_exped >= '$dateH1'");
	while($dataS1=mysql_fetch_object($reqSUM1)){
	 
	$COM=$dataS1->PO;
	$reqSUM12= mysql_query ("SELECT SUM(qte) FROM sortie_stock1 where IDpaquet LIKE '$pak%' and commande like '$COM'");
	$sumOUT1 =mysql_result($reqSUM12,0);
	$sumOUT=$sumOUT+$sumOUT1;
    }
	$stock=$ss+$sumOUT;
	// stock IN 
	$reqSUM2= mysql_query ("SELECT IDreception,qty FROM reception_items where item LIKE '$article'");
	while($dataS=mysql_fetch_object($reqSUM2)){

	$recep=$dataS->IDreception;
	$reqSUM21= mysql_query ("SELECT dateR FROM reception where IDreception LIKE '$recep'");
	$dateR=mysql_result($reqSUM21,0);
	if($dateR >= $dateH1){
	$q=$dataS->qty;
	$sumIN=$sumIN+$q;
	}
	}
	$stock=$stock-$sumIN;
	$req11= mysql_query ("INSERT INTO article_prevision(numART, idART, stockART) VALUES ('$i','$article','$stock') ");
	 
	 
	 // 
	 if($i==1){
	 $art=$article;
	 $stockART=$stock;
	 }
	 } 
	  
	 
	 
     $max=$i;
?>
  </tbody>
  
  
  </table>
                               </div>
                             
                         
							


<div class="col-lg-5">
<div class="table-responsive">
<table class="table table-fixed table-bordered results2" id="table2">
<thead style="width:96.8%">
            <tr>
               <th style="width:20%;height:40px" class="degraD">
			   <input type="button" value="<<" DISABLED>
			   <input type="button" value="<" DISABLED>
			   
			   </th>
				<th style="width:60%;height:40px" class="degraD"><center>
				<input type="text" id="IDart" value="<?php echo $art;?>" onBlur="prevision_stockItem();" size="10">
				<b>1/<?php echo $max; ?></b>
				
				</center></th>
				<th style="width:20%;height:40px" class="degraD">
				<input type="button" value=">" onClick="nextART('1')">
			   <input type="button" value=">>" onClick="nextART('FIN')">
				
				</th>			  
            </tr>
			<tr><th style="width:100%;height:40px" class="degraD">
			<center><input type="text" id="STOCKart" value="<?php echo $stockART; ?>" size="10" READONLY>
			<input type="button" value="+" onClick="addStock()">
			   <input type="button" value="Réel" onClick="realStock()"></center></th>
			</tr>
			<tr>
               <th style="width:32%;height:30px" class="degraD">IN</th>
				<th style="width:32%;height:30px" class="degraD">OUT</th>
				<th style="width:36%;height:30px" class="degraD">Stock</th>			  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%" onScroll="scrollMOVE();">
		   <?php
		   
		    
			 
   $req4= mysql_query("SELECT * FROM po_prevision ");
   while($a4=mysql_fetch_object($req4))
    {
    $num=$a4->num;
    $PO=$a4->po;
    $item=$a4->item;
    $dateEX=$a4->dateEX;
    $dateE=$a4->dateE;
    $typeP=$a4->typeP;
    $qteD=$a4->qty;
    $etat=$a4->etat;
    $col=$a4->col;
	$cl=$num."cl";
    if($typeP=='OA'){
	
	//
	if($item==$art){
	$stockART=$stockART+$qteD;
    $stockART=round($stockART,4);  	
    if($stockART<0){
	$col2="#FA5858";
	}else{
	$col2=$col;
	}	
	
	echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;background-color:'.$col.';text-align:center">'.$qteD.'</td>
	<td class='.$cl.' style="width:32%;background-color:'.$col.';text-align:center">0</td>
	<td class='.$cl.' style="width:32%;background-color:'.$col2.';text-align:center">'.$stockART.'</td></tr>');
	}else{	
	if($stockART<0){
	$col2="#FA5858";
	}else{
	$col2=$col;
	}	
	echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;background-color:'.$col.';text-align:center">0</td>
	<td class='.$cl.' style="width:32%;background-color:'.$col.';text-align:center">0</td>
	<td class='.$cl.' style="width:32%;background-color:'.$col2.';text-align:center">'.$stockART.'</td></tr>');
	}	
	//
	}else{
	
	$req42= mysql_query("SELECT * FROM produit_article1 where IDproduit ='$item' and IDarticle='$art'");
	if(mysql_num_rows($req42)>0){
   $a42=mysql_fetch_object($req42);     
    $qteB=$a42->qte;
    $qteS=$qteB*$qteD;
	$stockART=$stockART-$qteS;
	$stockART=round($stockART,4); 
   
	if($stockART<0){
	$col2="#FA5858";
	}else{
	$col2=$col;
	}
	echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">'.$qteS.'</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col2.'">'.$stockART.'</td></tr>');
	
	}else{	
	if($stockART<0){
	$col2="#FA5858";
	}else{
	$col2=$col;
	}
	echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col2.'">'.$stockART.'</td></tr>');
	}

	}
		
 }

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </form>
 </div> 
 </div> 
 
</div> 
</div> 
</div> 

	</div>
    </div>
<ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >   
    <li><a  href="#" onClick="ordre3();"> Repporter</a></li>   
</ul>
	
<ul id="contextMenu2" class="dropdown-menu" role="menu" style="display:none" >
    <li><a  href="#" onClick="moveUP();"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> <b>Move Up</b></a></li>
    <li><a  href="#"onClick="moveDown();"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> <b> Move Down</b></a></li>
   
   
</ul>
                    </div>
                    </div>
                    </div>
               
             
     

</body>

</html>