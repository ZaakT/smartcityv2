var space = '                   ';
var currency = $('#currency').html().replace('(','').replace(')',' ');
////////////////////  KEY DATES  /////////////////////////
var colors = ["rgba(95,227,161,", "rgba(163,160,251,","rgba(85,216,254,","rgba(255,218,131,","rgba(255,131,115,","rgba(0,123,255,","rgba(247, 174, 248,", "rgba(214, 255, 121,","rgba(220, 237, 255,"];
var id = 0;
var i = 0;


////////// CHANGE TH ECOLOR OF THE KEY DATES \\\\\\\\\\\\\\\\\\
$('.uc').each(function() {
  id = $(this).attr('id').split("_");
  console.log(id);
  $('#step1_'+id[1]).css("background-color", colors[i]+"0.4)"); 
  console.log('border-left : 12px solid '+colors[i]+'0.4);');
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
console.log(ucQuantity);

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

////////////////////  FINANCIAL BANKABILIY /////////////////////////

//GET THE DATA FROM THE HIDDEN TABS
colors = ["#55D8FE", "#FFDA83","#FF8373","#A3A0FB"];
//         

var FROI = [];
$('.FROI').each(function() {
  FROI.push($(this).html());
});
var fin_payback = [];
$('.fin_payback').each(function() {
  fin_payback.push($(this).html());
});
var cashreleasingScore = [];
$('.cashreleasingScore').each(function() {
  cashreleasingScore.push($(this).html());
});

//console.log(FROI, fin_payback, soc_payback, finBankLabel);

finBankLabel = [['Return per '+currency+' invested'],['Payback /','Project Duration'],['Cash Releasing', 'Benefits']];

// BUILD DATASETS
var finBankDatasets = { 
                        labels: finBankLabel,
                        datasets: []
};
var i = 0;
ucName.forEach((uc)=>{
  finBankDatasets.datasets.push({
    label: ucName[i],
    fill: false,
    backgroundColor: "rgba(179,181,198,0.2)",
    borderColor: colors[i],
    data: [FROI[i],fin_payback[i], cashreleasingScore[i]]
  });
  i++;
});
//console.log(finBankDatasets);

//CHART
new Chart($('#financialBankabilityChart'), {
  type: 'radar',
  data: finBankDatasets,
  options: {
    title: {
      display: false
    },
    legend: {
      position: "bottom"
    },
    plugins: {
      datalabels: {
        display: false
      }
      }
  }
});



////////////////////  SOCIETAL BANKABILIY /////////////////////////

//GET THE DATA FROM THE HIDDEN TABS

var SROI = [];
$('.SROI').each(function() {
  SROI.push($(this).html());
});
var soc_payback = [];
$('.soc_payback').each(function() {
  soc_payback.push($(this).html());
});
var risksScores = [];
$('.risksScores').each(function() {
  risksScores.push($(this).html());
});
var noncashScores = [];
$('.noncashScores').each(function() {
  noncashScores.push($(this).html());
});
var socBankLabel = [['Societal Return','per '+currency+' invested'],['Societal Payback /','Project Duration'],'Risks',['Non Cash','Benefits']];

// BUILD DATASETS
var socBankDatasets = { 
  labels: socBankLabel,
  datasets: []
};
var i = 0;
ucName.forEach((uc)=>{
  socBankDatasets.datasets.push({
    label: ucName[i],
    fill: false,
    backgroundColor: "rgba(179,181,198,0.2)",
    borderColor: colors[i],
    data: [SROI[i],soc_payback[i], risksScores[i], noncashScores[i]]
  });
  i++;
});
//console.log(socBankDatasets);

//CHART
new Chart($('#societalBankabilityChart'), {
  type: 'radar',
  data: socBankDatasets,
  options: {
    title: {
      display: false
    },
    legend: {
      display: false
    },
    plugins: {
      datalabels: {
        display: false
      }
      }
  }
});

