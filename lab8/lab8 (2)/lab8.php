<?php

    session_start();
    // Credentials for MySQL
    $servername = "localhost";
    $username = "kpi";
    $password = "Rd94sMZxYDAdjyUs88LFhzs34HzA7KUG";
    $dbname = "kpi";
    
    // Establish connection with MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Query for selecting clients
    $sql_select_clients = "SELECT 
                            id,
                            name,
                            surname,
                            phone,
                            address
                           FROM clients";

    // Query for selecting credit type
    $sql_select_credit_type = "SELECT
                                    id,
                                    name,
                                    stavka,
                                    num_of_days 
                                FROM credit_type";

    // Query for selecting credit
    $sql_select_credit = "SELECT
	                        credit.id AS credit_id,
                            credit_type.name AS credit_name,
                            clients.id AS client_id,
                            sum,
                            date
                        FROM credit
                        INNER JOIN clients
                        ON credit.id_client = clients.id
                        INNER JOIN credit_type
                        ON credit.id_credit_type = credit_type.id";
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #user, #clients, #credit_type, #credit, #search {
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
    <title>Lab 8</title>
</head>

<body>
    <div id="user">
        <h4>User: <?php echo $_SESSION["user"]; ?> </h4>
    </div>
    <div id="clients">
        <!-- Form for adding clients -->
        <form action="lab8.php" method="post">
        <input class="form-control" type="text"  name="client_name" placeholder="Client's Name">
            <input class="form-control" type="text"  name="client_surname" placeholder="Client's Surname">
            <input class="form-control" type="text"  name="client_phone" placeholder="Client's Phone">
        <div class="input-group mb-3">
            <input type="hidden" name="add_client">
            <input class="form-control" type="text"  name="client_address" placeholder="Client's Address">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Add</button>
            </div>
        </div>
        </form>

        <?php
            // Handle post from clients' form: insert new client in DB
            if (isset($_POST["add_client"])) {
                $client_name = $_POST["client_name"];
                $client_surname = $_POST["client_surname"];
                $client_phone = $_POST["client_phone"];
                $client_address = $_POST["client_address"];
                $sql = "INSERT INTO clients (name, surname, phone, address) VALUES ('$client_name', ' $client_surname', '$client_phone', '$client_address')";
                $conn->query($sql);
            }
        ?>

        <?php
            // Query client table for select
            $clients = $conn->query($sql_select_clients);
            // Generate table with query's results
            if ($clients->num_rows > 0) {
                echo  "<table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Surname</th>
                        <th scope='col'>Phone</th>
                        <th scope='col'>Address</th>
                    </tr>
                </thead>
                <tbody>";

                while ($row = $clients->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['surname'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody>
                </table>";
            }
        ?>
    </div>

    <div id="credit_type">
        <!-- Form for adding credit type -->
        <form action="lab8.php" method="post">
        <input type="hidden" name="add_credit_type">
            <input class="form-control" type="text" name="credit_type_name" placeholder="Credit Type's Name">
            <input class="form-control" type="number" name="credit_type_stavka" placeholder="Credit Type's Stavka">
        <div class="input-group mb-3">
            <input class="form-control" type="number" name="credit_type_num_of_days" placeholder="Credit Type's Number Of Days">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Add</button>
            </div>
        </div>
        </form>
        
        <?php
            if (isset($_POST["add_credit_type"])) {
                $credit_type_name = $_POST["credit_type_name"];
                $credit_type_stavka = (int)$_POST["credit_type_stavka"];
                $credit_type_num_of_days = (int)$_POST["credit_type_num_of_days"];
                
                $sql = "INSERT INTO credit_type (name, stavka, num_of_days) VALUES ('$credit_type_name', $credit_type_stavka, $credit_type_num_of_days)";
                $conn->query($sql);
            }
        ?>

        <?php
            // Query credit type table for select
            $credit_type = $conn->query($sql_select_credit_type);
            // Generate table with query's results
            if ($credit_type->num_rows > 0) {
                echo  "<table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Stavka</th>
                        <th scope='col'>Number Of Days</th>
                    </tr>
                </thead>
                <tbody>";

                while ($row = $credit_type->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['stavka'] . "</td>";
                    echo "<td>" . $row['num_of_days'] . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody>
                </table>";
            }
        ?>
    </div>

    <div id="credit">
        <!-- Form for adding credit -->
        <form action="lab8.php" method="post">
            <input type="hidden" name="add_credit">
            <input class="form-control" type="number" name="credit_sum" placeholder="Credit's Sum">
            <input class="form-control" type="date" name="credit_date" placeholder="Credit's Date">
            <select class="custom-select" name="credit_name_type" id="credit_id_type">
                    <option value="" disabled selected>Select Credit Type</option>
                    <?php
                        $credit_type = $conn->query($sql_select_credit_type);
                        if ($credit_type->num_rows > 0) {
                        
                            while ($row = $credit_type->fetch_assoc()) {
                                echo "<option value='" . $row["name"] . "'>" .$row["name"] . "</option>";
                            }
                        }
                    ?>
            </select>
            <div class="input-group mb-3">
                <select class="custom-select" name="credit_client" id="credit_client">
                    <option value="" disabled selected>Select Client</option>
                    <?php
                        $client = $conn->query($sql_select_clients);
                        if ($client->num_rows > 0) {
                        
                            while ($row = $client->fetch_assoc()) {
                                echo "<option value='" . $row["id"] . "'>" .$row["id"] . "</option>";
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
            // Handle post from credits' form: insert new credit in DB
            if (isset($_POST["add_credit"])) {
                $credit_sum = (int)$_POST["credit_sum"];
                $credit_date = $_POST["credit_date"];
                $credit_name_type = $_POST["credit_name_type"];
                $credit_client = (int)$_POST["credit_client"];
            
                $sql_credit_id_type = $conn->query("SELECT id FROM credit_type WHERE name='$credit_name_type'");
            
                if ($sql_credit_id_type->num_rows > 0) {
                    $credit_id_type = $sql_credit_id_type->fetch_assoc()["id"];
            
                    $sql = "INSERT INTO credit (id_credit_type, id_client, sum, date) VALUES ($credit_id_type, $credit_client, $credit_sum, '$credit_date')";
                    $conn->query($sql);
                }
            }
        ?>

        <?php
            // Query credit table for select
            $credit = $conn->query($sql_select_credit);
            // Generate table with query's results
            if ($credit->num_rows > 0) {
                echo  "<table class='table table-sm table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Credit Name</th>
                        <th scope='col'>ID Client</th>
                        <th scope='col'>SUM</th>
                        <th scope='col'>DATE</th>
                    </tr>
                </thead>
                <tbody>";

                while ($row = $credit->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['credit_id'] . "</td>";
                        echo "<td>" . $row['credit_name'] . "</td>";
                        echo "<td>" . $row['client_id'] . "</td>";
                        echo "<td>" . $row['sum'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "</tr>";
                    }
                
                    echo "</tbody>
                    </table>";
            }
        ?>
    </div>

    <div id="search">
        <!-- Form for searching -->
        <form action="lab8.php" method="post">
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
                    <th scope='col'>Credit Name</th>
                    <th scope='col'>Client Name</th>
                    <th scope='col'>Client Surname</th>
                    <th scope='col'>Client Phone</th>
                    <th scope='col'>SUM</th>
                    <th scope='col'>DATE</th>
                    </tr>
                </thead>
                <tbody>";

                // Query songs table, joing it with albums and artists table, for selecting statments "where like"
                $sql = "SELECT
                credit_type.name AS credit_name,
                clients.name AS client_name,
                clients.surname AS client_surname,
                clients.phone AS client_phone,
                sum,
                date
            FROM credit
            INNER JOIN clients
            ON credit.id_client = clients.id
            INNER JOIN credit_type
            ON credit.id_credit_type = credit_type.id
            WHERE credit_type.name LIKE '$q' OR
            clients.name LIKE '$q' OR
            clients.surname LIKE '$q' OR
            clients.phone LIKE '$q' OR
            sum LIKE '$q' OR
            date LIKE '$q'";
                
                $result = $conn->query($sql);

                // Generate table with query's results
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['credit_name'] . "</td>";
                        echo "<td>" . $row['client_name'] . "</td>";
                        echo "<td>" . $row['client_surname'] . "</td>";
                        echo "<td>" . $row['client_phone'] . "</td>";
                        echo "<td>" . $row['sum'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='6'>" . "Nothing was found" . "</td>";
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
</body>

<?php
    $conn->close();
?>
</html>