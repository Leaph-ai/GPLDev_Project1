// Ajouter cette fonction exportée dans le fichier components/previ.js
export const setupAutoCalculator = (row, products) => {
    const productSelect = row.querySelector('.select-product');
    const typeSelect = row.querySelector('[name="type-option"]');
    const surfaceInput = row.querySelector('[name="surface"]');
    const quantityInput = row.querySelector('[name="quantity"]');
    const unitPriceInput = row.querySelector('[name="unitPrice"]');
    const totalInput = row.querySelector('[name="total"]');

    // Fonction de calcul
    const calculateQuantityAndTotal = () => {
        const selectedProduct = productSelect.value;
        const selectedType = typeSelect.value;
        const surface = parseFloat(surfaceInput.value) || 0;

        if (selectedProduct && selectedType && surface > 0) {
            // Rechercher le produit correspondant
            const productInfo = products.find(p =>
                p.product === selectedProduct && p.type === selectedType);

            if (productInfo) {
                // Calcul de la quantité: surface ÷ surface_per_unit
                const quantity = surface / parseFloat(productInfo.surface_per_unit);

                // Afficher la quantité arrondie à 2 décimales
                quantityInput.value = quantity.toFixed(2);

                // Afficher le prix unitaire
                unitPriceInput.value = parseFloat(productInfo.unit_price).toFixed(2);

                // Calcul du prix total: quantité × prix unitaire
                const total = quantity * parseFloat(productInfo.unit_price);
                totalInput.value = total.toFixed(2);
            }
        }
    };

    // Écouter les changements qui doivent déclencher le calcul
    typeSelect.addEventListener('change', calculateQuantityAndTotal);
    surfaceInput.addEventListener('input', calculateQuantityAndTotal);
}