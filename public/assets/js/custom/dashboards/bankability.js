//récupérer les infos json
var projectData = JSON.parse($('#bankability_data').html());
var currency = $('#currency').html().replace('(','').replace(')',' ');
createCharts();
update_bankability();

//vérifier que target > nogo!! et no

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

        overalAssessment(score);

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

function createCharts() {
////////////////////  FINANCIAL BANKABILIY /////////////////////////
//CHART
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
            suggestedMax: 5
        }
        
    }
  }
});

////////////////////  SOCIETAL BANKABILIY /////////////////////////
//CHART
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
            suggestedMax: 5
        }
        
    }
  }
});
}

function filldefault() {
    $('#npv_nogo').val(100000);
    $('#npv_target').val(2000000);
    $('#roi_nogo').val(500);
    $('#roi_target').val(1000);
    $('#payback_nogo').val(9);
    $('#payback_target').val(6);
    $('#rr_nogo').val(8);
    $('#rr_target').val(4);
    $('#nqbr_nogo').val(2),
    $('#nqbr_target').val(3);
}  //fonction pour le bouton qui remplit avec des valeurs defaut : dev

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

function calcProjectScore(projectScore, target, nogo, idSelector) {
    var score = 0;
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
    
    //console.log(idSelector, projectScore, target, nogo, score  );
    return score;
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

function overalAssessment(score){
    //ALGO OVERAL
    // flag = [rouge: false, orange: false]
    //pour chaque score
    //  si c'est 3 => flag[rouge] = true
    //  si c 2 => flag[orange] = true
    //si flag[rouge]=true => allumer feu rouge, éteindre les autres
    // sinon si flag[orange]=true =>allumer feu orange, eteindre els autres
    // sinon allumer feu vert eteindre les autres

    var flag = { 'red':false, 'yellow':false };
    for(var key in score) {
        if (score[key] == 3) flag['red'] = true;
        if (score[key] == 2) flag['yellow'] = true;
    }

    //console.log(flag);
    if (flag.red) {
        $('#redcircle-bankability').css("color", "red"); 
        $('#yellowcircle-bankability').css("color", "#737300"); 
        $('#greencircle-bankability').css("color", "#194A04"); 
        $('#overal-project').html('Your project is not bankable.');
    } else if (flag.yellow) {
        $('#redcircle-bankability').css("color", "#5C0006"); 
        $('#yellowcircle-bankability').css("color", "yellow"); 
        $('#greencircle-bankability').css("color", "#194A04"); 
        $('#overal-project').html('Your project is bankable.');
    } else {
        $('#redcircle-bankability').css("color", "#5C0006"); 
        $('#yellowcircle-bankability').css("color", "#737300"); 
        $('#greencircle-bankability').css("color", "greenyellow");   
        $('#overal-project').html('Your project is highly bankable.');
    }

}
