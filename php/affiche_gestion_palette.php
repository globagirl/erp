<?php
    include('../connexion/connexionDB.php');
    $dateE = $_POST['dateE'];
    $client = $_POST['client'];
	$sql1=@mysql_query("SELECT IDpalette,statut,nbrCarton FROM palette where dateE='$dateE' and client='$client' order by dateC DESC");
	$NBP=@mysql_num_rows($sql1);
	//$sql1=@mysql_query("SELECT IDpalette,statut,nbrCarton FROM palette");
	echo ' <div class="row">
        <div class="col-lg-12">
		<div class="form-group form-inline">
			<select class="form-control" name="recherche" id="recherche">
				<option value="IDpalette">Palette</option>
				<option value="PO">PO</option>
				<option value="IDcarton">ID carton</option>
				<option value="IDproduit">Produit</option>
				<option value="OF">OF</option>
			</select>
			<input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search ">
			<input type="button" onClick="afficheFiltre();" class="btn btn-primary" Value=" >>">
		</div>
        <div class="col-lg-6" id="divListPal">
		  <div class="form-group">
  		    <label>Palettes</label>
			  <select multiple class="form-control" size="10"  id="IDpalette" name="IDpalette">';

			  echo "<option value=\"XX\" onClick=afficheCarton();>Total : ".$NBP."</option>";
	while($data1=@mysql_fetch_array($sql1)){
	   $IDpalette=$data1["IDpalette"];

       echo "<option value=\"".$data1["IDpalette"]."\" onClick=afficheCarton();>
	   ".$data1["IDpalette"]."&nbsp&nbsp&nbsp&nbsp&nbsp".$data1["nbrCarton"]."Cart&nbsp&nbsp&nbsp&nbsp&nbsp"."&nbsp&nbsp&nbsp&nbsp&nbsp".$data1["statut"]."</option>";

    }

	echo ' </select></div> </div>';
	//Liste des buttons
	echo '
        <div class="col-lg-3">
		<button type="button" onClick="ajout_palette();" class="btn btn-primary btn-block">Nouvelle palette</button>

		<button type="button" onClick="delete_palette();" class="btn btn-danger btn-block">Supprimer palette</button>
		<button type="button" class="btn btn-warning btn-block" onClick="close_palette();">Fermer palette</button>
		<button type="button" class="btn btn-success btn-block" onClick="ticket_palette();">Tickets</button>
    <button type="button" class="btn btn-default btn-block" onClick="packingList();" target="_blank">PACKING LIST </button>
		</div></div>
		';
	echo '<div class="col-lg-12">
	<div class="col-lg-4" id="divCartDisp">
	<div class="form-group">
  		    <label>Cartons disponible</label>
			  <select multiple="multiple" size="10" class="form-control" id="cartonLibre" name="cartonLibre">';
	$sql2=@mysql_query("SELECT IDcarton,PO,IDproduit FROM carton_palette where IDpalette LIKE 'X'");
	while($data2=@mysql_fetch_array($sql2)){

       echo "<option value=\"".$data2["IDcarton"]."\" >".$data2["IDcarton"]."&nbsp&nbsp&nbsp&nbsp".$data2["PO"]."&nbsp&nbsp&nbsp".$data2["IDproduit"]."</option>";
    }
	echo'</select></div></div>

	<div class="col-lg-1">
		<button type="button" class="btn btn-outline btn-default btn-block" onClick="affect_Carton_all();"> >> </button>
		<button type="button" class="btn btn-outline btn-default btn-block" onClick="affect_Carton();"> > </button>
		<button type="button" class="btn btn-outline btn-default btn-block" onClick="retir_Carton_all();"> << </button>
		<button type="button" class="btn btn-outline btn-default btn-block" onClick="retir_Carton();"> < </button>

		</div>
	<div class="col-lg-4" id="divCartPal">
	    <div class="form-group">
  		    <label>X</label>
			  <select multiple="multiple" size="10" class="form-control" id="cartPal" name="cartPal">
			  </select>
		</div>
	</div></div>';
    mysql_close();
?>
