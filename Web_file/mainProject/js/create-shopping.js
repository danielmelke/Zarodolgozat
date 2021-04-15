"use strict"

const shoppingSelect = document.querySelector("#post-category");
let shoppingDiv = document.querySelector("#shop-div");

function checkSelected(){
    if (shoppingSelect.options[shoppingSelect.selectedIndex].value == "shopping") {
        shoppingDiv.style.display = "block";
    } else {
        shoppingDiv.style.display = "none";
    }
}

checkSelected();

shoppingSelect.addEventListener("change", (e) => {
    checkSelected();
});

const newRowBtn = document.querySelector("#new-product-row");
let newRowContent = document.querySelector("#product-row");
const insertInto = document.querySelector("#productRow");

let x = 1;

newRowBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (document.querySelectorAll("#product-row").length < 10) {
        x++;
        newRowContent.outerHTML = newRowContent.outerHTML.replaceAll('row[1]', `row[${x}]`);
        insertInto.appendChild(newRowContent);
    }
    if (document.querySelectorAll("#product-row").length == 10) {
        alert("Maximális elemszám elérve!");
    }
});

const saveBtn = document.querySelector("#createNewProduct");

saveBtn.addEventListener('click', function(e){
    e.preventDefault();
    
    const urlapElem = document.querySelector("#createNewProductForm");
    let formData = new FormData(urlapElem);

    let kuldPromise = fetch(urlapElem.action,{
        method: "POST",
        body: formData
    })

    kuldPromise
        .then(response => response.json())
        .then(data => {
            if(data.success)
            {
                let dropdowns = document.querySelectorAll('#product-name');
                let option = document.createElement("option");
                option.text = data.data.name;
                option.value = data.data.id;
                for(let i = 0; i < dropdowns.length - 1; i++) {
                    dropdowns[i].appendChild(option);
                }
                $('#shoppingModal').modal('hide');
            }
            else {
                alert("Hiba!");
            }
        });
});