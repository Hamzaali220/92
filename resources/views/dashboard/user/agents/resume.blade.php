@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
@stop
@section('title', 'Resume')
@section('content')
<?php  $topmenu='Profile'; ?>
<?php $activemenu = 'resume'; ?>
@include('dashboard.include.sidebar')
<!--=== Profile ===-->
<div class="container content profile">
	<div class="row">
		<!--Left Sidebar-->
		@include('dashboard.user.agents.include.sidebar')
		@include('dashboard.user.agents.include.sidebar-profile')
		<!--End Left Sidebar-->
		
		<!-- Profile Content -->
		<div class="col-md-9">
			@if($segment[2] == "personal")
			<h2><b>Personal Biodata Update</b></h2>
			<div class="box-shadow-profile ">
				<!-- Default Proposals -->
				<div class="panel-profile">
					<div class="panel-heading overflow-h air-card">
						<!--<h2 class="heading-sm pull-left"> Personal Biodata {{ucfirst($user->email)}}</h2>-->
					</div>

					<div class="tab-v2">
						<div class="tab-content">
							<div id="Personal" class="profile-edit">
								<div class="message-Personal"> </div>
								<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
								{!! Form::open(array('class'=>'sky-form','id'=>'edit-personal-bio','enctype'=>'multipart/form-data')) !!}	
								<dl class="dl-horizontal">
									<dt class="resumelable"><strong>Office address<span class="mandatory">*</span></strong></dt>
									<dd class="resumefileds office_address" key=""  title="office address">
										<label class="input">
											<input type="text" id="office_address" name="office_address" value="{{ $userdetails->office_address }}" data-toggle="tooltip" data-placement="top" placeholder="office address">
											<b class="error-text" id="office_address_error"></b>
										</label>
									</dd>
									<hr>

									<dt class="resumelable"><strong>State <span class="mandatory">*</span> </strong> </dt>
									<dd class="resumefileds state_id"  title="State" class="text-left">
										<label class="select text-left">
											<select id="state" name="state_id" class="multipalselecte" placeholder="Select State" class="text-left">
												<option value="" class="text-left">Select State</option>
											</select>
											<b class="error-text" id="state_id_error"></b>
										</label>
									</dd>
									<hr>

									<dt class="resumelable"><strong>City<span class="mandatory">*</span> </strong></dt>
									<dd class="resumefileds city_id"  title="City">
										<label class="select">

											<select id="city" name="city_id" class="" placeholder="Select City">
												<option value="">Select City</option>
												<!-- <option selected>{{$userdetails->State->state_name}}</option> -->
											</select>
											<b class="error-text" id="city_id_error"></b>
										</label>
									</dd>
									<hr>
								
									<dt class="resumelable"><strong>Zip code </strong></dt>
									<dd class="resumefileds zip_code" key="{{ $userdetails->zip_code }}" id="zip_code" title="Zip code">
										<label class="input">
											<i class="icon-append fa fa-plus zip_code_add_new"></i>
											<div class="zip_code_append_new">
												@if($userdetails->zip_code)
												@foreach(explode(',',$userdetails->zip_code) as $zip)
												<input type="text" name="zip_code[]" maxlength="5" value="{{ $zip }}" placeholder="Zip code">
												@endforeach
												@else
												<input type="text" name="zip_code[]" maxlength="5" value="" placeholder="Zip code">
												@endif
											</div>
										</label>

									</dd>
									<hr>

									<dt class="resumelable"><strong>License no.<span class="mandatory">*</span></strong></dt>
									<dd class="resumefileds licence_number" key=""  title="License no.">
										<label class="input">
											<input type="text" id="licence_number" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;"
											onpaste="return false;" name="licence_number" value="{{ $userdetails->licence_number }}"  
											data-toggle="tooltip" data-placement="top" placeholder="Licence Number">
											<b class="error-text" id="licence_number_error"></b>
										</label>
									</dd>
									<hr>
									<dt class="resumelable"><strong>Franchise / Affiliation </strong></dt>
									<dd class="resumefileds franchise_id" key=""  title="Franchise">
										<label class="select">
											<select id="franchise" name="franchise" placeholder="Select franchise">
												<option value="">Select Franchise / Affiliation</option>
												<option value="other">Other</option>

											</select>
											<b class="error-text" id="franchise_error"></b>
										</label>
									</dd>
								</dd>
								<hr>
								<div class="other_franchise_show hide">
									<dt class="resumelable"><strong> Other Franchise</strong></dt>
									<dd class="resumefileds other_franchise" key=""  title="Other Franchise">
										<label class="input">
											<input type="text" id="other_franchise" name="other_franchise" value="{{ $userdetails->other_franchise }}" data-toggle="tooltip" data-placement="top" placeholder="Other Franchise">
											<b class="error-text" id="other_franchise_error"></b>
										</label>
									</dd>
									<hr>
								</div>
								<dt class="resumelable"><strong>Company name</strong></dt>
								<dd class="resumefileds company_name" key=""  title="Company name">
									<label class="input">
										<input type="text" id="company_name" name="company_name" value="{{ $userdetails->company_name }}" data-toggle="tooltip" data-placement="top" placeholder="Company name">
										<b class="error-text" id="company_name_error"></b>
									</label>
								</dd>
								<hr>

								<dt class="resumelable"><strong>Years of experience<span class="mandatory">*</span> </strong></dt>
								<dd class="resumefileds years_of_expreience" key=""  title="Years of experience">
									<label class="select">
										<select id="years_of_expreience" name="years_of_expreience" placeholder="Select years_of_expreience">
											<option value="">Select Years of experience</option>
											<option value="< 1" >< 1</option>
											<option value="1 - 5" > 1 - 5 </option>
											<option value="5 -10" > 5 -10 </option>
											<option value="greater than 10" > greater than 10 </option>
										</select>
										<b class="error-text" id="years_of_expreience_error"></b>
									</label>
								</dd>
								<hr>
								<dt class="resumelable"><strong>Fax no.</strong></dt>
								<dd class="resumefileds fax_no" key="" title="fax no.">
									<label class="input">
										<input type="text" id="fax_no" name="fax_no" value="{{ $userdetails->fax_no }}" data-toggle="tooltip" data-placement="top" placeholder="fax no.">
										<b class="error-text" id="fax_no_error"></b>
									</label>
								</dd>
								<hr>

								<dt class="resumelable"><strong>Brokers name<span class="mandatory">*</span></strong></dt>
								<dd class="resumefileds brokers_name" key="" title="Brokers name">
									<label class="input">
										<input type="text" id="brokers_name" name="brokers_name" value="{{ $userdetails->brokers_name }}"  data-toggle="tooltip" data-placement="top" placeholder="Brokers name">
										<b class="error-text" id="brokers_name_error"></b>
									</label>
								</dd>
								<hr>

								<dt class="resumelable"><strong>MLS public id</strong></dt>
								<dd class="resumefileds MLS_public_id" key=""  title="MLS public id">
									<label class="input">
										<input type="text" id="MLS_public_id" name="MLS_public_id" value="{{ $userdetails->MLS_public_id }}" data-toggle="tooltip" data-placement="top" placeholder="MLS public id">
										<b class="error-text" id="MLS_public_id_error"></b>
									</label>
								</dd>
								<hr>

								<dt class="resumelable"><strong>MLS office id</strong></dt>
								<dd class="resumefileds MLS_office_id" key=""  title="MLS office id">
									<label class="input">
										<input type="text" id="MLS_office_id" name="MLS_office_id" value="{{ $userdetails->MLS_office_id }}" data-toggle="tooltip" data-placement="top" placeholder="MLS office id">
										<b class="error-text" id="MLS_office_id_error"></b>
									</label>
								</dd>
								
								<hr>
								@if($userdetails->contract_verification == 0)
								<a href="/downloadContract" class="" id="download_contract"><p class="red">“Please download the contract, sign it and upload it back. Without the contract you cannot meet buyers or sellers ”</p></a>
								@elseif($userdetails->contract_verification == 2)
                                 <a class="" id="download_contract"><p class="red">“Your contract document is already verified.”</p></a>
                                 @else
                                 <a  class="" id="download_contract"><p class="red">“Your contract document is under processing.”</p></a>
								@endif
								<dt class="resumelable"><strong>Statement document <br> physically sign.pdf  <br> upload the signed PDF <span class="mandatory">*</span></strong></dt>
								<dd class="resumefileds statement_document" key=""  title="Statement document">
									<label for="file" class="input input-file">
										<div class="button">
											@if($userdetails->contract_verification == 0)
											<input type="file" id="statement_document" name="statement_document" multiple onchange="this.parentNode.nextSibling.value = this.value.replace(/^.*\\/, '')" accept=".pdf"> Upload </div><input type="text" placeholder="Only pdf file upload with your physically sign" readonly>
											@else
											 Upload </div><input type="text" placeholder="Only pdf file upload with your physically sign" readonly>
											@endif
									</label>
									
									@if($userdetails->statement_document !='')
									<iframe src="{{ $userdetails->statement_document }}" width="200" height="150"></iframe>
									@endif
									<b class="error-text" id="statement_document_error"></b>
								</dd>
                                 
                                 <input type="hidden" name="statement_document_c" value="{{ $userdetails->statement_document }}">
								<hr>

								<div class="form-group termc">
									<label>
										<input type="checkbox" <?php echo $userdetails->terms_and_conditions==1 ? 'checked' : ''; ?>  name="terms_and_conditions" value="1">
										I have read <a href="/terms" target="_blanck" class="sitegreen">Terms and Conditions<span class="mandatory">*</span></a>
										<b class="error-text" id="terms_and_conditions_error"></b>
										<br>
									</label>
								</div>
								<hr>

							</dl>
							<div class="message-Professional"> </div>
							<input type="hidden" name="id" value="{{$user->id}}">
							<button class="btn-u" type="submit">Update</button>
							{!!Form::close()!!}
						</div>
					</div>
				</div>						
			</div>
			<!-- Default Proposals -->
		</div>
		@endif
		@if($segment[2] == "professional")
		<h2><b>Professional Biodata Update</b></h2>
		<div class="box-shadow-profile ">
			<!-- Default Proposals -->
			<div class="panel-profile">
				<div class="panel-heading overflow-h air-card">
					<h2 class="heading-sm pull-left"> Professional Biodata </h2>
				</div>

				<div class="tab-v2">
					<div class="tab-content">
						<div id="settings" class="profile-edit">
							<div class="message-Professional-profile"> </div>
							<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
							{!! Form::open(array('class'=>'sky-form','id'=>'edit-professional-bio')) !!}	
							<dl class="dl-horizontal">
								<dt class="resumelable"><strong>Real Estate Education<span class="mandatory">*</span>  </strong></dt>
								<dd class="resumefileds append-real-estate-education" title="Real Estate Education">
									<p><i class="add-Education fa fa-plus pull-right margin">Add</i></p>
									@if(!empty($userdetails->real_estate_education))
									<?php $real = 1; ?>
									@foreach(json_decode($userdetails->real_estate_education) as $real_estate_education)
									<div class="group col-xs-12 group-education-{{$real}} education" title="group-education-{{$real}}">
										@if($real != 1)
										<h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-education-{{$real}}"></i></h3>
										@endif
										<div class=" col-md-6"><label>Degree<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" value="{{ $real_estate_education->degree }}" class="form-control"  value="" name="degree[]" />
											<b class="error-text" id="degree_error"></b>
										</div>
										<div class=" col-md-6"><label >School/College<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" value="{{ $real_estate_education->school }}" class="form-control"  value="" name="school[]" />
											<b class="error-text" id="school_error"></b>
										</div>
										<div class=" col-md-6"><label >Select From Date<span class="mandatory">*</span></label>
											<label class="select">
												<select name="educationfrom[]" placeholder="Select From">
													<option value="">Select From Date</option>
													@for($i=date('Y'); $i>1990; $i--)
													<option value="{{$i}}" {{ $real_estate_education->from==$i ? 'selected' : '' }}>{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="educationfrom_error"></b>
											</label>
										</div>
										<div class=" col-md-6"><label>Select To Date<span class="mandatory">*</span></label>
											<label class="select">
												<select name="educationto[]" placeholder="Select To">
													<option value="">Select To Date</option>
													@for($i=date('Y',strtotime('+5 year')); $i>1990; $i--)
													<option value="{{$i}}" {{ $real_estate_education->to==$i ? 'selected' : ''}} >{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="educationto_error"></b>
											</label>
										</div>

										<div class=" col-md-12"><label>Description<span class="mandatory">*</span></label>
											<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control jqte-test"  name="educationdescription[]">{{ $real_estate_education->description }}</textarea>
											<b class="error-text" id="educationdescription_error"></b>
										</div>
									</div>
									<?php $real++; ?>
									@endforeach
									@else
									<div class="group col-xs-12 group-education-1 education" title="group-education-1">
										<!-- <h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-education-1"></i></h3> -->
										<div class=" col-md-6"><label>Degree<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="degree[]" />
											<b class="error-text" id="degree_error"></b>
										</div>
										<div class=" col-md-6"><label >School/College<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="school[]" />
											<b class="error-text" id="school_error"></b>
										</div>
										<div class=" col-md-6"><label >Select From Date<span class="mandatory">*</span></label>
											<label class="select">
												<select name="educationfrom[]" placeholder="Select From">
													<option value="">Select From Date</option>
													@for($i=date('Y'); $i>1990; $i--)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="educationfrom_error"></b>
											</label>
										</div>
										<div class=" col-md-6"><label>Select To Date<span class="mandatory">*</span></label>
											<label class="select">
												<select name="educationto[]" placeholder="Select To Date">
													<option value="">Select To Date</option>
													@for($i=date('Y',strtotime('+5 year')); $i>1990; $i--)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="educationto_error"></b>
											</label>
										</div>

										<div class=" col-md-12"><label>Description<span class="mandatory">*</span></label>
											<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control jqte-test"  name="educationdescription[]"></textarea>
											<b class="error-text" id="educationdescription_error"></b>
										</div>
									</div>
									@endif
								</dd>
								<hr>
								<dt class="resumelable"><strong>Certifications<span class="mandatory">*</span> </strong></dt>
								<dd class="resumefileds certifications" title="certifications">
									<label class="select">
										<select id="certifications"  name="certifications[]" class="multipalselecte" multiple="" placeholder="Select Certifications">
											<option value="" disabled="">Select Certifications</option>

										</select>
										<b class="error-text" id="certifications_error"></b>
									</label>
								</dd>
								<hr>
								<dt class="resumelable"><strong>Specialization<span class="mandatory">*</span> </strong></dt>
								<dd class="resumefileds specialization_id" title="specialization id">
									<label class="select">
										<select id="specialization" name="specialization[]" class="multipalselecte" multiple="" placeholder="Select specialization">
											<option value="" disabled="">Select Specialization</option>
										</select>
										<b class="error-text" id="specialization_error"></b>
									</label>
								</dd>
								<hr>
								<dt class="resumelable "><strong>Industry Experience<span class="mandatory">*</span>  </strong></dt>
								<dd class="resumefileds industry_experience">
									<p><i class="add-Experience fa fa-plus pull-right margin">Add</i></p>
									@if(!empty($userdetails->industry_experience))
									<?php $indus=1; ?>
									@foreach(json_decode($userdetails->industry_experience) as $industry_experience)
									<div class="group col-xs-12 group-experience-{{$indus}} experience" title="group-experience-{{$indus}}">
										@if($indus != 1)
										<h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-experience-{{$indus}}"></i></h3>
										@endif
										<div class=" col-md-6"><label>Title<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{ $industry_experience->post }}" name="post[]" />
											<b class="error-text" id="post_error"></b>
										</div>
										<div class=" col-md-6"><label >Company<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{ $industry_experience->organization }}" name="organization[]" />
											<b class="error-text" id="organization_error"></b>
										</div>
										<div class=" col-md-6"><label >Select From Date<span class="mandatory">*</span></label>
											<label class="select">
												<select name="experiencefrom[]" placeholder="Select From">
													<option value="">Select From Date</option>
													<option value="currently_work" {{ $industry_experience->from == 'currently_work' ? 'selected' : '' }}>Currently Work</option>
													@for($i=date('Y'); $i>1990; $i--)
													<option value="{{$i}}" {{ $industry_experience->from==$i ? 'selected' : '' }}>{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="experiencefrom_error"></b>
											</label>
										</div>
										<div class=" col-md-6"><label>Select To Date<span class="mandatory">*</span></label>
											<label class="select">
												<select name="experienceto[]" placeholder="Select To Date">
													<option value="">Select To Date</option>
													<option value="currently_work" {{ $industry_experience->to == 'currently_work' ? 'selected' : '' }}>Currently Work</option>
													@for($i=date('Y'); $i>1990; $i--)
													<option value="{{$i}}" {{ $industry_experience->to==$i ? 'selected' : '' }}>{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="experienceto_error"></b>
											</label>
										</div>
										<div class=" col-md-12"><label>Description<span class="mandatory">*</span></label>
											<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control jqte-test"  name="experiencedescription[]">{{ $industry_experience->description }}</textarea>
											<b class="error-text" id="experiencedescription_error"></b>
										</div>
									</div>
									<?php $indus++; ?>
									@endforeach
									@else
									<div class="group col-xs-12 group-experience-1 experience" title="group-experience-1">
										<!-- <h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-experience-1"></i></h3> -->
										<div class=" col-md-6"><label>Title<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="post[]" />
											<b class="error-text" id="post_error"></b>
										</div>
										<div class=" col-md-6"><label >Company<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="organization[]" />
											<b class="error-text" id="organization_error"></b>
										</div>
										<div class=" col-md-6"><label >Select From Date<span class="mandatory">*</span></label>
											<label class="select">
												<select name="experiencefrom[]" placeholder="Select From">
													<option value="">Select From Date</option>
													<option value="currently_work">Currently Work</option>
													@for($i=date('Y'); $i>1990; $i--)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="experiencefrom_error"></b>
											</label>
										</div>
										<div class=" col-md-6"><label>Select To Date<span class="mandatory">*</span></label>
											<label class="select">
												<select name="experienceto[]" placeholder="Select To Date">
													<option value="">Select To Date</option>
													<option value="currently_work">Currently Work</option>
													@for($i=date('Y'); $i>1990; $i--)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="experienceto_error"></b>
											</label>
										</div>
										<div class=" col-md-12"><label>Description<span class="mandatory">*</span></label>
											<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control"  name="experiencedescription[]"></textarea>
											<b class="error-text" id="experiencedescription_error"></b>
										</div>
									</div>
									@endif
								</dd>
								<hr>

								<dd class="resumefileds">
									<label class="toggle"><input type="checkbox" {{ $userdetails->show_individual_yearly_figures==1 ? "checked" : '' }}  name="show_individual_yearly_figures" class="show_individual_yearly_figures"><i class="no-rounded"></i>Show individual yearly figures<span class="mandatory">*</span></label>
									<b class="error-text" id="show_individual_yearly_figures_error"></b>
								</dd>
								<dt class="resumelable"><strong>Sales history<span class="mandatory">*</span>  </strong></dt>
								<dd class="resumefileds sales_history">
									<p><i class="add-Sales-history fa fa-plus pull-right margin"> Add</i></p>
									@if(!empty($userdetails->sales_history) && $userdetails->sales_history != null && $userdetails->sales_history != [])
									<?php $ales=1; ?>
									@foreach(json_decode($userdetails->sales_history) as $sales_history)
									<div class="group col-xs-12 group-sales_history-{{$ales}} sales" title="group-sales_history-{{$ales}}">
										@if($ales != 1)
										<h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-sales_history-{{$ales}}"></i></h3>
										@endif
										<div class=" col-md-12"><label>Year<span class="mandatory">*</span></label>
											<label class="select">
												<select name="year[]" placeholder="Select Year">
													<option value="">Select Year</option>
													@for($i=date('Y'); $i>date('Y',strtotime('-20 year')); $i--)
													<option value="{{$i}}" {{ $sales_history->year==$i ? 'selected' : '' }}>{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="year_error"></b>
											</label>
										</div>
										<div class=" col-md-6"><label >Sellers Represented<span class="mandatory">*</span></label>
											<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{$sales_history->sellers_represented}}" name="sellers_represented[]" />
											<b class="error-text" id="sellers_represented_error"></b>
										</div>
										<div class=" col-md-6"><label >Buyers Represented<span class="mandatory">*</span></label>
											<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{$sales_history->buyers_represented}}" name="buyers_represented[]" />
											<b class="error-text" id="buyers_represented_error"></b>
										</div>
										<div class=" col-md-12"><label>Total Dollar Sales<span class="mandatory">*</span></label>
											<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{$sales_history->total_dollar_sales}}" name="total_dollar_sales[]" />
											<b class="error-text" id="total_dollar_sales_error"></b>
										</div>
									</div>
									<?php $indus++; ?>
									@endforeach
									@else
									<div class="group col-xs-12 group-sales_history-1 sales" title="group-sales_history-1">
										<!-- <h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-sales_history-1"></i></h3> -->
										<div class=" col-md-12"><label>Year<span class="mandatory">*</span></label>
											<label class="select">
												<select name="year[]" placeholder="Select Year">
													<option value="">Select Year</option>
													@for($i=date('Y'); $i>date('Y',strtotime('-20 year')); $i--)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
												<b class="error-text" id="year_error"></b>
											</label>
										</div>
										<div class=" col-md-6"><label >Sellers Represented<span class="mandatory">*</span></label>
											<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="sellers_represented[]" />
											<b class="error-text" id="sellers_represented_error"></b>
										</div>
										<div class=" col-md-6"><label >Buyers Represented<span class="mandatory">*</span></label>
											<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="buyers_represented[]" />
											<b class="error-text" id="buyers_represented_error"></b>
										</div>
										<div class=" col-md-12"><label>Total Dollar Sales<span class="mandatory">*</span></label>
											<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="total_dollar_sales[]" />
											<b class="error-text" id="total_dollar_sales_error"></b>
										</div>
									</div>
									@endif
								</dd>
								<hr>

								<dt class="resumelable"><strong>Associations & Awards</strong></dt>
								<dd class="resumefileds associations_awards" id="associations_awards" title="associations awards">
									<label class="input">
										<i class="icon-append fa fa-plus associations_awards_add"></i>
										<div class="associations_awards_pluse">
											@if($userdetails->associations_awards)
											@foreach(explode(',==,',$userdetails->associations_awards) as $awardd)
											<input type="text" name="associations_awards[]" value="{{ $awardd }}" placeholder="Associations Awards">
											@endforeach
											@else
											<input type="text" name="associations_awards[]" value="" placeholder="Associations Awards">
											@endif
										</div>
									</label>
								</dd>
								<hr>

								<dt class="resumelable"><strong>Publications</strong></dt>
								<dd class="resumefileds publications" id="publications" title="associations awards">
									<label class="input">
										<i class="icon-append fa fa-plus publications_add"></i>
										<div class="publications_pluse">
											@if($userdetails->publications)
											@foreach(explode(',==,',$userdetails->publications) as $public)
											<input type="text" name="publications[]" value="{{ $public }}" placeholder="Publications">
											@endforeach
											@else
											<input type="text" name="publications[]" value="" placeholder="Publications">
											@endif
										</div>
									</label>
								</dd>
								<hr>

								<dt class="resumelable"><strong>Community involvement</strong></dt>
								<dd class="resumefileds community_involvement" id="community_involvement" title="associations awards">
									<label class="input">
										<i class="icon-append fa fa-plus community_involvement_add"></i>
										<div class="community_involvement_pluse">
											@if($userdetails->community_involvement)
											@foreach(explode(',==,',$userdetails->community_involvement) as $comuni)
											<input type="text" name="community_involvement[]" value="{{ $comuni }}" placeholder="community involvement">
											@endforeach
											@else
											<input type="text" name="community_involvement[]" value="" placeholder="community involvement">
											@endif
										</div>
									</label>
								</dd>
								<hr>

								<dt class="resumelable"><strong>Language Proficiency<span class="mandatory">*</span>  </strong></dt>
								<dd class="resumefileds Language_Proficiency">
									<p><i class="add-Language-Proficiency fa fa-plus pull-right margin">Add</i></p>
									@if(!empty($userdetails->language_proficiency))
									<?php $lang=1; ?>
									@foreach(json_decode($userdetails->language_proficiency) as $language_proficiency)
									<div class="group col-xs-12 group-Language-{{$lang}} Language" title="group-Language-{{$lang}}">
										@if($lang != 1)
										<h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-Language-{{$lang}}"></i></h3>
										@endif
										<div class=" col-md-3" >
											<label>language<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{$language_proficiency->language}}" name="language[]" />
											<b class="error-text" id="language_error"></b>
										</div>

										<div class=" col-md-3 select" >
											<label >speak<span class="mandatory">*</span></label>
											<!-- <input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{$language_proficiency->speak}}" name="speak[]" /> -->
											<select id="speak" name="speak[]" placeholder="Select speak">
												<option value="">Select Yes/No</option>
												<option value="Y" {{ $language_proficiency->speak=='Y' ? 'selected' : '' }}> Y </option>
												<option value="N" {{ $language_proficiency->speak=='N' ? 'selected' : '' }}> N </option>
											</select>
											<b class="error-text" id="speak_error"></b>
										</div>
										<div class=" col-md-3 select" ><label >read<span class="mandatory">*</span></label>
											<!-- <input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{$language_proficiency->read}}" name="read[]" /> -->
											<select id="read" name="read[]" placeholder="Select read">
												<option value="">Select Yes/No</option>
												<option value="Y" {{ $language_proficiency->read=='Y' ? 'selected' : '' }}> Y </option>
												<option value="N" {{ $language_proficiency->read=='N' ? 'selected' : '' }}> N </option>
											</select>
											<b class="error-text" id="read_error"></b>
										</div>
										<div class=" col-md-3 select" ><label>write<span class="mandatory">*</span></label>
											<!-- <input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="{{$language_proficiency->write}}" name="write[]" /> -->
											<select id="write" name="write[]" placeholder="Select write">
												<option value="">Select Yes/No</option>
												<option value="Y" {{ $language_proficiency->write=='Y' ? 'selected' : '' }}> Y </option>
												<option value="N" {{ $language_proficiency->write=='N' ? 'selected' : '' }}> N </option>
											</select>
											<b class="error-text" id="write_error"></b>
										</div>
									</div>
									<?php $lang++; ?>
									@endforeach
									@else
									<div class="group col-xs-12 group-Language-1 Language" title="group-Language-1">
										<!-- <h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-Language-1"></i></h3> -->
										<div class=" col-md-3" ><label>language<span class="mandatory">*</span></label>
											<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="language[]" />
											<b class="error-text" id="language_error"></b>
										</div>
										<div class=" col-md-3 select" ><label >speak<span class="mandatory">*</span></label>
											<select id="speak" name="speak[]" placeholder="Select speak">
												<option value="">Select Yes/No</option>
												<option value="Y" > Y </option>
												<option value="N" > N </option>
											</select>
											<b class="error-text" id="speak_error"></b>
										</div>
										<div class=" col-md-3 select" ><label >read<span class="mandatory">*</span></label>
											<select id="read" name="read[]" placeholder="Select read">
												<option value="">Select Yes/No</option>
												<option value="Y" > Y </option>
												<option value="N" > N </option>
											</select>
											<b class="error-text" id="read_error"></b>
										</div>
										<div class=" col-md-3 select" ><label>write<span class="mandatory">*</span></label>
											<select id="write" name="write[]" placeholder="Select write">
												<option value="">Select Yes/No</option>
												<option value="Y" > Y </option>
												<option value="N" > N </option>
											</select>
											<b class="error-text" id="write_error"></b>
										</div>
									</div>
									@endif
								</dd>
								<hr>

								<dt class="resumelable"><strong>Additional details</strong></dt>
								<dd class="resumefileds additional_details"  title="Additional details">
									<label class="input">
										<textarea id="additional_details" class="form-control jqte-test"  name="additional_details">{{ $userdetails->additional_details }}</textarea>
										<!-- <input type="text" id="additional_details" name="additional_details" value="{{ $userdetails->additional_details }}" data-toggle="tooltip" data-placement="top" placeholder="Additional details"> -->
										<b class="error-text" id="additional_details_error"></b>
									</label>
								</dd>
								<hr>

							</dl>
							<div class="message-Professional-profile"> </div>
							<input type="hidden" name="id" value="{{$user->id}}">
							<button class="btn-u" type="submit">Update</button>

							{!!Form::close()!!}	
						</div>
					</div>
				</div>						
			</div>
			<!-- Default Proposals -->
		</div>
		@endif
	</div>
	<!-- End Profile Content -->
