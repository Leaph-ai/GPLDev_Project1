export const getProducts = async () => {
    const response = await fetch('index.php?component=previ&action=products',
        {headers : {'X-Requested-With': 'XMLHttpRequest'}});
    return await response.json();
}

export function generatePDF() {
    // Utilisation de la version CDN de jsPDF
    const doc = new jspdf.jsPDF();

    // Ajout du titre
    doc.setFontSize(18);
    doc.text('Prévisionnel', 105, 15, { align: 'center' });

    // Récupération des données
    const totalCost = document.getElementById('totalCost').value;
    doc.setFontSize(12);
    doc.text(`Coût Total (HT): ${totalCost}`, 20, 30);

    // Tableau des produits
    let yPos = 40;
    doc.text('Liste des produits:', 20, yPos);
    yPos += 10;

    const productRows = document.querySelectorAll('#product-tbody tr');
    if (productRows.length > 0) {
        productRows.forEach((row, index) => {
            try {
                const product = row.querySelector('.select-product') ? row.querySelector('.select-product').value : 'N/A';
                const type = row.querySelector('[name="type-option"], .type-select') ? row.querySelector('[name="type-option"], .type-select').value : 'N/A';
                const surface = row.querySelector('[name="surface"]') ? row.querySelector('[name="surface"]').value : 'N/A';

                // Chercher les entrées par leur nom ou classe au lieu de position
                const quantityInput = row.querySelector('[name="quantity"], .quantity');
                const priceInput = row.querySelector('[name="price"], .price');

                const quantity = quantityInput ? quantityInput.value : 'N/A';

                //prix a calculer ?? ou retirer
                const price = priceInput ? priceInput.value : 'N/A';

                doc.text(`${index + 1}. Produit: ${product}, Type: ${type}, Surface: ${surface}, Quantité: ${quantity}, Prix: ${price}`, 20, yPos);
                yPos += 8;

                // Éviter le débordement de page
                if (yPos > 280) {
                    doc.addPage();
                    yPos = 20;
                }
            } catch (error) {
                console.error("Erreur lors de l'extraction des données de la ligne:", error);
                doc.text(`${index + 1}. Erreur lors de l'extraction des données`, 20, yPos);
                yPos += 8;
            }
        });
    } else {
        doc.text('Aucun produit ajouté', 20, yPos);
    }

    // Vérifier si des données ont été entrées pour les équipes
    const previsionInput = document.getElementById('prevision-input').value;
    const laborCost = document.getElementById('labor-cost').value;

    // N'ajouter la section équipes que si au moins un des champs est rempli
    if (previsionInput.trim() !== '' || laborCost.trim() !== '') {
        yPos += 15;
        // Éviter le débordement de page
        if (yPos > 280) {
            doc.addPage();
            yPos = 20;
        }
        doc.text('Gestion des équipes:', 20, yPos);
        yPos += 8;
        if (previsionInput.trim() !== '') {
            doc.text(`Prévision: ${previsionInput}`, 20, yPos);
            yPos += 8;
        }
        if (laborCost.trim() !== '') {
            doc.text(`Coût de main d'œuvre: ${laborCost}`, 20, yPos);
            yPos += 8;
        }
    }

    // Vérifier si des données ont été entrées pour les divers
    const diversRows = document.querySelectorAll('#divers-tbody tr');
    if (diversRows.length > 0) {
        // Vérifier si au moins une ligne a des données
        let hasDiversData = false;


        diversRows.forEach(row => {
            // Utiliser plusieurs stratégies pour sélectionner les éléments
            const nomInput = row.querySelector('input[name="nom-divers"]') || row.querySelector('.nom-divers') || row.cells[0].querySelector('input');
            const coutInput = row.querySelector('input[name="cout-divers"]') || row.querySelector('.cout-divers') || row.cells[1].querySelector('input');

            // Debugging - vérifier si les inputs sont trouvés
            console.log("Input nom trouvé:", !!nomInput);
            console.log("Input coût trouvé:", !!coutInput);

            if ((nomInput && nomInput.value.trim() !== '') || (coutInput && coutInput.value.trim() !== '')) {
                hasDiversData = true;
            }
        });

        if (hasDiversData) {
            yPos += 15;
            // evite le débordement de page
            if (yPos > 280) {
                doc.addPage();
                yPos = 20;
            }

            // titre de la section divers
            doc.text('Gestions des divers:', 20, yPos);
            yPos += 8;

            // Ajouter chaque entrée divers
            diversRows.forEach((row, index) => {
                const nomInput = row.querySelector('input[name="nom-divers"]') || row.querySelector('.nom-divers') || row.cells[0].querySelector('input');
                const coutInput = row.querySelector('input[name="cout-divers"]') || row.querySelector('.cout-divers') || row.cells[1].querySelector('input');

                if (nomInput || coutInput) {
                    const nom = nomInput && nomInput.value.trim() !== '' ? nomInput.value : 'N/A';
                    const cout = coutInput && coutInput.value.trim() !== '' ? coutInput.value : 'N/A';

                    doc.text(`${index + 1}. Nom: ${nom}, Coût: ${cout}`, 20, yPos);
                    yPos += 8;

                    // Éviter le débordement de page
                    if (yPos > 280) {
                        doc.addPage();
                        yPos = 20;
                    }
                }
            });
        }
    }


    // Sauvegarder le PDF
    doc.save('previsionnel.pdf');
}

