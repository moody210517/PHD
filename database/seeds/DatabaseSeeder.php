<?php

use Illuminate\Database\Seeder;
use App\VisitPurpose;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {   
        
        $this->call([
            UserTypeSeeder::class            
        ]);

        // visit purpose part
        VisitPurpose::create([
            'title' => 'Asthma',
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => 'Heart Failure',
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => 'Altherosclerosis or Angina',
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => 'LV Hypertrophy',
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => 'Arrythmia',
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => 'Hypertension',
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Parkinson's Disease",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Raynaud's Syndrome",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "AV Block",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Pheochromocytoma",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Renal Failure",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Type II Diabetes",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Type I Diabetes",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Autoimmune Disease",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Cushing's Syndrome",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Hepatitis",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Sleep Apnea",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Bladder/Prostate Enlargement",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Cancer",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "HIV/AIDS",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Hypothyroidism",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Nephropathy",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Unipolar Depression",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Infectious Disease",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Glaucoma",
            'type' => 'Disease'
        ]);
        VisitPurpose::create([
            'title' => "Retinopathy",
            'type' => 'Disease'
        ]);

     

        // symptoms part
        VisitPurpose::create([
            'title' => "Fatigue",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Headache",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Chronic Pain",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Dizziness/Fainting",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Tingling in Toes/Fingers",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Head Interollerance",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Exercise Interollerance",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Smoking",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Burry Vision",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Erectile Distunction",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Previous MI or Stroke",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Urinary Problems",
            'type' => 'Symptoms'
        ]);
        VisitPurpose::create([
            'title' => "Digestive Disorders",
            'type' => 'Symptoms'
        ]);


        // visit treatment part
        VisitPurpose::create([
            'title' => "Anti Hypertensive Agent",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Anti Diabetic Agent",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Insulin Treatment",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Corticolds",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Anti Lipidemic Agent",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Thyroid Hormone Treatment",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Estrogen Therapy",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Contraceptive Pill",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Anti Depressants",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Stents",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Anti Platelets Agent",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Pacemaker",
            'type' => 'Treatment'
        ]);
        VisitPurpose::create([
            'title' => "Chemotherapy / Radiation",
            'type' => 'Treatment'
        ]);









    }
}
