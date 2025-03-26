export const getProducts = async () => {
    const response = await fetch('index.php?component=previ&action=products',
        {headers : {'X-Requested-With': 'XMLHttpRequest'}});
    return await response.json();
}

export function generatePDF() {
    const doc = new jspdf.jsPDF();

    doc.setFontSize(18);
    doc.text('Prévisionnel', 105, 15, { align: 'center' });

    let metadata = "";

    const totalCost = document.getElementById('totalCost').value;
    doc.setFontSize(12);
    doc.text(`Coût Total (HT): ${totalCost}`, 20, 30);

    let yPos = 50;
    doc.text('Liste des produits:', 20, yPos);
    yPos += 10;

    const productRows = document.querySelectorAll('#product-tbody tr');
    if (productRows.length > 0) {
        productRows.forEach((row, index) => {
            try {
                const product = row.querySelector('.select-product') ? row.querySelector('.select-product').value : 'N/A';
                const type = row.querySelector('[name="type-option"], .type-select') ? row.querySelector('[name="type-option"], .type-select').value : 'N/A';
                const surface = row.querySelector('[name="surface"]') ? row.querySelector('[name="surface"]').value : 'N/A';

                const quantityInput = row.querySelector('[name="quantity"], .quantity');
                const priceInput = row.querySelector('[name="unitPrice"], .price');

                const totalCost = row.querySelector('[name="total"], .total').value;

                const quantity = quantityInput ? quantityInput.value : 'N/A';

                const price = priceInput ? priceInput.value : 'N/A';

                doc.text(`${index + 1}. Produit: ${product}, Type: ${type}, Surface: ${surface}, Quantité: ${quantity}, Prix Unitaire: ${price}, Total: ${totalCost}`, 20, yPos);
                yPos += 8;

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

    const previsionInput = document.getElementById('prevision-input').value;
    const laborCost = document.getElementById('labor-cost').value;

    if (previsionInput.trim() !== '' || laborCost.trim() !== '') {
        yPos += 15;
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

    const diversRows = document.querySelectorAll('#divers-tbody tr');
    if (diversRows.length > 0) {
        let hasDiversData = false;


        diversRows.forEach(row => {
            const nomInput = row.querySelector('input[name="divers-name"]') || row.querySelector('.divers-name') || row.cells[0].querySelector('input');
            const coutInput = row.querySelector('input[name="divers-count"]') || row.querySelector('.divers-count') || row.cells[1].querySelector('input');

            if ((nomInput && nomInput.value.trim() !== '') || (coutInput && coutInput.value.trim() !== '')) {
                hasDiversData = true;
            }
        });

        if (hasDiversData) {
            yPos += 15;
            if (yPos > 280) {
                doc.addPage();
                yPos = 20;
            }

            doc.text('Gestions des divers:', 20, yPos);
            yPos += 8;

            diversRows.forEach((row, index) => {
                const nomInput = row.querySelector('input.divers-name') || row.querySelector('.divers-name') || row.cells[0].querySelector('input');
                const coutInput = row.querySelector('input.divers-cost') || row.querySelector('.divers-cost') || row.cells[1].querySelector('input');

                if (nomInput || coutInput) {
                    const nom = nomInput && nomInput.value.trim() !== '' ? nomInput.value : 'N/A';
                    const cout = coutInput && coutInput.value.trim() !== '' ? coutInput.value : 'N/A';

                    doc.text(`${index + 1}. Nom: ${nom}, Coût: ${cout}`, 20, yPos);
                    yPos += 8;

                    if (yPos > 280) {
                        doc.addPage();
                        yPos = 20;
                    }
                }
            });
        }
    }

    doc.setProperties({
        title: "Prévisionnel",
        subject: JSON.stringify({
            totalCost,
            products: Array.from(productRows).map(row => ({
                product: row.querySelector('.select-product')?.value || 'N/A',
                type: row.querySelector('[name="type-option"], .type-select')?.value || 'N/A',
                surface: row.querySelector('[name="surface"]')?.value || 'N/A',
                quantity: row.querySelector('[name="quantity"], .quantity')?.value || 'N/A',
                price: row.querySelector('[name="unitPrice"], .price')?.value || 'N/A',
                totalprice: row.querySelector('[name="total"]')?.value || 'N/A'
            })),
            team: {
                prevision: previsionInput,
                laborCost
            },
            divers: Array.from(document.querySelectorAll('#divers-tbody tr')).map(row => ({
                name: row.querySelector('input.divers-name')?.value || 'N/A',
                count: row.querySelector('input.divers-cost')?.value || 'N/A'
            }))
        })
    });

    doc.save('previsionnel.pdf');
}

