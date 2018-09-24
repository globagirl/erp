 function mySearch() {
			    var searchTerm = $(".search").val();
				searchTerm=searchTerm.toUpperCase();				
				var jobCount = $('.results tbody').children('tr').length;
				for (var iter = 1; iter <= jobCount; iter++) {
				    var nIter1="."+iter;
					var val=$(nIter1).html();
					val=val.toUpperCase();
					if (val.indexOf(searchTerm) >= 0){
					    $(nIter1).attr('visible','true');
                    }else{
                        $(nIter1).attr('visible','false');
                    }
                }
            }
			function mySearch2() {
			     if($('#E1').is(':checked')){
				    //var searchTerm="ALL";
					$(".R").attr('visible','true');
					$(".AT").attr('visible','true');
					$(".AN").attr('visible','true');
				}else if($('#E2').is(':checked')){
				    //var searchTerm="AT";
					$(".R").attr('visible','false');
					$(".AT").attr('visible','true');
					$(".AN").attr('visible','false');
				}else if($('#E3').is(':checked')){
				    //var searchTerm="AN";
					$(".R").attr('visible','false');
					$(".AT").attr('visible','false');
					$(".AN").attr('visible','true');
				}
			   
            }
            //	
		
			function afficheTrans(){
			    $('#divRel').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var compte = document.getElementById("compte").value;
				
				//alert (statut);
                $.ajax({
                    type: 'POST',
                    data: 'compte='+compte,
                    url: '../php/consult_transaction_compte.php',
                    success: function(data) {
                        $('#divRel').html(data);
                }});	  
            } 
			//		
			
			//
			function transPass(T){
			  if(confirm("Voulez vous vraiment passer le chéque ?!")){ 
			    var compte = document.getElementById("compte").value;
                $.ajax({
                    type: 'POST',
                    data: 'IDtrans='+T,
                    url: '../php/transactionPass.php',
                    success: function(data) {
                        afficheTrans();
                }});
	  
              }
            }
			////
			function transAnnule(T){
			  if(confirm("Voulez vous vraiment annuler la transaction ?!")){ 
			    var compte = document.getElementById("compte").value;
                $.ajax({
                    type: 'POST',
                    data: 'IDtrans='+T+'&compte='+compte,
                    url: '../php/transactionAnnule.php',
                    success: function(data) {
                        afficheTrans();
                }});
	          }
            }
			//
            function updateTrans(idTrans){
			    var montant = prompt("Entrer le nouveau montant  SVP :");
				if (montant != null) {
      				$.ajax({
					    type: 'POST',
						data:'idTrans='+idTrans+'&montant='+montant,
						url: '../php/update_transaction.php',
                        success: function(data) {         
                            afficheTrans();
                     }});
                }
			}

			//
			function updateTransRef(idTrans){
			    var ref = prompt("Entrer la nouvelle reference SVP :");
				if (ref != null) {
      				$.ajax({
					    type: 'POST',
						data:'idTrans='+idTrans+'&ref='+ref,
						url: '../php/update_transaction_ref.php',
                        success: function(data) {         
                            afficheTrans();
                     }});
                }
			}
			//
			function transDelete(T){
			  if(confirm("Voulez vous vraiment supprimer la transaction ?!")){ 
			    var compte = document.getElementById("compte").value;
                $.ajax({
                    type: 'POST',
                    data: 'IDtrans='+T+'&compte='+compte,
                    url: '../php/transactionDelete.php',
                    success: function(data) {
                        afficheTrans();
                }});
	          }
            }