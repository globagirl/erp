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
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<script src="../jquery/jquery-latest.min.js"></script>		
		<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
		<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
		<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
		<script src="../bootstrap/js/bootbox.min.js"></script>
		<title>Sortie Stock</title>
		<script>
		//affichage de la liste des articles
		function afficheArticle(){	
		    var recherche = document.getElementById("recherche").value;
			var valeur = document.getElementById("valeur").value;
			if(valeur==""){
                bootbox.alert("Donnez un PO un un OF SVP !!");
		    }else{
			    var typeS = document.querySelector('input[name=typeS]:checked').value;
				$.ajax({
				type: 'POST',
				data : 'recherche=' + recherche +'&valeur=' + valeur+'&typeS=' + typeS,
				url: '../php/sortie_affiche_article3.php',
				success: function(data) {
		            if(data != "0"){
                        $('#divProd').html(data);
						var A="A1";
						liste_article(A);
				
					}else{
			            bootbox.alert("verifier vos valeur svp ");
                    }			
                }}); 
            }
		}
		////Affichage des listes des paquets 
		function affichelisteP(art,p){
		    var prd="#"+p;
            var liste = document.getElementById(art);
			var valeur = liste.options[liste.selectedIndex].value;
			if(valeur=="0"){
	            bootbox.alert("Selectionnez un article SVP !!");
            }else{
			    $.ajax({
				type: 'POST',
				data : 'article=' + valeur,
				url: '../php/sortie_liste_paquet.php',
				success: function(data) {		            
                        $(prd).html(data);
								
                }}); 
			}
		}
	    //Stock paquet
		function stockP(p,s,x){	 
            var v=0;
			var n=1;
			var liste = document.getElementById(p);
			var valeur = liste.options[liste.selectedIndex].value;
            			
			if(valeur=="S"){
	            bootbox.alert("Selectionnez un paquet SVP !!");
            }else if(valeur != "R"){
			   
                if (x>1){
                    while((n<x ) && (v==0)){
	                    var P1="P"+n;
						var L1 = document.getElementById(P1);
						var val1 = L1.options[L1.selectedIndex].value;
						if(val1==valeur){
	                        v=1;
	                    }else{
	                        n++;
	                    }
		            }
				}
	            if(v==0){
	                $.ajax({
                    type: 'POST',
                    data : 'paq=' + valeur,
                    url: '../php/sortie_stock_paquet.php',
                    success: function(data) {
	                    document.getElementById(s).value=data;
          
	                }});
	            }else{
	                bootbox.alert("Ce paquet existe déja ");
		            document.getElementById(p).selectedIndex =0;
	            }
            }else{
			    
			    var ar="A"+x;
				var liste= document.getElementById(ar);
				var art = liste.options[liste.selectedIndex].value;
				
			    $.ajax({
                    type: 'POST',
                    data : 'paq='+valeur+'&art='+art,
                    url: '../php/sortie_stock_paquet.php',
                    success: function(data) {
	                    document.getElementById(s).value=data;
						
	                }});
			}
        }
		///////////////
        function verifier(){	 
            var nbr=document.getElementById('nbr').value;
			var v=0;
			var j=1;
			while ((j<=nbr)&&(v==0)){          
			    var s="S"+j;
				var q="Q"+j;
				var st=document.getElementById(s).value;
				var qt=document.getElementById(q).value;
				st=parseFloat(st);
				qt=parseFloat(qt);
				if(st<qt){
		            v=1;
					document.getElementById(q).style.backgroundColor='pink'; 
	            }else{
		            j++;
				}
            }
            if(v==0){
                document.getElementById('form1').submit();
            }else{
                alert("Vérifier vos valeur SVP !!");
            }
		}

        //Ajout zone
        function add(){
            var i=document.getElementById('nbr').value; 
			var paq="#paq"+i;
			i++;   
			var A="A"+i;
			var A2="#A"+i;
			var P="P"+i;
			var S="S"+i;
			var Q="Q"+i;
			var paqID="paq"+i;
			$(paq).after('<div id='+paqID+' class="col-md-8 well"><div class="form-group form-inline">  <select id='+A+' name='+A+' class="form-control"  onChange=affichelisteP("'+A+'","'+P+'");   > <option value="1">---Selectionnez</option></select> <select id='+P+' name='+P+'  onChange=stockP("'+P+'","'+S+'","'+i+'"); class="form-control"><option value="1">---Selectionnez</option></select> <input type="text"  class="form-control" id='+S+' name='+S+' size="8" READONLY> <input type="text" class="form-control" id='+Q+'  name='+Q+' size="8" placeholder="QTY" ></div></div>');
			liste_article(A);
			document.getElementById('nbr').value=i;
        }
		//Liste des articles d'un produit 
		function liste_article(A){
            var PRD=document.getElementById('PRD').value;
			var A2='#'+A;
			$.ajax({
                type: 'POST',
				data:'produit=' +PRD,
				url: '../php/sortie_liste_article.php',
				success: function(data) {
                    $(A2).html(data);
				}});
        }
		////
		function deleteZ(){
		    var i=document.getElementById('nbr').value; 
			var D="";
            if(i>1){
			    D="#paq"+i;
				$(D).remove();
				i--;
				document.getElementById('nbr').value=i;
            }
		}
		///// Désactiver l entrée 
		function desactiveEnter(){ 
		    if (event.keyCode == 13) { 
                event.keyCode = 0; 
				window.event.returnValue = false; 
            } 
		} 
        </script>
</head>
<body onKeyDown='desactiveEnter()'>
<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php 
include('../include/logOutIMG.php');
?>	
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="MAG"){
include('../menu/menuMagazin.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
        <div id='contenu'>
            <div class="container">
			    <div id="page-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">Gestion du  Stock </h1>
                        </div>           
                    </div>
					<form action="../php/sortie_stock3.php" method="POST" id="form1">
					<div class="row">
                        <div class="col-md-12">
						    <div class="panel panel-default">   
                                <div class="panel-heading"> Sortie stock  </div>							
                                <div class="panel-body"> 
								    <div class="row">								    							
										    <div class="pull-left col-md-12">
											    
												<div class="form-group">
												    <div class="radio-inline">
                                                        <label><input type="radio" name="typeS" id="T1" value="P" checked>Production</label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="typeS" id="T2" value="RL">Relance</label>
													</div>
												
             
                                                </div>
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">     
													    <option value="PO">PO</option>
														<option value="OF">Ordre fabrication</option>
														            
													    
													</select>
                                                    <input type="text" class="search form-control" id="valeur" name="valeur"  onKeyup="autoComplete();" onFocus="autoComplete()"  onBlur="hideListe();">
												    <input type="button" onclick="afficheArticle();" class="btn btn-danger" Value=">>">
													<div class="divAuto2"><ul id="listePO"></ul></div>
												</div>
	
                                            </div>
											<div class="col-md-12" id="divProd">
											
											</div>
								    </div>
							    </div>
						    </div>
						</div>
					</div>
				    </form>
				</div>
            </div>
		</div>
						  





</body>
</html>
<?PHP 
if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Stock sortie avec succès \');</SCRIPT>';
	 //header('Location: ../pages/ajout_fact.php');
	 } else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! veuillez réessayer SVP \');</SCRIPT>';}
} 
?>