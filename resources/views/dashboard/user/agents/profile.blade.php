@extends('dashboard.master')
@section('style')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <style type="text/css">
        .modal-header .close {
            color: #000 !important;
        }
    </style>
@stop

@section('title', 'Profile')
@section('content')

<?php
    $topmenu = 'Profile'; 
    $activemenu = 'agent'; 
?>

@include('dashboard.include.sidebar')

<!--=== Profile ===-->
    <div class="container content profile">
        <div class="row">
            <!--Left Sidebar-->
            @include('dashboard.user.agents.include.sidebar')
            @include('dashboard.user.agents.include.sidebar-profile')
            <!--End Left Sidebar-->

            <!-- Profile Content -->
            <!-- col-9 -->
            <div class="col-md-9">
                <div class="profile-body margin-bottom-10">
                    <div class="profile-bio">
                        <div class="row">
                            <div class="col-md-12 ">
                                <img data-toggle="modal" data-target="#changeprofilepic" width="80" height="80" id="profile-pic" src="@if($userdetails->photo != '') {{ url('/assets/img/profile/'.$userdetails->photo) }} @else {{ url('/assets/img/team/img32-md.jpg') }} @endif" alt="img04" class="profile-pic img-circle header-circle-img1 img-margin">

                                <h2 class="name" id="name" title="Full Name"> {{ ucfirst($userdetails->name)}} @php echo $editfield @endphp </h2>

                                <span class="address" id="address" title="Address"><strong> <i class="fa fa-map-marker text-16"></i> </strong> {{ $userdetails->address}} @php echo $editfield @endphp</span>
                            </div>

                            <div class="col-md-12 margin-top-20">
                                <span class="description" id="description" title="Description"> <strong> </strong> {!! $userdetails->description !!} @php echo $editfield @endphp</span>
                            </div>
                        </div>
                    </div><!--/end row-->
                </div>

                <div class="box-shadow-profile margin-bottom-10 " >

                    <!-- Default Proposals -->
                    <div class="panel-profile">
                        <div class="panel-heading overflow-h air-card ">
                            <h2 class="heading-sm pull-left"> Skills </h2>
                            <!-- <a class="field-edit cursor pull-right btn btn-default"><i class="fa fa-pencil"></i> Edit</a> -->
                        </div>

                        <div class="panel-body skills" id="skills" title="Skills">                      
                            <!-- <span class="skills" id="skills" title="Skills"><strong></strong>  -->
                                @if(!empty($userdetails->skills))
                                    @foreach($userdetails->skills as $skills)
                                        <p skey="{{$skills->skill_id}}" class="skill-lable label label-success" >{{$skills->skill}}</p>
                                    @endforeach
                                @endif
                                @php echo $editfield @endphp
                            <!-- </span> -->
                        </div>
                        <!--/end row-->
                    </div>
                    <!-- Default Proposals -->
                </div>

                <div class="box-shadow-profile margin-bottom-10">

                    <!-- Default Proposals -->
                    <div class="panel-profile">
                        <div class="panel-heading overflow-h air-card">
                            <h2 class="heading-sm pull-left"> Proposals </h2>
                            <a class="defaultproposal cursor pull-right btn btn-default"><i class="fa fa-plus"></i> Upload New Proposals</a>
                        </div>

                        <div class="panel-body row">                           
                            <div id="append-proposal-ajax"></div>
                            <div id="loadproposal" class="col-md-12 center loder loadproposal"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
                            <div class="center col-md-12 btn-buy animated fadeInRight">
                                <a  id="loadmoreproposal" class="cursor hide">Load More </a>
                                <a href="#" id="addnewproposal" class="defaultproposal btn-u">New Proposals</a>
                            </div>
                        </div>
                        <!--/end row-->
                    </div>
                    <!-- Default Proposals -->
                </div>

                <div class="box-shadow-profile margin-bottom-10">

                    <!-- Default Proposals -->
                    <div class="panel-profile">
                        <div class="panel-heading overflow-h air-card">
                            <h2 class="heading-sm pull-left"> Documents </h2>
                            <a class="uploadandshare cursor pull-right btn btn-default"><i class="fa fa-plus"></i> Upload New Documents</a>
                        </div>

                        <div class="panel-body row">                           
                            <div id="append-uploadshares-ajax"></div>
                            <div id="loaduploadshare" class="col-md-12 center loder loaduploadshare"><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div>
                            <div class="center col-md-12 btn-buy animated fadeInRight">
                                <a  id="loaduploadandshare" class="cursor hide"><i class="fa fa-spinner"> </i> load more </a>
                                <a href="#" id="addnewupload" class="uploadandshare btn-u">New Documents</a>
                            </div>
                        </div>
                        <!--/end row-->
                    </div>
                    <!-- Default Proposals -->
                </div>

                <div class="box-shadow-profile margin-bottom-10">

                    <!-- Default Proposals -->
                    <div class="panel-profile">
                        <div class="panel-heading overflow-h employment air-card" id="employment" title="Experience">
                            <h2 class="panel-title heading-sm pull-left " > Non-Real Estate related history and experiences </h2>
                            <a class="cursor pull-right btn btn-default field-edit"><i class="fa fa-pencil"></i> Edit</a>
                        </div>

                        <div class="panel-body ">
                            <ul class="timeline-v2 timeline-me" id="employment_list">
                                @if(!empty($userdetails->employment))
                                @foreach(json_decode($userdetails->employment) as $employment)
                                <li>
                                    <time datetime="" class="cbp_tmtime"><span class="post">{{$employment->post}}</span> <span class="from">{{  str_replace('_',' ',$employment->from) }} - {{  str_replace('_',' ',$employment->to) }}</span></time>
                                    <i class="cbp_tmicon rounded-x hidden-xs"></i>
                                    <div class="cbp_tmlabel">                                
                                        <h2 class="organization">{{$employment->organization}}</h2>
                                        <p class="description"> {!! $employment->description !!}</p>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        <!--/end row-->
                    </div>
                    <!-- Default Proposals -->
                </div>

                <div class="box-shadow-profile ">

                    <!-- Default Proposals -->
                    <div class="panel-profile">
                        <div class="panel-heading overflow-h education air-card" id="education" title="Education">
                            <h2 class="panel-title heading-sm pull-left " > Education </h2>

                            <a class="cursor pull-right btn btn-default field-edit"><i class="fa fa-pencil"></i> Edit</a>

                        </div>

                        <div class="panel-body ">

                            <ul class="timeline-v2 timeline-me" id="education_list">

                                @if(!empty($userdetails->education))

                                @foreach(json_decode($userdetails->education) as $education)

                                <li>

                                    <time datetime="" class="cbp_tmtime"><span class="degree">{{$education->degree}}</span> <span class="from">{{$education->from}} - {{$education->to}}</span></time>

                                    <i class="cbp_tmicon rounded-x hidden-xs"></i>

                                    <div class="cbp_tmlabel">

                                    

                                        <h2 class="school">{{$education->school}}</h2>

                                        <p class="description"> {!! $education->description !!}</p>

                                    </div>

                                </li>

                                @endforeach

                                @endif

                            </ul>

                        </div>

                        <!--/end row-->

                    </div>

                    <!-- Default Proposals -->

                </div>



            </div>

            <!-- col-9 -->

            <!-- col-3 -->

            <!-- <div class="col-md-3 sm-margin-bottom-20 grid cs-style-5">

                <a href="{{url('/profile/agent/settings')}}" class="cursor btn-block btn btn-default"> Profile Settings </a>

                <hr>

            </div> -->

            <!-- col-3 -->

            <!-- End Profile Content -->

        </div>

    </div>  

    <!-- profile model -->

    <div class="modal fade" id="profilemodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                {!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'edit-profile-model')) !!}

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title field-header-title" id="myModalLabel4" style="text-transform: capitalize;">{{ucfirst($userdetails->name)}}</h4>

                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <p class="col-md-12 success-text center hide" id="successsome"></p>

                            <fieldset class="col-md-12" id="field-add-model">

                                                        

                            </fieldset>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <input type="hidden" value="<?php
