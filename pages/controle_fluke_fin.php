<?php
 session_start ();
 $role=@$_SESSION['role'];
$userID=@$_SESSION['userID'];
include('../connexion/connexionDB.php');
?>
<html>

<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Controle Fluke
</title>
 <SCRIPT> 


            function myF1()
              {

               var qtei=document.getElementById("qte_e");
               qtei.innerHTML="";
               var x=document.getElementById("qte_e").value; 
 
                    if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/)))   
                     {  
                       qtei.value="saisi incorrect";
                       qtei.style.background="#DB5776";
                      return false;
                     }
                    else
                     {
                    return true;  
                     }
                      }
			   


            function myF2()
              {

               var qtei=document.getElementById("qte_s");
               qtei.innerHTML="";
               var x=document.getElementById("qte_s").value; 
 
                    if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/)))   
                     {  
                       qtei.value="saisi incorrect";
                       qtei.style.background="#DB5776";
                      return false;
                     }
                    else
                     {
                    return true;  
					document.getElementById("N_D").value = document.getElementById("qte_e").value - document.getElementById("qte_s").value;
                     }
					 }
			
				function calc()
			{
                     
					document.getElementById("nbr_def").value = document.getElementById("qte_e").value - document.getElementById("qte_s").value;
                     }

             function a1(status)
                {
             status=!status;
			 document.pro_sert.qd1.disabled=status;
			 }
			 
			 function a2(status)
                {
             status=!status;			
			 document.pro_sert.qd2.disabled=status;
                }

             function a3(status)
                {
             status=!status;			
			 document.pro_sert.qd3.disabled=status;
                }

             function a4(status)
                {
             status=!status;			
			 document.pro_sert.qd4.disabled=status;
                }
				
             function a5(status)
                {
             status=!status;			
			 document.pro_sert.qd5.disabled=status;
                }
		  
		      function a6(status)
                {
             status=!status;			
			 document.pro_sert.qd6.disabled=status;
                }
				
				function a7(status)
                {
                status=!status;			
			    document.pro_sert.qd7.disabled=status;
                }

			  
			   function del1()
                   {
                  document.forms['pro_sert'].qte_e.value="";
                       document.forms['pro_sert'].qte_e.style.background = "#FFFFFF";
                   }

			   function del2()
                   {
                  document.forms['pro_sert'].qte_s.value="";
                       document.forms['pro_sert'].qte_s.style.background = "#FFFFFF";
                   }
///
function affichePlan(){
		 
 var valeur = document.getElementById("plan").value;
 if(valeur==""){
	 alert("Selectionnez un plan SVP !!");
 }
 else{
   $.ajax({
           type: 'POST',
		   data:'plan=' +valeur,
           url: '../php/affichePlanCF2.php',
           success: function(data) {
           $('#tab').html(data);
		   document.getElementById("tab2").style.visibility = "visible";

           }});
 
 ///
	
}
}   		      			                
</SCRIPT> 
</head>

<body onload="a1(false),a2(false),a3(false),a4(false),a5(false),a6(false),a7(false)">
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
elseif($role=="TSF"){
include('../menu/menuTSF.php');	
}elseif($role=="TST"){
include('../menu/menuTST.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}
else{
	 include('../menu/menuTST.php');	
}
?>
</div>
<div id='contenu'>


<br>
<p class="there">Controle Fluke > fin opération</p>
<br>

<!-- end --> 






<form  method="post" action="../php/ajoutFluke2.php">
      <?php 
						  $numD=$_SESSION['idCF'];
						  $sql33 = mysql_query("SELECT * FROM pro_contr_fluke where num_fluk='$numD'");
                          $data2=mysql_fetch_array($sql33);
                          $plan=$data2['plan'];
                          $qtE=$data2['qte_e'];
						  $dateD=$data2['date_debut'];
						  echo("<table><TR><th>Plan: </th>
                          <td> <input  type=\"text\" size=\"15\" id=\"plan\" value=\"".$plan."\"/  READONLY></td>
                          <Th Wcode_articleTH=150 HEIGHT=30  >Quantité entrée :</Th>
                          <td><input  type=\"text\" size=\"10\" id=\"qte_e\" value=\"".$data2['qte_e']."\"/ READONLY></td>
						  <Th Wcode_articleTH=150 HEIGHT=30  > Debut :</Th>
                          <td><input  type=\"text\" size=\"10\" id=\"dateD\" value=\"".$dateD."\"/ READONLY></td></tr>
                          </table>");
						  ?>                         


<TABLE  BORDER="0">    


		
    <TR> 
                          <TH width=200 ALIGN="left">Agent Contrôle: *</TH> 
                          <TD >
                            <select name="ag_cont">
								<?php
								

								$nom_prenom_list = mysql_query("SELECT nom,prenom FROM agent_qual1 WHERE tache ='test' ");

								while ($row = mysql_fetch_array($nom_prenom_list)){
								echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
								}

								?>
								</select>	
                          </TD>
        </TR>



		

		
		
        <TR>  
                            <TH colspan=2> Résultat d'échantillonage:</TH> 
						                   		  
        </TR>
		
		
  
     <TR>
	         <td colspan=2>
			 
               <input type="radio" name="CONT_fluke" value="PASS">PASS<br>
               <input type="radio" name="CONT_fluke" value="FAILED">FAILED
          
	         </td>
	 </TR> 
	 <tr><td></td><td>
	  <input type="submit" name="valider" id="submitbutton"></td>
 </TABLE>  



 
 
</form>


</div>

</div>

</body>

</html>