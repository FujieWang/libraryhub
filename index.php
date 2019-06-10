<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Civic technology - Unnamed</title>

  <!-- Font Awesome Icons -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

  <!-- Plugin CSS -->
  <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

  <!-- Theme CSS - Includes Bootstrap -->
  <link href="css/creative.min.css" rel="stylesheet">

  <script src='https://api.mapbox.com/mapbox-gl-js/v0.54.0/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v0.54.0/mapbox-gl.css' rel='stylesheet' />


  <!-- wordcloud file-->
  <script src="/lib/d3/d3.js" charset="utf-8"></script>
    <script src="/lib/d3/d3.layout.cloud.js"></script>
    <script src="/d3.wordcloud.js"></script>

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">A class prject by Fujie Wang</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#vote">Vote</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#cloud">Word Cloud</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#search">Search</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#map">Map</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead">
    <div class="container h-100">
      <div class="row h-100 align-items-center justify-content-center text-center">
        <div class="col-lg-10 align-self-end">
          <h1 class="text-uppercase text-white font-weight-bold">LibraryHub</h1>
          <hr class="divider my-4">
        </div>
        <div class="col-lg-8 align-self-baseline">
          <p class="text-white-75 font-weight-light mb-5">NEED DESCRIPTION HERE!! </p>
          <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">About this site</a>
        </div>
      </div>
    </div>
  </header>

  <!-- About Section -->
  <section class="page-section bg-primary" id="about">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="text-white mt-0">About LibraryHub</h2>
          <hr class="divider light my-4">
          <p class="text-white-50 mb-4">NEED DESCRIPTION!!</p>
          <a class="btn btn-light btn-xl js-scroll-trigger" href="#vote">Vote your favorite book now!</a>
        </div>
      </div>
    </div>
  </section>



<!-- Vote -->
<section class="page-section bg-light" id="vote">
  <div class="container">
    <h2 class="text-center">VOTE FOR YOUR FAVOURITE BOOK</h2>
    <form action = "" method = "post">
    <input type="hidden" name="action" value="vote">
      <div class="form-group">
        <label for="inpuTitle">Title</label>
        <input type="text" class="form-control" id="inputTitle" name = "title" placeholder="The title of this book" required>
      </div>
      <div class="form-group">
          <label for="inputAuthor">Author</label>
          <input type="text" class="form-control" id="inputAuthor" name = "author" placeholder="The title of this book" required>
        </div>
      <div class="form-group">
        <label for="inputUrl">Url</label>
        <input type="text" class="form-control" id="inputUrl" name = "url" placeholder="A reference to this book">
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputName">Your name</label>
          <input type="text" class="form-control" id="inputName" name = "submitter" placeholder="Your name">
        </div>
      </div>
      <div class="form-group">
          <label for="inputWhy">Why you like this book?</label>
          <textarea class="form-control" id="inputWhy" name = "why" placeholder="WHY?">
          </textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</section>

<?php
//title, author, url, submitter, why
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["author"]) && isset($_POST["title"]) && $_POST["action"] == "vote")
    {
        // Extract data 
        $title = $_POST["title"];
        $author = $_POST["author"];
        $url = $_POST["url"];
        $submitter = $_POST["submitter"];
        $why = $_POST["why"];

        // Database information
        $server_name = "ysp9sse09kl0tzxj.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
        $user_name = "d03qhmczyewbyoxm";
        $password = "zf0k2ba0vwwj5jdf";
        $dbname = "wim3a3a876huja7u";

        // Connect to the database
        $mysqli = new mysqli($server_name, $user_name, $password, $dbname);
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        $title = mysqli_real_escape_string($mysqli, $_POST["title"]);
        $author = mysqli_real_escape_string($mysqli, $_POST["author"]);
        $url = mysqli_real_escape_string($mysqli, $_POST["url"]);
        $submitter = mysqli_real_escape_string($mysqli, $_POST["submitter"]);
        $why = mysqli_real_escape_string($mysqli, $_POST["why"]);

        // Select the title and author information for all records in the table
        $select_sql = "SELECT id, title, author FROM books";
        $select_result = $mysqli->query($select_sql);

        // Camel case the title and author
        $title = ucwords(strtolower($title)); 
        $author = ucwords(strtolower($author)); 

        // Check if the book is already in the database, if not, insert as a new record
        $found = FALSE;
        if ($select_result->num_rows > 0) {
            // Extract data for each row
            while($row = $select_result->fetch_assoc()) {
                similar_text(clean($row["title"]), clean($title), $title_percentage);
                similar_text(clean($row["author"]), clean($author), $author_percentage);

                // If the same book, update the weight
                if($title_percentage >= 90 && $author_percentage >= 90)
                {
                    $found = TRUE;
                    $update_sql = "UPDATE books SET weight = weight + 5 WHERE id = '" . $row["id"] . "'";
                    $update_result = $mysqli->query($update_sql);
                    if(!$update_result )
                    {
                        echo 
                        "<div class='alert alert-danger' role='alert'>
                        Failed to submit the form, please try later.
                        </div>";
                    }
                    else
                    {
                        echo 
                        "<div class='alert alert-success' role='alert'>
                        Thanks for voting!
                        </div>";
                    }
                }

            }
            // If different book
            if(!$found)
            {
                $insert_sql = "INSERT INTO books (title, author, url, submitter, why) VALUES ('$title', '$author', '$url', '$submitter', '$why')";

                $insert_result1 = $mysqli->query($insert_sql);
                if (!$insert_result1)
                {
                    echo 
                    "<div class='alert alert-danger' role='alert'>
                    Failed to submit the form, please try later.
                    </div>";
                }
                else
                {
                    echo 
                    "<div class='alert alert-success' role='alert'>
                    Thanks for voting!
                    </div>";
                }
            }
        } 

        // 0 records
        else 
        {
            $insert_sql = "INSERT INTO books (title, author, url, submitter, why) VALUES ('$title', '$author', '$url', '$submitter', '$why')";

            $insert_result = $mysqli->query($insert_sql);
            if (!$insert_result)
            {
                echo 
                "<div class='alert alert-danger' role='alert'>
                Failed to submit the form, please try later.
                </div>";
            }
            else
            {
                echo 
                    "<div class='alert alert-success' role='alert'>
                    Thanks for voting!
                    </div>";
            }
        }
        
        //clear the post array
        $_POST = array();
    }

    function clean($string) {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
      }
      //
