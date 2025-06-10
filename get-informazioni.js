
function loadUserInformation() {
    fetch("../api/get_user_information.php")
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            populateForm(data.data);
        }

    })
    .catch(error => {
        console.error("Errore nel caricamento dati:", error);

    });
}

function populateForm(userData) {
    if (userData.nome) document.getElementById('nome').value = userData.nome;
    if (userData.cognome) document.getElementById('cognome').value = userData.cognome;
    if (userData.data_nascita) document.getElementById('data_nascita').value = userData.data_nascita;
    if (userData.telefono) document.getElementById('telefono').value = userData.telefono;
    if (userData.indirizzo) document.getElementById('indirizzo').value = userData.indirizzo;
    if (userData.citta) document.getElementById('citta').value = userData.citta;
    if (userData.CAP) document.getElementById('cap').value = userData.CAP;
    if (userData.provincia) document.getElementById('provincia').value = userData.provincia;
    if (userData.paese) document.getElementById('paese').value = userData.paese;

    const submitBtn = document.getElementById('submit-btn');
    submitBtn.innerHTML = '✏️ Aggiorna Informazioni';
}


function saveUserInformation() {
    const form = document.getElementById('user-info-form');
    const formData = new FormData(form);
    
    // Mostra loading
    showLoading(true);
    
    fetch("../api/informazioni.php", {
        method: 'POST',
        body: formData
    })
    .then(handleResponse)
    .then(handleSuccess)
    .catch(handleError);
}
function handleResponse(response) {
    if (!response.ok) {
        return response.json().then(err => Promise.reject(err));
    }
    return response.json();
}


function handleSuccess(json) {
    console.log("Successo:", json);
    showLoading(false);
    showMessage(json.message, 'success');
    
    setTimeout(() => {
        window.location.href = 'index.php';
    }, 2000);
}


function handleError(error) {
    console.error("Errore:", error);
    showLoading(false);
    
    let message = "Errore durante il salvataggio";
    if (error && error.message) {
        message = error.message;
    }
    
    showMessage(message, 'error');
}

function showLoading(show) {
    const submitBtn = document.getElementById('submit-btn');
    const originalText = submitBtn.getAttribute('data-original-text') || submitBtn.innerHTML;
    
    if (show) {
        submitBtn.setAttribute('data-original-text', originalText);
        submitBtn.innerHTML = '⏳ Salvando...';
        submitBtn.disabled = true;
    } else {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

function showMessage(message, type) {

    const existingMessages = document.querySelectorAll('.message');
    existingMessages.forEach(msg => msg.remove());
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message');
    messageDiv.classList.add(type === 'success' ? 'success-message' : 'error-message');
    messageDiv.innerHTML = message;
    const formContainer = document.querySelector('.form-container');
    const form = document.getElementById('user-info-form');
    formContainer.insertBefore(messageDiv, form);

    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
}


document.addEventListener('DOMContentLoaded', function() {
    loadUserInformation();

    const form = document.getElementById('user-info-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            saveUserInformation();
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const capInput = document.getElementById('cap');
    
    if (capInput) {
        capInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        
            if (this.value.length > 5) {
                this.value = this.value.substring(0, 5);
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const provinciaInput = document.getElementById('provincia');
    
    if (provinciaInput) {
        provinciaInput.addEventListener('input', function(e) {
            this.value = this.value.toUpperCase().substring(0, 2);
        });
    }
});