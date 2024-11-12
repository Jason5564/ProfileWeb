<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="LoginPage.css">
    <link rel="stylesheet" href="MenuBar.css">
</head>
<body>
    <div class="topBar">
        <div style="border-radius: 50px; width: 30px; height: 30px; background-color: white; margin-left: 20px; margin-top: 10px;">
            <img src="resource/icon.png" width="100%" style="border: 2px white solid; box-sizing: border-box; border-radius: 50px">
        </div>

        <div class="menuBtn" style="margin-left: 25px;">
            <a href="index.php">Home</a>
        </div>

        <div class="menuBtn">
            <a href="EditPage.php">Edit</a>
        </div>

        <div class="menuBtn" style="margin-left: auto">
            <a href="LoginPage.php" style="background-color: #203648">Login</a>
        </div>
    </div>

    <div class="loginBlock center" style="margin-top: 150px">
        <div style="font-size: 35px; font-family: 'Noto Sans TC', sans-serif; font-weight: bold; color: white; text-align: center; letter-spacing: 6px;">
            LOGIN
        </div>

        <form action="Login.php" method="post" class="loginForm">
            <?php if (isset($_GET['error'])) { ?>
                <p class="error" style="color: #ff4f4f; text-align: center; font-family: 'Noto Sans TC', sans-serif;"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <input type="text" name="username", placeholder="Username" required="required" class="center inputBox">
            <br>
            <input type="password" name="password", placeholder="Password" required="required" class="center inputBox">
            <br>

            <input type="submit" value="Submit" class="center btnSubmit">
            
        </form>
    </div>

</body>
</html>