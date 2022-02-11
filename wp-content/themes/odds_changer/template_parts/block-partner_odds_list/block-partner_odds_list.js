document.addEventListener('DOMContentLoaded', (event) => {

    //get select option for sorting
    var sort_odds = document.getElementById("sort_odds");

    if (sort_odds) {
        sort_odds.addEventListener("change", function () {
            //call sorting function
            sortRows(sort_odds.value);
        });
    }
});

//sort rows function
function sortRows(value) {
    let data_att = "";
    let parent_div = document.getElementsByClassName("match_row_container");
    let list_row = document.getElementsByClassName("match_row_holder");

    //setting up and rendering values
    if ((value == "data-home-hi") || (value == "data-draw-hi") || (value == "data-away-hi")) {
        data_att = value;
        data_att = data_att.replace('-hi', '');

        sortByHighest(parent_div, list_row, data_att);
    } else {
        data_att = value;
        data_att = data_att.replace('-lo', '');

        sortByLowest(parent_div, list_row, data_att);
    }

}

//sorting by highest value function
function sortByHighest(parent_div, list_row, data_att) {

    //loop to check current value pos with the next one and compare
    for (let $i = 0; $i < list_row.length; $i++) {
        let current = list_row[$i].getAttribute(data_att);
        let next = 0;

        //taking care of attribute + 1 error (out of range)
        if ($i + 1 == list_row.length) {
            next = list_row[$i].getAttribute(data_att);
        } else {
            next = list_row[$i + 1].getAttribute(data_att);
        }

        //if next is higher than current, insert before and start again
        if (next > current) {
            parent_div[0].insertBefore(list_row[$i + 1], list_row[$i]);
            sortByHighest(parent_div, list_row, data_att);
        }
    }
}

//sorting by lowest value function
function sortByLowest(parent_div, list_row, data_att) {

    //loop to check current value pos with the next one and compare
    for (let $i = 0; $i < list_row.length; $i++) {
        let current = list_row[$i].getAttribute(data_att);
        let next = 0;

        //taking care of attribute + 1 error (out of range)
        if ($i + 1 == list_row.length) {
            next = list_row[$i].getAttribute(data_att);
        } else {
            next = list_row[$i + 1].getAttribute(data_att);
        }

        //if next is lower than current, insert before and start again
        if (next < current) {
            parent_div[0].insertBefore(list_row[$i + 1], list_row[$i]);
            sortByLowest(parent_div, list_row, data_att);
        }
    }
}

