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
Modification Client
</title>

<script>
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no') 
}
</script>
<SCRIPT LANGUAGE="javascript"> 
function sendata()

{
var nom_clt=document.getElementById("nom_clt").value;
var adr_client=document.getElementById("adr_client").value;
var adress_fact=document.getElementById("adress_fact").value;
var adress_liv=document.getElementById("adress_liv").value;
var pays_client=document.getElementById("pays_client").value;
var cont1=document.getElementById("cont1").value;
var cont2=document.getElementById("cont2").value;
var tel1=document.getElementById("tel1").value;
var tel2=document.getElementById("tel2").value;
var mail1=document.getElementById("mail1").value;
var mail2=document.getElementById("mail2").value;
var fax1=document.getElementById("fax1").value;
var fax2=document.getElementById("fax2").value;

 
   $.ajax({
 type: "POST",
 url: "../php/modif_clt.php",
 data: {nom_clt:nom_clt, adr_client:adr_client, adress_fact:adress_fact, adress_liv:adress_liv, pays_client:pays_client, cont1:cont1, cont2:cont2, tel1:tel1, tel2:tel2,
 mail1:mail1, mail2:mail2, fax1:fax1, fax2:fax2}
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
<p class="there">Modification Client</p>
<br>

<!-- end --> 



<TABLE BORDER="0"> 
                    <form name="form" method="POST">
                                <tr>
								
								
                                   <Th WIDTH=30 HEIGHT=30 ALIGN="left">Nom Client </Th> 
								   
								   <Td><input type="text" name="nom_clt" SIZE="8"> </Td> 
                                   
								   	   					   	
								   
                                 </tr>
                   </form>





		<!-- ligne 1 du tableau-->
		
		<form name="form1" method="POST" action="../php/modif_clt.php">
		
		 <tr>
		
		<td colspan="0"> </Td>
		           <th HEIGHT=20 colspan="2" align= "center" bgcolor="#63FFB2">
		
								   <?php
							   include('../connexion/connexionDB.php');
								
								$nom_clt= @$_POST['nom_clt'];
								
								
								?>
	
								Nom CLIENT: 							   
						    
							     <?php
							echo $nom_clt;
							echo "<input name=\"nom_clt\" id=\"nom_clt\" value=\"".$nom_clt."\"/  hidden> ";
						   ?>	
		
		</tr>
		
		
		
			<tr>			
                           <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Adresse client</Th> 
                                 <Td>		 
                                        <?php
									   $a_clt = mysql_query ("SELECT adr_client FROM client WHERE name_client ='$nom_clt' ");
									   
									   $a_clt = mysql_fetch_array($a_clt);
									   
						              
										echo "<textarea rows=5 cols=30  type=text name=adr_client id=adr_client> ".$a_clt['adr_client']."</textarea>";
						                ?>								 
								 </Td>
				</tr>
<tr>			
                           <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Adresse facturation</Th> 
                                 <Td>		 
                                        <?php
									   $a_fact = mysql_query ("SELECT adress_fact FROM client WHERE name_client ='$nom_clt' ");
									   
									   $a_fact = mysql_fetch_array($a_fact);
									   
										echo "<textarea rows=5 cols=30  type=text name=adress_fact id=adress_fact > ".$a_fact['adress_fact']."</textarea>";
										
						                ?>								 
								 </Td>
				</tr>
<tr>				
                            <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Adresse Livraison</Th> 
                                 <Td>		 
                                        <?php
									   $a_liv = mysql_query ("SELECT adress_liv FROM client WHERE name_client ='$nom_clt' ");
									   
									   $a_liv =@mysql_fetch_array($a_liv);
									   
										
										echo "<textarea rows=5 cols=30  type=text name=adress_liv > ".$a_liv['adress_liv']."</textarea>";
						                ?>								 
								 </Td>
 
        </TR> 
		 
		 <!-- ligne 2 du tableau-->
		 
      <tr>				
                             <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Pays client</Th> 
                                 <Td>		 
                                        <?php
									   $pay_clt = mysql_query ("SELECT pays_client FROM client WHERE name_client ='$nom_clt' ");
									   
									   $pay_clt = mysql_fetch_array($pay_clt);
									   
						                echo "<input name=\"pays_client\" id=\"pays_client\" value=\"".$pay_clt['pays_client']."\"/> ";
						                ?>								 
								 </Td>
 
        </TR>                          
							
			<tr>				
                            <Th>contact 1</Th> 
                            <Td>
							   <?php
									   $c_1 = mysql_query ("SELECT cont1 FROM client WHERE  name_client ='$nom_clt' ");
									   
									   $c_1 = mysql_fetch_array($c_1);
									   
						                echo "<input \" name=\"cont1\" id=\"cont1\" value=\"".$c_1['cont1']."\"/> ";
						                ?>	
							</Td>
 <Th>contact 2</Th> 
                            <Td>
							   <?php
									   $c_2 = mysql_query ("SELECT cont2 FROM client WHERE  name_client ='$nom_clt' ");
									   
									   $c_2 = mysql_fetch_array($c_2);
									   
						                echo "<input \" name=\"cont2\" id=\"cont2\" value=\"".$c_2['cont2']."\"/> ";
						                ?>	
							</Td>
 
 </tr>
 
  <Th>tel 1</Th> 
                            <Td>
							   <?php
									   $t_1 = mysql_query ("SELECT tel1 FROM client WHERE  name_client ='$nom_clt' ");
									   
									   $t_1 = mysql_fetch_array($t_1);
									   
						                echo "<input \" name=\"tel1\" id=\"tel1\" value=\"".$t_1['tel1']."\"/> ";
						                ?>	
							</Td>
 
 		
                            <Th>tel 2</Th> 
                            <Td>
							   <?php
									   $t_2 = mysql_query ("SELECT tel2 FROM client WHERE  name_client ='$nom_clt' ");
									   
									   $t_2 = mysql_fetch_array($t_2);
									   
						                echo "<input \" name=\"tel2\" id=\"tel2\" value=\"".$t_2['tel2']."\"/> ";
						                ?>	
							</Td>
							
							
							
							
 
        </TR> 
 <tr>
							   <Th>E-mail 1</Th> 
                            <Td>
							   <?php
									   $m_1 = mysql_query ("SELECT mail1 FROM client WHERE  name_client ='$nom_clt' ");
									   
									   $m_1 = mysql_fetch_array($m_1);
									   
						                echo "<input \" name=\"mail1\" id=\"mail1\" value=\"".$m_1['mail1']."\"/> ";
						                ?>	
							</Td>
 
 	
                            <Th>E-mail 2</Th> 
                            <Td>
							   <?php
									   $m_2 = mysql_query ("SELECT mail2 FROM client WHERE  name_client ='$nom_clt' ");
									   
									   $m_2 = mysql_fetch_array($m_2);
									   
						                echo "<input \" name=\"mail2\" id=\"mail2\" value=\"".$m_2['mail2']."\"/> ";
						                ?>	
							</Td>
							</tr>
							<tr>
 <Th>Fax 1</Th> 
                            <Td>
							   <?php
									   $f_1 = mysql_query ("SELECT fax1 FROM client WHERE  name_client ='$nom_clt' ");
									   
									   $f_1 = mysql_fetch_array($f_1);
									   
						                echo "<input \" name=\"fax1\" id=\"fax1\" value=\"".$f_1['fax1']."\"/> ";
						                ?>	
							</Td>
 
 
 		
							
							
							
							  
							
                                <Th>Fax 2</Th> 
                                <Td>
							   <?php
									   $f_2 = mysql_query ("SELECT fax2 FROM client WHERE  name_client ='$nom_clt' ");
									   
									   $f_2 =@mysql_fetch_array($f_2);
									   
						                echo "<input \" name=\"fax2\" id=\"fax2\" value=\"".$f_2['fax2']."\"/> ";
						                ?>	
							    </Td>
        </TR> 
  
  
  </form>
  
 </TABLE>  
 
 
   


    <input type="button" id="submitbutton" onclick="sendata()" value="Valider">
	
	
    <input onclick="pop_up('../php/afich_clt.php');" type="button" value="Afficher Liste Client" id="bigbutton"><br>

 
 



</div>

</div>

</body>

</html>