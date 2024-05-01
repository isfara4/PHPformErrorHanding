<?php

$host = "storm.cis.fordham.edu";
$username = "cisc3300";
$password = "cisc3300";
$DB = "cisc3300";

$conn = new mysqli($host, $username, $password, $DB);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateDate($date) {
    return DateTime::createFromFormat('Y-m-d', $date) !== false;
}

function validateTime($time) {
    return preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $time);
}

function displayValidationErrors($errors) {
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li class='error'>$error</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No validation errors.</p>";
    }
}

function displayFormWithErrors($name, $email, $message, $birthdate, $time, $errors) {
    echo "<h1>Contact Information</h1>";
    displayValidationErrors($errors);
    echo "<form method='post' action='collect.php'>";
    echo "<label for='name'>Name:</label><br><input type='text' id='name' name='name' value='$name'><br><br>";
    echo "<label for='email'>Email:</label><br><input type='email' id='email' name='email' value='$email'><br><br>";
    echo "<label for='message'>Message:</label><br><textarea id='message' name='message' rows='4' cols='50'>$message</textarea><br><br>";
    echo "<label for='birthdate'>Birthdate:</label><br> <input type='date' id='birthdate' name='birthdate' value='$birthdate'><br><br>";
    echo "<label for='time'>Time:</label><br> <input type='time' id='time' name='time' value='$time' ><br><br>";
    echo '<input type="submit" value="Submit">';
}

function handleFormSubmission($conn) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $birthdate = $_POST['birthdate'];
    $time = $_POST['time'];

    $errors = [];

    if (empty($name) || empty($email) || empty($message) || empty($birthdate) || empty($time)) {
        $errors[] = "All fields are required.";
    }

    if (!validateEmail($email)) {
        $errors[] = "Invalid email address.";
    }

    if (!validateDate($birthdate)) {
        $errors[] = "Invalid date format. Please use YYYY-MM-DD format.";
    }

    if (!validateTime($time)) {
        $errors[] = "Invalid time format. Please use HH:MM format (24-hour clock).";
    }

    if (!empty($errors)) {
        // Display form with validation errors and exit
        displayFormWithErrors($name, $email, $message, $birthdate, $time, $errors);
        $conn->close();
        exit();
    }

    $sql = "INSERT INTO ramey_collect (name, email, message, birthdate, time) VALUES ('$name', '$email', '$message', '$birthdate', '$time')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to display.php
        header("Location: display.php");
        exit();
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

handleFormSubmission($conn);
$conn->close();

?>
