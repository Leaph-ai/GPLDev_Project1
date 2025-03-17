<form method="post">
    <label for="select-option">Choisissez une option :</label>
    <select id="select-option" name="product-option">
        <option value="option1">Enduit</option>
        <option value="option2">Peinture</option>
        <option value="option3">ITE</option>
        <option value="option4">Pierre</option>
        <option value="option5">Colle, joints</option>
    </select>

    <label for="type-input">Type :</label>
    <input required type="text" id="type-input" name="type">

    <label for="unit-price-input">Prix unitaire :</label>
    <input required type="text" id="unit-price-input" name="unit-price">

    <label for="surface-per-unit-input">Surface par unité :</label>
    <input required type="text" id="surface-per-unit-input" name="surface-per-unit">

    <label for="unit-quantity-input">Quantité unitaire :</label>
    <input required type="text" id="unit-quantity-input" name="unit-quantity">

    <label for="unit-input">Unité(L, kg) :</label>
    <input required type="text" id="unit-input" name="unit">

    <button name="submit-btn" type="submit">Envoyer</button>
</form>
