<script src="../js/carrello.js"></script>
<header class="header">
    <div class="headertop">
        <a class="home" href="index.php"></a>
        <div class="contenitorebottoni">
            <!-- menu a tendina con js --> 
            <div class="menutendadiv">
                <button class="bottonetenda">
                    <a class="headerlink">
                        <svg class="imgxmlheader">
                            <path d="M4.88398 7.11612L3.11621 8.88389L12.0001 17.7678L20.884 8.88389L19.1162 7.11612L12.0001 14.2322L4.88398 7.11612Z"></path>
                        </svg>
                        <p class="testoheader">Collabora con noi</p>
                    </a>
                </button>
                <ul class="menuatendanascosto">    
                    <li class="tendaitem">
                        <a class="headerlink" target="_blank" href="https://restaurants.deliveroo.com/it-it/?utm-campaign=workwithus&utm-medium=organic&utm-source=landingpage">
                            <svg class="imgxmlheader">
                                <path d="M14 15V13H10V15H14ZM15 15H19.1872L19.7172 13H15V15ZM14 12V10H15V12H19.9822L20.5122 10H3.48783L4.01783 12H9V10H10V12H14ZM14 18V16H10V18H14ZM15 18H18.3922L18.9222 16H15V18ZM9 15V13H4.28283L4.81283 15H9ZM9 18V16H5.07783L5.60783 18H9ZM7 8V3H17V8H23L20 20H4L1 8H7ZM9 8H15V5H9V8Z"></path>
                            </svg>
                            <p class="testoheader">Partner</p>
                        </a>
                    </li>
                    <li class="tendaitem">
                        <a class="headerlink" target="_blank" href="https://careers.deliveroo.it">
                            <svg class="imgxmlheader">
                                <path d="M17 3H7V6H2V20H22V6H17V3ZM15 6H9V5H15V6ZM4 8H20V11H4V8ZM20 12V18H4V12H9V14H15V12H20ZM10 12H14V13H10V12Z"></path>
                            </svg>
                            <p class="headerlink">Lavora con noi</p>
                        </a>
                    </li>
                    <li class="tendaitem">
                        <a class="headerlink" target="_blank" href="https://deliveroo.it/it/for-work">
                            <svg class="imgxmlheader">
                                <path d="M18 12H12V16H18V12Z"></path>
                                <path d="M2 3V21H22V3H2ZM4 5H7V8L6.5 9H4V5ZM8 5H11.5V8L11 9H8.5L8 8V5ZM12.5 8V5H16V8L15.5 9H13L12.5 8ZM17 5H20V9H17.5L17 8V5ZM20 10V19H10V12H6V19H4V10H7L7.5 9L8 10H11.5L12 9L12.5 10H16L16.5 9L17 10H20Z"></path>
                            </svg>
                            <p class="testoheader">Deliveroo for Work</p>
                        </a>
                    </li>
                </ul>
            </div>
            <?php if(isset($_SESSION['username'])): ?>
            <div class="itemheader carrello-header-item">
                <button class="bottone carrello-toggle" id="carrello-toggle">
                    <a class="headerlink">
                        <svg class="imgxmlheader">
                            <path d="M7 18C5.9 18 5.01 18.9 5.01 20S5.9 22 7 22 9 21.1 9 20 8.1 18 7 18ZM1 2V4H3L6.6 11.59L5.24 14.04C5.09 14.32 5 14.65 5 15C5 16.1 5.9 17 7 17H19V15H7.42C7.28 15 7.17 14.89 7.17 14.75L7.2 14.63L8.1 13H15.55C16.3 13 16.96 12.58 17.3 11.97L20.88 5H5.21L4.27 3H1ZM17 18C15.9 18 15.01 18.9 15.01 20S15.9 22 17 22 19 21.1 19 20 18.1 18 17 18Z"/>
                        </svg>
                        <p class="testoheader">Carrello</p>
                        <span class="carrello-count" id="carrello-count">0</span>
                    </a>
                </button>
                <div class="carrello-dropdown" id="carrello-dropdown">
                    <div class="carrello-header">
                        <h3>Il tuo carrello</h3>
                        <button class="carrello-close" id="carrello-close">×</button>
                    </div>
                    
                    <div class="carrello-items" id="carrello-items">
                        <p class="carrello-vuoto">Il carrello è vuoto</p>
                    </div>
                    
                    <div class="carrello-footer">
                        <div class="carrello-totale">
                            <strong>Totale: €<span id="carrello-totale">0.00</span></strong>
                        </div>
                        <div class="carrello-azioni">
                            <button class="btn-svuota" id="svuota-carrello">Svuota</button>
                            <button class="procedi-ordine">
                                 <p class="testoheader">Procedi all'ordine </p>
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="itemheader">
                <button class="bottone">
                    <?php if(isset($_SESSION['username'])): ?>   
                    <a class="headerlink" href="logout.php">
                        <svg class="imgxmlheader">
                            <path d="M3 10L5 8.44444V5H9.42857L12 3L21 10V21H3V10ZM14 19H19V10.9782L12 5.53372L5 10.9782V19H10V14H14V19Z"></path>
                       </svg>
                        <p class="testoheader">Ciao <?php echo htmlspecialchars($_SESSION['username']); ?>, disconnetti</p>
                    <?php else: ?>
                    <a class="headerlink" href="login.php">
                        <svg class="imgxmlheader">
                            <path d="M3 10L5 8.44444V5H9.42857L12 3L21 10V21H3V10ZM14 19H19V10.9782L12 5.53372L5 10.9782V19H10V14H14V19Z"></path>
                        </svg> 
                        <p class="testoheader">Registrati o accedi</p>   
                    <?php endif; ?>   
                    </a>
                </button>
            </div>
            <div class="itemheader"> 
                <button class="bottone">
                    <a class="headerlink" href="account.php">
                       <svg class="imgxmlheader">
                            <path d="M12 3C9.23858 3 7 5.23858 7 8C7 9.93198 8.09575 11.608 9.69967 12.4406C8.35657 12.9598 7.19555 13.8814 6.30036 14.8961C4.94197 16.4359 4 18.4121 4 20L5 21H19L20 20C20 18.4121 19.058 16.4359 17.6996 14.8961C16.8044 13.8814 15.6434 12.9598 14.3003 12.4406C15.9043 11.608 17 9.93198 17 8C17 5.23858 14.7614 3 12 3ZM16.1999 16.2192C17.0137 17.1417 17.5637 18.1562 17.8249 19H6.17507C6.43633 18.1562 6.98632 17.1417 7.80014 16.2192C8.9593 14.9053 10.4584 14 12 14C13.5416 14 15.0407 14.9053 16.1999 16.2192ZM12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8C15 9.65685 13.6569 11 12 11Z"></path>
                       </svg>
                       <p class="testoheader">Account</p>
                    </a>   
                </button>
            </div>
        </div>  
    </div>
</header>