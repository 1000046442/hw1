<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');

$host = 'localhost';
$dbname = 'webprogramming';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Errore connessione: " . mysqli_connect_error());
}

echo "=== DEBUG CONTEGGIO PRODOTTI ===\n\n";

// Test 1: Conteggio totale
$sql1 = "SELECT COUNT(*) as totale FROM prodotti";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($result1);
echo "1. Prodotti totali nella tabella: " . $row1['totale'] . "\n";

// Test 2: Conteggio disponibili
$sql2 = "SELECT COUNT(*) as disponibili FROM prodotti WHERE disponibile = 1";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
echo "2. Prodotti disponibili: " . $row2['disponibili'] . "\n";

// Test 3: Conteggio con JOIN
$sql3 = "SELECT COUNT(*) as con_join 
         FROM prodotti p
         JOIN categorie c ON p.id_categoria = c.id
         JOIN negozi n ON p.id_negozio = n.id
         WHERE p.disponibile = 1";
$result3 = mysqli_query($conn, $sql3);
$row3 = mysqli_fetch_assoc($result3);
echo "3. Prodotti con JOIN: " . $row3['con_join'] . "\n";

// Test 4: Simulazione query API con ordinamento
$ordinamento = $_GET['ordinamento'] ?? 'nome';
echo "\n4. Test con ordinamento '$ordinamento':\n";

$sql4 = "SELECT COUNT(*) as con_ordinamento
         FROM prodotti p
         JOIN categorie c ON p.id_categoria = c.id
         JOIN negozi n ON p.id_negozio = n.id
         WHERE p.disponibile = 1";

switch($ordinamento) {
    case 'prezzo-crescente':
        $sql4 .= " ORDER BY p.prezzo ASC";
        break;
    case 'prezzo-decrescente':
        $sql4 .= " ORDER BY p.prezzo DESC";
        break;
    case 'popolarita':
        $sql4 .= " ORDER BY p.valutazione DESC";
        break;
    case 'nome':
    default:
        $sql4 .= " ORDER BY p.nome ASC";
        break;
}

$result4 = mysqli_query($conn, $sql4);
$row4 = mysqli_fetch_assoc($result4);
echo "   Prodotti con ordinamento: " . $row4['con_ordinamento'] . "\n";

// Test 5: Verifica dati nelle tabelle collegate
echo "\n5. Verifica tabelle collegate:\n";

$sql5a = "SELECT COUNT(*) as categorie_attive FROM categorie WHERE attiva = 1";
$result5a = mysqli_query($conn, $sql5a);
$row5a = mysqli_fetch_assoc($result5a);
echo "   Categorie attive: " . $row5a['categorie_attive'] . "\n";

$sql5b = "SELECT COUNT(*) as negozi_attivi FROM negozi WHERE attivo = 1";
$result5b = mysqli_query($conn, $sql5b);
$row5b = mysqli_fetch_assoc($result5b);
echo "   Negozi attivi: " . $row5b['negozi_attivi'] . "\n";

// Test 6: Prodotti senza categoria o negozio
echo "\n6. Prodotti con problemi di relazioni:\n";

$sql6a = "SELECT COUNT(*) as senza_categoria FROM prodotti WHERE id_categoria IS NULL OR id_categoria NOT IN (SELECT id FROM categorie WHERE attiva = 1)";
$result6a = mysqli_query($conn, $sql6a);
$row6a = mysqli_fetch_assoc($result6a);
echo "   Prodotti senza categoria valida: " . $row6a['senza_categoria'] . "\n";

$sql6b = "SELECT COUNT(*) as senza_negozio FROM prodotti WHERE id_negozio IS NULL OR id_negozio NOT IN (SELECT id FROM negozi WHERE attivo = 1)";
$result6b = mysqli_query($conn, $sql6b);
$row6b = mysqli_fetch_assoc($result6b);
echo "   Prodotti senza negozio valido: " . $row6b['senza_negozio'] . "\n";

mysqli_close($conn);

echo "\n=== FINE DEBUG ===\n";
?>