echo $user->id; ?>" name="id" >

                        <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn-u btn-u-primary" id="edit-profile" name="edit-profile-submit" value="Save changes" title="Save changes">Save Changes</button>

                    </div>

                {!!Form::close()!!}

            </div>

        </div>

    </div>

    <!-- default proposal -->

    <div class="modal fade" id="defaultproposal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                {!! Form::open(array('url' => '#','class'=>'sky-form','enctype'=>'multipart/form-data','id'=>'add-default-proposal')) !!}

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>

                    </div>

                    <div class="modal-body">

                        <fieldset>

                            <div id="message-proposal"> </div>

                            <dt>Proposal Title <span class="mandatory">*</span></dt>

                            <dd>

                                <section>

                                    <label class="input">

                                        <input type="text" id="proposals_title" name="proposals_title"  placeholder="Proposal Title">

                                    </label>

                                    <p class="error-text proposals_title-error" id="proposals_title-error"></p>

                                </section>

                            </dd>

                            <dt>Select Proposal Type <span class="mandatory">*</span></dt>

                            <dd>

                                <section>

                                    <div class="inline-group">

                                        <label class="radio"><input type="radio" name="type" class="type_1 type filetype" value="1" ><i class="rounded-x"></i>Files Upload</label>

                                        <label class="radio"><input type="radio" name="type" class="type_2 type filetype" value="2" ><i class="rounded-x"></i>Text Html</label>

                                        <p class="error-text type-error" id="type-error"></p>

                                    </div>

                                </section>

                            </dd>



                            <div class="filesupload hide">
                                <label>Upload Your proposal</label>
                                <section>
                                    <label for="file" class="input input-file">
                                        <div class="button"><input type="file" id="proposal-file" name="proposal_file" class="proposal_file" accept="application/pdf,application/doce,application/doc" onchange="this.parentNode.nextSibling.value = this.value.replace(/^.*\\/, '')">Upload proposal </div><input type="text" placeholder="Upload proposal" readonly>
                                    </label>
                                    <p class="error-text proposal_file-error" id="proposal_file-error"></p>
                                </section>      

                                <div style="clear:both">
                                   <div id="viewer" class="hide"></div>
                                </div>
                            </div>

                            <div class="texthtml hide">
                                <dd>

                                    <label class="label">Type Text</label>

                                    <section>

                                        <label class="textarea ">

                                            <textarea rows="2" class="field-border proposals_html jqte-test" name="proposals_html" id="proposals_html" placeholder="Enter Text"></textarea>

                                            <b class="error-text" id="proposals_html_error"></b>

                                        </label>

                                    </section>

                                </dd>

                            </div>

                        </fieldset>

                    </div>

                    <div class="modal-footer">

                        <input type="hidden" value="" name="id" id="proposal_id_update" >

                        <input type="hidden" value="<?php
echo $user->id; ?>" name="agents_user_id" >

                        <input type="hidden" value="<?php
echo $user->agents_users_role_id; ?>" name="agents_users_role_id" >

                        <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn-u btn-u-primary" name="add-proposal-submit" id="proposal-upload" value="Save changes" title="Save changes">Save</button>

                    </div>

                {!!Form::close()!!}

            </div>

        </div>

    </div>

    <div class="modal fade" id="open-proposal-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title proposal-popup-title">{{ucfirst($userdetails->name)}}</h4>

                    </div>

                    <div class="modal-body append-src-ifram">

                        

                    </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="proposaledeleteconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title ">Remove Proposal</h4>

                    </div>

                    <div class="modal-body">

                        <br />

                        <div class="proposal-delete-msg"> </div>

                        <p class="proposal-popup-title">Are you sure this proposal delete?</p>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn-u btn-u-primary" id="delete">Delete</button>

                        <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

                    </div>

            </div>

        </div>

    </div>



    <!-- uploads and share -->

    <div class="modal fade" id="uploadsharedeleteconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">Remove Upload Documents</h4>

                    </div>

                    <div class="modal-body">

                        <br />

                        <div class="upload-delete-msg"> </div>

                        <p class="upload-popup-title"></p>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn-u btn-u-primary" id="delete">Delete</button>

                        <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

                    </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="open-uploadshare-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>

                    </div>

                    <div class="modal-body uploadshare-src-ifram">

                        

                    </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="uploadandshare" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                {!! Form::open(array('url' => '#','class'=>'sky-form','enctype'=>'multipart/form-data','id'=>'add-upload-all-type')) !!}

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>

                    </div>

                    <div class="modal-body">
                        <fieldset>
                            <div id="message-uploadandshare" class="message-uploadandshare"> </div>
                            <label>Files Name</label>
                            <section>
                                <label for="name" class="input input-name">
                                <input type="text" name="name" placeholder="File Name" >
                                </label>
                                <p class="error-text name-error" id="name-error"></p>
                            </section> 
                            <label>Upload Files</label>
                            <section>
                                <label for="file" class="input input-file">
                                    <div class="button"><input type="file" accept="application/pdf,application/doce,application/doc" id="uploadshare-file" name="uploadshare" onchange="this.parentNode.nextSibling.value = this.value.replace(/^.*\\/, '')">Upload files </div><input type="text" placeholder="Upload files" readonly>
                                </label>
                                <p class="error-text uploadshare-error" id="uploadshare-error"></p>
                            </section>      
                        </fieldset>
                    </div>

                    <div class="modal-footer">

                        <input type="hidden" value="" name="id" id="uploadshare_id_update" >

                        <input type="hidden" value="<?php
echo $user->id; ?>" name="agents_user_id" >

                        <input type="hidden" value="<?php
echo $user->agents_users_role_id; ?>" name="agents_users_role_id" >

                        <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn-u btn-u-primary" id="document-upload" name="add-proposal-submit" value="Save changes" title="Save changes">Save</button>

                    </div>

                {!!Form::close()!!}

            </div>

        </div>

    </div>

    <!-- share option  start-->

    <!-- praposal -->

    <div class="modal fade" id="open-proposal-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                



                <div id="loadproposalshare"  class="loadproposalshare body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">Share Proposals With Seller/Buyer</h4>

                </div>

                <div class="row margin-10">

                    {!! Form::open(array('url' => '#','id'=>'searchproposalshareuser')) !!}

                        <div class="col-sm-6 md-margin-bottom-10">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>

                                <input type="text" autofocus placeholder="Search With Seller/Buyer" value="" name="proposalkeyword" id="proposalkeyword" class="keyword form-control">

                            </div>

                        </div>

                        <div class="col-sm-6 md-margin-bottom-10">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                <input type="text" autofocus placeholder="Search With Address & Zipcode" name="proposaladdress" value="" id="proposaladdress" class="address form-control">

                            </div>

                        </div>

                        <div class="col-sm-6 ">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <input type="text" id="proposaldate" title="Select Date" value="" name="proposaldate" value="" class="col-lg-10 form-control reservation proposaldate" placeholder="Search With Connected date">

                            </div>

                        </div>

                        <div class="col-sm-6 ">

                            <button type="submit" class="btn-u btn-block btn-u-dark"  name="searchproposal"> Search </button>

                        </div>

                        <input type="hidden" name="praposalid" id="praposalid" value="">

                    {!!Form::close()!!}

                </div>

                <div class="modal-body sky-form" id="append-proposal-share-user-list">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn-u" data-dismiss="modal">Share</button>

                    <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

    <!-- document -->

    <div class="modal fade" id="open-Document-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content not-top">

                <div id="loadDocumentshare"  class="loadDocumentshare body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">Share Documents With Agents</h4>

                </div>

                <div class="row margin-10">

                    {!! Form::open(array('url' => '#','id'=>'searchdocumentsshareuser')) !!}

                        <div class="col-sm-6 md-margin-bottom-10">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>

                                <input type="text" autofocus placeholder="Search With Seller/Buyer" value="" name="documentskeyword" id="documentskeyword" class="keyword form-control">

                            </div>

                        </div>

                        <div class="col-sm-6 md-margin-bottom-10">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                <input type="text" autofocus placeholder="Search With Address & Zipcode" name="documentsaddress" value="" id="documentsaddress" class="address form-control">

                            </div>

                        </div>

                        <div class="col-sm-6 ">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <input type="text" id="documentsdate" title="Select Date" value="" name="documentsdate" value="" class="col-lg-10 form-control reservation documentsdate" placeholder="Search With Connected date">

                            </div>

                        </div>

                        <div class="col-sm-6 ">

                            <button type="submit" class="btn-u btn-block btn-u-dark"  name="searchdocuments"> Search </button>

                        </div>

                        <input type="hidden" name="documentid" id="documentid" value="">

                    {!!Form::close()!!}

                </div>

                <div class="modal-body sky-form" id="append-Document-share-user-list">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn-u" data-dismiss="modal">Share</button>

                    <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

    <!-- share option  end-->

