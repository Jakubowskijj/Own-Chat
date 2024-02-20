<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <style>
        /* Dodatkowe style dla nagłówka i zawartości czatu */
        body {
            background-color: #f2f2f2; /* Szare tło */
            font-family: Arial, sans-serif; /* Wybrana czcionka */
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
            color: #333; /* Kolor tekstu */
            font-size: 36px; /* Mniejszy rozmiar tekstu */
        }
      
        .tabcontent {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-top: none;
            background-color: #fff; /* Tło białe */
            border-radius: 5px; /* Zaokrąglenie rogów */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Cień */
        }

        .back-btn {
            text-align: center;
            margin-top: 5px;
        }

        .back-btn a {
            display: inline-block;
            padding: 10px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-btn a:hover {
            background-color: #45a049;
        }

        .chat-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            height: 200px;
            overflow-y: scroll;
            background-color: #fff; /* Tło białe */
            border-radius: 5px; /* Zaokrąglenie rogów */
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1); /* Cień wewnętrzny */
            width: 60%; /* Zmniejszona szerokość czatu */
            margin-left: auto; /* Ustawienie czatu na środku strony */
            margin-right: auto; /* Ustawienie czatu na środku strony */
        }

        /* Styl dla formularza */
        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column; /* Ułożenie w kolumnie */
            align-items: center;
        }

        label {
            margin-bottom: 5px;
            color: #333; /* Kolor tekstu */
        }

        input[type="text"] {
            width: 80%; /* Szerokość pola tekstowego */
            padding: 8px;
            border-radius: 5px;
        }

        .message {
            margin-bottom: 10px;
            overflow: hidden;
        }

        .message .sender {
            float: right;
            background-color: #ddf0f7;
            padding: 5px 10px;
            border-radius: 10px;
            margin-left: 20px;
        }

        .message .receiver {
            float: left;
            background-color: #d1e8d8;
            padding: 5px 10px;
            border-radius: 10px;
            margin-right: 20px;
        }

       
        .user-icon-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
        .user-icon {
            width: 100px; /* Szerokość ikony */
            height: 100px; /* Wysokość ikony */
            border-radius: 50%; /* Okrągły kształt */
            cursor: pointer; /* Zmiana kształtu kursora po najechaniu */
            margin: 10px; /* Margines wokół ikon */
        }
        .user-caption {
            margin-top: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Chat</h2>
</div>

<div id="Tab1" class="tabcontent">
    <div class="user-icon-container">
        <?php
        // Dane do połączenia z bazą danych
        $servername = "localhost";
        $username = "root";
        $dbname = "chat";

        // Utworzenie połączenia
        $conn = new mysqli($servername, $username, "", $dbname) or die("blad");

        // Pobranie imion użytkowników z bazy danych
        $sql_users = "SELECT imie FROM imie";
        $result_users = $conn->query($sql_users);

        // Wyświetlenie ikon użytkowników z imionami z bazy danych
        if ($result_users->num_rows > 0) {
            while($row = $result_users->fetch_assoc()) {
                $userName = $row["imie"];
                echo "<div>
                        <a href='?user=$userName'>
                            <img class='user-icon' src='$userName.jpg' alt='$userName'>
                        </a>
                        <span class='user-caption'>$userName</span>
                      </div>";
            }
        } else {
            echo "Brak użytkowników.";
        }
        ?>
    </div>

    <?php
    $selectedRecipient = isset($_GET['recipient']) ? $_GET['recipient'] : '';
    ?>

    <form method="post" action="">
    <label for="rozmowca_id">Wybierz nadawcę:</label><br>
    <select name="rozmowca_id" id="rozmowca_id">
        <?php
        // Wyświetlenie opcji nadawców z imionami z bazy danych
        $result_users->data_seek(0); // Przywrócenie wskaźnika wyników zapytania do początku
        while ($row = $result_users->fetch_assoc()) {
            $userName = $row["imie"];
            echo "<option value='$userName'>$userName</option>";
        }
        ?>
    </select><br><br>

    <label for="odbiorca">Wybierz odbiorcę:</label><br>
    <select name="odbiorca" id="odbiorca">
        <!-- Odbiorca jest wybierany dynamicznie na podstawie nadawcy -->
    </select><br><br>

    <label for="tekst">Wpisz wiadomość:</label><br>
    <input type="text" id="tekst" name="tekst"><br><br>

    </form>

    <?php
        //################################################################################################################################WYSYLANIE
    // Dane do połączenia z bazą danych
    $servername = "localhost";
    $username = "root";
    $dbname = "chat";

    // Utworzenie połączenia
    $conn = new mysqli($servername, $username, "", $dbname) or die("blad");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rozmowca_id']) && isset($_POST['odbiorca'])) {
    $nadawca_id = $_POST['rozmowca_id'];
    $odbiorca = $_POST['odbiorca'];
    $tekst = $_POST['tekst'];

    // Zapytanie SQL do wybrania nadawcy na podstawie ID z tabeli "imie"
    $sql_select_nadawca = "SELECT id FROM imie WHERE imie = '$nadawca_id'";
    $result_nadawca = $conn->query($sql_select_nadawca);

    if ($result_nadawca && $result_nadawca->num_rows > 0) {
        $row_nadawca = $result_nadawca->fetch_assoc();
        $nadawca_id = $row_nadawca['id']; // ID nadawcy na podstawie imienia

        // Zapytanie SQL do wybrania odbiorcy na podstawie ID z tabeli "imie"
        $sql_select_odbiorca = "SELECT id FROM imie WHERE imie = '$odbiorca'";
        $result_odbiorca = $conn->query($sql_select_odbiorca);

        if ($result_odbiorca && $result_odbiorca->num_rows > 0) {
            $row_odbiorca = $result_odbiorca->fetch_assoc();
            $odbiorca_id = $row_odbiorca['id']; // ID odbiorcy na podstawie imienia

            // Zapisanie wiadomości do tabeli "wiadomosci" z numerem nadawcy i odbiorcy
            $sql_insert_wiadomosc = "INSERT INTO wiadomosci (nadawca, odbiorca, tekst) VALUES ('$nadawca_id', '$odbiorca_id', '$tekst')";

            if ($conn->query($sql_insert_wiadomosc) === TRUE) {
                echo "Wiadomość została zapisana pomyślnie.";
            } else {
                echo "Błąd podczas zapisywania wiadomości: " . $conn->error;
            }
        } else {
            echo "Brak użytkownika o podanym ID odbiorcy.";
            exit(); // Wyjście z kodu w przypadku braku użytkownika
        }
    } else {
        echo "Brak użytkownika o podanym ID nadawcy.";
        exit(); // Wyjście z kodu w przypadku braku użytkownika
    }
}
    //################################################################################################################################WYSYLANIE
    ?>

    <div class="back-btn">
        <a href="str.php">Powrót do strony głównej</a>
    </div>
