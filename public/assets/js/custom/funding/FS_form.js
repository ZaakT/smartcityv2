function checkSelFS(){
    $("#funding_sources_table :checkbox").each(function(){
        var id_source = parseInt($(this).attr('id'))
        if(this.checked){
            $("#share_"+id_source).removeAttr("disabled");
            $("#share_"+id_source).addClass("enabledInput");
            //$(".entities_"+id_source).removeAttr("hidden");
        } else {
            //console.log($("#share_"+id_source));
            $("#share_"+id_source).attr("disabled","disabled");
            $("#share_"+id_source).css("background","");
            $("#share_"+id_source).removeClass("enabledInput");
            //$(".entities_"+id_source).attr("hidden","hidden");
        }
    });
    if(checkTotFS()){
        calcOuputFS();
    }
}

function checkInputFS(){
    var sum = 0;
    var ret = true;
    $("#funding_sources_table :input[type='number']").each(function(){
        if(!this.disabled){
            var val = $(this).val();
            val = val ? parseFloat(val) : -1 ;
            var temp = String(val).split(".");
            sum += val;
            if(val <= 0.){
                $(this).css("background","salmon");
                $(this).val("");
                ret = false;
            } else if (temp.length==2 && temp[1].length>1 || val > 100){
                $(this).css("background","salmon");
                ret = false;
            } else {
                $(this).css("background","palegreen");
            }
        }
    });
    return ret;
}

function checkTotFS(){
    var sum = 0;
    $("#funding_sources_table .enabledInput").each(function(){
        var val = $(this).val();
        val = val ? parseFloat(val) : -1 ;
        //console.log(val);
        if(val != -1){
            sum += val;
        } else {
            $("#funding_sources_table .enabledInput").css("background","salmon");
            return false;
        }
    });
    if(sum==100){
        $("#funding_sources_table .enabledInput").css("background","palegreen");
        return checkInputFS();
    } else {
        //console.log("ddd");
        $("#funding_sources_table .enabledInput").css("background","salmon");
        return false;
    }
}

function calcOuputFS(){
    var funding_target = parseFloat($("#funding_target").val());
    $("#funding_sources_table .enabledInput").each(function(){
        var id_source = parseInt($(this).attr('id').split('_')[1]);
        var share = $(this).val()/100;
        var val = share*funding_target;
        console.log(id_source,val);
        $("#output_"+id_source).text("£ "+val.toLocaleString("en-EN",{minimumFractionDigits: 0, maximumFractionDigits: 2}));
    });
}
checkSelFS();



$.date = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = month + "/" + year;

    return date;
};


function initDatepickers(){
    var temp = {};
    $("#entities_table .date").each(function(){
        var id = $(this).attr('id').split('_');
        var id_source = parseInt(id[1]);
        var id_entity = parseInt(id[2]) ? parseInt(id[2]) : 0;
        if(id_entity != 0){
            temp[id_entity] = "";
            dates[id_source] = temp;
        } else {
            dates[id_source] = "";
        }

        $(this).datepicker( {
            format: "mm/yyyy",
            startView: "months", 
            minViewMode: "months",
        })
        .on('changeDate', function(ev){
            //var newDate = new Date(ev.date);
            var newDate = $(this).data('datepicker').date;
            //console.log(id_source,id_entity,newDate);
            var id = $(this).attr('id').split('_');
            var id_source = parseInt(id[1]);
            var id_entity = parseInt(id[2]) ? parseInt(id[2]) : 0;
            if(id_entity != 0){
                temp[id_entity] = newDate;
                dates[id_source] = temp;
            } else {
                dates[id_source] = newDate;
            }
            //console.log(dates);
            checkInputEntities();
        });

    });
    //console.log(dates);
}
//checkInputFS();

