<?php require_once('../inc/init.php'); ?>

<!-- afficher les membres sous forme de tableau et pouvoir les supprimer -->

<?php

if (isset($_GET['action']) && $_GET['action'] == 'suppression') 
{
    $pdo -> query("DELETE FROM client WHERE id_cli = '$_GET[id_cli]'");

    $content .= '<div class="alert alert-success">Le client a bien été supprimé</div>';

    $_GET['action'] = 'affichage'; 

    header('admin_users.php');
}

if (isset($_GET['action']) && $_GET['action'] == 'modification')
{
    $pdo -> query("UPDATE client WHERE id_cli = '$_GET[id_cli]'");

    $content .= '<div class="alert alert-success">Le client a bien été modifié</div>';

    $_GET['action'] = 'affichage';

    header('admin_users.php');
}

$r = $pdo -> query("SELECT * FROM client");

// cacher l'admin dans la liste des membres

if(isset($_SESSION['client']['status_ci']) && $_SESSION['client']['status_ci'] == 1)
{
    $r = $pdo -> query("SELECT * FROM client WHERE status_ci != 1");
}

// affichage des clients dans un tableau

if($r -> rowCount() > 1) 
{
    $content .= '<h1 class="text-center display-4">Gestion des ' . $r->rowCount() . ' membres </h1>';
}else{
    $content .= '<h1 class="text-center display-4">Gestion du membre </h1>';
}

$content .= '<table class="table table-striped container"><tr>';

for ($i = 0; $i < $r->columnCount(); $i++) 
{
    $colonne = $r->getColumnMeta($i);

    $content .= '<th>' . $colonne['name'] . '</th>';
}

$content .= '<th>Supprimer</th>';

$content .= '</tr>';

while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
    $content .= '<tr>';

    foreach ($row as $key => $value) {
        if ($key == 'password_cli') {
            $content .= '<td>********</td>';
        }
        else
        {
            $content .= '<td>' . $value . '</td>';
        }
    }

    $content .= "<td class=\"align-middle\">$row[id_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[lastname_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[firstname_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[mail_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[password_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[address_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[city_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[zipcode_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[phone_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[birthdate_cli]</td>";
    $content .= "<td class=\"align-middle\">$row[status_ci]</td>";
    $content .= "<td class=\"align-middle\">$row[country_ci]</td>";
    $content .= "<td class=\"align-middle\"><a href=?action=suppression&id_cli=$row[id_cli]>Supprimer</a></td>";
    $content .= '</tr>';
}

$content .= '</table>';

require_once('../inc/header.inc.php');

?>

<?= $content ?>

<?php

require_once('../inc/footer.inc.php');

?>
