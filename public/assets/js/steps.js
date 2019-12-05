/**
Custom module for you to write your own javascript functions
**/
var initStep = function(){    
    var step_id = $("#step_id").val();
    STEP = step_id;
    document.getElementById('step_title').innerHTML = STEPS[step_id];
    document.getElementById('step_description').innerHTML = DES[step_id];
    var patient_name = $('#patient_id option:selected').text();
    var device_name = $('#device_id option:selected').text();
    document.getElementById('page_title').innerHTML = patient_name + " - " + device_name;
    if(step_id == "0"){
        $("#abort").hide();  
    }else{
        $("#abort").show();  
    }    
    initButtons(PAGE_STATUS, STEP);    
    initStatusIcons();

    //init chart part

    //$('.myCheckbox').prop('checked', true);
    //initChartShow();
}

var onNext = function(index){
    STEP = index;
    PAGE_STATUS = 0;
    document.getElementById('step_title').innerHTML = STEPS[index];
    document.getElementById('step_description').innerHTML = DES[index];
    var patient_name = $('#patient_name').val(); // $('#patient_id option:selected').text();
    var device_name = $('#device_id option:selected').text();
    document.getElementById('page_title').innerHTML = patient_name + " - " + device_name;

    updateStep(index);
    initButtons(PAGE_STATUS, STEP);
    initChartShow();

    InitData();
    updateConfigAsOxygen(chartOxygen);
    updateConfigAsBlood(chartBlood);
    updateConfigAsGSR(chartGSR);
    
}


var onPrevious = function(index){
    document.getElementById('step_title').innerHTML = STEPS[index];
}

var start = function(){
    PAGE_STATUS = 1;
    initButtons(PAGE_STATUS, STEP);    
}
var stop = function (){
    PAGE_STATUS = 2;
    initButtons(PAGE_STATUS, STEP);    
    clearData();
}

var resetAllocation = function (){      
    allocation_id = $("#allocation_id").val();    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
      type: 'POST',
      data: { allocation_id:allocation_id, step_id:STEP},
      url: base_url + "api/resetAllocation",
      success: function(result) {     
            var res = result.results;
            if(res == 200){  
                PAGE_STATUS = 0;
                initButtons(PAGE_STATUS, STEP); 
            }else{
                alert("Failed");
            }
      }             
    });
}

var updateStep = function (stepV){         

    var patient_id = $("#patient_id").val();
    var device_id = $("#device_id").val();
    var user_id = $("#user_id").val();
    var company_id = $("#company_id").val();
    var visit_form_id = $("#visit_form_id").val();
    var diabet_risk_id = $("#diabet_risk_id").val();

    var base_url = window.location.origin;    
    var allocation_name = user_id + patient_id + device_id + "";
    var stepValue = Math.abs(stepV).toString(16);// step.toString();
    
    var oxymeter = $('#oxymeter').is(':checked');
    var blood = $('#blood').is(':checked');
    var gsr = $('#gsr').is(':checked');
    
    oxymeter_val = oxymeter == true ? "1" : "0";
    blood_val = blood == true ? "2" : "0";
    gsr_val = gsr == true ? "3" : "0";

    allocation_id = $("#allocation_id").val();
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
      type: 'POST',
      data: { patient_id:patient_id, device_id:device_id, 
        id:user_id, company_id:company_id , allocation_name:allocation_name ,stepValue:stepValue 
        , allocation_id:allocation_id, oxymeter:oxymeter_val, blood:blood_val, gsr:gsr_val , visit_form_id:visit_form_id, diabet_risk_id:diabet_risk_id},
      url: base_url + "/phd/api/updateStep",
      success: function(result) {     
            var res = result.results;
            if(res == 200){ 

                var id = result.id;
                $("#allocation_id").val(id);        
                clearData();                
                $("#abort").show();   
                initButtons(PAGE_STATUS, STEP);    

            }else{
                alert("Failed");
            }
      }             
    });
}


