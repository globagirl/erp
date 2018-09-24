<html>

<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />


<title>
Modification Fournisseur
</title>

<script>
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no') 
}
</script>
<SCRIPT LANGUAGE="javascript"> 
function sendata()

{
var nom=document.getElementById("nom_four").value;
var adr=document.getElementById("adr").value;
var adr_magas=document.getElementById("adr_magas").value;

var pays=document.getElementById("pays").value;
var cont_1=document.getElementById("cont_1").value;
var cont_2=document.getElementById("cont_2").value;
var tel_1=document.getElementById("tel_1").value;
var tel_2=document.getElementById("tel_2").value;
var mail_1=document.getElementById("mail_1").value;
var mail_2=document.getElementById("mail_2").value;
var fax_1=document.getElementById("fax_1").value;
var fax_2=document.getElementById("fax_2").value;

 
   $.ajax({
 type: "POST",
 url: "../php/modif_four.php",
 data: {
 
 nom:nom_four, adr:adr, adr_magas:adr_magas, pays:pays, cont_1:cont_1, cont_2:cont_2,
 
 tel_1:tel_1, tel_2:tel_2, mail_1:mail_1, mail_2:mail_2, fax_1:fax_1, fax_2:fax_2
 
 
 
 
 }
 }).done(function( result ) {
 if (result==0)
 {
 alert( " erreur de sauvegarde  ");
 }
 else{
 if (result==1)
 {
alert( " Terminé Avec Succèes ");
 }
 }
 });
    
 }

           
		      
			               
      document.form1 = function onLoadDo()
	  {
 var enterpressed = onLoadDo()? onLoadDo().which == 13: window.event.keyCode == 13;
 if (enterpressed){
 	document.form1.submit();
 	return false;
 }
}

			   
			   
		      </SCRIPT> 
</head>

<body onload="onLoadDo()">



<div id="entete">

<div id="logo">


</div>

<div id="boton">



</div>


</div>


<div id="main">



<div id="contenu">
<!-- began --> 
<BR>
<p class="two">COMMERCIAL</p>
<div id="global">
<div id="mbmcpebul_wrapper" style="max-width: 665px;">
  <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
  <li class="first_button"><div class="buttonbg gradient_button gradient30"><div class="arrow"><a>Gérer Commande</a></div></div>
    <ul>
    <li class="first_item"><a href="com_ajout_command.php">Ajout Commande</a></li>
    <li><a href="com_modif_command.php">Modification Commande</a></li>
    <li><a href="com_supp_command.php">Suppression Commande</a></li>
    <li class="last_item"><a href="com_consulter_command.php">Consulter Commandes</a></li>
    </ul></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 105px;"><div class="arrow"><a>Gérer Achats</a></div></div>
    <ul>
    <li class="first_item"><a href="com_afficher_achat.php">Consulter les Bon de commande</a></li>
    <li><a href="ach_b_c.php">Ajout Bon de commande</a></li>
		<li><a href="modif_oa.php">Modification Bon de commande</a></li>
	<li><a href="print_oa.php">Impression Bon de commande</a></li>
    <li class="last_item"><a href="com_supp_ordre_achat.php">Suppression Bon de commande</a></li>
    </ul></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 120px;"><div class="arrow"><a>Bon de livraison</a></div></div>
    <ul>
    <li class="first_item"><a href="ajout_bl.php">Création BL</a></li>
    <li><a href="consult_bl.php">Consulter BL</a></li>
	<li><a href="supp_bl.php">Suppression BL</a></li>
    <li class="last_item"><a href="print_bl.php">Impression BL</a></li>
    </ul></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 73px;"><div class="arrow"><a>Facture</a></div></div>
    <ul>
    <li class="first_item"><a href="ajout_fact.php">Création Facture</a></li>
    <li><a href="consult_fact.php">Consulter Facture</a></li>
	<li><a href="supp_fact.php">Suppression Facture</a></li>
    <li class="last_item"><a href="print_fact.php">Impression Facture</a></li>
    </ul></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 98px;"><div class="arrow"><a>Gérer Client</a></div></div>
    <ul>
    <li class="first_item"><a href="consulter_clt.php">Consulter client</a></li>
    <li><a href="ajout_client.php">Ajout client</a></li>
    <li><a href="supp_clt.php">Suppression client</a></li>
    <li class="last_item"><a href="modif_clt.php">Modification client</a></li>
    </ul></li>
  <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 120px;"><div class="arrow"><a>Gérer Fournisseur</a></div></div>
    <ul>
    <li class="first_item"><a href="consulter_four.php">Consulter Fournissuer</a></li>
    <li><a href="ajout_four.php">Ajout Fournissuer</a></li>
    <li><a href="modif_four.php">Modification Fournissuer</a></li>
    <li class="last_item"><a href="supp_four.php">Suppression Fournissuer</a></li>
    </ul></li>
  </ul>
</div>
</div>
<p class="there">Modification Fournisseur</p>
<br>

<!-- end --> 


