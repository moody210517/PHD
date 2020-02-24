


@extends('admin.main')

@section('content')   
    



<div class="canvas_div_pdf">

	<div class="page-container" >
		<div class="bg-white pt-4 pb-5 hide-print">
					
				<div class="page-title padding pb-0 ">										
				</div>
				
				<form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('report/savenote') }}" enctype="multipart/form-data">
				@csrf				
				<input type = "hidden" value="{{$allocation->auto_num}}" name="allocation_id" id="allocation_id" />
				
				<div class="row px-4">
					<div class="col-md-6 mt-2">	
						<h2 class="text-md mb-0">Test Review </h2>
					</div>
					
					
					<div class="col-md-6 mt-2 text-right">										
						<button  type="button"  class="btn  mb-1 btn-primary btn-notes" > Add Test Notes </button>		
						<button  type="button"  class="btn  mb-1 btn-primary btn-print" > Save as PDF </button>								
					</div>
				</div>

				</form>
								
				<div class="padding">							
					<div class="row px-3">
						<div class="col-md-3">
							<label class="col-form-label"> Patient Name </label>
						</div> 
						
						<div class="col-md-9">
							<input type="text" name="first_name" class="form-control" value="{{$patient->first_name.' '.$patient->last_name}}" placeholder="First Name" disabled>
						</div>                    
					</div>

					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="col-form-label"> Date of Exam</label>
						</div>
						
						<div class="col-md-9">							
							<input type="date" id="date" name="date" value="{{ substr($allocation->created_at, 0, 10) }}" class="form-control"  disabled>
						</div>                    
					</div>


					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="col-form-label"> Time of Exam</label>
						</div>
						
						<div class="col-md-9">
							<input type="time" id="time" name="time" value="{{ substr($allocation->created_at, 11, 10) }}"  class="form-control"  disabled>
						</div>                    
					</div>

					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="col-form-label"> BMI </label>
							<!-- <i class="ml-2 mr-2 i-con i-con-info" data-toggle="modal" data-target="#bmi_info"><i class="i-con-border"></i></i> -->
						</div>							
						<div class="col-md-9">
							<span class="form-control no-border"> {{$bmi }} - <strong class="{{$color}}"> {{$weight_status}} </strong></span> 
						</div>
					</div>

		

					<div class="row px-3 pt-3">
						<button onclick="expandContract()" class="btn btn-rounded bg-primary-lt i-con-h-a">
							<i class="i-con i-con-plus float-left w-16" id="icon_plus"></i>
							&nbsp;&nbsp; Pre-Test Questions
						</button>
					</div>
										
															

					<div id="expand-container">
						
						<div id="expand-contract" class="collapsed">
							
							<div class="padding">				

								<div class="row px-3 pt-2">
									<div class="col-md-5">
										<h6> Daily Activity Level: </h6>
									</div>
									<div class="col-md-7">
										
										<?php  if($visit_form && $visit_form->daily_activity == 1) { echo " Very little to no activity"; } ?> 
										<?php  if($visit_form && $visit_form->daily_activity == 2) { echo " Very light activity/Office activity"; } ?> 
										<?php  if($visit_form && $visit_form->daily_activity == 3) { echo " Moderate activity: 20 minutes per day/2 hours per week"; } ?> 
										<?php  if($visit_form && $visit_form->daily_activity == 4) { echo " Exercise: 2-4 hours per week"; } ?> 
										<?php  if($visit_form && $visit_form->daily_activity == 5) { echo " High exercise level: greater than 4 hours per week"; } ?> 
									</div>																			
								</div>		

								<div class="row px-3 pt-2">
									<div class="col-md-5">
										<h5> Reason For Visit: </h5>
									</div>
									<div class="col-md-7">

										<div class="radio mt-2">
											<label class="ui-check ui-check-md">
											<input id="rd_checkup" type="radio" name="rd_visit_step" class="visit_step" <?php if($visit_form->symptoms == "" && $visit_form->disease == "" && $visit_form->treatment == "" ) { echo 'checked';} ?> disabled>
											<i class="dark-white"></i>
											Check Up
											</label>								
										</div>

										<div class="checkbox">
											<label class="ui-check ui-check-md">
											<input id="chk_symptoms" type="checkbox"  class="visit_purpose" <?php if($visit_form->symptoms != null ) { echo 'checked';} ?>  disabled>
											<i class="dark-white"></i>
											Symptoms review
											</label>
										</div>
										<div class="checkbox">
											<label class="ui-check ui-check-md">
											<input id="chk_disease" type="checkbox"  class="visit_purpose" <?php if($visit_form->disease != null ) { echo 'checked';} ?>  disabled>
											<i class="dark-white"></i>
											Disease review
											</label>
										</div>
										<div class="checkbox">
											<label class="ui-check ui-check-md">
											<input id="chk_treatment" type="checkbox" class="visit_purpose" <?php if($visit_form->treatment != null ) { echo 'checked';} ?>  disabled>
											<i class="dark-white"></i>
											Follow-up for treatment
											</label>
										</div>																				
									</div>																			
								</div>	


								<div class="row px-3 pt-2">
									<div class="col-md-12">
										
										<h6> Symptoms review </h6> 
										<?php  if($visit_form && $visit_form->symptoms != "") { echo $visit_form->symptoms; } ?> <br>																				
									</div>					
									
									<div class="col-md-12 pt-2">
									
										<h6> Disease review </h6> 
										<?php  if($visit_form && $visit_form->disease != "") { echo $visit_form->disease; } ?> <br>
									</div>					
									
									<div class="col-md-12 pt-2">
										
										<h6> Treatment review </h6> 
										<?php  if($visit_form && $visit_form->treatment != "") { echo $visit_form->disease; } ?> 										
									</div>					

								</div>




								<div class="row px-3 pt-4">
									<div class="col-md-12">
										<h5>Type II Questions</h5>
									</div>						
								</div>

								<div class="row px-3">
									<div class="col-md-7 col-7">
										<label class=""> History of high blood glucose: </label>																				
									</div>							
									<div class="col-md-5 col-5">				
										<label class="">																				
										<?php  if($user_diabet->first() && $user_diabet->first()->glucose == 1) { echo "Yes"; } ?> 
										<?php  if($user_diabet->first() && $user_diabet->first()->glucose == 0) { echo "No"; } ?> 
										</label>
									</div>                    
								</div>

								<div class="row px-3">
									<div class="col-md-7 col-7">
										<label class=""> BMI: </label>																				
									</div>
									<div class="col-md-5 col-5">	
										<label class="">																							
										{{$bmi}}
										</label>
									</div>                    
								</div>

								<div class="row px-3">
									<div class="col-md-7 col-7">
										<label class=""> Daily consumption of vegetables, fruits, or berries: </label>																				
									</div>
									<div class="col-md-5 col-5">			
										<label class="">
										<?php  if($user_diabet->first() && $user_diabet->first()->vegetable == 1) { echo "Yes"; } ?>
										<?php  if($user_diabet->first() && $user_diabet->first()->vegetable == 0) { echo "No"; } ?>		
										</label>
									</div>                    
								</div>
															
								<div class="row px-3">
									<div class="col-md-7 col-7">									
										<label class=""> Waist (in):  </label>										
									</div>							
									<div class="col-md-5 col-5">
										<label class="">		
										{{ $user_diabet->first()? $user_diabet->first()->waist:'' }}
										</label>
									</div>									
								</div>
								<div class="row px-3">
									<div class="col-md-7 col-7">
										<label class=""> Family history of diabetes:  </label>										
									</div>							
									<div class="col-md-5 col-5">	
										<label class="">	
										<?php  if($user_diabet->first() && $user_diabet->first()->family == 0) { echo "No"; } ?> 
										<?php  if($user_diabet->first() && $user_diabet->first()->family == 2) { echo "Yes - 1st Degree Relative"; } ?> 
										<?php  if($user_diabet->first() && $user_diabet->first()->family == 1) { echo "Yes - 2nd Degree Relative"; } ?>
										</label>
									</div>									
								</div>



								<div class="row px-3 pt-2">
									<div class="col-md-7 col-7">
										<label class=""> Use of blood pressure medication: </label>																				
									</div>							
									<div class="col-md-5 col-5">																				
										<label class="">
										<?php  if($user_diabet->first() && $user_diabet->first()->bpmeds == 1) { echo "Yes"; } ?>
										<?php  if($user_diabet->first() && $user_diabet->first()->bpmeds == 0) { echo "No"; } ?>
										</label>
									</div>                    
								</div>



							</div>

						</div>
					</div>
					



					<div class="row px-3 pt-5">
						<h2>Overall Results of Test </h2>						
					</div>
					<h5>(Click on any gauge for more details)</h5>



					<div id="overall">

							<div class="row px-3 pt-5">
								<div class="col-md-12 report_title">		
									<h5 class="mb-0">Type II Diabetes & Arterial Assessment </h5>
								</div>
							</div>

							<div class="row px-3">								
								<div class="col-md-4 blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">Type II Risk</h6> </label>
									<div class="row" >
										<div class="form-control text-center no-border pt-3 pb-3 canvas_container_overall" id="div-preview1">	
											<div id="preview">
												<canvas width="380" height="170" id="canvas-preview1"></canvas>						
											</div>
											<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 26 &nbsp  100% </div>  </div> -->
											<div id="preview-textfield1" class="reset" style="display:none;">1</div>
											<div class="reset"> {{ $diabet_risk_score }}</div>
											<div id="status1" class="status {{$diabet_risk_color}}">{{$diabet_risk_name}}</div>
										</div>
									</div>			
								</div>						

								<div class="col-md-4 blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">Overall Blood Pressure</h6> </label>
									<div class="row" >
										<div class="form-control text-center no-border pt-3 pb-3 canvas_container_overall" id="div-preview2">	
											<div id="preview">
												<canvas width="380" height="170" id="canvas-preview2"></canvas>						
											</div>
											<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 26 &nbsp  100% </div>  </div> -->
											<div id="preview-textfield2" class="reset" style="display:none;">1</div>
											<div class="reset"> {{ $overall_blood_risk_score }}</div>
											<div id="status1" class="status {{$overall_blood_risk_color}}">{{$overall_blood_risk_name}}</div>
										</div>
									</div>			
								</div>																

														
								<div class="col-md-4 blue-border">
									<label class="col-form-label report_sub_title"><h6 class="mb-0"> Galvanic Skin Response</h6> </label>
									<div class="row">
										@if($patient->placemaker == "1")
										<div class="form-control text-center  no-border  pt-3 pb-3 canvas_container_overall" style="background-color:#d3d3d3;">
										@else
										<div class="form-control text-center  no-border  pt-3 pb-3 canvas_container_overall" id="div-preview3">
										@endif
																		
											<div id="preview">
												<canvas width="380" height="170" id="canvas-preview3"></canvas>						
											</div>
											<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 4 &nbsp  100% </div>  </div> -->
											<div id="preview-textfield3" class="reset" style="display:none;">1,250</div>
											<div class="reset"> {{$skin[0]}} </div>											
											@if($patient->placemaker == "1")										
												<div id="status3" class="status red-color">  Disabled </div>
											@else
												<div id="status3" class="status {{$skin[3]}}"> {{$skin[2]}}</div>
											@endif
											

											
										</div>
									</div>							
								</div>								
							</div>
							
							<div class="row px-3 pt-5">
								<div class="col-md-12 report_title">		
									<h5 class="mb-0">Autonomic Nerve Assessment </h5>
								</div>
							</div>
					
							<div class="row px-3">																						
									<div class="col-md-3  blue-border">
										<label class="col-form-label report_sub_title"> <h6 class="mb-0">ANS Dysfunction</h6> </label>
										<div class="row">
											<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall" id="div-preview5">
												
												<div id="preview">
													<canvas width="380" height="170" id="canvas-preview5" ></canvas>						
												</div>
												<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 18   100% </div>  </div>										 -->
												<div id="preview-textfield5" class="reset" style="display:none;">1,250</div>
												<div class="reset">{{ $ans_dysfunction_risk_score }}</div>
												<div id="status5" class="status {{$ans_dysfunction_risk_color}}">{{$ans_dysfunction_risk_name}}</div>

											</div>					
										</div>							
									</div>	


									<div class="col-md-3   blue-border">
										<label class="col-form-label report_sub_title"> <h6 class="mb-0">Adrenergic Sympathetic</h6> </label>
										<div class="row">
											<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall" id="div-preview6">
												
												<div id="preview">
													<canvas width="380" height="170" id="canvas-preview6" ></canvas>	
												</div>
												<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 35   100% </div>  </div> -->
												<div id="preview-textfield6" class="reset" style="display:none;">1,250</div>
												<div class="reset">{{$adrenergic[0]}}</div>
												<div id="status6" class="status {{$adrenergic[3]}}">{{$adrenergic[2]}}</div>

											</div>
										</div>														
									</div>	


									<div class="col-md-3   blue-border">
										<label class="col-form-label report_sub_title"> <h6 class="mb-0">Parasympathetic</h6> </label>
										<div class="row">
											<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall" id="div-preview7">
												
												<div id="preview">
													<canvas width="380" height="170" id="canvas-preview7"></canvas>						
												</div>
												<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 3   100% </div>  </div> -->
												<div id="preview-textfield7" class="reset" style="display:none;">1,250</div>
												<div class="reset">{{$para[0]}}</div>
												<div id="status7" class="status {{$para[3]}}">{{$para[2]}}</div>

											</div>
										</div>							
									</div>	


									<div class="col-md-3  blue-border">
										<label class="col-form-label report_sub_title"> <h6 class="mb-0">Cardiac Autonomic Neuropathy</h6> </label>
										<div class="row">
											<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall" id="div-preview8">
												
												<div id="preview">
													<canvas width="380" height="170" id="canvas-preview8"></canvas>	
												</div>
												<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 18            100% </div>  </div> -->
												<div id="preview-textfield8" class="reset" style="display:none;">1,250</div>
												<div class="reset">{{$card[0]}}</div>
												<div id="status8" class="status {{$card[3]}}">{{$card[2]}}</div>
											</div>
										</div>							
									</div>


							</div>																	
					</div>		

			</div>


			<div class="col-md-12 mt-4 text-right">	
				@if($page_type == "test")
					<a  href="{{ URL::to('doctor/testland') }}" class="btn col-md-2 mb-1 btn-primary">Home</a>	
				@else
					<a  href="{{ URL::to('Testreview/TestPatients') }}" class="btn col-md-2 mb-1 btn-primary">Home</a>					
					<button type="submit" class="btn col-md-2 mb-1 btn-primary btn-print"> Save as PDF </button>		

				@endif
				
			</div>


		</div>
	</div>


	<div id="print" class="page-container bg-white text-dark">
						
		<div id="pre_questions">		
				<div class="padding">				
					<div class="page-title padding pb-0 text-center">		
						<img class='menu_icon' />								
						<h5>Healthcare Professional Autonomic Nervous System Results</h5>			
					</div>
				
					<div class="row px-3 pt-2">
					<div class="col-md-12">
					<h5>The following report is a result from the Proactive Healthcare Detection device for {{$patient->first_name.' '.$patient->last_name}}.</h5>
					</div>
					</div>

					<div class="row px-3 mt-2">
						<div class="col-md-3">
							<label class="print_label"> Patient Name </label>
						</div>
						
						<div class="col-md-9">
							{{$patient->first_name.' '.$patient->last_name}}							
						</div>                    
					</div>

					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="print_label"> Date of Birth</label>
						</div>						
						<div class="col-md-9">							
							{{ $patient->date_of_birth }}
						</div>                    
					</div>

					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="print_label"> Date of Exam</label>
						</div>						
						<div class="col-md-9">							
						{{ substr($allocation->created_at, 0, 10) }}
						</div>                    
					</div>


					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="print_label"> Time of Exam</label>
						</div>						
						<div class="col-md-9">
						{{ substr($allocation->created_at, 11, 10) }}
						</div>                    
					</div>

					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="print_label"> Height </label>
						</div>						
						<div class="col-md-9">
						
						{{ $patient->user_height - 12 * floor($patient->user_height/12) }} feet
						{{ $patient->user_height - 12 * floor($patient->user_height/12) }} inches

						</div>                    
					</div>

					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="print_label"> Weight</label>
						</div>						
						<div class="col-md-9">
						{{ $patient->weight }}
						
						</div>                    
					</div>
					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="print_label"> Age</label>
						</div>						
						<div class="col-md-9">
						{{ $patient->age }}
						</div>                    
					</div>
					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="print_label"> Gender</label>
						</div>						
						<div class="col-md-9">
						{{ $patient->sex }}
						</div>                    
					</div>

			


					<div class="row px-3 pt-2">
						<div class="col-md-5">
							<h6> Daily Activity Level: </h6>
						</div>
						<div class="col-md-7">
							
							<?php  if($visit_form && $visit_form->daily_activity == 1) { echo " Very little to no activity"; } ?> 
							<?php  if($visit_form && $visit_form->daily_activity == 2) { echo " Very light activity/Office activity"; } ?> 
							<?php  if($visit_form && $visit_form->daily_activity == 3) { echo " Moderate activity: 20 minutes per day/2 hours per week"; } ?> 
							<?php  if($visit_form && $visit_form->daily_activity == 4) { echo " Exercise: 2-4 hours per week"; } ?> 
							<?php  if($visit_form && $visit_form->daily_activity == 5) { echo " High exercise level: greater than 4 hours per week"; } ?> 
						</div>																			
					</div>		

					<div class="row px-3 pt-2">
						<div class="col-md-5">
							<h5> Reason For Visit: </h5>
						</div>
						<div class="col-md-7">

							<div class="radio mt-2">
								<label class="ui-check ui-check-md">
								<input id="rd_checkup" type="radio" name="rd_visit_step" class="visit_step" <?php if($visit_form->symptoms == "" && $visit_form->disease == "" && $visit_form->treatment == "" ) { echo 'checked';} ?> disabled>
								<i class="dark-white"></i>
								Check Up
								</label>								
							</div>

							<div class="checkbox">
								<label class="ui-check ui-check-md">
								<input id="chk_symptoms" type="checkbox"  class="visit_purpose" <?php if($visit_form->symptoms != null ) { echo 'checked';} ?>  disabled>
								<i class="dark-white"></i>
								Symptoms review
								</label>
							</div>
							<div class="checkbox">
								<label class="ui-check ui-check-md">
								<input id="chk_disease" type="checkbox"  class="visit_purpose" <?php if($visit_form->disease != null ) { echo 'checked';} ?>  disabled>
								<i class="dark-white"></i>
								Disease review
								</label>
							</div>
							<div class="checkbox">
								<label class="ui-check ui-check-md">
								<input id="chk_treatment" type="checkbox" class="visit_purpose" <?php if($visit_form->treatment != null ) { echo 'checked';} ?>  disabled>
								<i class="dark-white"></i>
								Follow-up for treatment
								</label>
							</div>																				
						</div>																			
					</div>	


					<div class="row px-3 pt-2">
						<div class="col-md-12 padding blue-border">
							
							<h6> Symptoms review </h6> 
							<?php  if($visit_form && $visit_form->symptoms != "") { echo $visit_form->symptoms; } ?> <br>																				
							
						</div>					
						
						<div class="col-md-12 blue-border padding pt-2 mt-2">
						
							<h6> Disease review </h6> 
							<?php  if($visit_form && $visit_form->disease != "") { echo $visit_form->disease; } ?> <br>
						</div>					
						
						<div class="col-md-12 blue-border padding pt-2 mt-2">
							
							<h6> Treatment review </h6> 
							<?php  if($visit_form && $visit_form->treatment != "") { echo $visit_form->disease; } ?> 										
						</div>					

					</div>					

				</div>

		</div>

		<div class="pagebreak"> </div> 
		<!-- page 2 -->
		<div class="padding">

					<div class="page-title padding pb-0 text-center">		
						<img class='menu_icon' />								
						<h5>Healthcare Professional Autonomic Nervous System Results</h5>			
					</div>

					<div id="overall_print">

					
						<div class="row px-3 pt-5">
							<div class="col-md-12 ">	
								<h5 class="print-title-color"> Overall Results </h5>
							</div>
						</div>

						<div class="row px-3 pt-1">
							<div class="col-md-12 report_title">		
								<h5 class="mb-0">Type II Diabetes & Arterial Assessment </h5>
							</div>
						</div>

						<div class="row px-3">								
							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">Type II Risk</h6> </label>
								<div class="row" >
									<div class="form-control text-center no-border pt-3 pb-3 canvas_container_overall">	
										<div id="preview">
											<img width="100%" height="100%" id="image-canvas1" ></canvas>	
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 26 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield11" class="reset" style="display:none;">1</div>
										<div class="reset"> {{ $diabet_risk_score }}</div>
										<div  class="status {{$diabet_risk_color}}">{{$diabet_risk_name}}</div>
									</div>
								</div>			
							</div>												

							<div class="col-md-4 blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">Overall Blood Pressure</h6> </label>
									<div class="row" >
										<div class="form-control text-center no-border pt-3 pb-3 canvas_container_overall" id="div-preview1">	
											<div id="preview">
												<img width="100%" height="100%" id="image-canvas2" ></canvas>					
											</div>
											<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 26 &nbsp  100% </div>  </div> -->
											<div id="preview-textfield2" class="reset" style="display:none;">1</div>
											<div class="reset"> {{ $overall_blood_risk_score }}</div>
											<div id="status1" class="status {{$overall_blood_risk_color}}">{{$overall_blood_risk_name}}</div>
										</div>
									</div>			
								</div>		



													
							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"><h6 class="mb-0"> Galvanic Skin Response</h6> </label>
								<div class="row">
									@if($patient->placemaker == "1")
									<div class="form-control text-center  no-border  pt-3 pb-3 canvas_container_overall" style="background-color:#d3d3d3;">
									@else
									<div class="form-control text-center  no-border  pt-3 pb-3 canvas_container_overall">
									@endif
																	
										<div id="preview">											
											<img width="100%" height="100%" id="image-canvas3" ></canvas>							
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 4 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield33" class="reset" style="display:none;">1,250</div>
										<div class="reset"> {{$skin[0]}} </div>										
										@if($patient->placemaker == "1")										
											<div id="status3" class="status red-color">  Disabled </div>
										@else
											<div id="status3" class="status {{$skin[3]}}"> {{$skin[2]}}</div>
										@endif

									</div>
								</div>							
							</div>								
						</div>

						<div class="row px-3 pt-2">
							<div class="col-md-12 report_title">		
								<h5 class="mb-0">Autonomic Nerve Assessment </h5>
							</div>
						</div>

						<div class="row px-3">																						
								<div class="col-md-3  blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">ANS Dysfunction</h6> </label>
									<div class="row">
										<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall">
											
											<div id="preview">												
												<img width="100%" height="100%" id="image-canvas5" ></canvas>
											</div>
											<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 18   100% </div>  </div>										 -->
											<div id="preview-textfield55" class="reset" style="display:none;">1,250</div>
											<div class="reset">{{ $ans_dysfunction_risk_score }}</div>
											<div class="status {{$ans_dysfunction_risk_color}}">{{$ans_dysfunction_risk_name}}</div>

										</div>					
									</div>							
								</div>	


								<div class="col-md-3   blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">Adrenergic Sympathetic</h6> </label>
									<div class="row">
										<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall">
											
											<div id="preview">
												<img width="100%" height="100%" id="image-canvas6" ></canvas>
											</div>
											<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 35   100% </div>  </div> -->
											<div id="preview-textfield66" class="reset" style="display:none;">1,250</div>
											<div class="reset">{{$adrenergic[0]}}</div>
											<div  class="status {{$adrenergic[3]}}">{{$adrenergic[2]}}</div>

										</div>
									</div>														
								</div>	


								<div class="col-md-3   blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">Parasympathetic</h6> </label>
									<div class="row">
										<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall">
											
											<div id="preview">
												<img width="100%" height="100%" id="image-canvas7" ></canvas>
											</div>
											<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 3   100% </div>  </div> -->
											<div id="preview-textfield77" class="reset" style="display:none;">1,250</div>
											<div class="reset">{{$para[0]}}</div>
											<div class="status {{$para[3]}}">{{$para[2]}}</div>

										</div>
									</div>							
								</div>	


								<div class="col-md-3  blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">Cardiac Autonomic Neuropathy</h6> </label>
									<div class="row">
										<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall">
											
											<div id="preview">
												<img width="100%" height="100%" id="image-canvas8" ></canvas>
											</div>
											<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 18            100% </div>  </div> -->
											<div id="preview-textfield88" class="reset" style="display:none;">1,250</div>
											<div class="reset">{{$card[0]}}</div>
											<div class="status {{$card[3]}}">{{$card[2]}}</div>
										</div>
									</div>							
								</div>


						</div>																						
					</div>
					

					<div class="row px-3 pt-4">
						<div class="col-md-12">
							<h5  class="print-title-color"> Type II Risk - Score Based on Finish Diabetes Risk Score </h5>
						</div>						
					</div>
					<div class="row px-3">								
							<div class="col-md-3 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">Type II Risk</h6> </label>
								<div class="row" >
									<div class="form-control text-center no-border pt-3 pb-3 canvas_container_overall">	
										<div id="preview">
											<img width="100%" height="100%" id="image-typeii" ></canvas>	
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 26 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield11" class="reset" style="display:none;">1</div>
										<div class="reset"> {{ $diabet_risk_score }}</div>
										<div  class="status {{$diabet_risk_color}}">{{$diabet_risk_name}}</div>
									</div>
								</div>			
							</div>

							<div class="col-md-9 mt-1">
								<table id="type-table" class="text-center" width="100%" style="border:1px solid black"> 
									<thead>
									<tr>										
										<th class="no_border">Beginning Value</th>
										<th class="no_border">Ending Value</th>
										<th class="no_border" >Risk Percentage</th>
										<th class="no_border">Risk Assessment</th>							
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>														
							</div>																																
					</div>

					

					<div class="row px-3 pt-2">
						<div class="col-md-12">
							<h5  class="print-title-color"> Type II Risk - Details </h5>
						</div>						
					</div>

					<div class="row px-3">	
					<table id="type-risk-table" class="text-center" width="100%" style="border: 1px solid black;">
						<thead>
							<tr>
								<th> Question </th>
								<th> Answer </th>
								<th> Score </th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>		
					</div>
					

		</div>

		<!-- page 3 -->
		<div class="pagebreak"> </div>
		<div class="padding">
					
					<div class="page-title padding pb-0 text-center">		
						<img class='menu_icon' />								
						<h5>Healthcare Professional Autonomic Nervous System Results</h5>			
					</div>

					<div class="row px-3 pt-4">
						<div class="col-md-12">
							<h5 class="print-title-color">Overall Blood Pressure Results</h5>
						</div>						
					</div>


					<div class="row px-3">					

							<div class="col-md-3 blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">Overall Blood Pressure</h6> </label>
									<div class="row" >
										<div class="form-control text-center no-border pt-3 pb-3 canvas_container_overall" id="div-preview2">	
											<div id="preview">
												<img width="100%" height="100%" id="image-blood" ></canvas>						
											</div>
											<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 26 &nbsp  100% </div>  </div> -->
											<div id="preview-textfield2" class="reset" style="display:none;">1</div>
											<div class="reset"> {{ $overall_blood_risk_score }}</div>
											<div id="status1" class="status {{$overall_blood_risk_color}}">{{$overall_blood_risk_name}}</div>
										</div>
									</div>			
							</div>
							
							<div class="col-md-9 mt-1">
								<table id="blood-table" class="text-center" width="100%" style="border:1px solid black;">
									<thead>
									<tr>
										<th class="no_border">Beginning Value</th>
										<th class="no_border">Ending Value</th>
										<th class="no_border">Risk Percentage</th>
										<th class="no_border">Risk Assessment</th>									
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>														
							</div>																																
					</div>

					

					<div class="row px-3 pt-2">
						<div class="col-md-12">
							<h5  class="print-title-color"> Overall Blood Press – Details </h5>
						</div>						
					</div>

					<div class="row px-3">	
					<table id="blood-baseline-table" class="text-center" width="100%" style="border: 1px solid black;">
						<thead>
							<tr>
								<th colspan="2" bgColor="#d9d9d9"> Blood Pressure - Baseline </th>								
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>		
					</div>

					<div class="row px-3 pt-3">	
					<table id="blood-standing-table" class="text-center" width="100%" style="border: 1px solid black;">
						<thead>
							<tr>
								<th colspan="2" bgColor="#d9d9d9"> Blood Pressure – Standing </th>								
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>		
					</div>
					
					<div class="row px-3 pt-3">	
					<table id="blood-standing-res-table" class="text-center" width="100%" style="border: 1px solid black;">
						<thead>
							<tr>
								<th colspan="6" bgColor="#d9d9d9"> Blood Pressure – Standing Response </th>								
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>		
					</div>
					<div class="row px-3 pt-3">	
					<table id="blood-valsa-table" class="text-center" width="100%" style="border: 1px solid black;">
						<thead>
							<tr>
								<th colspan="2" bgColor="#d9d9d9"> Blood Pressure – Valsalva </th>								
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>		
					</div>
					<div class="row px-3 pt-3">	
					<table id="blood-valsa-res-table" class="text-center" width="100%" style="border: 1px solid black;">
						<thead>
							<tr>
								<th colspan="2" bgColor="#d9d9d9"> Blood Pressure – Valsalva Response </th>								
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>		
					</div>
					<div class="row px-3 pt-3">	
					<table id="blood-para-table" class="text-center" width="100%" style="border: 1px solid black;">
						<thead>
							<tr>
								<th colspan="2" bgColor="#d9d9d9"> Parasympathetic </th>								
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>		
					</div>
					
		</div>


		<!-- page 4 -->
		<div class="pagebreak"> </div>
		<div class="padding">
				<div class="page-title padding pb-0 text-center">		
					<img class='menu_icon' />										
					<h5>Healthcare Professional Autonomic Nervous System Results</h5>			
				</div>

				<div class="row px-3 pt-4">
					<div class="col-md-12">
						<h5  class="print-title-color">Overall Parasympathetic</h5>
					</div>						
				</div>


				<div class="row px-3">					

							<div class="col-md-3 blue-border">
									<label class="col-form-label report_sub_title"> <h6 class="mb-0">Parasympathetic</h6> </label>
									<div class="row">
										<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall" id="div-preview7">
											
											<div id="preview">												
												<img width="100%" height="100%" id="image-para" ></canvas>
											</div>
											<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 3   100% </div>  </div> -->
											<div id="preview-textfield7" class="reset" style="display:none;">1,250</div>
											<div class="reset">{{$para[0]}}</div>
											<div id="status7" class="status {{$para[3]}}">{{$para[2]}}</div>

										</div>
									</div>							
							</div>	
							
							
							<div class="col-md-9 mt-1">
								<table id="para-table" class="text-center" width="100%" style="border: 1px solid black;">
									<thead>
									<tr>
										<th class="no_border">Beginning Value</th>
										<th class="no_border">Ending Value</th>
										<th class="no_border">Risk Percentage</th>
										<th class="no_border">Risk Assessment</th>									
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>														
							</div>																																
					</div>

					

					<div class="row px-3 pt-2">
						<div class="col-md-12">
							<h5  class="print-title-color"> Parasympathetic – Details </h5>
						</div>						
					</div>

					<div class="row px-3">	
						<table id="para1-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Valsalva Ratio </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="para2-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9">K30 / 15 </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="para3-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> E / I Ratio </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>

					<div class="row px-3 pt-5">
						<div class="col-md-12">
							<h5 class="print-title-color">Overall Galvanic Skin Response</h5>
						</div>						
					</div>


					<div class="row px-3">			
								<div class="col-md-3 blue-border">
									<label class="col-form-label report_sub_title"><h6 class="mb-0"> Galvanic Skin Response</h6> </label>
									<div class="row">
										@if($patient->placemaker == "1")
										<div class="form-control text-center  no-border  pt-3 pb-3 canvas_container_overall" style="background-color:#d3d3d3;">
										@else
										<div class="form-control text-center  no-border  pt-3 pb-3 canvas_container_overall" id="div-preview3">
										@endif																		
											<div id="preview">												
												<img width="100%" height="100%" id="image-gsr" ></canvas>
											</div>
											<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 4 &nbsp  100% </div>  </div> -->
											<div id="preview-textfield3" class="reset" style="display:none;">1,250</div>
											<div class="reset"> {{$skin[0]}} </div>											
											@if($patient->placemaker == "1")										
												<div id="status3" class="status red-color">  Disabled </div>
											@else
												<div id="status3" class="status {{$skin[3]}}"> {{$skin[2]}}</div>
											@endif
											
											
										</div>
									</div>							
								</div>	
								
								
								
								<div class="col-md-9 mt-1">
									<table id="gsr-table" class="text-center" width="100%" style="border:1px solid black;">
										<thead>
										<tr>
											<th class="no_border">Beginning Value</th>
											<th class="no_border">Ending Value</th>
											<th class="no_border">Risk Percentage</th>
											<th class="no_border">Risk Assessment</th>									
										</tr>
										</thead>
										<tbody>
										</tbody>
									</table>														
								</div>																																
						</div>
						<div class="row px-3 pt-2">
							<div class="col-md-12">
								<h5 class="print-title-color"> Galvanic Skin Response – Details </h5>
							</div>						
						</div>

						<div class="row px-3">	
							<table id="gsr1-table" class="text-center" width="100%" style="border: 1px solid black;">
								<thead>
									<tr>
										<th colspan="2" bgColor="#d9d9d9"> Galvanic Skin Response - Hands </th>								
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>		
						</div>
						<div class="row px-3 pt-3">	
							<table id="gsr2-table" class="text-center" width="100%" style="border: 1px solid black;">
								<thead>
									<tr>
										<th colspan="2" bgColor="#d9d9d9">Galvanic Skin Response – Feet </th>								
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>		
						</div>

		</div>


		<!-- page 5 -->
		<div class="pagebreak"> </div>
		<div class="padding">
				<div class="page-title padding pb-0 text-center">		
					<img class='menu_icon' />										
					<h5>Healthcare Professional Autonomic Nervous System Results</h5>			
				</div>

				<div class="row px-3 pt-4">
					<div class="col-md-12">
						<h5  class="print-title-color">Overall ANS Dysfunction</h5>
					</div>						
				</div>


				<div class="row px-3">
				
							<div class="col-md-3 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">ANS Dysfunction</h6> </label>
								<div class="row">
									<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall" id="div-preview5">
										
										<div id="preview">											
											<img width="100%" height="100%" id="image-ans" ></canvas>					
										</div>
										<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 18   100% </div>  </div>										 -->
										<div id="preview-textfield5" class="reset" style="display:none;">1,250</div>
										<div class="reset">{{ $ans_dysfunction_risk_score }}</div>
										<div id="status5" class="status {{$ans_dysfunction_risk_color}}">{{$ans_dysfunction_risk_name}}</div>
									</div>					
								</div>							
							</div>															
							
							<div class="col-md-9 mt-1">
								<table id="ans-table" class="text-center" width="100%" style="border:1px solid black;">
									<thead>
									<tr>
										<th class="no_border">Beginning Value</th>
										<th class="no_border">Ending Value</th>
										<th class="no_border">Risk Percentage</th>
										<th class="no_border">Risk Assessment</th>									
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>														
							</div>																																
					</div>

					

					<div class="row px-3 pt-2">
						<div class="col-md-12">
							<h5  class="print-title-color"> ANS Dysfunction – Details </h5>
						</div>						
					</div>

					<div class="row px-3">	
						<table id="ans1-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Heart Rate – Baseline </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="ans2-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Standard Deviation RR Interval </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="ans3-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Root Mean Square – Successive Difference (RMSSD) </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="ans4-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> RR Interval – Baseline </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="ans5-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> pNN50 – Baseline </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="ans6-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Pulse Oximeter - Baseline </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
		</div>


	<!-- page 6 -->
	<div class="pagebreak"> </div>
		<div class="padding">
				<div class="page-title padding pb-0 text-center">		
					<img class='menu_icon' />										
					<h5>Healthcare Professional Autonomic Nervous System Results</h5>			
				</div>

				<div class="row px-3 pt-4">
					<div class="col-md-12">
						<h5  class="print-title-color">Overall Adrenergic Sympathetic</h5>
					</div>						
				</div>


				<div class="row px-3">
								
							<div class="col-md-3 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">Adrenergic Sympathetic</h6> </label>
								<div class="row">
									<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall" id="div-preview6">
										
										<div id="preview">
											<img width="100%" height="100%" id="image-adr" ></canvas>
										</div>
										<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 35   100% </div>  </div> -->
										<div id="preview-textfield6" class="reset" style="display:none;">1,250</div>
										<div class="reset">{{$adrenergic[0]}}</div>
										<div id="status6" class="status {{$adrenergic[3]}}">{{$adrenergic[2]}}</div>

									</div>
								</div>														
							</div>	
																												
							
							<div class="col-md-9 mt-1">
								<table id="adr-table" class="text-center" width="100%" style="border:1px solid black;">
									<thead>
									<tr>
										<th class="no_border">Beginning Value</th>
										<th class="no_border">Ending Value</th>
										<th class="no_border">Risk Percentage</th>
										<th class="no_border">Risk Assessment</th>									
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>														
							</div>																																
					</div>

					

					<div class="row px-3 pt-2">
						<div class="col-md-12">
							<h5  class="print-title-color"> Adrenergic Sympathetic – Details </h5>
						</div>						
					</div>

					<div class="row px-3">	
						<table id="adr1-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Systolic Pressure – Baseline </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="adr2-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Diastolic Pressure – Baseline </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="adr3-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Systolic Pressure – Standing </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="adr4-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Diastolic Pressure – Standing </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="adr5-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Blood Pressure Valsalva Response </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="adr6-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Systolic Pressure – Standing Response </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="adr7-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Diastolic Pressure – Standing Response </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>

		</div>




		<!-- page 7 -->
		<div class="pagebreak"> </div>
		<div class="padding">
				<div class="page-title padding pb-0 text-center">		
					<img class='menu_icon' />										
					<h5>Healthcare Professional Autonomic Nervous System Results</h5>			
				</div>

				<div class="row px-3 pt-4">
					<div class="col-md-12">
						<h5  class="print-title-color">Overall Cardiac Autonomic Neuropathy</h5>
					</div>						
				</div>


				<div class="row px-3">
								

							<div class="col-md-3 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">Cardiac Autonomic Neuropathy</h6> </label>
								<div class="row">
									<div class="form-control text-center no-border  pt-3 pb-3 canvas_container_overall" id="div-preview8">
										
										<div id="preview">											
											<img width="100%" height="100%" id="image-card" ></canvas>
										</div>
										<!-- <div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 18            100% </div>  </div> -->
										<div id="preview-textfield8" class="reset" style="display:none;">1,250</div>
										<div class="reset">{{$card[0]}}</div>
										<div id="status8" class="status {{$card[3]}}">{{$card[2]}}</div>
									</div>
								</div>							
							</div>

							
																												
							
							<div class="col-md-9 mt-1">
								<table id="card-table" class="text-center" width="100%" style="border:1px solid black;">
									<thead>
									<tr>
										<th class="no_border">Beginning Value</th>
										<th class="no_border">Ending Value</th>
										<th class="no_border">Risk Percentage</th>
										<th class="no_border">Risk Assessment</th>									
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>														
							</div>																																
					</div>

					

					<div class="row px-3 pt-2">
						<div class="col-md-12">
							<h5  class="print-title-color"> Cardiac Autonomic Neuropathy – Details </h5>
						</div>						
					</div>

					<div class="row px-3">	
						<table id="card1-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> RR Interval – Baseline </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="card2-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Valsalva Ratio </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="card3-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> K30 / 15 </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="card4-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Systolic Pressure – Standing Response </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="card5-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Diastolic Pressure – Standing Response </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>
					<div class="row px-3 pt-3">	
						<table id="card6-table" class="text-center" width="100%" style="border: 1px solid black;">
							<thead>
								<tr>
									<th colspan="2" bgColor="#d9d9d9"> Blood Pressure Response to Sustained Hand Grip  </th>								
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>		
					</div>					

		</div>




		<div class="pagebreak"> </div>
		<div class="padding">
				<div class="page-title padding pb-0 text-center">		
					<img class='menu_icon' />										
					<h5>Healthcare Professional Autonomic Nervous System Results</h5>			
				</div>

				<div class="row px-3 pt-4">
					<div class="col-md-12">
						<h5  class="print-title-color">Healthcare Professional’s Post Test Notes and Recommendations</h5>
					</div>						
				</div>

				<div class="row px-3 pt-4">
				<div class="col-md-12">
					<!-- <label>Healthcare Professional Notes</label> -->
					<textarea class="form-control" name="notes" rows="12" data-minwords="6" required="" placeholder="Type your message" required> {{$allocation->notes}} </textarea>					
				</div>
				</div>
				

		</div>
	





	</div>