var ID_OXYGEN = "0";
var ID_BLOOD = "0";
var ID_GSR = "0";

var BUFFER_INITIAL1 = [];
var BUFFER_INITIAL2 = [];
var BUFFER_INITIAL3 = [];
var BUFFER_INITIAL4 = [];
var BUFFER_INITIAL5 = [];
var BUFFER_INITIAL6 = [];

var BUFFER_LABELS = [];

var BUFFER_SPO2 = [];
var BUFFER_OXYGEN = [];

var BUFFER_SYSTOLIC = [];
var BUFFER_DIASTOLIC = [];
var BUFFER_BLOOD_BPM = [];
var BUFFER_GSR = [];

var LENGTH = 20;
var START_INDEX_OXYGEN = 0;
var START_INDEX_BLOOD = 0;
var START_INDEX_GSR = 0;

var PAGE_STATUS = 0;
var STEP = 1;
var base_url = window.location.origin;    

var InitData = function(){  
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

    BUFFER_LABELS = [];
    BUFFER_INITIAL1 = [];
    BUFFER_INITIAL2 = [];
    BUFFER_INITIAL3 = [];
    BUFFER_INITIAL4 = [];
    BUFFER_INITIAL5 = [];
    BUFFER_INITIAL6 = [];

    for(i = 0 ; i < LENGTH; i++){
        time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds() + i;
        BUFFER_LABELS = BUFFER_LABELS.concat(time); 
        BUFFER_INITIAL1 = BUFFER_INITIAL1.concat(0);                      
        BUFFER_INITIAL2 = BUFFER_INITIAL2.concat(0);
        BUFFER_INITIAL3 = BUFFER_INITIAL3.concat(0);            
        BUFFER_INITIAL4 = BUFFER_INITIAL4.concat(0);            
        BUFFER_INITIAL5 = BUFFER_INITIAL5.concat(0);            
        BUFFER_INITIAL6 = BUFFER_INITIAL6.concat(0);            
    }   
}

var clearData = function(){        
    BUFFER_SPO2 = [];
    BUFFER_OXYGEN = [];
    BUFFER_SYSTOLIC = [];
    BUFFER_DIASTOLIC = [];
    BUFFER_BLOOD_BPM = [];
    BUFFER_GSR = [];

    START_INDEX_OXYGEN = 0;
    START_INDEX_BLOOD = 0;
    START_INDEX_GSR = 0;
    initStatusIcons();
}

var refreshCall = function(){    
    allocation_id = $("#allocation_id").val();
    if(allocation_id != "-1" && PAGE_STATUS == 1){                     
        var base_url = window.location.origin;
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            type: 'POST',
            data: { allocation_id:allocation_id, id_oxygen:ID_OXYGEN, id_blood:ID_BLOOD,id_gsr:ID_GSR},
            url: base_url + "/phd/api/getAllSensorData",
            success: function(result) {     
                var res = result.results;
                if(res == 200){

                    if(result.id_oxygen != null && result.id_blood != ""){
                                                
                        BUFFER_SPO2 = BUFFER_SPO2.concat(result.spo2);
                        BUFFER_OXYGEN = BUFFER_OXYGEN.concat(result.oxygen);
                        BUFFER_SYSTOLIC = BUFFER_SYSTOLIC.concat(result.systolic);
                        BUFFER_DIASTOLIC = BUFFER_DIASTOLIC.concat(result.diastolic);
                        BUFFER_BLOOD_BPM = BUFFER_BLOOD_BPM.concat(result.blood_bpm);
                        BUFFER_GSR = BUFFER_GSR.concat(result.gsr);
                        
                        ID_OXYGEN = result.id_oxygen;
                        ID_BLOOD = result.id_blood;
                        ID_GSR = result.id_gsr;

                        // update pluse oxymeteer graph
                        if(periodOxygen != null){
                            clearInterval(periodOxygen);
                        }                                          
                        if(BUFFER_SPO2.length > 0){
                            periodOxygen = setInterval(function(){
                                if(allocation_id != "-1" && chartOxygen != null){                       
                                    moveGraph(chartOxygen, "0");  
                                }
                            },10000/(BUFFER_SPO2.length - START_INDEX_OXYGEN) );                            
                        }
                        
                                                
                        // update blood graph
                        if(periodBlood != null){
                            clearInterval(periodBlood);
                        }                                   
                        if(BUFFER_SYSTOLIC.length > 0){
                            periodBlood = setInterval(function(){
                                if(allocation_id != "-1" && chartBlood != null){                       
                                    moveGraph(chartBlood, "1");                        
                                }
                            },10000/(BUFFER_SYSTOLIC.length - START_INDEX_BLOOD));
                        }
                        
                        // update gsr graph
                        if(periodGSR != null){
                            clearInterval(periodGSR);
                        }                                  
                        if(BUFFER_GSR.length > 0){
                            periodGSR = setInterval(function(){
                                if(allocation_id != "-1" && chartGSR != null){                       
                                    moveGraph(chartGSR, "2");                        
                                }
                            },40000/result.gsr.length);        
                        }

                        initStatusIcons();
                    }                        
                }else{
                    //alert("Failed");
                }
            }             
        });            
    }
}

