<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location: LoginPage.php?error=Need to login first");
    exit();
}

include "DBConnect.php";
include "FieldNames.php";

$tableName = $_GET['tableName'];
$teacherCode = $_GET['teacherCode'];

$names = [];
$result = null;

switch ($_GET['tableName']){
    case 'person_info':
        $names = $personalInfo;
        break;
    case 'award':
        if(isset($_GET['type'])){
            switch ($_GET['type']){
                case '1':
                    $names = $awardType1;
                    break;
                case '2':
                    $names = $awardType2;
                    break;
            }
        }
        else
            header("location: ChooseTypePage.php?tableName=$tableName&teacherCode=$teacherCode");
        break;
    case 'experience':
        $names = $experience;
        break;
    case 'paper':
        if(isset($_GET['type'])){
            switch ($_GET['type']){
                case '1':
                    $names = $paperType1;
                    break;
                case '2':
                    $names = $paperType2;
                    break;
                case '3':
                    $names = $paperType3;
                    break;
            }
        }
        else
            header("location: ChooseTypePage.php?tableName=$tableName&teacherCode=$teacherCode");
        break;
    case 'project':
        if(isset($_GET['type'])){
            switch ($_GET['type']){
                case '1':
                    $names = $projectType1;
                    break;
                case '2':
                    $names = $projectType2;
                    break;
            }
        }
        else
            header("location: ChooseTypePage.php?tableName=$tableName&teacherCode=$teacherCode");
        break;
    case 'speech':
        $names = $speech;
        break;
    case 'educational_background':
        $names = $educationalBackground;
        break;
    case 'skill':
        $names = $skill;
        break;
}

$sql = "SELECT MAX(id) AS `id` FROM $tableName WHERE 1";
$result = mysqli_query($conn, $sql);
$id = $result->fetch_assoc()['id'] + 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="MenuBar.css">
    <link rel="stylesheet" href="LoginPage.css">
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
            <a href="EditPage.php" style="background-color: #203648">Edit</a>
        </div>

        <div class="menuBtn" style="margin-left: auto">
            <a href="Logout.php" style="color: #ff4f4f">Logout</a>
        </div>
    </div>

    <div style="margin-left: auto; margin-right: auto; width: 400px; background-color: #2A475C; margin-top: 100px; padding: 70px 0; box-sizing: border-box; border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
        <div style="font-size: 15px; text-align: center; margin-bottom: 20px; font-family: 'Noto Sans TC', sans-serif; font-weight: bolder; letter-spacing: 10px; color: white;">EDITOR</div>
        <form method="post" style="width: 100%">
            <?php
            foreach ($names as $field => $name){
                if ($name != ''){ ?>
                <input type="text" class="center inputBox" required name="<?php echo $name ?>" placeholder="<?php echo $name ?>" style="width: 70%; height: 28px;"><br> <?php
                }
            } ?>
            <input type="submit" name="submit" value="新增" class="center btnSubmit">
        </form>

        <?php
        if(isset($_POST["submit"])){
            $sql = "INSERT INTO $tableName VALUES ($teacherCode, $id";

            for ($i = 0; $i < count($names); $i++){
                if (isset($_POST[$names[$i]]))
                    $sql = $sql. ",'". $_POST[$names[$i]]. "'";
                else
                    $sql = $sql. ",''";
            }
            $sql = $sql. ")";

            if ($conn->query($sql) === TRUE)
                echo '<script>alert("新增成功");window.location.href = "EditPage.php";</script>';
            else
                echo $sql. '<script>alert("新增失敗")</script>';
        }
        ?>
    </div>
</body>
</html>