</div>






<div id="bmi_info" class="modal" data-backdrop="true" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title">BMI Information</h5>
		</div>
		<div class="modal-body text-center p-lg">
				
		<div class="padding" style="text-align:left;">
			<h2 class="text-md mb-1">What is BMI?</h2>			
			<p>BMI is a person’s weight in kilograms divided by the square of height in meters. BMI does not measure body fat directly, but research has shown that BMI is moderately correlated with more direct measures of body fat obtained from skinfold thickness measurements, bioelectrical impedance, densitometry (underwater weighing), dual energy x-ray absorptiometry (DXA) and other methods 1,2,3. Furthermore, BMI appears to be as strongly correlated with various metabolic and disease outcome as are these more direct measures of body fatness 4,5,6,7,8,9. In general, BMI is an inexpensive and easy-to-perform method of screening for weight category, for example underweight, normal or healthy weight, overweight, and obesity.</p>
			
			<h2 class="text-md mb-1 mt-2">How is BMI used?</h2>			
			<p>A high BMI can be an indicator of high body fatness. BMI can be used as a screening tool but is not diagnostic of the body fatness or health of an individual.
			To determine if a high BMI is a health risk, a healthcare provider would need to perform further assessments. These assessments might include skinfold thickness measurements, evaluations of diet, physical activity, family history, and other appropriate health screenings10.</p>

			<h2 class="text-md mb-1 mt-2">What are the BMI trends for adults in the United States?</h2>			
			<p>The prevalence of adult BMI greater than or equal to 30 kg/m2 (obese status) has greatly increased since the 1970s. Recently, however, this trend has leveled off, except for older women. Obesity has continued to increase in adult women who are age 60 years and older.
			To learn more about the trends of adult obesity, visit Adult Obesity Facts.</p>

			<h2 class="text-md mb-1 mt-2">Why is BMI used to measure overweight and obesity?</h2>
			<p>BMI can be used for population assessment of overweight and obesity. Because calculation requires only height and weight, it is inexpensive and easy to use for clinicians and for the general public. BMI can be used as a screening tool for body fatness but is not diagnostic.
			To see the formula based on either kilograms and meters or pounds and inches, visit How is BMI calculated?</p>

		
			<h2 class="text-md mb-1 mt-2">What are some of the other ways to assess excess body fatness besides BMI?</h2>
			<p>Other methods to measure body fatness include skinfold thickness measurements (with calipers), underwater weighing, bioelectrical impedance, dual-energy x-ray absorptiometry (DXA), and isotope dilution 1,2,3. However, these methods are not always readily available, and they are either expensive or need to be conducted by highly trained personnel. Furthermore, many of these methods can be difficult to standardize across observers or machines, complicating comparisons across studies and time periods.</p>
		</div>
		
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-white" data-dismiss="modal">No</button>
		<button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
		</div>
	</div><!-- /.modal-content -->
	</div>
