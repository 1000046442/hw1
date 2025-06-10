// funzione per far visualizzare il menu a tendina attraverso l'aggiunta e la rimozione di una classe modificando il display : none

function menuatenda() {
    const menu_tenda = document.querySelector(".menuatendanascosto");
    if (!menu_tenda.classList.contains("menuatendavisibile")) 
    menu_tenda.classList.add("menuatendavisibile");
    else 
    menu_tenda.classList.remove("menuatendavisibile");
}


const bottonetenda = document.querySelector(".bottonetenda");
bottonetenda.addEventListener("click" , menuatenda);
 
function creaelementi() {
    const prodottiristorante = {
        "mcdonalds": [ {
                nome: "Smoky Gran Crispy McBacon® Menu",
                img: "https://www.mcdonalds.it/sites/default/files/styles/product_isolated_preview/public/bundle/isolated--menu-smoky-gran-crispy-mcbacon.png?itok=muuz7vgn",
                prezzo: 8.64
            },
            {
                nome: "Big Mac® Menu",
                img: "https://www.mcdonalds.it/sites/default/files/styles/product_isolated_preview/public/bundle/isolated--menu-bigmac_0.png?itok=tbn18zG7",
                prezzo: 7.89
            },
        ],
        "sushi" : [ {
                nome: "Nigiri",
                img: "https://sushisenpai.it/wp-content/uploads/2017/08/tipi-di-sushi-nigiri.jpg",
                prezzo: 10
            },
            {
                nome: "Gunkan",
                img: "https://sushisenpai.it/wp-content/uploads/2017/08/sushi-particolari-gunkan.jpg",
                prezzo: 9.89
            },
        ],
        "burgerking" : [ {
                nome: "Special King combo Limited edition: King nuggets",
                img: "https://www.burgerking.it/assets/img/console/appUser/news/1537_desktop_it.png?v=1743777555",
                prezzo: 4.95
            },
            {
                nome: "Special King combo Limited edition: Insalata con tonno",
                img: "https://www.burgerking.it/assets/img/console/appUser/news/1536_desktop_it.png?v=1743777413",
                prezzo: 4.95
            },
        ],
        "kfc" : [ {
                nome: "Box Meal Menu Bucket Tender Crispy Cheese &n",
                img: "https://media.imagonist.com/products/products/466_thumb_it.png?v=1741068447",
                prezzo: 11.95
            },
            {
                nome: "Menu Bucket Tender Crispy",
                img: "https://media.imagonist.com/mo/products/1218_image_it.png?v=1730893242",
                prezzo: 15.95
            },
        ],
        "oldwildwest" : [ {
                nome: "NEW YORK SMASH BURGER",
                img: "https://www.oldwildwest.it/proxyvfs.axd/img_main/r26882/ny-jpg?v=19776&ext=.jpg",
                prezzo: 13.80
            },
            {
                nome: "SMASH BURGER 20 YEARS",
                img: "https://www.oldwildwest.it/proxyvfs.axd/img_main/r25754/20-jpg?v=19786&ext=.jpg",
                prezzo: 11.80 
            },
        ]
    };

    // Crea il modal per i prodotti
    const modal_prodotti = document.createElement('div');
    modal_prodotti.className = 'modal_prodotti';
    modal_prodotti.innerHTML = `<div class="boxmodal">
            <span class="chiudi">&times;</span>
            <h2 class="titolo">Prodotti</h2>
            <div class="contenitore_prodotti"></div>
            </div>`;
    document.body.appendChild(modal_prodotti);   // appendChild aggiunge un nodo alla fine dell'elenco
    // Gestione click sul modal
    const closeModal = modal_prodotti.querySelector('.chiudi');
    closeModal.addEventListener('click', () => {
        modal_prodotti.style.display = 'none';
    });
   // Chiudi il modal cliccando fuori dal contenuto
    modal_prodotti.addEventListener('click', (e) => {
        if (e.target === modal_prodotti) {
            modal_prodotti.style.display = 'none';
        }
    });
    // Aggiungi event listener alle immagini dello slider
    document.querySelectorAll('.imgslider').forEach(img => {
        img.addEventListener('click', function() {
            // gwtAttribut per prenderre un attributo dal html per ricavare il nome del ristorante
            const risto = this.getAttribute('data-risto') || 'vuoto'; //vuoto = se non trova l'attributo risto (fallback)
            // escludi le immagini voute e sostituisci le immagini
            if(risto !== 'vuoto')
                mostraprodotti(risto);
            else
                img.src = "https://media.istockphoto.com/id/936182806/it/vettoriale/nessun-segno-di-immagine-disponibile.jpg?s=612x612&w=is&k=20&c=xcOUyyWN-rJL1O-l01tS1qEKA3-keT4Czby5Qed-qBs=";
        });
    });
    function mostraprodotti(risto) {
        const contenitore_prodotti = modal_prodotti.querySelector('.contenitore_prodotti');
        // Pulisci il contenitore per non far visualizzare i prodotti al secondo click
        contenitore_prodotti.innerHTML = '';
        // Ottieni i prodotti 
        const prodotti = prodottiristorante[risto] || [];
        // Crea i prodotti
        prodotti.forEach(prodottox => {
            const prodottosingolo = document.createElement('div');
            prodottosingolo.className = 'prodottosingolosli';
            prodottosingolo.innerHTML = `
                <img class="imgprodottisli" src="${prodottox.img}">
                <div class="titoloprodottosli">${prodottox.nome}</div>
                <div class="prezzoprodottisli">${prodottox.prezzo.toFixed(2)}€</div>
                <button class="btn_cerca_youtube_prodotto"><i class="icona-youtube"></i> Cerca su YouTube</button>`;
            contenitore_prodotti.appendChild(prodottosingolo);
            
            // Aggiungi l'event listener al pulsante di ricerca YouTube
            const btnYoutube = prodottosingolo.querySelector('.btn_cerca_youtube_prodotto');
            btnYoutube.addEventListener('click', function(e) {
                e.stopPropagation(); // Previene che il click si propaghi al prodotto
                
                // Chiudi il modal dei prodotti
                modal_prodotti.style.display = 'none';
                
                // Apri la ricerca YouTube con il nome del prodotto
                apriRicercaYoutube(prodottox.nome);
            });
        });
        modal_prodotti.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    creaelementi();
});

