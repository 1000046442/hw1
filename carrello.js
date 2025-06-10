class Carrello {
    constructor() {
        this.items = this.caricaCarrello();
        this.inizializza();
    }
    
    inizializza() {
        this.aggiornaUI();
        this.impostaEventListeners();
    }
    
    impostaEventListeners() {
  
        const toggle = document.getElementById('carrello-toggle');
        const dropdown = document.getElementById('carrello-dropdown');
        const close = document.getElementById('carrello-close');
        
        if (toggle) {
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropdown.classList.toggle('show');
            });
        }
        
        if (close) {
            close.addEventListener('click', (e) => {
                e.preventDefault();
                dropdown.classList.remove('show');
            });
        }
        
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.carrello-header-item')) {
                dropdown.classList.remove('show');
            }
        });
        

        const svuotaBtn = document.getElementById('svuota-carrello');
        if (svuotaBtn) {
            svuotaBtn.addEventListener('click', () => {
                if (confirm('Sei sicuro di voler svuotare il carrello?')) {
                    this.svuota();
                }
            });
        }
        
    }
    
    aggiungi(prodotto) {
        const esistente = this.items.find(item => item.id === prodotto.id);
        
        if (esistente) {
            esistente.quantita++;
        } else {
            this.items.push({
                id: prodotto.id,
                nome: prodotto.nome,
                prezzo: parseFloat(prodotto.prezzo),
                immagine: prodotto.immagine,
                quantita: 1
            });
        }
        
        this.salvaCarrello();
        this.aggiornaUI();
        this.mostraNotifica(`${prodotto.nome} aggiunto al carrello!`);
    }
    
    rimuovi(prodottoId) {
        this.items = this.items.filter(item => item.id !== prodottoId);
        this.salvaCarrello();
        this.aggiornaUI();
    }
    
    aggiornaQuantita(prodottoId, nuovaQuantita) {
        const item = this.items.find(item => item.id === prodottoId);
        
        if (item) {
            if (nuovaQuantita <= 0) {
                this.rimuovi(prodottoId);
            } else {
                item.quantita = nuovaQuantita;
                this.salvaCarrello();
                this.aggiornaUI();
            }
        }
    }
    
    svuota() {
        this.items = [];
        this.salvaCarrello();
        this.aggiornaUI();
    }
    
    getTotale() {
        return this.items.reduce((totale, item) => {
            return totale + (item.prezzo * item.quantita);
        }, 0);
    }
    
    getQuantitaTotale() {
        return this.items.reduce((totale, item) => totale + item.quantita, 0);
    }
    
    aggiornaUI() {
        this.aggiornaContatore();
        this.aggiornaLista();
        this.aggiornaTotale();
    }
    
    aggiornaContatore() {
        const contatore = document.getElementById('carrello-count');
        const quantita = this.getQuantitaTotale();
        
        if (contatore) {
            contatore.textContent = quantita;
            if (quantita > 0) {
                contatore.classList.remove('hidden');
            } else {
                contatore.classList.add('hidden');
            }
        }
    }
    
    aggiornaLista() {
        const container = document.getElementById('carrello-items');
        if (!container) return;
        
        if (this.items.length === 0) {
            container.innerHTML = '<p class="carrello-vuoto">Il carrello è vuoto</p>';
            return;
        }
        
        container.innerHTML = this.items.map(item => `
            <div class="carrello-item" data-id="${item.id}">
                <div class="item-immagine">
                    <img src="${item.immagine || 'img/placeholder.jpg'}" alt="${item.nome}" onerror="this.src='img/placeholder.jpg'">
                </div>
                <div class="item-info">
                    <div class="item-nome">${item.nome}</div>
                    <div class="item-prezzo">€${item.prezzo.toFixed(2)}</div>
                </div>
                <div class="item-controlli">
                    <button class="btn-quantita minus" onclick="carrello.aggiornaQuantita(${item.id}, ${item.quantita - 1})">-</button>
                    <span class="item-quantita">${item.quantita}</span>
                    <button class="btn-quantita plus" onclick="carrello.aggiornaQuantita(${item.id}, ${item.quantita + 1})">+</button>
                    <button class="btn-rimuovi" onclick="carrello.rimuovi(${item.id})">×</button>
                </div>
            </div>
        `).join('');
    }
    
    aggiornaTotale() {
        const totaleElement = document.getElementById('carrello-totale');
        const checkoutBtn = document.getElementById('vai-checkout');
        
        if (totaleElement) {
            totaleElement.textContent = this.getTotale().toFixed(2);
        }
        
        if (checkoutBtn) {
            checkoutBtn.disabled = this.items.length === 0;
        }
    }
    
    mostraNotifica(messaggio) {
        const notifica = document.createElement('div');
        notifica.className = 'carrello-notifica';
        notifica.textContent = messaggio;
        notifica.style.animation = 'slideInRight 0.3s ease';
        
        document.body.appendChild(notifica);
        
        setTimeout(() => {
            notifica.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (document.body.contains(notifica)) {
                    document.body.removeChild(notifica);
                }
            }, 300);
        }, 2000);
    }
    
    salvaCarrello() {
        localStorage.setItem('carrello', JSON.stringify(this.items));
    }
    
    caricaCarrello() {
        const saved = localStorage.getItem('carrello');
        return saved ? JSON.parse(saved) : [];
    }
}

