@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/shortcode_timeline2.css') }}">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@stop
@section('title', 'Profile')
@section('content')
<?php  $topmenu='Home'; ?>
<?php $activemenu = 'buyer'; ?>
@include('dashboard.include.sidebar')

<!--=== Profile ===-->
    <div class="container content profile">
        <div class="row">
            <!--Left Sidebar-->
            @include('dashboard.user.buyers.include.sidebar') 
            @include('dashboard.user.buyers.include.sidebar-profile')
            <!--End Left Sidebar-->

            <!-- Profile Content -->
            <!-- col-9 -->
            <div class="col-md-9">
                <div class="profile-body margin-bottom-10">
                    <div class="profile-bio">
                        <div class="row">
                            <div class="col-md-12 ">
                                <img data-toggle="modal" style="cursor: pointer;" data-target="#changeprofilepic" width="80" height="80" id="profile-pic" src="@if($userdetails->photo != ''){{ url('/assets/img/profile/'.$userdetails->photo) }}@else{{ url('/assets/img/team/img32-md.jpg') }} @endif" alt="img04" class="img-circle header-circle-img1 img-margin">
                                <h2 class="name" id="name" title="Full Name"> 
                                    {{ ucfirst($userdetails->name)}} @php echo $editfield @endphp 
                                </h2>
                                <span class="address" id="address" title="Address"><strong> <i class="fa fa-map-marker text-16"></i> </strong> 
                                    {{ $userdetails->address}} @php echo $editfield @endphp
                                </span>
                            </div>
                            <div class="col-md-12 margin-top-20">
                                <span class="description" id="description" title="Description"> <strong> </strong> {!! $userdetails->description !!} @php echo $editfield @endphp</span>
                            </div>
                        </div>
                    </div><!--/end row-->
                </div> 
                <div class="box-shadow-profile ">
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

            </div>
            <!-- col-9 -->
            <!-- col-3 -->
            <!-- <div class="col-md-3 sm-margin-bottom-20 grid cs-style-5">
                <a href="{{url('/profile/buyer/settings')}}" class="cursor btn-block btn btn-default"> Profile Settings </a>
                <hr>
            </div> -->
            <!-- col-3 -->
            <!-- End Profile Content -->
        </div>
    </div>  
    <!-- <button class="btn-u" data-toggle="modal" data-target="#profilemodel">Modal Form Sample</button> -->
    <div class="modal fade" id="profilemodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
                {!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'edit-profile-model')) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel4">{{ucfirst($userdetails->name)}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <p class="col-md-12 success-text center hide" id="successsome"></p>
                            <div class="col-md-12" id="field-add-model">
                                                        
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="<?php echo $user->id; ?>" name="id" >
                        <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn-u btn-u-primary" name="edit-profile-submit" value="Save changes" title="Save changes">Save Changess</button>
                    </div>
                {!!Form::close()!!}
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
                        <br>
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
                            <div id="message-uploadandshare" class="message-uploadandshare"> </div>
							<label>File Name</label>
							<section>
									<label for="file" class="input input-file">
									<input type="text" name="name" />
								</label>
								<p class="error-text name-error" id="name-error"></p>
							</section>

                            <label>Upload File</label>
                            <section>
                                <label for="file" class="input input-file">
                                    <div class="button"><input type="file" id="uploadshare-file" name="uploadshare" onchange="this.parentNode.nextSibling.value = this.value.replace(/^.*\\/, '')">Upload files </div><input type="text" placeholder="Upload files" readonly>
                                </label>
                                <p class="error-text uploadshare-error" id="uploadshare-error"></p>
                            </section>      
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" name="id" id="uploadshare_id_update" >
                        <input type="hidden" value="<?php echo $user->id; ?>" name="agents_user_id" >
                        <input type="hidden" value="<?php echo $user->agents_users_role_id; ?>" name="agents_users_role_id" >
                        <button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn-u btn-u-primary" name="add-proposal-submit" value="Save changes" title="Save changes">Save</button>
                    </div>
                {!!Form::close()!!}
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
                    <h4 class="modal-title">Share Documents With Seller/Buyer</h4>
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
    
    $('#open-Document-share').on('hidden.bs.modal', function () {
	    ($("#searchdocumentsshareuser")[0]).reset();
	});

	$("#uploadandshare").on('hidden.bs.modal', function () {
		($("#add-upload-all-type")[0]).reset();
		$("#uploadandshare").find(".error-text").html("");
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
<script type="text/javascript">


    var uploadshare_data = [];
    var shared_document_connected_user_list = [];
    (function() {
        var a,listindex,fieldtype,innerHTML,innerText,html,title,id = $('#field-add-model'),model = $('#profilemodel');
        
        $('.field-edit').click(function(){
            a = $(this).parent(),listindex=1,fieldtype = a[0].id,innerHTML = a[0].innerHTML,innerText = a[0].innerText,html='',title = a[0].title,id = $('#field-add-model'),model = $('#profilemodel');
            $('#successsome').text('');
            
           
            if (fieldtype == 'name' || fieldtype == 'address'){

                model.modal('show');
                innerText = $.trim(innerText.replace('<?php echo $editfield; ?>', ''));
                innerText = $.trim(innerText.replace('Address:', ''));
                html += '<section><label class="label">'+title+'<span class="mandatory">*</span></label>';
                html += '<label class="input">';
                html += '<input type="text" data-toggle="tooltip" data-placement="top" class="form-control edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" value="'+innerText+'" name="'+fieldtype+'" />';
                html += '</label></section>';
            }
            else if(fieldtype == 'description') {
                model.modal('show');
                innerText = $.trim(innerText.replace('{!! $editfield !!}', ''));
                innerText = $.trim(innerText.replace('Description:', ''));
                html += '<section><label class="label">'+title+'<span class="mandatory">*</span></label>';
                html += '<label class="textarea">';
                    html += '<textarea rows="5"  type="text" data-toggle="tooltip" data-placement="top" class="summernote form-control jqte-testdd edit-field-'+fieldtype+'" id="edit-field-'+fieldtype+'" name="'+fieldtype+'">'+innerText+'</textarea>';
                html += '</label></section>';
            }


            
            id.html(html);
	            $('.jqte-testdd').summernote({
	  dialogsInBody: true
	})
            //$('.jqte-testdd').jqte();
              
            $('.dropdown-toggle').dropdown();
        });
        
        $('#edit-profile-model').submit(function(e){ 
            e.preventDefault();
            $('#successsome').removeClass('alert alert-success');
            var $form = $(e.target),fv= $form.data('edit-profile-model'),error = true;
            //alert($form.serialize());
            //alert('5');  
		if(fieldtype == 'description'){

               var a=  $.trim($('.jqte-testdd').val());
              
			//$('.note-editor').each(function(){
							
					if ($('.jqte-testdd').summernote('isEmpty')) {						
						$('.jqte-testdd').summernote('reset');
						error = false;	
						var div = $('.note-editor');
						div.addClass('error-border').attr('title','');
                        			div.tooltip({trigger:'manual'}).tooltip('show');
                        
					}else if($('.jqte-testdd').val()=='<p><br></p>'){									
						$('.jqte-testdd').summernote('reset');
						
						div.addClass('error-border').attr('title','Required');
                        			div.tooltip({trigger:'manual'}).tooltip('show');
					error = false;							
					}
			//});                    
                    }
             
			
		

            if (fieldtype == 'name' || fieldtype == 'address' ){
                      				   
                $("#profilemodel input, #profilemodel textarea").each(function() {

                    var fieldjv = $(this);
                    
                    if($(this).val() === "" && fieldjv[0].className !='note-codable' && fieldjv[0].className !='note-link-text form-control'&& fieldjv[0].className !='note-link-url form-control'&& fieldjv[0].className !='note-image-input form-control' && fieldjv[0].className !='note-image-url form-control col-md-12' && fieldjv[0].className !='note-video-url form-control span12'){
                        fieldjv.addClass('error-border').attr('title','Required');
                        fieldjv.tooltip({trigger:'manual'}).tooltip('show');
                        error = false;
                    }else{
                        //fieldjv.removeClass('error-border').tooltip({trigger:'manual'}).tooltip('hide');
                    }
                });
            }
            if(error){
                $.ajax({
                    url: "{{url('/')}}/profile/buyer/editfields",
                    type: 'POST',
                    data: $form.serialize(),
                    beforeSend: function(){$(".body-overlay").show();},
                    processData:false,
                    success: function(result) { 
                        //console.log(result);
                        $(".body-overlay").hide();
                        
                        if (result.status==0 || result.status==1){ $('#successsome').addClass('show alert alert-success').removeClass('hide').text(title+' has been updated sucessfully'); setTimeout(location.reload(),50);}
                        if (result.status=='nameerror') { 
                            var fieldjv1 = $('#edit-field-name'); 
                            fieldjv1.addClass('error-border').attr('title','Required'); 
                            fieldjv1.tooltip({trigger:'manual'}).tooltip('show'); }
                         if (result.status=='addresserror') { 
                            var fieldjv1 = $('#edit-field-address'); 
                            fieldjv1.addClass('error-border').attr('title','Required'); 
                            fieldjv1.tooltip({trigger:'manual'}).tooltip('show'); }
                        if (result.status=='loginerorr') { location.reload(); }
                    },
                    error: function(data) 
                    
                    {   $(".body-overlay").hide();
                        if(data.status=='500'){
                            $("#successsome").addClass('show').removeClass('hide').text(data.statusText).css({'color':'red'});
                        }else if(data.status=='422'){
                            $("#successsome").addClass('show').removeClass('hide').text(data.responseJSON.image[0]).css({'color':'red'});
                        }
                        setInterval(function() {$(".body-overlay").hide(); },50);
                    }   
                });
            }

        });

        /* upload and share */
        /*add-upload-all-type*/
        $('#add-upload-all-type').submit(function(e){
            e.preventDefault();
            var $form = $(e.target),esmsg = $("#message-uploadandshare");
            var filePath = $("#uploadshare-file").val();
            // alert(filePath);
             var path = "C:\\fakepath\\example.doc";
             var filename = path.replace(/^.*\\/, "");
             // alert(filename);
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
                {   
                    if(data.status=='500'){
                        esmsg.text(data.statusText).css({'color':'red'});
                    }else if(data.status=='422'){
                        esmsg.text(data.responseJSON.image[0]).css({'color':'red'});
                    }
                    setInterval(function() {$(".body-overlay").hide(); },1000);
                }
            });
        });
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
        loaduploadandshare(0);  
        $('#searchdocumentsshareuser').submit(function(e){
            e.preventDefault();
            shareuploadshare($('#documentid').val());
        });
    })();

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
                if(result.count !== 0){
                    $.each( result.result, function( key, value ) {
                        uploadshare_data[value.upload_share_id] = value;
                        var extension = value.attachments.substr( (value.attachments.lastIndexOf('.') +1) );
                            extension = extension.toLowerCase();
                        var docs = '';
                            if(extension=='png' || extension=='jpg' || extension=='jpeg' || extension=='gif' || extension=='tif'){
                                docs ='<img         class="documen document_'+value.upload_share_id+'" src="'+value.attachments+'" frameborder="0" scrolling="no"  width="225" height="142">';
                            }else{
                                docs ='<iframe  class="documen document_'+value.upload_share_id+'" src="https://docs.google.com/viewer?url='+value.attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';
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
                                        '<h4 class="text-center">'+value.name+'</h4>'+
                                    '</div>';
                        $('#append-uploadshares-ajax').append(htmll);
                    });
                    if(result.next!=0){
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
            docs ='<img         class="documen document_uploadfiles_'+uploadshare_data[el].upload_share_id+'" src="'+uploadshare_data[el].attachments+'" frameborder="0" scrolling="no" width="100%" height="300">';
        }else{
            docs ='<iframe  class="documen document_uploadfiles_'+uploadshare_data[el].upload_share_id+'" src="https://docs.google.com/viewer?url='+uploadshare_data[el].attachments+'&embedded=true" frameborder="0" scrolling="no" width="100%" height="300"></iframe>';
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
                docs ='<img         class="documen document_'+value.upload_share_id+'" src="'+value.attachments+'" frameborder="0" scrolling="no"  width="225" height="142">';
            }else{
                docs ='<iframe  class="documen document_'+value.upload_share_id+'" src="https://docs.google.com/viewer?url='+value.attachments+'&embedded=true" frameborder="0" scrolling="no"  width="225" height="142"></iframe>';
            }
        $('.upload-popup-title').html('<p>Are You Sure Want To Remove this Document?</p> <br> '+docs);
        $('#uploadsharedeleteconfirm')
            .modal({ backdrop: 'static', keyboard: false })
            .one('click', '#delete', function (e) {
        
            $.ajax({
                url: "/uploadshare/delete/"+el,
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
                        var htmll = '<section><label class="checkbox" style="border-bottom: 1px solid #e6e6e6;">'+
                                        '<span class="Document_share_'+value.details_id+'_'+value.details_id_role_id+'">'+asrvfun+'</span>'+
                                        '<strong>'+value.name+'</strong>'+
                                        '<p>(<small>'+
                                        value.posttitle+
                                        '<small>)</p>'+
                                    '</label></section>';
                        $('#append-Document-share-user-list').append(htmll);
                    });
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
            data: {notification_type : 2,notification_message : '{{ $userdetails->name }} share a Document related to your post `'+userdata.posttitle+'`' ,shared_type:2 ,shared_item_id:id,shared_item_type : 2,shared_item_type_id : userdata.post_id,receiver_id : userdata.details_id,receiver_role: userdata.details_id_role_id,sender_id: '{{ $user->id }}',sender_role : '{{ $user->agents_users_role_id }}',_token : '{{ csrf_token() }}'},
            success: function(result) { 
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
                $('.Document_share_'+userid+'_'+userdata.details_id_role_id).html('<input type="checkbox" onclick="shareDocument('+userid+','+id+')"  name="Documente-checkox-'+userdata.details_id+'"><i class="n-p-a"></i>');
            },error: function(result) { 
            }
        });    
    }
    function uploadshare_Edit(el) {
        $('#uploadshare_id_update').val(el);
        $('#uploadandshare').modal('show');
    }
    /* end */

    
</script> 
@stop
