<form method="post">
    <select required name="product" id="product" class="input-field" placeholder="Nom du produit">
        <option selected>Séléctionnez la catégorie de produit</option>
        <option value="Enduit">Enduit</option>
        <option value="Peinture">Peinture</option>
        <option value="Pierre">Plaquettes, brique, pierre</option>
        <option value="Colle">Colle, joints</option>
        <option value="ITE">ITE</option>
    </select>
    <label for="type"></label>
    <input required class="input-field" id="type" name="type" type="text" class="input-field" placeholder="Type">
    <label for="unit_price"></label>
    <input required class="input-field" id="unit_price" type="text" placeholder="Prix Unitaire">
    <label for="surface_per_unit"></label>
    <input required class="input-field" id="surface_per_unit" type="text" placeholder="Surface par unité">
    <label for="unit_quantity"></label>
    <input required class="input-field" id="unit_quantity" type="text" placeholder="Quantité par unité">
    <label for="unit"></label>
    <input required class="input-field" id="unit" type="text" placeholder="Unité (L, kg, ...)">
    <button id="valid-btn" name="button" class="valid-button" type="submit" ><?php echo(isset($_GET['action']) && $_GET['action'] === 'create' ? 'Créer un produit' : "Modifier produit"); ?> </button>
</form>