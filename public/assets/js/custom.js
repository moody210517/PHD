/**
Custom module for you to write your own javascript functions
**/
var Custom = function () {

    // private functions & variables

    var myFunc = function(text) {
        alert(text);
    }

    // public functions
    return {

        //main function
        init: function () {
            //initialize here something.            
        },

        //some helper function
        doSomeStuff: function () {
            myFunc();
        }
    };
}();


var refreshTable = function(tableId){        
    var rows = $(tableId).dataTable().fnGetNodes();
     for(var i=0;i<rows.length;i++)
     {
        $(rows[i]).css('background-color', 'white');
     }        
    // jQuery(this).closest("tr").css('background-color', 'gray');     
}

var refreshCall = function(sensor_id, allocation_id, id){

    var sId = sensor_id;
    var aId = allocation_id;
    var dId = id;
    
    var base_url = window.location.origin;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            type: 'POST',
            data: { sensor_id :sId,allocation_id:aId, id:dId},
            url: base_url + "/phd/api/getData",
            success: function(result) {     
                var res = result.results;
                if(res == 200){
                    if(result.data.auto_num != null && result.data.auto_num != ""){
                        id = result.data.auto_num;

                        if(sensor_id == "0"){

                            BUFFER_SPO2 = BUFFER_SPO2.concat(result.spo2);
                            BUFFER_OXYGEN = BUFFER_OXYGEN.concat(result.oxygen);
                            
                            if(periodicalGraph != null){
                                clearInterval(periodicalGraph);
                            }                                                
                            periodicalGraph = setInterval(function(){
                                if(allocation_id != "-1"){                       
                                    moveGraph(myChart);                        
                                }
                            },10000/result.spo2.length );

                        }else if(sensor_id == "1"){

                            BUFFER_SYSTOLIC = BUFFER_SYSTOLIC.concat(result.systolic);
                            BUFFER_DIASTOLIC = BUFFER_DIASTOLIC.concat(result.diastolic);
                            BUFFER_BLOOD_BPM = BUFFER_BLOOD_BPM.concat(result.blood_bpm);

                            if(periodicalGraph != null){
                                clearInterval(periodicalGraph);
                            }                                                
                            periodicalGraph = setInterval(function(){
                                if(allocation_id != "-1"){                       
                                    moveGraph(myChart);                        
                                }
                            },10000/result.systolic.length);

                            
                        }else if(sensor_id == "2"){

                        }
                        
                        

                    }                        
                }else{
                    //alert("Failed");
                }
            }             
        });
}


var id = "0";
var BUFFER_INITIAL1 = [];
var BUFFER_INITIAL2 = [];
var BUFFER_INITIAL3 = [];
var BUFFER_LABELS = [];

var BUFFER_SPO2 = [];
var BUFFER_OXYGEN = [];

var BUFFER_SYSTOLIC = [];
var BUFFER_DIASTOLIC = [];
var BUFFER_BLOOD_BPM = [];

var LENGTH = 100;
var startIndex = 0;
var width = 6;
var myChart;
var periodicalGraph;
var current_sensor_id = "";

var InitData = function(){  
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

    BUFFER_LABELS = [];
    BUFFER_INITIAL1 = [];
    BUFFER_INITIAL2 = [];
    BUFFER_INITIAL3 = [];
    for(i = 0 ; i < LENGTH; i++){
        BUFFER_LABELS = BUFFER_LABELS.concat(time); 
        BUFFER_INITIAL1 = BUFFER_INITIAL2.concat(0);                      
        BUFFER_INITIAL2 = BUFFER_INITIAL2.concat(0);
        BUFFER_INITIAL3 = BUFFER_INITIAL3.concat(0);            
    }   
}



var getRandomData = function(total) {
    var data = [];
    while (data.length < total) {
      var prev = data.length > 0 ? data[data.length - 1] : 50,
        y = prev + Math.random() * 10 - 5;
      if (y < 0) {
        y = 0;
      } else if (y > 100) {
        y = 100;
      }
      data.push(Math.round(y*100)/100);
    }

    return data;
  }

