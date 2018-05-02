<?php 
include_once(dirname(__FILE__) . "/../BDD/connexion_bdd.php");

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
//Même fonction que précédement,mais les etats diffèrent
//validé / en cours / refusé
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
//Cette fonction permet de retourner vraie si la formation (selectionnée par son id) est en attente et faux si elle ne l'est pas
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
//Cette fonction permet d'ajouter une formation dans la table "selectionner", en plus de déduire du nombre de crédit total de l'employé,
//le coût de la formation 
//Si l'employé est un manager, le statut de la formation passera à "validé"
//Sinon elle passera à "en attente"
function ajout($format)//début
{
	$dbh = init_connexion();
	if (Estmanager()) 
	{
		$req = 'INSERT INTO `Selectionner` (`id_Employe`, `id_Formation`, `etat`) VALUES (:id, :forma, "validé");
	UPDATE Employe inner join Selectionner on Employe.id_Employe=Selectionner.id_Employe inner join Formation on Selectionner.id_Formation=Formation.id_Formation SET Employe.credit = Employe.credit-Formation.credit WHERE `Employe`.`id_Employe` = :id and Formation.id_Formation=:forma;';
	} 
	else 
	{
		$req = 'INSERT INTO `Selectionner` (`id_Employe`, `id_Formation`, `etat`) VALUES (:id, :forma, "en attente");
	UPDATE Employe inner join Selectionner on Employe.id_Employe=Selectionner.id_Employe inner join Formation on Selectionner.id_Formation=Formation.id_Formation SET Employe.credit = Employe.credit-Formation.credit WHERE `Employe`.`id_Employe` = :id and Formation.id_Formation=:forma;';
	}
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe'], 'forma' => $format));
	$dbh = null;
}//fin
?>