@endsection



@section('scripts')

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> 

<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script type="text/javascript">



$(document).on('change', 'select[name^="from"]', function(){

    var thisSelect= $(this).val();

    var closestSelect= $(this).closest('div').next('div').find('select[name^="to"]').val();  

    if(parseInt(thisSelect)>parseInt(closestSelect)){ find('span.error-show')

        $('#edit-profile').prop("disabled", true);

        $(this).closest('div').next('div').children('span').text('Your end date can’t be earlier than your start date.');

    }else{

        $('#edit-profile').prop("disabled", false);

        $(this).closest('div').next('div').children('span').text('');

    }

     

});



$(document).on('change', 'select[name^="to"]', function(){

    var thisSelect= $(this).val();

    var closestSelect= $(this).closest('div').prev('div').find('select[name^="from"]').val(); 

    if(parseInt(thisSelect)<parseInt(closestSelect)){

        $('#edit-profile').prop("disabled", true);

        $(this).closest('.select').next('span').text('Your end date can’t be earlier than your start date.');

    }else{

        $('#edit-profile').prop("disabled", false);

        $(this).closest('.select').next('span').text('');

    }

     

});





    $(function() {

        var start = moment().subtract(60, 'days');

        var end = moment();

        $('#proposaldate,#documentsdate').daterangepicker({

            format: 'YYYY-MM-DD',

            "opens": "left",

            startDate: start,

            endDate: end,

            ranges: {

               'Today': [moment(), moment()],

               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],

               'Last 7 Days': [moment().subtract(6, 'days'), moment()],

               'Last 30 Days': [moment().subtract(29, 'days'), moment()],

               'This Month': [moment().startOf('month'), moment().endOf('month')],

               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

            },

            locale: {

                format: 'YYYY-MM-DD'

              }

        });

    });
</script>

