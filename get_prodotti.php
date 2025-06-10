<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Configurazione database
$host = 'localhost';
$dbname = 'webprogramming';
$username = 'root';
$password = '';

// Connessione con mysqli
$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore connessione database: ' . mysqli_connect_error()]);
    exit;
}

// Imposta charset
mysqli_set_charset($conn, 'utf8');

$action = $_GET['action'] ?? '';

switch($action) {
    case 'get_prodotti':
        getProdotti($conn);
        break;
    case 'get_categorie':
        getCategorie($conn);
        break;
    case 'get_negozi':
        getNegozi($conn);
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Azione non valida']);
}

mysqli_close($conn);

function getProdotti($conn) {
    try {
        // Parametri per filtri
        $filtri_categoria = $_GET['categorie'] ?? [];
        $filtri_negozio = $_GET['negozi'] ?? [];
        $ordinamento = mysqli_real_escape_string($conn, $_GET['ordinamento'] ?? 'nome');
        $pagina = (int)($_GET['pagina'] ?? 1);
        $per_pagina = (int)($_GET['per_pagina'] ?? 12);
        $offset = ($pagina - 1) * $per_pagina;
        
        // Costruzione query base
        $sql = "SELECT 
                    p.id,
                    p.nome,
                    p.prezzo,
                    p.descrizione,
                    p.immagine,
                    p.valutazione,
                    p.disponibile,
                    c.nome as categoria_nome,
                    c.id as categoria_id,
                    n.nome as negozio_nome,
                    n.codice as negozio_codice,
                    n.id as negozio_id
                FROM prodotti p
                JOIN categorie c ON p.id_categoria = c.id
                JOIN negozi n ON p.id_negozio = n.id
                WHERE p.disponibile = 1";
        
        // Filtro per categorie
        if (!empty($filtri_categoria) && is_array($filtri_categoria)) {
            $categoria_ids = array_map(function($id) use ($conn) {
                return "'" . mysqli_real_escape_string($conn, $id) . "'";
            }, $filtri_categoria);
            $sql .= " AND p.id_categoria IN (" . implode(',', $categoria_ids) . ")";
        }
        
        // Filtro per negozi
        if (!empty($filtri_negozio) && is_array($filtri_negozio)) {
            $negozio_ids = array_map(function($id) use ($conn) {
                return "'" . mysqli_real_escape_string($conn, $id) . "'";
            }, $filtri_negozio);
            $sql .= " AND p.id_negozio IN (" . implode(',', $negozio_ids) . ")";
        }
        
        // Ordinamento
        switch($ordinamento) {
            case 'prezzo-crescente':
                $sql .= " ORDER BY p.prezzo ASC";
                break;
            case 'prezzo-decrescente':
                $sql .= " ORDER BY p.prezzo DESC";
                break;
            case 'popolarita':
                $sql .= " ORDER BY p.valutazione DESC";
                break;
            case 'nome':
            default:
                $sql .= " ORDER BY p.nome ASC";
                break;
        }
        
        // Query per contare il totale (senza LIMIT)
        $count_sql = str_replace(
            'SELECT p.id, p.nome, p.prezzo, p.descrizione, p.immagine, p.valutazione, p.disponibile, c.nome as categoria_nome, c.id as categoria_id, n.nome as negozio_nome, n.codice as negozio_codice, n.id as negozio_id', 
            'SELECT COUNT(*)', 
            $sql
        );
        
        $count_result = mysqli_query($conn, $count_sql) or die(mysqli_error($conn));
        $totale_prodotti = mysqli_fetch_row($count_result)[0];
        mysqli_free_result($count_result);
        
        // Aggiunta paginazione
        $sql .= " LIMIT " . (int)$per_pagina . " OFFSET " . (int)$offset;
        
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        $prodotti = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $prodotti[] = $row;
        }
        
        mysqli_free_result($result);
        
        // Calcolo info paginazione
        $totale_pagine = ceil($totale_prodotti / $per_pagina);
        
        echo json_encode([
            'success' => true,
            'prodotti' => $prodotti,
            'paginazione' => [
                'pagina_corrente' => $pagina,
                'totale_pagine' => $totale_pagine,
                'totale_prodotti' => $totale_prodotti,
                'per_pagina' => $per_pagina
            ]
        ]);
        
    } catch(Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Errore nel recupero prodotti: ' . $e->getMessage()]);
    }
}

function getCategorie($conn) {
    try {
        $sql = "SELECT id, nome, descrizione, icona FROM categorie WHERE attiva = 1 ORDER BY nome";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        $categorie = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $categorie[] = $row;
        }
        
        mysqli_free_result($result);
        
        echo json_encode([
            'success' => true,
            'categorie' => $categorie
        ]);
        
    } catch(Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Errore nel recupero categorie: ' . $e->getMessage()]);
    }
}

function getNegozi($conn) {
    try {
        $sql = "SELECT 
                    n.id, 
                    n.nome, 
                    n.codice, 
                    n.descrizione
                FROM negozi n
                WHERE n.attivo = 1 
                ORDER BY n.nome";
        
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        $negozi = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $negozi[] = $row;
        }
        
        mysqli_free_result($result);
        
        echo json_encode([
            'success' => true,
            'negozi' => $negozi
        ]);
        
    } catch(Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Errore nel recupero negozi: ' . $e->getMessage()]);
    }
}
?>