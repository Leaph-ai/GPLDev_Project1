export const getProducts = async () => {
    const response = await fetch('index.php?component=previ&action=products',
        {headers : {'X-Requested-With': 'XMLHttpRequest'}});
    return await response.json();
}

export function generatePDF() {
    const doc = new jspdf.jsPDF();

    const primaryColor = '#fff100';
    const secondaryColor = '#6c757d';
    const titleFontSize = 22;
    const headingFontSize = 16;
    const fontSize = 12;
    const margin = 20;
    const lineHeight = 8;
    const logoMaxWidth = 20;
    const logoMaxHeight = 20;


    const companyName = document.getElementById('companyName').value || 'Sans nom';

    const limitDate = document.getElementById('limit_date').value || 'Non spécifié';


    const titleX = doc.internal.pageSize.getWidth() / 2;
    const titleY = margin + 10;


    const logoUrl = 'assets/images/AR+FACADES.png';

    try {
        doc.addImage(logoUrl, 'PNG', margin, margin, logoMaxWidth, logoMaxHeight);

        const titleX = margin + logoMaxWidth + 10;
        const titleY = margin + logoMaxHeight / 2;
    } catch (error) {
        const titleX = doc.internal.pageSize.getWidth() / 2;
        const titleY = margin + 10;
    }



    doc.setFontSize(titleFontSize);
    doc.setTextColor(0, 0, 0);
    doc.text(`Prévisionnel ${companyName}`, titleX, titleY, { align: 'center', baseline: 'middle' });

    const separatorY = Math.max(margin + titleFontSize + 5);
    doc.setFillColor(primaryColor);
    doc.rect(margin, separatorY, doc.internal.pageSize.getWidth() - 2 * margin, 1, 'F');

    let currentY = separatorY + 15;

    doc.setFontSize(fontSize);
    doc.setTextColor('#333');
    doc.text(`Date de validité du devis: ${limitDate}`, margin, currentY);
    currentY += lineHeight + 5;

    doc.setFontSize(headingFontSize);
    doc.setTextColor(secondaryColor);
    doc.text('Récapitulatif Financier', margin, currentY);
    doc.setFillColor(secondaryColor);
    doc.rect(margin, currentY + 2, doc.getTextWidth('Récapitulatif Financier'), 0.5, 'F');
    currentY += lineHeight + 5;

    doc.setFontSize(fontSize);
    doc.setTextColor('#333');
    const totalCost = parseFloat(document.getElementById('totalCost').value) || 0;
    let totalCharges = 0;

    const productRows = document.querySelectorAll('#product-tbody tr');
    productRows.forEach(row => {
        const totalValue = parseFloat(row.querySelector('[name="total"]')?.value || 0);
        if (!isNaN(totalValue)) {
            totalCharges += totalValue;
        }
    });

    let laborCost = parseFloat(document.getElementById('labor-cost').value) || 0;
    totalCharges += laborCost;

    const diversRows = document.querySelectorAll('#divers-tbody tr');
    diversRows.forEach(row => {
        const costValue = parseFloat(row.querySelector('.divers-cost')?.value || 0);
        if (!isNaN(costValue)) {
            totalCharges += costValue;
        }
    });

    const benefit = totalCost - totalCharges;

    doc.text(`Coût Total (HT): ${totalCost.toFixed(2)}`, margin, currentY);
    currentY += lineHeight;
    doc.text(`Charges Totales: ${totalCharges.toFixed(2)}`, margin, currentY);
    currentY += lineHeight;
    doc.text(`Bénéfice: ${benefit.toFixed(2)}`, margin, currentY);
    currentY += lineHeight + 5;


    doc.setFontSize(headingFontSize);
    doc.setTextColor(secondaryColor);
    doc.text('Détail des Produits', margin, currentY);
    doc.setFillColor(secondaryColor);
    doc.rect(margin, currentY + 2, doc.getTextWidth('Détail des Produits'), 0.5, 'F');
    currentY += lineHeight + 2;

    doc.setFontSize(fontSize);
    doc.setTextColor('#333');

    if (productRows.length > 0) {
        productRows.forEach((row, index) => {
            try {
                const product = row.querySelector('.select-product') ? row.querySelector('.select-product').value : 'N/A';
                const type = row.querySelector('[name="type-option"], .type-select') ? row.querySelector('[name="type-option"], .type-select').value : 'N/A';
                const surface = row.querySelector('[name="surface"]') ? row.querySelector('[name="surface"]').value : 'N/A';
                const quantityInput = row.querySelector('[name="quantity"], .quantity');
                const priceInput = row.querySelector('[name="unitPrice"], .price');
                const totalCostProduct = row.querySelector('[name="total"], .total').value;
                const quantity = quantityInput ? quantityInput.value : 'N/A';
                const price = priceInput ? priceInput.value : 'N/A';

                doc.text(`${index + 1}. Produit: ${product}, Type: ${type}, Surface: ${surface}m², Quantité: ${quantity}, Prix Unitaire: ${price}€, Total: ${totalCostProduct}€`, margin, currentY);
                currentY += lineHeight*2;

                if (currentY > doc.internal.pageSize.getHeight() - margin) {
                    doc.addPage();
                    currentY = margin;
                }
            } catch (error) {
                console.error("Erreur lors de l'extraction des données de la ligne:", error);
                doc.text(`${index + 1}. Erreur lors de l'extraction des données`, margin, currentY);
                currentY += lineHeight;
            }
        });
    } else {
        doc.text('Aucun produit ajouté', margin, currentY);
        currentY += lineHeight;
    }
    currentY += 5;

    const previsionInput = document.getElementById('prevision-input').value;
    laborCost = document.getElementById('labor-cost').value;

    if (previsionInput.trim() !== '' || laborCost.trim() !== '') {
        doc.setFontSize(headingFontSize);
        doc.setTextColor(secondaryColor);
        doc.text('Gestion des Équipes', margin, currentY);
        doc.setFillColor(secondaryColor);
        doc.rect(margin, currentY + 2, doc.getTextWidth('Gestion des Équipes'), 0.5, 'F');
        currentY += lineHeight + 2;

        doc.setFontSize(fontSize);
        doc.setTextColor('#333');
        if (previsionInput.trim() !== '') {
            doc.text(`Prévision: ${previsionInput}`, margin, currentY);
            currentY += lineHeight;
        }
        if (laborCost.trim() !== '') {
            doc.text(`Coût de main d'œuvre: ${laborCost}`, margin, currentY);
            currentY += lineHeight;
        }
        currentY += 5;
    }

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
            doc.setFontSize(headingFontSize);
            doc.setTextColor(secondaryColor);
            doc.text('Gestion des Divers', margin, currentY);
            doc.setFillColor(secondaryColor);
            doc.rect(margin, currentY + 2, doc.getTextWidth('Gestion des Divers'), 0.5, 'F');
            currentY += lineHeight + 2;

            doc.setFontSize(fontSize);
            doc.setTextColor('#333');
            diversRows.forEach((row, index) => {
                const nomInput = row.querySelector('input.divers-name') || row.querySelector('.divers-name') || row.cells[0].querySelector('input');
                const coutInput = row.querySelector('input.divers-cost') || row.querySelector('.divers-cost') || row.cells[1].querySelector('input');

                if (nomInput || coutInput) {
                    const nom = nomInput && nomInput.value.trim() !== '' ? nomInput.value : 'N/A';
                    const cout = coutInput && coutInput.value.trim() !== '' ? coutInput.value : 'N/A';

                    doc.text(`${index + 1}. Nom: ${nom}, Coût: ${cout}`, margin, currentY);
                    currentY += lineHeight;

                    if (currentY > doc.internal.pageSize.getHeight() - margin) {
                        doc.addPage();
                        currentY = margin;
                    }
                }
            });
        }
    }

    doc.setFillColor(primaryColor);
    doc.rect(margin, doc.internal.pageSize.getHeight() - margin - 5, doc.internal.pageSize.getWidth() - 2 * margin, 1, 'F');

    doc.setFontSize(fontSize - 2);
    doc.setTextColor(secondaryColor);
    const generationDate = new Date().toLocaleDateString('fr-FR');
    doc.text(`Généré le ${generationDate}`, doc.internal.pageSize.getWidth() - margin, doc.internal.pageSize.getHeight() - margin + 2, { align: 'right' });


    doc.setProperties({
        title: "Prévisionnel",
        subject: JSON.stringify({
            totalCost,
            totalCharges,
            benefit,
            companyName,
            limitDate,
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

    doc.save(`Previsionnel_${companyName}.pdf`);

}