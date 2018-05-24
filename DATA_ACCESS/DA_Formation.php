<?php 
include_once(dirname(__FILE__) . "/../BDD/connexion_bdd.php");

/**
 * Fonction formation_ok2
 * Cette fonction a pour but de vérifier la présence d'une formation associée à un employé (sous le statut : en attente, validé ou en cours)
 * @param [string] $forma
 * @return -- vrai si la formation entrée en paramètre est associée à l'employé dont la session est active
 */
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
/**
 * Fonction formation_etat_ok
 *
 * @param [string] $forma
 * @param [int] $id
 * @return -- vrai si la formation est associée à un salarié et n'est pas en attente 
 */
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
/**
 * fonction formation_etat_attente
 *
 * @param [int] $id
 * @return -- vrai si la formation dont l'id est en paramètre de la fonction est en attente
 */
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
/**
 * Fonction ajout
 * Cette fonction permet d'ajouter une formation dans la table selectionner (entre une formation et un employé)
 * Si l'employé est un manager, celle ci sera automatiquement mise sous le statut "validé".
 * @param [id] $format
 * @return void
 */
function ajout($format)
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
}
?>