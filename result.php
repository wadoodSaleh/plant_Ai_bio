<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="upload-section">
    <?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plant_id";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_SESSION['output'])) {
    $output = $_SESSION['output'];
    $trimmed_output = trim($output);
    // Normalize the output by replacing triple underscores with a space for visual display
    $display_output = str_replace("___", " ", $trimmed_output);
    $plant_name = explode("___", $trimmed_output)[0]; 
    
    // Define the SQL query template
    $sql_template = "SELECT * FROM plantcare WHERE plant_name = '%s' AND plant_condition = '%s'";

    // Create the path for the image based on plant name
    $image_path = 'outputs/' . str_replace(' ', '_', $plant_name) . '.jpg';

    // Display the image
    echo "<img src='" . $image_path . "' alt='" . $plant_name . "' style='width:200px;'><br>";

    // Handle multiple class conditions
    if ($trimmed_output === "Apple___Apple_scab") {
        $sql = sprintf($sql_template, 'Apple', 'Apple scab');
    } elseif ($trimmed_output === "Apple___Black_rot") {
        $sql = sprintf($sql_template, 'Apple', 'Black rot');
    } elseif ($trimmed_output === "Apple___Cedar_apple_rust") {
        $sql = sprintf($sql_template, 'Apple', 'Cedar apple rust');
    } elseif ($trimmed_output === "Apple___healthy") {
        $sql = sprintf($sql_template, 'Apple', 'Healthy');
    } elseif ($trimmed_output === "Corn_(maize)___Cercospora_leaf_spot Gray_leaf_spot") {
        $sql = sprintf($sql_template, 'Corn (maize)', 'Cercospora leaf spot Gray leaf spot');
    } elseif ($trimmed_output === "Corn_(maize)___Common_rust_") {
        $sql = sprintf($sql_template, 'Corn (maize)', 'Common rust');
    } elseif ($trimmed_output === "Corn_(maize)___Northern_Leaf_Blight") {
        $sql = sprintf($sql_template, 'Corn (maize)', 'Northern Leaf Blight');
    } elseif ($trimmed_output === "Corn_(maize)___healthy") {
        $sql = sprintf($sql_template, 'Corn (maize)', 'Healthy');
    } elseif ($trimmed_output === "Grape___Black_rot") {
        $sql = sprintf($sql_template, 'Grape', 'Black rot');
    } elseif ($trimmed_output === "Grape___Esca_(Black_Measles)") {
        $sql = sprintf($sql_template, 'Grape', 'Esca (Black Measles)');
    } elseif ($trimmed_output === "Grape___Leaf_blight_(Isariopsis_Leaf_Spot)") {
        $sql = sprintf($sql_template, 'Grape', 'Leaf blight (Isariopsis Leaf Spot)');
    } elseif ($trimmed_output === "Grape___healthy") {
        $sql = sprintf($sql_template, 'Grape', 'Healthy');
    } elseif ($trimmed_output === "Potato___Early_blight") {
        $sql = sprintf($sql_template, 'Potato', 'Early blight');
    } elseif ($trimmed_output === "Potato___Late_blight") {
        $sql = sprintf($sql_template, 'Potato', 'Late blight');
    } elseif ($trimmed_output === "Potato___healthy") {
        $sql = sprintf($sql_template, 'Potato', 'Healthy');
    } elseif ($trimmed_output === "Strawberry___Leaf_scorch") {
        $sql = sprintf($sql_template, 'Strawberry', 'Leaf scorch');
    } elseif ($trimmed_output === "Strawberry___healthy") {
        $sql = sprintf($sql_template, 'Strawberry', 'Healthy');
    } elseif ($trimmed_output === "Tomato___Tomato_Yellow_Leaf_Curl_Virus") {
        $sql = sprintf($sql_template, 'Tomato', 'Tomato Yellow Leaf Curl Virus');
    } elseif ($trimmed_output === "Tomato___Tomato_mosaic_virus") {
        $sql = sprintf($sql_template, 'Tomato', 'Tomato mosaic virus');
    } elseif ($trimmed_output === "Tomato___healthy") {
        $sql = sprintf($sql_template, 'Tomato', 'Healthy');
    } else {
        echo "No matching plant condition found.";
        $conn->close();
        exit;
    }

    // Execute the SQL query
    $result = $conn->query($sql);

    // Check the query results
    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<div class='plant-info'>
            <span class='plant-name'>Plant Name: " . $row["plant_name"] . "</span>
            <span class='plant-condition'> - Plant Condition: " . $row["plant_condition"] . "</span><br>
            <span class='care-instructions'>Care Instructions: " . $row["treatment"] . "</span>
          </div><br>";
        }
    } else {
        echo "No care information found for " . $display_output . ".";
    }

    unset($_SESSION['output']); // Clear the output from the session
} else {
    echo "no result to display";
}

$conn->close();
?>
    </div>
</body>
</html>
