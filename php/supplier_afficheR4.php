<?php
//credit note
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
		<input  type=\"text\" id=\"coursTND\" name=\"coursTND\"  placeholder=\"Currency TND\" size=\"10 \" >
    </td>
	<td style=\"text-align:center\">
	   <b> Invoice date : </b><input type=\"date\" name=\"dateF\" id=\"dateF\"  >
    </td>
    </tr>
    <tr>
    <td style=\"text-align:right\" >
    <input  type=\"text\" id=\"invoiceCredit\" name=\"invoiceCredit\"  placeholder=\"Real invoice N° \" size=\"20 \" >
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
	<b>Payment Date:  </b><input type=\"date\" name=\"dateP\" id=\"dateP\">

	</td>
	<td style=\"text-align:left\">
	<span class=\"custom-dropdown custom-dropdown--white custom-dropdown--small\" >
	 <select id=\"modeP1\" name=\"modeP1\" onChange=\"afficheMP('".$i."');\" class=\"custom-dropdown__select custom-dropdown__select--white\"  disabled>
	    <option value=\"Cache\">Cache</option>
	    <option value=\"Cheque\">Check</option>
	    <option value=\"Virement\">bank transfer</option>
	    <option value=\"Autre\">Other..</option>
     </select>
    </span>

    </td>
</tr>
<tr>
	<td colspan=2 id='zoneMP1' style=\"text-align:right\"></td>
    <td style=\"text-align:left\" >
	    <input type=\"button\" onclick=\"addI4();\" id=\"add1\" value=\"Submit >> \"  style=\"float:left\">
    </td>
</tr>
</table>");
?>
