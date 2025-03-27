<div class="container">
    <h1>Créer un prévisionnel</h1>
    <div class="section">
        <button class="button" id="import">Importer un PDF</button>
        <br>
        <br>
        <input type="text" name="companyName" id="companyName" class="input-field" placeholder="Saisissez le nom de l'entreprise">
        <input type="text" name="totalCost" id="totalCost" class="input-field" placeholder="Saisissez le coût total">
        <label for="totalCost">Coût Total (HT)</label>
        <br>
        <input type="date" name="limit_date" id="limit_date" class="input-field">
        <label for="limit_date">Date de validité</label>
    </div>
    <section>
        <div class="section-header">
            <h2>Gestion des produits</h2>
            <button id="addRowButton" class="button">+ Nouveau produit</button>
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
            <h2>Gestions des divers</h2>
            <button class="button" id="add-divers-row">+ Nouveau divers</button>
        </div>
            <table id="divers-table">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Coût</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="divers-tbody">
                </tbody>
            </table>
    </section>
    <section>
        <div class="section-header">
            <h2>Gestion des équipes</h2>
        </div>
        <div class="section-content">
            <label for="prevision-input"></label>
            <input id="prevision-input" class="input-field" type="text" placeholder="Saisissez le nombre d'équipes">
            <label for="labor-cost"></label>
            <input id="labor-cost" class="input-field" type="text" placeholder="Saisissez le coût de la main d'oeuvre">
        </div>
    </section>
    <div class="section section-footer">
        <button id="generatePdfButton" class="button">Générer un PDF</button>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.1/jspdf.umd.min.js"></script>