</div><!--/end row-->
</div>
<!--=== End Profile ===-->
@endsection

@section('scripts')
<script type="text/javascript">
	var statearray = '';
	var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        specialKeys.push(9); //Tab
        specialKeys.push(46); //Delete
        specialKeys.push(36); //Home
        specialKeys.push(35); //End
        specialKeys.push(37); //Left
        specialKeys.push(39); //Right
        function IsAlphaNumeric(e) {
        	var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
        	var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
        	return ret;
        }
        $( document ).ready(function() {
        	$('#years_of_expreience').val('<?php echo $userdetails->years_of_expreience; ?>');
        	$.ajax({
        		url: "{{url('/')}}/state/get",
        		type: 'get',
        		success: function(result) {	
        			statearray = result;
        			$.each( result, function( key, val ) {
        				var selected= val.state_id == '{{ $userdetails->state_id }}' ? 'selected' : '';
        				$('#state').append('<option class="text-left" value="'+val.state_id+'" '+selected+' >'+val.state_name+'</option>');
					});
					/*
        			$('#state').multiselect({
        				nonSelectedText: 'Select State',
        				columns: 1,
        				search: true,
        				onChange: function(option, checked) {

        				},
        				buttonContainer: '<div class="btn-grouptest" />',
					});
					*/
        		}
        	});        	
        	
        	$('#state').on('change',function(){
        	
        		var state_id = $(this).val();
        		$('#city').children('option:not(:first)').remove();
        		$.ajax({
        		url: "{{url('/')}}/city/get/"+state_id,
        		type: 'get',
        		success: function(result) {	
        			$.each( result, function( key, val ) {
        				var selected= val.city_id == '{{ $userdetails->city_id }}' ? 'selected' : '';
        				$('#city').append('<option class="text-left" value="'+val.city_id+'" '+selected+' >'+val.city_name+'</option>');
        			});
        		}
        	});

        	});
        	
        	$.ajax({
        		url: "{{url('/')}}/city/get/",
        		type: 'get',
        		success: function(result) {	
        			$.each( result, function( key, val ) {
        				var selected= val.city_id == '{{ $userdetails->city_id }}' ? 'selected' : '';
        				$('#city').append('<option value="'+val.city_id+'" '+selected+' >'+val.city_name+'</option>');
        			});
        			
        		}
        	});
        	
        	$.ajax({
        		url: "{{url('/')}}/area/get",
        		type: 'get',
        		success: function(result) {	
        			$.each( result, function( key, val ) {
        				var selected= jQuery.inArray(val.area_id, [<?php echo $userdetails->area; ?>]) !== -1 ? 'selected' : '';
        				$('#area').append('<option value="'+val.area_id+'" '+selected+' >'+val.area_name+'</option>');
        			});
        			$('#area').multiselect({
        				nonSelectedText: 'Select Area',
        				columns: 1,
        				search: true,
        				onChange: function(option, checked) {

        				},
        				buttonContainer: '<div class="btn-grouptest" />',
        			});
        		}
        	});
        	$.ajax({
        		url: "{{url('/')}}/certifications/get",
        		type: 'get',
        		success: function(result) {	
        			$.each( result, function( key, val ) {
        				var key = val.certifications_id;
        				var value = '<?php echo $userdetails->certifications; ?>';
        				var selected = $.inArray(key, value.split(',')) !== -1 ? 'selected' : '';
        				$('#certifications').append('<option value="'+val.certifications_id+'" '+selected+' >'+val.certifications_description+'</option>');
        			});
        			$('#certifications').multiselect({
        				nonSelectedText: 'Select certifications',
        				columns: 1,
        				nSelectedText: 'Certifications Selected',
        				search: true,
        				onChange: function(option, checked) {

        				},
        				buttonContainer: '<div class="btn-grouptest" />',
        			});
        		}
        	});
        	$.ajax({
        		url: "{{url('/')}}/specialization/get",
        		type: 'get',
        		success: function(result) {	
        			$.each( result, function( key, val ) {
        				var key = val.skill_id;
        				var value = '<?php echo $userdetails->specialization; ?>';
        				var selected = $.inArray(key, value.split(',')) !== -1 ? 'selected' : '';
        				$('#specialization').append('<option value="'+val.skill_id+'" '+selected+' >'+val.skill+'</option>');
        			});
        			$('#specialization').multiselect({
        				nonSelectedText: 'Select specialization',
        				columns: 1,
        				search: true,
        				nSelectedText: 'Specialization Selected',
        				buttonContainer: '<div class="btn-grouptest" />',
        				onChange: function(option, checked) {
        				},
        				buttonContainer: '<div class="btn-grouptest" />',
        			});
        		}
        	});
        	$.ajax({
        		url: "{{url('/')}}/franchise/get",
        		type: 'get',
        		success: function(result) {	
        			$.each( result, function( key, val ) {
        				var selected= jQuery.inArray(val.franchise_id, [<?php echo $userdetails->franchise != 'other' ? $userdetails->franchise : ''; ?>]) !== -1 ? 'selected' : '';
        				$('#franchise').append('<option value="'+val.franchise_id+'" '+selected+' >'+val.franchise_name+'</option>');
        			});
        			if('{{ $userdetails->franchise }}' == 'other'){
        				$('#franchise').val('other');
        				$('.other_franchise_show').addClass('show').removeClass('hide');
        			}
        			$('#franchise').multiselect({
        				nonSelectedText: 'Select franchise',
        				columns: 1,
        				search: true,
        				onChange: function(option, checked) {
        					if(option.val() == 'other'){
        						if(checked){
        							$('.other_franchise_show').addClass('show').removeClass('hide');
        						}else{
        							$('.other_franchise_show').addClass('hide').removeClass('show');
        						}
        					}else{
        						$('.other_franchise_show').addClass('hide').removeClass('show');
        					}
        				},
        				buttonContainer: '<div class="btn-grouptest" />',
        			});
        		}
        	});

        	/*$('#download_contract').click(function(e) {
        		e.preventDefault(); 
        		window.location.href = 'http://www.92agents.com/assets/img/agents_pdf/1536050674.pdf';
        	});*/

		// $('.franchise_add_new').click(function(e) {
		// 	e.preventDefault();
		// 	var html1 ='<input type="text" name="franchise[]"  data-toggle="tooltip" data-placement="top" placeholder="Franchise / Affiliatio">';
		// 	$('.franchise_append_new').append(html1);
		// });
		$('.zip_code_add_new').click(function(e) {
			e.preventDefault();
			var html1 ='<input type="text" maxlength="5" name="zip_code[]" placeholder="Zip code">';
			$('.zip_code_append_new').append(html1);
		});

		$('.add-Education').click(function(){
			var count = $('.education').length+1;
			var html1 =	'<div class="group col-xs-12 group-education-'+count+' education" title="group-education-'+count+'">'+
			'<h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-education-'+count+'"></i></h3>'+
			'<div class=" col-md-6"><label>Degree</label>'+
			'<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="degree[]" />'+
			'</div>'+
			'<div class=" col-md-6"><label >School/College</label>'+
			'<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="school[]" />'+
			'</div>'+
			'<div class=" col-md-6"><label >Select From Date</label>'+
			'<label class="select">'+
			'<select name="educationfrom[]" placeholder="Select From Date">'+
			'<option value="">Select From Date</option>'+
			'@for($i=date("Y"); $i>1990; $i--)'+
			'<option value="{{$i}}">{{$i}}</option>'+
			'@endfor'+
			'</select>'+
			'</label>'+
			'</div>'+
			'<div class=" col-md-6"><label>Select To Date</label>'+
			'<label class="select">'+
			'<select name="educationto[]" placeholder="Select From Date">'+
			'<option value="">Select To Date</option>'+
			'@for($i=date("Y",strtotime("+5 year")); $i>1990; $i--)'+
			'<option value="{{$i}}">{{$i}}</option>'+
			'@endfor'+
			'</select>'+
			'</label>'+
			'</div>'+
			'<div class=" col-md-12"><label>Description</label>'+
			'<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control jqte-test"  name="educationdescription[]"></textarea>'+
			'</div>'+
			'</div>';

			$('.append-real-estate-education').append(html1);
			$('.group-education-'+count+' .jqte-test').jqte();
		});
		$('.add-Experience').click(function(){
			var count = $('.experience').length+1;
			var html1 =	'<div class="group col-xs-12 group-experience-'+count+' experience" title="group-experience-'+count+'">'+
			'<h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-experience-'+count+'"></i></h3>'+
			'<div class=" col-md-6"><label>Title</label>'+
			'<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="post[]" />'+
			'</div>'+
			'<div class=" col-md-6"><label >Company</label>'+
			'<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="organization[]" />'+
			'</div>'+
			'<div class=" col-md-6"><label >Select From Date</label>'+
			'<label class="select">'+
			'<select name="experiencefrom[]" placeholder="Select From Date">'+
			'<option value="">Select From Date</option>'+
			'<option value="currently_work">Currently Work</option>'+
			'@for($i=date("Y"); $i>1990; $i--)'+
			'<option value="{{$i}}">{{$i}}</option>'+
			'@endfor'+
			'</select>'+
			'</label>'+
			'</div>'+
			'<div class=" col-md-6"><label>Select To Date</label>'+
			'<label class="select">'+
			'<select name="experienceto[]" placeholder="Select To Date">'+
			'<option value="">Select To Date </option>'+
			'<option value="currently_work">Currently Work</option>'+
			'@for($i=date("Y"); $i>1990; $i--)'+
			'<option value="{{$i}}">{{$i}}</option>'+
			'@endfor'+
			'</select>'+
			'</label>'+
			'</div>'+
			'<div class=" col-md-12"><label>Description</label>'+
			'<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control jqte-test"  name="experiencedescription[]"></textarea>'+
			'</div>'+
			'</div>';

			$('.industry_experience').append(html1);
			$('.group-experience-'+count+' .jqte-test').jqte();
		});
		$('.add-Sales-history').click(function(){
			var count = $('.sales').length+1;
			var html1 =	'<div class="group col-xs-12 group-sales_history-'+count+' sales_history" title="group-sales_history-'+count+'">'+
			'<h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-sales_history-'+count+'"></i></h3>'+

			'<div class=" col-md-12"><label>Year</label>'+
			'<label class="select">'+
			'<select name="year[]" placeholder="Select Year">'+
			'<option value="">Select Year</option>'+
			'@for($i=date("Y"); $i>date("Y",strtotime("-20 year")); $i--)'+
			'<option value="{{$i}}">{{$i}}</option>'+
			'@endfor'+
			'</select>'+
			'</label>'+
			'</div>'+
			'<div class=" col-md-6"><label >Sellers Represented</label>'+
			'<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="sellers_represented[]" />'+
			'</div>'+
			'<div class=" col-md-6"><label >Buyers Represented</label>'+
			'<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="buyers_represented[]" />'+
			'</div>'+
			'<div class=" col-md-12"><label>Total Dollar Sales</label>'+
			'<input type="number" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="total_dollar_sales[]" />'+
			'</div>'+

			'</div>';

			$('.sales_history').append(html1);
		});
		$('.add-Language-Proficiency').click(function(){
			var count = $('.Language').length+1;
			var html1 =	'<div class="group col-xs-12 group-Language-'+count+' Language" title="group-Language-'+count+'">'+
			'<h3 class="col-md-12 title-remove"><i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-Language-'+count+'"></i></h3>'+
			'<div class=" col-md-3" ><label>language</label>'+
			'<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="language[]" />'+
			'</div>'+
			'<div class=" col-md-3 select" ><label >speak</label>'+
								// '<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="speak[]" />'+
								'<select id="speak" name="speak[]" placeholder="Select speak">'+
								'<option value="">Select Yes/No</option>'+
								'<option value="Y" > Y </option>'+
								'<option value="N" > N </option>'+
								'</select>'+
								'</div>'+
								'<div class=" col-md-3 select" ><label >read</label>'+
								// '<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="read[]" />'+
								'<select id="read" name="read[]" placeholder="Select read">'+
								'<option value="">Select Yes/No</option>'+
								'<option value="Y" > Y </option>'+
								'<option value="N" > N </option>'+
								'</select>'+
								'</div>'+
								'<div class=" col-md-3 select" ><label>write</label>'+
								// '<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="write[]" />'+
								'<select id="write" name="write[]" placeholder="Select Yes/No">'+
								'<option value="">Select Yes/No</option>'+
								'<option value="Y" > Y </option>'+
								'<option value="N" > N </option>'+
								'</select>'+
								'</div>'+
								'</div>';

								$('.Language_Proficiency').append(html1);
							});
		$('.associations_awards_add').click(function(e) {
			e.preventDefault();
			var html1 ='<input type="text" name="associations_awards[]"  placeholder="Associations Awards">';
			$('.associations_awards_pluse').append(html1);
		});
		$('.publications_add').click(function(e) {
			e.preventDefault();
			var html1 ='<input type="text" name="publications[]"  placeholder="Publications">';
			$('.publications_pluse').append(html1);
		});
		$('.community_involvement_add').click(function(e) {
			e.preventDefault();
			var html1 ='<input type="text" name="community_involvement[]"  placeholder="Community Involvement">';
			$('.community_involvement_pluse').append(html1);
		});
		
		/* edit-personal-bio */
		$('#edit-personal-bio').submit(function(e){
			e.preventDefault();			
			// var $form = $(e.target),esmsg = $('.message-Professional');
			$.ajax({				
				url: "{{url('/')}}/profile/agent/editAgentPersonalProfile",
				type: 'POST',
				data:  new FormData(this),//$form.serialize(),
				beforeSend: function(){$(".body-overlay").show();},
				processData:false,
				contentType: false,
				success: function(result) {	
					
					$(".body-overlay").hide();
					$('.error-text').text('');
					$('#edit-personal-bio input, #edit-personal-bio select, #edit-personal-bio textarea').removeClass('error-border');

					if(typeof result.error !='undefined' && result.error !=null){
						var i=0
						$.each( result.error, function( key, value ) {
							if(i==0){
								scroleerr = $('#'+key+'_error');
							}
							i++;
							$('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
							var text = $('#'+key+'_error').text();
							text = text.replace("id", "");
							$('#'+key+'_error').text(text);
							$('#'+key).addClass('error-border');
						});
						// esmsg.text('');
						// $('html, body').animate({
						// 	scrollTop: scroleerr.offset().top
						// },1000);
						$(".body-overlay").hide();
						$('html, body').animate({
							scrollTop: $('.message-Professional').offset().top
						},1000);
					}

					if(result.msg !='undefined' && result.msg !=null){
						$(".message-Personal").addClass('alert alert-success text-center').html(result.msg).css({'color':'green'});
						setInterval(function() { esmsg.removeClass('alert alert-success text-center').html(''); },20000);
						// $('input, select, textarea').val('');
						$('html, body').animate({
							scrollTop: $('body').offset().top
						},1000);
					}

					console.log(result);
				},
				error: function(data) 
				{	
					if(data.status=='500'){
						esmsg.text(data.statusText).css({'color':'red'});
					}else if(data.status=='422'){
						esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
					}
					$(".body-overlay").hide();
					$('html, body').animate({
						scrollTop: $('.message-Professional').offset().top
					},1000);
				} 	
			});
		});
		/* edit edit-prasnol-bio*/

		/* edit-professional-bio */
		$('#edit-professional-bio').submit(function(e){
			e.preventDefault();
			
			var $form = $(e.target),esmsg = $('.message-Professional-profile');
			$.ajax({
				url: "{{url('/')}}/profile/agent/editagentprofessionalprofile",
				type: 'POST',
				data: $form.serialize(),
				beforeSend: function(){$(".body-overlay").show();},
				processData:false,
				
				success: function(result) {	
					$(".body-overlay").hide();
					$('.error-text').text('');
					$('#edit-professional-bio input, #edit-professional-bio select, #edit-professional-bio textarea').removeClass('error-border');

					if(typeof result.error !='undefined' && result.error !=null){
						var scroleerr = '';
						var i=0;
						$.each( result.error, function(key, value) {
							if(i==0){
								scroleerr = $('#'+key+'_error');
							}
							i++;
							$('#'+key+'_error').removeClass('success-text').addClass('error-text').text(value);
							var text = $('#'+key+'_error').text();
							text = text.replace("id", "");
							text = text.replace("experience", "");
							text = text.replace("Experience", "");
							text = text.replace("Education", "");
							text = text.replace("education", "");
							$('#'+key+'_error').text(text);
							$('#'+key).addClass('error-border');
						});
						esmsg.text('');
						$('html, body').animate({
							scrollTop: scroleerr.offset().top-200
						},1000);
					}

					if(typeof result.msg !='undefined' && result.msg !=null){
						esmsg.addClass('alert alert-success text-center').html(result.msg).css({'color':'green'});
						setInterval(function() { esmsg.removeClass('alert alert-success text-center').html(''); },20000);
						// $('input, select, textarea').val('');
						$('html, body').animate({
							scrollTop: $('body').offset().top
						},1000);
					}
				},
				error: function(data) 
				{	
					if(data.status=='500'){
						esmsg.text(data.statusText).css({'color':'red'});
					}else if(data.status=='422'){
						esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
					}
					$(".body-overlay").hide();
					$('html, body').animate({
						scrollTop: $('.message-Professional-profile').offset().top
					},1000);
				} 	
			});
		});
		/* edit edit-prasnol-bio*/
	});
function closegroup(id) {
	$('.'+id).remove();
}

$('input').hover(function(e){
    $(this).attr('title', '');
});

$('textarea').hover(function(e){
    $(this).attr('title', '');
});

$('select').hover(function(e){
    $(this).attr('title', '');
});
</script> 
@stop


