<?php
$showError="false";
if($_SERVER['REQUEST_METHOD']== 'POST'){
    include '_dbconnect.php';
    $user_name = $_POST['signupName'];
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupCPassword'];

    //check whether this email exists or not 
    $existsql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existsql);

    // var_dump($result); die;
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        $showError = "Email already in use";
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` ( `user_name`, `user_email`, `user_pass`, `timestamp`) VALUES ( '$user_name', '$user_email', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
                header("Location: /ITFORUM/index.php?signupsuccess=true");
                exit();
            }
        }else{
            $showError="Password did not match";
        }
    }
    header("Location: /ITFORUM/index.php?signupsuccess=false&error=$showError");

}



?>