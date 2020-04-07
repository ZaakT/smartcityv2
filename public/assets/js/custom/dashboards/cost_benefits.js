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
    console.log("kpi");
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
    console.log("keydates");
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


update_UC();


