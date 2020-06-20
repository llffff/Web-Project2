function deleteCookie() {
    document.cookie = "Username" + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    location.reload();
}

window.onload = function () {
    console.log(document.cookie);
}