var chartOxygen;
var chartBlood;
var chartGSR;

var periodOxygen;
var periodBlood;
var periodGSR;

var width = 6;
var current_sensor_id = "";

var initChart = function(){    

    try {        
        InitData();
        var ctx = document.getElementById("chart_oxygen");
        chartOxygen = new Chart(ctx, {            
                type: 'line',
                data: {
                    labels: BUFFER_LABELS,
                    datasets: [
                        {
                            yAxisID:"A",
                            label: 'Spo2',
                            data:BUFFER_INITIAL1,
                            fill: true,                        
                            backgroundColor: getGradient(theme.color.primary, 140),
                            hoverBackgroundColor: theme.color.primary,
                            pointRadius: 3,
                            tension: 0.35,
                            borderColor: theme.color.success,
                            pointBorderColor: '#fff',//'#fff''transparent'
                            pointBackgroundColor: theme.color.primary,//theme.color.primary 'transparent'
                            borderWidth: 2
                        },
                        {
                            yAxisID:"B",
                            label: 'Oxygen',
                            data:BUFFER_INITIAL2,
                            fill: false,
                            borderDash: [5,5],
                            pointRadius: 2,
                            tension: 0.35,
                            borderColor: [hexToRGB(theme.color.primary, 0.2)],
                            pointBorderColor: '#fff',
                            pointBackgroundColor: [hexToRGB(theme.color.primary, 0.2)],
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Pulse Oximeter'
                    },
                    scales: {
                        xAxes:[
                        {
                            display: true
                        }
                        ],
                        yAxes:[
                            {
                                id: 'A',
                                position:"left",
                                display: true,
                                name:"Spo2",
                                ticks: {
                                min: 30,
                                max: 140,
                                stepSize: 10
                                },                     
                                scaleLabel: {
                                    display: true,
                                    position:'top',
                                    labelString: 'SPO2'
                                }
                            },
                            {
                                id: 'B',
                                position:"right",
                                display: true,
                                ticks: {
                                min: 0,
                                max: 100, // percentage
                                stepSize: 20
                                },                     
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Oxygen'
                                }
                            }
                        ]
                    },
                    legend: {
                        display: false
                    }
                }

        });    


        // init blood
        var ctx2 = document.getElementById("chart_blood");
        chartBlood = new Chart(ctx2, {            
                type: 'line',
                data: {
                    labels: BUFFER_LABELS,
                    datasets: [
                        {
                            yAxisID:"A",
                            label: 'Systolic',
                            data:BUFFER_INITIAL3,
                            fill: true,                        
                            backgroundColor: getGradient(theme.color.primary, 140),
                            hoverBackgroundColor: theme.color.primary,
                            pointRadius: 3,
                            tension: 0.35,
                            borderColor: theme.color.success,
                            pointBorderColor: '#fff',//'#fff''transparent'
                            pointBackgroundColor: theme.color.primary,//theme.color.primary 'transparent'
                            borderWidth: 2
                        },
                        {
                            yAxisID:"B",
                            label: 'Diastolic',
                            data:BUFFER_INITIAL4,
                            fill: false,
                            borderDash: [5,5],
                            pointRadius: 2,
                            tension: 0.35,
                            borderColor: [hexToRGB(theme.color.danger, 0.2)],
                            pointBorderColor: '#fff',
                            pointBackgroundColor: [hexToRGB(theme.color.primary, 0.2)],
                            borderWidth: 2
                        },
                        {
                            yAxisID:"C",
                            label: 'Bpm Values',
                            data:BUFFER_INITIAL5,
                            fill: false,
                            borderDash: [5,5],
                            pointRadius: 2,
                            tension: 0.35,
                            borderColor: [hexToRGB(theme.color.warning, 0.2)],
                            pointBorderColor: '#fff',
                            pointBackgroundColor: [hexToRGB(theme.color.primary, 0.2)],
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Blood Pressure'
                    },
                    scales: {
                        xAxes: [{
                            display: true
                        }],
                        yAxes:[
                            {
                                id: 'A',
                                position:"left",
                                display: true,
                                name:"sys",
                                ticks: {
                                min: 0,
                                max: 140,
                                stepSize: 10
                                },                     
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Blood Pressure'
                                }
                            },
                            {
                                id: 'B',
                                position:"left",
                                display: false,
                                ticks: {
                                min: 0,
                                max: 100, // percentage
                                stepSize: 20
                                },                     
                                scaleLabel: {
                                    display: false,
                                    labelString: 'Diastolic'
                                }
                            },
                            {
                                id: 'C',
                                position:"right",
                                display: true,
                                ticks: {
                                min: 0,
                                max: 100, // percentage
                                stepSize: 20
                                },                     
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Heart Rate'
                                }
                            }
                        ]
                    },
                    legend: {
                        display: false
                    }
                }

        });  

        // init gsr
        var gsr = document.getElementById("chart_gsr");
        chartGSR = new Chart(gsr, {            
                type: 'line',
                data: {
                    labels: BUFFER_LABELS,
                    datasets: [
                        {
                            yAxisID:"A",
                            label: 'GSR',
                            data:BUFFER_INITIAL6,
                            fill: true,                        
                            backgroundColor: getGradient(theme.color.primary, 140),
                            hoverBackgroundColor: theme.color.primary,
                            pointRadius: 3,
                            tension: 0.35,
                            borderColor: theme.color.success,
                            pointBorderColor: '#fff',//'#fff''transparent'
                            pointBackgroundColor: theme.color.primary,//theme.color.primary 'transparent'
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'GSR Sensor'
                    },
                    scales: {
                        xAxes:[
                        {
                            display: true
                        }
                        ],
                        yAxes:[
                            {
                                id: 'A',
                                position:"left",
                                display: true,
                                name:"GSR",
                                ticks: {
                                min: 0,
                                max: 500,
                                stepSize: 50
                                },                     
                                scaleLabel: {
                                    display: true,
                                    labelString: 'BPM Value'
                                }
                            }
                        ]
                    },
                    legend: {
                        display: false
                    }
                }

        });  

    }catch(error){

    }    


    refreshCall();
    setInterval(function(){
        refreshCall();
        
    },5000);

}



