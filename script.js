function generateQR() {
    const qrText = document.getElementById('qrText').value;
    const qrResult = document.getElementById('qrResult');

    if (qrText.trim() === '') {
        qrResult.innerHTML = '<p>Please enter some text or a URL.</p>';
        return;
    }

    qrResult.innerHTML = '<p>Generating...</p>';

    fetch('generate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `text=${encodeURIComponent(qrText)}`
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text(); // Get raw response
    })
    .then(text => {
        console.log('Raw response:', text); // Log raw response
        try {
            const data = JSON.parse(text); // Try parsing as JSON
            if (data.success) {
                qrResult.innerHTML = `<img src="${data.image}" alt="QR Code">`;
            } else {
                qrResult.innerHTML = `<p>Error: ${data.error}</p>`;
            }
        } catch (e) {
            qrResult.innerHTML = `<p>JSON Parse Error: ${text}</p>`;
        }
    })
    .catch(error => {
        qrResult.innerHTML = '<p>Error generating QR code.</p>';
        console.error('Error:', error);
    });
}