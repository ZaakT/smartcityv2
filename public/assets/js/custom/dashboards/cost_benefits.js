function formatNumber(number)
{
    number = number.toFixed(0) + '';
    x = number.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

////////// CHANGE TH ECOLOR OF THE KEY DATES \\\\\\\\\\\\\\\\\\
var colors = ["rgba(95,227,161,", "rgba(163,160,251,","rgba(255,218,131,","rgba(255,131,115,","rgba(85,216,254,","rgba(0,123,255,"];
var i=0;
$('.uc').each(function() {
    id = $(this).attr('id').split("_");
    //console.log(id);
    $('#step1_'+id[1]).css("background-color", colors[i]+"0.4)"); 
    //console.log('border-left : 12px solid '+colors[i]+'0.4);');
    document.styleSheets[3].addRule('#step1_'+id[1]+'::after','border-left : 12px solid rgb(255,255,255,0.4);');
    $('#step2_'+id[1]).css("background-color", colors[i]+"0.7)");
    document.styleSheets[3].addRule('#step2_'+id[1]+'::after','border-left : 12px solid rgb(255,255,255,0.3);');
    $('#step3_'+id[1]).css("background-color", colors[i]+"1)"); 
    i++;
  });

// récupérer la liste des uc
//   get list of uc
//   pour chacun, vérifier si la checkbox est check
//   si oui : afficher la ligne correspondante
//   si non: cacher la ligne correspondante
var list_uc = [];
$('.uc').each(function() {
    list_uc.push($(this).attr('id').replace('uc_',''));
});
var currency = $('#currency').html().replace('(','').replace(')',' ');



/////// FONCTION UPDATE
function update() {

    var sumRatioZonePerUC = update_zone();
    keyDates(sumRatioZonePerUC);
    update_data_table (sumRatioZonePerUC);
    kpi(sumRatioZonePerUC);
    update_graph(sumRatioZonePerUC);


}

function kpi(sumRatioZonePerUC){
    //KPI   => format d'affichage et changement de devise
    // sommer
    var totalInvestment = 0;
    var npv = 0;
    var socnpv = 0;
    var breakeven = 0;
    var socbreakeven = 0;
    var ncbr = [0,0]; //[nb de ncbr précisé, somme des ncbr précisés]
    var rr = [0,0];

    list_uc.forEach(function(ucID) {
        //console.log("kpi");
        console.log(ucID);
        var checkBox = $('#select_uc_'+ucID);

        //calculs: somme de chaque indicateurs
        if (checkBox.prop("checked") == true) {
            console.log(Number($('#tot_invest_'+ucID).html()) * sumRatioZonePerUC[ucID]);
            totalInvestment += ( Number($('#tot_invest_'+ucID).html()) * sumRatioZonePerUC[ucID]);
            npv += ( Number($('#npv_'+ucID).html()) * sumRatioZonePerUC[ucID]);
            socnpv += ( Number($('#socnpv_'+ucID).html()) * sumRatioZonePerUC[ucID]);
            if ($('#noncash_rating_'+ucID).html() != "NA") {
                ncbr[0]++;
                ncbr[1] += Number($('#noncash_rating_'+ucID).html());
            }
            if ($('#risks_rating_'+ucID).html() != "NA") {
                rr[0]++;
                rr[1] += Number($('#risks_rating_'+ucID).html());
            }
        }
    }); 
    console.log(totalInvestment, npv, socnpv, ncbr, rr);
    //affichage
    var currency = $('#currency').html().replace('(','').replace(')',' ');
    //console.log(currency);
    $('#tot_invest').html(currency+totalInvestment);
    console.log(totalInvestment);
    $('#npv').html(currency+formatNumber(npv,0));
    $('#socnpv').html(currency+formatNumber(socnpv,0));
    $('#ncbr').html(ncbr[0] > 0 ? formatNumber(ncbr[1]/ncbr[0],2)+" / 10" : "NA");
    $('#rr').html(rr[0] > 0 ? formatNumber(rr[1]/rr[0],2)+" / 10" : "NA");    
}

function keyDates (sumRatioZonePerUC) {   //passer le id en paramètre?
    list_uc.forEach(function(ucID) {
    //console.log("keydates");
    var checkBox = $('#select_uc_'+ucID);

    if (checkBox.prop("checked") == true) {
        $('#keydates_'+ucID).removeAttr('hidden');
    } else if (checkBox.prop("checked") == false){
        $('#keydates_'+ucID).attr('hidden','');
    }
    });  
}


function update_graph(sumRatioZonePerUC) {

    ////// DATA GRAPH
    var labels = [];
    $('.labels').each(function() {
    labels.push($(this).html());
    });
    var yearCB = [];
    $('.yearCNC').each(function() {
    yearCB.push($(this).html());
    });

    //Cumulated Net Cash
    var CNC = [];    //init
    yearCB.forEach(function(year) {
        CNC.push(0);
    });
    list_uc.forEach(function(ucID) {   //for all uc
        var checkBox = $('#select_uc_'+ucID);
        var CNCtemp = [];
        if (checkBox.prop("checked") == true) {  //if it's checked
            $('.CNC_'+ucID).each(function() {    //we create a tab with all the data of the uc in it
            var temp = Number($(this).html());
            CNCtemp.push(temp);
            });
            for(var i=0; i < CNC.length; i++)    //we sums it with the previous datas
            {
                CNC[i] += ( CNCtemp[i] * sumRatioZonePerUC[ucID]);
            }
        }
    });

    //Cumulated Net Social Cash
    var CNSC = [];
    yearCB.forEach(function(year) {
        CNSC.push(0);
    });
    list_uc.forEach(function(ucID) {
        var checkBox = $('#select_uc_'+ucID);  
        var CNSCtemp = [];
        if (checkBox.prop("checked") == true) {
            $('.CNSC_'+ucID).each(function() {
            var temp = Number($(this).html());
            CNSCtemp.push(temp);
            });
            for(var i=0; i < CNSC.length; i++)
            {
                CNSC[i] += ( CNSCtemp[i] * sumRatioZonePerUC[ucID]);
            }
        }
    });

  new Chart(document.getElementById("cbGraph"), {
  type: 'line',
  data: {
    labels: yearCB,
    datasets: [{ 
      data: CNSC,
      label: labels[1],
      borderColor: "#55D8FE",
      backgroundColor: "#55D8FE",
      fill: false
    },{ 
        data: CNC,
        label: labels[0],
        borderColor: "#A3A0FB",
        backgroundColor: "#A3A0FB",
        fill: false
      } 
    ]
  },
  options: {
    scales: {
        yAxes: [{
            scaleLabel: {
              display: true,
            labelString: 'Cash (in '+currency+')'
            },
            ticks: {
                callback: function(value, index, values) {
                    if (parseInt(value) >= 1000||parseInt(value) <= -1000) {
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    } else {
                        return value;
                    }
                }
            }          
        }]
      },
    title: {
      display: false
    },
    plugins: {
      datalabels: {
        display: false
      }
    }
  }
});  
}



function update_data_table (sumRatioZonePerUC) {
    //calc longueur des tab = nb year + nb date + 1
    var lengthdates = $('.year').length + $('.date').length + 1;
    //console.log('lengthdates:'+lengthdates);

    ////// DATA TABLE DETAIL
    var capex = [];    //init
    var implem = [];
    var invest = [];
    var opex = [];
    var revenues = [];
    var cashreleasing = [];
    var widercash = [];
    var netcash = [];
    var cumulnetcash = [];
    var netsoccash = [];
    var cumulnetsoccash = [];
    for(var i=0; i < lengthdates; i++) {
        capex.push(0);
        implem.push(0);
        invest.push(0);
        opex.push(0);
        revenues.push(0);
        cashreleasing.push(0);
        widercash.push(0);
        netcash.push(0);
        netsoccash.push(0);
    }
    for(var i=1; i < lengthdates; i++) {
        cumulnetcash.push(0);
        cumulnetsoccash.push(0);
    }
    list_uc.forEach(function(ucID) {   //for all uc
        var checkBox = $('#select_uc_'+ucID);
        var capextemp = [];
        var implemtemp = [];
        var investtemp = [];
        var opextemp = [];
        var revenuestemp = [];
        var cashreleasingtemp = [];
        var widercashtemp = [];
        var netcashtemp = [];
        var cumulnetcashtemp = [];
        var netsoccashtemp = [];
        var cumulnetsoccashtemp = [];
        if (checkBox.prop("checked") == true) {  //if it's checked
            $('.capex_'+ucID).each(function() {    //we create a tab with all the data of the uc in it
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                capextemp.push(temp);
            });
            $('.implem_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                implemtemp.push(temp);
            });
            $('.invest_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                investtemp.push(temp);
            });
            $('.opex_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                opextemp.push(temp);
            });
            $('.revenues_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                revenuestemp.push(temp);
            });
            $('.cashreleasing_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                cashreleasingtemp.push(temp);
            });
            $('.widercash_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                widercashtemp.push(temp);
            });
            $('.netcash_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                netcashtemp.push(temp);
            });
            $('.cumulnetcash_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                cumulnetcashtemp.push(temp);
            });
            $('.netsoccash_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                netsoccashtemp.push(temp);
            });
            $('.cumulnetsoccash_'+ucID).each(function() {   
                var temp = Number($(this).html()) * sumRatioZonePerUC[ucID];
                cumulnetsoccashtemp.push(temp);
            });
            for(var i=0; i < lengthdates; i++)    //we sum it with the previous datas
            {
                capex[i] += capextemp[i];
                implem[i] += implemtemp[i];
                invest[i] += investtemp[i];
                opex[i] += opextemp[i];
                revenues[i] += revenuestemp[i];
                cashreleasing[i] += cashreleasingtemp[i];
                widercash[i] += widercashtemp[i];
                netcash[i] += netcashtemp[i];
                netsoccash[i] += netsoccashtemp[i];            
            }
            //console.log(cumulnetcashtemp);
            for(var i=0; i < lengthdates-1; i++)    //we sum it with the previous datas
            {
                cumulnetcash[i] += cumulnetcashtemp[i];
                cumulnetsoccash[i] += cumulnetsoccashtemp[i];            
            }
        }
    });
    //console.log(cumulnetcash, netsoccash, cumulnetsoccash);
    for(var i=0; i < lengthdates; i++) {
        $('#capex_'+i).html(formatNumber(capex[i]));
        $('#implem_'+i).html(formatNumber(implem[i]));
        $('#invest_'+i).html(formatNumber(invest[i]));
        $('#opex_'+i).html(formatNumber(opex[i]));
        $('#revenues_'+i).html(formatNumber(revenues[i]));
        $('#cashreleasing_'+i).html(formatNumber(cashreleasing[i]));
        $('#widercash_'+i).html(formatNumber(widercash[i]));
        $('#netcash_'+i).html(formatNumber(netcash[i]));
        $('#netsoccash_'+i).html(formatNumber(netsoccash[i]));
    }
    for(var i=1; i < lengthdates; i++) {
        $('#cumnetcash_'+i).html(cumulnetcash[i-1].toFixed(2));
        $('#cumnetsoccash_'+i).html(cumulnetsoccash[i-1].toFixed(2));
    }

}

