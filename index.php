<?php
include('db.php');

$sql = "SELECT * FROM `plant`";

if (isset($_POST['clear'])) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
else {
    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $searchTerm = $conn->real_escape_string($_POST['search']);
        $sql .= " WHERE ScientificName LIKE '%$searchTerm%' OR CommonName LIKE '%$searchTerm%'";
    }
    
    if (isset($_POST['growth-rate']) && $_POST['growth-rate'] != 'all-growth') {

        $growthRate = $_POST['growth-rate'];
        
        $sql = appendQuery($sql);
        
        if ($growthRate == 'vs-growth') {
            $sql .= " GrowthRate = 'Very Slow'";
        }
        elseif ($growthRate == 's-growth') {
            $sql .= " GrowthRate = 'Slow'";
        }
        elseif ($growthRate == 'm-growth') {
            $sql .= " GrowthRate = 'Medium'";
        }
        elseif ($growthRate == 'f-growth') {
            $sql .= " GrowthRate = 'Fast'";
        }
        elseif ($growthRate == 'vf-growth') {
            $sql .= " GrowthRate = 'Very Fast'";
        }
    }
    
    if (isset($_POST['color']) && $_POST['color'] != 'all-color') {
        $color = $_POST['color'];
        
        $sql = appendQuery($sql);
        
        if ($color == 'green') {
            $sql .= " Color = 'Green'";
        }
        elseif ($color == 'red') {
            $sql .= " Color = 'Red'";
        }
    }
    
    if (isset($_POST['lighting']) && $_POST['lighting'] != 'all-lighting') {
        $lighting = $_POST['lighting'];
        
        $sql = appendQuery($sql);
        
        if ($lighting == 'low-light') {
            $sql .= " Lighting = 'Low'";
        }
        elseif ($lighting == 'moderate-light') {
            $sql .= " Lighting = 'Moderate'";
        }
        elseif ($lighting == 'high-light') {
            $sql .= " Lighting = 'High'";
        }
    }
    
    if (isset($_POST['special']) && $_POST['special'] != 'all-trait') {
        $special = $_POST['special'];
        
        $sql = appendQuery($sql);
        
        if ($special == 'attached') {
            $sql .= " Special = 'Attached'";
        }
        elseif ($special == 'carpet') {
            $sql .= " Special = 'Carpet'";
        }
        elseif ($special == 'no-substrate') {
            $sql .= " Special = 'No Substrate'";
        }
        elseif ($special == 'substrate') {
            $sql .= " Special = 'Substrate'";
        }
        elseif ($special == 'surface') {
            $sql .= " Special = 'Surface'";
        }
    }
    
    if (isset($_POST['tempLow']) && $_POST['tempLow'] != '40' && isset($_POST['tempHigh']) && $_POST['tempHigh'] != '100') {
        $tempLow = $_POST['tempLow'];
        $tempHigh = $_POST['tempHigh'];
        
        $sql = appendQuery($sql);
        
        $sql .= " (TempLow >= $tempLow AND TempLow <= $tempHigh) AND (TempHigh >= $tempLow AND TempHigh <= $tempHigh)";   
    }
}

