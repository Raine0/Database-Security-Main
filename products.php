<?php
include 'components/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $result = pg_query($conn, "SELECT * FROM USERS");
    if (!$result) {
        echo "An error occurred.<br>";
        exit;
    } 
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>

    <?php
    while($row = pg_fetch_assoc($result)) {
        echo "
        <tr>
            <th>$row[id]</th>
            <th>$row[name]</th>
            <th>$row[email]</th>
        </tr>
        ";
    }
    ?>
    </table>
</body>
</html>