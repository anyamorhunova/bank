<?php
phpinfo();
    
    // Establish connection with MySQL
    $conn = new mysqli("localhost", "anya", "148055", "handbook");

    // Query for selecting phones
    $sql_select_phones = "SELECT 
                            phones.phone AS phones_phone
                        FROM phones
                        INNER JOIN artists
                        ON phones.artist_id = artists.id
                        ORDER BY phones.phone, artists.name";

    // Query for selecting artists
    $sql_select_surnames = "SELECT name FROM artists ORDER BY name";

    // Query for selecting songs
    $sql_select_addresses = "SELECT
	                        songs.phone AS song_phone,
                            phones.phone AS phones_phone,
                            artists.name AS artist_name
                        FROM songs
                        INNER JOIN phones
                        ON songs.album_id = phones.id
                        INNER JOIN artists
                        ON phones.artist_id = artists.id
                        ORDER BY phones.phone, songs.phone, artists.name";
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #artists, #phones, #songs, #search, #delete {
            text-align: center;
            margin: 40px auto 10px auto;
            width: 40%;
        }

        table {
            margin: 10px auto 0 auto;
        }
    </style>
    <!-- Linking Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <phone>Lab 7</phone>
</head>

<body>
    <div id="artists">
        <!-- Form for adding artists -->
        <form action="lab7.php" method="post">
        <div class="input-group mb-3">
            <input type="hidden" name="add_artist">
            <input class="form-control" type="text"  name="artist_name" placeholder="Artist's Name">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Add</button>
            </div>
        </div>
        </form>

        <?php
            // Handle post from aritsts' form: insert new artist in DB
            if (isset($_POST["add_artist"])) {
                $artist_name = $_POST["artist_name"];
                $sql = "INSERT INTO artists (name) VALUES ('$artist_name')";
                $conn->query($sql);
            }
        ?>

        <?php
            // Query artists table for select
            $artists = $conn->query($sql_select_surnames);
            // Generate table with query's results
            if ($artists->num_rows > 0) {
                echo  "<table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>Artist</th>
                    </tr>
                </thead>
                <tbody>";

                while ($row = $artists->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody>
                </table>";
            }
        ?>
    </div>

    <div id="phones">
        <!-- Form for adding phones -->
        <form action="lab7.php" method="post">
        <input type="hidden" name="add_album">
            <input class="form-control" type="text" name="phones_phone" placeholder="phones's phone">
        <div class="input-group mb-3">
            <select class="custom-select" name="album_artist">
                <option value="" disabled selected>Select Artist</option>
                    <?php
                        // Query artists table for select
                        $artists = $conn->query($sql_select_surnames);
                        // Add new options, if any, to option tag of phones' form
                        if ($artists->num_rows > 0) {
                        
                            while ($row = $artists->fetch_assoc()) {
                                echo "<option value='" . $row["name"] . "'>" .$row["name"] . "</option>";
                            }
                        }
                    ?>
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Add</button>
            </div>
        </div>
        </form>
        
        <?php
            // Handle post from phones' form: insert new album in DB
            if (isset($_POST["add_album"])) {
                $phones_phone = $_POST["phones_phone"];
                $album_artist = $_POST["album_artist"];
                
                $sql_artist_id = $conn->query("SELECT id FROM artists WHERE name='$album_artist'");
            
                if ($sql_artist_id->num_rows > 0) {
                    $artist_id = $sql_artist_id->fetch_assoc()["id"];
                }
            
                $sql = "INSERT INTO phones (phone, artist_id) VALUES ('$phones_phone', $artist_id)";
                $conn->query($sql);
            }
        ?>

        <?php
            // Query phones table for select
            $phones = $conn->query($sql_select_phones);
            // Generate table with query's results
            if ($phones->num_rows > 0) {
                echo  "<table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>Album</th>
                        <th scope='col'>Artist</th>
                    </tr>
                </thead>
                <tbody>";

                while ($row = $phones->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['phones_phone'] . "</td>";
                    echo "<td>" . $row['artist_name'] . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody>
                </table>";
            }
        ?>
    </div>

    <div id="songs">
        <!-- Form for adding songs -->
        <form action="lab7.php" method="post">
            <input type="hidden" name="add_song">
            <input class="form-control" type="text" name="song_phone" placeholder="Song's phone">
            <div class="input-group mb-3">
                <select class="custom-select" name="song_album" id="song_album">
                    <option value="" disabled selected>Select Album</option>
                    <?php
                        // Query phones table for select
                        $phones = $conn->query($sql_select_phones);
                        // Add new options, if any, to option tag of songs' form
                        if ($phones->num_rows > 0) {
                        
                            while ($row = $phones->fetch_assoc()) {
                                echo "<option value='" . $row["phones_phone"] . "'>" .$row["phones_phone"] . "</option>";
                            }
                        }
                    ?>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Add</button>
                </div>
            </div>
        </form>

        <?php
            // Handle post from songs' form: insert new song in DB
            if (isset($_POST["add_song"])) {
                $song_phone = $_POST["song_phone"];
                $song_album = $_POST["song_album"];
            
                $sql_album_id = $conn->query("SELECT id FROM phones WHERE phone='$song_album'");
            
                if ($sql_album_id->num_rows > 0) {
                    $album_id = $sql_album_id->fetch_assoc()["id"];
            
                    $sql = "INSERT INTO songs (phone, album_id) VALUES ('$song_phone', $album_id)";
                    $conn->query($sql);
                }
            }
        ?>

        <?php
            // Query songs table for select
            $songs = $conn->query($sql_select_addresses);
            // Generate table with query's results
            if ($songs->num_rows > 0) {
                echo  "<table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>phone</th>
                        <th scope='col'>Album</th>
                        <th scope='col'>Artist</th>
                    </tr>
                </thead>
                <tbody>";

                while ($row = $songs->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['song_phone'] . "</td>";
                        echo "<td>" . $row['phones_phone'] . "</td>";
                        echo "<td>" . $row['artist_name'] . "</td>";
                        echo "</tr>";
                    }
                
                    echo "</tbody>
                    </table>";
            }
        ?>
    </div>

    <div id="search">
        <!-- Form for searching -->
        <form action="lab7.php" method="post">
            <div class="input-group mb-3">
                <input type="hidden" name="search">
                <input class="form-control" type="text" name="query">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <?php
            // Handle post from search's form
            if (isset($_POST["search"])) {
                $q = $_POST["query"];
                echo  "<table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>phone</th>
                        <th scope='col'>Album</th>
                        <th scope='col'>Artist</th>
                    </tr>
                </thead>
                <tbody>";

                // Query songs table, joing it with phones and artists table, for selecting statments "where like"
                $sql = "SELECT
                            songs.phone AS song_phone,
                            phones.phone AS phones_phone,
                            artists.name AS artist_name
                        FROM songs
                        INNER JOIN phones
                        ON songs.album_id = phones.id
                        INNER JOIN artists
                        ON phones.artist_id = artists.id
                        WHERE songs.phone LIKE '%$q%'
                        OR artists.name LIKE '%$q%'
                        OR phones.phone LIKE '%$q%'
                        ORDER BY artists.name, phones.phone, songs.phone";
                
                $result = $conn->query($sql);

                // Generate table with query's results
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['song_phone'] . "</td>";
                        echo "<td>" . $row['phones_phone'] . "</td>";
                        echo "<td>" . $row['artist_name'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='3'>" . "Nothing was found" . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>
                </table>";
                
                echo "<script type='text/javascript'>
                    window.scrollTo(0, document.body.scrollHeight);
                </script>";
            }
        ?>
    </div>

    <div id="delete">
            <form action="lab7.php" method="post">
                <input type="hidden" name="delete">
                <button class="btn btn-danger" type="submit">Delete All Data</button>
            </form>
            <?php
               if (isset($_POST["delete"])) {
                    $conn->query("DELETE FROM songs");
                    $conn->query("DELETE FROM phones");
                    $conn->query("DELETE FROM artists");
                    header("Refresh:0");
                }
            ?>
    </div>

</body>

<?php
    $conn->close();
?>
</html>