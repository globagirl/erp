   <?php 
   include('../connexion/connexionDB.php');
						  $plan=$_POST['plan'];
						  $sql33 = mysql_query("SELECT * FROM pro_test_pol where plan='$plan'");
                          $data2=mysql_fetch_array($sql33);
                          $plan=$data2['plan'];
                          $qtE=$data2['qte_e'];
						  $dateD=$data2['date_debut'];
						  
						  echo("<TR><th>Plan: </th>
                          <td> <input  type=\"text\" size=\"15\" id=\"plan2\" name=\"plan2\" value=\"".$plan."\"/  READONLY></td>
                          <Th Wcode_articleTH=150 HEIGHT=30  >Quantité entrée :</Th>
                          <td><input  type=\"text\" size=\"10\" id=\"qte_e\" name=\"qte_e\" value=\"".$data2['qte_e']."\"/ READONLY></td>
                          <Th Wcode_articleTH=150 HEIGHT=30  > Debut :</Th>
                          <td><input  type=\"text\" size=\"20\" id=\"dateD\" value=\"".$dateD."\"/ READONLY></td></tr>
						         <TR> 
                           
                            <Th > Qté Sortie:* </Th> 
                            <Td><input type=\"text \" name=\"qte_s\" id=\"qte_s\" value=\"".$data2['qte_e']."\" SIZE=\"15\" onblur=\"myF2(),calc()\" onFocus=\"del2()\" ></Td>
							  <TH >Nombre de défaut:</TH> 
                           <Td colspan=3><input type=\"text\" name=\"nbr_def\" ID=\"N_D\"  SIZE=\"4\"  value=\"0\" readonly ></Td>
                     </TR> 
                          ");
						  ?>