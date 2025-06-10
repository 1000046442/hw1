
let paginaCorrente = 1;
let totalePagine = 1;
let categorie = [];
let negozi = [];

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM caricato, inizializzazione pagina...');
    inizializzaPagina();
});

function inizializzaPagina() {
    caricaCategorie();
    caricaNegozi();
    caricaProdotti();
    impostaEventListeners();
}

function impostaEventListeners() {
    const applicaFiltri = document.getElementById('applica-filtri');
    if (applicaFiltri) {
        applicaFiltri.addEventListener('click', function() {
            console.log('Applica filtri cliccato');
            paginaCorrente = 1;
            caricaProdotti();
        });
    }
    
    const resettaFiltri = document.getElementById('resetta-filtri');
    if (resettaFiltri) {
        resettaFiltri.addEventListener('click', function() {
            console.log('Resetta filtri cliccato');
            document.querySelectorAll('.filtri-negozi input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.checked = false;
            });
            paginaCorrente = 1;
            caricaProdotti();
        });
    }
    

    const ordinaPer = document.getElementById('ordina-per');
    if (ordinaPer) {
        ordinaPer.addEventListener('change', function() {
            console.log('Ordinamento cambiato a:', this.value);
            paginaCorrente = 1;
            caricaProdotti();
        });
    }
    
    // Gestione paginazione
    const paginaPrec = document.getElementById('pagina-prec');
    if (paginaPrec) {
        paginaPrec.addEventListener('click', function() {
            console.log('Pagina precedente cliccata');
            if (paginaCorrente > 1) {
                paginaCorrente--;
                caricaProdotti();
                scrollToTop();
            }
        });
    }
    
    const paginaSucc = document.getElementById('pagina-succ');
    if (paginaSucc) {
        paginaSucc.addEventListener('click', function() {
            console.log('Pagina successiva cliccata');
            if (paginaCorrente < totalePagine) {
                paginaCorrente++;
                caricaProdotti();
                scrollToTop();
            }
        });
    }
}

function caricaCategorie() {
    console.log('Caricamento categorie...');
    fetch('../api/get_prodotti.php?action=get_categorie')
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Errore HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                categorie = data.categorie;
                renderCategorie(data.categorie);
            } else {
                throw new Error(data.error || 'Errore nel caricamento categorie');
            }
        })
        .catch(function(error) {
            console.error('Errore nel caricamento delle categorie:', error);
            mostraErroreCategorie();
        });
}

function caricaNegozi() {
    console.log('Caricamento negozi...');
    fetch('../api/get_prodotti.php?action=get_negozi')
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Errore HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                negozi = data.negozi;
                renderNegozi(data.negozi);
            } else {
                throw new Error(data.error || 'Errore nel caricamento negozi');
            }
        })
        .catch(function(error) {
            console.error('Errore nel caricamento dei negozi:', error);
            mostraErroreNegozi();
        });
}

function caricaProdotti() {
    console.log('Caricamento prodotti - Pagina:', paginaCorrente);
    
    mostraLoading(true);
    
    const filtriCategoria = ottieniCategorieFiltrate();
    const filtriNegozio = ottieniNegoziFiltrati();
    const ordinamentoSelect = document.getElementById('ordina-per');
    const ordinamento = ordinamentoSelect ? ordinamentoSelect.value : 'nome';
    
    const params = new URLSearchParams({
        action: 'get_prodotti',
        ordinamento: ordinamento,
        pagina: paginaCorrente.toString(),
        per_pagina: '12'
    });
    
    filtriCategoria.forEach(function(id) {
        params.append('categorie[]', id);
    });
    
    filtriNegozio.forEach(function(id) {
        params.append('negozi[]', id);
    });
    
    const url = '../api/get_prodotti.php?' + params.toString();
    console.log('URL chiamata:', url);
    
    fetch(url)
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Errore HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            console.log('Risposta API:', data);
            if (data.success) {
                mostraProdotti(data.prodotti);
                aggiornaPaginazione(data.paginazione);
            } else {
                throw new Error(data.error || 'Errore nel caricamento prodotti');
            }
        })
        .catch(function(error) {
            console.error('Errore nel caricamento dei prodotti:', error);
            mostraErroreProdotti();
        })
        .finally(function() {
            mostraLoading(false);
        });
}

function renderCategorie(categorie) {
    const container = document.getElementById('filtri-categorie');
    if (!container) return;
    
    container.innerHTML = '';
    
    categorie.forEach(function(categoria) {
        const li = document.createElement('li');
        li.innerHTML = 
            '<label>' +
                '<input type="checkbox" name="categoria" value="' + categoria.id + '"> ' +
                categoria.nome +
            '</label>';
        container.appendChild(li);
    });
}

