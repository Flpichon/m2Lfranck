<?php 
include(dirname(__FILE__)."/boot_css/header.php");
include_once 'php/test.php';
include '/php/description.php';
Estconnecte();
$test=Afficher_formations_actuelles_encours();  
$i=0;
foreach ($test as $nb)
{$i++;}
$credit=CreditEmploye();

?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<title>Accueil M2L</title>
<link rel="shortcut icon" type="image/x-icon" href="image/logofranck.png" />
</head>
<body style="background:#E8E7E7">
<div class="alert alert-primary d-flex justify-content-between" role="alert">
<?php echo '<div>Connecté en tant que'."  ".$_SESSION['Prenom_Employe']." ".$_SESSION['nom_Employe']."</div>"
		   ;?>
	<div>Il vous reste <?echo $credit['credit'];?> crédits</div>
</div>
<?
if(isset($_POST["reseteri"]))
reseter();
?>
<form class="form" method="post" action="index.php">
<button type="submit" value="reseter" name="reseteri" class="btn btn-primary">Réinitialiser</button>
</form>
<div class="card">
  <div class="card-header">
  <h2 class="text-center">Vos formations en cours (<?echo$i;?>)</h2>

  </div>
	<?php if ($test)
{
?>
  <div class="card-body">
	<div class="table-responsive">
	<table class="table table-bordered" style="margin-top:3%;">
	<a class="btn btn-primary" href="php/description.php" role="button">PDF de vos formations</a>

		<thread>
			<tr>
				<th scope="col" class="text-center">Formation</th>
				<th scope="col" class="text-center">Description</th>
				<th scope="col" class="text-center">Date de la formation</th>
				<th scope="col" class="text-center">durée de la formation (en jours)</th>
				<th scope="col" class="text-center">prestataire</th>
			<tr>
		<thread>
	<!--<div class="container">
	<div class="row">
    	<div class="col-xs-3 col-lg-3">ID</div>
        <div class="col-xs-3 col-lg-3">Nom</div>
        <div class="col-xs-3 col-lg-3">Prenom</div>
		<div class="col-xs-3 col-lg-3">Pseudo</div>
    </div>-->
		<tbody>
		<?php 
	
		
			foreach($test as $mb)
			{	
				
				
				echo "<tr>";
				echo "<th scope=\"row\" class=\"text-center\">".$mb['titre_Formation']."</th>";
				echo "<td><div class=\"d-flex justify-content-center\"><button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#".$mb['titre_Formation']."\">
				Plus d'infos
			  </button></div></td>";
			  echo "<div class=\"modal fade\" id=\"".$mb['titre_Formation']."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
			  <div class=\"modal-dialog\" role=\"document\">
				<div class=\"modal-content\">
				  <div class=\"modal-header\">
					<h5 class=\"modal-title\" id=\"exampleModalLabel\">description de la formation : ".$mb['titre_Formation']."</h5>
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
					  <span aria-hidden=\"true\">&times;</span>
					</button>
				  </div>
				  <div class=\"modal-body\">
				  <p class=\"font-weight-bold\">Formation : <span class=\"font-weight-normal\">".$mb['titre_Formation']."</span></p>
				  <p class=\"font-weight-bold\">Début de la formation : <span class=\"font-weight-normal\">".AfficherDate($mb['date_Formation'])."</span></p>
				  <p class=\"font-weight-bold\">Nombre de jours : <span class=\"font-weight-normal\">".$mb['duree_Formation']."</span></p>
				  <p class=\"font-weight-bold\">Prestataire : <span class=\"font-weight-normal\">".$mb['nom_Prestataire']."</span></p>
				  <p class=\"font-weight-bold\">Description : </p>
				  <p>".$mb['description_forma']."</p>
				  </div>
				  <div class=\"modal-footer\">
					<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">fermer</button>
					
				  </div>
				</div>
			  </div>
			</div>";
			echo" 
			

				
				
   				
  				</div>
				</div>
				
				</td>";
				
				echo "<td class=\"text-center\">".AfficherDate($mb['date_Formation'])."</td>";
				echo "<td class=\"text-center\">".$mb['duree_Formation']."</td>";
				echo "<td class=\"text-center\">".$mb['nom_Prestataire']."</td>";
				
				echo "</tr>";	
		
			}
		?>




		 
		<tbody>
	</table>
	
</div>
</div>
    
  </div>
<?
}
else echo '<div class="alert alert-warning" style="font-size:25px;"role="alert">Vous n\'avez aucune formation en cours ! Cliquez <a href="php/liste_formations.php" class="badge badge-success">ici</a> pour voir la liste des formations disponibles.</div>';
?>
	<!-- Button trigger modal -->
	


</body>