</div>



<form id="diabetForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/diabetreport') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
	<input type="hidden" id="" value="{{$page_type}}"  name="page_type"/>

</form>

<form id="bloodPressureForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/BloodPressureReport') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
	<input type="hidden" id="" value="{{$page_type}}"  name="page_type"/>
</form>

<form id="skinForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/skin') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
	<input type="hidden" id="" value="{{$page_type}}"  name="page_type"/>
</form>

<form id="ansForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/ans') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
	<input type="hidden" id="" value="{{$page_type}}"  name="page_type"/>
</form>

<form id="adrenergicForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/adrenergic') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
	<input type="hidden" id="" value="{{$page_type}}"  name="page_type"/>
</form>

<form id="paraForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/para') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
	<input type="hidden" id="" value="{{$page_type}}"  name="page_type"/>
</form>

<form id="cardiacForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/cardiac') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
	<input type="hidden" id="" value="{{$page_type}}"  name="page_type"/>
</form>


@stop



@section('script')

<script type="text/javascript" src="{{ asset('assets/prettify.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jscolor.js') }}"></script>
<script src="{{ asset('assets/fd-slider/fd-slider.js') }}" ></script>
<script src="{{ asset('dist/gauge.js') }}"></script>

<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> -->


<script type="text/javascript">   
  	
	var isClickable = false;
    $(document).ready(function() {

		$(".btn-notes").on('click', function(){
			var allocation_id = $("#allocation_id").val();
			window.location.href ="http://" +  window.location.host + "/phd/report/note/" + allocation_id;
		});

		$(".btn-print").on('click', function(){
			if(isClickable){
				$(".print-btn").removeAttr("disabled");						
				var dataUrl = document.getElementById('canvas-preview1').toDataURL();
				//document.getElementById("overall_print").innerHTML =  "<br><img src='" + dataUrl  + "'/>"; //document.getElementById("overall").innerHTML;			
				initTypeIITable(1);
				initTypeIITable(2);
				initTypeIITable(3);
				initTypeIITable(4);
				initTypeIITable(5);
				initTypeIITable(6);
				initTypeIITable(7);
				$.ajax({
					url: '{{ route('review.typeii') }}',
					type: 'POST',
					data: {
						_token: $('meta[name="csrf-token"]').attr('content'),
						allocation_id:'{{$allocation->auto_num}}',
					},
					success: function(res) {
						var result = res.results;
						if(result == 200){
							initTypeIIRiskTable(res.diabet);
							initBloodTables(res.blood.baseline, 1);
							initBloodTables(res.blood.standing, 2);
							initBloodTables(res.blood.standingRes, 3);
							initBloodTables(res.blood.valsalva, 4);
							initBloodTables(res.blood.valsalvaRes, 5);
							initBloodTables(res.blood.para, 6);

							initParaTables(res.para.VRC4, 1);
							initParaTables(res.para.VRC6, 2);
							initParaTables(res.para.EIR, 3);

							initSkinTables(res.skin.hand, 1);
							initSkinTables(res.skin.feet, 2);

							initAnsTables(res.ans.heart_rate , 1);
							initAnsTables(res.ans.SDNN , 2);
							initAnsTables(res.ans.RMSSD , 3);
							initAnsTables(res.ans.AVG_RR , 4);
							initAnsTables(res.ans.More50 , 5);
							initAnsTables(res.ans.SPO2 , 6);

							initAdrTables(res.adr.BaselineSys, 1);
							initAdrTables(res.adr.BaselineDia, 2);
							initAdrTables(res.adr.StandingSys, 3);
							initAdrTables(res.adr.StandingDia, 4);
							initAdrTables(res.adr.SPRV, 5);
							initAdrTables(res.adr.SPRS, 6);
							initAdrTables(res.adr.DPRS, 7);

							initCardTables(res.card.RR, 1);
							initCardTables(res.card.VRC4, 2);
							initCardTables(res.card.VRC6, 3);
							initCardTables(res.card.SPRS, 4);
							initCardTables(res.card.DPRS, 5);
							initCardTables(res.card.SPRS7, 6);


						}
					},
					complete: function() {
						window.print();	
					},
					error: function() {
						alert('Error: no connection is available');
						return false;
					}
				});
				
				
			}else{
				alert("loading.. try it again");
			}						
		});
		
		var diabetLabel =  {
				font: "10px sans-serif",
				labels: [0, 3, 8, 12, 20, 26],
				fractionDigits: 0
			};
		var diabetZone = [								
				{strokeStyle: "#008000", min: 0, max: 8}, // green
				{strokeStyle: "#FFFF00", min: 8, max: 12}, // yellow
				{strokeStyle: "#FFA500", min: 12, max: 20}, // orange
				{strokeStyle: "#FF0000", min: 20, max: 26} //red
			];


		var bloodPressureLabel =  {
				font: "10px sans-serif",
				labels: [0, 7, 15, 23, 30],
				fractionDigits: 0
			};
		var bloodPressureZone = [
				{strokeStyle: "#008000", min: 0, max: 7},
				{strokeStyle: "#FFFF00", min: 7, max: 15},
				{strokeStyle: "#FFA500", min: 15, max: 23},
				{strokeStyle: "#FF0000", min: 23, max: 30}
			];


		var ansDysfunctionLabel =  {
				font: "10px sans-serif",
				labels: [0, 5, 9, 14, 18],
				fractionDigits: 0
			};
		var ansDysfunctionZone = [
				{strokeStyle: "#008000", min: 0, max: 5},
				{strokeStyle: "#FFFF00", min: 5, max: 9},
				{strokeStyle: "#FFA500", min: 9, max: 14},
				{strokeStyle: "#FF0000", min: 14, max: 18}
			];


		var skinLabel =  {
				font: "10px sans-serif",
				labels: [0, 1, 2,4],
				fractionDigits: 0
			};
		var skinZones = [				
				{strokeStyle: "#008000", min: 0, max: 1},
				{strokeStyle: "#FFFF00", min: 1, max: 2},
				{strokeStyle: "#FF0000", min: 2, max: 4}
			];

		var adrenergicLabel =  {
				font: "10px sans-serif",
				labels: [0, 7, 15, 23, 30],
				fractionDigits: 0
			};
		var ardrenergicZones = [
				{strokeStyle: "#008000", min: 0, max: 7},
				{strokeStyle: "#FFFF00", min: 7, max: 15},
				{strokeStyle: "#FFA500", min: 15, max: 23},
				{strokeStyle: "#FF0000", min: 23, max: 30}
			];

		var paraLabel =  {
				font: "10px sans-serif",
				labels: [0, 1, 2, 3],
				fractionDigits: 0
			};
		var paraZones = [
				{strokeStyle: "#008000", min: 0, max: 1},
				{strokeStyle: "#FFFF00", min: 1, max: 2},		
				{strokeStyle: "#FF0000", min: 2, max: 3}
			];
		var cardLabel =  {
				font: "10px sans-serif",
				labels: [0, 4, 9, 13, 18],
				fractionDigits: 0
			};
		var cardZones = [
				{strokeStyle: "#008000", min: 0, max: 4},
				{strokeStyle: "#FFFF00", min: 4, max: 9},
				{strokeStyle: "#FFA500", min: 9, max: 13},
				{strokeStyle: "#FF0000", min: 13, max: 18}
			];

		//initZones("canvas-preview1")
		myInit("canvas-preview1", "preview-textfield1", "{{$diabet_risk_score}}" , diabetLabel, diabetZone, 26);
		myInit("canvas-preview2", "preview-textfield2", "{{$overall_blood_risk_score}}" , bloodPressureLabel, bloodPressureZone,30);
		myInit("canvas-preview3", "preview-textfield3", "{{$skin[0]}}" , skinLabel, skinZones, 4);	
		myInit("canvas-preview5", "preview-textfield5", "{{ $ans_dysfunction_risk_score}}" , ansDysfunctionLabel, ansDysfunctionZone, 18);
		myInit("canvas-preview6", "preview-textfield6", "{{ $adrenergic[0] }}" , adrenergicLabel, ardrenergicZones, 30);
		myInit("canvas-preview7", "preview-textfield7", "{{$para[0]}}" , paraLabel, paraZones,3);
		myInit("canvas-preview8", "preview-textfield8","{{$card[0]}}" , cardLabel, cardZones, 18);


		$("#div-preview1").click(function(){
			document.getElementById("diabetForm").submit();
		});
		$("#div-preview2").click(function(){
			document.getElementById("bloodPressureForm").submit();
		});
		$("#div-preview3").click(function(){
			//skin
			document.getElementById("skinForm").submit();
		});
		
		$("#div-preview5").click(function(){
			document.getElementById("ansForm").submit();
		});
		$("#div-preview6").click(function(){
			document.getElementById("adrenergicForm").submit();
		});
		$("#div-preview7").click(function(){
			document.getElementById("paraForm").submit();
		});
		$("#div-preview8").click(function(){
			document.getElementById("cardiacForm").submit();
		});	
		$("#bmi_info").click(function(){			
		});


		setTimeout(function(){
			isClickable = true;
			var canvas1 = $("#canvas-preview1")[0];
			var img1 = canvas1.toDataURL("image/png");			
			document.getElementById("image-canvas1").src = img1; 

			var canvas2 = $("#canvas-preview2")[0];
			var img2 = canvas2.toDataURL("image/png");			
			document.getElementById("image-canvas2").src = img2; 

			var canvas3 = $("#canvas-preview3")[0];
			var img3 = canvas3.toDataURL("image/png");			
			document.getElementById("image-canvas3").src = img3; 	

			var canvas5 = $("#canvas-preview5")[0];
			var img5 = canvas5.toDataURL("image/png");			
			document.getElementById("image-canvas5").src = img5; 	

			var canvas6 = $("#canvas-preview6")[0];
			var img6 = canvas6.toDataURL("image/png");			
			document.getElementById("image-canvas6").src = img6; 	

			var canvas7 = $("#canvas-preview7")[0];
			var img7 = canvas7.toDataURL("image/png");			
			document.getElementById("image-canvas7").src = img7; 	

			var canvas8 = $("#canvas-preview8")[0];
			var img8 = canvas8.toDataURL("image/png");			
			document.getElementById("image-canvas8").src = img8; 
			
			document.getElementById("image-typeii").src = img1; 
			document.getElementById("image-blood").src = img2; 
			document.getElementById("image-para").src = img7; 
			document.getElementById("image-gsr").src = img3; 
			document.getElementById("image-ans").src = img5; 
			document.getElementById("image-adr").src = img6; 
			document.getElementById("image-card").src = img8; 

		},2000);
		

		


	});
	function newPatient(){
		window.location.href = "{{ URL::to('office/addPatient') }}";
	}

	function myInit(id, text, value, staticLables, staticZones, maxValue){

		var opts = {
			angle: 0,
			lineWidth: 0.3,
			radiusScale:1,
			pointer: {
				length: 0.6,
				strokeWidth: 0.04,
				color: '#000000'
			},						
			staticLabels: staticLables,			
			staticZones: staticZones,
			limitMax: false,
			limitMin: false,
			highDpiSupport: true
		};


		if( value == 0 && id == "canvas-preview3"){
			opts = {
			angle: 0,
			lineWidth: 0.3,
			radiusScale:1,
			pointer: {
				length: 0,
				strokeWidth: 0,
				color: '#000000'
			},

			staticLabels: staticLables,			
			staticZones: staticZones,
			limitMax: false,
			limitMin: false,
			highDpiSupport: true

		};
		}
		
		var target = document.getElementById(id); // your canvas element	
		var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
		gauge.setTextField(document.getElementById(text));
		gauge.maxValue = maxValue; // set max gauge value
		gauge.setMinValue(0);  // set min value
		gauge.set(value); // set actual value
	}



	function initZones(id){
		//document.getElementById("class-code-name").innerHTML = "Gauge";
		demoGauge = new Gauge(document.getElementById(id));
		var opts = {
		angle: -0.25,
		lineWidth: 0.2,
		radiusScale:0.9,
		pointer: {
			length: 0.6,
			strokeWidth: 0.15,
			color: '#000000'
		},
		staticLabels: {
			font: "10px sans-serif",
			labels: [200, 500, 2100, 2800],
			fractionDigits: 0
		},
		staticZones: [
			{strokeStyle: "#F03E3E", min: 0, max: 200},
			{strokeStyle: "#FFDD00", min: 200, max: 500},
			{strokeStyle: "#30B32D", min: 500, max: 2100},
			{strokeStyle: "#FFDD00", min: 2100, max: 2800},
			{strokeStyle: "#F03E3E", min: 2800, max: 3000}
		],
		limitMax: false,
		limitMin: false,
		highDpiSupport: true
		};
		demoGauge.setOptions(opts);
		demoGauge.setTextField(document.getElementById("preview-textfield"));
		demoGauge.minValue = 0;
		demoGauge.maxValue = 3000;
		demoGauge.set(1250);
  	};
    


	function expandContract() {
		const el = document.getElementById("expand-contract")
		el.classList.toggle('expanded')
		el.classList.toggle('collapsed')

		if($('#expand-contract').is('.expanded:not(.show)')) {  // expanded
    		// do collapse
			$('#icon_plus').addClass('i-con-minus').removeClass('i-con-plus');
		}else{
			$('#icon_plus').addClass('i-con-plus').removeClass('i-con-minus');			
		}
	}	




</script>

@stop
