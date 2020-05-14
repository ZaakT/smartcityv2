var list_uc = [];
$('.uc').each(function() {
    list_uc.push($(this).attr('id').replace('select_uc_',''));
}); 
var list_year = [];
$('.year').each(function() {
    list_year.push($(this).html());
}); 
var data = JSON.parse($('#data').html());
var lengthDates = $('.year').length ;
var currency = $('#currency').html().replace('(','').replace(')',' ');

function update_budget(){
    var sumUCData = data;
    
    //initialisation du tableau des sommes des valeurs 
    sumUCData.budgetCost.current = 0;
    sumUCData.baselineOpCost.current = 0;
    list_year.forEach(function(year) {
        sumUCData['budgetCost'][year] = 0;
        sumUCData['baselineOpCost'][year] = 0;
        sumUCData['netProjectCost'][year] = 0;
        sumUCData['implem'][year] = 0;
        sumUCData['opex'][year] = 0;
        sumUCData['revenues'][year] = 0;
        sumUCData['capexAmort'][year] = 0;
        sumUCData['OBYI'][year] = 0;
        sumUCData['OBCI'][year] = 0;
        sumUCData['CRV'][year] = 0;

    });
    //calcul pour chaque valeur et chaque année de la somme des valeurs corespondantes pour les UC cochés
    //ALGO:
    // pour chaque uc
    //  si la case de sélection est cochée
    //   sommer la valeur pour budgetcost et baseline current 
    //   pour chaque année
    //    sommer chaque donnée avec la donnée correspondate du uc

    list_uc.forEach(function(ucID) {
        var checkBox = $('#select_uc_'+ucID);
        if (checkBox.prop("checked") == true) { 
            sumUCData['budgetCost']['current'] += Number(data['budgetCost'][ucID]['current']);
            sumUCData['baselineOpCost']['current'] += Number(data['baselineOpCost'][ucID]['current']);
            list_year.forEach(function(year) { 
                sumUCData['budgetCost'][year] += Number(data['budgetCost'][ucID][year]);
                sumUCData['baselineOpCost'][year] += Number(data['baselineOpCost'][ucID][year]);
                sumUCData['netProjectCost'][year] += Number(data['netProjectCost'][ucID][year]);
                sumUCData['implem'][year] += Number(data['implem'][ucID][year]);
                sumUCData['opex'][year] += Number(data['opex'][ucID][year]);
                sumUCData['revenues'][year] += Number(data['revenues'][ucID][year]);
                sumUCData['capexAmort'][year] += Number(data['capexAmort'][ucID][year]);
                sumUCData['OBYI'][year] += Number(data['OBYI'][ucID][year]);
                sumUCData['OBCI'][year] += Number(data['OBCI'][ucID][year]);
                sumUCData['CRV'][year] += Number(data['CRV'][ucID][year]);
            });
        }
    }); 
    //console.log(sumUCData);

    // affichage: pour chaque année, afficher les résultats
    $('#budgetCost_current').html(currency+sumUCData['budgetCost']['current'].toLocaleString("en-EN"));
    $('#baselineOpCost_current').html(currency+sumUCData['baselineOpCost']['current'].toLocaleString("en-EN"));
    list_year.forEach(function(year) { //pour chaque année, on affiche chaque donnée
        $('#budgetCost_'+year).html(currency+sumUCData['budgetCost'][year].toLocaleString("en-EN"));
        $('#baselineOpCost_'+year).html(currency+sumUCData['baselineOpCost'][year].toLocaleString("en-EN"));
        $('#netProjectCost_'+year).html(currency+sumUCData['netProjectCost'][year].toLocaleString("en-EN"));
        $('#implem_'+year).html(currency+sumUCData['implem'][year].toLocaleString("en-EN"));
        $('#opex_'+year).html(currency+sumUCData['opex'][year].toLocaleString("en-EN"));
        $('#revenues_'+year).html(currency+sumUCData['revenues'][year].toLocaleString("en-EN"));
        $('#capexAmort_'+year).html(currency+sumUCData['capexAmort'][year].toLocaleString("en-EN"));
        $('#OBYI_'+year).html(currency+sumUCData['OBYI'][year].toLocaleString("en-EN"));
        $('#OBCI_'+year).html(currency+sumUCData['OBCI'][year].toLocaleString("en-EN"));
        $('#CRV_'+year).html(currency+sumUCData['CRV'][year].toLocaleString("en-EN"));
    });

    //  GRAPHIQUE
    var BOC = [];
    var NPC = [];
    var OBI = [];
    list_year.forEach(function(year) {
        BOC.push(sumUCData['baselineOpCost'][year]);
        NPC.push(sumUCData['netProjectCost'][year]);
        OBI.push(sumUCData['OBYI'][year]);
    });
    //console.log(BOC,NPC,OBI);

    window.budgetGraph = new Chart($('#budgetGraph'), {
        type: 'bar',
        data: {
            datasets: [{
                label: "Baseline Operating Cost",
                data: BOC,
                backgroundColor: '#A3A0FB',
                order: 3
            }, {
            label: "Net Project Cost",
            data: NPC,
            backgroundColor: '#5FE3A1',
            order: 2
        }, {
                label: "Operating Budget Impact",
                data: OBI,
                borderColor: '#2137B0',
                fill: false,
    
                // Changes this dataset to become a line
                type: 'line',
                order: 1
            }],
            labels: list_year
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
                    maxTicksLimit:7,
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
}

function budget2csv(idTable,projName,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var name = "output_Budget_"+projName;
    // pour chaque uc coché,rajouté le nom du uc
    list_uc.forEach(function(ucID) {
        var checkBox = $('#select_uc_'+ucID);
        var label = $("label[for='select_uc_"+ucID+"']").html();
        console.log(label);
        if (checkBox.prop("checked") == true) { 
            name += "_"+label;
        }
    } );
    //console.log(name);

    labels.push("Project");

    if(idTable == "budget_table"){
        $("#"+idTable+" thead tr").each(function(){
            $(this).children('th').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                labels.push(text);
            });
        });
        var i = 0;
        $("#"+idTable+" tbody tr").each(function(){
            if(i == 0){
                data.push([projName]);
            } else {
                data.push([""]);
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                data[i].push(text);
            });
            i++;
        });
    }
    console.log(labels);
    //console.log(data);
    download_csv(name,labels,data)
}

function destroygraph(){
    if( window.budgetGraph!==undefined) {
        window.budgetGraph.destroy();
    }
}


update_budget();