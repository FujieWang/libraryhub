<html>

  <head>
    <meta charset="UTF-8">
    <title>Word Cloud</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="../lib/d3/d3.js" charset="utf-8"></script>
    <script src="../lib/d3/d3.layout.cloud.js"></script>
    <script src="../d3.wordcloud.js"></script>
    <!-- <script src="words.js"></script> -->
  </head>

  <!--Start of the body-->
  <body>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav" style="background-color: #e3f2fd;">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">A class project by Fujie Wang</a>
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
              <a class="nav-link js-scroll-trigger" href="#cloud">Word cloud</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#search">Search</a>
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
            <h1 class="text-uppercase text-black font-weight-bold">I don't have a name</h1>
            <hr class="divider my-4">
          </div>
          <div class="col-lg-8 align-self-baseline">
            <p class="text-white-75 font-weight-light mb-5">Please add descriptions of this project</p>
            <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Vote Now!</a>
          </div>
        </div>
      </div>
    </header>

    <!-- Vote -->
    <section class="page-section" id="vote">
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
  
              // Datebase information
              $server_name = "localhost";
              $user_name = "root";
              $password = "Msql940825qiu#";
              $dbname = "fujiefujie";
  
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
  <!-- Word Cloud section-->
  <section class="page-section" id = "cloud">
      <div class="container">
      <!--Load Wordcloud-->
      <div class="container">
        <h2 class="text-center">WORLD COULD</h2>
        <div id='wordcloud'></div>
        </div>
        <script>
          d3.wordcloud()
            .size([1100, 850])
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

  <!-- Searchsection-->
  <section class="page-section" id = "search">
      <div class="container">
      <h2 class="text-center">SEARCH YOUR FAVOURITE BOOK</h2>
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
        echo "<table class='table'> \n";

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
          $server_name = "localhost";
          $user_name = "root";
          $password = "Msql940825qiu#";
          $dbname = "fujiefujie";

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

            }
            $rank += 1;
          }
      }

      echo "</tbody>";
      echo "</table> \n";

    ?>

      </div>
    </section>


    <!--Bootstrap JS Script-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </body>
</html>

