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


<!-- DOC --> 
<title>
Demande congé
</title>
<script>
////////////////////////LISTE LIKE GOOGLE :) /////////////
function autoComplete(){
var liste = document.getElementById('recherche');
var R = liste.options[liste.selectedIndex].value;
var zoneC="#valeur";
var zoneL="#listeP";
var min_length =1; 
	var keyword = $(zoneC).val();	
	if (keyword.length >= min_length) {
	
		$.ajax({
			url: '../php/auto_liste_personnel.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC+"&R="+R,
			success:function(data){
				$(zoneL).show();
				$(zoneL).html(data);
			}});
	}else {
		$(zoneL).hide();
	}
}
///
function hideListe() {
	
    var zoneL="#listeP";
	$(zoneL).hide();
	}

function choixListe(p,z) {
var ch=p.replace("|"," ");
var ch=ch.replace("|"," ");
var ch=ch.replace("|"," ");
	$(z).val(ch);
	
}
////////////////////////////////////FIN/////////////// 
function verif(){
    var val=document.getElementById("matricule").value;
    var val1=document.getElementById("dateD").value;    
    var val2=document.getElementById("nbrH").value;
    if(val=="0" || val==0 ){
        alert("Veuillez vous re-connecter pour détecter votre MATRICULE SVP  !!");
        document.getElementById('matricule').style.backgroundColor='pink';             		  
    }else if(val1==""){
        alert("Donner la  date du debut du congée SVP !!");
		document.getElementById('dateD').style.backgroundColor='pink';             		  
    }else if(val2==""){
        alert("Donner le total des heures  SVP !!");
		document.getElementById('nbrH').style.backgroundColor='pink';             		  
    }else {  
        document.forms['formD'].submit(); 
    }
}
//Calculer le nombre d'heure
function calculNBR(){
    var d1=document.getElementById("dateD").value;
    var d2=document.getElementById("dateF").value;
	if(d1==""){
        alert("Donner la  date du debut du congée SVP !!");
		document.getElementById('dateD').style.backgroundColor='pink'; 
	}else{
	    $.ajax({
            type: 'POST',
            data:'dateD='+d1+'&dateF='+d2,
            url: '../php/calculNbrH.php',
            success: function(data) {        
                document.getElementById("nbrH").value=data;	
       }});
	}
}
</script>
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
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}
elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
elseif($role=="FIN"){
include('../menu/menuFinance.php');	
}
elseif($role=="CONS"){
include('../menu/menuConsommable.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}
elseif($role=="MAG"){
include('../menu/menuMagazin.php');	
}
elseif($role=="MAG2"){
include('../menu/menuMagazin2.php');	
}
elseif($role=="EXP"){
include('../menu/menuExpedition.php');	
}
elseif($role=="GRH"){
include('../menu/menuGRH.php');	
}elseif($role=="TST"){
include('../menu/menuTST.php');	
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
                    <h1 class="page-header">Congé  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
         Demande congé
 </div>
 <div class="panel-body" >
<?php
include('../connexion/connexionDB.php');
$sql=mysql_query("SELECT matricule from users1 where ID='$userID'");
if(@mysql_num_rows($sql)>0){
$matricule=mysql_result($sql,0);
$sql1=mysql_query("SELECT nom from personnel_info where matricule='$matricule'");
$nom=mysql_result($sql1,0);
}else{
$matricule=0;
$nom="";
}

?>
<form role="form" method="post" name="formD" id="formD" action="../php/demande_conge.php" >
    <div class="col-lg-12">
        <div class="col-lg-4">
            <div class="form-group">
                <label>Matricule</label>
				<input type="text" id="matricule" class="form-control" name="matricule" value="<?php echo $matricule ; ?>" READONLY>
				<p class="help-block"><?php echo $nom ; ?></p>
			</div>
			
		</div>
    </div>
	<div class="col-lg-12">
        <div class="col-lg-6">
			<div class="form-group">
                <label>Periode congé</label>
				<div class="form-inline">	
				    <input type="date" class="form-control" placeholder="aaaa-mm-jj" name="dateD" id="dateD">
					<input type="date" class="form-control"  placeholder="aaaa-mm-jj" name="dateF" id="dateF">
					<p class="help-block">From ...To ...</p>
                </div>
            </div>
			<div class="form-group">
                <label>Durée</label>
				    <div class="form-inline">
					<input type="text" class="form-control"  placeholder="Total des heures" name="nbrH" id="nbrH">
					 <input type="button" onClick="calculNBR();" class="btn btn-danger" Value="? ">
					<p class="help-block">Vous pouvez calculer le nombre d'heure en cliquant sur le button "?"</p>
                    </div>
            </div>
			
             <div class="form-group">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="typeC" id="typeC1" value="Annuel" checked>Annuel
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="typeC" id="typeC2" value="Mariage">Mariage
                    </label>
                </div>
				<div class="radio-inline">
                    <label>
                        <input type="radio" name="typeC" id="typeC3" value="Autre">Autre
                    </label>
                </div>
            </div>
            <input type="button" onClick="verif();" class="btn btn-default blue" Value="Envoyer >> ">
        </div>
    </div>
</form>
</div>
</div>
</div>
</div>

</div>

</body>

</html>