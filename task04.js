function displayValidationMessage(id, message, isError) {
    const element = document.getElementById(id);
    element.textContent = message;
    element.style.color = isError ? 'red' : 'green';
}

function validateInput(event) {
    const input = event.target;
    const value = input.value.trim();
    const name = input.name;

 // regex
    const typeRegex = /^[A-Za-z-]{3,10}$/;
    const brandRegex = /^[A-Za-z0-9&-]{2,20}$/;

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
    }
}

document.getElementById('typeInput').addEventListener('input', validateInput);
document.getElementById('brandInput').addEventListener('input', validateInput);

document.getElementById('addBrandForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    // GET pour serv qui use fetch
    fetch('task04.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('resultMessage').textContent = data.message;
    })
    .catch(error => {
        console.error('An error occurred:', error);
    });
});
