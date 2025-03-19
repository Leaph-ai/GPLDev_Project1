<div class="header">
    <h1>Créer un prévisionnel</h1>
</div>
<div class="container">
    <div class="section">
        <button class="button">Importer un PDF</button>
        <label for="totalCost">Coût Total (HT)</label>
        <input type="text" name="totalCost" id="totalCost">
    </div>
    <div class="section">
        <div class="section-header">
            <h2>Gestion des produits</h2>
            <button id="addRowButton" class="button">+</button>
        </div>
        <table id="productTable">
            <thead>
            <tr>
                <th>Produit</th>
                <th>Type</th>
                <th>Surface</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script type="module" src="./assets/javascript/services/previ.js"></script>
<script type="module" src="./assets/javascript/components/previ.js"></script>
<script type="module">
    import {getProducts} from "./assets/javascript/services/previ.js"
    import {updateTypeSelect} from "./assets/javascript/components/previ.js";
    document.addEventListener("DOMContentLoaded" , async () => {
        const addRow = document.querySelector("#addRowButton")
        const productTable = document.querySelector("#productTable")
        const tbody = productTable.querySelector("tbody")
        const products = await getProducts()
        addRow.addEventListener("click", () => {
            let maxId = 1
            if(tbody.querySelector("tr:last-child")) {
                maxId = tbody.querySelector("tr:last-child").getAttribute("data-id") + 1
            }
            const tr = document.createElement("tr")
            tr.setAttribute("data-id", maxId)
            tr.innerHTML = `
                <td>
                    <select class="select-option select-product" name="product-option">
                        <option disabled selected>Choisissez un produit</option>
                        <option value="Enduit">Enduit</option>
                        <option value="Peinture">Peinture</option>
                        <option value="ITE">ITE</option>
                        <option value="Pierre">Pierre</option>
                        <option value="Colle">Colle, joints</option>
                    </select>
                </td>
                <td>
                    <select class="select-option type-select" name="type-option">
                        <option disabled selected>Choisissez un type</option>
                    </select>
                </td>
                <td><input type="text" name="surface"></td>
                <td><input type="text" name="quantity"></td>
                <td><input type="text" name="unitPrice"></td>
                <td><input type="text" name="total"></td>
                <td><button type="button" data-id="${maxId}" class="delete-line-button">Supprimer</button></td>
            `
            const typeSelect = tr.querySelector(".type-select")
            const deleteLineButton = tr.querySelector(".delete-line-button")
            tr.querySelector(".select-product").addEventListener("change", (e) => {
                const selectedProduct = e.target.value
                updateTypeSelect(products, e.target.value, typeSelect)
            })
            typeSelect.addEventListener("change", () => {
                const product = products.find(product => product.type === typeSelect.value)
                tr.querySelector("[name='unitPrice']").value = product.unit_price
            })
            deleteLineButton.addEventListener('click', (e) => {
                const trToRemove = e.target.closest("tr")
                trToRemove.remove()
            })
            tbody.appendChild(tr)
        })
    })
</script>