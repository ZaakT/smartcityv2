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


//récupérer les infos json
var projectData = JSON.parse($('#bankability_data').html());
var currency = $('#currency').html().replace('(','').replace(')',' ');
update_bankability();


  
function update_bankability(){
  //corrects si tous les input sont non nuls, des nombres, que target >= no go pour npv roi nqbr et l'inverse poru payback et rr

  //quand on clique sur le bouton ok
  //récupérer les input
  // si tous les input ne sont pas corrects: afficher "please rentrer tout"
  // sinon
  //   mettre a jour project score
  //   mettre a jour overal
  //   mettre a jour graphs


  //GET ALL THE INPUT DATA 
  var input = {
      'npv':{
          'nogo':$('#npv_nogo').val(),
          'target':$('#npv_target').val()
      },
      'roi':{
          'nogo':$('#roi_nogo').val(),
          'target':$('#roi_target').val()
      },
      'payback':{
          'nogo':$('#payback_nogo').val(),
          'target':$('#payback_target').val()
      },
      'rr':{
          'nogo':$('#rr_nogo').val(),
          'target':$('#rr_target').val()
      },
      'nqbr':{
          'nogo':$('#nqbr_nogo').val(),
          'target':$('#nqbr_target').val()
      }
  };
  //console.log(input);

  if (checkInput()) {
      var score = projectScore(input);

      updateCharts(input);
  }
}

function checkInput(){
  //GET ALL THE INPUT DATA 
  var input = {
      'npv':{
          'nogo':$('#npv_nogo').val(),
          'target':$('#npv_target').val()
      },
      'roi':{
          'nogo':$('#roi_nogo').val(),
          'target':$('#roi_target').val()
      },
      'payback':{
          'nogo':$('#payback_nogo').val(),
          'target':$('#payback_target').val()
      },
      'rr':{
          'nogo':$('#rr_nogo').val(),
          'target':$('#rr_target').val()
      },
      'nqbr':{
          'nogo':$('#nqbr_nogo').val(),
          'target':$('#nqbr_target').val()
      }
  };
  //console.log(input);

  function updateCharts(input) {
    var financialChartData =  [
        calcChartValue(
            Number(projectData['fin_npv']), 
            Number(input['npv']['target']), 
            Number(input['npv']['nogo'])),
        calcChartValue(
            Number(projectData['fin_roi']), 
            Number(input['roi']['target']), 
            Number(input['roi']['nogo'])),
        calcChartValue(
            -Number(projectData['fin_payback']), 
            -Number(input['payback']['target']), 
            -Number(input['payback']['nogo'])),
        calcChartValue(
            -Number(projectData['rating_risks']), 
            -Number(input['rr']['target']), 
            -Number(input['rr']['nogo'])),
        calcChartValue(
            Number(projectData['rating_noncash']), 
            Number(input['nqbr']['target']), 
            Number(input['nqbr']['nogo'])),
        ];
    
    var societalChartData =  [
        calcChartValue(
            Number(projectData['soc_npv']), 
            Number(input['npv']['target']), 
            Number(input['npv']['nogo'])),
        calcChartValue(
            Number(projectData['soc_roi']), 
            Number(input['roi']['target']), 
            Number(input['roi']['nogo'])),
        calcChartValue(
            -Number(projectData['soc_payback']), 
            -Number(input['payback']['target']), 
            -Number(input['payback']['nogo'])),
        calcChartValue(
            -Number(projectData['rating_risks']), 
            -Number(input['rr']['target']), 
            -Number(input['rr']['nogo'])),
        calcChartValue(
            Number(projectData['rating_noncash']), 
            Number(input['nqbr']['target']), 
            Number(input['nqbr']['nogo'])),
        ];
    console.log(financialChartData, societalChartData);

    if (financialChart.data.datasets.length > 2) {
        financialChart.data.datasets.pop();
        societalChart.data.datasets.pop();
    }

    financialChart.data.datasets.push({
        label: 'Project',
        fill: true,
        backgroundColor: "rgba(85, 216, 254, 0.2)",
        borderColor: 'rgb(85, 216, 254)',
        borderWidth: 2,
        pointRadius: 2,
        data: financialChartData
      });
      financialChart.update();

      societalChart.data.datasets.push({
        label: 'Project',
        fill: true,
        backgroundColor: "rgba(163, 160, 251, 0.2)",
        borderColor: 'rgb(163, 160, 251)',
        borderWidth: 2,
        pointRadius: 2,
        data: societalChartData
      });
      societalChart.update();  
        
}

  var flagVerif = true;
  for (var key in input) {
      if (input[key]['nogo'] == "" || !input['target'] == "") { //vérifier que les entrées sont non nulles
          flagVerif = false;
          $('#errorInput').html("Error: make sure every input is completed");
          break;
      } else if ((key == 'npv' || key == 'roi' || key == 'nqbr') && Number(input[key]['nogo']) > Number(input[key]['target'])) { 
          //que les relations d'ordres sont respectées
          flagVerif = false;
          $('#errorInput').html("Error: No go value has to be lower than Target value for Net Present Value, Return on Investment and Non Quantifiable Benefits Rating");
          break;
      } else if ((key == 'rr' || key == 'payback') && Number(input[key]['target']) > Number(input[key]['nogo'])) {
          flagVerif = false;
          $('#errorInput').html("Error: No go value has to be greater than Target value for Payback and Risk Rating");
          break;
      } else {
          $('#errorInput').html("");
      }
  }

return flagVerif;
}


