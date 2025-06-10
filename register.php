<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$errors = [];

include 'auth.php';
if (checkAuth()) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register"])) {
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        $errors[] = "Tutti i campi sono obbligatori!";

    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Inserisci un'email valida!";
        header("Location: register.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION["error"] = "Le password non coincidono!";
        header("Location: register.php");
        exit;
    }

    if (strlen($password) < 8) {
        $errors[] = "deve essere lunga almeno 8 caratteri";
    }

    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = "deve contenere almeno un carattere speciale";
    }

    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "deve contenere almeno una lettera minuscola";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "deve contenere almeno una lettera maiuscola";
    }

    if (!empty($errors)) {
    $_SESSION["error"] = "La password " . implode(", ", $errors) . "!";
    header("Location: register.php");
    exit;
    }

    $conn = new mysqli($db['host'], $db['user'], $db['password'], $db['name']);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    $query = "SELECT email , id , username, password FROM users WHERE email = '".$email."'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;

    if ($res->num_rows > 0) {
        $_SESSION["error"] = "Email già registrata!";
        mysqli_free_result($res);
        mysqli_close($conn);
        header("Location: register.php");
        exit;
    }
    mysqli_free_result($res);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_query = "INSERT INTO users ( username,email, password) VALUES ('".$username."','".$email."','".$hashed_password."')"; 
    if (mysqli_query($conn, $insert_query)) {
        $_SESSION["success"] = "Registrazione completata!";
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["user_id"] = mysqli_insert_id($conn);
        $_SESSION["username"] = $_POST["username"];
        mysqli_close($conn);
        header("Location: account.php");
        exit;
    } else {
        $_SESSION["error"] = "Errore durante la registrazione: " . $conn->error;
        mysqli_close($conn);
        header("Location: register.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>Registrazione</title>
</head>
<body>
      <nav class="navbar">
        <div class="headertop">
            <a class="home" href="index.php">
            </a>

        <button class="bottone">
            <a class="headerlink" href="login.php">
                <svg class="imgxmlheader">
                    <path d="M3 10L5 8.44444V5H9.42857L12 3L21 10V21H3V10ZM14 19H19V10.9782L12 5.53372L5 10.9782V19H10V14H14V19Z">
                    </path>
                </svg>
                <p class="testoheader">Hai un account? Accedi</p>  
            </a>
            </button>
        </div>
       </nav>

    <div class="login-wrapper">
        <div class="login-container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="login-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <h2 class="login-title">Registrati</h2>

            <form method="POST" action="register.php" class="login-form">
                <input type="hidden" name="register" value="1">
                <input type="text" name="email" placeholder="E-mail" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Ripeti La Password" required>
                <button type="submit" class="login-btn">Registrati</button>
            </form>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
