let $cookie = getCookie("odds_format");

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
        console.log($data_converted);
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
        console.log($data_converted);
    }
}

function changeFractionToDecimal(collection) {
    for (let $i = 0; $i < collection.length; $i++) {
        $data = collection[$i].innerHTML.toString();
        console.log($data);
        $dataarr = $data.split("/")
        $ans = ((Number($dataarr[0]) / Number($dataarr[1])) + 1);

        $data_converted = $ans.toFixed(2);
        collection[$i].innerHTML = $data_converted;
        console.log($data_converted);
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
        console.log($data_converted);
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
        console.log($data_converted);
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
        console.log($data_converted);
    }
}

document.addEventListener('DOMContentLoaded', (event) => {

    $odds_class = document.getElementById("hidden_odds_changer_plugin").getAttribute("hidden_data");

    var classname = document.getElementsByClassName("odds_format");
    let collection = document.getElementsByClassName($odds_class);
    let current_format = getCookie("odds_format");

    var changeFormat_click = function () {
        children = this.children;
        el_classname = children[0].className;
        new_format = el_classname.replace('odds_format_', '');
        collection = document.getElementsByClassName("odds");
        current_format = getCookie("odds_format");

        console.log(new_format);
        console.log(current_format);

        changeFormat(new_format, current_format, collection);
        setCookie(new_format);
    };

    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', changeFormat_click, false);
    }

    $loaded = false;
    if (!$loaded) {
        changeFormat(current_format, "decimal", collection);
        $loaded = true;
    }
});

