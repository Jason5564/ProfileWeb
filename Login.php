<?php
session_start();

include "DBConnect.php";

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username)){
        header("Location: LoginPage.php?error=User Name is required");
        exit();
    }else if(empty($password)){
        header("Location: LoginPage.php?error=Password is required");
        exit();
    }else{
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $password) {
                echo "Logged in!";
                $_SESSION['username'] = $row['username'];

                header("Location: EditPage.php");
                exit();
            }else{
                header("Location: LoginPage.php?error=Incorect User name or password");
                exit();
            }
        }else{
            header("Location: LoginPage.php?error=Incorect User name or password");
            exit();
        }
    }
}
else{
    header("Location: LoginPage.php");
    exit();
}

?>