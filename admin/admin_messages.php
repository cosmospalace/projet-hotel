<?php require_once '../inc/init.php';

/* Afficher la liste des messages reçus via le formulaire de contact.
Possibilité de les marquer comme lus ou non lus, de les supprimer.
*/

if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $pdo -> query("DELETE FROM contact WHERE id_contact = '$_GET[id_contact]'");

    $content .= '<div class="alert alert-success">Le message a bien été supprimé</div>';

    $_GET['action'] = 'affichage';

    header('admin_messages.php');
}

$r = $pdo -> query("SELECT * FROM contact");

if($r -> rowCount() > 1)
{
    $content .= '<h1 class="text-center display-4">Gestion des ' . $r->rowCount() . ' messages </h1>';
}else{
    $content .= '<h1 class="text-center display-4">Gestion du message </h1>';
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

    $content .= "<td class=\"align-middle\">$row[id_contact]</td>";
    $content .= "<td class=\"align-middle\">$row[lastname]</td>";
    $content .= "<td class=\"align-middle\">$row[firstname]</td>";
    $content .= "<td class=\"align-middle\">$row[email]</td>";
    $content .= "<td class=\"align-middle\">$row[message]</td>";
    $content .= "<td class=\"align-middle\">$row[date]</td>";
    $content .= "<td class=\"align-middle\"><a href=\"?action=suppression&id_contact=$row[id_contact]\" class=\"btn btn-danger\"><i class=\"fas fa-trash-alt\"></i>Suppression</a></td>";

    $content .= '</tr>';
}

$content .= '</table>';

require_once '../inc/header.inc.php'; ?>

<?= $content ?>

<?php require_once '../inc/footer.inc.php'; ?>

