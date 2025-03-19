export const updateTypeSelect = (products, selectedProduct, typeSelect) => {
    const filteredProducts = products.filter(product => product.product === selectedProduct)
    typeSelect.innerHTML = ''
    const defaultOption = document.createElement('option')
    defaultOption.textContent = 'Sélectionnez un type'
    typeSelect.appendChild(defaultOption)

    filteredProducts.forEach(product => {
        const option = document.createElement('option')
        option.value = product.type
        option.textContent = product.type
        typeSelect.appendChild(option)
    })
}