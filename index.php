<?php
include('db.php');

$sql = "SELECT * FROM plant";

if (isset($_POST['search']) && !empty($_POST['search'])) {
    $searchTerm = $conn->real_escape_string($_POST['search']);
    $sql = "SELECT * FROM plant WHERE ScientificName LIKE '%$searchTerm%' OR CommonName LIKE '%$searchTerm%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&family=Noto+Sans+Gurmukhi:wght@100..900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Aquatic Plants Database</title>
</head>

<body>
    <header>
        <h1 id="title">Aquatic Plants Database</h1>
    </header>

    <div class="content">
            <div class="left-column">
                <h2 id="filters-title">Filters</h2>
                <div class="filter-container">

                <form method="POST" action="" id="search-form">
                    <input type="text" name="search" placeholder="Search..." id="search-input" />
                    <input type="submit" value="Search" id="search-button" />
                </form>
            
            <p>testing</p>
            <p>testing</p>
            <p>testing</p>
            <p>testing</p>
            <p>testing</p>
            <p>testing</p>

            </div>
    </div>

    <div class="right-column">
        <h2 id="plants-title">Plants</h2>

    <div class="card-container">
        
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h3>" . $row['ScientificName'] . "</h3>";
                echo "<p><strong>Common Name:</strong> " . $row['CommonName'] . "</p>";
                echo "<p><strong>Lighting:</strong> " . $row['Lighting'] . "</p>";
                echo "<p><strong>Temp Low:</strong> " . $row['TempLow'] . "</p>";
                echo "<p><strong>Temp High:</strong> " . $row['TempHigh'] . "</p>";
                echo "<p><strong>Color:</strong> " . $row['Color'] . "</p>";
                echo "<p><strong>Growth Rate:</strong> " . $row['GrowthRate'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No plants found in the database.</p>";
        }
        ?>
        
    </div>


    </div>


    <script src="script.js"></script>

</body>

</html>

<?php
$conn->close();
?>