function renderNegozi(negozi) {
    const container = document.getElementById('filtri-negozi');
    if (!container) return;
    
    container.innerHTML = '';
    
    negozi.forEach(function(negozio) {
        const li = document.createElement('li');
        li.innerHTML = 
            '<label>' +
                '<input type="checkbox" name="negozio" value="' + negozio.id + '"> ' +
                negozio.nome +
            '</label>';
        container.appendChild(li);
    });
}

function mostraProdotti(prodotti) {
    const container = document.getElementById('prodotti-container');
    if (!container) return;
    
    container.innerHTML = '';
    
    if (prodotti.length === 0) {
        container.innerHTML = '<p class="nessun-risultato">Nessun prodotto trovato con i filtri selezionati.</p>';
        container.style.display = 'block';
        return;
    }
    
    console.log('Mostro', prodotti.length, 'prodotti');
    
    prodotti.forEach(function(prodotto) {
        const prodottoElement = document.createElement('div');
        prodottoElement.className = 'prodotto-card';
        prodottoElement.innerHTML = 
            '<div class="prodotto-immagine">' +
                '<img src="../' + (prodotto.immagine || 'img/placeholder.jpg') + '" alt="' + prodotto.nome + '" onerror="this.src=\'../img/placeholder.jpg\'">' +
            '</div>' +
            '<div class="prodotto-info">' +
                '<h3 class="prodotto-nome">' + prodotto.nome + '</h3>' +
                '<div class="prodotto-negozio">' + prodotto.negozio_nome + '</div>' +
                '<div class="prodotto-categoria">' + prodotto.categoria_nome + '</div>' +
                '<div class="prodotto-valutazione">' + renderStelle(prodotto.valutazione) + '</div>' +
                '<div class="prodotto-prezzo">€' + parseFloat(prodotto.prezzo).toFixed(2) + '</div>' +
                '<button class="prodotto-aggiungi" data-id="' + prodotto.id + '" onclick="aggiungiAlCarrello(' + prodotto.id + ')">' +
                    'Aggiungi al carrello' +
                '</button>' +
            '</div>';
        container.appendChild(prodottoElement);
    });
    
    container.style.display = 'grid';
}

function aggiornaPaginazione(paginazione) {
    console.log('Aggiornamento paginazione:', paginazione);
    
    totalePagine = paginazione.totale_pagine;
    paginaCorrente = paginazione.pagina_corrente;
    
    const contatore = document.getElementById('contatore-pagine');
    if (contatore) {
        contatore.textContent = 'Pagina ' + paginaCorrente + ' di ' + totalePagine + ' (' + paginazione.totale_prodotti + ' prodotti)';
    }
    
    const paginaPrec = document.getElementById('pagina-prec');
    if (paginaPrec) {
        paginaPrec.disabled = paginaCorrente <= 1;
    }
    
    const paginaSucc = document.getElementById('pagina-succ');
    if (paginaSucc) {
        paginaSucc.disabled = paginaCorrente >= totalePagine;
    }
    
    const paginazioneDiv = document.getElementById('paginazione');
    if (paginazioneDiv) {
        if (totalePagine > 1) {
            paginazioneDiv.style.display = 'flex';
        } else {
            paginazioneDiv.style.display = 'none';
        }
    }
}

function renderStelle(valutazione) {
    const stellePiene = Math.floor(valutazione);
    const stellaMezza = valutazione - stellePiene >= 0.5 ? 1 : 0;
    const stelleVuote = 5 - stellePiene - stellaMezza;
    
    return '★'.repeat(stellePiene) + (stellaMezza ? '½' : '') + '☆'.repeat(stelleVuote);
}


function ottieniCategorieFiltrate() {
    return Array.from(document.querySelectorAll('input[name="categoria"]:checked')).map(function(el) {
        return el.value;
    });
}

function ottieniNegoziFiltrati() {
    return Array.from(document.querySelectorAll('input[name="negozio"]:checked')).map(function(el) {
        return el.value;
    });
}

function mostraLoading(mostra) {
    const loading = document.getElementById('loading');
    const container = document.getElementById('prodotti-container');
    
    if (loading && container) {
        if (mostra) {
            loading.style.display = 'block';
            container.style.display = 'none';
        } else {
            loading.style.display = 'none';
            container.style.display = 'grid';
        }
    }
}

function mostraErroreProdotti() {
    const container = document.getElementById('prodotti-container');
    if (container) {
        container.innerHTML = '<p class="errore">Errore nel caricamento dei prodotti.</p>';
        container.style.display = 'block';
    }
}

function mostraErroreCategorie() {
    const container = document.getElementById('filtri-categorie');
    if (container) {
        container.innerHTML = '<li><span style="color: #e74c3c;">Errore nel caricamento categorie</span></li>';
    }
}

function mostraErroreNegozi() {
    const container = document.getElementById('filtri-negozi');
    if (container) {
        container.innerHTML = '<li><span style="color: #e74c3c;">Errore nel caricamento negozi</span></li>';
    }
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}