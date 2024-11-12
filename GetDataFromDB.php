<?php
function GetData($teacherCode, $conn, $tableName){
    $sql = "SELECT * FROM $tableName where teacher_code='$teacherCode'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
    return null;
}

function GetDataById($teacherCode, $id, $conn, $tableName){
    $sql = "SELECT * FROM $tableName where teacher_code='$teacherCode' AND id='$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
    return null;
}

function GetDataWithCondition($teacherCode, $fieldName, $value, $conn, $tableName){
    if ($value != ''){
        $sql = "SELECT * FROM $tableName where teacher_code='$teacherCode' AND $fieldName LIKE '%$value%'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    return null;
}

?>