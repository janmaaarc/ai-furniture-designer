document.addEventListener('DOMContentLoaded', () => {
    const furnitureForm = document.getElementById('furniture-form');
    const closeResultBtn = document.getElementById('close-result-btn');
    const generateBtn = document.getElementById('generate-btn');

    const ui = {
        mainCard: document.getElementById('main-card'),
        loader: document.getElementById('loader'),
        resultContainer: document.getElementById('result-container'),
        result: document.getElementById('result')
    };

    const showView = (view) => {
        ui.loader.style.display = 'none';
        ui.resultContainer.style.display = 'none';

        if (view === 'form') {
            ui.mainCard.style.display = 'block';
            ui.mainCard.classList.remove('loading-active');
            ui.result.innerHTML = '';
        } else if (view === 'loader') {
            ui.mainCard.style.display = 'block';
            ui.mainCard.classList.add('loading-active');
            ui.loader.style.display = 'flex';
        } else if (view === 'result') {
            ui.mainCard.style.display = 'none';
            ui.resultContainer.style.display = 'block';
        }
    };

    const setButtonLoadingState = (isLoading) => {
        if (isLoading) {
            generateBtn.disabled = true;
            generateBtn.classList.add('loading');
        } else {
            generateBtn.disabled = false;
            generateBtn.classList.remove('loading');
        }
    };

    const handleGenerationRequest = async () => {
        if (!furnitureForm.checkValidity()) {
            furnitureForm.reportValidity();
            return;
        }
        
        const webhookUrl = window.N8N_WEBHOOK_URL;
        if (!webhookUrl) {
            console.error('N8N_WEBHOOK_URL is not defined. Please set it in your environment.');
            ui.result.innerHTML = `<p style="text-align:center; color:red; padding: 40px;">Configuration error: The webhook URL is not set. Please contact support.</p>`;
            showView('result');
            return;
        }

        const formData = new FormData(furnitureForm);
        const data = Object.fromEntries(formData.entries());

        setButtonLoadingState(true);
        showView('loader');

        try {
            const response = await fetch(webhookUrl, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    // Change content type to bypass CORS preflight issues. n8n can still parse this.
                    'Content-Type': 'text/plain'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const htmlResponse = await response.text();
            
            if (htmlResponse && !htmlResponse.includes('undefined')) {
                ui.result.innerHTML = htmlResponse;
                showView('result');
            } else {
                throw new Error('Received an empty or invalid response from the server.');
            }

        } catch (error) {
            console.error('Error sending data to n8n:', error);
            const userMessage = `An error occurred while generating the page. Please try again later.`;
            ui.result.innerHTML = `<p style="text-align:center; color:red; padding: 40px;">${userMessage}</p>`;
            setButtonLoadingState(false);
            showView('result');
        }
    };

    const resetForm = () => {
        furnitureForm.reset();
        setButtonLoadingState(false);
        showView('form');
    };

    generateBtn.addEventListener('click', handleGenerationRequest);
    if (closeResultBtn) {
        closeResultBtn.addEventListener('click', resetForm);
    }
    showView('form');
});