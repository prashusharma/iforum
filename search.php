<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <title>It Forum</title>
  <style>
      .container{
          min-height: 85vh;
      }
      
    .jumbotron {
      padding: 2rem 1rem;
      margin-bottom: 2rem;
      background-color: #e9ecef;
      border-radius: .3rem;
    }
  
  </style>
</head>

<body>
  <?php include 'partials/_dbconnect.php' ?>
  <?php include 'partials/_header.php' ?>


              <!-- search results here -->

    <div class="container my-3">
        <h1>Search results for <em>"<?php echo $_GET['search'] ?>"</em></h1>
        <?php
    $query = $_GET['search'];
    $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title, thread_desc) against('$query')";
    $result = mysqli_query($conn, $sql);
    $noResult=true;
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_id = $row['thread_id'];
        $url="thread.php?threadid=".$thread_id;
        $noResult=false;

        echo '
        <div class="results py-2">
            <h4><a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
            <p>'.$desc.'</p>
        </div>
        ';
    }
    if($noResult){
        echo '
        <div class="jumbotron">
      <h1 class="display-4">No results found</h1>
      <p class="lead"> <ul>
      Suggestions:
      
      <li>Make sure that all words are spelled correctly.</li>
      <li>Try different keywords.</li>
      <li>Try more general keywords.</li>
      </ul> </p>
      <hr class="my-4">
      <p style="color: red; font-size: 20px;"><strong>Note: Follow the forum rules .</strong></p>
      
    </div>';
    }
?>

    </div>

  <?php include 'partials/_footer.php' ?>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>