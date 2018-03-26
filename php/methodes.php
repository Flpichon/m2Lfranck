<?php
include(dirname(__FILE__) . "/../BDD/connexion_bdd.php");


function afficher_mb()
{
	$dbh = init_connexion();
	$req = 'SELECT * FROM Employe where type_Employe=2';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array());

	$resultat = $prep->fetchAll();


	return $resultat;

}
?>
<?php

function recherche_utilisateur($Pseudo, $mdp)
{
	$dbh = init_connexion();
	$req = "select Pseudo,mdp,id_Employe,Prenom_Employe,nom_Employe,credit,type_Employe from Employe inner join Type_Employe on Employe.type_Employe=Type_Employe.id_Type_Employe where Pseudo= :pseudo and mdp= md5(:mdp)";
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array(
		'pseudo' => $Pseudo,
		'mdp' => $mdp
	));
	if ($resultat) {
		$resultat = $prep->fetch();

	}
	$dbh = null;
	return $resultat;



}

function connexion_utilisateur()
{
	$resultat = false;
	if ($_POST['Pseudo'] and $_POST['mdp']) {
		$employe = recherche_utilisateur($_POST['Pseudo'], $_POST['mdp']);

		if ($employe) {
			session_start();

			$_SESSION['id_Employe'] = $employe['id_Employe'];
			$_SESSION['Prenom_Employe'] = $employe['Prenom_Employe'];
			$_SESSION['nom_Employe'] = $employe['nom_Employe'];
			$_SESSION['creditfo'][] = "";
			$_SESSION['credit'] = $employe['credit'];
			$_SESSION['type_Employe'] = $employe['type_Employe'];




			$resultat = true;
		}

	}
	return $resultat;

}

function DemarrerSession()
{
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}

function EstConnecte()
{

	DemarrerSession();
	if (!isset($_SESSION['id_Employe'])) {
		header('location: ../page_connexion.php');
		exit;
	}
}




function AfficherDuJour()
{
	setlocale(LC_TIME, 'fr_FR.UTF8');
	date_default_timezone_set('Europe/Paris');
//setlocale(LC_TIME, 'fr_FR');
//setlocale(LC_TIME, 'fr');
//setlocale(LC_TIME, 'fra_fra');
//return strftime('%Y-%m-%d %H:%M:%S'); 
	return strftime('Il est %Hh%M et nous sommes le %d/%m/%Y');
}

function AfficherDate($date)
{
	$phpdate = strtotime($date);
	return date('d-m-Y', $phpdate);
}



function Afficher_formations_actuelles_encours()
{
	$dbh = init_connexion();
	$req = 'SELECT titre_Formation,description_forma,date_Formation,duree_Formation,nom_Prestataire FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en cours" or etat="en attente" or etat="validé") and (duree_Formation+ date_Formation)>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));

	$resultat = $prep->fetchAll();


	return $resultat;
}

function Afficher_formations_Employés($id)
{
	$dbh = init_connexion();
	$req = 'SELECT titre_Formation,description_forma,date_Formation,duree_Formation,nom_Prestataire,Formation.id_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en cours" or etat="en attente" or etat="validé") and (duree_Formation+ date_Formation)>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $id));

	$resultat = $prep->fetchAll();


	return $resultat;
}

function Afficher_formations()
{
	$dbh = init_connexion();
	$req = 'SELECT id_Formation,titre_Formation,description_forma,date_Formation,duree_Formation,nom_Prestataire,credit FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire where date_Formation>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array());

	$resultat = $prep->fetchAll();


	return $resultat;
}


function formation_ok2($forma)
{
	$dbh = init_connexion();
	$req = 'SELECT titre_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en cours" or etat="en attente" or etat="validé" or etat="refusé") and (date_Formation+duree_Formation)>CURDATE() and titre_Formation=:formation';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe'], 'formation' => $forma));
	$resultat = $prep->fetchAll();

	if ($resultat) return true;
	else return;
}

