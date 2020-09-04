function update_chart(event) {
    var debut_projet = new Date(2020, 9, 4)
    var fin_projet = new Date(2021, 2, 21)
    var duree_projet = Math.round(fin_projet.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)
    console.log(duree_projet)

    if(!event.id.endsWith("_1")) {
        let bar = event.id + "_bar"
        //set width : x où x est la place de la date sur la période project-end - project-start
        
    }
}

function pre_fill_starts() {
    $("input.start-date").attr("value", "2020-09-04");
}

pre_fill_starts()