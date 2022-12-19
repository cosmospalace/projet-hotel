<?php require_once '../inc/init.php'; 

// afficher la liste des équipements de l'hôtel et pouvoir les modifier et les supprimer

if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $pdo -> query("DELETE FROM equipments WHERE id_equip = '$_GET[id_equip]'");

    $content .= '<div class="alert alert-success">L\'équipement a bien été supprimé</div>';

    $_GET['action'] = 'affichage';

    header('admin_equipments.php');
}

if (isset($_GET['action']) && $_GET['action'] == 'modification')
{
    $pdo -> query("UPDATE equipments WHERE id_equip = '$_GET[id_equip]'");

    $content .= '<div class="alert alert-success">L\'équipement a bien été modifié</div>';

    $_GET['action'] = 'affichage';

    header('admin_equipments.php');
}

$r = $pdo -> query("SELECT * FROM equipments");

// affichage des équipements dans un tableau

if($r -> rowCount() > 1)
{
    $content .= '<h1 class="text-center display-4">Gestion des ' . $r->rowCount() . ' équipements </h1>';
}else{
    $content .= '<h1 class="text-center display-4">Gestion de l\'équipement </h1>';
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

while ($row = $r->fetch(PDO::FETCH_ASSOC))
{
    $content .= '<tr>';

    $content .= "<td class=\"align-middle\">$row[id_equip]</td>";
    $content .= "<td class=\"align-middle\">$row[name_equip]</td>";
    $content .= "<td class=\"align-middle\"><a href=\"?action=modification&id_equip=$row[id_equip]\" class=\"btn btn-warning\">Modification</a></td>";
    $content .= "<td class=\"align-middle\"><a href=\"?action=suppression&id_equip=$row[id_equip]\" class=\"btn btn-danger\">Suppression</a></td>";

    $content .= '</tr>';
}

$content .= '</table>';

require_once '../inc/header.inc.php'; ?>

<?= $content ?>

<!-- Formulaire d'ajout d'équipements à la BDD -->

<h2 class="text-center display-4">Ajouter un équipement</h2>

<div class="container">
    <form method="post" action="admin_equipments.php">
        <div class="form-group">
            <label for="name_equip">Nom de l'équipement</label>
            <input type="text" class="form-control" id="name_equip" name="name_equip" placeholder="Nom de l'équipement">
        </div>
        <br>
        <button type="submit" class="btn btn-warning">Ajouter</button>
    </form>
</div>

<?php require_once '../inc/footer.inc.php' ?>