//youtube

function initYouTubeSearch() {
    // Crea il modal per la ricerca di YouTube
    const modal_youtube = document.createElement('div');
    modal_youtube.className = 'modal_youtube';
    modal_youtube.innerHTML = `<div class="boxmodal">
            <span class="chiudi">&times;</span>
            <h2 class="titolo">Ricerca YouTube</h2>
            <div class="ricerca_youtube">
                <input type="text" id="query_youtube" placeholder="Cerca video su YouTube...">
                <button id="btn_cerca_youtube">Cerca</button>
            </div>
            <div class="contenitore_video"></div>
            </div>`;
    document.body.appendChild(modal_youtube);
    
    // Gestione click sul modal YouTube
    const closeYoutubeModal = modal_youtube.querySelector('.chiudi');
    closeYoutubeModal.addEventListener('click', () => {
        modal_youtube.style.display = 'none';
    });
    
    // Chiudi il modal cliccando fuori dal contenuto
    modal_youtube.addEventListener('click', (e) => {
        if (e.target === modal_youtube) {
            modal_youtube.style.display = 'none';
        }
    });
    
    const btnYoutube = document.createElement('button');
    btnYoutube.id = 'apri_youtube';
    btnYoutube.textContent = 'Cerca Video YouTube';
    document.body.appendChild(btnYoutube);
    
    // Event listener per il pulsante di apertura ricerca YouTube
    btnYoutube.addEventListener('click', () => {
        modal_youtube.style.display = 'block';
    });
    
    document.getElementById('btn_cerca_youtube').addEventListener('click', cercaVideoYoutube);
    
    // Aggiungi event listener per abilitare la ricerca con il tasto Enter nella casella di input
    document.getElementById('query_youtube').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            cercaVideoYoutube();
        }
    });
}

// Funzione per cercare video su YouTube
function cercaVideoYoutube() {
    const query = document.getElementById('query_youtube').value;
    if (!query.trim()) {
        alert('Inserisci un termine di ricerca');
        return;
    }
    
    const API_KEY = 'secret';
    
    const url = `https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=10&q=${encodeURIComponent(query)}&type=video&key=${API_KEY}`;
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Errore nella richiesta API');
            }
            return response.json();
        })
        .then(data => {
            mostraRisultatiYoutube(data.items);
        })
        .catch(error => {
            console.error('Errore:', error);
            alert('Errore durante la ricerca. Verifica la tua API key.');
        });
}