let carrello;
document.addEventListener('DOMContentLoaded', function() {
    carrello = new Carrello();
});


document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('prodotti-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('prodotto-aggiungi')) {
            const prodottoId = e.target.getAttribute('data-id');
            if (prodottoId) {
                aggiungiAlCarrelloDelegate(prodottoId, e.target);
            }
        }
    });
});

function aggiungiAlCarrelloDelegate(prodottoId, button) {

    const prodottoCard = button.closest('.prodotto-card');
    
    if (!prodottoCard) {
        console.error('errore card non trovata');
        return;
    }
    
    const nome = prodottoCard.querySelector('.prodotto-nome').textContent.trim();
    const prezzo = prodottoCard.querySelector('.prodotto-prezzo').textContent.replace('€', '').trim();
    const immagineEl = prodottoCard.querySelector('img');
    const immagine = immagineEl ? immagineEl.src : '../img/placeholder.jpg';
    
    const prodotto = {
        id: parseInt(prodottoId),
        nome: nome,
        prezzo: parseFloat(prezzo),
        immagine: immagine
    };
    
    if (typeof carrello !== 'undefined') {
        carrello.aggiungi(prodotto);
        

        const originalState = {
            text: button.textContent,
            className: button.className,
            style: button.getAttribute('style') || ''
        };
        
        button.textContent = 'Aggiunto! ✓';
        button.className = originalState.className + ' successo';
        button.disabled = true;
        button.style.background = '#27ae60';
        
        setTimeout(() => {
            button.textContent = originalState.text;
            button.className = originalState.className;
            button.disabled = false;
            button.setAttribute('style', originalState.style);
            

        }, 1000);
    }
}

window.aggiungiAlCarrello = function(prodottoId) {
    const button = document.querySelector(`[data-id="${prodottoId}"]`);
    if (button) {
        aggiungiAlCarrelloDelegate(prodottoId, button);
    }
};



