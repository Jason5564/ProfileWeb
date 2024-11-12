<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location: LoginPage.php?error=Need to login first");
    exit();
}

include "GetDataFromDB.php";
include "DBConnect.php";
include "FieldNames.php";

$tableName = $_GET['tableName'];
$teacherCode = $_GET['teacherCode'];
$id = $_GET['id'];

$names = [];
$result = null;

switch ($_GET['tableName']){
    case 'person_info':
        $names = $personalInfo;
        $result = GetData($teacherCode, $conn, $tableName);
        break;
    case 'award':
        $names = $award;
        $result = GetDataById($teacherCode, $id, $conn, $tableName);
        break;
    case 'experience':
        $names = $experience;
        $result = GetDataById($teacherCode, $id, $conn, $tableName);
        break;
    case 'paper':
        $names = $paper;
        $result = GetDataById($teacherCode, $id, $conn, $tableName);
        break;
    case 'project':
        $names = $project;
        $result = GetDataById($teacherCode, $id, $conn, $tableName);
        break;
    case 'speech':
        $names = $speech;
        $result = GetDataById($teacherCode, $id, $conn, $tableName);
        break;
    case 'educational_background':
        $names = $educationalBackground;
        $result = GetDataById($teacherCode, $id, $conn, $tableName);
        break;
    case 'skill':
        $names = $skill;
        $result = GetDataById($teacherCode, $id, $conn, $tableName);
        break;
}
$row = $result->fetch_assoc();
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
            $i = 0;
            foreach ($row as $field => $value){
                if($field != 'teacher_code' && $field != 'id') {
                    if($value != ''){ ?>
                    <input type="text" class="center inputBox" required name="<?php echo $names[$i] ?>" placeholder="<?php echo $names[$i] ?>" value="<?php echo $value ?>" style="width: 70%; height: 28px;"><br><?php
                    }
                    $i++;
                }
            } ?>
            <input type="submit" name="submit" value="修改" class="center btnSubmit">
        </form>

        <?php
        if(isset($_POST["submit"])){
            $sql = "UPDATE $tableName SET ";

            $i = 0;
            $count = 0;
            foreach ($row as $field => $value){
                if($count++ > 0)
                    $sql = $sql. ",";

                if($field == 'teacher_code' || $field == 'id')
                    $sql = $sql. $field. "=". $value;
                else if(isset($_POST[$names[$i]])){
                    $sql = $sql. $field. "=". "'". $_POST[$names[$i]]. "'";
                    $i++;
                }
                else{
                    $sql = $sql. $field. "='' ";
                    $i++;
                }
            }

            if($id == 'null')
                $sql = $sql. "WHERE teacher_code='$teacherCode'";
            else
                $sql = $sql. "WHERE teacher_code='$teacherCode' AND id='$id'";

            if ($conn->query($sql) === TRUE)
                echo '<script>alert("修改成功");window.location.href = "EditPage.php";</script>';
            else
                echo $sql. '<script>alert("修改失敗")</script>';
        }
        ?>
    </div>
</body>
</html>