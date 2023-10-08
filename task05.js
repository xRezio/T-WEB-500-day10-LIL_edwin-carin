function displayValidationMessage(id, message, isError) {
    const element = document.getElementById(id);
    element.textContent = message;
    element.style.color = isError ? 'red' : 'green';
}

function validateInput(event) {
    const input = event.target;
    const value = input.value.trim();
    const name = input.name;

    const typeRegex = /^[A-Za-z-]{3,10}$/;
    const brandRegex = /^[A-Za-z0-9&-]{2,20}$/;
    const priceRegex = /^[><]?[0-9]{2,5}$/;
    const numberRegex = /^[1-9][0-9]*$/;

    if (name === 'type') {
        if (!typeRegex.test(value)) {
            displayValidationMessage('typeValidation', 'Invalid type.', true);
        } else {
            displayValidationMessage('typeValidation', 'Type is valid.', false);
        }
    } else if (name === 'brand') {
        if (!brandRegex.test(value)) {
            displayValidationMessage('brandValidation', 'Invalid brand.', true);
        } else {
            displayValidationMessage('brandValidation', 'Brand is valid.', false);
        }
    } else if (name === 'price') {
        if (!priceRegex.test(value)) {
            displayValidationMessage('priceValidation', 'Invalid price.', true);
        } else {
            displayValidationMessage('priceValidation', 'Price is valid.', false);
        }
    } else if (name === 'number') {
        if (!numberRegex.test(value)) {
            displayValidationMessage('numberValidation', 'Invalid number.', true);
        } else {
            displayValidationMessage('numberValidation', 'Number is valid.', false);
        }
    }
}

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
        const stockCell = row.insertCell(4);

        typeCell.textContent = product.type;
        brandCell.textContent = product.brand;
        priceCell.textContent = product.price;
        numberCell.textContent = product.number;
        stockCell.textContent = product.stock;
    });
}

document.getElementById('typeInput').addEventListener('input', validateInput);
document.getElementById('brandInput').addEventListener('input', validateInput);
document.getElementById('priceInput').addEventListener('input', validateInput);
document.getElementById('numberInput').addEventListener('input', validateInput);

document.getElementById('addProductForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('task05.php?type=' + formData.get('type') + '&brand=' + formData.get('brand') + '&price=' + formData.get('price') + '&number=' + formData.get('number'), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.message ==='Product added successfully.'){
            updateProductTable(data.products);
        }
        document.getElementById('resultMessage').textContent = data.message;
    })
    .catch(error => {
        console.error('An error occurred:', error);
    });
});

