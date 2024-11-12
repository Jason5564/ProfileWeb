function SendType(element, tableName, teacherCode){
    window.location.href = "AddPage.php?tableName=" + tableName + "&teacherCode=" + teacherCode + "&type=" + element.id;
}