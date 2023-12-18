<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/home.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/test.css">
    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
    <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'Views/Shared/navbar.php';
include_once 'Views/Order/orderSubCategories.php';
?>
<h1>Cart</h1>
<?php
if (empty($data)) {
    echo "<label>Empty Cart</label>";
}
?>
<h2>Tests</h2>
<?php
if (!empty($data['tests'])) {
?>
<table>
    <thead>
    <tr>
        <th>Snake Name</th>
        <th>Sex</th>
        <th>Origin</th>
        <th>Known Morphs</th>
        <th>Possible Morphs</th>
        <th>Tested Morphs</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['tests'] as $test) {
        echo "<td>" . $test['customerSnakeId'] . "</td>";
        echo "<td>" . $test['sex'] . "</td>";
        echo "<td>" . $test['origin'] . "</td>";
        $stringKnownMorph = implode(', ', $test['knownMorphs']);
        $stringPossibleMorph = implode(', ', $test['possibleMorphs']);
        $stringTestedMorph = implode(', ', $test['testedMorphs']);
        echo "<td>" . $stringKnownMorph . "</td>";
        echo "<td>" . $stringPossibleMorph . "</td>";
        echo "<td>" . $stringTestedMorph . "</td>";
        echo "<td><a href='index.php?controller=order&action=updateTest&id=" . $test['testId'] . "'>Update</a></td>";
        echo "<td><a href='index.php?controller=order&action=deleteTest&id=" . $test['testId'] . "'>Delete</a></td></tr>";
    }
    ?>
    </tbody>
</table>
<?php } ?>
<h2>Donations</h2>
<table>
    <thead>
    <tr>
        <th>Snake Name</th>
        <th>Header 2</th>
        <th>Header 3</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Data 1</td>
        <td>Data 2</td>
        <td>Data 3</td>
    </tr>
    <tr>
        <td>Data 4</td>
        <td>Data 5</td>
        <td>Data 6</td>
    </tr>
    <!-- Add more rows as needed -->
    </tbody>
</table>
<a href="?controller=billing&action=billing"><button>Confirm</button></a>
</body>
</html>