var testChart = function(){
    var data1 = [23,34,23, 23,34,-23,23,34,23,23,34,23, 23,34,23,23,34,23,23,34,23, 23,34,23,23,34,23, 23,34,-23,23,34,23,23,34,23, 23,34,23,23,34,23,23,34,23, 23,34,23,23,34,23];
    var data2 = [23,34,33];
    var data3 = [23,34,43];
    var data4 = [23,34,33];
    var data5 = [23,34,-23];
    var data6 = [23,-34,23];
    var data7 = [23,34,23];
    var data8 = [23,34,23];
    var data9 = [23,34,23];
    var data10 = [23,34,23];
    var data11 = [23,34,23];
    var data12 = [23,34,23];

    $('#chart-bar1').chartjs(
        {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'july', 'aug','sep','oct','nov', 'dec', 'Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'july', 'aug','sep','oct','nov', 'dec', 'Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'july', 'aug','sep','oct','nov', 'dec'], 
            datasets: [
                {
                    position:'top',
                    labels: 'Jan',
                    data: data1,
                    fill: true,
                    backgroundColor:[hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.danger, 1), hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1)],
                    borderColor: theme.color.success,
                    borderWidth: 1,
                    
                }

            ]
        },
        options: {
            legend: { 
               
                display: false 
            },
            scales: {
                display: true,
                ticks: {
                      beginAtZero: true
                },
                 
                xAxes: [{
                    barPercentage: 0.8,
                    categoryPercentage: 1,
                    scaleLabel: {
                        display: true,
                        labelString: ['[2001] , [2002] , [2003]']
                    }
                }]
               
            }
        }
        }
    );


    // $('#chart-bar1').chartjs(
    //     {
    //     type: 'bar',
    //     data: {
    //         labels: ['2005', '2006', '2007'], 
    //         datasets: [
    //             {
    //                 position:'top',
    //                 labels: 'Jan',
    //                 data: data1,
    //                 fill: true,
    //                 backgroundColor: [hexToRGB(theme.color.success, 1), hexToRGB(theme.color.success, 1),hexToRGB(theme.color.success, 1)] ,
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                    
    //             },
    //             {
    //                 position:'bottom',
    //                 label: 'Feb',
    //                 data: data2,
    //                 fill: true,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                    
                    
    //             },
    //             {
    //                 label: 'Apirl',
    //                 data: data3,
    //                 fill: true,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                    
                    
    //             },
    //             {
    //                 label: 'May',
    //                 data: data4,
    //                 fill: false,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                    
                    
    //             },
    //             {
    //                 label: 'June',
    //                 data: data5,
    //                 fill: false,
    //                 backgroundColor: [hexToRGB(theme.color.success, 1), hexToRGB(theme.color.success, 1), hexToRGB(theme.color.danger, 1)],
    //                 borderColor: [hexToRGB(theme.color.success, 1), hexToRGB(theme.color.success, 1), hexToRGB(theme.color.danger, 1)],
    //                 borderWidth: 1,
    //                 labelString: "dfdsf"
                    
                    
    //             },
    //             {
    //                 label: 'july',
    //                 data: data6,
    //                 fill: false,
    //                 backgroundColor: [hexToRGB(theme.color.success, 1), hexToRGB(theme.color.danger, 1), hexToRGB(theme.color.success, 1)],
    //                 borderColor:  [hexToRGB(theme.color.success, 1), hexToRGB(theme.color.danger, 1), hexToRGB(theme.color.success, 1)],
    //                 borderWidth: 1,
                                        
    //             },
    //             {
                    
    //                 data: data7,
    //                 fill: false,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                                        
    //             },
    //             {
                    
    //                 data: data8,
    //                 fill: false,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                                        
    //             },
    //             {
                    
    //                 data: data9,
    //                 fill: false,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                                        
    //             },
    //             {
                    
    //                 data: data10,
    //                 fill: false,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                                        
    //             },
    //             {
                    
    //                 data: data11,
    //                 fill: false,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                                        
    //             },
    //             {
                    
    //                 data: data12,
    //                 fill: false,
    //                 backgroundColor: hexToRGB(theme.color.success, 1),
    //                 borderColor: theme.color.success,
    //                 borderWidth: 1,
                                        
    //             }

    //         ]
    //     },
    //     options: {
    //         legend: { 
               
    //             display: false 
    //         },
    //         scales: {
    //             display: true,
    //             ticks: {
    //                   beginAtZero: true
    //             },
                 
    //             xAxes: [{
    //                 barPercentage: 0.8,
    //                 categoryPercentage: 1,
    //                 scaleLabel: {
    //                     display: true,
    //                     labelString: ['SPO2']
    //                 }
    //             }]
               
    //         }
    //     }
    //     }
    // );
}

var customChat = function(sensor_id, allocation_id){    
    current_sensor_id = sensor_id;
    if(allocation_id == -1){
        $("#complete").hide();
        $("#allocate").show();
    }else{
        $("#complete").show();
        $("#allocate").hide();
    }        
    try {        
        InitData();
        var ctx = document.getElementById("chartline");
        myChart = new Chart(ctx, {            
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
                        display: true
                    }
                }

        });    
    }catch(error){

    }    
    refreshCall(sensor_id, allocation_id, id);
    setInterval(function(){
        sensor_id = $("#sensor_id").val();
        allocation_id = $("#allocation_id").val();
        if(allocation_id != "-1"){
            refreshCall(sensor_id, allocation_id, id);
        }            
    },10000);

    // if(periodicalGraph != null){
    //     clearInterval(periodicalGraph);
    // }
    // periodicalGraph = setInterval(function(){
    //     if(allocation_id != "-1"){                       
    //         moveGraph(myChart);                        
    //     }            
    // },300);   
}


