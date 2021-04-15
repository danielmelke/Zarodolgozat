"use strict"

const body = document.querySelector("body");
const title = document.title;

if (title == "Bejelentkezés" || title == "Regisztráció") {
    body.style.background = 'url("img/sample2.jpg") no-repeat';
}
else if (title == "Főoldal" || title == "Profil" || title == "Saját posztok" || title == "Saját hírdetések") {
    body.style.background = 'url("img/sample1.jpg") no-repeat';
}
else if (title == "Posztok" || title == "Új poszt létrehozása" || title == "Poszt szerkesztése" || title == "Poszt megtekintése") {
    body.style.background = 'url("img/sample3.jpg") no-repeat';
}
else if (title == "Az oldalról") {
    body.style.background = 'url("img/sample4.jpg") no-repeat';
}
else if (title == "Keres-kínál hírdetések" || title == "Hírdetés megtekintése" || title == "Új hírdetés létrehozása" || title == "Hírdetés szerkesztése") {
    body.style.background = 'url("img/sample5.jpg") no-repeat';
}