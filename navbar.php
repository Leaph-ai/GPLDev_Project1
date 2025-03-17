<?php
$current_page = $_GET['component'] ?? '';
?>

<nav>
    <a href="index.php">
        <img src="assets/images/AR+FACADES.png" alt="Logo">
    </a>
    <a href="index.php?component=previsionnel" class="<?= ($current_page == 'previsionnel') ? 'active' : '' ?>">+ Créer un prévisionnel</a>
    <a href="index.php?component=products" class="<?= ($current_page == 'products') ? 'active' : '' ?>">Produits</a>
    <a href="index.php?component=users" class="<?= ($current_page == 'users') ? 'active' : '' ?>">Utilisateurs</a>
    <a href="index.php?disconnect=true">Déconnexion</a>
    <div class="user">
        <i class="fa-solid fa-user me-2"></i><?php echo $_SESSION['username']; ?>
    </div>
</nav>
