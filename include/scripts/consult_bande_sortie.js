//affiche rretourinfo
		  
function afficheInfoS(ID){

			  $.ajax({
                type: 'POST',
				data:'IDsortie='+ID,
				url: '../php/consult_sortie_info.php',
				success: function(data) {
                    bootbox.alert(data);
                    //alert(data);
                }});
				
}
//Consult sortie info
function confirm_sortie(ID){
			  $.ajax({
                type: 'POST',
				data:'IDsortie='+ID,
				url: '../php/confirm_bande_sortie.php',
				success: function(data) {
                     bootbox.hideAll();
					 location.reload();
                }});
}
			//
			/*
			function affiche_sortie(){
			    //alert ("hhhhhh");				
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;               
				var statut = document.querySelector('input[name=statut]:checked').value;				
                $.ajax({
                    type: 'POST',
                    data: 'valeur='+val+'&recherche='+recherche+'&statut='+statut,
                    url: '../php/consult_bande_sortie.php',
                    success: function(data) {
                        $('#tbody2').html(data);
                }});
	  
            }*/
			//