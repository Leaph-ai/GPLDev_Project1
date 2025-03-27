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

    const pageHeight = doc.internal.pageSize.getHeight();
    const pageWidth = doc.internal.pageSize.getWidth();
    const maxContentHeight = pageHeight - margin * 2;

    const addFooter = (pageNum, totalPages) => {
        doc.setFillColor(primaryColor);
        doc.rect(margin, pageHeight - margin - 5, pageWidth - 2 * margin, 1, 'F');

        doc.setFontSize(fontSize - 2);
        doc.setTextColor(secondaryColor);
        doc.text(`Page ${pageNum} / ${totalPages}`, margin, pageHeight - margin + 2);

        const generationDate = new Date().toLocaleDateString('fr-FR');
        doc.text(`Généré le ${generationDate}`, pageWidth - margin, pageHeight - margin + 2, { align: 'right' });
    };

    const checkForNewPage = (heightNeeded) => {
        if (currentY + heightNeeded > pageHeight - margin - 10) {
            doc.addPage();
            currentY = margin + 10;

            doc.setFontSize(fontSize);
            doc.setTextColor(secondaryColor);
            const companyName = document.getElementById('companyName').value || 'Sans nom';
            doc.text(`Prévisionnel ${companyName} (suite)`, doc.internal.pageSize.getWidth() / 2, margin, { align: 'center' });
            doc.setFillColor(secondaryColor);
            doc.rect(margin, margin + 5, doc.internal.pageSize.getWidth() - 2 * margin, 0.5, 'F');
            currentY = margin + 15;

            return true;
        }
        return false;
    };

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

    checkForNewPage(headingFontSize + lineHeight * 5);

    doc.setFontSize(headingFontSize);
    doc.setTextColor(secondaryColor);
    doc.text('Récapitulatif Financier :', margin, currentY);
    doc.setFillColor(secondaryColor);
    doc.rect(margin, currentY + 2, doc.getTextWidth('Récapitulatif Financier :'), 0.5, 'F');
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

    doc.text(`Coût Total (HT): ${totalCost.toFixed(2)}€`, margin, currentY);
    currentY += lineHeight;
    doc.text(`Charges Totales: ${totalCharges.toFixed(2)}€`, margin, currentY);
    currentY += lineHeight;
    doc.text(`Bénéfice: ${benefit.toFixed(2)}€`, margin, currentY);
    currentY += lineHeight + 5;

    checkForNewPage(headingFontSize + lineHeight * 2);

    doc.setFontSize(headingFontSize);
    doc.setTextColor(secondaryColor);
    doc.text('Détail des Produits :', margin, currentY);
    doc.setFillColor(secondaryColor);
    doc.rect(margin, currentY + 2, doc.getTextWidth('Détail des Produits :'), 0.5, 'F');
    currentY += lineHeight + 2;

    doc.setFontSize(fontSize);
    doc.setTextColor('#333');

    if (productRows.length > 0) {
        productRows.forEach((row, index) => {
            if (checkForNewPage(lineHeight * 2)) {
            }

            try {
                const product = row.querySelector('.select-product') ? row.querySelector('.select-product').value : 'N/A';
                const type = row.querySelector('[name="type-option"], .type-select') ? row.querySelector('[name="type-option"], .type-select').value : 'N/A';
                const surface = row.querySelector('[name="surface"]') ? row.querySelector('[name="surface"]').value : 'N/A';
                const quantity = row.querySelector('[name="quantity"]') ? row.querySelector('[name="quantity"]').value : 'N/A';
                const unitPrice = row.querySelector('[name="unitPrice"]') ? row.querySelector('[name="unitPrice"]').value : 'N/A';
                const total = row.querySelector('[name="total"]') ? row.querySelector('[name="total"]').value : 'N/A';

                doc.text(`${index + 1}. ${product} (${type}) - Surface: ${surface}m², Qté: ${quantity}, Prix: ${unitPrice}€/m², Total: ${total}€`, margin, currentY);
                currentY += lineHeight;
            } catch (error) {
                console.error('Erreur lors de l\'ajout d\'un produit au PDF:', error);
                doc.text(`${index + 1}. Erreur dans les données du produit`, margin, currentY);
                currentY += lineHeight;
            }
        });
    } else {
        doc.text('Aucun produit ajouté.', margin, currentY);
        currentY += lineHeight;
    }

    currentY += lineHeight;

    checkForNewPage(headingFontSize + lineHeight * 3);

    doc.setFontSize(headingFontSize);
    doc.setTextColor(secondaryColor);
    doc.text('Main d\'Œuvre :', margin, currentY);
    doc.setFillColor(secondaryColor);
    doc.rect(margin, currentY + 2, doc.getTextWidth('Main d\'Œuvre :'), 0.5, 'F');
    currentY += lineHeight + 2;

    doc.setFontSize(fontSize);
    doc.setTextColor('#333');

    const previsionInput = document.getElementById('prevision-input').value || 'Non spécifié';
    doc.text(`Nombre d'équipes: ${previsionInput}`, margin, currentY);
    currentY += lineHeight;
    doc.text(`Coût de la main d'œuvre: ${laborCost.toFixed(2)}€`, margin, currentY);
    currentY += lineHeight + 5;

    if (diversRows.length > 0) {
        checkForNewPage(headingFontSize + lineHeight * 2);

        doc.setFontSize(headingFontSize);
        doc.setTextColor(secondaryColor);
        doc.text('Détail des Divers :', margin, currentY);
        doc.setFillColor(secondaryColor);
        doc.rect(margin, currentY + 2, doc.getTextWidth('Détail des Divers :'), 0.5, 'F');
        currentY += lineHeight + 2;

        doc.setFontSize(fontSize);
        doc.setTextColor('#333');

        diversRows.forEach((row, index) => {
            if (checkForNewPage(lineHeight * 2)) {
            }

            try {
                const name = row.querySelector('.divers-name') ? row.querySelector('.divers-name').value : 'N/A';
                const cost = row.querySelector('.divers-cost') ? row.querySelector('.divers-cost').value : 'N/A';

                doc.text(`${index + 1}. ${name}: ${cost}€`, margin, currentY);
                currentY += lineHeight;
            } catch (error) {
                console.error('Erreur lors de l\'ajout d\'un élément divers au PDF:', error);
                doc.text(`${index + 1}. Erreur dans les données de l'élément divers`, margin, currentY);
                currentY += lineHeight;
            }
        });
    }

    const totalPages = doc.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
        doc.setPage(i);
        addFooter(i, totalPages);
    }




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

    doc.save(`Prévisionnel_${companyName}_${new Date().toLocaleDateString().replace(/\//g, '-')}.pdf`);

}