<script type="module" src="./assets/javascript/services/previ.js"></script>
<script type="module" src="./assets/javascript/components/previ.js"></script>
<script type="module" src="./assets/javascript/components/calcul.js"></script>
<script type="module">
    import { generatePDF } from './assets/javascript/services/previ.js';
    import {getProducts} from "./assets/javascript/services/previ.js"
    import {updateTypeSelect} from "./assets/javascript/components/previ.js";
    import {setupAutoCalculator} from "./assets/javascript/components/calcul.js";
    document.addEventListener("DOMContentLoaded" , async () => {
        const addRow = document.querySelector("#addRowButton")
        const productTable = document.querySelector("#productTable")
        const productTbody = productTable.querySelector("#product-tbody")
        const diversTbody = document.querySelector("#divers-tbody")
        const addDiversRow = document.querySelector("#add-divers-row")
        const products = await getProducts()
        const generatePdfButton = document.querySelector("#generatePdfButton")
        const existingRows = productTbody.querySelectorAll("tr");
        existingRows.forEach(row => {
            setupAutoCalculator(row, products);
        });


        generatePdfButton.addEventListener("click", () => {
            generatePDF()
        })

        addRow.addEventListener("click", () => {
            let maxId = 1
            if(productTbody.querySelector("tr:last-child")) {
                maxId = parseInt(productTbody.querySelector("tr:last-child").getAttribute("data-id")) + 1
            }
            const tr = document.createElement("tr")
            tr.setAttribute("data-id", maxId)
            tr.innerHTML = `
        <td>
            <select class="select-option select-product " name="product-option">
                <option disabled selected>Choisissez un produit</option>
                ${products.map(p => `<option value="${p.product}">${p.product}</option>`).filter((v, i, a) => a.indexOf(v) === i).join('')}
            </select>
        </td>
        <td>
            <select class="select-option type-select" name="type-option">
                <option disabled selected>Choisissez un type</option>
            </select>
        </td>
        <td><input type="text" class="input-field" name="surface" placeholder="Surface"></td>
        <td><input type="text" class="input-field" name="quantity" placeholder="Quantité" readonly></td>
        <td><input type="text" class="input-field" name="unitPrice" placeholder="Prix unitaire (€)" readonly></td>
        <td><input type="text" class="input-field" name="total" placeholder="Total (€)" readonly></td>
        <td><button type="button" data-id="${maxId}" class="delete-line-button">Supprimer</button></td>
    `
            const typeSelect = tr.querySelector(".type-select")
            const deleteLineButton = tr.querySelector(".delete-line-button")

            tr.querySelector(".select-product").addEventListener("change", (e) => {
                updateTypeSelect(products, e.target.value, typeSelect)
            })

            setupAutoCalculator(tr, products);

            deleteLineButton.addEventListener('click', (e) => {
                const trToRemove = e.target.closest("tr")
                trToRemove.remove()
            })
            productTbody.appendChild(tr)
        })



        function setupAutoCalculator(row, products) {
            const productSelect = row.querySelector('.select-product');
            const typeSelect = row.querySelector('[name="type-option"]');
            const surfaceInput = row.querySelector('[name="surface"]');
            const quantityInput = row.querySelector('[name="quantity"]');
            const unitPriceInput = row.querySelector('[name="unitPrice"]');
            const totalInput = row.querySelector('[name="total"]');

            const calculateQuantityAndTotal = () => {
                const selectedProduct = productSelect.value;
                const selectedType = typeSelect.value;
                const surface = parseFloat(surfaceInput.value) || 0;

                if (selectedProduct && selectedType && surface > 0) {
                    const productInfo = products.find(p =>
                        p.product === selectedProduct && p.type === selectedType);

                    if (productInfo) {
                        const quantity = surface / parseFloat(productInfo.surface_per_unit);

                        quantityInput.value = quantity.toFixed(2);

                        unitPriceInput.value = parseFloat(productInfo.unit_price).toFixed(2);

                        const total = quantity * parseFloat(productInfo.unit_price);
                        totalInput.value = total.toFixed(2);
                    }
                }
            };

            typeSelect.addEventListener('change', calculateQuantityAndTotal);
            surfaceInput.addEventListener('input', calculateQuantityAndTotal);
        }

        addDiversRow.addEventListener("click", () => {
            let maxId = 1
            if(productTbody.querySelector("tr:last-child")) {
                maxId = parseInt(productTbody.querySelector("tr:last-child").getAttribute("data-id"))+1
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

        document.querySelector('#import').addEventListener('click', async () => {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.pdf';
            input.onchange = async (event) => {
                const file = event.target.files[0];
                if (!file) return;

                const arrayBuffer = await file.arrayBuffer();
                const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;

                const metadata = await pdf.getMetadata();
                const data = JSON.parse(metadata.info.Subject || '{}');

                document.getElementById('totalCost').value = data.totalCost || '';

                const imputname = document.getElementById('companyName')
                imputname.value = data.companyName

                const limitDate = document.getElementById('limit_date')
                limitDate.value = data.limitDate

                const productTbody = document.getElementById('product-tbody');
                productTbody.innerHTML = '';
                data.products.forEach(productData => {
                    let maxId = 1
                    if(productTbody.querySelector("tr:last-child")) {
                        maxId = parseInt(productTbody.querySelector("tr:last-child").getAttribute("data-id"))+1
                    }
                    const tr = document.createElement('tr');
                    tr.setAttribute("data-id", maxId)
                    tr.innerHTML = `
                <td>
                    <select class="select-option select-product" name="product-option">
                        <option disabled>Choisissez un produit</option>
                        <option value="Enduit">Enduit</option>
                        <option value="Peinture">Peinture</option>
                        <option value="ITE">ITE</option>
                        <option value="Pierre">Pierre</option>
                        <option value="Colle">Colle, joints</option>
                    </select>
                </td>
                <td>
                    <select class="select-option type-select" name="type-option">
                        <option disabled>Choisissez un type</option>
                    </select>
                </td>
                <td><input type="text" value="${productData.surface}" name="surface" class="input-field"></td>
                <td><input type="text" value="${productData.quantity}"  name="quantity" class="input-field"></td>
                <td><input type="text" value="${productData.price}" name="unitPrice" class="input-field"></td>
                <td><input type="text" value="${productData.totalprice}" class="input-field" name="total"></td>

                <td><button type="button" data-id="${maxId}" class="delete-line-button">Supprimer</button></td>
            `;
                    const selectElement = tr.querySelector('.select-option.select-product');
                    const selectTypeElement = tr.querySelector('.select-option.type-select');
                    updateTypeSelect(products, productData.product, selectTypeElement);
                    if (selectElement) {
                        Array.from(selectElement.options).some(option => {
                            if (option.value === productData.product) {
                                option.selected = true;
                                return true;
                            }
                            return false;
                        });
                    }
                    if (selectTypeElement) {
                        Array.from(selectTypeElement.options).some(option => {
                            if (option.value === productData.type) {
                                option.selected = true;
                                return true;
                            }
                            return false;
                        });
                    }

                    const deleteLineButton = tr.querySelector(".delete-line-button")
                    deleteLineButton.addEventListener('click', (e) => {
                        const trToRemove = e.target.closest("tr")
                        trToRemove.remove()
                    })

                    productTbody.appendChild(tr);
                    setupAutoCalculator(tr, products);
                });

                document.getElementById('prevision-input').value = data.team.prevision || '';
                document.getElementById('labor-cost').value = data.team.laborCost || '';

                let maxId = 1
                if(productTbody.querySelector("tr:last-child")) {
                    maxId = parseInt(productTbody.querySelector("tr:last-child").getAttribute("data-id"))+1
                }
                const diversTbody = document.getElementById('divers-tbody');
                diversTbody.innerHTML = '';
                for (const diversData of data.divers) {
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td><input type="text" value="${diversData.name}" class="divers-name input-field"></td>
                    <td><input type="text" value="${diversData.count}" class="divers-cost input-field"></td>
                    <td><button type="button" class="delete-line-button">Supprimer</button></td>
                `
                    const deleteLineButton = tr.querySelector(".delete-line-button")
                    deleteLineButton.addEventListener('click', (e) => {
                        const trToRemove = e.target.closest("tr")
                        trToRemove.remove()
                    })

                    diversTbody.appendChild(tr)
                }

            };
            input.click();
        });
        })
</script>