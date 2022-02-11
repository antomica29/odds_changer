let $cookie = getCookie("odds_format");
let loaded = false;

//setting up cookie default if not found
if ($cookie == "") {
    setCookie("decimal");
}

//setting up cookie name and path to avoid multiple cookies of same name
function setCookie(name) {
    document.cookie = "odds_format=" + name + ";path=/";
}

function getCookie(name) {
    let value = `; ${document.cookie}`;
    let parts = value.split(`; ${name}=`);
    if (value != "") return parts.pop().split(';').shift();
}

/**function to change text format
 * @param new_format = the clicked format, the new one to be expected
 * @param current_format = the current format that is displayed and will be changed
 * @param collection = the DOM elements to change
 **/
function changeFormat(new_format, current_format, collection) {

    if (current_format == "decimal" && new_format == "fraction") {
        changeDecimalToFraction(collection);
    } else if (current_format == "decimal" && new_format == "american") {
        changeDecimalToAmerican(collection);
    } else if (current_format == "fraction" && new_format == "decimal") {
        changeFractionToDecimal(collection);
    } else if (current_format == "fraction" && new_format == "american") {
        changeFractionToAmerican(collection);
    } else if (current_format == "american" && new_format == "decimal") {
        changeAmericanDecimal(collection);
    } else if (current_format == "american" && new_format == "fraction") {
        changeAmericanFraction(collection)
    }

    collection = [];
}

function changeDecimalToFraction(collection) {
    for (let $i = 0; $i < collection.length; $i++) {
        $data = collection[$i].innerHTML;
        $ans = Math.round(($data - 1) * 100) / 100;

        $data_converted = $ans + "/1";
        collection[$i].innerHTML = $data_converted;
    }
}

function changeDecimalToAmerican(collection) {
    for (let $i = 0; $i < collection.length; $i++) {
        $data = collection[$i].innerHTML;
        $dataarr = $data.split(".")
        $ans = 0;
        $am_ans = 0;

        if ($data < 2) {
            $ans = ($dataarr[0] * 100 / $dataarr[1] * 100);
            $am_ans = 0 - $ans;
        } else {
            $am_ans = Math.round(($data - 1) * 100);
        }

        $data_converted = $am_ans.toFixed(0);
        collection[$i].innerHTML = $data_converted;
    }
}

function changeFractionToDecimal(collection) {
    for (let $i = 0; $i < collection.length; $i++) {
        $data = collection[$i].innerHTML.toString();
        $dataarr = $data.split("/")
        $ans = ((Number($dataarr[0]) / Number($dataarr[1])) + 1);

        $data_converted = $ans.toFixed(2);
        collection[$i].innerHTML = $data_converted;
    }
}

function changeFractionToAmerican(collection) {
    for (let $i = 0; $i < collection.length; $i++) {
        $data = collection[$i].innerHTML;
        $dataarr = $data.split("/")
        $ans = 0;
        $am_ans = 0;

        if ($dataarr[0] < $dataarr[1]) {
            $ans = $dataarr[1] * 100 / $dataarr[0];
            $am_ans = 0 - $ans;
        } else {
            $am_ans = $dataarr[0] * 100;
        }

        $data_converted = $am_ans;
        collection[$i].innerHTML = $data_converted.toFixed(0);
    }
}

function changeAmericanDecimal(collection) {
    for (let $i = 0; $i < collection.length; $i++) {
        $data = collection[$i].innerHTML;
        $ans = 0;

        if ($data < 0) {
            $ans = (100 / $data - 1);
        } else {
            $ans = ($data / 100 + 1);
        }

        $data_converted = Math.abs($ans).toFixed(2);
        collection[$i].innerHTML = $data_converted;
    }
}

function changeAmericanFraction(collection) {
    for (let $i = 0; $i < collection.length; $i++) {
        $data = collection[$i].innerHTML;
        $ans = 0;
        $am_ans = 0;

        if ($data < 0) {
            $am_ans = Math.abs($data);
            $ans = Math.round(((100 / $am_ans)+ Number.EPSILON) * 100 ) / 100;
        } else {
            $ans = ($data / 100);
        }

        $data_converted = $ans + "/1";
        collection[$i].innerHTML = $data_converted;
    }
}

document.addEventListener('DOMContentLoaded', (event) => {

    //getting elements needed
    let odds_class = document.getElementById("hidden_odds_changer_plugin").getAttribute("hidden-data");
    var classname = document.getElementsByClassName("odds_format");
    let collection = document.getElementsByClassName(odds_class);
    let current_format = getCookie("odds_format");

    //called when plugin button are clicked
    var changeFormat_click = function () {
        //getting clicked button info
        children = this.children;
        el_classname = children[0].className;
        new_format = el_classname.replace('odds_format_', '');
        collection = document.getElementsByClassName(odds_class);
        current_format = getCookie("odds_format");

        //calling change format event and changing cookie value
        changeFormat(new_format, current_format, collection);
        setCookie(new_format);
    };

    //adding on click event of plugin buttons calling changeFormat_click function
    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', changeFormat_click, false);
    }

    //if page was loaded, call changeFormat function to change format on page load to cookie setting
    if (!loaded) {
        changeFormat(current_format, "decimal", collection);
        loaded = true;
    }
});

