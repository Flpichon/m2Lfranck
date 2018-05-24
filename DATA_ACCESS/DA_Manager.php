<?php
/**
 * fonction afficher_mb
 * Dans cette fonction seuls les employé ayant pour superieur le manager avec l'id donné seront affichés
 * @return -- tableau contenant toutes les informations relatives aux employés (de type 2 : non-manager)
 */
function afficher_mb() 
{
	$dbh = init_connexion();
	$req = 'SELECT * FROM Employe where type_Employe=2 and Superieur=:id'; 
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$resultat = $prep->fetchAll();
	return $resultat;
} 
/**
 * Fonction Valider_Etat_Formation
 * Cette fonction va permettre selon le choix fait du manager de valider ou de refuser une formation 
 * demandée par un employé.
 * Si elle est refusée, les crédits de l'employé luis sont réatribués.
 * @param [string] $etat
 * @param [int] $formation
 * @param [int] $id_employe
 * @return void
 */
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