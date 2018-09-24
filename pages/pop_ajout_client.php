<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
?>
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
Ajout Client
</title>
<script>
function ajout(){
	document.forms['formCl'].submit(); 
	
	
}
</script>

</head>

<body>





<!-- began --> 
<BR>

<p class="there">Ajout Client</p>
<br>

<!-- end --> 


<form method="post" action="../php/pop_ajout_client.php" id="formCl">


<TABLE BORDER="0"> 

		<TR> 
			<Th WIDTH=150 HEIGHT=30  ALIGN="left" >Client </Th> 
			<TD colspan="4"><input type="text" name="clt" SIZE="18" MAXLENGTH="8"></TD> 

		</TR> 
  
  
		<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">adresse client</TH> 
			<TD><input type="text" name="adr_clt" SIZE="40" MAXLENGTH="30"></TD> 
			 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Pays </TH> 
 <TD colspan="3"> <input type="text" name="pays" SIZE="30" MAXLENGTH="30"></TD>
 </tr>
			
			<tr>
			<Th WIDTH=30 HEIGHT=30 ALIGN="left">adresse livraison </Th> 
            <Td><input type="text" name="adr_liv" SIZE="40" ></Td> 
			
            <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >adresse facturation</Th> 
            <Td><input type="text" name="adr_fact" SIZE="40" ></Td>
		</TR> 
 



<TR> 
 <TH WIDTH=100 HEIGHT=30  ALIGN="left">contact 1   </TH> 
 <TD > <input type="text" name="ctc_1"> </TD> 
  <TH WIDTH=100 HEIGHT=30  ALIGN="left">contact 2  </TH> 
 <TD > <input type="text" name="ctc_2"> </TD> 
 </tr>
 <tr>
 <TH WIDTH=100 HEIGHT=30  ALIGN="left">E-mail 1</TH> 
 <TD ><input type="text" name="mail_1" SIZE="30" MAXLENGTH="30" placeholder="exemple@serveur.com" ></TD>
 
 <TH WIDTH=100 HEIGHT=30  ALIGN="left">E-mail 2</TH> 
 <TD ><input type="text" name="mail_2" SIZE="30" MAXLENGTH="30" placeholder="exemple@serveur.com" ></TD>
 </tr>
 <tr>
 <Th WIDTH=30 HEIGHT=30 ALIGN="left">tél 1 </Th> 
 <Td><input type="text" name="tel_1" SIZE="8" ></Td> 
  <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >tél 2</Th> 
 <Td><input type="text" name="tel_2" SIZE="8" ></Td>
 </TR>
 <TR>
 <Th WIDTH=30 HEIGHT=30 ALIGN="left">fax 1 </Th> 
 <Td><input type="text" name="fax_1" SIZE="8" ></Td>
 <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >fax 2</Th> 
 <Td><input type="text" name="fax_2" SIZE="8" ></Td> 
 
 </TR>
 <tr>
 			<td></td><td><input type="buttton" value="submit" id="submitbutton" onClick="ajout();"> 
</td>
 </tr>
	
</TABLE> 


		 
		
		 
	
 
</form>


</body>

</html>