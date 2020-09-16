function update_chart(event) {
    let debut_projet = new Date(document.querySelector("p#project-start").outerText)
    let fin_projet = new Date(document.querySelector("p#project-end").outerText)
    let duree_projet = Math.round(fin_projet.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)

    if (event.id.startsWith("ucpri")) { //UC Pricing Schedule (3 bars)
        let bar_void = "ucpri_1_bar"
        let bar_poc = "ucpri_2_bar"
        let bar_run = "ucpri_3_bar"

        let transition_void = new Date($("#ucpri_2").val())
        let transition_poc = new Date($("#ucpri_3").val())

        let duree_void = Math.round((Math.round(transition_void.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_poc = Math.round((Math.round(transition_poc.getTime() - transition_void.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_run = Math.round((Math.round(fin_projet.getTime() - transition_poc.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar_void).css("width", duree_void + "%")
        $("#" + bar_poc).css("width", duree_poc + "%")
        $("#" + bar_run).css("width", duree_run + "%")
    } else if (event.id.startsWith("ucrev")) { //UC Revenues Schedule (4 bars)
        let bar_void = "ucrev_1_bar"
        let bar_lag = "ucrev_2_bar"
        let bar_ramp = "ucrev_3_bar"
        let bar_run = "ucrev_4_bar"

        let transition_void = new Date($("#ucrev_2").val())
        let transition_lag = new Date($("#ucrev_3").val())
        let transition_ramp = new Date($("#ucrev_4").val())


        let duree_void = Math.round((Math.round(transition_void.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_lag = Math.round((Math.round(transition_lag.getTime() - transition_void.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_ramp = Math.round((Math.round(transition_ramp.getTime() - transition_lag.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_run = Math.round((Math.round(fin_projet.getTime() - transition_ramp.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar_void).css("width", duree_void + "%")
        $("#" + bar_lag).css("width", duree_lag + "%")
        $("#" + bar_ramp).css("width", duree_ramp + "%")
        $("#" + bar_run).css("width", duree_run + "%")
    } else if (!event.id.endsWith("_1")) { //reste des cas
        let bar = event.id + "_bar";
        let bar_precedente = event.id.split("_")[0] + "_" + (parseInt(event.id.slice(-1)) - 1) + "_bar";

        let date_transition = new Date(event.value);
        var duree_depuis_debut = Math.round((Math.round(date_transition.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        var duree_depuis_fin = Math.round((Math.round(fin_projet.getTime() - date_transition.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar).css("width", duree_depuis_fin + "%")
        $("#" + bar_precedente).css("width", duree_depuis_debut + "%")
    }
}

function check_form() {
    var validate_form = true
    let inputs = ["#ucop_2", "#ucpri_3", "#ucpri_4", "#ucrev_2", "#ucrev_3", "#ucrev_4"]
    let changed_buttons = []
    inputs.forEach(i => {
        let btn = i.substring(0, i.indexOf("_"))
        if ($(i).val() == "") {
            $('.alert').addClass("show");
            validate_form = false;

            $(btn).removeClass("btn-dark")
            $(btn).addClass("btn-warning")
            changed_buttons.push(btn)
        } else {
            if (!changed_buttons.includes(btn)) {
                $(btn).removeClass("btn-warning")
                $(btn).addClass("btn-dark")
            }
        }
    })

    if (validate_form)
        $("#supplier_schedule").submit();
}

function check_form_debug() {
    $("#supplier_schedule").submit();
}

function update_all_chart() {
    let debut_projet = new Date(document.querySelector("p#project-start").outerText)
    let fin_projet = new Date(document.querySelector("p#project-end").outerText)
    let duree_projet = Math.round(fin_projet.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)

    //UC Pricing Schedule (3 bars)
    let bar_void = "ucpri_1_bar"
    let bar_poc = "ucpri_2_bar"
    let bar_run = "ucpri_3_bar"

    let transition_void = new Date($("#ucpri_2").val())
    let transition_poc = new Date($("#ucpri_3").val())

    if (transition_void && transition_poc) {
        let duree_void = Math.round((Math.round(transition_void.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_poc = Math.round((Math.round(transition_poc.getTime() - transition_void.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_run = Math.round((Math.round(fin_projet.getTime() - transition_poc.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar_void).css("width", duree_void + "%")
        $("#" + bar_poc).css("width", duree_poc + "%")
        $("#" + bar_run).css("width", duree_run + "%")
    }

    //UC Revenues Schedule (4 bars)
    let bar_void_2 = "ucrev_1_bar"
    let bar_lag = "ucrev_2_bar"
    let bar_ramp = "ucrev_3_bar"
    let bar_run_2 = "ucrev_4_bar"

    let transition_void_2 = new Date($("#ucrev_2").val())
    let transition_lag = new Date($("#ucrev_3").val())
    let transition_ramp = new Date($("#ucrev_4").val())

    if (transition_void_2 && transition_lag && transition_ramp) {
        let duree_void = Math.round((Math.round(transition_void_2.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_lag = Math.round((Math.round(transition_lag.getTime() - transition_void_2.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_ramp = Math.round((Math.round(transition_ramp.getTime() - transition_lag.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_run = Math.round((Math.round(fin_projet.getTime() - transition_ramp.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar_void_2).css("width", duree_void + "%")
        $("#" + bar_lag).css("width", duree_lag + "%")
        $("#" + bar_ramp).css("width", duree_ramp + "%")
        $("#" + bar_run_2).css("width", duree_run + "%")
    }

    let bar = "ucop_2_bar";
    let bar_precedente = "ucop_1_bar";

    let transition_deploy = new Date($("#ucop_2").val())

    if (transition_deploy) {
        var duree_depuis_debut = Math.round((Math.round(transition_deploy.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        var duree_depuis_fin = Math.round((Math.round(fin_projet.getTime() - transition_deploy.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar).css("width", duree_depuis_fin + "%")
        $("#" + bar_precedente).css("width", duree_depuis_debut + "%")
    }
}