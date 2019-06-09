<script>
    var words = [];
</script>

<?php
    // Database information
    $server_name = "localhost";
    $user_name = "root";
    $password = "Msql940825qiu#";
    $dbname = "fujiefujie";

    // Connect to the database
    $mysqli2 = new mysqli($server_name, $user_name, $password, $dbname);
    if ($mysqli2->connect_error) {
        die("Connection failed: " . $mysqli2->connect_error);
    }

    // Select query
    $select_sql2 = "SELECT title, url, weight FROM books";
    $select_result2 = $mysqli2->query($select_sql2);

    if ($select_result2->num_rows > 0) {
        while($row = $select_result2->fetch_assoc()) { ?>
            <script>
                words.push({text: '<?php echo addslashes($row["title"]);?>', size: parseInt(<?php echo $row["weight"]; ?>)});
            </script>
     <?php } // Yeah, I know it is ugly
    }
?>

