<?php require_once '../inc/init.php';

// afficher la liste des services et pouvoir les modifier et les supprimer

if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $pdo -> query("DELETE FROM service WHERE id_services = '$_GET[id_services]'");

    $content .= '<div class="alert alert-success">Le service a bien été supprimé</div>';

    $_GET['action'] = 'affichage';

    header('admin_services.php');
}

if (isset($_GET['action']) && $_GET['action'] == 'modification')
{
    $pdo -> query("UPDATE service WHERE id_services = '$_GET[id_services]'");

    $content .= '<div class="alert alert-success">Le service a bien été modifié</div>';

    $_GET['action'] = 'affichage';

    header('admin_services.php');
}

$r = $pdo -> query("SELECT * FROM services");

// affichage des services dans un tableau

if($r -> rowCount() > 1)
{
    $content .= '<h1 class="text-center display-4">Gestion des ' . $r->rowCount() . ' services </h1>';
}else{
    $content .= '<h1 class="text-center display-4">Gestion du service </h1>';
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

    $content .= "<td class=\"align-middle\">$row[id_services]</td>";
    $content .= "<td class=\"align-middle\">$row[icon]</td>";
    $content .= "<td class=\"align-middle\">$row[name]</td>";
    $content .= "<td class=\"align-middle\">$row[description]</td>";
    $content .= "<td class=\"align-middle\"><a href=\"?action=modification&id_services=$row[id_services]\"><i class=\"fas fa-edit\"></i></a></td>";
    $content .= "<td class=\"align-middle\"><a href=\"?action=suppression&id_services=$row[id_services]\"><i class=\"fas fa-trash-alt\"></i></a></td>";

    $content .= '</tr>';
}

$content .= '</table>';

require_once '../inc/header.inc.php'; ?>

<?= $content ?>

<!-- Formulaire d'ajout de services -->

<!-- C'EST UN PLACEHOLDER - C'EST UN PLACEHOLDER - C'EST UN PLACEHOLDER - C'EST UN PLACEHOLDER -->

<h2 class="text-center display-4">Ajouter un service</h2>

<div class="container">
    <form methode="POST" action="">
        <div class="form-group">
            <label for="icon">Icone</label>
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Icone">
        </div>
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nom">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Description">
        </div>
        <br>
        <button type="submit" class="btn btn-warning">Ajouter</button>
    </form>
</div>


<?php require_once '../inc/footer.inc.php'; ?>