function projectScore(input) {

  //AFFICHER TARGETS DANS LE TABLEAU PROJECT SCORE
  $('#display_target_npv').html(input.npv.target ? input.npv.target+' '+currency : " - "); 
  $('#display_target_roi').html(input.roi.target ? input.roi.target+' %' : " - ");
  $('#display_target_payback').html(input.payback.target ? input.payback.target+' months' : " - ");
  $('#display_target_rr').html(input.rr.target ? input.rr.target : " - ");
  $('#display_target_nqbr').html(input.nqbr.target ? input.nqbr.target : " - ");

  //AFFICHAGE DES POUCES
  //pour chaque indicateur
  // si indicateur >= target => resultatscore = 1 et on cache pouce en en bas, on affiche pouce en haut et on le colorie en vert
  // si no go <= indicateur < target => resultat =2, on cache pouce en bas, on affiche pouche en haut et on el colorie en orange
  // si indicatuer < nogo => resultat = 3, on cache pouce en haut, on affiche pouce en bas
  score = {
      'fin_npv': calcProjectScore(
          Number(projectData['fin_npv']), 
          Number(input['npv']['target']), 
          Number(input['npv']['nogo']), 
          '#fin_npv'),
      'soc_npv': calcProjectScore(
          Number(projectData['soc_npv']), 
          Number(input['npv']['target']), 
          Number(input['npv']['nogo']), 
          '#soc_npv'),
      'fin_roi': calcProjectScore(
          Number(projectData['fin_roi']), 
          Number(input['roi']['target']), 
          Number(input['roi']['nogo']), 
          '#fin_roi'),
      'soc_roi': calcProjectScore(
          Number(projectData['soc_roi']), 
          Number(input['roi']['target']), 
          Number(input['roi']['nogo']), 
          '#soc_roi'),
      'fin_payback': calcProjectScore(
          -Number(projectData['fin_payback']), 
          -Number(input['payback']['target']), 
          -Number(input['payback']['nogo']), 
          '#fin_payback'),
      'soc_payback': calcProjectScore(
          -Number(projectData['soc_payback']), 
          -Number(input['payback']['target']), 
          -Number(input['payback']['nogo']), 
          '#soc_payback'),
      'rr': calcProjectScore(
          -Number(projectData['rating_risks']), 
          -Number(input['rr']['target']), 
          -Number(input['rr']['nogo']), 
          '.rr'),
      'nqbr': calcProjectScore(
          Number(projectData['rating_noncash']), 
          Number(input['nqbr']['target']), 
          Number(input['nqbr']['nogo']), 
          '.nqbr')
  };
  //console.log(score);

  return score;
}