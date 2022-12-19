<?php require_once '../inc/init.php';

// gestion des icons

// if($_POST)
// {
    foreach ($_POST as $key => $value)
    {
        $_POST[$key] = htmlentities(addslashes($value));
    }
    if(!empty($_FILES['icon']))
    {
        $nom_icon = time() . '' . $_POST['name'] . '' . $_FILES['icon']['name'];

        $icon_doc = RACINE . "../img/$nom_icon";
        $icon_bdd = URL . "../img/$nom_icon";

        if($_FILES['icon']['size'] <= 8000000)
        {
            $data = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);

            $tab = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'JPG', 'JPEG', 'PNG', 'GIF', 'SVG', 'Jpg', 'Jpeg', 'Png', 'Gif', 'Svg'];

            if(in_array($data, $tab))
            {
                copy($_FILES['icon']['tmp_name'], $icon_doc);
            }else{
                $content .= '<div class="alert alert-danger">Format non-autorisé</div>';
            }
            }else{
                $content .= '<div class="alert alert-danger">Fichier trop volumineux</div>';
            }
            $rep = $pdo -> query("INSERT INTO services (icon, name, description) VALUES ('$icon_bdd', '$_POST[name]', '$_POST[description]')");

            $content .= '<div class="alert alert-success">Le service a bien été ajouté</div>';

            $_GET['action'] = 'affichage';
            header('admin_services.php');
        }

$r = $pdo -> query("SELECT * FROM services");

// affichage des services dans un tableau

if($r->rowCount() > 1)
{
    $content .= '<h1 class="text-center display-4">Liste des ' . $r->rowCount() . ' services de l\'hôtel</h1>';
}else{
    $content .= '<h1 class="text-center" display-4">Liste du service de l\'hôtel</h1>';
}

$content .= '<table class="table table-striped"><tr>';

for ($i = 0; $i < $r->columnCount(); $i++) {

    $colone = $r->getColumnMeta($i);

    $content .= '<th>' . $colone['name'] . '</th>';
}

$content .= '<th>Modification</th>';
$content .= '<th>Suppression</th>';

$content .= '</tr>';

while($row = $r->fetch(PDO::FETCH_ASSOC))
{
    $content .= '<tr>';

    foreach($row as $key => $value)
    {
        if($key == 'icon')
        {
            $content .= "<td class=\"align-middle\"><img src=\"$value\" width=\"60\"></td>";
        }else{
            $value = substr($value, 0, 20);
            $content .= "<td class=\"align-middle\">$value</td>";
        }
    }


    $content .= "<td class=\"align-middle\"><a class=\"btn btn-warning\" href=?action=modification&id_services=$row[id_services]>Modifier</a></td>";
    $content .= "<td class=\"align-middle\"><a class=\"btn btn-danger\" href=?action=suppression&id_services=$row[id_services]>Supprimer</a></td>";
    $content .= '</tr>';
}

$content .= '</table>';

if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $pdo -> query("DELETE FROM services WHERE id_services = '$_GET[id_services]'");

    $content .= '<div class="alert alert-danger">Le service a bien été supprimé</div>';

    $_GET['action'] = 'affichage';

    header('admin_services.php');
}

if (isset($_GET['action']) && $_GET['action'] == 'modification')
{
    $pdo -> query("UPDATE services WHERE id_services = '$_GET[id_services]'");

    $content .= '<div class="alert alert-success">Le service a bien été modifié</div>';

    $_GET['action'] = 'affichage';

    header('admin_services.php');
}

// afficher la liste des services et pouvoir les modifier et les supprimer

require_once '../inc/header.inc.php'; ?>

<?= $content; ?>

<!-- Formulaire d'ajout de services -->

<h2 class="text-center display-4">Ajouter un service</h2>

<form action="admin_services.php" method="POST" enctype="multipart/form-data">
<div class="container">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius:  10px;">
            <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Enregistrer un service</h3>
            <php $content ?>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-4">

                    <div class="form-outline">
                        <label class="form-label" for="name">Nom</label>
                        <input type="text" id="name" class="form-control form-control-lg" name="name"/>
                    </div>

                    </div>
                    <div class="col-md-6 mb-4">
                    <div class="form-outline">
                        <label for="description" class="form-label">Description</label>
                        <input type="textarea" class="form-control" id="description" name="description">
                    </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4 pb-2">
                        <div class="form-outline">
                            <label for="icon" class="form-label">Icone</label>
                            <input type="file" class="form-control" id="icon" name="icon">
                        </div>
                    </div>
                </div>

                    <div>
                        <?php if(isset($_GET['action']) && $_GET['action'] == 'modification') : ?>
                            <br><input type="submit" class="btn btn-warning" value="Modifier">
                        <?php else : ?>
                            <br><input type="submit" class="btn btn-success" value="Enregistrer">
                        <?php endif; ?>
                    </div>

            </form>
            </div>
        </div>
        </div>
    </div>
</div>
</form>


<?php require_once '../inc/footer.inc.php'; ?>