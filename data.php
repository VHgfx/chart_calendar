<?php
include_once('db.php');

// Initialize variables
$counts = array();

$statutNumbers = range(1, 16);

foreach ($statutNumbers as $statut) {
    $query = "SELECT COUNT(*) as total FROM fake_historique_modif_statut WHERE statut = ?";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        if (!empty($start_date) && !empty($end_date)) {

            $query .= " AND `date` BETWEEN ? AND ?";
            $stmt = $connexion->prepare($query);
            $stmt->bind_param("iss", $statut, $start_date, $end_date);


        } elseif (!empty($start_date) && empty($end_date)) {
            $query .= " AND `date` > ?";
            $stmt = $connexion->prepare($query);
            $stmt->bind_param("is", $statut, $start_date);

            
        } elseif (empty($start_date) && !empty($end_date)) {

            $query .= " AND `date` < ?";
            $stmt = $connexion->prepare($query);
            $stmt->bind_param("is", $statut, $end_date); // Reordered parameters        
        }
    } else {
        $stmt = $connexion->prepare($query);
        $stmt->bind_param("i", $statut);
    }

    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $counts[$statut] = $count;

    $stmt->close();
}

   // return calculateNb($counts);

function calculateNb($counts){
    $nb_candidats_contactes = $counts[2] + $counts[3] + $counts[4] + $counts[5] + $counts[6] + $counts[7] + $counts[8] + $counts[9] + $counts[10] + $counts[11] + $counts[12] + $counts[13] + $counts[14] + $counts[15] + $counts[16];
    $nb_entretiens_realises = $counts[7] + $counts[8] + $counts[9] + $counts[10] + $counts[11] + $counts[12] + $counts[13] + $counts[14] + $counts[15] + $counts[16];
    $nb_candidats_prerequis = $counts[6] + $counts[7] + $counts[8] + $counts[9] + $counts[10] + $counts[11] + $counts[12] + $counts[13] + $counts[14] + $counts[15] + $counts[16];
    $nb_demandes_cnaps = $counts[9];
    $nb_candidats_cnaps = $counts[12] + $counts[13] + $counts[14] + $counts[15] + $counts[16];
    $nb_candidats_attente_formation = $counts[13];
    $nb_candidats_entres_formation = $counts[14];
    $nb_echecs_test = $counts[5];
    $nb_echecs_entretien = $counts[8];
    $nb_echecs_cnaps = $counts[10];
    $nb_echecs_projet = $counts[16];

    /*return [
        "Candidats Contactés" => intval($nb_candidats_contactes),
        "Entretiens Réalisés" => intval($nb_entretiens_realises),
        "Prérequis" => intval($nb_candidats_prerequis),
        "Demandes en Cours" => intval($nb_demandes_cnaps),
        "Autorisation CNAPS" => intval($nb_candidats_cnaps),
        "Attente Formation" => intval($nb_candidats_attente_formation),
        "Entrés en Formation" => intval($nb_candidats_entres_formation),
        "Échec Test" => intval($nb_echecs_test),
        "Refusé Entretien" => intval($nb_echecs_entretien),
        "Refusé CNAPS" => intval($nb_echecs_cnaps),
        "Demandes en Cours" => intval($nb_echecs_projet)
    ];*/

    $result = [
        "Candidats contactés" => intval($nb_candidats_contactes),
        "Entretiens réalisés" => intval($nb_entretiens_realises),
        "Candidats avec les prérequis" => intval($nb_candidats_prerequis),
        "Nombre de demande CNAPS" => intval($nb_demandes_cnaps),
        "Candidats avec le CNAPS" => intval($nb_candidats_cnaps),
        "Candidats en attente de formation" => intval($nb_candidats_attente_formation),
        "Candidats entrés en formation" => intval($nb_candidats_entres_formation),
        "Refusés au test" => intval($nb_echecs_test),
        "Refusés à l'entretien" => intval($nb_echecs_entretien),
        "Refusés au CNAPS" => intval($nb_echecs_cnaps),
        "Abandons de projet" => intval($nb_echecs_projet)
    ];

    return [
        "data" => [
            "labels" => array_keys($result),
            "value" => array_values($result)
        ]
    ];
}

$result = calculateNb($counts);

//$resultSearch = ['data' => $result];

echo json_encode($result);