var addData = function(chart, label, data){
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
   // chart.update();
}

var moveGraph = function(chart){
 
    
    var sensor_id = $("#sensor_id").val();        
    if(sensor_id == "0"){
       
        if(current_sensor_id != sensor_id){
            current_sensor_id = sensor_id;
            startIndex = 0;
            chart.data.datasets.forEach(function(dataset, index) {                            
                dataset.data.splice(0, LENGTH - 1); // remove first data point
            });  
            InitData();        
            updateConfigAsOxygen(chart);                   
        }                        
        if(BUFFER_SPO2.length > startIndex && BUFFER_OXYGEN.length > startIndex){

            var spo2 =  BUFFER_SPO2[startIndex];
            var oxygen =  BUFFER_OXYGEN[startIndex];
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
            startIndex = startIndex + 1;

        }
        
    }else if(sensor_id == "1"){
        if(current_sensor_id != sensor_id){
            current_sensor_id = sensor_id;         
            startIndex = 0;            
            chart.data.datasets.forEach(function(dataset, index) {                            
                dataset.data.splice(0, LENGTH - 1); // remove first data point
            });                   
            InitData(); 
            updateConfigAsBlood(chart);                     
        }
        
        if(BUFFER_SYSTOLIC.length > startIndex && BUFFER_DIASTOLIC.length > startIndex && BUFFER_BLOOD_BPM.length > startIndex){

            var systolic =  BUFFER_SYSTOLIC[startIndex];
            var diastolic =  BUFFER_DIASTOLIC[startIndex];
            var blood_bpm =  BUFFER_BLOOD_BPM[startIndex];
               
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
            startIndex = startIndex + 1;
            
        }        
    }else{

    }       
    
    // remove part
    // chart.data.labels.pop();
    // chart.data.datasets.forEach((dataset) => {
    //     dataset.data.pop();
    // });
    // chart.update();
}


var updateConfigAsOxygen  = function(chart) {
    chart.options = {
        responsive: true,
        title: {
            display: true,
            text: 'Oxygen'
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
                    name:"Spo2",
                    ticks: {
                    min: 30,
                    max: 140,
                    stepSize: 10
                    },                     
                    scaleLabel: {
                        display: true,
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
            display: true
        }
    };    
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


var updateConfigAsBlood = function(chart) {
    chart.options = {
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
            display: true
        }
    };

    chart.data = {
        labels: BUFFER_LABELS,
        datasets: [
            {
                yAxisID:"A",
                label: 'Systolic',
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
                label: 'Diastolic',
                data:BUFFER_INITIAL2,
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
                data:BUFFER_INITIAL3,
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

var updateConfigAsGSR = function(chart) {
    chart.options = {
        responsive: true,
        title: {
            display: true,
            text: 'Chart.js'
        },
        scales: {
            xAxes: [{
                display: true
            }],
            yAxes: [{
                display: true
            }]
        },
        legend: {
            display: true
        }
    };
    chart.update();
}

var initGraph = function(chart) {

    chart.options = {
        responsive: false,
        title: {
            display: false,
            text: 'Init'
        },
        scales: {
            xAxes: [{
                display: false
            }],
            yAxes: [{
                display: false
            }]
        },
        legend: {
            display: false
        }
    };
    chart.update();
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
      data: { patient_id:patient_id, device_id:device_id, id:user_id, company_id:company_id , allocation_name:allocation_name},
      url: base_url + "/phd/api/allocatePatient",
      success: function(result) {     
            var res = result.results;
            if(res == 200){                                        
                $('#allocation_id').val(result.id);
                startIndex = 0;
                $("#complete").show();
                $("#allocate").hide();

            }else{
                alert("Failed");
            }
      }             
    });
}

var complete = function (){
    var allocation_id = $("#allocation_id").val();           
    var base_url = window.location.origin;           
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
      type: 'POST',
      data: { allocation_id:allocation_id},
      url: base_url + "/phd/api/completeAllocation",
      success: function(result) {     
            var res = result.results;
            if(res == 200){
                //alert("ok");                                  
                $("#allocation_id").val("-1");       
                $("#allocation_name").val("");
                startIndex = 0;              
                $("#complete").hide();
                $("#allocate").show();
                BUFFER_SPO2 = [];
                BUFFER_OXYGEN = [];
                BUFFER_SYSTOLIC = [];
                BUFFER_DIASTOLIC = [];
                BUFFER_BLOOD_BPM = [];
                
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