function update_zone(){
    var ratio_zones = JSON.parse($('#ratio_zones').html());
    var sumRatioZonePerUC = new Object();
    list_uc.forEach(function(ucID) {
        sumRatioZonePerUC[ucID] = 0;
        });
    //console.log(sumRatioZonePerUC);
    list_uc.forEach(function(ucID) {
        //on parcout chaque zone
        //si cochée, on somme
        for (var idZone in ratio_zones) {
            var checkBox = $('#select_zone_'+idZone);
            if (checkBox.prop("checked") == true) {
                sumRatioZonePerUC[ucID] += Number(ratio_zones[idZone][ucID]);
            }
        }   
    });
    console.log(ratio_zones, sumRatioZonePerUC);
    return sumRatioZonePerUC;
}

function show_hide_months(){
    var elt = $('.month-cell');
    if ( elt[0].hasAttribute("hidden") ){
        elt.removeAttr('hidden');
        $('#cb_chevron_right').attr('hidden', true);
        $('#cb_chevron_left').removeAttr('hidden');
    } else {
        elt.attr('hidden', true);
        $('#cb_chevron_left').attr('hidden', true);
        $('#cb_chevron_right').removeAttr('hidden');
    }
}

function cballuc2csv(idTable,projName,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var name = "output_CB_allUC_"+projName;
    labels.push("Project");
    if(idTable == "cost_benefits_data"){
        name += "_summary";
        $("#cost_benefits_data thead th").each(function(){
            text = $(this).text();
            labels.push(text);
        });
        var i = 0;
        $("#cost_benefits_data tbody tr").each(function(){
            if(i == 0){
                data.push([projName]);
            } else {
                data.push([""]);
            }
            i++;
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                data[data.length-1].push(text);
            });
        });
    }
    //console.log(labels);
    //console.log(data);
    download_csv(name,labels,data)
}

update();
show_hide_months();