</div>

<div class="chat-box">

<?php
        // Odczytanie wybranych nadawcy i odbiorcy
        $nadawca = isset($_POST['rozmowca_id']) ? $_POST['rozmowca_id'] : '';
        $odbiorca = isset($_POST['odbiorca']) ? $_POST['odbiorca'] : '';

        // Odczytanie historii wiadomości między nadawcą i odbiorcą z bazy danych
        $servername = "localhost";
        $username = "root";
        $password = ""; // Twoje hasło
        $dbname = "chat";

        // Utworzenie połączenia
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Zapytanie SQL do pobrania historii wiadomości
        $sql_messages = "SELECT imie.imie, wiadomosci.tekst FROM wiadomosci 
                 INNER JOIN imie ON wiadomosci.nadawca = imie.id 
                 WHERE 
                 (nadawca = (SELECT id FROM imie WHERE imie = '$nadawca') 
                 AND odbiorca = (SELECT id FROM imie WHERE imie = '$odbiorca')) 
                 OR 
                 (nadawca = (SELECT id FROM imie WHERE imie = '$odbiorca') 
                 AND odbiorca = (SELECT id FROM imie WHERE imie = '$nadawca')) 
                 ORDER BY wiadomosci.id"; // Dodanie aliasu 'wiadomosci' dla kolumny 'id'

$result_messages = $conn->query($sql_messages);
        if ($result_messages === false) {
            echo "Error: " . $conn->error;
        } else {
            if ($result_messages->num_rows > 0) {
                while ($row = $result_messages->fetch_assoc()) {
                    $sender = $row['imie'];
                    $message = $row['tekst'];
                    
                    // Sprawdzenie czy nadawca jest równy wybranemu nadawcy, aby wyświetlić odpowiedni styl dla wiadomości
                    $messageClass = ($sender === $nadawca) ? 'sender' : 'receiver';
                    echo "<div class='message'><span class='$messageClass'>$sender:</span> $message</div>";
                }
            } else {
                echo "Brak wiadomości.";
            }
        }

        $conn->close();
        ?>
     </div>

<script>
    // Funkcja aktualizująca listę odbiorców w zależności od wybranego nadawcy
    function selectUser(selected) {
    const select = document.getElementById('odbiorca');
    const options = select.getElementsByTagName('option');

    // Usuń wszystkie opcje
    while (select.firstChild) {
        select.removeChild(select.lastChild);
    }

    // Stwórz nowe opcje na podstawie wybranego nadawcy
    const users = ['Maciej', 'Kuba', 'Marek'];
    const index = users.indexOf(selected);
    for (let i = 0; i < users.length; i++) {
        if (i !== index) {
            const option = document.createElement('option');
            option.value = users[i];
            option.text = users[i];
            select.appendChild(option);
        }
    }

    // Ustaw wartość recipient
    const recipientInput = document.getElementById('odbiorca');
    recipientInput.value = selectedUser;
}

    // Funkcja, która wywołuje się po załadowaniu strony
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const selectedUser = urlParams.get('user');

        const select = document.getElementById('rozmowca_id');
        select.value = selectedUser; // Ustawienie wartości nadawcy

        selectUser(selectedUser); // Aktualizacja listy odbiorców
    };
</script>

</body>
</html>