<TABLE BORDER="0"> 
                    <form name="form" method="POST">
                                <tr>
								
								
                                   <Th WIDTH=30 HEIGHT=30 ALIGN="left">Nom fournisseur </Th> 
								   
								   <Td><input type="text" name="nom_four" SIZE="8"> </Td> 
                                   
								   	   					   	
								   
                                 </tr>
                   </form>





		<!-- ligne 1 du tablau-->
		
		<form method="POST" name="form1" action="../php/modif_four.php">
		
		 <tr>
		
		<td colspan="0"> </Td>
		           <th HEIGHT=20 colspan="2" align= "center" bgcolor="#63FFB2">
		
								   <?php
							   include('../connexion/connexionDB.php');
								
								$nom_four= @$_POST['nom_four'];
								
								
								?>
	
								Nom fournisseur: 							   
						    
							     <?php
							echo $nom_four;
							echo "<input name=\"nom_four\" id=\"nom_four\" value=\"".$nom_four."\"/  hidden> ";
						   ?>	
		
		</tr>
		
		
		
			<tr>			
                           <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Adresse fournisseur</Th> 
                                 <Td>		 
                                        <?php
									   $a_four = mysql_query ("SELECT adr FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $a_four = mysql_fetch_array($a_four);
									   
						              
										echo "<textarea rows=5 cols=30  type=text name=adr_client > ".$a_four['adr']."</textarea>";
						                ?>								 
								 </Td>
								 
								 
								 <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Adresse magasin</Th> 
                                 <Td>		 
                                        <?php
									   $a_mag = mysql_query ("SELECT adr_magas FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $a_mag = mysql_fetch_array($a_mag);
									   
						              
										echo "<textarea rows=5 cols=30  type=text name=adr_magas > ".$a_mag['adr_magas']."</textarea>";
						                ?>								 
								 </Td>
								 
								 
								 
				</tr>
<tr>			
                           
 
        </TR> 
		 
		 <!-- ligne 2 du tableau-->
		 
      <tr>				
                             <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Pays fournisseur</Th> 
                                 <Td>		 
                                        <?php
									   $pay_four = mysql_query ("SELECT pays FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $pay_four = mysql_fetch_array($pay_four);
									   
						                echo "<input name=\"pays\" id=\"pays\" value=\"".$pay_four['pays']."\"/> ";
						                ?>								 
								 </Td>
 
        </TR>                          
							
			<tr>				
                            <Th>contact 1</Th> 
                            <Td>
							   <?php
									   $c_1 = mysql_query ("SELECT contact_1 FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $c_1 = mysql_fetch_array($c_1);
									   
						                echo "<input \" name=\"contact_1\" id=\"contact_1\" value=\"".$c_1['contact_1']."\"/> ";
						                ?>	
							</Td>
   <Th>contact 2</Th> 
                            <Td>
							   <?php
									   $c_2 = mysql_query ("SELECT contact_2 FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $c_2 = mysql_fetch_array($c_2);
									   
						                echo "<input \" name=\"contact_2\" id=\"contact_2\" value=\"".$c_2['contact_2']."\"/> ";
						                ?>	
							</Td>
							
							</tr>
							<tr>
  <Th>tel 1</Th> 
                            <Td>
							   <?php
									   $t_1 = mysql_query ("SELECT tel_1 FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $t_1 = mysql_fetch_array($t_1);
									   
						                echo "<input \" name=\"tel_1\" id=\"tel_1\" value=\"".$t_1['tel_1']."\"/> ";
						                ?>	
							</Td>
 
       				
                            <Th>tel 2</Th> 
                            <Td>
							   <?php
									   $t_2 = mysql_query ("SELECT tel_2 FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $t_2 = mysql_fetch_array($t_2);
									   
						                echo "<input \" name=\"tel_2\" id=\"tel_2\" value=\"".$t_2['tel_2']."\"/> ";
						                ?>	
							</Td>
							
							
		 </TR> 					
			<TR> 					
							   <Th>E-mail 1</Th> 
                            <Td>
							   <?php
									   $m_1 = mysql_query ("SELECT mail_1 FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $m_1 = mysql_fetch_array($m_1);
									   
						                echo "<input \" name=\"mail_1\" id=\"mail_1\" value=\"".$m_1['mail_1']."\"/> ";
						                ?>	
							</Td>
 
       
			          
  
  	
						
                            <Th>E-mail 2</Th> 
                            <Td>
							   <?php
									   $m_2 = mysql_query ("SELECT mail_2 FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $m_2 = mysql_fetch_array($m_2);
									   
						                echo "<input \" name=\"mail_2\" id=\"mail_2\" value=\"".$m_2['mail_2']."\"/> ";
						                ?>	
							</Td>
							
					</TR> 	
<TR> 						
							
							  <Th>Fax 1</Th> 
                            <Td>
							   <?php
									   $f_1 = mysql_query ("SELECT fax_1 FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $f_1 = mysql_fetch_array($f_1);
									   
						                echo "<input \" name=\"fax_1\" id=\"fax_1\" value=\"".$f_1['fax_1']."\"/> ";
						                ?>	
							</Td>
 
 
 
       			
							
							
							
							 
							
                                <Th>Fax 2</Th> 
                                <Td>
							   <?php
									   $f_2 = mysql_query ("SELECT fax_2 FROM fournisseur WHERE nom ='$nom_four' ");
									   
									   $f_2 =@mysql_fetch_array($f_2);
									   
						                echo "<input \" name=\"fax_2\" id=\"fax_2\" value=\"".$f_2['fax_2']."\"/> ";
						                ?>	
							    </Td>
        </TR> 
  
  
  </form>
  
 </TABLE>  
 
 
   


  <input type="button" id="submitbutton" onclick="sendata()" value="Valider">
<input onclick="pop_up('../php/afich_four.php');" type="button" value="Afficher Liste fournisseur" id="bigbutton"><br>

 
 



</div>

</div>

</body>

</html>