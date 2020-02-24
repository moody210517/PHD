/**
Custom module for you to write your own javascript functions
**/


var updateStepNew = function (stepV){     
        
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

                if(stepV == 1){
                    callPeriodically();
                    var id = result.id;
                    $("#allocation_id").val(id);
                    $("#aid").val(id);
                }else{
                    var id = result.id;
                    $("#allocation_id").val(id);
                    //clearData();                
                    $("#abort").show();   
                    //initButtons(PAGE_STATUS, STEP);    
                }
            }else{
                alert("Failed");
            }
      }
    });
}

var hideAllDiv = function(){
    $("#div_step1").hide();
    $("#div_step2").hide();
    $("#div_step3").hide();
    $("#div_step4").hide();
    $("#div_step5").hide();
    $("#div_step6").hide();
    $("#div_step7").hide();
}

var callPeriodically = function(){
    var intervalID = setInterval(function(){        
            var allocation_id = $("#allocation_id").val();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
            type: 'POST',
            data: {allocation_id:allocation_id},
            url: base_url + "api/checkStep",
            success: function(result) {
                    var res = result.results;
                    if(res == 200){
                        //alert("ok");
                        var step_id = result.step_id;
                        if(step_id == "8"){
                            //window.location.href ="http://" +  window.location.host + "/phd/report/note/" + allocation_id;
                            window.location.href ="http://" +  window.location.host + "/phd/report/review/" + allocation_id;                    
                        }
                                                
                        hideAllDiv();
                        $("#img_loading").show();
                        $("#step_id").val(step_id);                                                                   
                        if(step_id == "1"){       
                            //Data Results for Step 1 - Calibration                     
                            $('#step_title').text('Receiving Data for Step 1 - Calibration');                               
                        }else if(step_id == "2"){
                            //Data Results for Step 2 - Baseline
                            $('#step_title').text('Receiving Data for Step 2 - Baseline');                               
                        }else if(step_id == "3"){
                            //Data Results for Step 3 - Baseline - Feet
                            $('#step_title').text('Receiving Data for Step 3 - Baseline - Feet');                            
                        }else if(step_id == "4"){
                            //Data Results for Step 4 - Valsalva Maneuver
                            $('#step_title').text('Receiving Data for Step 4 - Valsalva Maneuver');
                        }else if(step_id == "5"){
                            //Data Results for Step 5 - Deep Breathing
                            $('#step_title').text('Receiving Data for Step 5 - Deep Breathing');
                        }else if(step_id == "6"){
                            //Data Results for Step 6 - Standing Up
                            $('#step_title').text('Receiving Data for Step 6 - Standing Up');
                        }else if(step_id == "7"){
                            //Data Results for Step 7 - Blood Pressure - Gripping
                            $('#step_title').text('Receiving Data for Step 7 - Blood Pressure - Gripping');                            
                        }

                    }else if(res == 300){
                        var step_id = result.step_id;
                        $("#img_loading").hide();
                        hideAllDiv();

                        if(step_id == "1"){                             
                            $('#step_title').text('Data Results for Step 1 - Calibration');                              
                            $("#div_step1").show();
                            showStep1Data(result);
                        }else if(step_id == "2"){                            
                            $('#step_title').text('Data Results for Step 2 - Baseline');
                            $("#div_step1").show();
                            cleanStep1Data();
                            showStep1Data(result);
                        }else if(step_id == "3"){                            
                            $('#step_title').text('Data Results for Step 3 - Baseline - Feet');
                            $("#div_step3").show();
                            $("#step3_us").val(result.us);

                        }else if(step_id == "4"){                            
                            $('#step_title').text('Data Results for Step 4 - Valsalva Maneuver');
                            $("#div_step1").show();
                            cleanStep1Data();
                            showStep1Data(result);
                            $("#div_gsr").hide();
                        }else if(step_id == "5"){                            
                            $('#step_title').text('Data Results for Step 5 - Deep Breathing');
                            $("#div_step1").show();
                            cleanStep1Data();
                            showStep1Data(result);
                            $("#div_gsr").hide();
                        }else if(step_id == "6"){                            
                            $('#step_title').text('Data Results for Step 6 - Standing Up');
                            $("#div_step1").show();
                            cleanStep1Data();
                            showStep1Data(result);
                            $("#div_gsr").hide();

                        }else if(step_id == "7"){                        
                            $('#step_title').text('Data Results for Step 7 - Blood Pressure - Gripping');
                            $("#div_step1").show();
                            cleanStep1Data();
                            showStep1Data(result);
                            $("#div_gsr").hide();
                            $("#div_pluse").hide();
                            $("#div_pul").hide();

                        }else if(step_id == "8"){
                        
                            //window.location.href ="http://" +  window.location.host + "/phd/report/note/" + allocation_id;
                            window.location.href ="http://" +  window.location.host + "/phd/report/review/" + allocation_id;                    
                        }

                    }else if(res == 400){
                        $("#img_loading").hide();
                        $("#alert_modal").modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        //$("#alert_modal").modal();                        
                    }else{
                        alert("Failed");
                    }
            }
            });
    }, 5000);    

}

