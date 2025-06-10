 <?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
    <title>Deliveroo</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="script.js" defer></script>
</head>
<body>
<?php include("header.php"); ?>



    <div class="headerbottom">
        <h1 class="testoboxtop">I piatti dei ristoranti che ami e la spesa, a domicilio </h1>
        <div class="headerbottombox">
            <div class="testobox">
                Inserisci un indirizzo per scoprire le opzioni disponibili nella tua zona
            </div>
            <div class="ricerca">
                <svg class="imgxmlheaderricerca">
                    <path d="M2 11.8214L21 3L12.1786 22L10.1429 13.8571L2 11.8214ZM11.7882 12.2118L12.7455 16.0408L16.8936 7.10644L7.95923 11.2545L11.7882 12.2118Z"></path>
                </svg>  
                <input class="cercalocation" type="text" inputmode="text" autocomplete="off" placeholder="Inserisci il tuo indirizzo completo">
                <div class="suggerimenti-ricerca"></div>
                <a class="Aheader">
                    <button class="cerca">
                        Cerca
                    </button>  
                </a>
            </div>
        </div>    

            <div class="headerprodotti">
                <h2 class="testoprodottitop">Scopri tutti i nostri prodotti</h2>
                    <div class="headerprodottibox">
                        <div class="testoprodottibox">
                            Sfoglia il nostro catalogo completo e trova i prodotti perfetti per te
                        </div>
                        <div class="ricercaprodotti">
                            <svg class="imgxmlheaderricerca">
                                <path d="M7 18C5.9 18 5.01 18.9 5.01 20S5.9 22 7 22 9 21.1 9 20 8.1 18 7 18ZM1 2V4H3L6.6 11.59L5.24 14.04C5.09 14.32 5 14.65 5 15C5 16.1 5.9 17 7 17H19V15H7.42C7.28 15 7.17 14.89 7.17 14.75L7.2 14.63L8.1 13H15.55C16.3 13 16.96 12.58 17.3 11.97L20.88 5H5.21L4.27 3H1ZM17 18C15.9 18 15.01 18.9 15.01 20S15.9 22 17 22 19 21.1 19 20 18.1 18 17 18Z"/>
                            </svg> 
                            <a class="Aheaderprodotti" href="elencoprodotti.php">
                                <button class="cercaprodotti">
                                    Cerca Prodotti
                                </button>  
                            </a>
                        </div>
                    </div>  
            </div>
        </div>        

    <section class="sliderimmagini">
        <div class="slider">
            <div class="simg"><img class="imgslider" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTofG8ztxXbOG0LINKzNcGGQRuGNiQXxvktkg&s" data-risto="mcdonalds"></div>
            <div class="simg"><img class="imgslider" src="https://img2.storyblok.com/filters:format(webp)/f/62776/512x256/b07158449c/sushi-wide.jpg" data-risto="sushi"></div>
            <div class="simg"><img class="imgslider" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRvtYxEPGmJUrlbLbE1xlYeK8AE3_uCLvHaiA&s" data-risto="burgerking"></div>
            <div class="simg"><img class="imgslider" src="https://www.rundesign.it/wp-content/uploads/2023/08/kfc.jpg" data-risto="kfc"></div>
            <div class="simg"><img class="imgslider" src="https://i0.wp.com/www.sintesi-hub.com/wp-content/uploads/2017/11/logo-OWW-home_rid.jpg?fit=709%2C673&quality=100" data-risto="oldwildwest"></div>
            <div class="simg"><img class="imgslider" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8wnjmb-FNcj5EcQ_ahlzmZSjlN8S6_Gd5-Q&s"></div>
        </div>
    </section>
    <section class="seguiordini">
        <div class="testoordini">
            <div class="texttop">
                <h2 class="h2header">Segui gli ordini passo passo</h2>
            </div>
            <div class="textbottom">
                I piatti e i prodotti che ami, consegnati in pochissimo tempo. Vedrai quando il rider ha ritirato l'ordine, che potrai seguire passo passo, e riceverai una notifica quando sarà quasi da te.
            </div>
            <div class="imgseguiordinibottom">
                <a target="_blank" href="https://deliveroo.it/app/?platform=ios&home_page=true&home_page_variant=homepage_variant_b&mobile_banner=false">
                    <img class="app" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Download_on_the_App_Store_Badge_IT_RGB_blk.svg/2560px-Download_on_the_App_Store_Badge_IT_RGB_blk.svg.png">
                </a>
                <a  target="_blank" href="https://deliveroo.it/app/?platform=android&home_page=true&home_page_variant=homepage_variant_b&mobile_banner=false">
                    <img class="app" src="data:image/png;base64,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">
                </a>
            </div>
        </div>
        <div class="mappa">
            <img class="imgmap" src="https://img2.storyblok.com/filters:format(webp)/f/62776/x/ca59b51c51/map-min.svg" alt="mappanoncaricata">
            <img class="imgsopramap" src="https://img2.storyblok.com/filters:format(webp)/f/62776/731x276/e6a58efba4/notification-itit.png" alt="messaggiononcaricato">
        </div>
    </section>
    <section class="sconti">
        <div class="textscontitop">
            <h1 class="h1sconti">Menù in offerta: sconti fino al 25%</h1>
        </div>
        <div class="textscontimiddle"> 
            Perfetti per dare più gusto alla tua settimana, 
            ordinare i piatti più amati da tutta la famiglia e fare una pausa dai fornelli.
        </div>
        <div class="textscontobottom">
            Si applicano spese di consegna e di servizio. Offerta soggetta a disponibilità, solo per ristoranti aderenti
             all'iniziativa. Si applicano termini e condizioni, consultabili qui.
             <a class="scontolink" href="https://deliveroo.it/it/legal">Termini e condizioni qui.</a>
        </div>

    </section>
    <section class="lavoro">
        <div class="lavorobox">
            <img class="imglavoro" src="https://a.storyblok.com/f/62776/1000x800/a0cab248af/partner.jpg">
            <h1 class="testolavorah1">Diventa nostro partner</h1>
            <p class="testolavora">Raggiungi più clienti con Deliveroo. Gestiamo noi la consegna, così tu puoi dedicarti a offrire i migliori piatti e prodotti.</p>
            <form action="https://restaurants.deliveroo.com/it-it/?utm-campaign=workwithus&utm-medium=organic&utm-source=landingpage">
                <button class="lavoroiniziaora">
                    <span class="lavorotestoiniziaora">Inizia ora</span>
                </button>
            </form>        
        </div>
        <div class="lavorobox">
            <img class="imglavoro" src="https://a.storyblok.com/f/62776/1000x800/686a5c87b6/rider.jpg">
            <h1 class="testolavorah1">Consegna con noi</h1>
            <p class="testolavora">La libertà di consegnare dove e quando vuoi, con ottimi guadagni, convenzioni e sconti riservati a te.</p>
            <form action="https://deliveroo.it/apply?utm-campaign=ridewithus_lower&utm-medium=organic&utm-source=landingpage">
                <button class="lavoroiniziaora">
                    <span class="lavorotestoiniziaora">Inizia ora</span>
                </button>
            </form>        
        </div>
        <div class="lavorobox">
            <img class="imglavoro" src="https://a.storyblok.com/f/62776/800x638/02b3179ae5/dfw_2021_relaunch_shot_06_edit_lr.jpg">
            <h1 class="testolavorah1">Deliveroo for Work</h1>
            <p class="testolavora">Da pranzi aziendali a budget personalizzati per i dipendenti, possiamo offrire la soluzione giusta per qualsiasi esigenza.</p>
            <form action="https://deliveroo.it/it/for-work">
                <button class="lavoroiniziaora">
                    <span class="lavorotestoiniziaora">Inizia ora</span>
                </button>
            </form>        
        </div>
    </section>
<?php include("footer.php"); ?>


</body>
</html>