<script>
    var proposale_data  = [];
    var uploadshare_data = [];
    var shared_proposal_connected_user_list  = [];
    var shared_document_connected_user_list  = [];
    var obj = <?php echo json_encode($agentskills) ?>;

    $( document ).ready(function() {

        $("#uploadshare-file").change(function () {
            var fileExtension = ['jpeg','jpg','png','pdf', 'doc','docx'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
               $("#uploadshare-error").text("Only formats are allowed : "+fileExtension.join(', '));
                $('#document-upload').prop('disabled', true);
                return false; 
            }
             $('#document-upload').prop('disabled', false);
        });

        $("#proposal-file").change(function () {
            var fileExtension = ['jpeg','jpg','png','pdf', 'doc','docx'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
               $("#proposal_file-error").text("Only formats are allowed : "+fileExtension.join(', '));
                $('#proposal-upload').prop('disabled', true);
                return false; 
            }
             $('#proposal-upload').prop('disabled', false);
        });       

        $('.type').change(function(e) {
            e.preventDefault();
            var value = $(this).val();
            if(value==1){ 
                $(".filesupload").addClass('show').removeClass('hide');
                $(".texthtml").addClass('hide').removeClass('show');                
            }else{
                $(".filesupload").addClass('hide').removeClass('show');
                $(".texthtml").addClass('show').removeClass('hide');
            }
        });

        var header_title = $('.field-header-title');
        var a,listindex,fieldtype,innerHTML,innerText,html,title,id = $('#field-add-model'),model = $('#profilemodel');

        $('.field-edit').click(function(){

            a = $(this).parent(),listindex=1,fieldtype = a[0].id,innerHTML = a[0].innerHTML,innerText = a[0].innerText,html='',title = a[0].title,id = $('#field-add-model'),model = $('#profilemodel');
            $('#successsome').text('');          

            $('#edit-profile').prop("disabled", false);

            if (fieldtype == 'name' || fieldtype == 'address'){
                header_title.text('Profile ' + fieldtype );
                model.modal('show');
                innerText = $.trim(innerText.replace('<?php echo $editfield; ?>', ''));
                innerText = $.trim(innerText.replace('Address:', ''));
                html += '<section><label class="label">'+title+'<span class="mandatory">*</span></label>';
                html += '<label class="input">';
                    html += '<input type="text" data-toggle="tooltip" data-placement="top" class="form-control edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" value="'+innerText+'" name="'+fieldtype+'" />';
                html += '</label></section>';
            }
              else if(fieldtype == 'description') {
                header_title.text('Overview');
                model.modal('show');
                innerText = $.trim(innerText.replace('<?php echo $editfield; ?>', ''));
                innerText = $.trim(innerText.replace('Description:', ''));
                html += '<section><label class="label">My '+title+'<span class="mandatory">*</span></label>';
                html += '<label class="textarea">';
                html += '<textarea rows="5"  type="text" data-toggle="tooltip" data-placement="top" class="form-control jqte-testdd edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" name="'+fieldtype+'">'+innerText+'</textarea> ';
                html += '</label></section>';
            }
              else if(fieldtype == 'skills') {
                header_title.text('My Skills');
                model.modal('show');
                innerText = $.trim(innerText.replace('<?php echo $editfield; ?>', ''));               
                html += '<section><label class="label"> Select '+title+'</label>';
                html += '<label class="select">';
                html += '<select data-toggle="tooltip" multiple data-placement="top" data-role="multiselect" class="form-control multipalselecte edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" name="'+fieldtype+'[]">';

                        $.each( obj, function( key, val ) {
                            var selected='';
                            $( "#"+fieldtype+" p" ).each(function( index ,elem) {
                                if($( this ).attr('skey') == val.skill_id){ selected = "selected"; }
                            });
                            html += '<option value="'+val.skill_id+'" '+selected+'>'+val.skill+'</option>';
                        });

                    html += '</select>';           
                html += '</label><div class="note"><strong> <i class="fa fa-info-circle" ></i> Info : </strong>  Click select box and select multipal skills.</div></section>';      
            }
            else if(fieldtype == 'employment') {
                model.modal('show');
                // alert(fieldtype);
                html += '<p><b>'+title+'</b><i class="add-group fa fa-plus pull-right "></i></p> <input type="hidden" value="'+fieldtype+'" name="type" >';
                html += '<div class="edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'">';
                    $( "#employment_list li" ).each(function( index ,elem) {
                        var m = $(this),
                            title = m[0].children[0].children[0].innerText,
                            Company = m[0].children[2].children[0].innerText,
                            From = m[0].children[0].children[1].innerText,
                            Description = m[0].children[2].children[1].innerText; 
                        var result = From.split(' - ');
                    // console.log(index);
                    html +='<div class="group col-xs-12 group-'+listindex+'">';
                    html +='<h3 class="col-md-12">'+title;
                        if(index !=0){
                            html +='<i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-'+listindex+'"></i>';
                        }
                        html += '</h3><div class=" col-md-6"><label>Title</label>';
                        html +='<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="'+title+'" name="post[]" />';
                        html += '</div>';                       
                        html += '<div class=" col-md-6"><label >Company</label>';
                            html +='<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="'+Company+'" name="organization[]" />';
                        html += '</div>';
                        html += '<div class=" col-md-6"><label >Select From Date</label>';
                            html +='<label class="select">'+
                                    '<select name="from[]" placeholder="Selecte From" data-toggle="tooltip" data-placement="top" class="form-control" >'+
                                        '<option value="">Select From Date</option>'+
                                        '<option value="currently_work" '+( result[0] == 'currently_work' ? "selected" : "" )+'>Currently Work</option>';
                                        for(var $i='{{ date("Y") }}'; $i>1990; $i--){
                                            html +='<option value="'+$i+'" '+(result[0]==$i ? "selected" : "")+'>'+$i+'</option>';
                                        }
                                    html +='</select>'+
                                '</label>';
                        html += '</div>';
                        html += '<div class=" col-md-6"><label>Select To Date</label>';
                            html +='<label class="select">'+
                                    '<select name="to[]" placeholder="Selecte To" data-toggle="tooltip" data-placement="top" class="form-control">'+
                                        '<option value="">Select To Date</option>'+
                                        '<option value="currently_work" '+(result[1]=='currently_work' ? "selected" : "")+'>Currently Work</option>';
                                        for(var $i='{{ date("Y") }}'; $i>1990; $i--){
                                            html +='<option value="'+$i+'" '+(result[1]==$i ? "selected" : "")+'>'+$i+'</option>';
                                        }
                                    html +='</select>'+'</label><span class="error-show"></span>';
                        html += '</div>';                        

                        html += '<div class=" col-md-12"><label>Description</label>';
                            html += '<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control"  name="description[]">'+Description+'</textarea>';
                        html += '</div>';
                        html +='</div>';
                        listindex = listindex+1;
                    });
                html += '</div>';
            }
              else if(fieldtype == 'education') {
                model.modal('show');
                html += '<p><b>'+title+'</b><i class="add-group1 fa fa-plus pull-right "></i></p> <input type="hidden" value="'+fieldtype+'" name="type" >';
                html += '<div class="edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'">';
                    $( "#education_list li" ).each(function( index ,elem) {
                        var m = $(this),
                            title = m[0].children[0].children[0].innerText,
                            Company = m[0].children[2].children[0].innerText,
                            From = m[0].children[0].children[1].innerText,
                            Description = m[0].children[2].children[1].innerText;
                        var result = From.split(' - ');

                    html +='<div class="group col-xs-12 group-'+listindex+'">';
                        html +='<h3 class="col-md-12">'+title;
                        if(index !=0){
                            html +='<i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-'+listindex+'"></i>';
                        }
                        html += '</h3><div class=" col-md-6"><label>Degree</label>';
                            html +='<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="'+title+'" name="post[]" />';
                        html += '</div>';                       
                        html += '<div class=" col-md-6"><label >School/College</label>';
                            html +='<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="'+Company+'" name="organization[]" />';
                        html += '</div>';
                        html += '<div class=" col-md-6"><label >Select From Date</label>';
                           // html +='<input type="text"   value="'+result[0]+'" name="from[]" />';
                            html +='<label class="select">'+
                                    '<select name="from[]" placeholder="Selecte From" data-toggle="tooltip" data-placement="top" class="form-control">'+
                                        '<option value="">Selecte From Date</option>';

                                        for(var $i='{{ date("Y") }}'; $i>1990; $i--){

                                            html +='<option value="'+$i+'" '+(result[0]==$i ? "selected" : "")+'>'+$i+'</option>';
                                        }
                                    html +='</select>'+
                                '</label>';
                        html += '</div>';

                        html += '<div class=" col-md-6"><label>Select To Date</label>';
                        // html +='<input type="text"   value="'+result[1]+'" name="to[]" />';
                            html +='<label class="select">'+
                                    '<select name="to[]" placeholder="Selecte To " data-toggle="tooltip" data-placement="top" class="form-control">'+
                                        '<option value="">Select To Date</option>';
                                        for(var $i='{{ date("Y",strtotime("+5 year")) }}'; $i>1990; $i--){

                                            html +='<option value="'+$i+'" '+(result[1]==$i ? "selected" : "")+'>'+$i+'</option>';
                                        }
                                    html +='</select>'+
                                '</label><span class="error-show"></span>';
                        html += '</div>';                      
                        html += '<div class=" col-md-12"><label>Description</label>';
                            html += '<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control"  name="description[]">'+Description+'</textarea>';
                        html += '</div>';
                    html +='</div>';
                        listindex = listindex+1;
                    });
                html += '</div>';
            }
            id.html(html);            

            // $('.jqte-testdd').jqte();
            $('.jqte-testdd').summernote();
            $('.dropdown-toggle').dropdown();
                $('.multipalselecte').multiselect({ 
                            nonSelectedText: 'Select Skills',
                            columns: 1,
                            search: true,
                            onChange: function(option, checked) {

                            },
                            buttonContainer: '<div class="btn-grouptest" />',
                });
            
            $('.add-group').click(function(){

                listindex = listindex+1;

                var html1 ='<div class="group col-xs-12 group-'+listindex+'">';

                    html1 +='<h3 class="col-md-12">New Experience<i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-'+listindex+'"></i></h3>';

                    html1 += '<div class=" col-md-6"><label>Title</label>';

                        html1 +='<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="post[]" />';

                    html1 += '</div>';

                    

                    html1 += '<div class=" col-md-6"><label >Company</label>';

                        html1 +='<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="organization[]" />';

                    html1 += '</div>';



                    html1 += '<div class=" col-md-6"><label >Select From Date</label>';

                        html1 +='<label class="select">'+

                                    '<select name="from[]" placeholder="Selecte From Date" data-toggle="tooltip" data-placement="top" class="form-control">'+

                                        '<option value="">Select From Date</option>'+

                                        '<option value="currently_work">Currently Work</option>'+

                                        '@for($i=date("Y"); $i>1990; $i--)'+

                                            '<option value="{{$i}}">{{$i}}</option>'+

                                        '@endfor'+

                                    '</select>'+

                                '</label>';

                    html1 += '</div>';



                    html1 += '<div class=" col-md-6"><label>Select To Date</label>';

                        html1 +='<label class="select">'+

                                    '<select name="to[]" placeholder="Select To" data-toggle="tooltip" data-placement="top" class="form-control">'+

                                        '<option value="">Select To Date</option>'+

                                        '<option value="currently_work">Currently Work</option>'+

                                        '@for($i=date("Y"); $i>1990; $i--)'+

                                            '<option value="{{$i}}">{{$i}}</option>'+

                                        '@endfor'+

                                    '</select>'+

                                '</label><span class="error-show"></span>';

                    html1 += '</div>';



                    

                    html1 += '<div class=" col-md-12"><label>Description</label>';

                        html1 += '<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control"  name="description[]"></textarea>';

                    html1 += '</div>';



                html1 +='</div>';

                $('#edit-field-'+fieldtype).append(html1);

                $('#profilemodel').animate({

                    scrollTop: ($('.group-'+listindex).first().offset().top)

                },500);

            });

            $('.add-group1').click(function(){

                listindex = listindex+1;

                var html1 ='<div class="group col-xs-12 group-'+listindex+'">';

                    html1 +='<h3 class="col-md-12">New Education<i class="close-group fa fa-trash-o pull-right" onclick="closegroup(this.id);" id="group-'+listindex+'"></i></h3>';

                    html1 += '<div class=" col-md-6"><label>Degree</label>';

                        html1 +='<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="post[]" />';

                    html1 += '</div>';

                    

                    html1 += '<div class=" col-md-6"><label >School/College</label>';

                        html1 +='<input type="text" data-toggle="tooltip" data-placement="top" class="form-control"  value="" name="organization[]" />';

                    html1 += '</div>';



                    html1 += '<div class=" col-md-6"><label >Select From Date</label>';

                        html1 +='<label class="select">'+

                                    '<select name="from[]" placeholder="Select From" data-toggle="tooltip" data-placement="top" class="form-control">'+

                                        '<option value="">Select From Date</option>'+

                                        '@for($i=date("Y"); $i>1990; $i--)'+

                                            '<option value="{{$i}}">{{$i}}</option>'+

                                        '@endfor'+

                                    '</select>'+

                                '</label>';

                    html1 += '</div>';



                    html1 += '<div class=" col-md-6"><label>Select To Date</label>';

                        html1 +='<label class="select">'+

                                    '<select name="to[]" placeholder="Select To Date" data-toggle="tooltip" data-placement="top" class="form-control">'+

                                        '<option value="">Select To Date </option>'+

                                        '@for($i=date("Y",strtotime("+5 year")); $i>1990; $i--)'+

                                            '<option value="{{$i}}">{{$i}}</option>'+

                                        '@endfor'+

                                    '</select>'+

                                '</label><span class="error-show"></span>';

                    html1 += '</div>';



                    

                    html1 += '<div class=" col-md-12"><label>Description</label>';

                        html1 += '<textarea type="text" data-toggle="tooltip" data-placement="top" class="form-control"  name="description[]"></textarea>';

                    html1 += '</div>';



                html1 +='</div>';

                $('#edit-field-'+fieldtype).append(html1);

                $('#profilemodel').animate({

                    scrollTop: ($('.group-'+listindex).first().offset().top)

                },500);

            });

            

        });



        $('#edit-profile-model').submit(function(e){

            e.preventDefault();

            $('#successsome').removeClass('alert alert-success');

            var $form = $(e.target),fv= $form.data('edit-profile-model'),error = true;



            if (fieldtype == 'name' || fieldtype == 'address' || fieldtype == 'description'){

                $("#profilemodel input, #profilemodel textarea, #profilemodel select").each(function() {

                    var fieldjv = $(this);

                    if($(this).val() === "" && fieldjv[0].className !='note-codable' && fieldjv[0].className !='note-link-text form-control'&& fieldjv[0].className !='note-link-url form-control'&& fieldjv[0].className !='note-image-input form-control' && fieldjv[0].className !='note-image-url form-control col-md-12' && fieldjv[0].className !='note-video-url form-control span12'){

                        fieldjv.addClass('error-border').attr('title','Required');

                        fieldjv.tooltip({trigger:'manual'}).tooltip('show');

                        error = false;

                    }else{


                        // fieldjv.removeClass('error-border').tooltip({trigger:'manual'}).tooltip('hide');


                        

                    }

                });

            }


            // console.log(error); 


            if(error){

                

                $.ajax({

                    url: "{{url('/')}}/profile/agent/editfields",

                    type: 'POST',

                    data: $form.serialize(),

                    beforeSend: function(){$(".body-overlay").show();},

                    processData:false,

                    success: function(result) { 

                        $(".body-overlay").hide();

                        if (result.status==0 || result.status==1){ $('#successsome').addClass('show alert alert-success').removeClass('hide').text(title+' has been updated sucessfully').css({'color':'green'}); setTimeout(location.reload(),5000);}

                        if (result.status=='nameerror') { var fieldjv = $('#edit-field-name'); fieldjv.addClass('error-border').attr('title','Required'); fieldjv.tooltip({trigger:'manual'}).tooltip('show'); }

                        if (result.status=='loginerorr') { location.reload(); }

                    },

                    error: function(data) 

                    {  $(".body-overlay").hide();

                        if(data.status=='500'){

                            $("#successsome").addClass('show').removeClass('hide').text(data.statusText).css({'color':'red'});

                        }else if(data.status=='422'){

                            $("#successsome").addClass('show').removeClass('hide').text(data.responseJSON.image[0]).css({'color':'red'});

                        }

                        setInterval(function() {$(".body-overlay").hide(); },5000);

                    }   

                });

            }



        });

        /*default-proposal*/

        $('#add-default-proposal').submit(function(e){

            e.preventDefault();


            // $(".body-overlay").show();


            var esmsg = $("#message-proposal");



            var data = [];

            data = new FormData(this);
            console.log(data);
            

            if($(".type_2").is(':checked')){

                

                $('.note-editor img').attr('style', 'width: 100px !important;');



                var doc = new jsPDF("p","mm","letter");

                doc.fromHTML($("#proposals_html").summernote('code'), 10, 10, {

                    'width': 210

                }, function(a) {


                    // doc.save("Image.pdf");


                    var pdf =doc.output('blob'); 

                    data.append("data" , pdf);

                    $.ajax({

                        url: "{{url('/')}}/agent/proposal/insert",

                        type: 'POST',

                        data: data,//new FormData(this),

                        beforeSend: function(){$(".body-overlay").show();},

                        processData:false,

                        contentType: false,

                        success: function(result) { 

                            $(".body-overlay").hide();

                            $('.error-text').text('');



                            if(typeof result.error !='undefined' && result.error !=null){

                            

                                $.each( result.error, function( key, value ) {

                                        if(key=='proposal_file'){

                                         $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value+' Proposal should be less then 2MB.');
                                        }else{
                                            
                                         $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value);
                                        }
                                    });

                                esmsg.text('');

                            

                            }

                            if(typeof result.msg !='undefined' && result.msg !=null){

                            

                                if(result.msg.error !='undefined' && result.msg.error !=null){

                                    esmsg.text(result.msg.error).css({'color':'red'});

                                }else{

                                    esmsg.text('').css({'color':'green'});

                                    esmsg.addClass('alert alert-success text-center').text(result.msg);

                                    setTimeout(location.reload(),5000);

                                }

                            }

                        },

                        error: function(data) 

                        {   $(".body-overlay").hide();

                            if(data.status=='500'){

                                esmsg.text(data.statusText).css({'color':'red'});

                            }else if(data.status=='422'){

                                esmsg.text(data.responseJSON.image[0]).css({'color':'red'});

                            }

                        }

                    });             

                });

            }else{

                $.ajax({

                    url: "{{url('/')}}/agent/proposal/insert",

                    type: 'POST',

                    data: data,//new FormData(this),

                    beforeSend: function(){$(".body-overlay").show();},

                    processData:false,

                    contentType: false,

                    success: function(result) { 

                        $(".body-overlay").hide();

                        $('.error-text').text('');



                        if(typeof result.error !='undefined' && result.error !=null){

                        

                            $.each( result.error, function( key, value ) {

                                    if(key=='proposal_file'){

                                     $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value+' Proposal should be less then 2MB.');
                                    }else{
                                        
                                     $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value);
                                    }

                                });

                            esmsg.text('');

                        

                        }

                        if(typeof result.msg !='undefined' && result.msg !=null){

                        

                            if(result.msg.error !='undefined' && result.msg.error !=null){

                                esmsg.text(result.msg.error).css({'color':'red'});

                            }else{

                                esmsg.text('').css({'color':'green'});

                                esmsg.addClass('alert alert-success text-center').text(result.msg);

                                setTimeout(location.reload(),5000);

                            }

                        }

                    },

                    error: function(data) 

                    {   $(".body-overlay").hide();

                        if(data.status=='500'){

                            esmsg.text(data.statusText).css({'color':'red'});

                        }else if(data.status=='422'){

                            esmsg.text(data.responseJSON.image[0]).css({'color':'red'});

                        }

                    }

                }); 

            }

        });

        /*add-upload-all-type*/

        $('#add-upload-all-type').submit(function(e){

            e.preventDefault();

            var $form = $(e.target),esmsg = $("#message-uploadandshare");

            $.ajax({

                url: "{{url('/')}}/uploadshare/insert",

                type: 'POST',

                data: new FormData(this),

                beforeSend: function(){$(".body-overlay").show();},

                processData:false,

                contentType: false,

                success: function(result) { 

                    $(".body-overlay").hide();

                    $('.error-text').text('');



                    if(typeof result.error !='undefined' && result.error !=null){

                    

                        $.each( result.error, function( key, value ) {

                             $('#'+key+'-error').removeClass('success-text').addClass('error-text').text(value);

                            });

                        esmsg.text('');

                    

                    }

                    

                    if(typeof result.msg !='undefined' && result.msg !=null){

                    

                        if(result.msg.error !='undefined' && result.msg.error !=null){

                            esmsg.text(result.msg.error).css({'color':'red'});

                        }else{

                            esmsg.text('').css({'color':'green'});

                            esmsg.addClass('alert alert-success text-center').text(result.msg);

                            setTimeout(location.reload(),5000);

                        }

                    }

                },

                error: function(data) 

                {   $(".body-overlay").hide();

                    if(data.status=='500'){

                        esmsg.text(data.statusText).css({'color':'red'});

                    }else if(data.status=='422'){

                        esmsg.text(data.responseJSON.image[0]).css({'color':'red'});

                    }


                    // setInterval(function() {$(".body-overlay").hide(); },1000);


                }

            });

        });




        // $("#proposal-file").change(function(){
   //           pdffile=document.getElementById("proposal-file").files[0];
   //          src = URL.createObjectURL(pdffile);
   //          var extension = src.substr( (src.lastIndexOf('.') +1) );
            //  extension = extension.toLowerCase();
            // var docs='';
            //  if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){
            //      docs ='<img         class="" src="'+src+'" frameborder="0" scrolling="no"  width="225" height="150">';
            //  }else{
            //      docs ='<iframe  class="" src="https://docs.google.com/viewer?url='+src+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';
            //  }               
            // $('#viewer').html(docs).removeClass('hide');
   //            // $('#viewer').attr('src',pdffile_url).removeClass('hide');
      //   });




        $('.defaultproposal').click(function(e){

            e.preventDefault();

            $('#proposals_title').val('');

            $('#viewer').attr('src','').addClass('hide');

            $('#proposal_id_update').val('');


            // $('#proposals_html').jqteVal('');


            $('#proposals_html').summernote('code');

            $('#defaultproposal').modal('show');

        });

        $('#loadmoreproposal').click(function(e){

            e.preventDefault();

            var limit = $(this).attr('title');

            loadproposal(limit);

        });

        /*default-proposal*/

        /* upload and share */

        $('.uploadandshare').click(function(e){

            e.preventDefault();

            $('#upload_viewer').attr('src','').addClass('hide');

            $('#uploadshare_id_update').val('');

            $('#uploadandshare').modal('show');

        });

        $('#loaduploadandshare').click(function(e){

            e.preventDefault();

            var limit = $(this).attr('title');

            loaduploadandshare(limit);

        });

        loadproposal(0);        

        loaduploadandshare(0);  

        $('#searchproposalshareuser').submit(function(e){

            e.preventDefault();

            shareproposalpopup($('#praposalid').val());

        });

        $('#searchdocumentsshareuser').submit(function(e){

            e.preventDefault();

            shareuploadshare($('#documentid').val());

        });

    });

    

    function closegroup(id) {

        var error_span = $('.error-show').text();

        if(error_span ==''){

            $('#edit-profile').prop("disabled", false);

        }

        $('.'+id).remove();

    }

    

    /*load proposal */

    function loadproposal(limit) {



        $.ajax({

            url: "{{url('/')}}/agent/proposal/get/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",
            type: 'get',
            beforeSend: function(){$(".loadproposal").show();},
            processData:false,
            contentType: false,
            success: function(result) { 
                $(".loadproposal").hide();
                if(result.count !== 0){                  
                    $.each( result.result, function( key, value ) {
                        proposale_data[value.proposals_id] = value;
                        var extension = value.proposals_attachments.substr( (value.proposals_attachments.lastIndexOf('.') +1) );
                            extension = extension.toLowerCase();
                        var docep='';
                        if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){
                            docep   ='<img      class="documen document_'+value.proposals_id+'" src="'+value.proposals_attachments+'" frameborder="0" scrolling="no" width="225" height="150">';
                        }else{
                            docep   ='<iframe   class="documen document_'+value.proposals_id+'" src="https://docs.google.com/viewer?url='+value.proposals_attachments+'&embedded=true" frameborder="0" scrolling="no" width="225" height="142"></iframe>';
                        }
                        var htmll = '<div class="col-md-4">'+
                                        '<div class="thumbnails thumbnail-style thumbnail-kenburn">'+
                                            '<div class="cbp-caption thumbnail-img">'+
                                                '<div class="overflow-hidden cbp-caption-defaultWrap">'+
                                                    docep+
                                                '</div>'+
                                                '<div class="removehover cbp-caption-activeWrap">'+
                                                    '<div class="cbp-l-caption-alignCenter">'+
                                                        '<div class="cbp-l-caption-body">'+
                                                            '<ul class="link-captions no-bottom-space">'+
                                                                '<li><a class="cursor" title="View" onclick="openpropop('+value.proposals_id+')" id="'+value.proposals_id+'"><i class="rounded-x fa fa-eye"></i></a>'+
                                                                '<li><a class="cursor" Title="Share" onclick="shareproposalpopup('+value.proposals_id+')" id="'+value.proposals_id+'"><i class="rounded-x fa fa-share-alt"></i></a>'+
                                                                '<li><a class="cursor" Title="Remove" onclick="removeproposal('+value.proposals_id+')" id="'+value.proposals_id+'"><i class="rounded-x fa fa-trash-o"></i></a>'+
                                                            '</ul>'+
                                                        '</div>'+
                                                    '</div>'+      
                                                '</div>'+
                                            '</div>'+

                                            '<div class="caption cbp-title-dark">'+

                                                '<span class="cbp-l-grid-agency-title"><a class="cursor hover-effect" onclick="openpropop('+value.proposals_id+')"   title="'+value.proposals_attachments+'"><strong class="showTitle">'+value.proposals_title+'</strong></a></span>'+

                                            '</div>'+
                                        '</div>'+
                                    '</div>';

                        $('#append-proposal-ajax').append(htmll);
                    });

                    if(result.next!=0){

                        $('#addnewproposal').addClass('hide');

                        $('#loadmoreproposal').removeClass('hide').attr('title',result.next);

                    }else{

                        $('#loadmoreproposal').addClass('hide');

                    }

                }

                

            },

            error: function(data) 

            {   $(".loadproposal").hide();

                if(data.status=='500'){

                    $('.loadproposal').text(data.statusText).css({'color':'red'});

                }else if(data.status=='422'){

                    $('.loadproposal').text(data.responseJSON.image[0]).css({'color':'red'});

                }

            }

        });

    }

    function openpropop(el) {

        var src = proposale_data[el].proposals_attachments;

        var text = proposale_data[el].proposals_title;

        $('.proposal-popup-title').text(text);

        var extension = src.substr( (src.lastIndexOf('.') +1) );

            extension = extension.toLowerCase();

        var docs='';

            if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){

                docs ='<img         class="documen document_'+proposale_data[el].proposals_id+'" src="'+proposale_data[el].proposals_attachments+'" frameborder="0" scrolling="no"  width="225" height="150">';

            }else{

                docs ='<iframe  class="documen document_'+proposale_data[el].proposals_id+'" src="https://docs.google.com/viewer?url='+proposale_data[el].proposals_attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';

            }

        $('.append-src-ifram').html(docs+

                                        '<div class="modal-footer">'+

                                            '<button type="button" class="btn-u btn-u-primary" Title="Update" onclick="proposal_Edit('+el+');" data-dismiss="modal">Edit</button>'+

                                            '<button type="button" class="btn-u btn-u-primary" Title="Remove" onclick="removeproposal('+el+');" data-dismiss="modal">Delete</button>'+

                                            '<button type="button" class="btn-u btn-u-default" Title="Close Popup" data-dismiss="modal">Close</button>'+

                                        '</div>');

        $('#open-proposal-popup').modal('show');

    }

    function removeproposal(el) {

        var text = proposale_data[el].proposals_title;

        $('.proposal-popup-title').text('Are you sure you want to remove "'+text+'" from your proposals?');

        

        $('#proposaledeleteconfirm')

            .modal({ backdrop: 'static', keyboard: false })

            .one('click', '#delete', function (e) {

        

            $.ajax({

                url: "{{url('/')}}/agent/proposal/delete/"+el,

                type: 'get',

                beforeSend: function(){$(".body-overlay").show();},

                processData:false,

                success: function(result) { 

                    $(".body-overlay").hide();

                    if(result.status=='error'){

                        $('.proposal-delete-msg').addClass('alert alert-danger text-center').text(result.msg);

                    }else{

                        $('.proposal-delete-msg').addClass('alert alert-success text-center').text(result.msg);

                    }

                    setTimeout(location.reload(),7000);

                },error: function(data) {   $(".body-overlay").hide();  }

                    

            });

        

        });



    }

    function shareproposalpopup(id) {

        var praposaldata = proposale_data[id];

        $('#append-proposal-share-user-list').html('');

        $('#open-proposal-share').modal('show');



        $('#praposalid').val(id);

        var keyword = $('#proposalkeyword').val();          

        var address = $('#proposaladdress').val();      

        var date = $('#proposaldate').val();    

        

        $.ajax({

            url: "{{url('/')}}/shared/proposals/with/connected/users/by/"+id+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",

            type: 'post',

            data: {date :date,keyword : keyword,address : address,_token : '{{ csrf_token() }}'},

            headers: {

                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                },

            beforeSend: function(){$(".loadproposalshare").show();},

            success: function(result) { 

                $(".loadproposalshare").hide();

                if(result.count !== 0){

                    $.each( result.result, function( index, value ) {

                        shared_proposal_connected_user_list[value.details_id] = value;

                        if(value.share_file.result != '' && value.share_file.result != null){

                            var asrvfun ='<input type="checkbox" checked onclick="shareproposalremove('+value.details_id+','+id+','+value.share_file.result.shared_id+')" name="proposale-checkox-'+value.details_id+'"><i class="o-p-a"></i>';

                        }else{

                            var asrvfun ='<input type="checkbox" onclick="shareproposal('+value.details_id+','+id+')"  name="proposale-checkox-'+value.details_id+'"><i class="n-p-a"></i>';

                        } 

                        var htmll = '<section><label class="checkbox" style="border-bottom: 1px solid #e6e6e6;">'+

                                        '<span class="proposal_share_'+value.details_id+'_'+value.details_id_role_id+'">'+asrvfun+'</span>'+

                                        '<strong>'+value.name+'</strong>'+

                                        '<p>(<small>'+

                                        value.posttitle+

                                        '<small>)</p>'+

                                    '</label></section>';

                        $('#append-proposal-share-user-list').append(htmll);

                    });

                }

                

            },

            error: function(data) 

            {   

                $(".loadproposalshare").hide();

                if(data.status=='500'){

                    $('#append-proposal-share-user-list').text(data.statusText).css({'color':'red'});

                }else if(data.status=='422'){

                    $('#append-proposal-share-user-list').text(data.responseJSON.image[0]).css({'color':'red'});

                }

            }

        });

    }

    function shareproposal(userid,id) {

        var userdata = shared_proposal_connected_user_list[userid];

        $.ajax({

            url: "{{url('/shared/data/insert')}}",

            type: 'post',

            data: {notification_type : 3,notification_message : '{{ $userdetails->name }} share a proposal related to your post `'+userdata.posttitle+'`' ,shared_type:3 ,shared_item_id:id,shared_item_type : 1,shared_item_type_id : userdata.post_id,receiver_id : userdata.details_id,receiver_role: userdata.details_id_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},

            success: function(result) { 

                $('.proposal_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" checked onclick="shareproposalremove('+userid+','+id+','+result.data+')"  name="proposale-checkox-'+userdata.details_id+'"><i class="o-p-a"></i>');

            },error: function(result) { 

            }

        });  



    }

    function shareproposalremove(userid,id,shared_id) {     

        var userdata = shared_proposal_connected_user_list[userid];

        $.ajax({

            url: "{{url('/shared/data/delete')}}",

            type: 'post',

            data: { id : id, shared_id : shared_id, _token : '{{ csrf_token() }}' },

            success: function(result) { 

                $('.proposal_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" onclick="shareproposal('+userid+','+id+')"  name="proposale-checkox-'+userdata.details_id+'"><i class="n-p-a"></i>');

            },error: function(result) { 

            }

        });    

    }

    function proposal_Edit(el) {

        var src = proposale_data[el].proposals_attachments;

        var type = proposale_data[el].type;

        var proposals_html = proposale_data[el].proposals_html;



        $('#proposals_title').val(proposale_data[el].proposals_title);

        $('#proposal_id_update').val(el);

        

        if(type==1){

            $(".filesupload").addClass('show').removeClass('hide');

            $(".texthtml").addClass('hide').removeClass('show');

            var extension = src.substr( (src.lastIndexOf('.') +1) );

                extension = extension.toLowerCase();

            var docs='';

                if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){

                    docs ='<img         class="" src="'+proposale_data[el].proposals_attachments+'" frameborder="0" scrolling="no"  width="225" height="150">';

                }else{

                    docs ='<iframe  class="" src="https://docs.google.com/viewer?url='+proposale_data[el].proposals_attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';

                }               

            $('#viewer').html(docs).removeClass('hide');

            $(".type_1").prop("checked", true);

        }else{

            $(".filesupload").addClass('hide').removeClass('show');

            $(".texthtml").addClass('show').removeClass('hide');


            // $('#proposals_html').jqteVal(proposals_html);


            $('#proposals_html').summernote('code',proposals_html);

            $(".type_2").prop("checked", true);

        }

        $('#open-proposal-popup').on('hidden.bs.modal', function (e) {

            if($('#proposal_id_update').val() !=''){

                $('#defaultproposal').modal('show');

            }

        });

    }

    /* end */

    /*load uploadandshare */

    function loaduploadandshare(limit) {



        $.ajax({

            url: "{{url('/')}}/uploadshare/get/"+limit+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",

            type: 'get',

            beforeSend: function(){$(".loaduploadshare").show();},

            processData:false,

            contentType: false,

            success: function(result) { 

                $(".loaduploadshare").hide();


                // console.log(result);


                if(result.count !== 0){

                    $.each( result.result, function( key, value ) {

                        uploadshare_data[value.upload_share_id] = value;

                        var extension = value.attachments.substr( (value.attachments.lastIndexOf('.') +1) );

                            extension = extension.toLowerCase();

                        var docs = '';

                            if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){

                                docs ='<img         class="documen document_'+value.upload_share_id+'" src="'+value.attachments+'" frameborder="0" scrolling="no"  width="225" height="150">';

                            }else{

                                docs ='<iframe  class="documen document_'+value.upload_share_id+'" src="https://docs.google.com/viewer?url='+value.attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';
                            }
                            if(value.name == ''){
                            var docName = value.attachments.replace(/^.*[\\\/]/, '');
                            }else{
                            var docName = value.name;
                            }    

                        var htmll = '<div class="col-md-4">'+
                                        '<div class="thumbnails thumbnail-style thumbnail-kenburn">'+
                                            '<div class="cbp-caption thumbnail-img">'+
                                                '<div class="overflow-hidden cbp-caption-defaultWrap">'+docs+'</div>'+
                                                '<div class="removehover cbp-caption-activeWrap">'+
                                                    '<div class="cbp-l-caption-alignCenter">'+
                                                        '<div class="cbp-l-caption-body">'+
                                                            '<ul class="link-captions no-bottom-space">'+
                                                                '<li><a class="cursor" title="View" onclick="openuploadshare('+value.upload_share_id+')"><i class="rounded-x fa fa-eye"></i></a>'+
                                                                '<li><a class="cursor" title="Share" onclick="shareuploadshare('+value.upload_share_id+')"><i class="rounded-x fa fa-share-alt"></i></a>'+
                                                                '<li><a class="cursor" title="Remove" onclick="removeuploadshare('+value.upload_share_id+')"><i class="rounded-x fa fa-trash-o"></i></a>'+
                                                            '</ul>'+
                                                        '</div>'+
                                                    '</div>'+       
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '<h4 class="text-center">'+docName+'</h4>'+
                                    '</div>';
                        $('#append-uploadshares-ajax').append(htmll);
                    });

                    if(result.next!=0){

                        $('#addnewupload').addClass('hide');

                        $('#loaduploadandshare').removeClass('hide').attr('title',result.next);

                    }else{

                        $('#loaduploadandshare').addClass('hide');

                    }

                }

                

            },

            error: function(data) 

            {   $(".loaduploadshare").hide();

                if(data.status=='500'){

                    $('.loaduploadshare').text(data.statusText).css({'color':'red'});

                }else if(data.status=='422'){

                    $('.loaduploadshare').text(data.responseJSON.image[0]).css({'color':'red'});

                }

            }

        });

    }

    function openuploadshare(el) {

        var src = uploadshare_data[el].attachments;

        var extension = uploadshare_data[el].attachments.substr( (uploadshare_data[el].attachments.lastIndexOf('.') +1) );

            extension = extension.toLowerCase();

        var docs='';

        if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){

            docs ='<img         class="documen document_uploadfiles_'+uploadshare_data[el].upload_share_id+'" src="'+uploadshare_data[el].attachments+'" frameborder="0" scrolling="no" width="225" height="150">';

        }else{

            docs ='<iframe  class="documen document_uploadfiles_'+uploadshare_data[el].upload_share_id+'" src="https://docs.google.com/viewer?url='+uploadshare_data[el].attachments+'&embedded=true" frameborder="0" scrolling="no" width="225" height="142"></iframe>';

        }

        var hh =    docs+

                    '<div class="modal-footer">'+

                        '<button type="button" class="btn-u btn-u-primary" onclick="uploadshare_Edit('+el+');" data-dismiss="modal">Edit</button>'+

                        '<button type="button" class="btn-u btn-u-primary" onclick="removeuploadshare('+el+');" data-dismiss="modal">Delete</button>'+

                        '<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>'+

                    '</div>';

        $('.uploadshare-src-ifram').html(hh);

        $('#open-uploadshare-popup').modal('show');

    }

    function removeuploadshare(el) {

        var value = uploadshare_data[el];



        var extension = value.attachments.substr( (value.attachments.lastIndexOf('.') +1) );

            extension = extension.toLowerCase();

        var docs = '';

            if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){

                docs ='<img class="documen document_'+value.upload_share_id+'" src="'+value.attachments+'" frameborder="0" scrolling="no"  width="225" height="150">';

            }else{

                docs ='<iframe  class="documen document_'+value.upload_share_id+'" src="https://docs.google.com/viewer?url='+value.attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>'; 

            }

        $('.upload-popup-title').html('<p>Are you sure you want to remove from your Documents?</p> <br /> '+docs);

        $('#uploadsharedeleteconfirm')

            .modal({ backdrop: 'static', keyboard: false })

            .one('click', '#delete', function (e) {

        

            $.ajax({

                url: "{{url('/')}}/uploadshare/delete/"+el,

                type: 'get',

                beforeSend: function(){$(".body-overlay").show();},

                processData:false,

                success: function(result) { 

                    $(".body-overlay").hide();

                    if(result.status=='error'){

                        $('.upload-delete-msg').addClass('alert alert-danger text-center').text(result.msg);

                    }else{

                        $('.upload-delete-msg').addClass('alert alert-success text-center').text(result.msg);

                    }

                    setTimeout(location.reload(),7000);

                },error: function(data) {   $(".body-overlay").hide();  }

                    

            });

        

        });



    }



    function shareuploadshare(id) {

        var praposaldata = uploadshare_data[id];

        $('#append-Document-share-user-list').html('');

        $('#open-Document-share').modal('show');

        

        $('#documentid').val(id);

        var keyword = $('#documentskeyword').val();         

        var address = $('#documentsaddress').val();     

        var date = $('#documentsdate').val();   



        $.ajax({

            url: "{{url('/')}}/shared/documents/with/connected/users/by/"+id+"/{{ $user->id }}/{{ $user->agents_users_role_id }}",

            type: 'post',

            data: {date :date,keyword : keyword,address : address,_token : '{{ csrf_token() }}'},

            headers: {

                    'X-CSRF-TOKEN': '{{ csrf_token() }}'

                },

            beforeSend: function(){$(".loadDocumentshare").show();},

            success: function(result) { 

                $(".loadDocumentshare").hide();

                if(result.count !== 0){

                    $.each( result.result, function( index, value ) {

                        shared_document_connected_user_list[value.details_id] = value;

                        if(value.share_file.result != '' && value.share_file.result != null){

                            var asrvfun ='<input type="checkbox" checked onclick="shareDocumentremove('+value.details_id+','+id+','+value.share_file.result.shared_id+')" name="Documente-checkox-'+value.details_id+'"><i class="o-p-a"></i>';

                        }else{

                            var asrvfun ='<input type="checkbox" onclick="shareDocument('+value.details_id+','+id+')"  name="Documente-checkox-'+value.details_id+'"><i class="n-p-a"></i>';

                        } 
                        let docName = "";
                        if(value.name != ''){
                            docName = value.name;
                        }else{
                            let completeUrl = value.attachments;
                            let tempdocName = completeUrl.toString().match(/.*\/(.+?)\./);
                            if (tempdocName && tempdocName.length > 1){
                                docName = tempdocName[1];
                            }else{
                                docName = '';
                            }
                        }

                        var htmll = '<section><label class="checkbox" style="border-bottom: 1px solid #e6e6e6;">'+

                                        '<span class="Document_share_'+value.details_id+'_'+value.details_id_role_id+'">'+asrvfun+'</span>'+

                                        '<strong>'+value.name+'</strong>'+

                                        '<p>(<small>'+

                                        value.posttitle+

                                        '<small>)</p>'+

                                    '</label></section>';

                        $('#append-Document-share-user-list').append(htmll);

                    });

                }else{
					let no_records = `No Records Found`;
					$('#append-Document-share-user-list').html(no_records);
				}

                

            },

            error: function(data) 

            {   

                $(".loadDocumentshare").hide();

                if(data.status=='500'){

                    $('#append-Document-share-user-list').text(data.statusText).css({'color':'red'});

                }else if(data.status=='422'){

                    $('#append-Document-share-user-list').text(data.responseJSON.image[0]).css({'color':'red'});

                }

            }

        });

    }

    function shareDocument(userid,id) {

        var userdata = shared_document_connected_user_list[userid];

        $.ajax({

            url: "{{url('/shared/data/insert')}}",

            type: 'post',

            data: {notification_type : 2,notification_message : '{{ $userdetails->name }} share a Document related to your post `'+userdata.posttitle+'`' ,shared_type:2 ,shared_item_id:id,shared_item_type : 1,shared_item_type_id : userdata.post_id,receiver_id : userdata.details_id,receiver_role: userdata.details_id_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},

            success: function(result) { 
                msgshowfewsecond('Document shared successfully');

                $('.Document_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" checked onclick="shareDocumentremove('+userid+','+id+','+result.data+')"  name="Documente-checkox-'+userdata.details_id+'"><i class="o-p-a"></i>');

            },error: function(result) { 

            }

        });  



    }

    function shareDocumentremove(userid,id,shared_id) {     

        var userdata = shared_document_connected_user_list[userid];

        $.ajax({

            url: "{{url('/shared/data/delete')}}",

            type: 'post',

            data: { id : id, shared_id : shared_id, _token : '{{ csrf_token() }}' },

            success: function(result) { 
                msgshowfewsecond('Document removed successfully');

                $('.Document_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" onclick="shareDocument('+userid+','+id+')"  name="Documente-checkox-'+userdata.details_id+'"><i class="n-p-a"></i>');

            },error: function(result) { 

            }

        });    

    }

    function uploadshare_Edit(el) {

        $('#uploadshare_id_update').val(el);

        $('#uploadandshare').modal('show');

    }

    $('#open-Document-share').on('hidden.bs.modal', function () {
	    ($("#searchdocumentsshareuser")[0]).reset();
	});

	$("#uploadandshare").on('hidden.bs.modal', function () {
		($("#add-upload-all-type")[0]).reset();
		$("#uploadandshare").find(".error-text").html("");
    });
    
    /* end */

    $(document).ready(function(){

            $('.jqte-testdd').summernote();

            $('.dropdown-toggle').dropdown();           

       });

</script> 

@stop