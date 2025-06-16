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
    <title>Calendar</title>
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
            font-size: 1.8em;
            color: black;
            font-weight: 700;
            font-family: Comfortaa;
        }
        .dropdown {
            position: absolute;
            top: 140px; 
            left: 10px;
        }
        .dropdown button {
            background-color: #3B3738;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1.2em;
            margin-bottom: 10px;
            font-family: Comfortaa;
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
            font-family: Comfortaa;
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
            font-size: 1.2em;
            margin-bottom: 10px;
            font-family: Comfortaa;
        }
        .settings button:hover {
            background-color: #544d4f;
        }
        .logout {
            position: absolute;
            top: 280px; 
            left: 10px;

        }
        .logout button {
            background-color: #3B3738;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1.2em;
            font-family: Comfortaa;
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
            border: 2px solid black;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header button {
            background-color: #3B3738;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
        }
        .header button:hover {
            background-color: #544d4f;
        }
        .header h1 {
            color: white;
            font-size: 2em;
        }
        .calendar-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .header-row {
            font-weight: bold;
        }
        .calendar-cell {
            flex: 1;
            text-align: center;
            padding: 10px;
            background-color: #FBFAF5;
            border: 1px solid #ccc;
            margin: 2px;
            border-radius: 8px;
        }
        .header-cell {
            background-color: #3B3738;
            color: white;
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
            <button onclick="previousMonth()">&lt;</button>
            <h1 id="monthYear"></h1>
            <button onclick="nextMonth()">&gt;</button>
        </div>
        <div id="calendar"></div>
    </div>

    <script>
        const monthNames = [
            "Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie",
            "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"
        ];

        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();

        function generateCalendar(month, year) {
            const daysOfWeek = ['Duminică', 'Luni', 'Marți', 'Miercuri', 'Joi', 'Vineri', 'Sâmbătă'];
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';

            const date = new Date(year, month);
            const firstDay = date.getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();

            
            document.getElementById('monthYear').innerText = `${monthNames[month]} ${year}`;

           
            const headerRow = document.createElement('div');
            headerRow.className = 'calendar-row header-row';
            daysOfWeek.forEach(day => {
                const cell = document.createElement('div');
                cell.className = 'calendar-cell header-cell';
                cell.innerText = day;
                headerRow.appendChild(cell);
            });
            calendar.appendChild(headerRow);

           
            let currentDay = 1;
            for (let i = 0; i < 6; i++) {
                const row = document.createElement('div');
                row.className = 'calendar-row';
                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('div');
                    cell.className = 'calendar-cell';

                    if ((i === 0 && j < firstDay) || currentDay > lastDate) {
                        cell.innerText = '';
                    } else {
                        cell.innerText = currentDay;
                        currentDay++;
                    }
                    row.appendChild(cell);
                }
                calendar.appendChild(row);
            }
        }

        function previousMonth() {
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            generateCalendar(currentMonth, currentYear);
        }

        function nextMonth() {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            generateCalendar(currentMonth, currentYear);
        }

        
        generateCalendar(currentMonth, currentYear);
    </script>
</body>
</html>
