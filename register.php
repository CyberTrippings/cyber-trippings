<?php 
session_start();
include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName = trim($_POST['fName']);
    $lastName = trim($_POST['lName']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password = md5($password);

    $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        echo "Email Address Already Exists !";
    } else {
        $verification_code = strval(rand(100000, 999999));
        $insert = $conn->prepare('INSERT INTO users(firstName,lastName,email,password,is_verified,verification_code) VALUES (?, ?, ?, ?, 0, ?)');
        $insert->bind_param('sssss', $firstName, $lastName, $email, $password, $verification_code);
        if($insert->execute()){
            $_SESSION['pending_email'] = $email;
            $_SESSION['verification_code'] = $verification_code;
            header('Location: verify.php');
            exit();
        } else {
            echo 'Error:' . $conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
   $email = trim($_POST['email']);
   $password = trim($_POST['password']);
   $password = md5($password);

   $stmt = $conn->prepare('SELECT email, is_verified FROM users WHERE email = ? AND password = ?');
   $stmt->bind_param('ss', $email, $password);
   $stmt->execute();
   $result = $stmt->get_result();

   if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    if($row['is_verified'] == 0){
        $_SESSION['pending_email'] = $email;
        header('Location: verify.php');
        exit();
    }
    $_SESSION['email'] = $row['email'];
    header('Location: homepage.php');
    exit();
   }
   else{
    echo "Not Found, Incorrect Email or Password";
   }
}
?>