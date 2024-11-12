let idArray1 = ['personalInfo', 'educationalBackground', 'skill', 'award', 'experience', 'paper', 'project', 'speech'];
let idArray2 = ['personalInfoContent', 'educationalBackgroundContent', 'skillContent', 'awardContent', 'experienceContent', 'paperContent', 'projectContent', 'speechContent'];

for(let i = 0; i < idArray1.length; i++){
    let temp = document.getElementById(idArray1[i]);
    temp.addEventListener('click', function (e){Collapse(document.getElementById(idArray2[i]))})
}

function Collapse(element){
    if(element.style.display === 'grid')
        element.style.display = 'none';
    else
        element.style.display = 'grid';
}

function Delete(element){
    let str = element.id.split(',');
    if(window.confirm("確定要刪除嗎?"))
        window.location.href = 'Delete.php?tableName=' + str[0] + '&id=' + str[1];
}

function OpenDialog(){
    let tmp = document.getElementById('searchDialog');
    tmp.showModal();
}

function CloseDialog(){
    let tmp = document.getElementById('searchDialog');
    tmp.close();
}

function SetCookie(){
    let searchTable = document.getElementById('tableSelector').innerText;
    let searchField = document.getElementById('fieldSelector').innerText;
    let searchBar = document.getElementById('searchBar').innerText;

    document.cookie = "searchTable=" + searchTable + ";searchField=" + searchField + ";searchBar=" + searchBar;
}

function Extract(key, cookie){
    let a = cookie.split(";");
    a.forEach((el) => {
        let e = el.split("=");
        if(e[0] === key) {
            return e[1];
        }
    });
}

let educationalBackground = {
    "school": "學校",
    "department": "科系",
    "educational_level": "學位"
};

let skill = {
    "name": "專長"
};

let award = {
    "award_name": "獲獎名稱",
    "location": "地點",
    "date": "日期",
    "topic": "獲獎主題"
}

let experience = {
    "department": "單位",
    "position": "職位",
}

let paper = {
    "author": "作者",
    "name": "論文名稱",
    "date": "日期",
    "book_name": "書名",
    "level": "等級",
    "location": "地點",
    "agency": "認證機構",
}

let project = {
    "project_name": "計畫名稱",
    "start_date": "起始日期",
    "end_date": "結束日期",
    "project_code": "計畫代號",
    "position": "職位",
}
let speech = {
    "topic": "主題",
    "organizer": "主辦方",
    "date": "日期",
}

let options = {
    "educational_background": educationalBackground,
    "skill": skill,
    "award": award,
    "experience": experience,
    "paper": paper,
    "project": project,
    "speech": speech,
};

function SelectChanged(selectedValue){
    let fieldSelector = document.getElementById('fieldSelector')
    let removeOptions = fieldSelector.querySelectorAll("option");

    for(let i = 0; i < removeOptions.length; i++){
        fieldSelector.removeChild(removeOptions[i]);
    }

    let fieldOptions = options[selectedValue];
    for(const [key, value] of Object.entries(fieldOptions)){
        let option = document.createElement("OPTION");
        option.value = key;
        option.innerHTML = value;
        fieldSelector.add(option);
    }
}

SelectChanged("educational_background");