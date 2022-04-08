<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
  // include 'partials/_dbconnect.php';
  $id = $_GET['threadid'];
  $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $title = $row['thread_title'];
  $desc = $row['thread_desc'];
  $thread_user_id = $row['thread_user_id'];
  // var_dump($thread_user_id); die;
  // $id = $row['thread_id'];
  $sql3 = "SELECT * FROM `users` WHERE sno=$thread_user_id";
  $result3 = mysqli_query($conn, $sql3);
  $row3 = mysqli_fetch_assoc($result3);
  $posted_by = $row3['user_name'];
  ?>

  <!-- category container starts here -->

  <!-- <?php echo $title; ?> -->
  <div class="container my-3">
    <div class="jumbotron">
      <h1 class="display-4"><?php echo $title ?></h1>
      <p class="lead"> <?php echo $desc ?> </p>
      <hr class="my-4">
      <p style="color: red; font-size: 20px;"><strong>Note: Follow the forum rules .</strong></p>
      <p class="lead">
        Posted by : <?php echo "<em><b>". $posted_by ."</b></em> "?>
      </p>
    </div>
  </div>

<?php
  $showAlert = false;
  $method = $_SERVER['REQUEST_METHOD'];
  if ($method == 'POST') {
    $comment = $_POST['comment'];
    $comment=str_replace("<", "&lt", $comment);
    $comment=str_replace(">", "&gt", $comment);
    // $comment_by = $_POST['comment_by'];
    $sno=$_POST['sno'];
    
    $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$comment', '$id', current_timestamp(), '$sno');";

    $result = mysqli_query($conn, $sql);
    $showAlert = true;
    if ($showAlert) {
      echo  '<div id="insertAlert" class="px-5 mx-5 alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success ! </strong> Your comment has been added.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  ?>

<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '
      <div class="container">
      <h2>Comment here</h1>
      <form action="' . $_SERVER['REQUEST_URI'].'" method="POST">
      
      <div class="form-group">
      <label for="comment">Post your comment here</label>
      <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
      <input type="hidden" name="sno" value=" '. $_SESSION["sno"] .' ">
        </div>

        <button type="submit" class="btn btn-success mt-2">Post comment</button>
      </form>
  </div>';
    }else{
      echo '
      <div class="container my-0">
        <p class="lead" style="font-size:40px">You are not loggedIn yet, please login to post your comments.</p>
      </div>
      
      ';
    }

?>


  <!-- <div class="container">
    <h2>Comment here</h1>
      <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">

        <div class="form-group">
          <label for="comment">Post your comment here</label>
          <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-2">Post comment</button>
      </form>
  </div> -->



  <div class="container my-4">
    <h1>Discussions :</h1>


    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while ($row = mysqli_fetch_assoc($result)) {
      $noResult = false;
      $content = $row['comment_content'];
      $id = $row['comment_id'];
      $comment_time = $row['comment_time'];
      $thread_user_id = $row['comment_by'];
      $sql2="SELECT user_name FROM `users` WHERE sno='$thread_user_id'";
      $result2= mysqli_query($conn, $sql2);
      $row2=mysqli_fetch_assoc($result2);
      $user_name= $row2['user_name'];
      // var_dump($user_name);
      echo ' <div class="container my-3">
        
        <div class="d-flex border p-3">
            <img src="./img/user.png" alt="John Doe"
                class="rounded-circle" style="width:100px;height:60px;">
            <div class="ms-3">
            
                <p>
                ' . $content . '
                </p>
                <p class="font-weight-bold py-0" style="font-weight: bold;">'. $user_name .' <span style="color: rgb(102, 102, 102);">at '. $comment_time .'</span></p>
            </div>
        </div>
        </div>';
      if ($noResult) {
        echo '<div class="alert alert-success text-center" role="alert">
    <strong>There is no comment for this particular question ! Be the first one to answer.
  </div>';
      }
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