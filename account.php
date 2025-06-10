 <?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>le tue informazioni - Deliveroo</title>
    <link rel="stylesheet" href="../css/informazioni.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include("header.php"); ?>
    <main class="main-content">
        <div class="form-container">
            <h2 class="form-title">Le tue informazioni</h2>

            <form id="user-info-form">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="nome">Nome *</label>
                        <input type="text" id="nome" name="nome" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cognome">Cognome *</label>
                        <input type="text" id="cognome" name="cognome" class="form-input" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="data_nascita">Data di Nascita</label>
                        <input type="date" id="data_nascita" name="data_nascita" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="telefono">Telefono</label>
                        <input type="tel" id="telefono" name="telefono" class="form-input" placeholder="+39 123 456 7890">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label class="form-label" for="indirizzo">Indirizzo</label>
                        <input type="text" id="indirizzo" name="indirizzo" class="form-input" placeholder="Via, Numero civico">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="citta">Città</label>
                        <input type="text" id="citta" name="citta" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cap">CAP</label>
                        <input type="text" id="cap" name="cap" class="form-input" maxlength="5" pattern="[0-9]{5}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="provincia">Provincia</label>
                        <input type="text" id="provincia" name="provincia" class="form-input" maxlength="2" placeholder="CT">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="paese">Paese</label>
                        <input type="text" id="paese" name="paese" class="form-input" value="Italia">
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="submit-btn">💾 Salva Informazioni</button>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    
    <script src="../js/get-informazioni.js"></script>
</body>
</html>