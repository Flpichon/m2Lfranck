<?php
include(dirname(__FILE__)."/../boot_css/header.php");
include_once 'test.php';
EstConnecte();
$aff=Afficher_formations();
$nbr=Afficher_formations_actuelles_encours();
$j=0;
foreach ($nbr as $nbrr)
{$j++;}  
$i=0;
foreach ($aff as $nb)
{$i++;}
$k=$i-$j;
$l=0;
$credit=CreditEmploye();
$ct=0;		
$s=0;
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body style="background:#E8E7E7">
<div class="alert alert-primary d-flex justify-content-between" role="alert">
<?php echo '<div>Connecté en tant que'."  ".$_SESSION['Prenom_Employe']." ".$_SESSION['nom_Employe']."</div>"
		   ;?>
	<div>Il vous reste <?echo $credit['credit'];?> crédits</div>
</div>
<?
if ($_SERVER["REQUEST_METHOD"] == "POST")
{	if(isset($_POST["formation"]))
	{
	foreach ($_POST["formation"] as $idforma)
	{
		$ct+=$_SESSION['creditfo'][$idforma];
	}
	foreach ($_POST["formation"] as $idforma)
	{
		if($credit['credit']>=$ct)
			{
			ajout($idforma);
			$l++;
			$s=1;
			}
			else $s=2;
		
	}
	if($s==2){
	echo "vous n'avez pas assez de crédits";header ('Refresh:1;url= liste_formations.php');}
	else {echo "<div class=\"alert alert-success d-flex justify-content-between\" role=\"alert\">".$l." formation(s) selectionnée(s).</div>";}
}
else {echo"<div class=\"alert alert-warning d-flex justify-content-between\" role=\"alert\">Aucune formation selectionnée.</div>";header ('Refresh:1;url= liste_formations.php');}
}
$s=0;
?>
	<div class="card">
  	<div class="card-header">
  		<h2 class="text-center">Liste des formations disponibles (<?echo$k;?>)</h2>

  	</div>
  <div class="d-flex card-body">
		<div class="container-fluid">
			<div class="row d-flex">
				<div class="d-flex col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
					<div class="table-responsive">
						<table class="table table-bordered table-xl" >

							<thread>
								<tr>
									<th scope="col" class="text-center">Formation</th>
									<th scope="col" class="text-center">Description</th>
									<th scope="col" class="text-center">Date de la formation</th>
									<th scope="col" class="text-center">durée de la formation (en jours)</th>
									<th scope="col" class="text-center">prestataire</th>
									<th scope="col" class="text-center">coût</th>
        
								<tr>
							</thread>
							<tbody>
        
				
<?php 

foreach($aff as $mb)
{	
			
			   echo "<tr>";
					 echo "<th scope=\"row\" class=\"text-center\">".$mb['titre_Formation']."
					 			 </th>";
						echo "<td>
										<div class=\"d-flex justify-content-center\">
											<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#".$mb['titre_Formation']."\">
											Plus d'infos
											</button>
										</div>
									</td>";
			  			echo "<div class=\"modal fade\" id=\"".$mb['titre_Formation']."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
			  							<div class=\"modal-dialog\" role=\"document\">
												<div class=\"modal-content\">
				  								<div class=\"modal-header\">
														<h5 class=\"modal-title\" id=\"exampleModalLabel\">description de la formation : ".$mb['titre_Formation']."</h5>
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
																<span aria-hidden=\"true\">&times;
																</span>
															</button>
				                  </div>
				  								<div class=\"modal-body\">
														<p class=\"font-weight-bold\">Formation : 
															<span class=\"font-weight-normal\">".$mb['titre_Formation']."
															</span>
														</p>
														<p class=\"font-weight-bold\">Début de la formation : <span class=\"font-weight-normal\">".AfficherDate($mb['date_Formation'])."
															</span>
														</p>
														<p class=\"font-weight-bold\">Nombre de jours : 
															<span class=\"font-weight-normal\">".$mb['duree_Formation']."
															</span>
														</p>
														<p class=\"font-weight-bold\">Prestataire : 
															<span class=\"font-weight-normal\">".$mb['nom_Prestataire']."
															</span>
														</p>
														<p class=\"font-weight-bold\">Description : 
														</p>
														<p>".$mb['description_forma']."
														</p>
				                  </div>
				                  <div class=\"modal-footer\">
													 <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">fermer
													 </button>
			                    </div>
				                </div>
			                </div>
			              </div>
									</div>
				       </div>
							</td>";

				echo "<td class=\"text-center\">".AfficherDate($mb['date_Formation'])."</td>";
				echo "<td class=\"text-center\">".$mb['duree_Formation']."</td>";
				echo "<td class=\"text-center\">".$mb['nom_Prestataire']."</td>";
				echo "<td class=\"text-center\">".$mb['credit']."</td>"; $_SESSION['creditfo'][$mb['id_Formation']]=$mb['credit'];
		echo "</tr>";
				}
			?>

			</tbody>
		</table >
	</div>
</div>

<div class="col-6 col-sm-6 lign-self-center col-md-2 col-l-2 col-xl-2 d-flex align-items-center">
	<div class="table-responsive">
	<table class="table table-bordered table-xl ">	
	<thread>
	<tr>
									<th scope="col" class="text-center">Votre choix</th>
	<tr>
	</thread>
		<tbody>
			<form class="form" method="post" action="liste_formations.php">
				<?php $idforma="";

					foreach($aff as $mb)
					{
						echo "<tr><td class=\"align-middle d-flex justify-content-center\"><div class=\"radio\">
  					<label class=\"radio-inline\"><input type=\"checkbox\" name=\"formation[]\" value=\"".$mb['id_Formation']."\" ".formation_ok($mb['titre_Formation']).">".$mb['titre_Formation']."</label>
						</td></tr>";
					}
?>
	
      	  <tr><td class="d-flex justify-content-center"><button type="submit" value="submit" class="btn btn-success">Valider</button></td></tr>
	    </form>
	

		<tbody>
	</table>
</div>	
</div>
</div>
</div>
</div>


    

	


	<!-- Button trigger modal -->
	


</body>