<?php require_once '../inc/init.php';

// Afficher les avis laissés par les clients sur la page d'accueil home.php
// Possibilité de les supprimer

if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $pdo -> query("DELETE FROM reviews WHERE id_avis = '$_GET[id_reviews]'");

    $content .= '<div class="alert alert-success">L\'avis a bien été supprimé</div>';

    $_GET['action'] = 'affichage';

    header('admin_avis.php');
}

$r = $pdo -> query("SELECT * FROM reviews");

if($r -> rowCount() > 1)
{
    $content .= '<h1 class="text-center display-4">Modération des ' . $r->rowCount() . ' avis </h1>';
}else{
    $content .= '<h1 class="text-center display-4">Modération de l\'avis </h1>';
}

$content .= '<table class="table table-striped container"><tr>';

for ($i = 0; $i < $r->columnCount(); $i++)
{
    $colonne = $r->getColumnMeta($i);

    $content .= '<th>' . $colonne['name'] . '</th>';
}

$content .= '<th>Supprimer</th>';

$content .= '</tr>';

while ($row = $r->fetch(PDO::FETCH_ASSOC))
{
    $content .= '<tr>';

    $content .= "<td class=\"align-middle\">$row[id_reviews]</td>";
    $content .= "<td class=\"align-middle\">$row[id_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[review]</td>";
    $content .= "<td class=\"align-middle\">$row[rating]</td>";
    $content .= "<td class=\"align-middle\">$row[id_room]</td>";
    $content .= "<td class=\"align-middle\"><a href=\"?action=suppression&id_reviews=$row[id_reviews]\" class=\"btn btn-danger\"><i class=\"fas fa-trash-alt\"></i>Suppression</a></td>";

    $content .= '</tr>';
}

$content .= '</table>';

require_once '../inc/header.inc.php'; ?>

<?= $content ?>

<?php require_once '../inc/footer.inc.php'; ?>
