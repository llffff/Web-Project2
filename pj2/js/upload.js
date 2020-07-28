const OK_TAG = "<span class='glyphicon glyphicon-ok-sign' ></span>";
const FALSE_TAG = " <span class='glyphicon glyphicon-remove-sign'> </span>";

let form2 = document.getElementById("upload_form");

form2.onsubmit = function () {
    console.log("checkPath() is "+checkPath());
    console.log("checkTitle() is "+checkTitle());
    console.log("checkDescription() is "+checkDescription());
    console.log("checkCountry() is "+checkCountry());
    console.log("checkCity() is "+checkCity());
    console.log("checkContent() is "+checkContent());

    return checkSubmit2();
};


function checkSubmit2() {
    checkPath();
    checkTitle()
    checkDescription()
    checkCountry()
    checkCity()
    checkContent()

    return (
        checkPath() &&
        checkTitle() &&
        checkDescription() &&
        checkCountry() &&
        checkCity() &&
        checkContent()
    );
}



function checkPath() {
    let path = document.getElementById('upload_file');
    let span = document.getElementById('pathSpan');
    if(!path.getAttribute('disable')){
        if (path.value === "") span.innerHTML = FALSE_TAG + " 请填写";
        else span.innerHTML = " " + OK_TAG;
        return !(path.value === "");
    }

    return true;

}



function checkTitle() {
    let title = document.getElementById('title');
    let span = document.getElementById('titleSpan');
    if (title.value === "") span.innerHTML = FALSE_TAG + " 请填写";
    else span.innerHTML = " " + OK_TAG;

    return !(title.value === "");
}



function checkDescription() {
    let description = document.getElementById('description');
    let span = document.getElementById('descriptionSpan');
    if (description.value === "") span.innerHTML = FALSE_TAG + " 请填写";
    else span.innerHTML = " " + OK_TAG;

    return !(description.value === "");
}




function checkCountry() {
    let select_country = document.getElementById('select_country');
    let span = document.getElementById('countrySpan');
    if (select_country.value === "") span.innerHTML = FALSE_TAG + " 请选择";
    else span.innerHTML = " " + OK_TAG;

    return !(select_country.value === "");
}




function checkCity() {
    let select_city = document.getElementById('select_city');
    let span = document.getElementById('citySpan');
    if (select_city.value === "") span.innerHTML = FALSE_TAG + " 请选择";
    else span.innerHTML = " " + OK_TAG;

    return !(select_city.value === "");}


function checkContent() {
    let select_content = document.getElementById('select_content');
    let span = document.getElementById('contentSpan');
    if (select_content.value === "") span.innerHTML = FALSE_TAG + " 请选择";
    else span.innerHTML = " " + OK_TAG;

    return !(select_content.value === "");
}