?>

    <?php include 'words.php';?>

  <section class="page-section" id = "cloud">
  <div class="container">
      <!--Load Wordcloud-->
      <div class="container">
        <h1 class="text-center">WORLD COULD</h1>
        <div id='wordcloud'></div>
        </div>
        <script>
          d3.wordcloud()
            .size([900, 650])
            .fill(d3.scale.ordinal().range(["#884400", "#448800", "#888800", "#444400"]))
            .words(words)
            .spiral('archimedean')
            .onwordclick(function(d, i) {
              if (d.href) {window.location = d.href; }
            })
            .start();
        </script>
      </div>
    </section>

  <section class="page-section bg-light" id="search">
  <div class="container">
      <h2 class="text-center">CHECK THE RANKING OF YOUR FAVORITE BOOK</h2>
      <form action = "" method = "post">
        <div class="form-group">
          <input type="text" class="form-control" id="inputTitle" name = "search_term" placeholder="The title of the book" required>
        </div>
        <input type="hidden" name="action" value="search">
        <button type="submit" class="btn btn-outline-primary waves-effect">Search!</button>
      </form>

    <!-- Handle search query -->
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["search_term"]) && $_POST["action"] == "search")
      {
        echo "<br><br> <h3 class='text-center' > Result </h3>";
        echo "<br><br><table class='table'> \n";

        echo "<thead>
        <tr>
          <th scope='col'>Title</th>
          <th scope='col'>Rank</th>
        </tr>
      </thead> \n";

      echo "<tbody>";
          //Format: {title : weight}
          $list_of_books = array();

          // Datebase information
          // $server_name = "localhost";
          // $user_name = "root";
          // $password = "Msql940825qiu#";
          // $dbname = "fujiefujie";

          // Database information
          $server_name = "ysp9sse09kl0tzxj.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
          $user_name = "d03qhmczyewbyoxm";
          $password = "zf0k2ba0vwwj5jdf";
          $dbname = "wim3a3a876huja7u";

          // Connect to the database
          $mysqli3 = new mysqli($server_name, $user_name, $password, $dbname);
          if ($mysqli3->connect_error) {
              die("Connection failed: " . $mysqli->connect_error);
          }

          $search_term = mysqli_real_escape_string($mysqli3, $_POST["search_term"]);

          // Select the title and author information for all records in the table
          $search_sql = "SELECT id, title, weight FROM books";
          $select_result = $mysqli3->query($search_sql);

          // Camel case the search term
          $search_term = ucwords(strtolower($search_term)); 

          // Retrive all recoreds from the database
          if ($select_result->num_rows > 0) {
              // Extract data for each row
              while($row = $select_result->fetch_assoc()) {
                $list_of_books[$row["title"]] = (int)$row["weight"];
              }
          }
          
          //Sort the list of books based on weights
          arsort($list_of_books);

          // rank of a book
          $rank = 1;

          $book_not_found = TRUE;

          //Check if the searched book exists
          foreach ($list_of_books as $name => $weight) {
            similar_text(clean($name), clean($search_term), $term_percentage);
            if(strpos($name, $search_term) !== false || $term_percentage > 90)
            {
              echo 
              "<tr>
              <td>$name</td>
              <td>$rank</td>
              </tr> \n";
              $book_not_found = FALSE;
            }
            $rank += 1;
          }        

          if($book_not_found)
          {
            echo "<br><br> <h3 class='text-center' > Book not found! </h3>";
          }

      }

      echo "</tbody>";
      echo "</table> \n";

    ?>

</div>
</section>

  <!-- Map Section -->
  <section class="page-section" id="map">

    <div class="container">
    <h2 class="text-center" > Chicago Library Map </h2>
    <iframe src="https://www.google.com.qa/maps/d/u/0/embed?mid=1Ko20Q8LhtT0BjY30g7yF4fHgvSPKY7KI" width="1140" height="480"></iframe>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-light py-5">
    <div class="container">
      <div class="small text-center text-muted">Copyright &copy; 2019 - Start Bootstrap</div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/creative.min.js"></script>


</body>

</html>