// Funzione per mostrare i risultati di YouTube
function mostraRisultatiYoutube(videos) {
    const contenitore_video = document.querySelector('.contenitore_video');
    contenitore_video.innerHTML = '';
    
    if (!videos || videos.length === 0) {
        contenitore_video.innerHTML = '<p>Nessun risultato trovato.</p>';
        return;
    }
    
    videos.forEach(video => {
        const videoElement = document.createElement('div');
        videoElement.className = 'video_item';
        
        // Ottieni i dettagli del video
        const videoId = video.id.videoId;
        const titolo = video.snippet.title;
        const thumbnail = video.snippet.thumbnails.medium.url;
        const canale = video.snippet.channelTitle;
        const pubblicato = new Date(video.snippet.publishedAt).toLocaleDateString('it-IT');
        
        videoElement.innerHTML = `
            <div class="video_preview">
                <img src="${thumbnail}" alt="${titolo}">
                <div class="play_button" data-videoid="${videoId}">▶</div>
            </div>
            <div class="video_info">
                <h3>${titolo}</h3>
                <p>Canale: ${canale}</p>
                <p>Pubblicato: ${pubblicato}</p>
                <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank">Guarda su YouTube</a>
            </div>
        `;
        
        contenitore_video.appendChild(videoElement);
        
        // Aggiungi evento click sul bottone play
        const playButton = videoElement.querySelector('.play_button');
        playButton.addEventListener('click', () => {
            apriVideoYoutube(videoId, titolo);
        });
    });
}

// Funzione per aprire il video in un modal
function apriVideoYoutube(videoId, titolo) {
    // Crea un modal per il video
    const videoModal = document.createElement('div');
    videoModal.className = 'modal_video';
    videoModal.innerHTML = `
        <div class="boxmodal_video">
            <span class="chiudi">&times;</span>
            <h3>${titolo}</h3>
            <div class="video_container">
                <iframe width="560" height="315" 
                        src="https://www.youtube.com/embed/${videoId}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    `;
    
    document.body.appendChild(videoModal);
    
    videoModal.style.display = 'block';
    
    const closeVideoModal = videoModal.querySelector('.chiudi');
    closeVideoModal.addEventListener('click', () => {
        document.body.removeChild(videoModal);
    });
    
    videoModal.addEventListener('click', (e) => {
        if (e.target === videoModal) {
            document.body.removeChild(videoModal);
        }
    });
}

function apriRicercaYoutube(query = '') {
    if (!document.querySelector('.modal_youtube')) {
        initYouTubeSearch();
    }
    if (query) {
        document.getElementById('query_youtube').value = query;
    }
    
    document.querySelector('.modal_youtube').style.display = 'block';
    
    if (query) {
        cercaVideoYoutube();
    }
}


document.addEventListener('DOMContentLoaded', function() {
    initYouTubeSearch();
});



//openstreet

document.addEventListener('DOMContentLoaded', function() {
    const input =  document.querySelector(".cercalocation");
    const suggerimenti = document.querySelector('.suggerimenti-ricerca');
    let selectedLocation = null;

    // Cerca indirizzi usando Nominatim
    function searchAddress(query) {
        if (query.length < 3) {
            suggerimenti.style.display = 'none';
            return;
        }

        // Mostra un messaggio di caricamento
        suggerimenti.innerHTML = '<div class="suggerimento-item">Ricerca in corso...</div>';
        suggerimenti.style.display = 'block';

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=it&limit=5`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    suggerimenti.innerHTML = '';
                    data.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'suggerimento-item';
                        div.textContent = item.display_name;
                        div.addEventListener('click', () => {
                            selectLocation(item);
                        });
                        suggerimenti.appendChild(div);
                    });
                } else {
                    suggerimenti.innerHTML = '<div class="suggerimento-item">Nessun risultato trovato</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                suggerimenti.innerHTML = '<div class="suggerimento-item">Errore nella ricerca</div>';
            });
    }

    // Seleziona un indirizzo dai suggerimenti
    function selectLocation(location) {
        selectedLocation = location;
        input.value = location.display_name;
        suggerimenti.style.display = 'none';
    }

    // Event listeners
    input.addEventListener('input', function() {
        searchAddress(this.value);
    });

    input.addEventListener('focus', function() {
        if (this.value.length >= 3 && suggerimenti.innerHTML.trim() !== '') {
            suggerimenti.style.display = 'block';
        }
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.ricerca')) {
            suggerimenti.style.display = 'none';
        }
    });

    // Nascondi suggerimenti quando si preme ESC
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            suggerimenti.style.display = 'none';
        }
    });
});