var cleanStep1Data = function(){
    $("#o2").val("");
    $("#hrv").val("");
    $("#us").val("");
    $("#sys").val("");
    $("#dia").val("");
    $("#pul").val(""); 
}
var showStep1Data = function(result){
    $("#o2").val(result.o2);
    $("#hrv").val(result.hrv);
    $("#us").val(result.us);
    $("#sys").val(result.sys);
    $("#dia").val(result.dia);
    $("#pul").val(result.pul);     
}

var initTypeIITable = function(page) {

    // $tbody.append('<tr> <td rowspan="6" width="20%" class="no_border"> ' + 
    // '<div class="">' +
    // '<label class="col-form-label report_sub_title"> <h6 class="mb-0">Type II Risk</h6> </label>' + 
    // '<div class="row" >' +
    //     '<div class="form-control text-center no-border pt-3 pb-3 canvas_container_overall">	' +
    //         '<div id="preview">' +
    //             '<img width="100%" height="100%" id="image-typeii" ></canvas>'+
    //         '</div>'+                
    //         '<div id="preview-textfield11" class="reset" style="display:none;">1</div>' + 
    //         '<div class="reset"> {{ $diabet_risk_score }} </div>'+
    //         '<div  class="status {{$diabet_risk_color}}">{{$diabet_risk_name}}</div>'+
    //     '</div>'+
    // '</div>'+
    // '</div>'+
    // +' </td>  <td  class="no_border" >Beginning Value</td> <td  class="no_border" >Ending Value</td> <td  class="no_border" >Risk Percentage</td> <td  class="no_border">Risk Assessment</td> </tr>');                                

    if(page == 1){ // type ii 
        $tbody = $('#type-table').find('tbody');    
        $tbody.empty();										       
        $tbody.append('<tr> <td  class="no_border" >0</td> <td  class="no_border" >3</td> <td  class="no_border" >12%</td> <td  class="no_border">Very Low</td> </tr>');
        $tbody.append('<tr><td  class="no_border">3</td> <td class="no_border">8</td> <td class="no_border">19%</td> <td class="no_border">Low</td> </tr>');
        $tbody.append('<tr><td  class="no_border">8</td> <td class="no_border">12</td> <td class="no_border">15%</td> <td class="no_border">Moderate</td> </tr>');
        $tbody.append('<tr><td class="no_border">12</td> <td class="no_border">20</td> <td class="no_border">31%</td> <td class="no_border">High</td> </tr>');
        $tbody.append('<tr><td class="no_border">20</td> <td class="no_border">26</td> <td class="no_border">23%</td> <td class="no_border">Very High</td> </tr>');
        $tbody.append('<tr><td class="no_border"></td> <td class="no_border"></td> <td class="no_border"></td> <td class="no_border"></td> </tr>');
    }else if(page == 2){  // blood 
        $tbody = $('#blood-table').find('tbody');    
        $tbody.empty();
        $tbody.append('<tr><td class="no_border">0</td> <td class="no_border">7</td> <td class="no_border">23%</td> <td class="no_border">Very Low</td> </tr>');
        $tbody.append('<tr><td class="no_border">7</td> <td class="no_border">15</td> <td class="no_border">27%</td> <td class="no_border">Moderate</td> </tr>');
        $tbody.append('<tr><td class="no_border">15</td> <td class="no_border">23</td> <td class="no_border">27%</td> <td class="no_border">High</td> </tr>');
        $tbody.append('<tr><td class="no_border">23</td> <td class="no_border">30</td> <td class="no_border">23%</td> <td class="no_border">Very High</td> </tr>');        
    }else if(page == 3) { // para
        $tbody = $('#para-table').find('tbody');    
        $tbody.empty();
        $tbody.append('<tr><td  class="no_border">0</td> <td class="no_border">1</td> <td class="no_border">33%</td> <td class="no_border">Low</td> </tr>');
        $tbody.append('<tr><td class="no_border">1</td> <td class="no_border">2</td> <td class="no_border">33%</td> <td class="no_border">Moderate</td> </tr>');
        $tbody.append('<tr><td class="no_border">2</td> <td class="no_border">3</td> <td class="no_border">33%</td> <td class="no_border">High</td> </tr>');
        
    }else if(page == 4){ //gsr
        $tbody = $('#gsr-table').find('tbody');    
        $tbody.empty();
        $tbody.append('<tr><td class="no_border">0</td> <td class="no_border">1</td> <td class="no_border">25%</td> <td class="no_border">Very Low</td> </tr>');
        $tbody.append('<tr><td class="no_border">1</td> <td class="no_border">2</td> <td class="no_border">25%</td> <td class="no_border">Moderate</td> </tr>');
        $tbody.append('<tr><td class="no_border">2</td> <td class="no_border">3</td> <td class="no_border">50%</td> <td class="no_border">High</td> </tr>');
    }else if(page == 5){ // ans
        $tbody = $('#ans-table').find('tbody');    
        $tbody.empty();
        $tbody.append('<tr><td class="no_border">0</td> <td class="no_border">5</td> <td class="no_border">28%</td> <td class="no_border">Very Low</td> </tr>');
        $tbody.append('<tr><td class="no_border">5</td> <td class="no_border">9</td> <td class="no_border">22%</td> <td class="no_border">Moderate</td> </tr>');
        $tbody.append('<tr><td class="no_border">9</td> <td class="no_border">14</td> <td class="no_border">28%</td> <td class="no_border">High</td> </tr>');
        $tbody.append('<tr><td class="no_border">14</td> <td class="no_border">18</td> <td class="no_border">22%</td> <td class="no_border">Very High</td> </tr>');
    } else if (page == 6){ // adr        
        $tbody = $('#adr-table').find('tbody');    
        $tbody.empty();
        $tbody.append('<tr><td class="no_border">0</td> <td class="no_border">7</td> <td class="no_border">23%</td> <td class="no_border">Very Low</td> </tr>');
        $tbody.append('<tr><td class="no_border">7</td> <td class="no_border">15</td> <td class="no_border">27%</td> <td class="no_border">Moderate</td> </tr>');
        $tbody.append('<tr><td class="no_border">15</td> <td class="no_border">23</td> <td class="no_border">27%</td> <td class="no_border">High</td> </tr>');
        $tbody.append('<tr><td class="no_border">23</td> <td class="no_border">30</td> <td class="no_border">23%</td> <td class="no_border">Very High</td> </tr>');
    }else if(page == 7){ // cardiac
        $tbody = $('#card-table').find('tbody');    
        $tbody.empty();
        $tbody.append('<tr><td class="no_border">0</td> <td class="no_border">4</td> <td class="no_border">22%</td> <td class="no_border">Very Low</td> </tr>');
        $tbody.append('<tr><td class="no_border">4</td> <td class="no_border">9</td> <td class="no_border">28%</td> <td class="no_border">Moderate</td> </tr>');
        $tbody.append('<tr><td class="no_border">9</td> <td class="no_border">13</td> <td class="no_border">22%</td> <td class="no_border">High</td> </tr>');
        $tbody.append('<tr><td class="no_border">13</td> <td class="no_border">18</td> <td class="no_border">28%</td> <td class="no_border">Very High</td> </tr>');
    }
    
}

