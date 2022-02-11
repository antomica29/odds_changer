document.addEventListener('DOMContentLoaded', (event) => {

    var sort_odds = document.getElementById("sort_odds");

    if(sort_odds) {
        sort_odds.addEventListener("change", function () {

            sortArray(sort_odds.value);
        });
    }
});

function sortArray(value) {
    let valArr = [];
    let arr = [];
    let data_att = "";
    let parent_div = document.getElementsByClassName("match_row_container");
    let list_row = document.getElementsByClassName("match_row_holder");

    if (value == "Highest Home") {
        data_att = "data-home";
    } else if (value == "Highest Draw") {
        data_att = "data-draw";
    } else if (value == "Highest Away") {
        data_att = "data-away";
    } else{
        data_att = "data-pos";
        sortByLowest(parent_div, list_row, data_att);
    }

    sortByHighest(parent_div, list_row, data_att);
}

function sortByHighest(parent_div, list_row, data_att) {
    for (let $i = 0; $i < list_row.length; $i++) {
        let current = list_row[$i].getAttribute(data_att);
        let next = 0;

        //taking care of attribute + 1 error
        if($i + 1 ==  list_row.length){
            next = list_row[$i].getAttribute(data_att);
        }else {
            next = list_row[$i + 1].getAttribute(data_att);
        }

        if (next > current) {
            parent_div[0].insertBefore(list_row[$i + 1], list_row[$i]);
            sortByHighest(parent_div, list_row, data_att);
        }
    }
}

function sortByLowest(parent_div, list_row, data_att) {
    for (let $i = 0; $i < list_row.length; $i++) {
        let current = list_row[$i].getAttribute(data_att);
        let next = 0;
/*
        if($i + 1 ==  list_row.length){
            next = list_row[$i].getAttribute(data_att);
        }else {*/
            next = list_row[$i + 1].getAttribute(data_att);
            /*}*/

            if (next < current) {
                parent_div[0].insertBefore(list_row[$i+1], list_row[$i]);
                sortByLowest(parent_div, list_row, data_att);
            }
        }
        //taking care of attribute + 1 error
}