function appendQuery($sql) {
    if (strpos($sql, "WHERE") !== false) {
        $sql .= " AND";
    }
    else {
        $sql .= " WHERE";
    }
    return $sql;
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
<script src="https://kit.fontawesome.com/7a42259443.js" crossorigin="anonymous"></script>
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

<div class="search-container">
<input type="text" name="search" placeholder="Search..." id="search-input" />

<button type="submit" id="search-button" title="Search and filter">
    <i class="fa-solid fa-magnifying-glass"></i>
</button>

<button type="submit" name="clear" value="1" id="clear-button" title="Reset"> 
    <i class="fa-solid fa-rotate-right"></i>
</button>

</div>


<!--Growth Rate Filter-->
<label for="growth-rate"><strong>Growth Rate</strong></label>
<select name="growth-rate" id="growth-rate" onchange="updateValues(); this.form.submit();">
<option value="all-growth" <?php echo isset($_POST['growth-rate']) && $_POST['growth-rate'] == 'all-growth' ? 'selected' : ''; ?>>-</option>
<option value="vs-growth" <?php echo isset($_POST['growth-rate']) && $_POST['growth-rate'] == 'vs-growth' ? 'selected' : ''; ?>>Very Slow</option>
<option value="s-growth" <?php echo isset($_POST['growth-rate']) && $_POST['growth-rate'] == 's-growth' ? 'selected' : ''; ?>>Slow</option>
<option value="m-growth" <?php echo isset($_POST['growth-rate']) && $_POST['growth-rate'] == 'm-growth' ? 'selected' : ''; ?>>Medium</option>
<option value="f-growth" <?php echo isset($_POST['growth-rate']) && $_POST['growth-rate'] == 'f-growth' ? 'selected' : ''; ?>>Fast</option>
<option value="vf-growth" <?php echo isset($_POST['growth-rate']) && $_POST['growth-rate'] == 'vf-growth' ? 'selected' : ''; ?>>Very Fast</option>
</select>

<!--Lighting Filter-->
<label for="lighting"><strong>Lighting</strong></label>
<select name="lighting" id="lighting" onchange="updateValues(); this.form.submit();">
<option value="all-lighting" <?php echo isset($_POST['lighting']) && $_POST['lighting'] == 'all-lighting' ? 'selected' : ''; ?>>-</option>
<option value="low-light" <?php echo isset($_POST['lighting']) && $_POST['lighting'] == 'low-light' ? 'selected' : ''; ?>>Low</option>
<option value="moderate-light" <?php echo isset($_POST['lighting']) && $_POST['lighting'] == 'moderate-light' ? 'selected' : ''; ?>>Moderate</option>
<option value="high-light" <?php echo isset($_POST['lighting']) && $_POST['lighting'] == 'high-light' ? 'selected' : ''; ?>>High</option>
</select>

<!--Color Filter-->
<label for="color"><strong>Color</strong></label>
<select name="color" id="color" onchange="updateValues(); this.form.submit();">
<option value="all-color" <?php echo isset($_POST['color']) && $_POST['color'] == 'all-color' ? 'selected' : ''; ?>>-</option>
<option value="green" <?php echo isset($_POST['color']) && $_POST['color'] == 'green' ? 'selected' : ''; ?>>Green</option>
<option value="red" <?php echo isset($_POST['color']) && $_POST['color'] == 'red' ? 'selected' : ''; ?>>Red</option>
</select>

<!--Special-->
<label for="special"><strong>Special</strong></label>
<select name="special" id="special" onchange="updateValues(); this.form.submit();">
<option value="all-trait" <?php echo isset($_POST['special']) && $_POST['special'] == 'all-trait' ? 'selected' : ''; ?>>-</option>
<option value="attached" <?php echo isset($_POST['special']) && $_POST['special'] == 'attached' ? 'selected' : ''; ?>>Attached</option>
<option value="carpet" <?php echo isset($_POST['special']) && $_POST['special'] == 'carpet' ? 'selected' : ''; ?>>Carpet</option>
<option value="no-substrate" <?php echo isset($_POST['special']) && $_POST['special'] == 'no-substrate' ? 'selected' : ''; ?>>No Substrate</option>
<option value="substrate" <?php echo isset($_POST['special']) && $_POST['special'] == 'substrate' ? 'selected' : ''; ?>>Substrate</option>
<option value="surface" <?php echo isset($_POST['special']) && $_POST['special'] == 'surface' ? 'selected' : ''; ?>>Surface</option>
</select>

<!--Temperature Filter-->
<label for="temp"><strong>Temperature (F)</strong></label>
<input type="range" id="tempLow" title="Min temp" min="50" max="90" value="<?php echo isset($_POST['tempLow']) ? $_POST['tempLow'] : 50; ?>" step="5" onchange="updateValues(); this.form.submit();" />
<span id="tempLowValue" class="sliderValue"><?php echo isset($_POST['tempLow']) ? $_POST['tempLow'] : 50; ?></span>
<input type="range" id="tempHigh" title="Max temp" min="50" max="90" value="<?php echo isset($_POST['tempHigh']) ? $_POST['tempHigh'] : 90; ?>" step="5" onchange="updateValues(); this.form.submit();" />
<span id="tempHighValue" class="sliderValue"><?php echo isset($_POST['tempHigh']) ? $_POST['tempHigh'] : 90; ?></span>
<input type="hidden" name="tempLow" id="hidden-tempLow" value="50">
<input type="hidden" name="tempHigh" id="hidden-tempHigh" value="90">
</form>

</div>
</div>


<div class="right-column">

<?php
    $total = $result->num_rows;
    echo "<div class='right-subtitle'><strong>Results: $total </strong></div>";
?>

<h2 id="plants-title">Plants</h2>

<div class="card-container">

<?php
$total = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        
        if (!empty($row['ImagePath'])) {
            echo "<img src='" . $row['ImagePath'] . "' alt='Plant Image' width='180' height='auto'>";
        } 
        else {
            echo "<p>No image available</p>";
        }
        echo "<h3>" . $row['ScientificName'] . "</h3>";
        echo "<p><strong>Common Name: </strong> " . "<br>" . $row['CommonName'] . "</p>";
        echo "<p><strong>Lighting: </strong> " . "<br>" . $row['Lighting'] . "</p>";
        echo "<p><strong>Temperature (F): </strong> " . "<br>" . $row['TempLow'] . "-" . $row['TempHigh'] . "</p>";
        echo "<p><strong>Growth Rate: </strong> " . "<br>" . $row['GrowthRate'] . "</p>";
        
        echo "<div class='traits'>";
        
        if ($row['Color'] == 'Green') {
            echo "<i class='fa-solid fa-palette' title='Color: " . $row['Color'] . "' style='color: #62bc81'></i>";
        }
        else {
            echo "<i class='fa-solid fa-palette' title='Color: " . $row['Color'] . "' style='color: #b95050'></i>";
        }
        
        if ($row['Lighting'] == 'Low') {
            echo "<i class='fa-solid fa-sun' title='Lighting: " . $row['Lighting'] . "' style='color: Grey'></i>";
        }
        else if ($row['Lighting'] == 'Moderate') {
            echo "<i class='fa-solid fa-sun' title='Lighting: " . $row['Lighting'] . "' style='color:rgb(245, 217, 79)'></i>";
        }
        else {
            echo "<i class='fa-solid fa-sun' title='Lighting: " . $row['Lighting'] . "' style='color: Yellow'></i>";
        }
        
        echo "<i class='fa-solid fa-flag' title='Special: " . $row['Special'] . "' style='color: #6b8fcc' ></i>";
        
        echo "</div>";
        
        echo "</div>";
    }
} else {
    echo "<p>No matching plants found in the database.</p>";
}

?>

</div>

</div>

<a href="#top" id="back-to-top" title="Back to Top">
    <i class="fa-solid fa-arrow-up"></i>
</a>

<script src="script.js"></script>

</body>
</html>

<?php
    $conn->close();
?>
