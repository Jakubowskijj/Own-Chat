<!DOCTYPE html>
<html>
<head>
    <title>Strona Główna</title>
    <style>
         .tab {
            text-align: center;
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            text-align: center; /* Wyśrodkowanie treści */
        }

        .tab button {
            background-color: #4CAF50; /* Zielony kolor */
            color: white;
            border: none;
            outline: none;
            cursor: pointer; /* daje wskaźjik */
            padding: 32px 64px; /* Zwiększenie rozmiaru przycisku */
            transition: 0.3s;
            font-size: 16px;
            margin: 10px auto 20px; /* Odstęp od góry i dołu, automatyczne centrowanie */
            display: inline-block; /* Zamienia przycisk na blokowy, aby wyśrodkować */
            border-radius: 5px;
        }

         .tab button:hover {
            
            background-color: #45a049; /* Ciemniejszy odcień zielonego koloru po najechaniu */
        }

        .tab button.active {
            text-align: center;
            background-color: #ccc;
            color: black;
        }

        /* Styl nagłówka */
        .header {
            text-align: center;
            margin-bottom: 90px;
            background-image: linear-gradient(to right, violet, indigo, blue, green, orange, red);
            -webkit-background-clip: text;
            color: transparent;
            font-size: 48px; /* Powiększenie rozmiaru tekstu */
            
           
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Witajcie w naszym czacie!</h2>
    <p>Po kliknięciu przycisku możecie zacząć.</p>
</div>
 

<div class="tab">

    <a href="wybor.php"><button class="tablinks">CHAT</button></a>
</div>


</body>
</html>
