<?php
session_start();

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "notepad";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        $email = htmlspecialchars($_POST['email']);

        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $username;
            header("Location: notepad.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if (isset($_POST['login'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                header("Location: notepad.php");
                exit();
            } else {
                echo "parola invalida. incercati din nou.";
            }
        } else {
            echo "nu exista utilizator cu acest nume.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>note pad</title>
    <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet'>
    
    <style>
        body {
            font-family: Comfortaa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #FFDAD8;
        }
        .container {
            text-align: center;
            font-family: Comfortaa;
        }
        .form-container {
            display: none;
        }
        .form-container.active {
            display: block;
        }
        .form-input {
            margin: 10px 0;
            font-family: Comfortaa;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            padding: 10px;
            width: 80%;
            margin: 10px 0;
            box-sizing: border-box;
            border-radius: 25px;
            outline: none;
            font-family: Comfortaa;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #616161;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 25px;
            outline: none;
            font-family: Comfortaa;
        }
        .toggle-button {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
            font-family: Comfortaa;
        }
    </style>

</head>
<body>
    <div class="container" id="welcome-container">
        <h1>note pad <img src="funda.png" alt="fundita" height="25" width="25"></h1>
        <div id="login-form-container" class="form-container active">
            <h2>conecteaza-te</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-input">
                    <input type="text" name="username" placeholder="nume" required>
                </div>
                <div class="form-input">
                    <input type="password" name="password" placeholder="parola" required>
                </div>
                <div class="form-input">
                    <input type="submit" name="login" value="gata">
                </div>
            </form>
            <p>nu ai un cont inca? <span class="toggle-button" onclick="toggleForms()">inregistreaza-te aici!</span></p>
        </div>
        <div id="register-form-container" class="form-container">
            <h2>inregistreaza-te</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-input">
                    <input type="text" name="username" placeholder="nume" required>
                </div>
                <div class="form-input">
                    <input type="password" name="password" placeholder="parola" required>
                </div>
                <div class="form-input">
                    <input type="email" name="email" placeholder="email" required>
                </div>
                <div class="form-input">
                    <input type="submit" name="register" value="gata">
                </div>
            </form>
            <p>ai deja un cont? <span class="toggle-button" onclick="toggleForms()">conecteaza-te aici!</span></p>
        </div>
    </div>

    <script>
        function toggleForms() {
            document.getElementById('login-form-container').classList.toggle('active');
            document.getElementById('register-form-container').classList.toggle('active');
        }
    </script>
</body>
</html>