function formation_etat_ok($forma, $id)
{

	$dbh = init_connexion();
	$req = 'SELECT titre_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en cours" or etat="validé" or etat="refusé") and (date_Formation+duree_Formation)>CURDATE() and titre_Formation=:formation';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $id, 'formation' => $forma));
	$resultat = $prep->fetchAll();

	if ($resultat) return true;
	else return;
}
function formation_etat_attente($id)
{

	$dbh = init_connexion();
	$req = 'SELECT titre_Formation FROM Prestataire inner join Formation on Prestataire.id_Prestataire=Formation.id_Prestataire inner join Selectionner on Formation.id_Formation = Selectionner.id_Formation inner join Employe on Selectionner.id_Employe=Employe.id_Employe where Employe.id_Employe =:id and (etat="en attente") and (date_Formation+duree_Formation)>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $id));
	$resultat = $prep->fetchAll();

	if ($resultat) return true;
	else return;
}

function ajout($format)
{
	$dbh = init_connexion();
	if (Estmanager()) {
		$req = 'INSERT INTO `Selectionner` (`id_Employe`, `id_Formation`, `etat`) VALUES (:id, :forma, "validé");
	UPDATE Employe inner join Selectionner on Employe.id_Employe=Selectionner.id_Employe inner join Formation on Selectionner.id_Formation=Formation.id_Formation SET Employe.credit = Employe.credit-Formation.credit WHERE `Employe`.`id_Employe` = :id and Formation.id_Formation=:forma;';
	} else {
		$req = 'INSERT INTO `Selectionner` (`id_Employe`, `id_Formation`, `etat`) VALUES (:id, :forma, "en attente");
	UPDATE Employe inner join Selectionner on Employe.id_Employe=Selectionner.id_Employe inner join Formation on Selectionner.id_Formation=Formation.id_Formation SET Employe.credit = Employe.credit-Formation.credit WHERE `Employe`.`id_Employe` = :id and Formation.id_Formation=:forma;';

	}
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe'], 'forma' => $format));
	$dbh = null;

}

function CreditEmploye()
{
	$dbh = init_connexion();
	$req = 'SELECT `credit` from Employe where id_Employe=:id';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$resultat = $prep->fetch();
	return $resultat;


}

function reseter()

{
	$dbh = init_connexion();
	$req = 'UPDATE Employe SET credit = 3000 WHERE Employe.id_Employe = :id;
	DELETE FROM `Selectionner` WHERE `Selectionner`.`id_Employe` = :id;';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$dbh = null;
	echo 'Vos formations et vos crédits ont bien été réinitialisés';
	header('Refresh:1;url= ../index.php');


}

function Estmanager() //vérifie si l'utilisateur qui se connecte est manager. Permet de changer le Header.
{
	$dbh = init_connexion();
	$req = "SELECT id_Type_Employe from Type_Employe inner join Employe on Type_Employe.id_Type_Employe=Employe.id_Employe where id_Employe = :id and id_type_Employe=1";
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$resultat = $prep->fetch();

	if ($resultat) return true;
	else return false;

}

function Valider_Etat_Formation($etat, $formation, $id_employe)

{
	$dbh = init_connexion();
	$req = "UPDATE `Selectionner` SET `etat` = :etat WHERE `Selectionner`.`id_Employe` = :id_employe AND `Selectionner`.`id_Formation` = :id_formation;";
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id_employe' => $id_employe, 'id_formation' => $formation, 'etat' => $etat));
	if ($etat=="Refusé")
	{
		$req1="UPDATE Employe inner join Selectionner on Employe.id_Employe=Selectionner.id_Employe inner join Formation on Selectionner.id_Formation=Formation.id_Formation SET Employe.credit = Employe.credit+Formation.credit WHERE `Employe`.`id_Employe` = :id_employe and Formation.id_Formation=:id_formation;
		DELETE FROM `Selectionner` WHERE `Selectionner`.`id_Employe` = :id_employe and `Selectionner`.`id_Formation`=:id_formation;";
		$prep1=$dbh->prepare($req1);
		$resultat1=$prep1->execute(array('id_employe' => $id_employe, 'id_formation' => $formation));
	}


}
?>