function checkInputEntities(){
    var ret = true;
    $("#entities_table input[type=number]").each(function(){
        var val = $(this).val();
        val = val != "" ? parseFloat(val) : -1;
        var temp = String(val).split(".");
        if(val <= 0) {
            $(this).css("background","salmon");
            ret = false;
        } else if (temp.length==2 && temp[1].length>1 || val > 100){
            $(this).css("background","salmon");
            ret = false;
        } else {
            $(this).css("background","palegreen");
        }
    });
    $("#entities_table .date input").each(function(){
        var val = $(this).val();
        if(val == "") {
            $(this).css("background","salmon");
            ret = false;
        } else {
            $(this).css("background","palegreen");
        }
    });
    calcOutputEntities();
    return checkTotEntities() && ret;
}

function calcOutputEntities(){
    var funding_target = parseFloat($("#funding_target1").val());
    $("#entities_table input[type=number]").each(function(){
        var id = $(this).attr('id').split('_');
        var id_source = parseInt(id[1]);
        var id_entity = parseInt(id[2]) ? parseInt(id[2]) : 0;
        var share = parseFloat($(this).val())/100;
        var val = share && funding_target ? share*funding_target : "-";
        $("#output_"+id_source+"_"+id_entity).text("£ "+val.toLocaleString("en-EN",{minimumFractionDigits: 0, maximumFractionDigits: 2}));
    });
    $("#entities_table .shareFS").each(function(){
        var id = $(this).attr('id').split('_');
        var id_source = parseInt(id[1]);
        var share = parseFloat($(this).text().split("%")[0])/100;
        var val = share&&funding_target ? share*funding_target : "-";
        $("#output_"+id_source).text("£ "+val.toLocaleString("en-EN",{minimumFractionDigits: 0, maximumFractionDigits: 2}));
    });
}

function checkTotEntities(){
    var shares = {};
    var ret = true;
    $("#entities_table input[type=number]").each(function(){
        var temp = {};
        var id = $(this).attr('id').split('_');
        var id_source = parseInt(id[1]);
        var id_entity = parseInt(id[2]) ? parseInt(id[2]) : 0;
        var share = $(this).val() ? parseFloat($(this).val()) : -1;
        if(id_source in shares){
            shares[id_source][id_entity] = share;
        } else {
            temp[id_entity] = share;
            shares[id_source] = temp;
        }
    });
    for (const id_source in shares) {
        if (shares.hasOwnProperty(id_source)) {
            const list_shares = shares[id_source];
            var sum = 0;
            var shareFS = parseFloat($("#entities_table #shareFS_"+id_source).text().split("%")[0]);
            var list_entities = [];
            for (const id_entity in list_shares) {
                if (list_shares.hasOwnProperty(id_entity)) {
                    const share = list_shares[id_entity];
                    if(share){
                        sum += share;
                    }
                    list_entities.push(id_entity);
                }
            }
            //console.log(id_source,shareFS,sum);
            if(shareFS != sum){
                list_entities.forEach((id_entity) => {
                    $("#share_"+id_source+"_"+id_entity).css("background","salmon");
                });
                ret = false;
            } else {
                /* list_entities.forEach((id_entity) => {
                    $("#share_"+id_source+"_"+id_entity).css("background","palegreen");
                }); */
            }
        }
    }
    return ret;
}

dates = {};
initDatepickers();
checkInputEntities()

function initDatepickers2(){
    var temp = {};
    $("#entities_table_2 .date").each(function(){
        var id = $(this).attr('id').split('_');
        var id_source = parseInt(id[1]);
        var id_entity = parseInt(id[2]) ? parseInt(id[2]) : 0;
        if(id_entity != 0){
            temp[id_entity] = "";
            dates2[id_source] = temp;
        } else {
            dates2[id_source] = "";
        }

        $(this).datepicker( {
            format: "mm/yyyy",
            startView: "months", 
            minViewMode: "months",
        })
        .on('changeDate', function(ev){
            //var newDate = new Date(ev.date);
            var newDate = $(this).data('datepicker').date;
            //console.log(id_source,id_entity,newDate);
            var id = $(this).attr('id').split('_');
            var id_source = parseInt(id[1]);
            var id_entity = parseInt(id[2]) ? parseInt(id[2]) : 0;
            if(id_entity != 0){
                temp[id_entity] = newDate;
                dates2[id_source] = temp;
            } else {
                dates2[id_source] = newDate;
            }
            //console.log(dates);
            checkInputEntities2();
        });

    });
    //console.log(dates);
}

