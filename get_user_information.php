<?php
include '../pagine/auth.php';
if (!checkAuth()) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non autorizzato']);
    exit;
}

header('Content-Type: application/json');

try {
    $conn = new mysqli('localhost', 'root', '', 'webprogramming');
    if ($conn->connect_error) {
        throw new Exception("Connessione fallita: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];

    $query = "SELECT nome, cognome, data_nascita, telefono, indirizzo, citta, CAP, provincia, paese 
              FROM user_information 
              WHERE id_cliente = '".$conn->real_escape_string($user_id)."'";
    
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $user_data = $res->fetch_assoc();
    $conn->close();

    if ($user_data) {
        echo json_encode([
            'success' => true,
            'data' => $user_data
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Nessun dato trovato'
        ]);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Errore durante il recupero dei dati'
    ]);
}
?>