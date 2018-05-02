
<?php
include_once '../DATA_ACCESS/DA_Employe.php';
Estconnecte();
$test = Afficher_formations_actuelles_encours();
?>

<?php



foreach ($test as $mb) {
   
    $pdf .= '<p style="font-weight:bold;">Formation : <span style="font-weight:normal">';
    $pdf .= $mb['titre_Formation'];
    $pdf .= '</span></p>';
    $pdf .= '<p style="font-weight:bold;">Début de la formation : <span style="font-weight:normal">';
    $pdf .= AfficherDate($mb['date_Formation']);
    $pdf .= '</span></p>';
    $pdf .= '<p style="font-weight:bold;">Nombre de jours : <span style="font-weight:normal">';
    $pdf .= $mb['duree_Formation'];
    $pdf .= '</span></p>';
    $pdf .= '<p style="font-weight:bold;">Prestataire : <span style="font-weight:normal">';
    $pdf .= $mb['nom_Prestataire'];
    $pdf .= '</span></p>';
    $pdf .= '<p style="font-weight:bold;">Description : <span style="font-weight:normal;">';
    $pdf .= $mb['description_forma'];
    $pdf .= '</span></p>';
    $pdf .= '<div style="border-bottom:thin solid black;"></div><br/><br/>';
}





require_once '../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetTitle("Vos formations");
$mpdf->WriteHTML($pdf);
$mpdf->Output();
?>