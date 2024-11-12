<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location: LoginPage.php?error=Need to login first");
    exit();
}

$paperTypeNames = ["期刊論文", "會議論文", "專書論文"];
$projectTypeNames = ["科技部計畫", "產學合作計畫"];
$awardTypeNames = ["校內", "校外"];

$tableName = $_GET['tableName'];
$teacherCode = $_GET['teacherCode'];
$curTypeNames = [];

switch ($tableName){
    case 'paper':
        $curTypeNames = $paperTypeNames;
        break;
    case 'project':
        $curTypeNames = $projectTypeNames;
        break;
    case 'award':
        $curTypeNames = $awardTypeNames;
        break;
}
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

    <div class="center loginBlock" style="margin-top: 150px; width: 350px; background-color: #2A475C;">
        <div class="center" style="font-size: large; color: white; font-weight: bold; text-align: center; margin-bottom: 20px; letter-spacing: 3px">選擇您要新增的項目</div>
        <?php
        for ($i = 0; $i < count($curTypeNames); $i++){ ?>
            <button class="btnSubmit center" id="<?php echo ($i + 1); ?>" onclick="SendType(this, '<?php echo $tableName; ?>', '<?php echo $teacherCode; ?>')"> <?php echo $curTypeNames[$i]; ?> </button> <?php
        } ?>
    </div>

    <script src="ChooseTypePage.js"></script>
</body>
</html>