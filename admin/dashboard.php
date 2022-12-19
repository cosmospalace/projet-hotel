<?php require_once '../inc/init.php';

// if (!userIsAdmin())
// {
//     header('location:../dashboard.php');
//     exit();
// }

    require_once '../inc/header.inc.php'; ?>


<h1 class="text-center display-2">Admin Dashboard</h1>
<br>
<div class="container text-center">
    <h2 class="text-muted display-4">Gestion des clients, services, équipements, etc</h2>
        <ul class="list-unstyled">
            <li><a href="admin_users.php" class="link-danger">Liste des clients</a></li>
            <li><a href="admin_reservation.php" class="link-danger">Liste des réservations</a></li>
            <li><a href="admin_rooms.php" class="link-danger">Liste des chambres</a></li>
            <li><a href="admin_services.php" class="link-danger">Liste des services</a></li>
            <li><a href="admin_equipments.php" class="link-danger">Liste des équipements</a></li>
        </ul>
    <h2 class="text-muted display-4">Gestion du carousel</h2>
        <ul class="list-unstyled">
            <li><a href="admin_carousel.php" class="link-danger">Gestion des images du carousel</a></li>
        </ul>
    <h2 class="text-muted display-4">Modération</h2>
        <ul class="list-unstyled">
            <li><a href="admin_messages.php" class="link-danger">Gestion des messages du formulaire</a></li>
            <li><a href="admin_avis.php" class="link-danger">Modération des avis</a></li>
        </ul>
</div>

<?php require_once '../inc/footer.inc.php'; ?>