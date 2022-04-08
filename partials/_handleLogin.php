<?php

if($_SERVER['REQUEST_METHOD']== 'POST'){
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];
    // $pass = password_hash($pass, PASSWORD_DEFAULT);
    // var_dump($email); die;

    $sql = "SELECT * from `users` where user_email = '$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        $row = mysqli_fetch_assoc($result);
        $hash=$row['user_pass'];
        // var_dump($pass, $hash); die;
        if(password_verify($pass, $hash)){
        // if($pass==$hash){
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['sno']=$row['sno'];
            $_SESSION['useremail']=$email;
            // echo "logged in ". $email;
            header("Location:/itforum");
        }else{
            // echo "something went wrong";
            header("Location:/itforum");
        }
        // header("Location: /itforum/index.php");
    }
}


?>