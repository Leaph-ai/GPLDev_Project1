<h2>Gestion des produits</h2>
<a href="index.php?component=product&action=create">
    <button>Créer un produit</button>
</a>

<!-- Tableau des produits -->
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Produit</th>
        <th>Type</th>
        <th>Prix unitaire</th>
        <th>Surface par unité</th>
        <th>Quantité par unité</th>
        <th>Unité</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars($product['product']) ?></td>
                <td><?= htmlspecialchars($product['type']) ?></td>
                <td><?= number_format($product['unit_price'], 2) ?> €</td>
                <td><?= number_format($product['surface_per_unit'], 2) ?> m²</td>
                <td><?= $product['unit_quantity'] ?></td>
                <td><?= htmlspecialchars($product['unit']) ?></td>
                <td class="actions">
                    <a href="index.php?component=product&action=edit&id=<?= $product['id'] ?>" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?component=product&action=delete&id=<?= $product['id'] ?>"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')"
                       title="Supprimer" class="delete-icon">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">Aucun produit trouvé</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<!-- Pagination -->
<div class="pagination">
    <?php if ($totalPages > 1): ?>
        <?php if ($page > 1): ?>
            <a href="index.php?component=products&page=<?= $page - 1 ?>">Précédent</a>
        <?php endif; ?>

        <?php
        // Afficher un nombre limité de pages
        $start = max(1, $page - 2);
        $end = min($totalPages, $page + 2);

        if ($start > 1) {
            echo '<a href="index.php?component=products&page=1">1</a>';
            if ($start > 2) echo '<span>...</span>';
        }

        for ($i = $start; $i <= $end; $i++):
            ?>
            <?php if ($i == $page): ?>
            <span class="current-page"><?= $i ?></span>
        <?php else: ?>
            <a href="index.php?component=products&page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
        <?php endfor;

        if ($end < $totalPages) {
            if ($end < $totalPages - 1) echo '<span>...</span>';
            echo '<a href="index.php?component=products&page=' . $totalPages . '">' . $totalPages . '</a>';
        }
        ?>

        <?php if ($page < $totalPages): ?>
            <a href="index.php?component=products&page=<?= $page + 1 ?>">Suivant</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
