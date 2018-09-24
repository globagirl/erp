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
<link href="../tablecloth/table.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>

<title>Ajout Ordre Fabrication</title>
<script>

///////Auto Complete //////
function autoComplete(){

var min_length =3; 
	var keyword = $('#PO').val();	
	if (keyword.length >= min_length) {
	var zoneC="#PO";
		$.ajax({
			url: '../php/auto_liste_po.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC,
			success:function(data){
				$('#listePO').show();
				$('#listePO').html(data);
			}});
	}else {
		$('#listePO').hide();
	}
}
//
function hideListe() {
	
    
	$('#listePO').hide();
	}
//	
function choixListe(p,z) {
	$(z).val(p);
}
////////////////////////////////////FIN///////////////
function affichePO(){
		
 var valeur = document.getElementById("PO").value;
 if(valeur==""){
	  alert("Selectionnez une commande SVP !!");

 }
 else{
	
	$.ajax({
			url: '../php/affichePO.php',
			type: 'POST',
			data: "commande="+valeur,
			success:function(data){
				if(data != 0){
				$('#OFD').html(data);
				}else{
				alert("Vérifier votre PO SVP !!");
				}
			}});
	//
	
 }
}

///////
function updateP(tlots){
	
	            var cmdcal=document.getElementById("qteP").value;
				cmdcal=parseInt(cmdcal);
				tlots=parseInt(tlots);
	                if(cmdcal>tlots){
					
								if ((cmdcal%tlots)==0)
								{
									
								var divs = cmdcal/tlots;
								document.getElementById("nbP").value = divs;
								document.getElementById("plan").value=tlots;
								document.getElementById("planS").value="0";
								
								}
								else 
								{
								
								var qteS=cmdcal%tlots;
								var nbrP = (cmdcal-qteS)/tlots;
								
								nbrP++;
								document.getElementById("nbP").value = nbrP;
								document.getElementById("plan").value=tlots;
								document.getElementById("planS").value=qteS;
								}
							
					}else{
								document.getElementById("nbP").value = "1";
								document.getElementById("plan").value=cmdcal;
								document.getElementById("planS").value="0";
								}
	
	
}
//////////////Cas PCB & others
function updateP2(){
    var nbP=document.getElementById("nbP").value;
	nbP=parseInt(nbP);
	var qteP=document.getElementById("qteP").value;
	qteP=parseInt(qteP);
	var plan=document.getElementById("plan").value;
	plan=parseInt(plan);
	var planS=document.getElementById("planS").value;
	planS=parseInt(planS);
	if(nbP==1){
	document.getElementById("plan").value=qteP;
	}else if(planS==0){
	var x =qteP/nbP;
	document.getElementById("plan").value=x;
	}else{
	var x1=qteP-planS;
	var x =x1/(nbP-1);
	document.getElementById("plan").value=x;
	}
	


}
///// ajout OF 
function ajoutOF(){
	var qteC=document.getElementById("qteC").value;
	var qteP=document.getElementById("qteP").value;
	var qteL=document.getElementById("qteL").value;
	var dateE=document.getElementById("dateE").value;
	var dateL=document.getElementById("dateL").value;
	qteC=parseInt(qteC);
	qteL=parseInt(qteL);
	qteP=parseInt(qteP);
	var qte=qteL+qteP;
	//qte=parseInt(qte);
	if(qte>qteC){
		alert("Vérifier la quantité planifié SVP !!");
		document.getElementById('qteP').style.backgroundColor='pink'; 
	}else if(dateE==""){
		alert("Donnez la date d'expédition  SVP !!");
		document.getElementById('dateE').style.backgroundColor='pink'; 
	}else if(dateL==""){
		alert("Donnez la date de lancement SVP !!");
		document.getElementById('dateL').style.backgroundColor='pink'; 
	}else{
		document.forms['form1'].submit(); 
	}

}
//////////////
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
} 	  
	
</script>



</head>


<body onKeyDown="desactiveEnter()">
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
<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manufacturing order  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>


<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          New manufacturing order
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" action="../php/ajout_ordre_fabrication.php">
  <div class="row">
                                <div class="col-lg-6">
                                
                                        <div class="form-group form-inline">
                                            
                                            <input class="form-control" id="PO" name="PO" placeholder="PO client" onKeyup="autoComplete();" onFocus="autoComplete()"  onBlur="hideListe();">
                                            <button type="button" class="btn btn-default" onclick="affichePO()">>> </button>
                                        </div>
										<div class="divAuto2"><ul id="listePO" ></ul></div>
									
										</div>
										</div>



<div id="OFD"></div>
	</form>



</div>
</div>
</div>
</div>
</div>

</div>


</body>

</html>