var addData = function(chart, label, data){
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
   // chart.update();
}

var moveGraph = function(chart, sensor_id){     

    if(PAGE_STATUS == 1){
        if(sensor_id == "0"){                              
            if(BUFFER_SPO2.length > START_INDEX_OXYGEN && BUFFER_OXYGEN.length > START_INDEX_OXYGEN){
                var spo2 =  BUFFER_SPO2[START_INDEX_OXYGEN];
                var oxygen =  BUFFER_OXYGEN[START_INDEX_OXYGEN];
                var yAxes = chart.options.scales.yAxes;        
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var dateTime = date+' '+time;    
            
                chart.data.labels.push(time); // add new label at end
                chart.data.labels.splice(0, 1); // remove first label
            
                chart.data.datasets.forEach(function(dataset, index) {       
                    //myChart.data.datasets[0].data.splice(0, 1);
                    if(dataset.yAxisID == 'A'){
                        dataset.data.push( spo2 ); // add new data at end Math.floor(Math.random() * 10)
                    }else{
                        dataset.data.push( oxygen ); // add new data at end Math.floor(Math.random() * 10)
                    }        
                    dataset.data.splice(0, 1); // remove first data point
                });
            
                chart.update();
                START_INDEX_OXYGEN = START_INDEX_OXYGEN + 1;
            }
            
        }else if(sensor_id == "1"){                
            if(BUFFER_SYSTOLIC.length > START_INDEX_BLOOD && BUFFER_DIASTOLIC.length > START_INDEX_BLOOD && BUFFER_BLOOD_BPM.length > START_INDEX_BLOOD){
    
                var systolic =  BUFFER_SYSTOLIC[START_INDEX_BLOOD];
                var diastolic =  BUFFER_DIASTOLIC[START_INDEX_BLOOD];
                var blood_bpm =  BUFFER_BLOOD_BPM[START_INDEX_BLOOD];
                   
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    
                chart.data.labels.push(time); // add new label at end
                chart.data.labels.splice(0, 1); // remove first label
            
                chart.data.datasets.forEach(function(dataset, index) {       
                    //myChart.data.datasets[0].data.splice(0, 1);
                    if(dataset.yAxisID == 'A'){
                        dataset.data.push( systolic ); // add new data at end Math.floor(Math.random() * 10)
                    }else if(dataset.yAxisID == 'B'){
                        dataset.data.push( diastolic ); // add new data at end Math.floor(Math.random() * 10)
                    }else{
                        dataset.data.push( blood_bpm ); // add new data at end Math.floor(Math.random() * 10)
                    }
                    dataset.data.splice(0, 1); // remove first data point
                });
                chart.update();
                START_INDEX_BLOOD = START_INDEX_BLOOD + 1;
            }        
        }else{    
            if(BUFFER_GSR.length > START_INDEX_GSR){    
                var gsr =  BUFFER_GSR[START_INDEX_GSR];                           
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    
                chart.data.labels.push(time); // add new label at end
                chart.data.labels.splice(0, 1); // remove first label
            
                chart.data.datasets.forEach(function(dataset, index) {       
                    //myChart.data.datasets[0].data.splice(0, 1);
                    if(dataset.yAxisID == 'A'){
                        dataset.data.push( gsr ); // add new data at end Math.floor(Math.random() * 10)
                    }
                    dataset.data.splice(0, 1); // remove first data point
                });
                chart.update();
                START_INDEX_GSR = START_INDEX_GSR + 1;
            }    
        }
    }else{
        clearData();
    }        

}


