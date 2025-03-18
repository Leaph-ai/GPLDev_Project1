<div class="header">
    <h1>Créer un prévisionnel</h1>
    <p>Produits Utilisateurs Déconnexion Admin</p>
</div>
<div class="container">
    <div class="section">
        <button class="button">Importer un PDF</button>
        <p>Coût Total (HT)</p>
    </div>
    <div class="section">
        <div class="section-header">
            <h2>Gestion des produits</h2>
            <button id="addRowButton" class="button">Ajouter une ligne</button>
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
            const tr = document.createElement("tr")
            tr.innerHTML = `
                <td>
                    <select class="select-option" name="product-option">
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
                <td><input type="number" name="surface"></td>
                <td><input type="number" name="quantity"></td>
                <td><input type="number" name="unitPrice"></td>
                <td><input type="number" name="total"></td>
                <td><button class="delete-line-button">Supprimer</button></td>
            `
            tr.querySelector(".select-option").addEventListener("change", (e) => {
                updateTypeSelect(products, e.target.value, tr.querySelector(".type-select"))
            })
            tbody.appendChild(tr)
        })
    })
</script>