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

function calcTot(compo,zones,item,uc=""){ //calcule les sommes totales de chaque catégorie
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
    //$("#tot_"+item+compo+uc).text("test calcTot");
    $("#tot_"+item+compo+uc).text(sum);
}

function calcTotUC(uc,zone,compo){ //calcule le nombre total de use case par zone pour un composant
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
        //$("#totUC_"+uc+"_"+zone).text(res);
        //$("#totUC_"+uc+"_"+zone).text("test calcTotUC");
        return res;
    }
    return 0;
}

function fillTot(formName){  //calcule le nombre total de use case lorsque nb de composant ou ration comp/uc est modifié
    colorFilledVolumes();
    const list_ucs = searchIDs(formName)[0];
    const list_compo = searchIDs(formName)[1];
    const list_zones = searchIDs(formName)[2];
    const list_items = ["nb_","nbuc_"];
    list_compo.forEach((compo) => {
        //calcTot(compo,list_zones,"zones_"); pas compris
        list_items.forEach((item) => {
            list_ucs.forEach((uc) => {
                calcTot(compo,list_zones,item,"_"+uc); //calcule les sommes sur zones de la colonne de droite
            })
        })
    })
    list_ucs.forEach((uc) => {
        var tot_totUC = 0; //total pour un UC (en bas à droite)
        var totCompoZone = 0; //total pour un composant pour une zone

        list_zones.forEach((zone) => {
            totZone = 0; //total de UC pour une zone (ligne du bas)
            list_compo.forEach((compo) => {
                totCompoZone = calcTotUC(uc,zone,compo);
                if (totCompoZone != "-"){
                    totZone += totCompoZone ;
                }
            })
            $("#totUC_"+uc+"_"+zone).val(totZone);
            tot_totUC += totZone;
        })
        $("#tot_totUC_"+uc).text(tot_totUC);
    })
}

function fillTot2(formName){ //calcule le nombre total de use case  lorsque le nb de use case item par quartier est modifié
    const list_ucs = searchIDs(formName)[0];
    const list_compo = searchIDs(formName)[1];
    const list_zones = searchIDs(formName)[2];
    const list_items = ["nb_","nbuc_"];
    list_compo.forEach((compo) => {
        //calcTot(compo,list_zones,"zones_"); pas compris
        list_items.forEach((item) => {
            list_ucs.forEach((uc) => {
                calcTot(compo,list_zones,item,"_"+uc); //calcule les sommes sur zones de la colonne de droite
            })
        })
    })
    list_ucs.forEach((uc) => {
        var tot_totUC = 0; //total pour un UC (en bas à droite)

        list_zones.forEach((zone) => {
            totZone = Number($("#totUC_"+uc+"_"+zone).val()); //total de UC pour une zone (ligne du bas)
            tot_totUC += totZone;
        })
        console.log("#tot_totUC_"+uc)
        $("#tot_totUC_"+uc).text(tot_totUC);
    })
    colorFilledVolumes();
}

function colorFilledVolumes(){
    //console.log("col !")
    var ret = true;
    $(".volumes_table input").each(function(){
        var id = this.id
        var value = $("#"+id).val();
        //value = value=="" ? "" : parseInt(value);
        //console.log(value);
        if( value=="" || value<0){
            //console.log("#"+id)
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else {
            value = parseInt(value);
            $("#"+id).val(value);
            $("#"+id).css("background","#C3E6CB");
        }
    });
    return ret
}

colorFilledVolumes();

fillTot2("form_volumes");


function fillByAv(id){
    $("#"+id+" input").each(function(){
        var element = $(this);
        //console.log(element);
        if(element.attr("placeholder")){
            var tab = element.attr("placeholder").split("-");
            if(tab.length > 1){
                var min = tab[0] != "" ? parseInt(tab[0].replace(",","")) : 0;
                var max = tab[1] != "" ? parseInt(tab[1].replace(",","")) : 0;
                //console.log((min+max)/2);
                element.val(parseInt((min+max)/2));
                //console.log(element.val());
            } else {
                var val = parseInt(tab[0]);
                element.val(parseInt(val));
            }
            element.trigger("input");
        }
    });
}

function clearTable(id){
    $("#"+id+" input").each(function(){
        var element = $(this);
            element.val("");
            element.trigger("input");
    });
}

function displayGuideline() {
    var classes = $('#guideline_button').classes();
    if (classes.includes("active")) {
        $('#guideline_button').removeClass("active");
        //console.log($('#guideline_button').classes());
        $('#body').removeClass('col-7');
        $('#body').addClass('col-12');    
        $('#guideline').hide();
    } else {
        $('#guideline_button').addClass("active");
        //console.log($('#guideline_button').classes());
        $('#guideline').show();
        $('#body').removeClass('col-12');
        $('#body').addClass('col-7');
        
    }
}
displayGuideline();