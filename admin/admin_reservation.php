<?php require_once '../inc/init.php'; ?>

<!-- partie traitement -->

<?php

if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $pdo -> query("DELETE FROM reservation WHERE id_res = '$_GET[id_res]'");

    $content .= '<div class="alert alert-success">La réservation a bien été supprimée</div>';

    $_GET['action'] = 'affichage';

    header('admin_reservation.php');
}

if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
    $pdo -> query("UPDATE reservation WHERE id_res = '$_GET[id_res]'");

    $content .= '<div class="alert alert-success">La réservation a bien été modifiée</div>';

    $_GET['action'] = 'affichage';

    header('admin_reservation.php');
}

$r = $pdo -> query("SELECT * FROM reservation");

// affichage des réservations dans un tableau

if($r -> rowCount() > 1)
{
    $content .= '<h1 class="text-center display-4">Liste des ' . $r->rowCount() . ' réservations </h1>';
}else{
    $content .= '<h1 class="text-center display-4">Liste de la réservation </h1>';
}

$content .= '<table class="table table-striped container"><tr>';

for ($i = 0; $i < $r->columnCount(); $i++)
{
    $colonne = $r->getColumnMeta($i);

    $content .= '<th>' . $colonne['name'] . '</th>';
}

$content .= '<th>Modifier</th>';
$content .= '<th>Supprimer</th>';

$content .= '</tr>';

while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
    $content .= '<tr>';

$content .= "<td class=\"align-middle\">$row[id_res]</td>";
$content .= "<td class=\"align-middle\">$row[id_room]</td>";
$content .= "<td class=\"align-middle\">$row[id_cli]</td>";
$content .= "<td class=\"align-middle\">$row[date]</td>";
$content .= "<td class=\"align-middle\">$row[adults]</td>";
$content .= "<td class=\"align-middle\">$row[children]</td>";
$content .= "<td class=\"align-middle\"><a href=?action=modification&id_reservation=$row[id_reservation] class=\"btn btn-warning\">Modifier</a></td>";
$content .= "<td class=\"align-middle\"><a href=?action=suppression&id_reservation=$row[id_reservation] class=\"btn btn-danger\">Supprimer</a></td>";

$content .= '</tr>';

}

$content .= '</table>';

require_once('../inc/header.inc.php');

?>

<!-- partie affichage -->

<?= $content ?>

<?php require_once '../inc/footer.inc.php'; ?>
