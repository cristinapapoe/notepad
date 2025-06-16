<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>setari</title>
    <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet'>

    <style>
    body {
    font-family: Comfortaa;
    margin: 0;
    padding: 0;
    background-color: #FFDAD8;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    position: relative;
}
.greeting {
    position: absolute;
    top: 10px;
    left: 10px;
    font-family: Comfortaa;
    font-size: 1.8em;
    color: black;
    font-weight: 700;
}
.container {
    width: 80%;
    max-width: 800px;
    background-color: #818181;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 25px;
    font-family: Comfortaa;
    border: 2px solid black;
    margin-top: 20px;
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: Comfortaa;
    margin-bottom: 20px;
}
.header h1 {
    font-size: 1.5em;
    color: white;
}
.back-button {
    background-color: #3B3738;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-family: Comfortaa;
}
.back-button:hover {
    background-color: #544d4f;
}
.settings-list {
    font-size: 1.2em;
    color: white;
    margin-bottom: 20px;
}
.settings-list li {
    margin-bottom: 10px;
}
.setting-label {
    font-weight: bold;
}
</style>
     
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }
    $username = $_SESSION['username'];
    ?>
    <div class="greeting">buna, <?php echo htmlspecialchars($username); ?> <img src="funda.png" alt="fundita" height="25" width="25"></div>
    
    <div class="container">
        <div class="header">
            <h1>setari</h1>
            <a href="notepad.php"><button class="back-button">inapoi la notite</button></a>
        </div>
        <ul class="settings-list">
            <li>
                <span class="setting-label">nume site:</span> note pad
            </li>
            <li>
                <span class="setting-label">versiune:</span> 1.0
            </li>
            <li>
                <span class="setting-label">limba:</span> romana
            </li>
            <li>
                <span class="setting-label">tema:</span> light
            </li>
        </ul>
    </div>
</body>
</html>
