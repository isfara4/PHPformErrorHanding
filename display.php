<?php

$host = "storm.cis.fordham.edu";
$username = "cisc3300";
$password = "cisc3300";
$DB = "cisc3300";


$conn = new mysqli($host, $username, $password, $DB);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM ramey_collect";
$result = $conn->query($sql);

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

    <h2>Data from Database</h2>
    <?php

    if ($result->num_rows > 0) {

        echo "<table border='1'>";
        echo "<tr>";
        echo "<th style='background-color: #4CAF50; color: white;'>Name</th>";
        echo "<th style='background-color: #2196F3; color: white;'>Email</th>";
        echo "<th style='background-color: #f44336; color: white;'>Message</th>";
        echo "<th style='background-color: #9C27B0; color: white;'>Birthdate</th>";
        echo "<th style='background-color: #607D8B; color: white;'>Time</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["message"] . "</td>";
            echo "<td>" . $row["birthdate"] . "</td>";
            echo "<td>" . $row["time"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No data available.";
    }
    ?>

</body>
</html>