<?php
session_start ();
//code vérifié
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
	<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	<script src="../jquery/jquery-latest.min.js"></script>
	<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
	<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
	<title>Pointage manuel</title>
	<script>
	var V=1; //Vérification des horaires
    //Auto Complete
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
	    var ch=ch.replace("|"," ");
	    var ch=ch.replace("|"," ");
	    var ch=ch.replace("|"," ");
	    var ch=ch.replace("|"," ");
	    $(z).val(ch);	
    }
    //FIN///////////////
	function addPointage(){	
        var val=document.getElementById("pause").value;
		var val1=document.getElementById("dateD").value;
        if(V != 1){
		    alert("Vérifier les horaires SVP !!");
	    }else if(val==""){
		    alert("Donnez le temp de pause SVP !!");
		    document.getElementById('pause').style.backgroundColor='pink'; 	 
        }else if(val1==""){
		    alert("Donnez la date de début SVP !!");
		    document.getElementById('dateD').style.backgroundColor='pink'; 	 
        } else {		
		    document.forms['form1'].submit(); 
	    }
    }
    ////
    function verifierH(x){	
        var val=document.getElementById(x).value;
        l=val.length;
	    if(l!=2){
		    alert("Exemple : 07 !!");
			document.getElementById(x).style.backgroundColor='pink'; 	 
            V=0;  
        }else{
		    V=1;
	    }
    }
    //
    function activeSamedi(){
        if(document.getElementById("chek").checked == false){
            document.getElementById("hdS").disabled = true;
			document.getElementById("mdS").disabled = true;
			document.getElementById("hfS").disabled = true;
			document.getElementById("mfS").disabled = true;
			document.getElementById("pauseS").disabled = true;
		
        }else{
	        document.getElementById("hdS").disabled = false;
			document.getElementById("mdS").disabled = false;
			document.getElementById("hfS").disabled = false;
			document.getElementById("mfS").disabled = false;
			document.getElementById("pauseS").disabled = false;
		}
	}
	//
    function activeNuit(){
        if(document.getElementById("chekNuit").checked == false){
            document.getElementById("hdN").disabled = true;
			document.getElementById("mdN").disabled = true;
			document.getElementById("hfN").disabled = true;
			document.getElementById("mfN").disabled = true;
		
		
        }else{
	        document.getElementById("hdN").disabled = false;
			document.getElementById("mdN").disabled = false;
			document.getElementById("hfN").disabled = false;
			document.getElementById("mfN").disabled = false;
			
		}
    }
	//
	function changeDateF(){
		var dateD=$('#dateD').val();
		$('#dateF').val(dateD);
	}
    </script>
</head>
<body>
    <div id="entete">
        <div id="logo"></div>
        <div id="boton">
            <?php include('../include/logOutIMG.php');?>	
        </div>
    </div>
	<div id="main">
        <div id="menu">
		    <?php
                if($role=="ADM"){
				    include('../menu/menuAdmin.php');	
                }elseif($role=="GRH"){
                    include('../menu/menuGRH.php');	
                }else{
	                header('Location: ../deny.php');
                }
            ?>
        </div>
        <div id='contenu'>
		    <br>
			<p class="there">Pointage manuel</p>
			<br>
			<hr size=2 />
			<form method="POST"  id="form1" name="form1" action="../php/pointage_manuel.php">
                <table> 
				    <tr>
		                <th rowspan=2> Horaire journaliére</th>
			            <td colspan=2> 
			                <input type="text" value="08" name="hd" id="hd" size="1" onBlur="verifierH('hd');">:			    <input type="text" value="00" name="md" id="md" size="1" onBlur="verifierH('md');"> 
							<b> >> </b>
							<input type="text" value="16" name="hf" id="hf" size="1" onBlur="verifierH('hf');">:
							<input type="text" value="30" name="mf" id="mf" size="1" onBlur="verifierH('mf');">
			            </td>
		            </tr>
		            <tr>  
		                <td colspan=2>Pause : <input type="text" value="30" name="pause" id="pause" size="1"> mn </td>
		            </tr> 
		            <tr>
		                <th rowspan=2> Horaire du samedi </th>
						<td colspan=2> 
			                <input type="text" value="08" name="hdS" id="hdS" size="1" onBlur="verifierH('hdS');" disabled>:
							<input type="text" value="00" name="mdS" id="mdS" size="1" onBlur="verifierH('mdS');" disabled>
							<b> >> </b>
							<input type="text" value="12" name="hfS" id="hfS" size="1" onBlur="verifierH('hfS');" disabled>:
							<input type="text" value="30" name="mfS" id="mfS" size="1" onBlur="verifierH('mfS');" disabled>
							<input type="checkbox" name="chek" id="chek"  value="oui" onClick="activeSamedi();">
			            </td>
		            </tr> 
		            <tr>
		                <td colspan=2>Pause : <input type="text" value="0" name="pauseS" id="pauseS" size="1" disabled> mn </td>
		            </tr> 
					<tr>
					    <th > Poste Nuit </th>
					    <td colspan=2>
						   <input type="text" value="21" name="hdN" id="hdN" size="1" onBlur="verifierH('hdN');" disabled>:
						   <input type="text" value="00" name="mdN" id="mdN" size="1" onBlur="verifierH('mdN');" disabled>
						   <b> >> </b>
						   <input type="text" value="23" name="hfN" id="hfN" size="1" onBlur="verifierH('hfN');" disabled>:
						   <input type="text" value="59" name="mfN" id="mfN" size="1" onBlur="verifierH('mfN');" disabled>
						   <input type="checkbox" name="chekNuit" id="chekNuit"  value="oui" onClick="activeNuit();">
						</td>
		            <tr>
		                <th rowspan=2>Personnel </th> 
                        <td style="width:40px">
			                <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
				                <select name="recherche" id="recherche"  class="custom-dropdown__select custom-dropdown__select--white">
								    <option value="matricule"> Matricule</option> 
									<option value="nom"> Nom & Prenom</option> 
									
									<option value="a"> ALL</option>
	                            </select> 
                            </span>
                        </td>
			            <td id="zone">
                            <input type="text" name="valeur" id="valeur" size="20" onBlur="hideListe('listeP1');" onKeyup="autoComplete('valeur','listeP1'); " onFocus="autoComplete('valeur','listeP1')">
                            <div class="divAuto2"><ul id="listeP1" ></ul></div>
                        </td>
		            </tr>
					<tr>
					    <td colspan=2>
			                <input type= "date" name="dateD" id="dateD" onChange="changeDateF();" />
							<b>To</b>
						    <input type= "date" name="dateF" id="dateF" />
			            </td>
		            </tr>

					<tr>
		                <td></td>
			            <td colspan=2><input type="button" onClick="addPointage();" value="Add >> " id="submitbutton"></td>
	                </tr>		
                </table>
            	<hr size=2 />
            </form>
		</div>
    </div>
</body>
</html>
<?PHP 

if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Pointage manuel ajouté avec succès \');</SCRIPT>';
	 
	 } else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! veuillez réessayer SVP \');</SCRIPT>';}
} 
?>
