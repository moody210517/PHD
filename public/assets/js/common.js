/**
Custom module for you to write your own javascript functions
**/

var STEPS = ["Patient Test Step 1 : Select Patient and select PHD Device"
            , "Patient Test Step 2 : Calibrate PHD"
            , "Patient Test Step 3 : Test Patient at Rest"
            , "Patient Test Step 4 : Test Patient after Valsalva Maneuver"
            , "Patient Test Step 5 : Test Patient after Deep Breathing"
            , "Patient Test Step 6 : Test Pateint after Standing up"
            , "Completed",
        ];

var DES = [
    "Step 1 - please select the patient and PHD device you are about to use",
    "Step 2 - please hook up all sensors to patient and begin sending data.  Click Start when the PHD device shows it is sending data successfully. Click Stop when all sensor tests have passed. Create task"  ,
    "Step 3 - Collecting patient data while patient is relaxed.  Please make sure patient is relaxed and sitting comfortably.  Click Start when the PHD device shows it is sending data successfully.  Allow test to complete for 3 minutes before clicking Stop.  The test will stop by itself after 5 minutes.",
    "Step 4 - Collecting patient data after patient performs Valsalva Maneuver.  Please make sure patient has successfully performed the Valsalva Maneuver.  Click Start when the PHD device shows it is sending data successfully.  Allow test to complete for 3 minutes before clicking Stop.  The test will stop by itself after 5 minutes.",
    "Step 5 - Collecting patient data after patient performs deep breathing exercise.  Please make sure patient has successfully perform 5 second deep breaths three times.  Click Start when the PHD device shows it is sending data successfully.  Allow test to complete for 3 minutes before clicking Stop.  The test will stop by itself after 5 minutes.",
    "Step 6 - Collecting patient data after patient stands up.  Please have patient stand up while connected to all sensors.  Click Start when the PHD device shows it is sending data successfully.  Allow test to complete for 3 minutes before clicking Stop.  The test will stop by itself after 5 minutes.",
    "Step 7 - Collecting patient data while patient is gripping a small object. Please have patient grip a small object tightly creating a flexed muscle sensation. Click Start when the PHD device shows it is sending data successfully. Allow test to complete for 3 minutes before clicking Stop. The test will stop by itself after 5 minutes."
];

var ICON_STATUS = [
    "i-con i-con-ok bg-fail w-16 b-2x",
    "i-con i-con-ok bg-success w-16 b-2x"
];

var BUTTON_START = [
    "btn w-sm mb-1 btn-rounded btn-outline-info disabled",
    "btn w-sm mb-1 btn-rounded btn-outline-info"
];
var BUTTON_STOP = [
    "btn w-sm mb-1 btn-rounded btn-outline-danger disabled",
    "btn w-sm mb-1 btn-rounded btn-outline-danger"
];
var BUTTON_RESET = [
    "btn w-sm mb-1 btn-rounded btn-outline-warning disabled",
    "btn w-sm mb-1 btn-rounded btn-outline-warning"
];

var BUTTON_NEXT = [
    "btn btn-white button-next i-con-h-a disabled",
    "btn btn-white button-next i-con-h-a"
];

var DIV_CHART = [
    "col-xl-4 col-lg-12 col-md-12",
    "col-xl-6 col-lg-12 col-md-12",
    "col-xl-12 col-lg-12 col-md-12"
];