window.procediOrdine = function() {
    
    // Cerca carrello
    let carrelloData = null;
    
    if (window.carrello && window.carrello.items && window.carrello.items.length > 0) {
        carrelloData = window.carrello;
    }
    else if (localStorage.getItem('carrello')) {
        try {
            const stored = JSON.parse(localStorage.getItem('carrello'));
            if (stored && stored.length > 0) {
                carrelloData = { 
                    items: stored, 
                    getTotale: () => stored.reduce((tot, item) => tot + (item.prezzo * item.quantita), 0) 
                };
            }
        } catch(e) {}
    }
    else if (sessionStorage.getItem('carrello')) {
        try {
            const stored = JSON.parse(sessionStorage.getItem('carrello'));
            if (stored && stored.length > 0) {
                carrelloData = { 
                    items: stored, 
                    getTotale: () => stored.reduce((tot, item) => tot + (item.prezzo * item.quantita), 0) 
                };
            }
        } catch(e) {}
    }
    else {
        const carrelloItems = document.querySelectorAll('.carrello-item, .item-carrello, .cart-item');
        if (carrelloItems.length > 0) {
            carrelloData = {
                items: Array.from(carrelloItems).map(item => {
                    const nome = item.querySelector('.nome, .prodotto-nome, .item-name')?.textContent || 'Prodotto';
                    const prezzoEl = item.querySelector('.prezzo, .price, .item-price');
                    const prezzo = parseFloat(prezzoEl?.textContent.replace('€', '').replace(',', '.') || '0');
                    const quantitaEl = item.querySelector('.quantita, .qty, .quantity');
                    const quantita = parseInt(quantitaEl?.textContent || quantitaEl?.value || '1');
                    
                    return { nome, prezzo, quantita, id: Date.now() + Math.random() };
                }),
                getTotale: function() {
                    return this.items.reduce((tot, item) => tot + (item.prezzo * item.quantita), 0);
                }
            };
        }
    }
    
    if (!carrelloData || !carrelloData.items || carrelloData.items.length === 0) {
        alert(' Il carrello è vuoto!, aggiungi dei prodotti prima di procedere all\'ordine.');
        return;
    }
    
    const totale = carrelloData.getTotale();
    
    const dettagli = carrelloData.items.map(item => `• ${item.nome} - €${item.prezzo} x ${item.quantita}`).join('\n');
    const conferma = confirm(`Prodotti:\n${dettagli}\n\nTOTALE: €${totale.toFixed(2)}\n\nProcedere con l'acquisto?`);
    
    if (!conferma) {
        return;
    }
    
    const btnProcedi = document.querySelector('.procedi-ordine');
    let testoOriginale = '';
    if (btnProcedi) {
        testoOriginale = btnProcedi.textContent;
        btnProcedi.disabled = true;
        btnProcedi.textContent = ' Elaborazione...';
        btnProcedi.style.background = '#95a5a6';
    }
    
    const ordineData = {
        totale: parseFloat(totale.toFixed(2)),
        items: carrelloData.items.map(item => ({
            id: item.id || Math.random(),
            nome: String(item.nome),
            prezzo: parseFloat(item.prezzo),
            quantita: parseInt(item.quantita)
        }))
    };
    
    fetch('../api/salva_ordine.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(ordineData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`il tuo ordine #${data.ordine_id} è stato salvato!\n\nTotale: €${totale.toFixed(2)}\nData: 2025-06-10 21:40:47\n\nGrazie per il tuo acquisto! 🍕🍔`);
            
            if (window.carrello && typeof window.carrello.svuota === 'function') {
                window.carrello.svuota();
            }
            localStorage.removeItem('carrello');
            sessionStorage.removeItem('carrello');
            
            const overlay = document.getElementById('carrello-overlay');
            if (overlay) overlay.style.display = 'none';
            
            document.body.classList.remove('carrello-aperto');
            
        } else {
            throw new Error(data.error || 'Errore durante il salvataggio');
        }
    })
    .catch(error => {
        alert(`errore: ${error.message}\n\nRiprova più tardi.`);
    })
    .finally(() => {
        if (btnProcedi) {
            btnProcedi.disabled = false;
            btnProcedi.textContent = testoOriginale || 'Procedi all\'ordine';
            btnProcedi.style.background = '#00ccbc';
        }
    });
};

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const btn = document.querySelector('.procedi-ordine');
        if (btn) {
            btn.removeAttribute('onclick');
            
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                procediOrdine();
                
            });
        }
    }, 1000); 
});

// Backup: cerca il pulsante ogni 3 secondi per 30 secondi
let tentativi = 0;
const maxTentativi = 10;

const intervalloRicerca = setInterval(function() {
    tentativi++;
    
    const btn = document.querySelector('.procedi-ordine');
    
    if (btn && !btn.dataset.hasListener ) {
        btn.dataset.hasListener  = 'attached';
        
        btn.removeAttribute('onclick');
        
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            procediOrdine();
            this.svuota();
        });
        
        clearInterval(intervalloRicerca);
    }
    
    if (tentativi >= maxTentativi) {
        clearInterval(intervalloRicerca);
    }
}, 3000);