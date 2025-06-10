<?php
    include 'auth.php';
    if (checkAuth()) {
        header('Location: index.php');
        exit;
    }


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"], $_POST["password"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    //connessione
    $conn = new mysqli($db['host'], $db['user'], $db['password'], $db['name']);
    if ($conn->connect_error) {
        $_SESSION["error"] = "Errore di connessione al database";
        header("Location: login.php");
        exit;
    }

    $query = "SELECT email , id , username, password FROM users WHERE email = '".$email."'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;

     if (mysqli_num_rows($res) > 0) {
        $user = $res->fetch_assoc();
        
        // Verifica la password hashata
        if (password_verify($password, $user["password"])) {
            $_SESSION["email"] = $user["username"];
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: index.php");
            exit;
        }
    }
    mysqli_free_result($res);
    mysqli_close($conn);
    $_SESSION["error"] = "Username o password errati!";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
</head>
<body>
      <nav class="navbar">
        <div class="headertop">
            <a class="home" href="index.php">
            </a>

        <button class="bottone">
            <a class="headerlink"  href="register.php">
                <svg class="imgxmlheader">
                    <path d="M3 10L5 8.44444V5H9.42857L12 3L21 10V21H3V10ZM14 19H19V10.9782L12 5.53372L5 10.9782V19H10V14H14V19Z">
                    </path>
                </svg>
                <p class="testoheader">Non hai un account? Registrati</p>  
            </a>
            </button>
        </div>
       </nav>

    <div class="login-wrapper">
        <div class="login-container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="login-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <h2 class="login-title">Accedi al tuo account</h2>

            <form method="POST" action="login.php" class="login-form">
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>