var initButtons = function(PAGE_STATUS, STEP){

    if(STEP == 0){        
        return;
    }
    if(STEP == 6){
        document.getElementById("btn_next").innerHTML = "Finish";        
    }else if(STEP == 7){
        document.getElementById("btn_next").innerHTML = "";   
    }

    //if(BUFFER_SPO2.length == 0 && BUFFER_OXYGEN.length == 0 && BUFFER_SYSTOLIC.length == 0 && BUFFER_DIASTOLIC.length == 0 && BUFFER_BLOOD_BPM.length == 0 && BUFFER_GSR.length == 0){
    if(PAGE_STATUS == 0){
        document.getElementById("btn_start").className = BUTTON_START[1];
        document.getElementById("btn_stop").className = BUTTON_STOP[0];
        document.getElementById("btn_reset").className = BUTTON_RESET[0];
        document.getElementById("btn_start").disabled = false;
        document.getElementById("btn_stop").disabled = true;
        document.getElementById("btn_reset").disabled = true;                
        // $('.button-next').prop('disabled', true);
        // $("#btn_next").off('click');
        // $("#btn_next").disabled = true;
        document.getElementById("btn_next").className = BUTTON_NEXT[0];
    }else if(PAGE_STATUS == 1){

        //element.className.replace
        document.getElementById("btn_start").className = BUTTON_START[0];
        document.getElementById("btn_stop").className = BUTTON_STOP[1];
        document.getElementById("btn_reset").className = BUTTON_RESET[0];
        // $("#btn_start").addClass(BUTTON_START[0]);
        // $("#btn_stop").addClass(BUTTON_STOP[1]);
        // $("#btn_reset").addClass(BUTTON_RESET[0]);
        document.getElementById("btn_start").disabled = true;
        document.getElementById("btn_stop").disabled = false;
        document.getElementById("btn_reset").disabled = true;        
        document.getElementById("btn_next").className = BUTTON_NEXT[0];
    }else{
        
        document.getElementById("btn_start").className = BUTTON_START[0];
        document.getElementById("btn_stop").className = BUTTON_STOP[0];
        document.getElementById("btn_reset").className = BUTTON_RESET[1];

        document.getElementById("btn_start").disabled = true;
        document.getElementById("btn_stop").disabled = true;
        document.getElementById("btn_reset").disabled = false;            
        document.getElementById("btn_next").className = BUTTON_NEXT[1];        
    }
}

var initStatusIcons = function(){
    if(BUFFER_SPO2.length == 0 && BUFFER_OXYGEN.length == 0){
        document.getElementById("status_oximeter").className = ICON_STATUS[0];
    }else{
        document.getElementById("status_oximeter").className = ICON_STATUS[1];
    }

    if( BUFFER_SYSTOLIC.length == 0 && BUFFER_DIASTOLIC.length == 0 && BUFFER_BLOOD_BPM.length == 0 ){
        document.getElementById("status_blood").className =  ICON_STATUS[0];
    }else{
        document.getElementById("status_blood").className =  ICON_STATUS[1];
    }
    
    if(BUFFER_GSR.length == 0){                      
        document.getElementById("status_gsr").className =  ICON_STATUS[0];
    }else{
        document.getElementById("status_gsr").className =  ICON_STATUS[1];
    }  
}

var initChartShow = function(){
    var oxymeter = $('#oxymeter').is(':checked');
    var blood = $('#blood').is(':checked');
    var gsr = $('#gsr').is(':checked');

    var tmp = 0;
    if(oxymeter){
        tmp++;        
    }
    if(blood){
        tmp++;
    }
    if(gsr){
        tmp++;
    }
    
    if(oxymeter){
        $('#div_chart_oxygen').hide();
    }else{
        $('#div_chart_oxygen').show();
    }

    if(blood){
        $('#div_chart_blood').hide();
    }else{
        $('#div_chart_blood').show();
    }

    if(gsr){
        $('#div_chart_gsr').hide();
    }else{
        $('#div_chart_gsr').show();
    }

    if(tmp == 1){
        document.getElementById("div_chart_oxygen").className = DIV_CHART[1];
        document.getElementById("div_chart_blood").className = DIV_CHART[1];
    }else if(tmp == 2){
        document.getElementById("div_chart_oxygen").className = DIV_CHART[2];
        document.getElementById("div_chart_blood").className = DIV_CHART[2];
        document.getElementById("div_chart_gsr").className = DIV_CHART[2];
    }

}

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




/***
Usage
***/
//Custom.init();
//Custom.doSomeStuff();