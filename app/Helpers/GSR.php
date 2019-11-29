<?php

    use App\GSR;
    use App\Oximeter;

    

    function getAgeScore($age){
        $age_score = 0;
        if($age >=  45  && $age <= 54){
            $age_score = 2;
        }else if($age >=  55  && $age <= 64){
            $age_score = 3;
        }else if($age > 64){
            $age_score = 4;
        }
        return $age_score;
    }

    function getSPRS_DPRS_Score($SPRS, $DPRS){
        $StandingResponseScore = 0;
        if($SPRS >= 10 && $SPRS < 20){            
            $StandingResponseScore += 2;
        }else if($SPRS >= 20 && $SPRS < 30){            
            $StandingResponseScore += 3;
        }else if($SPRS >= 30){            
            $StandingResponseScore += 4;
        }

        if($DPRS >= 5 && $DPRS < 10){            
            $StandingResponseScore += 2;
        }else if($DPRS >= 10 && $DPRS < 20){            
            $StandingResponseScore += 3;
        }else if($DPRS >= 20){            
            $StandingResponseScore += 4;
        }    

        return $StandingResponseScore;
    }

    function getFemaleHandScore($age, $GSR){
        $Female_Hand_Score = 0;
        if($age > 21 && $age <= 30){
            if($GSR < 65.1){
                $Female_Hand_Score = 2;
            }else if($GSR >= 65.1 && $GSR <= 84.3){
                $Female_Hand_Score = 0;
            }else if($GSR > 84.3){
                $Female_Hand_Score = 1;
            }
        }else if($age > 30 && $age <= 40){
            if($GSR < 67.1){
                $Female_Hand_Score = 2;
            }else if($GSR >= 67.1 && $GSR <= 84.7){
                $Female_Hand_Score = 0;
            }else if($GSR > 84.7){
                $Female_Hand_Score = 1;
            }
        }else if($age > 40 && $age <= 50){
            if($GSR < 65.6){
                $Female_Hand_Score = 2;
            }else if($GSR >= 65.6 && $GSR <= 82.4){
                $Female_Hand_Score = 0;
            }else if($GSR > 82.4){
                $Female_Hand_Score = 1;
            }
        }else if($age > 50 && $age <= 60){
            if($GSR < 65.5){
                $Female_Hand_Score = 2;
            }else if($GSR >= 65.5 && $GSR <= 82.1){
                $Female_Hand_Score = 0;
            }else if($GSR > 82.1){
                $Female_Hand_Score = 1;
            }
        }else if($age > 60 && $age <= 70){
            if($GSR < 61){
                $Female_Hand_Score = 2;
            }else if($GSR >= 61 && $GSR <= 81.2){
                $Female_Hand_Score = 0;
            }else if($GSR > 81.2){
                $Female_Hand_Score = 1;
            }
        }else if($age > 71){
            if($GSR < 61.4){
                $Female_Hand_Score = 2;
            }else if($GSR >= 61.4 && $GSR <= 80.6){
                $Female_Hand_Score = 0;
            }else if($GSR > 80.6){
                $Female_Hand_Score = 1;
            }
        }
        return $Female_Hand_Score;
    }

    function getFemaleFeetScore($age, $GSR){
        $Female_Hand_Score = 0;
        if($age > 21 && $age <= 30){
            if($GSR < 78.1){
                $Female_Hand_Score = 2;
            }else if($GSR >= 78.1 && $GSR <= 89.7 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 84.3){
                $Female_Hand_Score = 1;
            }
        }else if($age > 30 && $age <= 40){
            if($GSR < 79.4){
                $Female_Hand_Score = 2;
            }else if($GSR >= 79.4 && $GSR <= 89 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 89 ){
                $Female_Hand_Score = 1;
            }
        }else if($age > 40 && $age <= 50){
            if($GSR < 77.9 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 77.9 && $GSR <= 88.3 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 88.3){
                $Female_Hand_Score = 1;
            }
        }else if($age > 50 && $age <= 60){
            if($GSR < 77.1){
                $Female_Hand_Score = 2;
            }else if($GSR >= 77.1 && $GSR <= 88.3 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 88.3){
                $Female_Hand_Score = 1;
            }
        }else if($age > 60 && $age <= 70){
            if($GSR < 78){
                $Female_Hand_Score = 2;
            }else if($GSR >= 78 && $GSR <= 86.4){
                $Female_Hand_Score = 0;
            }else if($GSR > 86.4){
                $Female_Hand_Score = 1;
            }
        }else if($age > 71){
            if($GSR < 66.2 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 66.2 && $GSR <= 84.8 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 84.8){
                $Female_Hand_Score = 1;
            }
        }
        return $Female_Hand_Score;
    }




    function getMaleHandScore($age, $GSR){
        $Female_Hand_Score = 0;
        if($age > 21 && $age <= 30){
            if($GSR < 65.9 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 65.9 && $GSR <= 86.1 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 84.3){
                $Female_Hand_Score = 1;
            }
        }else if($age > 30 && $age <= 40){
            if($GSR < 70.8){
                $Female_Hand_Score = 2;
            }else if($GSR >= 70.8 && $GSR <= 84 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 84 ){
                $Female_Hand_Score = 1;
            }
        }else if($age > 40 && $age <= 50){
            if($GSR < 64.5 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 64.5 && $GSR <= 85.9 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 85.9 ){
                $Female_Hand_Score = 1;
            }
        }else if($age > 50 && $age <= 60){
            if($GSR < 68.1 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 68.1 && $GSR <= 83.5 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 83.5 ){
                $Female_Hand_Score = 1;
            }
        }else if($age > 60 && $age <= 70){
            if($GSR < 60.7 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 60.7 && $GSR <= 83.9 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 83.9 ){
                $Female_Hand_Score = 1;
            }
        }else if($age > 71){
            if($GSR < 56.2 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 56.2 && $GSR <= 76.2 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 76.2 ){
                $Female_Hand_Score = 1;
            }
        }
        return $Female_Hand_Score;
    }

    function getMaleFeetScore($age, $GSR){
        $Female_Hand_Score  = 0;
        if($age > 21 && $age <= 30){
            if($GSR < 74.1){
                $Female_Hand_Score = 2;
            }else if($GSR >= 74.1 && $GSR <= 89.3 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 89.3){
                $Female_Hand_Score = 1;
            }
        }else if($age > 30 && $age <= 40){
            if($GSR < 75.7 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 75.7 && $GSR <= 86.7 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 86.7 ){
                $Female_Hand_Score = 1;
            }
        }else if($age > 40 && $age <= 50){
            if($GSR < 73.9 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 73.9 && $GSR <= 88.1 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 88.1){
                $Female_Hand_Score = 1;
            }
        }else if($age > 50 && $age <= 60){
            if($GSR < 78.3){
                $Female_Hand_Score = 2;
            }else if($GSR >= 78.3 && $GSR <= 89.7 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 89.7 ){
                $Female_Hand_Score = 1;
            }
        }else if($age > 60 && $age <= 70){
            if($GSR < 77.1){
                $Female_Hand_Score = 2;
            }else if($GSR >= 77.1 && $GSR <= 85.9){
                $Female_Hand_Score = 0;
            }else if($GSR > 85.9 ){
                $Female_Hand_Score = 1;
            }
        }else if($age > 71){
            if($GSR < 66.6 ){
                $Female_Hand_Score = 2;
            }else if($GSR >= 66.6 && $GSR <= 85.4 ){
                $Female_Hand_Score = 0;
            }else if($GSR > 85.4 ){
                $Female_Hand_Score = 1;
            }
        }
        return $Female_Hand_Score;
    }


    function getANSHeartScore( $sex, $age, $HR){
        $ANS_Score  = 0;
        if($sex == "Male"){
            if($age >= 18 && $age <= 25){
                 if($HR > 49 && $HR <=55){

                 }else if($HR > 55 && $HR <= 61){

                 }else if($HR > 61 && $HR <= 65){
                     $ANS_Score += 1;
                 }else if($HR > 65 && $HR <=69){
                     $ANS_Score += 2;
                 }else if($HR > 69 && $HR <= 73){
                     $ANS_Score += 3;
                 }else if($HR > 73 && $HR <= 81){
                     $ANS_Score += 4;
                 }else if($HR >= 82){
                     $ANS_Score += 5;
                 }                   
            }else if($age >= 26 && $age <= 35){
                 if($HR > 49 && $HR <=54){

                 }else if($HR > 54 && $HR <= 61){

                 }else if($HR > 61 && $HR <= 65){
                     $ANS_Score += 1;
                 }else if($HR > 65 && $HR <= 70){
                     $ANS_Score += 2;
                 }else if($HR > 70 && $HR <= 74){
                     $ANS_Score += 3;
                 }else if($HR > 74 && $HR <= 81){
                     $ANS_Score += 4;
                 }else if($HR >= 82){
                     $ANS_Score += 5;
                 }    
            }else if($age >= 36 && $age <= 45){
                 if($HR > 50 && $HR <= 56){

                 }else if($HR > 56 && $HR <= 62){

                 }else if($HR > 62 && $HR <= 66){
                     $ANS_Score += 1;
                 }else if($HR > 66 && $HR <= 70){
                     $ANS_Score += 2;
                 }else if($HR > 70 && $HR <= 75){
                     $ANS_Score += 3;
                 }else if($HR > 75 && $HR <= 82){
                     $ANS_Score += 4;
                 }else if($HR > 82){
                     $ANS_Score += 5;
                 }  
            }else if($age >= 46 && $age <= 55){
                 if($HR > 50 && $HR <= 57){
                 }else if($HR > 57 && $HR <= 63){
                 }else if($HR > 63 && $HR <= 67){
                     $ANS_Score += 1;
                 }else if($HR > 67 && $HR <= 71){
                     $ANS_Score += 2;
                 }else if($HR > 71 && $HR <= 76){
                     $ANS_Score += 3;
                 }else if($HR > 76 && $HR <= 83){
                     $ANS_Score += 4;
                 }else if($HR > 83){
                     $ANS_Score += 5;
                 }  
            }else if($age >= 56 && $age <= 65){
                 if($HR > 51 && $HR <= 56){
                 }else if($HR > 56 && $HR <= 61){
                 }else if($HR > 61 && $HR <= 67){
                     $ANS_Score += 1;
                 }else if($HR > 67 && $HR <= 71){
                     $ANS_Score += 2;
                 }else if($HR > 71 && $HR <= 75){
                     $ANS_Score += 3;
                 }else if($HR > 75 && $HR <= 81){
                     $ANS_Score += 4;
                 }else if($HR > 81){
                     $ANS_Score += 5;
                 }  
            }else if($age > 65){
                 if($HR > 50 && $HR <= 55){
                 }else if($HR > 55 && $HR <= 61){
                 }else if($HR > 61 && $HR <= 65){
                     $ANS_Score += 1;
                 }else if($HR > 65 && $HR <= 69){
                     $ANS_Score += 2;
                 }else if($HR > 69 && $HR <= 73){
                     $ANS_Score += 3;
                 }else if($HR > 73 && $HR <= 79){
                     $ANS_Score += 4;
                 }else if($HR > 79){
                     $ANS_Score += 5;
                 }  
            }
        }else{

             if($age >= 18 && $age <= 25){
                     if($HR > 54 && $HR <= 60){
                     }else if($HR > 60 && $HR <= 65){
                     }else if($HR > 65 && $HR <= 69){
                         $ANS_Score += 1;
                     }else if($HR > 69 && $HR <=73){
                         $ANS_Score += 2;
                     }else if($HR > 73 && $HR <= 78){
                         $ANS_Score += 3;
                     }else if($HR > 78 && $HR <= 84){
                         $ANS_Score += 4;
                     }else if($HR > 84){
                         $ANS_Score += 5;
                     }                   
             }else if($age >= 26 && $age <= 35){
                     if($HR > 54 && $HR <= 59){
                     }else if($HR > 59 && $HR <= 64){
                     }else if($HR > 64 && $HR <= 68){
                         $ANS_Score += 1;
                     }else if($HR > 68 && $HR <= 72){
                         $ANS_Score += 2;
                     }else if($HR > 72 && $HR <= 76){
                         $ANS_Score += 3;
                     }else if($HR > 76 && $HR <= 82){
                         $ANS_Score += 4;
                     }else if($HR > 82){
                         $ANS_Score += 5;
                     }    
             }else if($age >= 36 && $age <= 45){
                     if($HR > 54 && $HR <= 59){

                     }else if($HR > 59 && $HR <= 64){

                     }else if($HR > 64 && $HR <= 69){
                         $ANS_Score += 1;
                     }else if($HR > 69 && $HR <= 73){
                         $ANS_Score += 2;
                     }else if($HR > 73 && $HR <= 78){
                         $ANS_Score += 3;
                     }else if($HR > 78 && $HR <= 84){
                         $ANS_Score += 4;
                     }else if($HR > 84){
                         $ANS_Score += 5;
                     }  
             }else if($age >= 46 && $age <= 55){
                     if($HR > 54 && $HR <= 60){
                     }else if($HR > 60 && $HR <= 65){
                     }else if($HR > 65 && $HR <= 69){
                         $ANS_Score += 1;
                     }else if($HR > 69 && $HR <= 73){
                         $ANS_Score += 2;
                     }else if($HR > 73 && $HR <= 77){
                         $ANS_Score += 3;
                     }else if($HR > 77 && $HR <= 83){
                         $ANS_Score += 4;
                     }else if($HR > 83){
                         $ANS_Score += 5;
                     }  
             }else if($age >= 56 && $age <= 65){
                     if($HR > 54 && $HR <= 59){
                     }else if($HR > 59 && $HR <= 64){
                     }else if($HR > 64 && $HR <= 68){
                         $ANS_Score += 1;
                     }else if($HR > 68 && $HR <= 73){
                         $ANS_Score += 2;
                     }else if($HR > 73 && $HR <= 77){
                         $ANS_Score += 3;
                     }else if($HR > 77 && $HR <= 83){
                         $ANS_Score += 4;
                     }else if($HR > 83){
                         $ANS_Score += 5;
                     }  
             }else if($age > 65){
                     if($HR > 54 && $HR <= 59){
                     }else if($HR > 59 && $HR <= 64){
                     }else if($HR > 64 && $HR <= 68){
                         $ANS_Score += 1;
                     }else if($HR > 68 && $HR <= 72){
                         $ANS_Score += 2;
                     }else if($HR > 72 && $HR <= 76){
                         $ANS_Score += 3;
                     }else if($HR > 76 && $HR <= 84){
                         $ANS_Score += 4;
                     }else if($HR > 84){
                         $ANS_Score += 5;
                     }  
             }                    
        }

        return $ANS_Score;

    }

    function getSDNNScore($age, $SDNN){
        $ANS_Score = 0;
        if($age > 30){
            if($SDNN >= 30 && $SDNN < 40){
                $ANS_Score += 1;
            }else if($SDNN < 30){
                $ANS_Score += 3;
            }
       }else{
            if($SDNN >= 35 && $SDNN < 45){
                $ANS_Score += 1;
            }else if($SDNN < 35){
                $ANS_Score += 3;
            }
       }
       return $ANS_Score;
    }


    function getRMSSDScore($age, $RMSSD){
        $ANS_Score = 0;
        if($age > 30){
            if($RMSSD >= 25 && $RMSSD < 35){
                $ANS_Score += 1;
            }else if($RMSSD < 25){
                $ANS_Score += 3;
            }
        }else{
            if($RMSSD >= 30 && $RMSSD < 40){
                $ANS_Score += 1;
            }else if($RMSSD < 30){
                $ANS_Score += 3;
            }
        }
        return $ANS_Score;

    }

    function getAvgRRScore($AVG_RR){
        $ANS_Score = 0;
        if($AVG_RR >= 500 && $AVG_RR < 670){
            $ANS_Score += 1;
        }else if($AVG_RR < 500){
            $ANS_Score += 3;
        }
        return $ANS_Score;

    }

    function get50Score($PERCENT_MORE_THAN_50){
        $ANS_Score = 0;
        if($PERCENT_MORE_THAN_50 >= 5 && $PERCENT_MORE_THAN_50 < 10){
            $ANS_Score += 1;
        }else if($PERCENT_MORE_THAN_50 < 5){
            $ANS_Score += 3;
        }
        return $ANS_Score;
    }
    

    function getBaselineFromSys($avg_systolic){
        $overview_score = 0;
        if($avg_systolic < 120 ){
            $overview_score += 0;
        }else if( $avg_systolic < 130 ){
            $overview_score += 1;
        }else if( $avg_systolic < 140 ){
            $overview_score += 3;
        }else if($avg_systolic < 180 ){
            $overview_score += 4;
        }else{
            $overview_score += 5;
        }
        return $overview_score;
    }

    function getBaselineFromDia($avg_diastolic){
        $overview_score = 0;
        if($avg_diastolic < 80 ){
            $overview_score += 0;
        }else if( $avg_diastolic < 90 ){
            $overview_score += 2;
        }else if( $avg_diastolic < 120 ){
            $overview_score += 4;
        }else{
            $overview_score += 5;
        }
        return $overview_score;
    }


    // get standing step scores
    function getStandingFromSys($avg_systolic){
        $overview_score = 0;
        if($avg_systolic < 110 ){
            $overview_score += 0;
        }else if( $avg_systolic < 120 ){
            $overview_score += 1;
        }else if( $avg_systolic < 130 ){
            $overview_score += 3;
        }else if($avg_systolic < 170 ){
            $overview_score += 4;
        }else{
            $overview_score += 5;
        }
        return $overview_score;
    }

    function getStandingFromDia($avg_diastolic){
        $overview_score = 0;
        if($avg_diastolic < 75 ){
            $overview_score += 0;
        }else if( $avg_diastolic < 84 ){
            $overview_score += 2;
        }else if( $avg_diastolic < 114 ){
            $overview_score += 4;
        }else{
            $overview_score += 5;
        }
        return $overview_score;
    }


    function getValsalvaScore($value){
        $score = 0;
        if( $value < -60){
            $score += 0;
        }else if($value < -50){
            $score += 0;
        }else if($value < -40){
            $score += 1;
        }else if($value < -20){
            $score += 3;
        }else if($value < -10){
            $score += 4;
        }else{
            $score += 5;
        }
        return $score;
    }


    function getSPRSScore($value){
        $score = 0;
        if($value < -30){
            $score += 1;
        }else if($value < 10 && $value > 5){
            $score += 3;
        }else if($value < 20 && $value > 10){
            $score += 4;
        }else if($value > 20){
            $score += 5;
        }
        return $score;
    }

    function getDPRSScore($value){
        $score = 0;
        if($value < -30){
            $score += 1;
        }else if($value < 10 && $value > 5){
            $score += 3;
        }else if($value < 20 && $value > 10){
            $score += 4;
        }else if($value > 20){
            $score += 5;
        }
        return $score;
    }


?>