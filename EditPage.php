<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location: LoginPage.php?error=Need to login first");
    exit();
}

include "GetDataFromDB.php";
include "DBConnect.php";
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
    <link rel="stylesheet" href="EditPage.css">
    <link rel="stylesheet" href="CollapseBlock.css">
</head>
<body>
    <div class="topBar" style="z-index: 10; position: relative;">
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

    <div class="center" style="margin-top: -1px; z-index: 0; position: relative; width: 600px;">
        <button id="searchBtn" onclick="OpenDialog()">search</button>
    </div>


    <dialog id="searchDialog">
        <div class="close-container" onclick="CloseDialog()" style="float: right">
            <div class="leftright"></div>
            <div class="rightleft"></div>
        </div><br><br>

        <form method="post" style="display: flex; margin-bottom: 50px; justify-content: right;">
            <select id="tableSelector" name="tableSelector" onchange="SelectChanged(this.value)" style="font-size: 15px;">
                <option value="educational_background">學歷</option>
                <option value="skill">專長</option>
                <option value="award">獲獎</option>
                <option value="experience">經歷</option>
                <option value="paper">論文</option>
                <option value="project">計畫</option>
                <option value="speech">演講</option>
            </select>
            <select id="fieldSelector" name="fieldSelector" style="font-size: 15px; margin-left: 5px;"></select>

            <input type="search" id="searchBar" name="searchText" required placeholder="search">
            <input type="submit" id="searchSubmit" name="submit" value="搜尋">
        </form>

        <?php
        if(isset($_POST['submit'])){ ?>
            <script>
                document.getElementById('searchDialog').showModal();
                if (window.history.replaceState) {
                    window.history.replaceState( null, null, window.location.href );
                }
            </script>
            <?php
            $result = GetDataWithCondition('10001', $_POST['fieldSelector'],  $_POST['searchText'], $conn, $_POST['tableSelector']);
            if($result){
                $count = 0;
                while ($row = $result->fetch_assoc()){ ?>
                    <div style="display: grid; grid-template-columns: 87% 13%; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; display: flex; align-items: center; justify-content: flex-start; border-radius: 5px 0 0 5px;">
                            <a style="font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div>

                        <div style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 0 5px 5px 0;">
                            <a href="Editor.php?teacherCode=10001&tableName=<?php echo $_POST['tableSelector']; ?>&id=<?php echo $row['id'] ?>" style="margin-right: 10px; text-decoration:none;">編輯</a>
                            <a onclick="Delete(this)" id="educational_background,<?php echo $row['id'] ?>" class="deleteBtn" style="color: #ff4f4f; text-decoration:none;">刪除</a>
                        </div>
                    </div> <?php
                }
            }
            else { ?>
                <div class='center' style="color: #ff4f4f; font-size: large; font-family: 'Noto Sans TC', sans-serif; width: 200px; margin-top: 0">not thing found!</div><?php
            }
        } ?>
    </dialog>

    <div class="center">
        <div>
            <div id="personalInfo" class="collapseBlock" style="display: flex;">
                個人資料
            </div>

            <div id="personalInfoContent" class="hideContents">
                <?php
                    $result = GetData('10001', $conn, 'person_info');
                    if($result){
                        $row = $result->fetch_assoc();
                        echo '<a>'. $row['name']. '  '. $row['position']. '  '. $row['phone']. '  '. $row['email']. '</a><a href="Editor.php?teacherCode=10001&tableName=person_info&id=null" style="justify-self: right; text-decoration:none;">編輯</a>';
                    }
                ?>
            </div>
        </div>

        <div>
            <div id="educationalBackground" class="collapseBlock" style="display: flex;">
                學歷
                <div style="justify-self: end; margin-left: auto; height: 100%; background-color: #679876; padding: 2px 5px 2px 5px; border-radius: 5px; box-sizing: border-box; display: flex; align-items: center;">
                    <a href="AddPage.php?tableName=educational_background&teacherCode=10001" style="color: white; text-decoration: none; font-size: small; letter-spacing: 2px">新增</a>
                </div>
            </div>


            <div id="educationalBackgroundContent" class="hideContents">
                <?php
                $result = GetData('10001', $conn, 'educational_background');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; display: flex; align-items: center; justify-content: flex-start; border-radius: 5px 0 0 5px; background-color: <?php if($count % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div>

                        <div style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 0 5px 5px 0; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a href="Editor.php?teacherCode=10001&tableName=educational_background&id=<?php echo $row['id'] ?>" style="margin-right: 10px; text-decoration:none;">編輯</a>
                            <a onclick="Delete(this)" id="educational_background,<?php echo $row['id'] ?>" class="deleteBtn" style="color: #ff4f4f; text-decoration:none;">刪除</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div>
            <div id="skill" class="collapseBlock" style="display: flex;">
                專長
                <div style="justify-self: end; margin-left: auto; height: 100%; background-color: #679876; padding: 2px 5px 2px 5px; border-radius: 5px; box-sizing: border-box; display: flex; align-items: center;">
                    <a href="AddPage.php?tableName=skill&teacherCode=10001" style="color: white; text-decoration: none; font-size: small; letter-spacing: 2px">新增</a>
                </div>
            </div>

            <div id="skillContent" class="hideContents">
                <?php
                $result = GetData('10001', $conn, 'skill');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; display: flex; align-items: center; justify-content: flex-start; border-radius: 5px 0 0 5px; background-color: <?php if($count % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div>

                        <div style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 0 5px 5px 0; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a href="Editor.php?teacherCode=10001&tableName=skill&id=<?php echo $row['id'] ?>" style="margin-right: 10px; text-decoration:none;">編輯</a>
                            <a onclick="Delete(this)" id="skill,<?php echo $row['id'] ?>" class="deleteBtn" style="color: #ff4f4f; text-decoration:none;">刪除</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div>
            <div id="award" class="collapseBlock" style="display: flex">
                獲獎
                <div style="justify-self: end; margin-left: auto; height: 100%; background-color: #679876; padding: 2px 5px 2px 5px; border-radius: 5px; box-sizing: border-box; display: flex; align-items: center;">
                    <a href="AddPage.php?tableName=award&teacherCode=10001" style="color: white; text-decoration: none; font-size: small; letter-spacing: 2px">新增</a>
                </div>
            </div>

            <div id="awardContent" class="hideContents">
                <?php
                $result = GetData('10001', $conn, 'award');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; display: flex; align-items: center; justify-content: flex-start; border-radius: 5px 0 0 5px; background-color: <?php if($count % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div>

                        <div style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 0 5px 5px 0; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a href="Editor.php?teacherCode=10001&tableName=award&id=<?php echo $row['id'] ?>" style="margin-right: 10px; text-decoration:none;">編輯</a>
                            <a onclick="Delete(this)" id="award,<?php echo $row['id'] ?>" class="deleteBtn" style="color: #ff4f4f; text-decoration:none;">刪除</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div>
            <div id="experience" class="collapseBlock" style="display: flex">
                經歷
                <div style="justify-self: end; margin-left: auto; height: 100%; background-color: #679876; padding: 2px 5px 2px 5px; border-radius: 5px; box-sizing: border-box; display: flex; align-items: center;">
                    <a href="AddPage.php?tableName=experience&teacherCode=10001" style="color: white; text-decoration: none; font-size: small; letter-spacing: 2px">新增</a>
                </div>
            </div>

            <div id="experienceContent" class="hideContents">
                <?php
                $result = GetData('10001', $conn, 'experience');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; display: flex; align-items: center; justify-content: flex-start; border-radius: 5px 0 0 5px; background-color: <?php if($count % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div>

                        <div style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 0 5px 5px 0; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a href="Editor.php?teacherCode=10001&tableName=experience&id=<?php echo $row['id'] ?>" style="margin-right: 10px; text-decoration:none;">編輯</a>
                            <a onclick="Delete(this)" id="experience,<?php echo $row['id'] ?>" class="deleteBtn" style="color: #ff4f4f; text-decoration:none;">刪除</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div>
            <div id="paper" class="collapseBlock" style="display: flex">
                論文
                <div style="justify-self: end; margin-left: auto; height: 100%; background-color: #679876; padding: 2px 5px 2px 5px; border-radius: 5px; box-sizing: border-box; display: flex; align-items: center;">
                    <a href="AddPage.php?tableName=paper&teacherCode=10001" style="color: white; text-decoration: none; font-size: small; letter-spacing: 2px">新增</a>
                </div>
            </div>

            <div id="paperContent" class="hideContents">
                <?php
                $result = GetData('10001', $conn, 'paper');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; display: flex; align-items: center; justify-content: flex-start; border-radius: 5px 0 0 5px; background-color: <?php if($count % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div>

                        <div style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 0 5px 5px 0; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a href="Editor.php?teacherCode=10001&tableName=paper&id=<?php echo $row['id'] ?>" style="margin-right: 10px; text-decoration:none;">編輯</a>
                            <a onclick="Delete(this)" id="paper,<?php echo $row['id'] ?>" class="deleteBtn" style="color: #ff4f4f; text-decoration:none;">刪除</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div>
            <div id="project" class="collapseBlock" style="display: flex">
                計畫
                <div style="justify-self: end; margin-left: auto; height: 100%; background-color: #679876; padding: 2px 5px 2px 5px; border-radius: 5px; box-sizing: border-box; display: flex; align-items: center;">
                    <a href="AddPage.php?tableName=project&teacherCode=10001" style="color: white; text-decoration: none; font-size: small; letter-spacing: 2px">新增</a>
                </div>
            </div>

            <div id="projectContent" class="hideContents">
                <?php
                $result = GetData('10001', $conn, 'project');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; display: flex; align-items: center; justify-content: flex-start; border-radius: 5px 0 0 5px; background-color: <?php if($count % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div>

                        <div style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 0 5px 5px 0; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a href="Editor.php?teacherCode=10001&tableName=project&id=<?php echo $row['id'] ?>" style="margin-right: 10px; text-decoration:none;">編輯</a>
                            <a onclick="Delete(this)" id="project,<?php echo $row['id'] ?>" class="deleteBtn" style="color: #ff4f4f; text-decoration:none;">刪除</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div>
            <div id="speech" class="collapseBlock" style="display: flex">
                演講
                <div style="justify-self: end; margin-left: auto; height: 100%; background-color: #679876; padding: 2px 5px 2px 5px; border-radius: 5px; box-sizing: border-box; display: flex; align-items: center;">
                    <a href="AddPage.php?tableName=speech&teacherCode=10001" style="color: white; text-decoration: none; font-size: small; letter-spacing: 2px">新增</a>
                </div>
            </div>

            <div id="speechContent" class="hideContents">
                <?php
                $result = GetData('10001', $conn, 'speech');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; display: flex; align-items: center; justify-content: flex-start; border-radius: 5px 0 0 5px; background-color: <?php if($count % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div>

                        <div style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 0 5px 5px 0; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a href="Editor.php?teacherCode=10001&tableName=speech&id=<?php echo $row['id'] ?>" style="margin-right: 10px; text-decoration:none;">編輯</a>
                            <a onclick="Delete(this)" id="speech,<?php echo $row['id'] ?>" class="deleteBtn" style="color: #ff4f4f; text-decoration:none;">刪除</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
<script src="EditPage.js"></script>
</html>
