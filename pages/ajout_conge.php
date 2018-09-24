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
		<title>Congé</title>
        <script>
		        
		////////////////////////LISTE LIKE GOOGLE :) /////////////
        function autoComplete(c,l){
		    var liste = document.getElementById('recherche');
			var R = liste.options[liste.selectedIndex].value;
			var zoneC="#"+c;
			var zoneL="#"+l;
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
        function hideListe(l) {
		    var zoneL="#"+l;
			$(zoneL).hide();
	    }
		//
		function choixListe(p,z) {
            var ch=p.replace("|"," ");
            ch=ch.replace("|"," ");
			ch=ch.replace("|"," ");
			ch=ch.replace("|"," ");
	        $(z).val(ch);
	
        }
        //////////////////////////FIN///////////////
		
		function addConge(){
	        
			var liste = document.getElementById('recherche');
			var R = liste.options[liste.selectedIndex].value;
			var val = document.getElementById('valeur').value;
			var dateD = document.getElementById('dateD').value;
			var dateF = document.getElementById('dateF').value;
      var nbr=0;
			if(dateD=="" || dateF=="" || val=="" ){
          bootbox.alert("Vérifier vos donnée SVP !! ");
      }else{
        //Vérif
         if ($('#demiJD').is(':checked')) {
           nbr=nbr+4;
         }
         if ($('#demiJF').is(':checked')) {
           nbr=nbr+4;
         }
			    $.ajax({
            type: 'POST',
			      data:'recherche='+R+'&valeur='+val+'&dateD='+dateD+'&dateF='+dateF+'&nbr='+nbr,
			      url: '../php/conge_verif.php',
				    success: function(data) {        
              if(data == '1'){
				        bootbox.alert("Congé existe déja !! ");
              }else if(data == '0'){
	              document.getElementById('form1').submit();
				      }else{
                bootbox.alert("Vous avez dépassé le plafond , Total congé déja pris : "+data+" jours");
              }
			    }});
		    }
		}
    </script>
</head>
<body>
    <div id="entete">
	    <div id="logo"></div>
        <div id="boton"><?php include('../include/logOutIMG.php');?></div>
    </div>
	<div id="main">
	    <div id="menu">
		    <?php
			    if($role=="ADM"){
                    include('../menu/menuAdmin.php');
                }else if($role=="GRH"){
				    include('../menu/menuGRH.php');	
                }else{
                    header('Location: ../deny.php');
				}
            ?>
        </div>
		
		<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
     <div class="col-md-12">
        <h1 class="page-header">Congé</h1>
     </div>              
</div>
<div class="row">
<div class="col-md-12" >
<div class="panel panel-default">
<div class="panel-heading"> Ajout congé </div>
<div class="panel-body" >
  <form role="form" method="post" name="form1" id="form1" action="../php/ajout_conge.php">
	 <div class="well">
	   <div class="row">
	     <div class="col-md-7">	
            		 
		    <div class="form-group">
			  <label>Personnel:</label>	
		      <div class="form-inline">
		        <select name="recherche" id="recherche" class="form-control" >
			      <option value="nom">Nom</option>
			      <option value="matricule">Matricule</option> 
	             	
                </select> 
			    <span id="zone">
			      <input type="text" name="valeur" id="valeur"  class="form-control" onBlur="hideListe('listeP1');" onKeyup="autoComplete('valeur','listeP1'); " onFocus="autoComplete('valeur','listeP1')">
			    </span>
				<div class="divAuto2"><ul id="listeP1" ></ul></div>
		     </div>
	       </div>
		     
           <div class="form-group">
		     <label>Marge par date:</label>	
             <div class="form-inline">		
               <input class="form-control" id="dateD" name="dateD" type="date"> 
		       <input class="form-control" id="dateF" name="dateF" type="date">		
		       
             </div>
           </div>            
		   <div class="form-group form-inline">
			  
               <div class="checkbox">
                  <label>
                     <input type="checkbox" id="demiJD" name="demiJD"> 1/2 journée le premier jour
                  </label>
               </div>
			   <div class="checkbox">
                  <label>
                     <input type="checkbox" id="demiJF" name="demiJF"> 1/2 journée le dernier jour 
                  </label>
               </div>
			 
           </div> 
           </div> 
		   <div class="col-md-5">	
		   <div class="form-group">	
             <label>Type congé:</label>		
             			 
               <div class="radio">
                  <label>
                     <input type="radio" name="typeC" id="typeC1" value="Annuel" checked>Annuel
                  </label>
               </div>
			   <div class="radio">
                  <label>
                     <input type="radio" name="typeC" id="typeC2" value="Mariage">Mariage
                  </label>
               </div> 
			   <div class="radio">
                  <label>
                     <input type="radio" name="typeC" id="typeC3" value="Maladie">Maladie
                  </label>
               </div>
			   <div class="radio">
                  <label>
                     <input type="radio" name="typeC" id="typeC4" value="Autre">Autre
                  </label>
               </div>			 
            	 
           </div> 
          			  
           <div class="form-group">	
              <label>Payment congé:</label>			   
           		  
               <div class="radio">
                  <label>
                     <input type="radio" name="payC" id="payC1" value="N" checked> Non Payé
                  </label>
               </div>
               <div class="radio">
                  <label>
                     <input type="radio" name="payC" id="payC2" value="P">Payé
                  </label>
               </div>
               <div class="radio">
                  <label>
                     <input type="radio" name="payC" id="payC2" value="PN">Payé Non attribué
                  </label>
               </div>
         
			 
           </div> 		   
		</div><!--div row 3 -->
		<!--</div>--div row 3 -->
		
        <div class="col-md-12">
           <input type="button" class="btn btn-primary" onclick="addConge();" id="add1" value="Ajouter >> "> 		
          	
		</div>
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

	</div>
</body>
</html>

