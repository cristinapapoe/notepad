<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>note pad</title>
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
        .dropdown {
            position: absolute;
            top: 140px; 
            left: 10px;
            font-family: Comfortaa;
        }
        .dropdown button {
            background-color: #3B3738;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-family: Comfortaa;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #3B3738;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 25px;
            font-family: Comfortaa;
        }
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-radius: 25px;
            font-size: 1.2em;
        }
        .dropdown-content a:hover {
            background-color: #544d4f;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .settings {
            position: absolute;
            top: 210px; 
            left: 10px;
            font-family: Comfortaa;
        }
        .settings button {
            background-color: #3B3738;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-family: Comfortaa;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .settings button:hover {
            background-color: #544d4f;
        }
        .logout {
            position: absolute;
            top: 280px; 
            left: 10px;
            font-family: Comfortaa;
        }
        .logout button {
            background-color: #3B3738;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-family: Comfortaa;
            font-size: 1.2em;
        }
        .logout button:hover {
            background-color: #544d4f;
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
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: Comfortaa;
        }
        .header button {
            background-color: #3B3738;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-family: Comfortaa;
            font-size: 1.2em;
        }
        .header button:hover {
            background-color: #3B3738;
            font-family: Comfortaa;
        }
        .notes-list {
            margin-top: 20px;
        }
        .note {
            background-color: #FBFAF5;
            padding: 10px;
            margin: 10px 0;
            border-radius: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: Comfortaa;
        }
        .note-content {
            flex-grow: 1;
            margin-right: 10px;
            font-family: Comfortaa;
        }
        .note-actions button {
            background-color: rgb(255, 119, 119);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 25px;
            cursor: pointer;
            font-family: Comfortaa;
        }
        .note-actions button:hover {
            background-color: red;
            font-family: Comfortaa;
        }
        .note-editor {
            display: none;
            flex-direction: column;
            font-family: Comfortaa;
        }
        .note-editor textarea {
            width: 100%;
            height: 200px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 25px;
            font-family: Comfortaa;
        }
        .note-editor .save-button {
            align-self: flex-end;
            background-color: #544d4f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-family: Comfortaa;
        }
        .note-editor .save-button:hover {
            background-color: #3B3738;
            font-family: Comfortaa;
        }
    </style>
   
</head>
<body>
    <div class="greeting">buna, <?php echo htmlspecialchars($username); ?> <img src="funda.png" alt="fundita" height="25" width="25"></div>
    
    <div class="dropdown">
        <button>meniu</button>
        <div class="dropdown-content">
            <a href="notepad.php">note pad</a>
            <a href="calendar.php">calendar</a>
        </div>
    </div>

    <div class="settings">

       <a href="settings.php"> <button>setari</button></a>
    </div>

    <div class="logout">
        <form action="logout.php" method="post">
            <button type="submit">logout</button>
        </form>
    </div>

    <div class="container">
        <div class="header">
            <h1>note pad</h1>
            <button onclick="createNewNote()">+ notita noua</button>
        </div>
        <div class="notes-list" id="notesList"></div>
        <div class="note-editor" id="noteEditor">
            <textarea id="noteContent"></textarea>
            <button class="save-button" onclick="saveNote()">salveaza</button>
        </div>
    </div>

    <script>
        let notes = [];
        let currentNoteIndex = null;

        function createNewNote() {
            currentNoteIndex = null;
            document.getElementById('noteContent').value = '';
            document.getElementById('noteEditor').style.display = 'flex';
        }

        function editNote(index) {
            currentNoteIndex = index;
            document.getElementById('noteContent').value = notes[index];
            document.getElementById('noteEditor').style.display = 'flex';
        }

        function saveNote() {
            const content = document.getElementById('noteContent').value;
            if (currentNoteIndex === null) {
                notes.push(content);
            } else {
                notes[currentNoteIndex] = content;
            }
            document.getElementById('noteEditor').style.display = 'none';
            renderNotes();
        }

        function deleteNote(index) {
            notes.splice(index, 1);
            renderNotes();
        }

        function renderNotes() {
            const notesList = document.getElementById('notesList');
            notesList.innerHTML = '';
            notes.forEach((note, index) => {
                const noteElement = document.createElement('div');
                noteElement.className = 'note';
                noteElement.innerHTML = `
                    <div class="note-content">${note}</div>
                    <div class="note-actions">
                        <button onclick="editNote(${index})">editeaza</button>
                        <button onclick="deleteNote(${index})">sterge</button>
                    </div>
                `;
                notesList.appendChild(noteElement);
            });
        }

        renderNotes();
    </script>
</body>
</html>