var updateConfigAsOxygen  = function(chart) {
    // chart.options = {
    //     responsive: true,
    //     title: {
    //         display: true,
    //         text: 'Oxygen'
    //     },
    //     scales: {
    //         xAxes: [{
    //             display: true
    //         }],
    //         yAxes:[
    //             {
    //                 id: 'A',
    //                 position:"left",
    //                 display: true,
    //                 name:"Spo2",
    //                 ticks: {
    //                 min: 30,
    //                 max: 140,
    //                 stepSize: 10
    //                 },                     
    //                 scaleLabel: {
    //                     display: true,
    //                     labelString: 'SPO2'
    //                 }
    //             },
    //             {
    //                 id: 'B',
    //                 position:"right",
    //                 display: true,
    //                 ticks: {
    //                 min: 0,
    //                 max: 100, // percentage
    //                 stepSize: 20
    //                 },                     
    //                 scaleLabel: {
    //                     display: true,
    //                     labelString: 'Oxygen'
    //                 }
    //             }
    //         ]
    //     },
    //     legend: {
    //         display: true
    //     }
    // };    

    if(chart != null){
        chart.data = {
            labels: BUFFER_LABELS,
            datasets: [
                {
                    yAxisID:"A",
                    label: 'Spo2',
                    data:BUFFER_INITIAL1,
                    fill: true,                        
                    backgroundColor: getGradient(theme.color.primary, 140),
                    hoverBackgroundColor: theme.color.primary,
                    pointRadius: 3,
                    tension: 0.35,
                    borderColor: theme.color.success,
                    pointBorderColor: '#fff',//'#fff''transparent'
                    pointBackgroundColor: theme.color.primary,//theme.color.primary 'transparent'
                    borderWidth: 2
                },
                {
                    yAxisID:"B",
                    label: 'Oxygen',
                    data:BUFFER_INITIAL2,
                    fill: false,
                    borderDash: [5,5],
                    pointRadius: 2,
                    tension: 0.35,
                    borderColor: [hexToRGB(theme.color.primary, 0.2)],
                    pointBorderColor: '#fff',
                    pointBackgroundColor: [hexToRGB(theme.color.primary, 0.2)],
                    borderWidth: 2
                }
            ]
        };
        chart.update();
    }
    
}


