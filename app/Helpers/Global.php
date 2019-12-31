<?php

    use App\Blood;
    use App\Oximeter;

    function test($number){               
        return $number * 3;
    }

    function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }


   
    function getLevelBood($allocation_id, $step){                      
        //$allocation_id = 139;
        $blood = Blood::where('allocation_id', $allocation_id)
        ->where('step_id', $step)
        ->get();           
        $n = 0; $sys = 0; $dia = 0; $bpm = 0;
        $max_tmp = 0; $min_tmp = 0; $max = 0; $min = 0;
        foreach($blood as $item){            
            $value  = json_decode($item["raw_data"], true);
            foreach($value as $v){                      
                $sys = $sys + $v["systolic"];
                $dia = $dia + $v["diastolic"];
                $bpm = $bpm + $v["bpm"];
                
                if($n == 0){
                    $min_tmp = $v["bpm"];
                }

                if($max_tmp < $v["bpm"]){
                    $max_tmp = $v["bpm"];
                }
                if($min_tmp > $v["bpm"]){
                    $min_tmp = $v["bpm"];
                }
                $n++;
            }
        }

        $avg_systolic = 0; $avg_diastolic = 0; $avg_bpm = 0;
        if($n != 0){
            $avg_systolic = $sys/$n;
            $avg_diastolic = $dia/$n;
            $avg_bpm = $bpm/$n;
        }
        $overview_score = 0;
        $score_color = "green-color";

        if($avg_systolic > 120 && $avg_systolic <= 130 && $avg_diastolic < 80){
            $overview_score = $overview_score + 1;
            $score_color = "green-color";
        }else if( ($avg_systolic > 130 && $avg_systolic < 139) || ($avg_diastolic > 80 && $avg_diastolic < 89) ){
            $overview_score = $overview_score + 3;
            $score_color = "yellow-color";
        }else if( ($avg_systolic > 140 && $avg_systolic < 179) || ($avg_diastolic > 90 && $avg_diastolic < 119) ){
            $overview_score = $overview_score + 4;
            $score_color = "orange-color";
        }else if($avg_systolic >= 180 || $avg_diastolic >= 120){
            $overview_score = $overview_score + 5;
            $score_color = "red-color";
        }
        return [$overview_score, $avg_systolic, $avg_diastolic, $avg_bpm, $min_tmp, $max_tmp, $score_color];
    }



    function getLevelBoodValsa($allocation_id, $step){                      
        //$allocation_id = 139;
        $blood = Blood::where('allocation_id', $allocation_id)
        ->where('step_id', $step)
        ->get();           
        $n = 0; $sys = 0; $dia = 0; $bpm = 0;
        $max_tmp = 0; $min_tmp = 0; $max = 0; $min = 0;
        foreach($blood as $item){            
            $value  = json_decode($item["raw_data"], true);
            foreach($value as $v){                      
                $sys = $sys + $v["systolic"];
                $dia = $dia + $v["diastolic"];
                $bpm = $bpm + $v["bpm"];
                
                if($n == 0){
                    $min_tmp = $v["bpm"];
                }

                if($max_tmp < $v["bpm"]){
                    $max_tmp = $v["bpm"];
                }
                if($min_tmp > $v["bpm"]){
                    $min_tmp = $v["bpm"];
                }
                $n++;
            }
        }

        $avg_systolic = 0; $avg_diastolic = 0; $avg_bpm = 0;
        if($n != 0){
            $avg_systolic = $sys/$n;
            $avg_diastolic = $dia/$n;
            $avg_bpm = $bpm/$n;
        }
        $overview_score = 0; $score_percentage =0;
        $score_color = "green-color";
        if($avg_systolic > 160 && $avg_systolic < 169 && $avg_diastolic < 120){
            $overview_score = $overview_score + 1;
            $score_percentage = 20;
            $score_color = "green-color";
        }else if( ($avg_systolic > 170 && $avg_systolic < 179) || ($avg_diastolic > 120 && $avg_diastolic < 129) ){
            $overview_score = $overview_score + 3;
            $score_color = "yellow-color";
            $score_percentage = 40;
        }else if( ($avg_systolic > 180 && $avg_systolic < 219) || ($avg_diastolic > 130 && $avg_diastolic < 159) ){
            $overview_score = $overview_score + 4;
            $score_color = "orange-color";
            $score_percentage = 60;
        }else if($avg_systolic >= 220 || $avg_diastolic >= 160){
            $overview_score = $overview_score + 5;
            $score_color = "red-color";
            $score_percentage = 100;
        }
        return [$overview_score, $avg_systolic, $avg_diastolic, $avg_bpm, $min_tmp, $max_tmp, $score_color, $score_percentage];
    }

    
    function getRR($allocation_id, $step){
        
        //$allocation_id = 139;        
        $pluse_oximeter = Oximeter::where('allocation_id', $allocation_id)
        ->where('step_id', $step)
        ->get();
       
        $n = 0;$SPO2bpm =0;$OxygenSat = 0; 
        $RR = []; $RR_Total = 0; $countMoreThan50 = 0;
        $index = 0;
        foreach($pluse_oximeter as $item){
            $value  = json_decode($item["raw_data"], true);
                        
            foreach($value as $v){
                
                $SPO2bpm = $SPO2bpm + $v["SPO2bpm"];
                $OxygenSat = $SPO2bpm + $v["OxygenSat"];
                $RR_TimeStamp = $v["RR"];
                $RRT = $RR_TimeStamp;//json_decode($RR_TimeStamp);
                $tmp = 0;
                $tmp2 = 0;

                foreach($RRT as $vv){
                    if($tmp == 0){
                        $tmp = $vv;
                        $RR_Total += $vv;
                    }else{
                        $RR[] = $vv - $tmp;
                        $RR_Total += $vv;// - $tmp;

                        if(abs($vv - $tmp ) > 50){
                            $countMoreThan50 += abs($vv - $tmp );
                            $index ++;
                        }

                        $tmp = $vv;
                    }                    
                }
                $n++;
            }
        }

        $avg_spo2bpm = 0;
        $avg_oxygensat = 0;
        $avg_rr = 0;
        $percentMoreThan50 = 0;
        if($n != 0){
            $avg_spo2bpm = $SPO2bpm/$n;
            $avg_oxygensat = $OxygenSat/$n;
        }        
        if(count($RR) > 0){
            $avg_rr = $RR_Total / count($RR);
            $percentMoreThan50 = $countMoreThan50  / $index;
        }
        
        return [$avg_spo2bpm, $avg_oxygensat, $avg_rr, $percentMoreThan50,  $RR];
    }

    function getLongShortRR($RR){

        $max = 0; $min = 0;
        if(count($RR) > 0){
            $min = $RR[0];
        }
        foreach($RR as $value){
            if($max < $value){
                $max = $value;
            }
            if($min > $value){
                $min = $value;
            }
        }
        return [$max, $min];        
    }

    function getValsaTitleColor($score){
        $risk = 0;
        if($score == 0){
            $risk = 0;
            $risk_title = "Low";  
            $risk_color = "green-color";            
        }else if($score == 1){
            $risk = 100;
            $risk_title = "High";  
            $risk_color = "yellow-color";            
        }
        return [$risk , $risk_title, $risk_color];
    }

    
    function getParaTitleColor($score, $type){
        
        $risk = 0;
        if($type == "overall"){
            if($score == 0 || $score == 1){
                if($score == 0){
                    $risk = 0;
                }else{
                    $risk = 25;
                }                
                $risk_title = "Low";  
                $risk_color = "green-color";            
            }else if($score == 2){
                $risk = 50;
                $risk_title = "Medium";  
                $risk_color = "yellow-color";            
            }else if($score == 3 ){
                $risk = 100;
                $risk_title = "High";  
                $risk_color = "red-color";            
            }
        }else{
            if($score == 0){
                $risk = 0;
                $risk_title = "Low";  
                $risk_color = "green-color";            
            }else if($score == 1){
                $risk = 100;
                $risk_title = "High";  
                $risk_color = "yellow-color";            
            }

        }
        return [$risk , $risk_title, $risk_color];

    }


    function getSkinTitleColor( $score , $type){
        $risk = 0;
        if($type == "overall"){
            if($score == 0 || $score == 1){
                if($score == 0){
                    $risk = 0;
                }else{
                    $risk = 25;
                }                
                $risk_title = "Very Low";  
                $risk_color = "green-color";            
            }else if($score == 2){
                $risk = 50;
                $risk_title = "Moderate";  
                $risk_color = "yellow-color";            
            }else if($score == 3 || $score == 4){
                $risk = 100;
                $risk_title = "High";  
                $risk_color = "red-color";            
            }
        }else{
            if($score == 0){
                $risk = 50;
                $risk_title = "Normal";  
                $risk_color = "green-color";            
            }else if($score == 1){
                $risk = 100;
                $risk_title = "Above Normal";  
                $risk_color = "yellow-color";            
            }else if($score == 2){
                $risk = 0;
                $risk_title = "Below Normal";  
                $risk_color = "orange-color";            
            }
        }        

        return [$risk , $risk_title, $risk_color];

    }




    function getRiskAndTitleColor($measure, $val1, $val2 , $val3 , $val4, $val5 = 0, $per1, $per2, $per3, $per4, $per5){
        

        $risk = 0;
        $risk_title = "Low"; $risk_color = "green-color";
        if($measure <= $val1){
            $risk = ($per1 / $val1) * $measure; 
            $risk_title = "Very Low";            
            $risk_color = "green-color";                    
        }
        if($measure > $val1 && $measure <= $val2){
            
            $risk = $per1 + ($per2 / ($val2 - $val1) ) * ($measure - $val1);
            
            $risk_title = "Low";
            if($val3 == 0){
                $risk_title = "High";
                $risk_color = "red-color";
                return [$risk , $risk_title, $risk_color];
            }else{
                if($val4 == 0){
                    $risk_title = "Moderate";
                    $risk_color = "yellow-color";
                }else{
                    if($val5 == 0){
                        $risk_color = "yellow-color";
                    }else{
                        $risk_color = "green-color";
                    }
                }   
            }
                   
        }
        if($measure > $val2 && $measure <= $val3){
            $risk = $per1 + $per2 + ($per3 / ($val3 - $val2)) * ($measure - $val2);
            $risk_title = "Moderate";
            if($val4 == 0){
                $risk_title = "High";
                $risk_color = "red-color";
            }else{
                if($val5 == 0){
                    $risk_color = "orange-color";
                }else{
                    $risk_color = "yellow-color";
                }            
            }            
        }
        if($measure > $val3 && $measure <= $val4){
            $risk = $per1 + $per2 + $per3 + ( $per4 / ($val4 - $val3) ) * ($measure - $val3);
            $risk_title = "High";
            if($val5 == 0){
                $risk_color = "red-color";
            }else{
                $risk_color = "orange-color";
            }            
        }

        if($val5 != 0 && $per5 != 0){
            if($measure > $val4 && $measure <= $val5){
                $risk = $per1 + $per2 + $per3 + $per4 + ( $per5 / ($val5-$val4)) * ($measure - $val4);
                $risk_title = "Very high";
                $risk_color = "red-color";
            }
        }    
        return [$risk , $risk_title, $risk_color]; // percent, title, color
    }


    
?>