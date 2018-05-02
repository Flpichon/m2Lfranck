<?php
include_once(dirname(__FILE__) . "/../BDD/connexion_bdd.php");

function Afficher_formations_actuelles_encours()
{
	$dbh = init_connexion();
	$req = 'SELECT titre_Formation,description_forma,date_Formation,duree_Formation,nom_Prestataire
	 FROM Prestataire 
	 inner join Formation 
	 on Prestataire.id_Prestataire=Formation.id_Prestataire 
	 inner join Selectionner 
	 on Formation.id_Formation = Selectionner.id_Formation 
	 inner join Employe on Selectionner.id_Employe=Employe.id_Employe 
	 where Employe.id_Employe =:id 
	 and (etat="en cours" or etat="en attente" or etat="validé") 
	 and (duree_Formation+ date_Formation)>CURDATE()';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
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
/**
 * function recherche_utilisateur
 *
 * @param [string] $Pseudo
 * @param [string] $mdp
 * @return void
 * 
 * Place le pseudo et le mot de passe d'un utilisateur en paramètres
 * retourne true si pseudo || mot de passe sont présents dans la BDD
 */
function recherche_utilisateur($Pseudo, $mdp)//début
{
	$dbh = init_connexion();
	$req = "select Pseudo,mdp,id_Employe,Prenom_Employe,nom_Employe,credit,type_Employe from Employe inner join Type_Employe on Employe.type_Employe=Type_Employe.id_Type_Employe where Pseudo= :pseudo and mdp= md5(:mdp)";
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('pseudo' => $Pseudo,'mdp' => $mdp));
			if ($resultat) 
			{
				$resultat = $prep->fetch();
			}
	$dbh = null;
	return $resultat;
}//fin

/**
 * function connexion_utilisateur
 *
 * @return void
 */
function connexion_utilisateur()
{
	$resultat = false;
	if ($_POST['Pseudo'] and $_POST['mdp'])
	{
		$employe = recherche_utilisateur($_POST['Pseudo'], $_POST['mdp']);
		{
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
	if (!isset($_SESSION['id_Employe'])) 
	{
		header('location: ../page_connexion.php');
		exit;
	}
}

/**
 * function AfficherDate
 *
 * @param [Date] $date
 * @return void
 * cette fonction permet de renvoyer dans le format souhaité une date entrée en paramètres
 */
function AfficherDate($date)
{
	$phpdate = strtotime($date);
	return date('d-m-Y', $phpdate);
}

/**
 * function CreditEmploye
 * renvoit le nombre de crédits d'un employé
 *
 * @return void
 */
function CreditEmploye()
{
	$dbh = init_connexion();
	$req = 'SELECT `credit` from Employe where id_Employe=:id';
	$prep = $dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$resultat = $prep->fetch();
	return $resultat;
}
?>