function checkInputEntities2(){
    var ret = true;
    $("#entities_table_2 input[type=number]").each(function(){
        var inputCat = $(this).attr('id').split('_')[0];
        if(inputCat=="share"){
            var val = $(this).val();
            val = val != "" ? parseFloat(val) : -1;
            var temp = String(val).split(".");
            if(val <= 0.) {
                $(this).css("background","salmon");
                ret = false;
            } else if (temp.length==2 && temp[1].length>1 || val > 100){
                $(this).css("background","salmon");
                ret = false;
            } else {
                $(this).css("background","palegreen");
            }
        } else if (inputCat=="interest"){
            var val = $(this).val();
            val = val != "" ? parseFloat(val) : -1;
            var temp = String(val).split(".");
            if(val < 0.) {
                $(this).css("background","salmon");
                ret = false;
            } else if (temp.length==2 && temp[1].length>2/*  || val > 100 */){
                $(this).css("background","salmon");
                ret = false;
            } else {
                $(this).css("background","palegreen");
            }
        }
    });
    $("#entities_table_2 .date input").each(function(){
        var val = $(this).val();
        if(val == "") {
            $(this).css("background","salmon");
            ret = false;
        } else {
            $(this).css("background","palegreen");
        }
    });
    calcOutputEntities2();
    return checkTotEntities2() && ret;
}

function calcOutputEntities2(){
    var funding_target = parseFloat($("#funding_target2").val());
    $("#entities_table_2 input[type=number]").each(function(){
        var id = $(this).attr('id').split('_');
        if (id[0]=="share"){
            var id_source = parseInt(id[1]);
            var id_entity = parseInt(id[2]) ? parseInt(id[2]) : 0;
            var share = parseFloat($(this).val())/100;
            var val = share && funding_target ? share*funding_target : "-";
            $("#output_"+id_source+"_"+id_entity).text("£ "+val.toLocaleString("en-EN",{minimumFractionDigits: 0, maximumFractionDigits: 2}));
        }
    });
    $("#entities_table_2 .shareFS").each(function(){
        var id = $(this).attr('id').split('_');
        var id_source = parseInt(id[1]);
        var share = parseFloat($(this).text().split("%")[0])/100;
        var val = share*funding_target;
        $("#output_"+id_source).text("£ "+val.toLocaleString("en-EN",{minimumFractionDigits: 0, maximumFractionDigits: 2}));
    });
}

function checkTotEntities2(){
    var shares = {};
    var ret = true;
    $("#entities_table_2 input[type=number]").each(function(){
        //console.log($(this));
        var temp = {};
        var id = $(this).attr('id').split('_');
        if(id[0]=="share"){
            var id_source = parseInt(id[1]);
            var id_entity = parseInt(id[2]) ? parseInt(id[2]) : 0;
            var share = $(this).val() ? parseFloat($(this).val()) : -1;
            if(id_source in shares){
                shares[id_source][id_entity] = share;
            } else {
                temp[id_entity] = share;
                shares[id_source] = temp;
            }
        }
    });
    for (const id_source in shares) {
        if (shares.hasOwnProperty(id_source)) {
            const list_shares = shares[id_source];
            var sum = 0;
            var shareFS = parseFloat($("#entities_table_2 #shareFS_"+id_source).text().split("%")[0]);
            var list_entities = [];
            for (const id_entity in list_shares) {
                if (list_shares.hasOwnProperty(id_entity)) {
                    const share = list_shares[id_entity];
                    if(share){
                        sum += share;
                    }
                    list_entities.push(id_entity);
                }
            }
            //console.log(id_source,shareFS,sum);
            if(shareFS != sum){
                list_entities.forEach((id_entity) => {
                    $("#share_"+id_source+"_"+id_entity).css("background","salmon");
                });
                ret = false;
            } else {
                /* list_entities.forEach((id_entity) => {
                    $("#share_"+id_source+"_"+id_entity).css("background","palegreen");
                }); */
            }
        }
    }
    return ret;
}

dates2 = {};
initDatepickers2();
checkInputEntities2()