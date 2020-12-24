<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 6</title>
    <style>
        body {
            margin-top: 20%;
            text-align: center;
            font-size: 30px;
        }
    </style>
</head>
<body>
    <?php 
    echo $_POST["fname"], " ", $_POST["lname"], " your form was recieved at ", date("H:i:s");
    ?>     
</body>
</html>
