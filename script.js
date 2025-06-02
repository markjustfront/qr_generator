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
        // Check if response is JSON
        const contentType = response.headers.get('Content-Type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Response is not JSON');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            qrResult.innerHTML = `<img src="${data.image}" alt="QR Code">`;
        } else {
            qrResult.innerHTML = `<p>Error: ${data.error}</p>`;
        }
    })
    .catch(error => {
        qrResult.innerHTML = '<p>Error generating QR code.</p>';
        console.error('Error:', error);
        // Optionally log the response for debugging
        fetch('generate.php', { method: 'POST', body: `text=${encodeURIComponent(qrText)}` })
            .then(res => res.text())
            .then(text => console.log('Raw response:', text));
    });
}