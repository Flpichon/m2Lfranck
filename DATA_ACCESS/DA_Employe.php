<?php
include_once(dirname(__FILE__) . "/../BDD/connexion_bdd.php");

/**
 * function Afficher_formations_actuelles_encours()
 *
 * @return -- tableau contenant les formations en cours, en attente ou validé pour un Employé
 */
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
/**
 * fonction Afficher_formations()
 *
 * @return -- un tableau avec la liste des formations
 */
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
}
/**
 * fonction info_Employe
 *
 * @param [int] $id
 * @return -- tableau des informations relatives à l'employé selectionné par son id
 */
function info_Employe($id)
{
	$dbh=init_connexion();
	$req="select * from Employe where id_Employe= :id";
	$prep=$dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $id));
	$resultat=$prep->fetch(PDO::FETCH_ASSOC);
	return $resultat;
}
/**
 * function connexion_utilisateur
 * Cette fonction verifie si le Pseudo et le mot de passe ont bien été saisit.
 * Ensuite elle appelle la fonction : recherche_utilisateur afin de déterminer l'existence d'un pseudo et d'un mot de passe
 * Enfin si l'utilisateur est trouvé, la fonction crée une session ainsi que des variables de sessions.
 * @return void
 */
function connexion_utilisateur()
{
	$resultat = false;
	if ($_POST['Pseudo'] and $_POST['mdp'])
	{
		$employe = recherche_utilisateur($_POST['Pseudo'], $_POST['mdp']);
		if ($employe)
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
/**
 * Fonction DemarrerSession
 * Verifie si une session est créée, sinon démarre une session
 * @return void
 */
function DemarrerSession()
{
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}

/**
 * fonction EstConnecte()
 * Cette fonction vérifie la presence de la variable de session relative à l'id de l'employé.
 * Si elle n'est pas présente, elle redirige vers la page de connexion.
 * @return void
 */
function EstConnecte()
{
	DemarrerSession();
	if (!isset($_SESSION['id_Employe'])) 
	{
		header('location: /m2Lfranck/page_connexion.php');
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

function Superieur_Employe()
{
	$dbh=init_connexion(); 
	$req='SELECT nom_Employe from employe where id_Employe = (select Superieur from employe where id_Employe=:id)';
	$prep=$dbh->prepare($req);
	$resultat = $prep->execute(array('id' => $_SESSION['id_Employe']));
	$resultat = $prep->fetch();
	return $resultat;
}


?>