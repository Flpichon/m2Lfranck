<!-- Cette page permet la gestion de formations des employés par leur manager.-->
<?php
include_once '../DATA_ACCESS/methodes.php';
EstConnecte();
if (Estmanager()) {
	include '../boot_css/header_man.php';
} else include '../boot_css/header.php';
$credit = CreditEmploye();
$mb = afficher_mb();
$t;

?>
<script> var membre[]; </script>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src=../js/co.js></script>
<title>Gestion des formations</title>
</head>
<body style="background:#E8E7E7">
<div class="alert alert-primary d-flex justify-content-between" role="alert">
<?php echo '<div>Connecté en tant que' . "  " . $_SESSION['Prenom_Employe'] . " " . $_SESSION['nom_Employe'] . "</div>"; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["submit"]) && isset($_POST["formation"]) && isset($_POST["etat"])) {
		$data = $_POST["formation"];
		list($formatio, $membre) = explode("/", $data);
		echo $formatio . $membre;
		Valider_Etat_Formation($_POST["etat"], $formatio, $membre);
			//echo $_POST['formation'].$_POST['etat'];
		header('Refresh:1;url= gestion_formation.php');
	}



}
?>
	<div>Il vous reste <? echo $credit['credit']; ?> crédits</div>
</div>
<div class="card">
  	<div class="card-header">
  		<h2 class="text-center">Liste des Employés</h2>

  	</div>
  <div class="d-flex card-body">
		<div class="container-fluid  ">
			<div class="row d-flex">
				<div class="d-flex col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="table-responsive">
						<table class="table table-bordered table-xl" >

							<thread>
								<tr>
									<th scope="col" class="text-center">Prénom</th>
									<th scope="col" class="text-center">Nom</th>
									<th scope="col" class="text-center">Crédits</th>
									<th scope="col" class="text-center">Mail</th>
									<th scope="col" class="text-center">Gestion des formations</th>
				
        
								<tr>
							</thread>
						<tbody>
<?php
foreach ($mb as $membres) {

	$forma = Afficher_formations_Employés($membres['id_Employe']);
	echo "<tr>";
	echo "<td class=\"text-center\">" . $membres['Prenom_Employe'] . "
		  </td>";
	echo "<td class=\"text-center\">" . $membres['nom_Employe'] . "
		  </td>";
	echo "<td class=\"text-center\">" . $membres['credit'] . "
		  </td>";
	echo "<td class=\"text-center\">" . $membres['mail'] . "
		  </td>";
	?>
	
	<td class="text-center">
	<div class="d-flex justify-content-center">
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $membres[0]; ?>">
  Formations demandées
</button>
</div>

	<div class="modal" tabindex="-1" role="dialog" id="<?php echo $membres[0]; ?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Formations (état à définir)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="gestion_formation.php">
<?php $nb_forma = count(Afficher_formations_Employés($membres['id_Employe']));
if (Afficher_formations_Employés($membres['id_Employe'])) 
  { if (formation_etat_attente($membres[0])){
	echo "<select class=\"form-control\" name=\"formation\">";
	foreach ($forma as $formations) {
		if (!formation_etat_ok($formations['titre_Formation'], $membres[0])) {echo "<option value=\"" . $formations['id_Formation'] . "/" . $membres[0] . "\">" . $formations[0] . "</option>";
		}
	}
	echo "</select>"; ?>
	<label><input type="radio" name="etat" value="validé">Valider</label>
  <label><input type="radio" name="etat" value="Refusé">Refuser</label>
	<?php
	
}else echo "aucune formation à traiter";} else echo "pas de formations"; ?>

		
      </div>
      <div class="modal-footer">
			<?php if(formation_etat_attente($membres[0]))
        echo "<button <button type=\"submit\" name=\"submit\" value=\"submit\" class=\"btn btn-success\" >Valider votre choix</button>";?>
        <button type="button" class="btn btn-secondary"   data-dismiss="modal">Fermer</button>
      </div>
	  </form>
    </div>
  </div>
</div>
	</td>
	</tr>
	
	<?php	
}

?>

</tbody>
		</table >
	</div>
</div>
</body>


