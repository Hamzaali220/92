@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
<style type="text/css">
	.mCustomScrollBox {
		overflow-y: scroll !important;
	}
</style>
@stop
{{-- {{dd($invoice_details);}} --}}
@section('title', 'Applied Post')
@section('content')
<?php  $topmenu='Home'; ?>
<?php $activemenu = 'appliedpost'; ?>
@include('dashboard.include.sidebar')

<!--=== Profile ===-->
    <div class="container content profile">
		<div class="row">
			<!--Left Sidebar-->
			@include('dashboard.user.agents.include.sidebar')
			<!--End Left Sidebar-->
				<!-- Profile Content -->
			<div class="col-md-12">
				<h2><b>All My Jobs</b></h2>
				<div class="box-shadow-profile ">
					<div class="panel-profile" style="padding: 10px;">
						<div class="table-responsive">
						    <table class="table table-bordered table-striped">
						        <thead>
						            <tr>
						                <th>Sl. No.</th>
						                <th>Project</th>
						                <th>Posted By</th>
						                {{-- <th>Posted At</th> --}}
						                <th>Closing Date</th>
						                <th>Sale Price</th>
						                <th>Payment Status</th>
						                <th>Actions</th>
						            </tr>
						        </thead>
						        <tbody>
									<?php
									$n=0;	
									foreach($invoice_details as $in){?>
										<tr>
						                <td>{{$n}}</td>
						                <td>{{$in->posttitle}}</td>
						                <td>{{$in->sellers_name}}</td>
						                {{-- <td>{{$in->address}}</td> --}}
						                <td>
						                    <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" title="Select Closing Date" value="{{@$in->sale_date}}" name="proposaldate" class="col-lg-10 form-control reservation proposaldate" />
                                            </div>
						                </td>
						                <td>
						                    <input type="text" class="form-control" placeholder="Selling Price" value="{{@$in->sale_price}}" />
						                </td>
						                
											<?php if(@$in->sale_date=='' || @$in->sale_price==''){?>
										<td>
												<span class="badge badge-blue">
						                        Closing Pending
						                    </span>
										</td>
											<td>
												<button class="btn btn-default">Save</button>
											</td>
											<?php
											}else{
											?>
										<td>
						                    <span class="badge badge-red">
						                        Payment Pending
						                    </span>
						                </td>
						                <td>
						                    <button class="btn-u padding-6">Pay it now</button>
						                </td>
										<?php
											}
										?>
						                    
						                
						                <td>
						                    
						                </td>
						            </tr>	
									<?php
								$n=$n+1;	
								}
									?>
						            <tr>
						                {{-- <td>1</td>
						                <td>Need to sell my property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>06/06/2022</td>
						                <td>$40,000</td>
						                <td>
						                    <span class="badge badge-green">
						                        Paid
						                    </span>
						                </td>
						                <td>
						                    
						                </td>
						            </tr>
						            <tr>
						                <td>2</td>
						                <td>Req. to sell my home</td>
						                <td>Sanjeev</td>
						                <td>09/21/2022 01:01:00</td>
						                <td>01/06/2023</td>
						                <td>$4,000</td>
						                <td>
						                    <span class="badge badge-red">
						                        Payment Pending
						                    </span>
						                </td>
						                <td>
						                    <button class="btn-u padding-6">Pay it now</button>
						                </td>
						            </tr>
						            <tr>
						                <td>3</td>
						                <td>Need to sell a property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>
						                    <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />
                                            </div>
						                </td>
						                <td>
						                    <input type="text" class="form-control" placeholder="Selling Price" />
						                </td>
						                <td>
						                    <span class="badge badge-blue">
						                        Closing Pending
						                    </span>
						                </td>

						                <td>
						                    <button class="btn btn-default">Save</button>
						                </td>
						            </tr>
						            <tr>
						                <td>4</td>
						                <td>Need to sell a property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>
						                    <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />
                                            </div>
						                </td>
						                <td>
						                    <input type="text" class="form-control" placeholder="Selling Price" />
						                </td>
						                <td>
						                    <span class="badge badge-blue">
						                        Closing Pending
						                    </span>
						                </td>
						                <td>
						                    <button class="btn btn-default">Save</button>
						                </td>
						            </tr>
						            <tr>
						                <td>5</td>
						                <td>Need to sell a property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>
						                    <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />
                                            </div>
						                </td>
						                <td>
						                    <input type="text" class="form-control" placeholder="Selling Price" />
						                </td>
						                <td>
						                    <span class="badge badge-blue">
						                        Closing Pending
						                    </span>
						                </td>
						                <td>
						                    <button class="btn btn-default">Save</button>
						                </td>
						            </tr>
						            <tr>
						                <td>6</td>
						                <td>Need to sell a property</td>
						                <td>Kedar</td>
						                <td>01/01/2022 01:01:00</td>
						                <td>07/10/2022 01:01:00</td>
						                <td>$10,000</td>
						                <td>
						                    <span class="badge badge-orange">
						                        Ready for Closing
						                    </span>
						                </td>
						                <td>
						                    <button class="btn btn-default">Save</button>
						                </td>
						            </tr> --}}
						        </tbody>
						    </table>
						</div>
					</div>
				</div>
			</div>
			<!-- End Profile Content -->			
		</div>
	</div>	
	

@endsection
