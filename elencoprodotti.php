<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
    <title>Prodotti - Deliveroo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/prodotti.css">
</head>
<body>
<?php include("header.php"); ?>

<main class="pagina-prodotti">
    <div class="contenitore-principale">
        <!-- Filtri laterali -->
        <aside class="filtri-negozi">
            <h2 class="titolo-filtri">Filtra per negozio</h2>
            <div class="contenitore-filtri">
                <div class="filtro-categoria">
                    <h3>Categorie</h3>
                    <ul class="lista-filtri" id="filtri-categorie">
                        <!-- Le categorie verranno caricate dinamicamente -->
                    </ul>
                </div>
                
                <div class="filtro-negozio">
                    <h3>Negozi</h3>
                    <ul class="lista-filtri" id="filtri-negozi">
                        <!-- I negozi verranno caricati dinamicamente -->
                    </ul>
                </div>
                
                <button class="pulsante-filtro" id="applica-filtri">Applica filtri</button>
                <button class="pulsante-filtro" id="resetta-filtri">Resetta filtri</button>
            </div>
        </aside>

        <!-- Contenuto principale con prodotti -->
        <section class="elenco-prodotti">
            <div class="intestazione-prodotti">
                <h1>Prodotti disponibili</h1>
                <div class="ordinamento">
                    <label for="ordina-per">Ordina per:</label>
                    <select id="ordina-per">
                        <option value="nome">Nome</option>
                        <option value="prezzo-crescente">Prezzo: crescente</option>
                        <option value="prezzo-decrescente">Prezzo: decrescente</option>
                        <option value="popolarita">Popolarità</option>
                    </select>
                </div>
            </div>
            
            <div id="loading" class="loading" style="display: none;">
                <p>Caricamento prodotti...</p>
            </div>
            
            <div class="prodotti-grid" id="prodotti-container">
                <!-- I prodotti verranno caricati qui via JavaScript -->
            </div>
            
            <div class="paginazione" id="paginazione" style="display: none;">
                <button class="pulsante-pagina" id="pagina-prec">Precedente</button>
                <span class="contatore-pagine" id="contatore-pagine">Pagina 1 di 1</span>
                <button class="pulsante-pagina" id="pagina-succ">Successiva</button>
            </div>
        </section>
    </div>
</main>

<?php include("footer.php"); ?>

<script src="../js/prodotti.js"></script>
</body>
</html>