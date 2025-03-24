<div class="header">
    <h1>Créer un prévisionnel</h1>
</div>
<div class="container">
    <div class="section">
        <button class="button">Importer un PDF</button>
        <label for="totalCost">Coût Total (HT)</label>
        <input type="text" name="totalCost" id="totalCost" class="input-field">
    </div>
    <section>
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
            <tbody id="product-tbody">
            </tbody>
        </table>
    </section>
    <section>
        <div class="section-header">
            <h2>Gestion des équipes</h2>
        </div>
        <div class="section-content">
            <label for="prevision-input"></label>
            <input id="prevision-input" class="input-field" type="text">
            <label for="labor-cost"></label>
            <input id="labor-cost" class="input-field" type="text">
            <button class="button">Valider</button>
        </div>
    </section>
    <section>
        <div class="section-header">
            <h2>Gestions des divers</h2>
            <button class="button" id="add-divers-row">+</button>
        </div>
        <div class="section-content">
            <table id="divers-table">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Coût</th>
                </tr>
                </thead>
                <tbody id="divers-tbody">
                </tbody>
            </table>
        </div>
    </section>
</div>
<script type="module" src="./assets/javascript/services/previ.js"></script>
<script type="module" src="./assets/javascript/components/previ.js"></script>
<script type="module">
    import {getProducts} from "./assets/javascript/services/previ.js"
    import {updateTypeSelect} from "./assets/javascript/components/previ.js";
    document.addEventListener("DOMContentLoaded" , async () => {
        const addRow = document.querySelector("#addRowButton")
        const productTable = document.querySelector("#productTable")
        const productTbody = productTable.querySelector("#product-tbody")
        const diversTbody = document.querySelector("#divers-tbody")
        const addDiversRow = document.querySelector("#add-divers-row")
        const products = await getProducts()
        addRow.addEventListener("click", () => {
            let maxId = 1
            if(productTbody.querySelector("tr:last-child")) {
                maxId = productTbody.querySelector("tr:last-child").getAttribute("data-id") + 1
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
                <td><input type="text" class="input-field" name="surface"></td>
                <td><input type="text" class="input-field" name="quantity"></td>
                <td><input type="text" class="input-field" name="unitPrice"></td>
                <td><input type="text" class="input-field" name="total"></td>
                <td><button type="button" data-id="${maxId}" class="delete-line-button">Supprimer</button></td>
            `
            const typeSelect = tr.querySelector(".type-select")
            const deleteLineButton = tr.querySelector(".delete-line-button")
            tr.querySelector(".select-product").addEventListener("change", (e) => {
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
            productTbody.appendChild(tr)
        })

        addDiversRow.addEventListener("click", () => {
            let maxId = 1
            if(productTbody.querySelector("tr:last-child")) {
                maxId = productTbody.querySelector("tr:last-child").getAttribute("data-id") + 1
            }
            const tr = document.createElement("tr")
            tr.innerHTML = `
                <td><input type="text"  class="divers-name input-field"></td>
                <td><input type="text" class="divers-cost input-field"></td>
                <td><button type="button" class="delete-line-button">Supprimer</button></td>
            `
            const deleteLineButton = tr.querySelector(".delete-line-button")
            deleteLineButton.addEventListener('click', (e) => {
                const trToRemove = e.target.closest("tr")
                trToRemove.remove()
            })
            diversTbody.appendChild(tr)
        })
    })
</script>