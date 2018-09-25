<?php
///Multiple
include('../connexion/connexionDB.php');
$i=1;
echo("<div id=\"divAdd\"><table><tr>
<td><center><b> Invoice N°: </b><input type=\"text\" placeholder=\"Invoice N°\" name=\"inv1\" id=\"inv1\" onBlur=verif_invoice2('inv1')></center></td>
<td><b>Date facturation : </b><input  type=\"date\" name=\"dateF1\" ></td>
<td><b>Amount : </b>
<input  type=\"text\" id=\"total1\" name=\"total1\"  size=\"15 \" > 
 <span class=\"custom-dropdown custom-dropdown--white custom-dropdown--small\">
			<select name=\"devise1\" type=\"text\" class=\"custom-dropdown__select custom-dropdown__select--white\">
			<option value=\"TND\">TND</option>
				<option value=\"EUR\">EUR</option>
				<option value=\"USD\">USD</option>		
			</select>
	 </span>
	 <input  type=\"text\" id=\"coursTND1\" name=\"coursTND1\"  placeholder=\"Cours TND\" size=\"10 \" > 
	 </td>
	 </tr>
	 <tr>
	 <td><center> <b>Paid  </b> <input type=\"checkbox\" name=\"paid1\" id=\"paid1\" value=\"oui\" onClick=\"activeMP('".$i."');\"></center></td>
	 <td><b>Date payement : </b><input type=\"date\" name=\"dateP1\" id=\"dateP1\"></td><td>
	  <span class=\"custom-dropdown custom-dropdown--white custom-dropdown--small\" >
	 <select id=\"modeP1\" name=\"modeP1\" onChange=\"afficheMP('".$i."');\" class=\"custom-dropdown__select custom-dropdown__select--white\"  disabled>	    
	    <option value=\"Cache\">Cache</option>
	    <option value=\"Cheque\">Par chéque</option>
	    <option value=\"Virement\">Virement</option>
	    <option value=\"Autre\">Autre..</option>	 
   </select> 
   </span>
	 </td>
	 </tr>
	 <tr>
	 <td id='zoneMP1' style=\"text-align:right\" colspan=\"2\"></td>
<td>
<input type=\"file\" name=\"imgFact1[]\"  multiple>
</td>
</tr>
</table>
</div>
<table>
<tr>
<td>
<input type=\"button\" onclick=\"addZ();\" id=\"add1\" value=\"+\"  style=\"float:right\">
</td><td>
<input type=\"button\" onclick=\"deleteZ();\" id=\"add1\" value=\"-\"  style=\"float:left\">
<input type=\"text\" name=\"nbr\" id=\"nbr\" value=\"1\"  HIDDEN>
</td>
<td><input type=\"button\" onclick=\"addI3();\" id=\"add1\" value=\"Submit >> \"  style=\"float:left\">
</td>
</tr>
</table>");
?>