var initTypeIIRiskTable = function(answer) {
    $tbody = $('#type-risk-table').find('tbody');
    $tbody.empty();
    $tbody.append('<tr><td>Age</td> <td  width="15%" style="text-align: center;" >' + answer.age[0] + '</td> <td style="text-align: center;" > +' + answer.age[1] + '</td> </tr>');
    $tbody.append('<tr><td>History of high blood glucose</td> <td style="text-align: center;" >' + answer.glucose[0] + '</td> <td style="text-align: center;" > +' + answer.glucose[1] + '</td> </tr>');
    $tbody.append('<tr><td>BMI</td> <td style="text-align: center;" >' + answer.bmi[0] + '</td> <td style="text-align: center;" > +' + answer.bmi[1] + '</td> </tr>');
    $tbody.append('<tr><td>Daily consumption of vegetables, fruits, or berries</td> <td style="text-align: center;" >' + answer.vegetable[0] + '</td> <td style="text-align: center;" > +' + answer.vegetable[1] + '</td> </tr>');
    $tbody.append('<tr><td>Waist (in) </td> <td style="text-align: center;" >' + answer.waist[0] + '</td> <td style="text-align: center;" > +' + answer.waist[1] + '</td> </tr>');
    $tbody.append('<tr><td>Family history of diabetes </td> <td style="text-align: center;" >' + answer.family[0] + '</td> <td style="text-align: center;" > +' + answer.family[1] + '</td> </tr>');
    $tbody.append('<tr><td>Use of blood pressure medication </td> <td style="text-align: center;" >' + answer.bpmeds[0] + '</td> <td style="text-align: center;" > +' + answer.bpmeds[1] + '</td> </tr>');
    $tbody.append('<tr><td>Physical Activity (hours/week) </td> <td style="text-align: center;" > <' + (parseInt(answer.activity[0]) + 1) + '</td> <td style="text-align: center;" > +' + answer.activity[1] + '</td> </tr>');
    $tbody.append('<tr><td colspan="2" > <b>Total Number of Points </b> </td> <td class="last_column"> <span class="' + answer.risk_color + '"><b>' + answer.total + '</b></span></td> </tr>');
    $tbody.append('<tr><td colspan="2"> <b>Risk Level</b> </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + answer.risk_color + '"><b>' + answer.title + '</b></span></td> </tr>');
    $tbody.append('<tr><td colspan="2"> <b>10-year risk of developing Type 2 Diabets </b> </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + answer.risk_color + '"><b>' + answer.year_risk + '</b></span></td> </tr>');
}


var initSkinTables = function(result, index) {
    
    if(index == 1){
        $tbody = $('#gsr1-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> microSeimens (µS) </td> <td class="last_column"> <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Lisk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');        
    }else if(index == 2){
        $tbody = $('#gsr2-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> microSeimens (µS) </td> <td class="last_column"> <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Lisk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');
    }
}

var initAdrTables = function(result, index){
    if(index == 1){
        $tbody = $('#adr1-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Systolic Pressure – Baseline</td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 2){
        $tbody = $('#adr2-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Diastolic Pressure – Baseline </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 3){
        $tbody = $('#adr3-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Systolic Pressure – Standing </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 4){
        $tbody = $('#adr4-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Diastolic Pressure – Standing </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 5){
        $tbody = $('#adr5-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Blood Pressure Valsalva Response </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 6){
        $tbody = $('#adr6-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Systolic Pressure – Standing Response </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 7){
        $tbody = $('#adr7-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Diastolic Pressure – Standing Response </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }
}

var initCardTables = function(result, index){
    if(index == 1){
        $tbody = $('#card1-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> RR Interval – Baseline </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 2){
        $tbody = $('#card2-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Valsalva Ratio </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 3){
        $tbody = $('#card3-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> K30 / 15 </td> <td class="last_column" > <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 4){
        $tbody = $('#card4-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Systolic Pressure – Standing Response </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 5){
        $tbody = $('#card5-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Diastolic Pressure – Standing Response </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 6){
        $tbody = $('#card6-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Blood Pressure Response to Sustained Hand Grip </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }
}


var initAnsTables = function(result, index){
    if(index == 1){
        $tbody = $('#ans1-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Beats Per Minute </td> <td class="last_column"> <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');        
    }else if(index == 2){

        $tbody = $('#ans2-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Standard Deviation RR Interval </td> <td class="last_column"> <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');        
    }else if(index == 3){
        $tbody = $('#ans3-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Root Mean Square – Successive Difference (RMSSD) </td> <td class="last_column"> <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');        
    }else if(index == 4){
        $tbody = $('#ans4-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> RR Interval – Baseline > 670 ms </td> <td class="last_column"> <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');        
    }else if(index == 5){
        $tbody = $('#ans5-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> pNN50 – Baseline </td> <td class="last_column"> <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');        
    }else if(index == 6){
        $tbody = $('#ans6-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Pulse Oximeter - Baseline </td> <td class="last_column" > <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');        
    }
}


var initParaTables = function(result, index) {
    
    if(index == 1){
        $tbody = $('#para1-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Valsalva Ratio >=1.25 </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 2){

        $tbody = $('#para2-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> K30 / 15 >= 1.13 </td> <td class="last_column" > <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }else if(index == 3){
        $tbody = $('#para3-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> E / I Ratio >= 1.20 </td> <td class="last_column" > <span class="' + result[3] + '"><b>' + result[4] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');        
    }
}

var initBloodTables = function(result, index) {
    
    if(index == 1){
        $tbody = $('#blood-baseline-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Systolic Pressure <= 140 mmHg </td> <td class="last_column"> <span class="' + result[6] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Diastolic Pressure <= 90 mmHg </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[7] + '"><b>' + result[2] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');
    }else if(index == 2){

        $tbody = $('#blood-standing-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Systolic Pressure <= 119 mmHg </td> <td class="last_column"> <span class="' + result[6] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Diastolic Pressure <= 75 mmHg </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[7] + '"><b>' + result[2] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');

    }else if(index == 3){
        $tbody = $('#blood-standing-res-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td colspan="5"> Systolic Pressure <= 10 mmHg </td> <td class="last_column"> <span class="' + result[6] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td colspan="5"> Diastolic Pressure <= 5 mmHg </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[7] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Systolic Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="'
         + result[4] + '"><b>' + result[8] + '</b></span></td>     '+ 
         '<td> Diastolic Score </td>'+
         '<td bgcolor="#a6a6a6" style="text-align: center;"> <span class="' + result[4]+ '"> ' + result[9]+' </span></td>'+
         '<td> Total Score </td>'+
         '<td bgcolor="#a6a6a6" style="text-align: center;"> <span class="' + result[4] + '"> ' + result[2] + ' </span> </td>'+
         +' </tr>');
        $tbody.append('<tr><td colspan="5"> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');

    }else if(index == 4){
        $tbody = $('#blood-valsa-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Systolic Pressure <= 140 mmHg </td> <td class="last_column"> <span class="' + result[6] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Diastolic Pressure <= 90 mmHg </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[7] + '"><b>' + result[2] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[4] + '"><b>' + result[3] + '</b></span></td> </tr>');
    }else if(index == 5){
        $tbody = $('#blood-valsa-res-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Systolic Pressure Response to Valsalva (SPRV) >= -40 mmHg </td> <td class="last_column"> <span class="' + result[3] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[3] + '"><b>' + result[2] + '</b></span></td> </tr>');
    }else if(index == 6){
        $tbody = $('#blood-para-table').find('tbody');
        $tbody.empty();
        $tbody.append('<tr><td> Valsalva Ratio >=1.25 </td> <td class="last_column"> <span class="' + result[4] + '"><b>' + result[0] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> K30 / 15 >= 1.13 </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[5] + '"><b>' + result[1] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> E / I Ratio >= 1.20 </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[6] + '"><b>' + result[2] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Score </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[8] + '"><b>' + result[3] + '</b></span></td> </tr>');
        $tbody.append('<tr><td> Risk Level </td> <td bgcolor="#a6a6a6" style="text-align: center;" >  <span class="' + result[8] + '"><b>' + result[7] + '</b></span></td> </tr>');
    }
}


/***
Usage
***/
//Custom.init();
//Custom.doSomeStuff();