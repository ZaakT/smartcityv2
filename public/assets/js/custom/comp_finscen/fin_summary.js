/* function showComponent(idCompo){
    var test = undefined;
    var compo = "";
    $("#sel_compo #compo_"+idCompo).each(function(){
        test = this.checked;
        compo = $(this).attr('name').split('_')[1];
    });
    if(compo == "funding mix"){
        if(test){
            $('.funding_mix').removeAttr('hidden');
        } else {
            $('.funding_mix').attr('hidden','hidden');
        }
    } else if(compo == "cash flows") {
        if(test){
            $('.cash_flows').removeAttr('hidden');
        } else {
            $('.cash_flows').attr('hidden','hidden');
        }
    }
} */

function calcTotCat(){
    val_cat = {};
    $('#financing_table_2 .sourceCat').each(function(){
        var id = $(this).attr('id');
        var temp = id.split('_')
        var idCat = parseInt(temp[1]);
        var idScen = parseInt(temp[2]);
        if(val_cat[idCat]){
            val_cat[idCat][idScen] = 0;
        } else {
            val_cat[idCat] = {};
            val_cat[idCat][idScen] = 0;
        }
    });
    $('#financing_table_2 .sourceValues').each(function(){
        var id = $(this).attr('id');
        var temp = id.split('_')
        var idCat = parseInt(temp[1]);
        var idSource = parseInt(temp[2]);
        var idScen = parseInt(temp[3]);
        var val = parseFloat($(this).text());
        val_cat[idCat][idScen] += val;
    });
    for (const idCat in val_cat) {
        if (val_cat.hasOwnProperty(idCat)) {
            const list_value = val_cat[idCat];
            for (const idScen in list_value) {
                if (list_value.hasOwnProperty(idScen)) {
                    const value = list_value[idScen];
                    $("#val_"+idCat+"_"+idScen).text(value.toLocaleString("en-UK",{style:"currency",currency:deviseName,minimumFractionDigits:2,maximumFractionDigits:2}));
                }
            }
        }
    }
}

function setNewDeviseFinSummary(name,sym){
    deviseName = name;
    deviseSym = sym;
    calcTotCat();
}
