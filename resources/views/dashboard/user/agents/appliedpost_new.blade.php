@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
<style type="text/css">
	.mCustomScrollBox {
		overflow-y: scroll !important;
	}
</style>
@stop
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
						                <th>Select</th>
						                <th>Project</th>
						                <th>Posted By</th>
						                <th>Sale Date</th>
						                <th>Sale Price</th>
						                <th>Closing Date</th>
						                <th>92 Agent's Commission</th>
						                <th>Payment Status</th>
						                <th>Actions</th>
						            </tr>
						        </thead>
						        <tbody>
						            <?php 
						                foreach($invoice_details as $k=>$v) {
						            ?>
						            <tr>
						                <td><input type="checkbox" name="selected_invoices[]" value=<?=$v->id?> /></td>
						                <td>{{$v->posttitle}}</td>
						                <td>{{$v->sellers_name}}</td>
						                <td>{{est_std_date($v->sale_date)}}</td>
						                <td class="text-right">${{$v->sale_price}}</td>
						                <td>
						                    <?php 
						                        if(!$v->closing_date) {
						                            echo '<div class="input-group">';
                                                    echo    '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
                                                    echo    '<input type="text" title="Select Closing Date" value="" name="closing_date[]" value="" class="col-lg-10 form-control" />';
                                                    echo '</div>';
						                        } else {
						                            echo est_std_date($v->closing_date);
						                        }
						                    ?></td>
						                <td class="text-right">${{calc_92_commission($v->sale_price)}}</td>
						                <td>
						                    <?php 
						                        if($v->payment_status == 1) {
						                    ?>
						                    <span class="badge badge-green">
						                        Paid
						                    </span>
						                    <?php } elseif($v->sale_price > 0 && $v->payment_status == 0) { ?>
						                    <span class="badge badge-red">
						                        Payment Pending
						                    </span>
						                    <?php } elseif(!$v->closing_date) { ?>
						                    <span class="badge badge-blue">
						                        Closing Pending
						                    </span>
						                    <?php } elseif(!$v->closing_date) { ?>
						                    <span class="badge badge-orange">
						                        Ready for Closing
						                    </span>
						                    <?php } ?>
						                </td>
						                <td>
						                    <?php 
						                    if($v->payment_status == 0) {
						                        echo '<button class="btn-u padding-6" onclick="payIndividually($v->id)">Pay</button>';
						                    }
						                    ?>
						                </td>
						            </tr>
						            <?php } ?>
						            <?php if(empty($invoice_details)) { ?>
						            <tr>
						                <td colspan="8">No Data Available</td>
						            </tr>
						            <?php } ?>
						            <!--<tr>-->
						            <!--    <td>2</td>-->
						            <!--    <td>Req. to sell my home</td>-->
						            <!--    <td>Sanjeev</td>-->
						            <!--    <td>09/21/2022 01:01:00</td>-->
						            <!--    <td>01/06/2023</td>-->
						            <!--    <td>$4,000</td>-->
						            <!--    <td>-->
						            <!--        <span class="badge badge-red">-->
						            <!--            Payment Pending-->
						            <!--        </span>-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <button class="btn-u padding-6">Pay it now</button>-->
						            <!--    </td>-->
						            <!--</tr>-->
						            <!--<tr>-->
						            <!--    <td>3</td>-->
						            <!--    <td>Need to sell a property</td>-->
						            <!--    <td>Kedar</td>-->
						            <!--    <td>01/01/2022 01:01:00</td>-->
						            <!--    <td>-->
						            <!--        <div class="input-group">-->
                  <!--                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                  <!--                              <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />-->
                  <!--                          </div>-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <input type="text" class="form-control" placeholder="Selling Price" />-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <span class="badge badge-blue">-->
						            <!--            Closing Pending-->
						            <!--        </span>-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <button class="btn btn-default">Save</button>-->
						            <!--    </td>-->
						            <!--</tr>-->
						            <!--<tr>-->
						            <!--    <td>4</td>-->
						            <!--    <td>Need to sell a property</td>-->
						            <!--    <td>Kedar</td>-->
						            <!--    <td>01/01/2022 01:01:00</td>-->
						            <!--    <td>-->
						            <!--        <div class="input-group">-->
                  <!--                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                  <!--                              <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />-->
                  <!--                          </div>-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <input type="text" class="form-control" placeholder="Selling Price" />-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <span class="badge badge-blue">-->
						            <!--            Closing Pending-->
						            <!--        </span>-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <button class="btn btn-default">Save</button>-->
						            <!--    </td>-->
						            <!--</tr>-->
						            <!--<tr>-->
						            <!--    <td>5</td>-->
						            <!--    <td>Need to sell a property</td>-->
						            <!--    <td>Kedar</td>-->
						            <!--    <td>01/01/2022 01:01:00</td>-->
						            <!--    <td>-->
						            <!--        <div class="input-group">-->
                  <!--                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                  <!--                              <input type="text" title="Select Closing Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" />-->
                  <!--                          </div>-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <input type="text" class="form-control" placeholder="Selling Price" />-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <span class="badge badge-blue">-->
						            <!--            Closing Pending-->
						            <!--        </span>-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <button class="btn btn-default">Save</button>-->
						            <!--    </td>-->
						            <!--</tr>-->
						            <!--<tr>-->
						            <!--    <td>6</td>-->
						            <!--    <td>Need to sell a property</td>-->
						            <!--    <td>Kedar</td>-->
						            <!--    <td>01/01/2022 01:01:00</td>-->
						            <!--    <td>07/10/2022 01:01:00</td>-->
						            <!--    <td>$10,000</td>-->
						            <!--    <td>-->
						            <!--        <span class="badge badge-orange">-->
						            <!--            Ready for Closing-->
						            <!--        </span>-->
						            <!--    </td>-->
						            <!--    <td>-->
						            <!--        <button class="btn btn-default">Save</button>-->
						            <!--    </td>-->
						            <!--</tr>-->
						        </tbody>
						    </table>
						</div>
					</div>
					<br />
				    <div class="col-md-12">
				        <div class="row">
				            <button class="btn-u padding-6" onclick="payInBulk()">Pay in bulk</button>
				        </div>
				    </div>
				</div>
			</div>
			<!-- End Profile Content -->			
		</div>
	</div>	
@endsection

<script>
    function payInBulk() {
        console.log(document.getElementsByTagName('selected_invoices'));
    }
</script>
