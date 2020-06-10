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




////////////////  NUMBER OF ITEMS - DONUT CHART /////////////////////////

//GET THE DATA FROM THE HIDDEN TABS

var measureName = $('.measureName').html();
var ucName = [];
$('.ucName').each(function() {
  //console.log($(this).html());
  ucName.push($(this).html());
});
var ucQuantity = [];
$('.ucQuantity').each(function() {
 // console.log($(this).html());
  ucQuantity.push($(this).html());
});
var donutColors = colors;
for (var key in donutColors){
  donutColors[key] += '1)';
}
//console.log(ucQuantity);

//DISPLAY GRAPH
var numberOfItems = new Chart($('#numberOfItems'), {
    type: 'doughnut',
    data: {
      labels: ucName, //data
      datasets: [
        {
          label: "# of items",
          backgroundColor: donutColors,
          data: ucQuantity, //data
          borderWidth : 0
        }
      ]
    },
    options: {
      responsive:true,
      title: {
        display: true,
        text: space+measureName, //data
        position: "top",
        padding: 0, //-20
        fontSize: 17
      },
      legend: {
        display: true,
        position: "right",
        labels: {
           boxWidth: 20,
           align: "center",
           fontSize: 15
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
        formatter: function(value, index, values) {
          if (parseInt(value) >= 1000||parseInt(value) <= -1000) {
              return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          } else {
              return value;
          }
      }
      }
      }
    }
});

////////////////////  BUDGET /////////////////////////

//GET THE DATA FROM THE HIDDEN TABS

var yearBudget = [];
$('.yearBudget').each(function() {
  yearBudget.push($(this).html());
});
var budgetLabel = [];
$('.budgetLabel').each(function() {
  budgetLabel.push($(this).html());
});
var BOC = [];
$('.BOC').each(function() {
  BOC.push($(this).html());
});
var NPC = [];
$('.NPC').each(function() {
  var temp = $(this).html().replace(',','');
  NPC.push(temp);
});
var OPI = [];
$('.OPI').each(function() {
  var temp = $(this).html().replace(',','');
  OPI.push(temp);
});
//console.log(BOC,NPC,OPI);

//BOC=[78436, 20436,30436,40436,10436];  //dev

var budgetGraph = new Chart($('#budgetGraph'), {
  type: 'bar',
  data: {
      datasets: [{
          label: budgetLabel[0],
          data: BOC,
          backgroundColor: '#A3A0FB',
          order: 3
      }, {
        label: budgetLabel[1],
        data: NPC,
        backgroundColor: '#5FE3A1',
        order: 2
    }, {
          label: budgetLabel[2],
          data: OPI,
          borderColor: '#2137B0',
          fill: false,

          // Changes this dataset to become a line
          type: 'line',
          order: 1
      }],
      labels: yearBudget
  },
  options:  {
    tooltips: {enabled: true},
    cornerRadius: 20,
    title: { display: false },  
    scales: {
      xAxes: [{
          stacked: true,
          barPercentage: 0.5
      }],
      yAxes: [{
          stacked: true,
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
    plugins: {
      datalabels: {
        display: false
      }
    }
  }
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


new Chart(document.getElementById("costbenefitsGraph"), {
  type: 'line',
  data: {
    labels: yearCB,
    datasets: [{ 
      data: CNSC,
      label: cbLabel[1],
      borderColor: "#55D8FE",
      backgroundColor: "#55D8FE",
      fill: false
    },{ 
        data: CNC,
        label: cbLabel[0],
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


//////////  FINANCIAL BANKABILIY /////////
financialChart = new Chart($('#financialBankabilityChart'), {
type: 'radar',
data: { 
  labels: ['Net Present Value','Return per '+currency+' invested', ['Payback /','Project Duration'], 'Risks Rating', ['Non Quantifiable', 'Benefits Rating']],
  datasets: [{
      label: 'Target',
      fill: false,
      pointRadius: 0,
      borderColor: 'green',
      data: [4,4,4,4,4]
    },{
      label: 'No Go',
      fill: false,
      pointRadius: 0,
      borderColor: 'red',
      data: [2,2,2,2,2]
    },{
      label: 'Project',
      fill: true,
      backgroundColor: "rgba(85, 216, 254, 0.2)",
      borderColor: 'rgb(85, 216, 254)',
      borderWidth: 2,
      pointRadius: 2,
      data: financialChartData
    }]
},
options: {
  title: {
    display: false
  },
  legend: {
    position: "right"
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

function isEmptyObject(obj) {
  return Object.keys(obj).length === 0 && obj.constructor === Object;
}

var projectData = JSON.parse($('#bankability_data').html());
var input = JSON.parse($('#input_nogo_target').html());
//console.log(input, isEmptyObject(input));
if (!isEmptyObject(input)) {
  createCharts(input,projectData);
} else {
  $('#financialBankabilityChart').hide();
  $('#societalBankabilityChart').hide();
  $('.bankability_error').show();
}

