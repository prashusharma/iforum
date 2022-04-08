<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>It Forum</title>
  <style>
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

  <?php
  $id = $_GET['catid'];
  $sql = "SELECT * FROM `categories` WHERE category_id=$id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
  }
  ?>


  <?php
  $showAlert = false;
  $method = $_SERVER['REQUEST_METHOD'];
  if ($method == 'POST') {
    $th_title = $_POST['title'];
    $th_desc = $_POST['desc'];
    $th_title=str_replace("<", "&lt", $th_title);
    $th_title=str_replace(">", "&gt", $th_title);
    $th_desc=str_replace("<", "&lt", $th_desc);
    $th_desc=str_replace(">", "&gt", $th_desc);
    $sno=$_POST['sno'];

    
    $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp());";
    $result = mysqli_query($conn, $sql);
    $showAlert = true;
    if ($showAlert) {
      echo  '<div id="insertAlert" class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong>Your queries posted succesfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  ?>
  <!-- category container starts here -->


  <div class="container my-3">
    <div class="jumbotron">
      <h1 class="display-4">Welcome to <?php echo $catname; ?> forum</h1>
      <p class="lead"> <?php echo $catdesc; ?> </p>
      <hr class="my-4">
      <p>1. No Spam / Advertising / Self-promote in the forums. <br>
        2. Do not post copyright-infringing material. <br>
        3. Do not post “offensive” posts, links or images. <br>
        4. Do not cross post questions. <br>
        5. Do not PM users asking for help. </p>
      <p class="lead">
        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
      </p>
    </div>
  </div>
<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '
      <div class="container">
      <h2>Start a discussion !</h1>
        <form action="' . $_SERVER['REQUEST_URI']. '" method="POST">
          <div class="form-group">
            <label for="title">Question title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">Please keep your questions short and simple</small>
          </div>
          <input type="hidden" name="sno" value=" '. $_SESSION["sno"] .' ">
          <div class="form-group">
            <label for="desc">Ellaborate your question</label>
            <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
          </div>
  
          <button type="submit" class="btn btn-success mt-2">Submit</button>
        </form>
    </div>';
    }else{
      echo '
      <div class="container my-0">
        <p class="lead" style="font-size:40px">You are not loggedIn yet, please login to start discussion.</p>
      </div>
      
      ';
    }

?>
  


  <div class="container my-4">
    <h1>Browse questions :</h1>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while ($row = mysqli_fetch_assoc($result)) {
      $noResult = false;
      $title = $row['thread_title'];
      $desc = $row['thread_desc'];
      $id = $row['thread_id'];
      $time_stamp = $row['timestamp'];
      $thread_user_id = $row['thread_user_id'];
      $sql2="SELECT user_name FROM `users` WHERE sno='$thread_user_id'";
      $result2= mysqli_query($conn, $sql2);
      $row2=mysqli_fetch_assoc($result2);

      echo ' <div class="container" id="questions">
    
    <div class="d-flex border p-3 my-2">
        <img src="./img/user.png" alt="John Doe"
            class=" rounded-circle" style="width:100px;height:60px;">
        <div>
        
            <h5><small><a class="text-dark" href="thread.php?threadid=' . $id . '">' . $title . '</a></small></h5>
            <p>' . $desc . '</p>
            <h6>Asked by '. $row2['user_name'] .' <span style="color: rgb(102, 102, 102);">at '. $time_stamp .'</span> </h6>
        </div>
    </div>
    </div>';
    }
    if ($noResult) {
      echo '<div class="alert alert-success text-center" role="alert">
      <strong>No questions found ! </strong> Be the first person to ask your queries...
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