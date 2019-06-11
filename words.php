<script>
    var words = [];
</script>

<?php
    // Database information
    $server_name = "ysp9sse09kl0tzxj.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
    $user_name = "d03qhmczyewbyoxm";
    $password = "zf0k2ba0vwwj5jdf";
    $dbname = "wim3a3a876huja7u";

    // Connect to the database
    $mysqli2 = new mysqli($server_name, $user_name, $password, $dbname);
    if ($mysqli2->connect_error) {
        die("Connection failed: " . $mysqli2->connect_error);
    }

    // Select query
    $select_sql2 = "SELECT title, url, weight FROM books";
    $select_result2 = $mysqli2->query($select_sql2);

    $books = array();
    if ($select_result2->num_rows > 0) {
        while($row = $select_result2->fetch_assoc()) { 
            $books[$row["title"]] = (int)$row["weight"];
        } 

        arsort($books);
        $i = 1;
        foreach ($books as $name => $weight) {
            if(sizeof($books) <= 50 && $i < sizeof($books))
            { ?>
                <script>
                words.push({text: '<?php echo addslashes($name);?>', size: parseInt(<?php echo $weight; ?>)});
                </script>
                <?php 
                $i += 1;
            }
            elseif(sizeof($books) > 50 && $i < 50) 
            {?>
                <script>
                words.push({text: '<?php echo addslashes($name);?>', size: parseInt(<?php echo $weight; ?>)});
                </script>
                <?php 
                $i += 1;
            }
            else{
                break;
            }
        }
    }
?>

