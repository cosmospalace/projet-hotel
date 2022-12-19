<?php require_once '../inc/init.php';

// afficher la liste des chambres et pouvoir les modifier et modifier leurs équipements

if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $pdo -> query("DELETE FROM room WHERE id_room = '$_GET[id_room]'");

    $content .= '<div class="alert alert-success">La chambre a bien été supprimée</div>';

    $_GET['action'] = 'affichage';

    header('admin_rooms.php');
}

if (isset($_GET['action']) && $_GET['action'] == 'modification')
{
    $pdo -> query("UPDATE room WHERE id_room = '$_GET[id_room]'");

    $content .= '<div class="alert alert-success">La chambre a bien été modifiée</div>';

    $_GET['action'] = 'affichage';

    header('admin_rooms.php');
}

$r = $pdo -> query("SELECT * FROM room");

// affichage des chambres dans un tableau

if($r -> rowCount() > 1)
{
    $content .= '<h1 class ="text-center display-4">Gestion des ' . $r->rowCount() . ' chambres </h1>';
}else{
    $content .= '<h1 class ="text-center display-4">Gestion de la chambre </h1>';
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

    $content .= "<td class=\"align-middle\">$row[id_room]</td>";
    $content .= "<td class=\"align-middle\">$row[title_room]</td>";
    $content .= "<td class=\"align-middle\">$row[price_room]</td>";
    $content .= "<td class=\"align-middle\">$row[type_chambre]</td>";
    $content .= "<td class=\"align-middle\">$row[size] m²</td>";
    $content .= "<td class=\"align-middle\">$row[description]</td>";
    $content .= "<td class=\"align-middle\">$row[adults]</td>";
    $content .= "<td class=\"align-middle\">$row[children]</td>";
    $content .= "<td class=\"align-middle\">$row[status]</td>";
    $content .= "<td class=\"align-middle\"><a href=?action=modification&id_room=$row[id_room] class=\"btn btn-warning\">Modifier</a></td>";
    $content .= "<td class=\"align-middle\"><a href=?action=suppression&id_room=$row[id_room] class=\"btn btn-danger\">Supprimer</a></td>";

$content .= '</tr>';

}

$content .= '</table>';

require_once '../inc/header.inc.php'; ?>

<?= $content ?>

<?php require_once '../inc/footer.inc.php'; ?>

