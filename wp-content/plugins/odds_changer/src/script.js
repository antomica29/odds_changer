const $cookie = getCookie("odds_format");

if ($cookie == "") {
    setCookie("decimal");
}

function setCookie(name) {
    document.cookie = "odds_format=" + name;
}

function getCookie(name) {
    let value = `; ${document.cookie}`;
    let parts = value.split(`; ${name}=`);
    if (value != "") return parts.pop().split(';').shift();
}

window.addEventListener('DOMContentLoaded', (event) => {

    var classname = document.getElementsByClassName("odds_format");

    var myFunction = function () {
        children = this.children;
        el_classname = children[0].className;
        new_format = el_classname.replace('odds_format_','');

        setCookie(new_format);
    };

    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', myFunction, false);
    }

});