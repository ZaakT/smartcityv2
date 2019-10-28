function colorActive(){
    var CheminComplet = document.location.href;
    var CheminRepertoire  = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) );
    var NomDuFichier     = CheminComplet.substring(CheminComplet.lastIndexOf( "/" )+1 );
    var temp = NomDuFichier.split('=');
    var temp2 = [];
    
    for (let i = 0; i < temp.length; i++) {
        var element = temp[i].split("&");
        temp2.push(element);
    }
    
    active = "#"+ temp2[2][0];
    $(active).addClass("active");
}


function prereq_ProjectDesign1(check){
    var parts_cond = ["measures","criteria","geography"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectDesign2(check){
    var parts_cond = ["use_case"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectDesign3(check){
    var parts_cond = ["rating","scoring","global_score"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}


colorActive();

