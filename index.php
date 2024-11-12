<?php
session_start();
include "GetDataFromDB.php";
include "DBConnect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="MenuBar.css">
    <link rel="stylesheet" href="HomePage.css">
    <link rel="stylesheet" href="CollapseBlock.css">
</head>
<body>
    <div class="topBar">
        <div style="border-radius: 50px; width: 30px; height: 30px; background-color: white; margin-left: 20px; margin-top: 10px;">
            <img src="resource/icon.png" width="100%" style="border: 2px white solid; box-sizing: border-box; border-radius: 50px">
        </div>

        <div class="menuBtn" style="margin-left: 25px;">
            <a href="index.php" style="background-color: #203648">Home</a>
        </div>

        <div class="menuBtn">
            <a href="EditPage.php">Edit</a>
        </div>

        <div class="menuBtn" style="margin-left: auto">
            <?php
            if(!isset($_SESSION['username']))
                echo '<a href="LoginPage.php">Login</a>';
            else
                echo '<a href="Logout.php" style="color: #ff4f4f">Logout</a>';
            ?>
        </div>
    </div>

    <div id = "center">
        <div id = "D">
            <img src="resource/head.jpg" id="photo">
            <div id = "ET">
                <div>
                    <img src="resource/email_icon.png" height="20">
                    <?php
                    $result = GetData('10001', $conn, 'person_info');
                    if($result){
                        $row = $result->fetch_assoc();
                        echo $row['email'];
                    }
                    ?>
                </div>

                <div>
                    <img src="resource/phone_icon.png" height="20">
                    <?php
                    $result = GetData('10001', $conn, 'person_info');
                    if($result){
                        $row = $result->fetch_assoc();
                        echo $row['phone'];
                    }
                    ?>
                </div>
            </div>

            <div id = "name">
                <?php
                $result = GetData('10001', $conn, 'person_info');
                if($result){
                    $row = $result->fetch_assoc();
                    echo $row['name'];
                }
                ?>
            </div>
            <div id = "P">
                <?php
                $result = GetData('10001', $conn, 'person_info');
                if($result){
                    $row = $result->fetch_assoc();
                    echo $row['position'];
                }
                ?>
            </div>
        </div>

        <div id = "infoBlock">
            <div id = "Info">Info</div>

            <div id ="academic">
                <div id = "AQ">學歷</div>
                <div style="color: white; font-size: 20px; margin-left: 10px; margin-top: 10px">
                    <?php
                    $result = GetData('10001', $conn, 'educational_background');
                    if($result){
                        $row = $result->fetch_assoc();
                        echo $row['school']. ' '. $row['department']. ' '. $row['educational_level'];
                    }
                    ?>
                </div>
            </div>

            <div id ="expertise">
                <div id = "Ex">專長</div>
                <ul style="color: white; font-size: 20px; margin-top: 10px">
                    <?php
                    $result = GetData('10001', $conn, 'skill');
                    if($result){
                        while ($row = $result->fetch_assoc()){
                            echo '<li style="margin-top: 1px">'. $row['name']. '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="bottomBlock" >
        <div class="collapseBlock" id="experience" style="font-size: 23px">經歷</div>
        <div class = "hideContents" id="experienceContents">
            <?php
            $result = GetData('10001', $conn, 'experience');
            if($result){
                $count = 0;
                while ($row = $result->fetch_assoc()){ ?>
                    <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                        <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                            <?php
                            foreach ($row as $field => $value)
                                if($value != null && $field != 'teacher_code' && $field != 'id')
                                    echo $value. '/';
                            ?>
                        </a>
                    </div> <?php
                }
            }
            ?>
        </div>

        <div class="collapseBlock" id="paper" style="font-size: 23px">論文</div>
        <div class = "hideContents" id="paperContents">
            <div>
                <div style="font-size: large; font-weight: bold; width: 100%; background-color: #ADD9F9; padding: 5px 10px; box-sizing: border-box; border-radius: 5px; margin-top: 10px;">期刊論文</div>
                <?php
                $result = GetData('10001', $conn, 'paper');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){
                        if ($row['level'] != ''){ ?>
                            <div style="z-index: 0; height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                                <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                                </a>
                            </div> <?php
                        }
                    }
                }
                ?>
            </div>

            <div>
                <div style="font-size: large; font-weight: bold; width: 100%; background-color: #ADD9F9; padding: 5px 10px; box-sizing: border-box; border-radius: 5px; margin-top: 30px;">會議論文</div>
                <?php
                $result = GetData('10001', $conn, 'paper');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){
                        if ($row['location'] != ''){ ?>
                            <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                                <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                                    <?php
                                    foreach ($row as $field => $value)
                                        if($value != null && $field != 'teacher_code' && $field != 'id')
                                            echo $value. '/';
                                    ?>
                                </a>
                            </div><?php
                        }
                    }
                }
                ?>
            </div>

            <div>
                <div style="font-size: large; font-weight: bold; width: 100%; background-color: #ADD9F9; padding: 5px 10px; box-sizing: border-box; border-radius: 5px; margin-top: 30px;">專書論文</div>
                <?php
                $result = GetData('10001', $conn, 'paper');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){
                        if ($row['agency'] != ''){ ?>
                            <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                                <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                                    <?php
                                    foreach ($row as $field => $value)
                                        if($value != null && $field != 'teacher_code' && $field != 'id')
                                            echo $value. '/';
                                    ?>
                                </a>
                            </div> <?php
                        }
                    }
                }
                ?>
            </div>

        </div>

        <div class="collapseBlock" id="plan" style="font-size: 23px">計畫</div>
        <div class = "hideContents" id="planContents">
            <div>
                <div style="font-size: large; font-weight: bold; width: 100%; background-color: #ADD9F9; padding: 5px 10px; box-sizing: border-box; border-radius: 5px; margin-top: 10px;">科技部計畫</div>
                <?php
                $result = GetData('10001', $conn, 'project');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){
                        if ($row['project_code'] != ''){ ?>
                            <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                                <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                                    <?php
                                    foreach ($row as $field => $value)
                                        if($value != null && $field != 'teacher_code' && $field != 'id')
                                            echo $value. '/';
                                    ?>
                                </a>
                            </div><?php
                        }
                    }
                }
                ?>
            </div>

            <div>
                <div style="font-size: large; font-weight: bold; width: 100%; background-color: #ADD9F9; padding: 5px 10px; box-sizing: border-box; border-radius: 5px; margin-top: 30px;">產學合作計畫</div>
                <?php
                $result = GetData('10001', $conn, 'project');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){
                        if ($row['project_code'] == ''){ ?>
                            <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                                <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                                    <?php
                                    foreach ($row as $field => $value)
                                        if($value != null && $field != 'teacher_code' && $field != 'id')
                                            echo $value. '/';
                                    ?>
                                </a>
                            </div><?php
                        }
                    }
                }
                ?>
            </div>
        </div>

        <div class="collapseBlock" id="speech" style="font-size: 23px">演講</div>
        <div class = "hideContents" id="speechContents" >
            <?php
            $result = GetData('10001', $conn, 'speech');
            if($result){
                $count = 0;
                while ($row = $result->fetch_assoc()){ ?>
                    <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                        <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                            <?php
                            foreach ($row as $field => $value)
                                if($value != null && $field != 'teacher_code' && $field != 'id')
                                    echo $value. '/';
                            ?>
                        </a>
                    </div><?php
                }
            }
            ?>
        </div>

        <div class="collapseBlock" id="award" style="font-size: 23px">獲獎</div>
        <div class = "hideContents" id="awardContents" >
            <div>
                <div style="font-size: large; font-weight: bold; width: 100%; background-color: #ADD9F9; padding: 5px 10px; box-sizing: border-box; border-radius: 5px; margin-top: 10px;">校內</div>
                <?php
                $result = GetData('10001', $conn, 'award');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){
                        if ($row['topic'] != ''){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div> <?php
                        }
                    }
                }
                ?>
            </div>

            <div>
                <div style="font-size: large; font-weight: bold; width: 100%; background-color: #ADD9F9; padding: 5px 10px; box-sizing: border-box; border-radius: 5px; margin-top: 30px;">校外</div>
                <?php
                $result = GetData('10001', $conn, 'award');
                if($result){
                    $count = 0;
                    while ($row = $result->fetch_assoc()){
                        if ($row['topic'] == ''){ ?>
                        <div style="height: 100%; width: 100%; padding: 10px; box-sizing: border-box; align-items: center; border-radius: 5px; background-color: <?php if($count++ % 2 == 0){echo 'white';}else{echo '#D2D2D2';} ?>">
                            <a style="margin-top: 10px; font-size: medium; font-weight: normal;">
                                <?php
                                foreach ($row as $field => $value)
                                    if($value != null && $field != 'teacher_code' && $field != 'id')
                                        echo $value. '/';
                                ?>
                            </a>
                        </div> <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div style="width: 100%; height: 1px; background-color: white; margin-bottom: 50px; margin-top: 50px;"></div>
</body>
<script src="HomePage.js"></script>
</html>