var updateConfigAsBlood = function(chart) {
   
    if(chart != null){
        chart.data = {
            labels: BUFFER_LABELS,
            datasets: [
                {
                    yAxisID:"A",
                    label: 'Systolic',
                    data:BUFFER_INITIAL3,
                    fill: true,                        
                    backgroundColor: getGradient(theme.color.primary, 140),
                    hoverBackgroundColor: theme.color.primary,
                    pointRadius: 3,
                    tension: 0.35,
                    borderColor: theme.color.success,
                    pointBorderColor: '#fff',//'#fff''transparent'
                    pointBackgroundColor: theme.color.primary,//theme.color.primary 'transparent'
                    borderWidth: 2
                },
                {
                    yAxisID:"B",
                    label: 'Diastolic',
                    data:BUFFER_INITIAL4,
                    fill: false,
                    borderDash: [5,5],
                    pointRadius: 2,
                    tension: 0.35,
                    borderColor: [hexToRGB(theme.color.danger, 0.2)],
                    pointBorderColor: '#fff',
                    pointBackgroundColor: [hexToRGB(theme.color.primary, 0.2)],
                    borderWidth: 2
                },
                {
                    yAxisID:"C",
                    label: 'Bpm Values',
                    data:BUFFER_INITIAL5,
                    fill: false,
                    borderDash: [5,5],
                    pointRadius: 2,
                    tension: 0.35,
                    borderColor: [hexToRGB(theme.color.warning, 0.2)],
                    pointBorderColor: '#fff',
                    pointBackgroundColor: [hexToRGB(theme.color.primary, 0.2)],
                    borderWidth: 2
                }
            ]
        };
    
        chart.update();
    }    

}

var updateConfigAsGSR = function(chart) {

    if(chart != null){

        chart.data = {
            labels: BUFFER_LABELS,
            datasets: [
                {
                    yAxisID:"A",
                    label: 'GSR',
                    data:BUFFER_INITIAL6,
                    fill: true,                        
                    backgroundColor: getGradient(theme.color.primary, 140),
                    hoverBackgroundColor: theme.color.primary,
                    pointRadius: 3,
                    tension: 0.35,
                    borderColor: theme.color.success,
                    pointBorderColor: '#fff',//'#fff''transparent'
                    pointBackgroundColor: theme.color.primary,//theme.color.primary 'transparent'
                    borderWidth: 2
                }
            ]
        };
        chart.update();

    }
    
    
}


