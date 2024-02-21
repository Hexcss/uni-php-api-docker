<?php
$host = 'mysql';
$user = 'exampleuser';
$password = 'examplepass';
$db = 'exampledb';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to MySQL database<br>";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

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

    try {
        $stmt = $conn->prepare("INSERT INTO json_data (data) VALUES (?)");
        $stmt->execute([$jsonData]);
        echo "JSON data uploaded successfully<br>";
    } catch (PDOException $e) {
        echo "Error uploading JSON data: " . $e->getMessage() . "<br>";
    }
}

function getAllJsonFromDB($conn)
{
    $sql = "SELECT data FROM json_data";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $allData = [];
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $allData[] = json_decode($row["data"], true);
        }
        echo "<pre id='jsonDisplay'>" . json_encode($allData, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "No data found<br>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["uploadJson"])) {
        $jsonData = $_POST["jsonData"];
        uploadJsonToDB($conn, $jsonData);
    } elseif (isset($_POST["fetchAll"])) {
        getAllJsonFromDB($conn);
    }
}
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
