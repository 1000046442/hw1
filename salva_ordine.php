<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Metodo non consentito'
    ]);
    exit();
}

require_once '../parametri.php'; 
session_start();

try {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        throw new Exception('Utente non autenticato. Effettua il login.');
    }
    
    $id_cliente = intval($_SESSION['user_id']);
    $username = $_SESSION['username'];
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Dati non validi ricevuti dal client');
    }
    
    $totale = floatval($input['totale'] ?? 0);
    $items = $input['items'] ?? [];
    
    // Validazioni
    if ($totale <= 0) {
        throw new Exception('Totale ordine non valido: deve essere maggiore di zero');
    }
    
    if (empty($items)) {
        throw new Exception('Carrello vuoto: aggiungi almeno un prodotto');
    }
    
    
    $conn = new mysqli($db['host'], $db['user'], $db['password'], $db['name']);
    
    if ($conn->connect_error) {
        throw new Exception('Errore di connessione al database: ' . $conn->connect_error);
    }
    
    $id_cliente_safe = mysqli_real_escape_string($conn, $id_cliente);
    $totale_safe = mysqli_real_escape_string($conn, number_format($totale, 2, '.', ''));
    
    $query = "INSERT INTO carrello (id_cliente, totale) VALUES ('$id_cliente_safe', '$totale_safe')";
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        throw new Exception('Errore durante il salvataggio dell\'ordine: ' . mysqli_error($conn));
    }
    $ordine_id = mysqli_insert_id($conn);
    if (!$ordine_id) {
        throw new Exception('Errore nel recupero dell\'ID ordine');
    }
    $verify_query = "SELECT * FROM carrello WHERE id = '$ordine_id'";
    $verify_result = mysqli_query($conn, $verify_query);
    
    if (!$verify_result || mysqli_num_rows($verify_result) === 0) {
        throw new Exception('Errore: ordine non trovato dopo inserimento');
    }
    $ordine_salvato = mysqli_fetch_assoc($verify_result);
    
    mysqli_free_result($verify_result);
    mysqli_close($conn);

    echo json_encode([
        'success' => true,
        'message' => 'Ordine salvato con successo nel database',
        'ordine_id' => $ordine_id,
        'data' => [
            'id' => $ordine_id,
            'id_cliente' => $id_cliente,
            'username' => $username,
            'totale' => floatval($ordine_salvato['totale']),
            'created_at' => $ordine_salvato['created_at'],
            'numero_prodotti' => count($items),
            'timestamp' => date('Y-m-d H:i:s')
        ]
    ]);
    
} catch (Exception $e) {
    if (isset($conn) && $conn) {
        mysqli_close($conn);
    }
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s'),
        'user' => $_SESSION['username'] ?? 'N/A'
    ]);
}
?>