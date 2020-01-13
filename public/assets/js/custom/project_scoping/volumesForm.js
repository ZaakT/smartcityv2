function searchIDs(formName){
    var list_ucs = [];
    var list_compo = [];
    var list_zones = [];
    $("#"+formName+" .val_nb").each(function(){
        var id = $(this).attr('id');
        var tab = id.split('_');
        var id_compo = parseInt(tab[2]);
        var id_uc = parseInt(tab[3]);
        var id_zone = parseInt(tab[4]);
        //console.log(id_compo,id_uc,id_zone);
        if(!list_ucs.includes(id_uc)){
            list_ucs.push(id_uc);
        }
        if(!list_compo.includes(id_compo)){
            list_compo.push(id_compo);
        }
        if(!list_zones.includes(id_zone)){
            list_zones.push(id_zone);
        }
    });
    //console.log(list_ucs,list_compo,list_zones);
    return [list_ucs,list_compo,list_zones];
}

function calcTot(compo,zones,item,uc=""){
    var sum = 0;
    var val = 0;
    zones.forEach((zone) => {
        //console.log("#val_"+item+compo+uc+"_"+zone);
        val = $("#val_"+item+compo+uc+"_"+zone).text().replace(/\s/g,'');
        if($("#val_"+item+compo+uc+"_"+zone).val()){
            val += $("#val_"+item+compo+uc+"_"+zone).val().replace(/\s/g,'');
        }
        if(val!=""){
            sum += parseInt(val);
        }
    })
    sum = sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    sum = sum!="NaN" ? sum : "0";
    $("#tot_"+item+compo+uc).text(sum);
}

function calcTotUC(uc,zone,compo){
    var val_1 = $("#val_nb_"+compo+"_"+uc+"_"+zone).val();
    var val_2 = $("#val_nbuc_"+compo+"_"+uc+"_"+zone).val();
    if(val_1 && val_2){
        val_1 = val_1==0 ? 0 : parseInt(val_1);
        val_2 = val_2==0 ? 0 : parseInt(val_2);
        if(val_1>0 && val_2>0){
            if(val_1 >= val_2){
                res = parseInt(val_1/val_2);
            } else {
                res = 0;
            }
        } else {
            res = "-";
        }
        $("#totUC_"+uc+"_"+zone).text(res);
        return res;
    }
    return 0;
}

function fillTot(formName){
    colorFilledVolumes();
    const list_ucs = searchIDs(formName)[0];
    const list_compo = searchIDs(formName)[1];
    const list_zones = searchIDs(formName)[2];
    const list_items = ["nb_","nbuc_"];
    list_compo.forEach((compo) => {
        calcTot(compo,list_zones,"zones_");
        list_items.forEach((item) => {
            list_ucs.forEach((uc) => {
                calcTot(compo,list_zones,item,"_"+uc);
            })
        })
    })
    list_ucs.forEach((uc) => {
        var sum = 0;
        var val = 0;
        list_compo.forEach((compo) => {
            sum = 0;
            list_zones.forEach((zone) => {
                val = calcTotUC(uc,zone,compo);
                //console.log(val);
                if(val!="-"){
                    sum += val;
                }
                $("#tot_totUC_"+uc).text(sum);
            })
        })
    })
}

function colorFilledVolumes(){
    var ret = true;
    //console.log("--------------------");
    $(".volumes_table input").each(function(){
        //console.log(this);
        var element = $(this);
        var value = element.val();
        value = value=="" ? 0 : parseInt(value);
        if(value<0){
            element.css("background","salmon");
            element.val("");
            ret = false;
        } else {
            element.val(value);
            element.css("background","palegreen");
        }
    });
    return ret
}

colorFilledVolumes();

fillTot("form_volumes");


function fillByAv(){
    $("#"+id+" input").each(function(){
        var element = $(this);
        console.log(element);
        if(element.attr("placeholder")){
            var tab = element.attr("placeholder").split("-");
            if(tab.length > 1){
                var min = tab[0] != "" ? parseInt(tab[0].replace(",","")) : 0;
                var max = tab[1] != "" ? parseInt(tab[1].replace(",","")) : 0;
                console.log((min+max)/2);
                element.val(parseInt((min+max)/2));
                console.log(element.val());
            } else {
                var val = parseInt(tab[0]);
                element.val(parseInt(val));
            }
            element.trigger("input");
        }
    });
}

function clearTable(){
    $("#"+id+" input").each(function(){
        var element = $(this);
            element.val("");
            element.trigger("input");
    });
}