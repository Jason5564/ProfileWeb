let b = document.getElementById("experience");
let c = document.getElementById("experienceContents");
b.addEventListener('click', function (event){a(c)});

let d = document.getElementById("paper");
let e = document.getElementById("paperContents");
d.addEventListener('click', function (event){a(e)});

let j = document.getElementById("plan");
let k = document.getElementById("planContents");
j.addEventListener('click', function (event){a(k)});

let m = document.getElementById("speech");
let n = document.getElementById("speechContents");
m.addEventListener('click', function (event){a(n)});

let o = document.getElementById("award");
let p = document.getElementById("awardContents");
o.addEventListener('click', function (event){a(p)});

let isMobile = false;

if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/iPhone/i)) {
    isMobile = true;
    let loginBlock = document.getElementById('loginBox');
    MobileStyle(loginBlock);
}

window.addEventListener('resize', Resize);

function Resize(){
    let viewport_width = window.innerWidth;
    let loginBlock = document.getElementById('loginBox');
    if (isMobile || viewport_width <= 1000)
        MobileStyle(loginBlock);
    else
        DesktopStyle(loginBlock);
}

function a(element){
    if (element.style.display === "block")
        element.style.display = "none";
    else
        element.style.display = "block";

}

function MobileStyle(loginBlock){
    document.querySelector("link[href='HomePage.css']").href = "HomePageMobile.css";
}

function DesktopStyle(loginBlock){
    document.querySelector("link[href='HomePageMobile.css']").href = "HomePage.css";
}