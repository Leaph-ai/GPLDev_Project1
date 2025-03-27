<div class="container">
    <form method="post" id="productForm">
        <label for="select-option">Choisissez une option :</label>
        <select id="select-option" name="product-option">
            <option value="Enduit" <?php echo(isset($productInfos) && $productInfos['product'] === "Enduit" ? "selected" : ""); ?>>Enduit</option>
            <option value="Peinture" <?php echo(isset($productInfos) && $productInfos['product'] === "Peinture" ? "selected" : ""); ?>>Peinture</option>
            <option value="ITE" <?php echo(isset($productInfos) && $productInfos['product'] === "ITE" ? "selected" : ""); ?>>ITE</option>
            <option value="Pierre" <?php echo(isset($productInfos) && $productInfos['product'] === "Pierre" ? "selected" : ""); ?>>Pierre</option>
            <option value="Colle" <?php echo(isset($productInfos) && $productInfos['product'] === "Colle" ? "selected" : ""); ?>>Colle, joints</option>
        </select>

        <div class="form-container">
            <label for="type-input">Type :</label>
            <input class="input-field" required type="text" id="type-input" name="type" value="<?php echo(isset($productInfos) && isset($productInfos['type']) ? $productInfos['type'] : ""); ?>">
        </div>

        <div class="form-container">
            <label for="unit-price-input">Prix unitaire :</label>
            <input class="input-field" required type="text" id="unit-price-input" name="unit-price" value="<?php echo(isset($productInfos) && isset($productInfos['unit_price']) ? $productInfos['unit_price'] : ""); ?>">
        </div>

        <div class="form-container">
            <label for="surface-per-unit-input">Surface par unité :</label>
            <input class="input-field" required type="text" id="surface-per-unit-input" name="surface-per-unit" value="<?php echo(isset($productInfos) && isset($productInfos['surface_per_unit']) ? $productInfos['surface_per_unit'] : ""); ?>">
        </div>

        <div class="form-container">
            <label for="unit-quantity-input">Quantité unitaire :</label>
            <input class="input-field" required type="text" id="unit-quantity-input" name="unit-quantity" value="<?php echo(isset($productInfos) && isset($productInfos['unit_quantity']) ? $productInfos['unit_quantity'] : ""); ?>">
        </div>

        <div class="form-container">
            <label for="unit-input">Unité(L, kg) :</label>
            <input class="input-field" required type="text" id="unit-input" name="unit" value="<?php echo(isset($productInfos) && isset($productInfos['unit']) ? $productInfos['unit'] : ""); ?>">
        </div>

        <div class="form-container">
            <button name="submit-btn" class="button" type="submit"><?php echo(isset($productInfos) ? "Modifier" : "Créer"); ?></button>
        </div>
    </form>
</div>
