 <?php
    include('../connexion/connexionDB.php');
    $OF=$_POST['OF'];
    echo'
    <table class="table table-fixed tabScroll">
	<thead style="width:100%"><tr>
	<th style="width:24.6%;height:60px">Plan</th>
	<th style="width:14.6%;height:60px">Qty</th>
	<th style="width:14.6%;height:60px">Nbr default</th>
	<th style="width:44.6%;height:60px">Position</th>
    </tr></thead><tbody id="tbody2" style="width:100%">';
    $req= mysql_query("SELECT * FROM plan1 where OF='$OF'");
	while($data=mysql_fetch_array($req)){
        //Affichage
		$statut=$data['statut'];
		if($statut==""){
		    $statut="----";
		}
		echo"<tr>
		<td style=\"width:25%;height:40px\">".$data['numPlan']."</td>
        <td style=\"width:15%;height:40px\">".$data['qte_p']."</td>
        <td style=\"width:15%;height:40px\" >".$data['nbr_defaut']."</td>
        <td style=\"width:45%;height:40px\" >".$statut."</td>
		</tr>";
     }

    echo '</tbody></table>';
  ?>