var getGradient = function(color, height){
    var ctx = $('<canvas/>').get(0).getContext("2d");
    var gradient = ctx.createLinearGradient(0, 0, 0, height);
    gradient.addColorStop(0, hexToRGB(color, 0.35));
    gradient.addColorStop(1, hexToRGB(color, 0));
    return gradient;
}

var allocate = function (){
    //var allocation_name = $("#allocation_name").val();
    var allocation_name = document.getElementById("allocation_name").value;
        
    var patient_id = $("#patient_id").val();
    var device_id = $("#device_id").val();
    var user_id = $("#user_id").val();
    var company_id = $("#company_id").val();
    var visit_form_id = $("#visit_form_id").val();
    var base_url = window.location.origin;           
    var toke =  $('meta[name="csrf-token"]').attr('content');    
    allocation_name = user_id + patient_id + device_id + "";


    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
      type: 'POST',
      data: { patient_id:patient_id, device_id:device_id, id:user_id, company_id:company_id , allocation_name:allocation_name, visit_form_id:visit_form_id},
      url: base_url + "/phd/api/allocatePatient",
      success: function(result) {     
            var res = result.results;
            if(res == 200){                
                $('#allocation_id').val(result.id);            
                $("#abort").show();
                $("#allocate").hide();
            }else{
                alert("Failed");
            }
      }             
    });
}

var completeStep = function (status){
    var allocation_id = $("#allocation_id").val();   
            
    var base_url = window.location.origin;           
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    
    $.ajax({
      type: 'POST',
      data: { allocation_id:allocation_id, status:status},
      url: base_url + "/phd/api/completeAllocation",      
      success: function(result) {
            var res = result.results;
            if(res == 200){

                if(status == '2'){
                    //var patient_id = $("#patient_id").val();
                    window.location.href = "testland";// + patient_id;
                }else{
                    var patient_id = $("#patient_id").val();
                    //window.location.href = "review/" + allocation_id;
                    //alert("http://" + window.location.host + "/phd/report/review/" + allocation_id);
                    window.location.href ="http://" +  window.location.host + "/phd/report/review/" + allocation_id;                    
                }
                
                //alert("ok");                                  
                $("#allocation_id").val("-1");     
                $("#step_id").val("0");       
                $("#allocation_name").val("");                
                $("#abort").hide();
                $("#allocate").show();

                BUFFER_SPO2 = [];
                BUFFER_OXYGEN = [];
                BUFFER_SYSTOLIC = [];
                BUFFER_DIASTOLIC = [];
                BUFFER_BLOOD_BPM = [];
                BUFFER_GSR = [];                
                initStep();

                //location.reload();
               
            }else{
                alert("Failed");
            }
      }
         
    });
}



var deleteData = function (deleteId, link){
        var id = deleteId;
        //var base_url = window.location.origin;  
        var CSRF_TOKEN =  $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });    
        $.ajax({
          type: 'POST',
          data: {id:id},
          url: link,
          success: function(result) {     
                var res = result.results;
                if(res == 200){
                    location.reload();
                    //window.location = link;
                }else{
                    alert("Failed");
                }
          }
        });      
}


var editData = function (elementId, deleteId, link){
    $(elementId).click(function(){    
        var id = deleteId;    
        var CSRF_TOKEN =  $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });    
        $.ajax({
          type: 'POST',
          data: {id:id},
          url: link,
          success: function(result) {     
                var res = result.results;
                if(res == 200){
                    location.reload();
                }else{
                    alert("Failed");
                }
          }             
        });
    });       
}




/***
Usage
***/
//Custom.init();
//Custom.doSomeStuff();