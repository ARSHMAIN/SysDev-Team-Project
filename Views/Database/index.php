<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Database</title>
</head>
<body>
<form id="form" action="?controller=database&action=index" method="post">
    <label for="database"></label>
    <select id="database" name="database">
        <?php
        foreach ($data['tableNames'] as $tableName) {
            echo "<option value='" . $tableName['Tables_in_snake'] . "'>" . $tableName['Tables_in_snake'] . "</option>";
        }
        ?>
    </select>
</form>
<?php
if (isset($data['table'])) {
?>
<table>
    <thead>
    <tr>
<?php
foreach ($data['table']['columns'] as $column) {
    echo "<th>" . $column['Field'] . "</th>";
}
?>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php
        foreach ($data['table']['rows'] as $row) {
            echo "<tr>";
            foreach ($row as $data) {
                echo "<td>" . $data . "</td>";
            }
            echo "</tr>";
        }
        ?>
    </tr>
    </tbody>
</table>
<?php
}
?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('select[name="database"]').addEventListener('change', () => {
            document.getElementById('form').submit();
        });
    });
</script>
</html>