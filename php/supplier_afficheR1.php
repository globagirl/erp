<?php 
///service , credit note , expense
$i="1";
echo("<table>
<tr>
    <td style=\"text-align:right\"> 
        <b>Amount : </b> 
        <input  type=\"text\" id=\"total\" name=\"total\"  size=\"15 \" > 
        <span class=\"custom-dropdown custom-dropdown--white custom-dropdown--small\">
			<select name=\"devise\" type=\"text\" class=\"custom-dropdown__select custom-dropdown__select--white\">
			    <option value=\"TND\">TND</option>
				<option value=\"EUR\">EUR</option>
				<option value=\"USD\">USD</option>
			</select>
	    </span>
		<input  type=\"text\" id=\"coursTND\" name=\"coursTND\"  placeholder=\"Cours TND\" size=\"10 \" > 
    </td>
	<td style=\"text-align:center\">
	   <b> Invoice date : </b><input type=\"date\" name=\"dateF\" id=\"dateF\"  >
    </td>
    <td style=\"text-align:left\">
	    <input type=\"file\" name=\"imgFact[]\"  multiple>
    </td>
	
</tr>
<tr>	
    <td style=\"text-align:right\"> 
	    <b>Paid </b> 
		<input type=\"checkbox\" name=\"paid1\" id=\"paid1\" value=\"oui\" onClick=\"activeMP('".$i."');\">
    </td>
	<td style=\"text-align:center\">
	<b>Date payment:  </b><input type=\"date\" name=\"dateP\" id=\"dateP\">
	 
	</td>
	<td style=\"text-align:left\">
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
    
	<td colspan=2 id='zoneMP1' style=\"text-align:right\">
	
    </td>		
    <td style=\"text-align:left\" >
	<input type=\"button\" onclick=\"addI1();\" id=\"add1\" value=\"Submit >> \"  style=\"float:left\">
    </td>
</tr>
</table>");
?>
	
