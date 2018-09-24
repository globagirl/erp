//affiche rretourinfo
		    function afficheInfoRT(ID,stat,T){
			  $.ajax({
                type: 'POST',
				data:'IDretour='+ID+'&statut='+stat+'&typeR='+T,
				url: '../php/consult_retour_info.php',
				success: function(data) {
                     bootbox.alert(data);
                }});

            }
			////affiche retourinfo
		    /*function confirmRT(idRT,T){
			if(confirm("Voulez vous vraiment confirmer cet bande de retour ?!")){
			  $.ajax({
                type: 'POST',
				data:'IDretour='+idRT+'&typeR='+T,
				url: '../php/confirm_bande_retour.php',
				success: function(data) {
                     //bootbox.hideAll();
					 //location.reload();
					 bootbox.alert(data);
                }});

            }
			}*/
			//
			function affiche_retour(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
               
				var statut = document.querySelector('input[name=statut]:checked').value;
				//alert (statut);
				
                $.ajax({
                    type: 'POST',
                    data: 'valeur='+val+'&recherche='+recherche+'&statut='+statut,
                    url: '../php/consult_bande_retour.php',
                    success: function(data) {
                        $('#tbody2').html(data);
                }});
	  
            }
			//