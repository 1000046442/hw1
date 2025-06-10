<?php
include '../pagine/auth.php';
if (!checkAuth()) {
    header('Location: index.php');
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Metodo non consentito'
    ]);
    exit;
}

$required_fields = ['nome', 'cognome'];
$errors = [];

foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $errors[] = ucfirst($field) . " è obbligatorio";
    }
}

if (!empty($_POST['cap']) && !preg_match('/^[0-9]{5}$/', $_POST['cap'])) {
    $errors[] = "Il CAP deve essere di 5 cifre";
}

if (!empty($_POST['telefono']) && !preg_match('/^[\+]?[0-9\s\-\(\)]{8,20}$/', $_POST['telefono'])) {
    $errors[] = "Formato telefono non valido";
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => implode(', ', $errors),
        'errors' => $errors
    ]);
    exit;
}

try {

    $conn = new mysqli('localhost', 'root', '', 'webprogramming');
    if ($conn->connect_error) {
        throw new Exception("Connessione fallita: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    
    $query = "SELECT id FROM user_information WHERE id_cliente = '".$conn->real_escape_string($user_id)."'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $existing = $res->fetch_assoc();

    $data = [
        'nome' => $conn->real_escape_string(trim($_POST['nome'])),
        'cognome' => $conn->real_escape_string(trim($_POST['cognome'])),
        'data_nascita' => !empty($_POST['data_nascita']) ? $conn->real_escape_string($_POST['data_nascita']) : null,
        'telefono' => !empty($_POST['telefono']) ? $conn->real_escape_string($_POST['telefono']) : null,
        'indirizzo' => !empty($_POST['indirizzo']) ? $conn->real_escape_string($_POST['indirizzo']) : null,
        'citta' => !empty($_POST['citta']) ? $conn->real_escape_string($_POST['citta']) : null,
        'CAP' => !empty($_POST['cap']) ? $conn->real_escape_string($_POST['cap']) : null,
        'provincia' => !empty($_POST['provincia']) ? $conn->real_escape_string($_POST['provincia']) : null,
        'paese' => !empty($_POST['paese']) ? $conn->real_escape_string($_POST['paese']) : null
    ];

    if ($existing) {
        // UPDATE
        $query = "UPDATE user_information SET 
                 nome = '".$data['nome']."', 
                 cognome = '".$data['cognome']."',
                 data_nascita = '".$data['data_nascita']."',
                 telefono = '".$data['telefono']."',
                 indirizzo = '".$data['indirizzo']."',
                 citta = '".$data['citta']."',
                 CAP = '".$data['CAP']."',
                 provincia = '".$data['provincia']."',
                 paese = '".$data['paese']."',                                                   
                 updated_at = CURRENT_TIMESTAMP
                 WHERE id_cliente = '".$conn->real_escape_string($user_id)."'";
    } else {
        // INSERT
        $query = "INSERT INTO user_information 
                 (id_cliente, nome, cognome, data_nascita, telefono, indirizzo, citta, CAP, provincia, paese, created_at, updated_at) 
                 VALUES (
                    '".$conn->real_escape_string($user_id)."',
                    '".$data['nome']."',
                    '".$data['cognome']."',
                    '".$data['data_nascita']."',
                    '".$data['telefono']."',
                    '".$data['indirizzo']."',
                    '".$data['citta']."', 
                    '".$data['CAP']."',
                    '".$data['provincia']."', 
                    '".$data['paese']."',
                    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
    }

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $conn->close();
    echo json_encode([
        'success' => true,
        'message' => 'Informazioni salvate con successo!'
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Errore durante il salvataggio'
    ]);
}
?>





