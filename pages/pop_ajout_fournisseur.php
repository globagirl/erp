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
Ajout Fournisseur
</title>

</head>

<body>

<p class="there">Ajout  Fournisseur</p>
<br>

<!-- end --> 


<form method="post" action="../php/pop_ajout_fournisseur.php">


<TABLE BORDER="0"> 

		<TR> 
			<Th WIDTH=150 HEIGHT=30  ALIGN="left" > fournisseur </Th> 
			<TD colspan="3"><input type="text" name="four" SIZE="30" " colspan="2"></TD> 
			
		</TR> 
  <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Type fournisseur: </TH> 
  <TD colspan=3> <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="t" id="t" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="s">---Selectionnez</option>
			<option value="Production">Production</option>
			<option value="Service">Service</option>
            <option value="Expondable">Expondable</option>
          
			
			</select>
			</span>		 </TD> 
  
		<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">adresse fournisseur </TH> 
			<TD><textarea name="adr_four" rows="5" cols="25"></textarea></TD> 
			
			<Th WIDTH=30 HEIGHT=30 ALIGN="left">adresse magasin </Th> 
            <Td><textarea  name="adr_magas" rows="5" cols="25"></textarea></Td> 
			
            
		</TR> 
  
  
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Pays </TH> 
 <TD colspan="3"> <input type="text" name="pays" SIZE="30"></TD>
</TR>



<TR> 
 <TH WIDTH=100 HEIGHT=30  ALIGN="left">contact 1   </TH> 
 <TD > <input type="text" name="ctc_1"> </TD> 
  <TH WIDTH=100 HEIGHT=30  ALIGN="left">contact 2   </TH> 
 <TD> <input type="text" name="ctc_2"> </TD> 
 </tr>
 <tr>
 <TH WIDTH=100 HEIGHT=30  ALIGN="left">E-mail 1</TH> 
 <TD ><input type="text" name="mail_1" SIZE="30" MAXLENGTH="30" placeholder="exemple@serveur.com" ></TD>
  
 <TH WIDTH=100 HEIGHT=30  ALIGN="left">E-mail 2</TH> 
 <TD ><input type="text" name="mail_2" SIZE="30" MAXLENGTH="30" placeholder="exemple@serveur.com" ></TD>
 </tr>
 <tr>
 <Th WIDTH=30 HEIGHT=30 ALIGN="left">tél 1 </Th> 
 <Td><input type="text" name="tel_1" SIZE="18" ></Td> 
 
 <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >tel 2</Th> 
 <Td><input type="text" name="tel_2" SIZE="18" ></Td>
 </tr>
 <tr>
 <Th WIDTH=30 HEIGHT=30 ALIGN="left">fax 1 </Th> 
 <Td><input type="text" name="fax_1" SIZE="18" ></Td> 
  <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >fax 2</Th> 
 <Td><input type="text" name="fax_2" SIZE="18" ></Td>
 
 </TR>
 
 
 
 

		
		
</TABLE> 

<input type="submit" id="submitbutton" value="Valider"> 


		 
		
		 
	
 
</form>


</div>

</div>

</body>

</html>