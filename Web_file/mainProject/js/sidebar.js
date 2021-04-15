var isOpen = false;
var bigscreen = false;
var windowWidth;
var sidebarWidth = "350px";

const openbtn = document.getElementById("openbtn");
const closebtn = document.getElementById("closebtn");
const sidebar = document.getElementById("mySidebar");
const main = document.getElementById("main");
const navbar = document.getElementById("navbar");

if (window.innerWidth >= 992) {
    openbtn.hidden = true;
    closebtn.hidden = true;
    sidebar.style.width = sidebarWidth;
    main.style.marginLeft = sidebarWidth;
    isOpen = true;
    bigscreen = true;
}

function moveNav() {
    windowWidth = window.innerWidth
    if (isOpen) {
        sidebar.style.width = "0";
        main.style.marginLeft = "0";
        isOpen = false;
    }
    else if (!isOpen && windowWidth <= 575) {
        sidebar.style.width = "100vw";
        main.style.marginLeft = "100vw";
        isOpen = true;
    }
    else{
        sidebar.style.width = sidebarWidth;
        main.style.marginLeft = sidebarWidth;
        isOpen = true;
    }
}

window.onresize = function(){
    windowWidth = window.innerWidth;
    if (!bigscreen) {
        openbtn.hidden = false;
        closebtn.hidden = false;
        navbar.style.paddingLeft = "10px";
        if (windowWidth >= 992) {
            bigscreen = true;
            openbtn.hidden = true;
            closebtn.hidden = true;
            sidebar.style.width = sidebarWidth;
            main.style.marginLeft = sidebarWidth;
            navbar.style.paddingLeft = "100px";
        }
        if (windowWidth <= 575 && isOpen) {
            sidebar.style.width = windowWidth + "px";
            main.style.marginLeft = windowWidth + "px";
        }
        else if (windowWidth > 575 && isOpen) {
            sidebar.style.width = sidebarWidth;
            main.style.marginLeft = sidebarWidth;
        }
    }
    else if (bigscreen && windowWidth < 992) {
        bigscreen = false;
        sidebar.style.width = "0";
        main.style.marginLeft = "0";
    }
}