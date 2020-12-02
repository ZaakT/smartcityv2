var space = '                   ';
var currency = $('#currency').html().replace('(','').replace(')',' ');
////////////////////  KEY DATES  /////////////////////////
var colors = ["rgba(95,227,161,", "rgba(163,160,251,","rgba(85,216,254,","rgba(255,218,131,","rgba(255,131,115,","rgba(0,123,255,","rgba(247, 174, 248,", "rgba(214, 255, 121,","rgba(220, 237, 255,"];
var id = 0;
var i = 0;


////////// CHANGE TH ECOLOR OF THE KEY DATES \\\\\\\\\\\\\\\\\\
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






////////////////////  COST BENEFITS /////////////////////////

//GET THE DATA FROM THE HIDDEN TABS

var cbLabel = [];
$('.cbLabel').each(function() {
  cbLabel.push($(this).html());
});
var yearCB = [];
$('.yearCB').each(function() {
  yearCB.push($(this).html());
});
var CNC = [];
$('.CNC').each(function() {
  var temp = $(this).html();
  CNC.push(temp);
});
var CNSC = [];
$('.CNSC').each(function() {
  var temp = $(this).html();
  CNSC.push(temp);
});
//console.log(cbLabel,yearCB,CNC,CNSC);



if(CNSC.length>0){
  chartCost = new Chart(document.getElementById("costbenefitsGraph"), {
    type: 'line',
    data: {
      labels: yearCB,
      datasets: [{ 
          data: CNC,
          label: cbLabel[0],
          borderColor: "#A3A0FB",
          backgroundColor: "#A3A0FB",
          fill: false
        } ,{ 
          data: CNSC,
          label: cbLabel[1],
          borderColor: "#55D8FE",
          backgroundColor: "#55D8FE",
          fill: false
        }
      ]
    },
    options: {
      legend : {
        labels : {
          usePointStyle: true
        }
      },
      scales: {
        yAxes: [{
            scaleLabel: {
              display: true,
            labelString: 'Cash (in '+currency+')'
            },
            ticks: {
              beginAtZero: true,
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
}else{
  chartCost = new Chart(document.getElementById("costbenefitsGraph"), {
    type: 'line',
    data: {
      labels: yearCB,
      datasets: [{ 
          data: CNC,
          label: cbLabel[0],
          borderColor: "#A3A0FB",
          backgroundColor: "#A3A0FB",
          fill: false
        } 
      ]
    },
    options: {
      legend : {
        labels : {
          usePointStyle: true
        }
      },
      scales: {
        yAxes: [{
            scaleLabel: {
              display: true,
            labelString: 'Cash (in '+currency+')'
            },
            ticks: {
              beginAtZero: true,
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






/////////////  FINANCIAL AND SOCIETAL BANKABILITY \\\\\\\\\\\\\\\\\\

//récupérer les input nogo target
//récupérer les valeurs fin and soc
//Calculer valeurs a afficher dans graphiques
     

function createCharts(input,projectData) {

  var financialChartData =  [
    calcChartValue(
        Number(projectData['fin_npv']), 
        Number(input['npv_target']), 
        Number(input['npv_nogo'])),
    calcChartValue(
        Number(projectData['fin_roi']), 
        Number(input['roi_target']), 
        Number(input['roi_nogo'])),
    calcChartValue(
        -Number(projectData['fin_payback']), 
        -Number(input['payback_target']), 
        -Number(input['payback_nogo'])),
    calcChartValue(
        -Number(projectData['rating_risks']), 
        -Number(input['rr_target']), 
        -Number(input['rr_nogo'])),
    calcChartValue(
        Number(projectData['rating_noncash']), 
        Number(input['nqbr_target']), 
        Number(input['nqbr_nogo'])),
    ];

var societalChartData =  [
    calcChartValue(
        Number(projectData['soc_npv']), 
        Number(input['npv_target']), 
        Number(input['npv_nogo'])),
    calcChartValue(
        Number(projectData['soc_roi']), 
        Number(input['roi_target']), 
        Number(input['roi_nogo'])),
    calcChartValue(
        -Number(projectData['soc_payback']), 
        -Number(input['payback_target']), 
        -Number(input['payback_nogo'])),
    calcChartValue(
        -Number(projectData['rating_risks']), 
        -Number(input['rr_target']), 
        -Number(input['rr_nogo'])),
    calcChartValue(
        Number(projectData['rating_noncash']), 
        Number(input['nqbr_target']), 
        Number(input['nqbr_nogo'])),
    ];
//console.log(financialChartData, societalChartData);



///////////// SOCIETAL BANKABILIY ///////////
societalChart = new Chart($('#societalBankabilityChart'), {
type: 'radar',
data: { 
  labels: [['Societal','Net Present Value'],['Societal Return', 'per '+currency+' invested'], ['Societal Payback /','Project Duration'], 'Risks Rating', ['Non Quantifiable', 'Benefits Rating']],
  datasets: [{
      label: 'Target',
      fill: false,
      borderColor: 'green',
      pointRadius: 0,
      data: [4,4,4,4,4]
    },{
      label: 'No Go',
      fill: false,
      borderColor: 'red',
      pointRadius: 0,
      data: [2,2,2,2,2]
    },{
      label: 'Project',
      fill: true,
      backgroundColor: "rgba(163, 160, 251, 0.2)",
      borderColor: 'rgb(163, 160, 251)',
      borderWidth: 2,
      pointRadius: 2,
      data: societalChartData
    }]
},
options: {
  title: {
    display: false
  },
  legend: {
    position: "left"
  },
  plugins: {
    datalabels: {
      display: false
    }
  },
  scale: {
      ticks: {
          callback: function() {return ""},
          suggestedMin: 0,
          suggestedMax: 5,
          stepSize: 1
      }
      
  }
}
});
}

function calcChartValue(projectScore, target, nogo) {
  var delta = target * 0.05;
  //console.log(projectScore,target,nogo,delta);
  var resultat = 0;
  if ( projectScore < nogo - delta ) resultat = 1;
  else if ( projectScore <= nogo + delta ) resultat = 2;
  else if ( projectScore < target - delta) resultat = 3;
  else if (projectScore <= target + delta) resultat = 4;
  else resultat = 5;

  return resultat;
}



//-----------------------------------------------------------------------------

///////////// SOCIETAL BANKABILIY ///////////

function updateBankability(){
  var data = $('#data').data("bankabilityTargetNogo").target;
  var selDevSym = $("#selDevSym").text();

  var current = $('#data').data("bankabilityCalc");
  console.log("current");
  console.log(current);
  if(data.length==0){
    $("#errorInput").text("Error: make sure Deal Criteria is completed.");
  }else{
    $("#display_operatingMargin").text(data.operating_margin_target.toLocaleString()+" %");
    $("#display_payback").text(data.payback_target.toLocaleString()+" months");
    $("#display_societalPayback").text(data.societal_payback_target.toLocaleString()+" months");
    $("#display_roi").text(data.roi_target.toLocaleString()+" %");
    $("#display_societalRoi").text(data.societal_roi_target.toLocaleString()+" %");
    $("#display_npv").text(selDevSym+" "+data.npv_target).toLocaleString();  
    $("#display_societalNpv").text(selDevSym+" "+data.societal_npv_target.toLocaleString());
    if(data.nqbr_target>=0){
      $("#display_nqb").text(data.nqbr_target.toLocaleString()+"/10");
    }
    if(data.rr_target>=0){
      $("#display_risk").text(data.rr_target.toLocaleString()+"/10");
    }
    //$("#current_operatingMargin").text(current.fin_operating_margin.toLocaleString()+" %");
    $("#current_payback").text(current.fin_payback.toLocaleString()+" months");
    $("#current_societalPayback").text(current.fin_societal_payback.toLocaleString()+" months");
    $("#current_roi").text(current.fin_roi.toLocaleString()+" %");
    $("#current_societalRoi").text(current.fin_societal_roi.toLocaleString()+" %");
    $("#current_npv").text(selDevSym+" "+Math.round(current.fin_npv).toLocaleString());  
    $("#current_societalNpv").text(selDevSym+" "+current.fin_societal_npv.toLocaleString());
    if(data.nqb>=0){
      $("#current_nqb").text(current.nqb.toFixed(2).toLocaleString()+"/10");
    }
    if(data.rating_risks>=0){
      $("#current_risk").text(current.rating_risks.toFixed(2).toLocaleString()+"/10");
    }
  }

}
function projectScore() {
  var data = $('#data').data("bankabilityTargetNogo");
  var dataCalc = $('#data').data("bankabilityCalc");
  console.log(dataCalc);
  console.log(data);
  console.log("coucou : " + dataCalc[2]);
  console.log(dataCalc);
  updateBankability();


  //AFFICHAGE DES POUCES
  //pour chaque indicateur
  // si indicateur >= target => resultatscore = 1 et on cache pouce en en bas, on affiche pouce en haut et on le colorie en vert
  // si no go <= indicateur < target => resultat =2, on cache pouce en bas, on affiche pouche en haut et on el colorie en orange
  // si indicatuer < nogo => resultat = 3, on cache pouce en haut, on affiche pouce en bas
  score = {
    'fin_payback': calcProjectScore(
        Number(dataCalc.fin_payback), 
        Number(data.target.payback_target), 
        Number(data.nogo.payback_nogo), 
        '#fin_payback'),
    'soc_payback': calcProjectScore(
        Number(dataCalc.soc_payback), 
        Number(data.target.payback_target), 
        Number(data.nogo.payback_nogo), 
        '#soc_payback'),
    'fin_societal_payback': calcProjectScore(
        Number(dataCalc.fin_societal_payback), 
        Number(data.target.societal_payback_target), 
        Number(data.nogo.societal_payback_nogo), 
        '#fin_societalPayback'),
    'soc_societal_payback': calcProjectScore(
        Number(dataCalc.soc_societal_payback), 
        Number(data.target.societal_payback_target), 
        Number(data.nogo.societal_payback_nogo), 
        '#soc_societalPayback'),
    'fin_roi': calcProjectScore(
        Number(dataCalc.fin_roi), 
        Number(data.target.roi_target), 
        Number(data.nogo.roi_nogo), 
        '#fin_roi'),
    'soc_roi': calcProjectScore(
        Number(dataCalc.soc_roi), 
        Number(data.target.roi_target), 
        Number(data.nogo.roi_nogo), 
        '#soc_roi'),
    'fin_societal_roi': calcProjectScore(
        Number(dataCalc.fin_roi), 
        Number(data.target.societal_roi_target), 
        Number(data.nogo.societal_roi_nogo), 
        '#fin_societalRoi'),
    'soc_societal_roi': calcProjectScore(
          Number(dataCalc.soc_roi), 
          Number(data.target.roi_target), 
          Number(data.nogo.societal_roi_nogo), 
          '#soc_societalRoi'),

    'fin_npv': calcProjectScore(
        Number(dataCalc.fin_npv), 
        Number(data.target.npv_target), 
        Number(data.nogo.npv_nogo), 
        '#fin_npv'),
    'soc_npv': calcProjectScore(
        Number(dataCalc.soc_npv), 
        Number(data.target.npv_target), 
        Number(data.nogo.npv_nogo), 
        '#soc_npv'),
    'fin_societal_npv': calcProjectScore(
        Number(dataCalc.fin_societal_npv), 
        Number(data.target.societal_npv_target), 
        Number(data.nogo.societal_npv_nogo), 
        '#fin_societalNpv'),   
    'soc_societal_npv': calcProjectScore(
        Number(dataCalc.soc_societal_npv), 
        Number(data.target.societal_npv_target), 
        Number(data.nogo.societal_npv_nogo), 
        '#soc_societalNpv'),

    'fin_nqb': calcProjectScore(
        Number(dataCalc.nqb), 
        Number(data.target.nqbr_target), 
        Number(data.nogo.nqbr_nogo), 
        '#fin_nqb'),
    'soc_nqb': calcProjectScore(
        Number(dataCalc.nqb), 
        Number(data.target.nqbr_target), 
        Number(data.nogo.nqbr_nogo), 
        '#soc_nqb'),
    'fin_rating_risks': calcProjectScore(
        Number(dataCalc.rating_risks), 
        Number(data.target.rr_target), 
        Number(data.nogo.rr_nogo), 
        '#fin_risk'),
    'soc_rating_risks': calcProjectScore(
        Number(dataCalc.rating_risks), 
        Number(data.target.rr_target), 
        Number(data.nogo.rr_nogo), 
        '#soc_risk'),
    'fin_operating_margin': calcProjectScore(
        Number(dataCalc.fin_operating_margin), 
        Number(data.target.operating_margin_target),
        Number(data.nogo.operating_margin_nogo),  
        '#fin_operatingMargin'),
    'soc_operating_margin': calcProjectScore(
        Number(dataCalc.soc_operating_margin),  
        Number(data.target.operating_margin_target), 
        Number(data.nogo.operating_margin_nogo),
        '#soc_operatingMargin')
        
  };
  //console.log(score);

  return score;
}
function calcProjectScore(projectScore, target, nogo, idSelector) {
  var score = 0;
  if(target>=nogo){
    if (projectScore >= target) {
        score = 1;
        $(idSelector+'_thumb-down').attr('hidden', true);
        $(idSelector+'_thumb-up').removeAttr('hidden');
        $(idSelector+'_thumb-up').css("color", "green"); 
    } else if ( projectScore >= nogo ) {
        score = 2;
        $(idSelector+'_thumb-down').attr('hidden', true);
        $(idSelector+'_thumb-up').removeAttr('hidden');
        $(idSelector+'_thumb-up').css("color", "orange"); 
    } else {
        score = 3;
        $(idSelector+'_thumb-up').attr('hidden', true);
        $(idSelector+'_thumb-down').removeAttr('hidden');          
    }
  }else{
    if (projectScore <= target) {
      score = 1;
      $(idSelector+'_thumb-down').attr('hidden', true);
      $(idSelector+'_thumb-up').removeAttr('hidden');
      $(idSelector+'_thumb-up').css("color", "green"); 
    } else if ( projectScore <= nogo ) {
        score = 2;
        $(idSelector+'_thumb-down').attr('hidden', true);
        $(idSelector+'_thumb-up').removeAttr('hidden');
        $(idSelector+'_thumb-up').css("color", "orange"); 
    } else {
        score = 3;
        $(idSelector+'_thumb-up').attr('hidden', true);
        $(idSelector+'_thumb-down').removeAttr('hidden');          
    }
  }
  
  //console.log(idSelector, projectScore, target, nogo, score  );
  return score;
}


projectScore();

//--- Torus Graph ---
var space = '                   ';
var donutColors = colors;
for (var key in donutColors){
  donutColors[key] += '1)';
}
var torusNames = $('#data').data("repartitionOfBenefits").titles;
var torusData = $('#data').data("repartitionOfBenefits").data;
var repartitionOfBenefits = new Chart($('#repartitionOfBenefits'), {
  type: 'doughnut',
  data: {
    labels: torusNames, //data
    datasets: [
      {
        label: "# of items",
        backgroundColor: donutColors,
        data: torusData, //data
        borderWidth : 0
      }
    ]
  },
  options: {
    responsive:true,
    legend: {
      display: true,
      position: "right",
      labels: {
         boxWidth: 20,
         align: "center",
         fontSize: 15,
         useLineStyle: true
      }
    },
    layout: {
      padding: {
          left: 0,
          right: 0,
          top: 0,
          bottom: 0
      }
    },
    plugins: {
    datalabels: {
      display: true,
      formatter: (value, ctx) => {
                      let sum = 0;
                      let dataArr = ctx.chart.data.datasets[0].data;
                      dataArr.map(data => {
                          sum += data;
                      });
                      let percentage = (value*100 / sum).toFixed(2)+"%";
                      return percentage;
                  },
              }
    }
  }
});



