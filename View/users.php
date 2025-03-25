<h2>Gestion des utilisateurs</h2>
<a href="index.php?component=user&action=create">
    <button class="button">Créer un utilisateur</button>
</a>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom d'utilisateur</th>
        <th>Administrateur</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($users) > 0): ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= $user['admin'] == 1 ? 'Oui' : 'Non' ?></td>
                <td class="actions">
                    <a href="index.php?component=user&action=edit&id=<?= $user['id'] ?>" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?component=users&action=delete&id=<?= $user['id'] ?>"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')"
                       title="Supprimer" class="delete-icon">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Aucun utilisateur trouvé</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <?php if ($page > 1): ?>
            <a href="index.php?component=users&page=<?= $page - 1 ?>">Précédent</a>
        <?php endif; ?>

        <?php
        $start = max(1, $page - 2);
        $end = min($totalPages, $page + 2);

        if ($start > 1) {
            echo '<a href="index.php?component=users&page=1">1</a>';
            if ($start > 2) echo '<span>...</span>';
        }

        for ($i = $start; $i <= $end; $i++):
            ?>
            <?php if ($i == $page): ?>
            <span class="current-page"><?= $i ?></span>
        <?php else: ?>
            <a href="index.php?component=users&page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
        <?php endfor;

        if ($end < $totalPages) {
            if ($end < $totalPages - 1) echo '<span>...</span>';
            echo '<a href="index.php?component=users&page=' . $totalPages . '">' . $totalPages . '</a>';
        }
        ?>

        <?php if ($page < $totalPages): ?>
            <a href="index.php?component=users&page=<?= $page + 1 ?>">Suivant</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
