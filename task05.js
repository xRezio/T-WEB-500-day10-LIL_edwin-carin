document.getElementById('searchButton').addEventListener('click', function () {
    const type = document.getElementById('typeInput').value.trim();
    const brand = document.getElementById('brandInput').value.trim();
    const price = document.getElementById('priceInput').value.trim();
    const number = document.getElementById('numberInput').value.trim();

    // Build the URL for the search based on the provided filters
    let searchUrl = 'task05.php?search=true';

    if (type !== '') {
        searchUrl += '&type=' + type;
    }

    if (brand !== '') {
        searchUrl += '&brand=' + brand;
    }

    if (price !== '') {
        searchUrl += '&price=' + price;
    }

    if (number !== '') {
        searchUrl += '&number=' + number;
    }

    // Send the AJAX request for the search
    fetch(searchUrl)
        .then(response => response.json())
        .then(data => {
            // Update the table with the search results
            updateProductTable(data.products);
        })
        .catch(error => {
            console.error('An error occurred:', error);
        });
});

function updateProductTable(products) {
    const table = document.getElementById('productTable');
    const tbody = table.getElementsByTagName('tbody')[0];

    // Clear existing table rows
    tbody.innerHTML = '';

    // Populate the table with retrieved products
    products.forEach(product => {
        const row = tbody.insertRow();
        const typeCell = row.insertCell(0);
        const brandCell = row.insertCell(1);
        const priceCell = row.insertCell(2);
        const numberCell = row.insertCell(3);

        typeCell.textContent = product.type;
        brandCell.textContent = product.brand;
        priceCell.textContent = product.price;
        numberCell.textContent = product.stock;
    });
}
