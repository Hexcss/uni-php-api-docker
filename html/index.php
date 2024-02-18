<?php
$host = 'mysql';
$user = 'exampleuser';
$password = 'examplepass';
$db = 'exampledb';
$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to MySQL database<br>";

function isValidJson($jsonStr)
{
    json_decode($jsonStr);
    return json_last_error() == JSON_ERROR_NONE;
}

function uploadJsonToDB($conn, $jsonData)
{
    if (!isValidJson($jsonData)) {
        echo "Invalid JSON data.<br>";
        return false;
    }

    $stmt = $conn->prepare("INSERT INTO json_data (data) VALUES (?)");
    $stmt->bind_param("s", $jsonData);
    if ($stmt->execute()) {
        echo "JSON data uploaded successfully<br>";
    } else {
        echo "Error uploading JSON data<br>";
    }
    $stmt->close();
}

function getAllJsonFromDB($conn)
{
    $sql = "SELECT data FROM json_data";
    $result = $conn->query($sql);
    $allData = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $allData[] = json_decode($row["data"], true);
        }
        echo "<pre id='jsonDisplay'>" . json_encode($allData, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "No data found<br>";
    }
}

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["uploadJson"])) {
        $jsonData = $_POST["jsonData"];
        uploadJsonToDB($conn, $jsonData);
    } elseif (isset($_POST["fetchAll"])) {
        getAllJsonFromDB($conn);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JSON Data Management</title>
    <script>
        function clearData() {
            document.getElementById('jsonDisplay').innerHTML = '';
        }
    </script>
</head>
<body>
    <h2>Upload JSON Data</h2>
    <form method="post">
        <textarea name="jsonData" rows="4" cols="50"></textarea><br>
        <input type="submit" name="uploadJson" value="Upload JSON">
    </form>

    <h2>Fetch All JSON Data</h2>
    <form method="post">
        <input type="submit" name="fetchAll" value="Fetch All JSON Data">
    </form>
    <button onclick="clearData()">Clear Data</button>
</body>
</html>
