// récupérer la liste des uc
//   get list of uc
//   pour chacun, vérifier si la checkbox est check
//   si oui : afficher la ligne correspondante
//   si non: cacher la ligne correspondante
var list_uc = [];
$('.uc').each(function() {
    list_uc.push($(this).attr('id').replace('uc_',''));
});


/////// FONCTION UPDATE
function update_UC() {

    keyDates();
    update_data_table ();

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
                CNC[i] += CNCtemp[i];
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
                CNSC[i] += CNSCtemp[i];
            }
        }
    });
    update_graph(labels, yearCB, CNC, CNSC);

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
    var checkBox = $('#select_uc_'+ucID);

    //calculs: somme de chaque indicateurs
    if (checkBox.prop("checked") == true) {
        totalInvestment += Number($('#tot_invest_'+ucID).html());
        npv += Number($('#npv_'+ucID).html());
        socnpv += Number($('#socnpv_'+ucID).html());
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
//affichage
$('#tot_invest').html('£ '+totalInvestment);
$('#npv').html('£ '+npv);
$('#socnpv').html('£ '+socnpv);
$('#ncbr').html(ncbr[0] > 0 ? ncbr[1]/ncbr[0] : "NA");
$('#rr').html(rr[0] > 0 ? rr[1]/rr[0] : "NA");
}

function keyDates () {   //passer le id en paramètre?
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


function update_graph(labels, yearCB, CNC, CNSC) {

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



function update_data_table () {
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
                var temp = Number($(this).html());
                capextemp.push(temp);
            });
            $('.implem_'+ucID).each(function() {   
                var temp = Number($(this).html());
                implemtemp.push(temp);
            });
            $('.invest_'+ucID).each(function() {   
                var temp = Number($(this).html());
                investtemp.push(temp);
            });
            $('.opex_'+ucID).each(function() {   
                var temp = Number($(this).html());
                opextemp.push(temp);
            });
            $('.revenues_'+ucID).each(function() {   
                var temp = Number($(this).html());
                revenuestemp.push(temp);
            });
            $('.cashreleasing_'+ucID).each(function() {   
                var temp = Number($(this).html());
                cashreleasingtemp.push(temp);
            });
            $('.widercash_'+ucID).each(function() {   
                var temp = Number($(this).html());
                widercashtemp.push(temp);
            });
            $('.netcash_'+ucID).each(function() {   
                var temp = Number($(this).html());
                netcashtemp.push(temp);
            });
            $('.cumulnetcash_'+ucID).each(function() {   
                var temp = Number($(this).html());
                cumulnetcashtemp.push(temp);
            });
            $('.netsoccash_'+ucID).each(function() {   
                var temp = Number($(this).html());
                netsoccashtemp.push(temp);
            });
            $('.cumulnetsoccash_'+ucID).each(function() {   
                var temp = Number($(this).html());
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
        $('#capex_'+i).html(capex[i]);
        $('#implem_'+i).html(implem[i]);
        $('#invest_'+i).html(invest[i]);
        $('#opex_'+i).html(opex[i]);
        $('#revenues_'+i).html(revenues[i]);
        $('#cashreleasing_'+i).html(cashreleasing[i]);
        $('#widercash_'+i).html(widercash[i]);
        $('#netcash_'+i).html(netcash[i]);
        $('#netsoccash_'+i).html(netsoccash[i]);
    }
    for(var i=1; i < lengthdates; i++) {
        $('#cumnetcash_'+i).html(cumulnetcash[i-1]);
        $('#cumnetsoccash_'+i).html(cumulnetsoccash[i-1]);
    }

}


update_UC();