@extends('admin.master')
@section('title', 'dashboard')
@section('style')
@stop
@section('content')
    <div class="content-wrapper">   
    <section class="content-header">
      <h1>
	  {{$tag}} Questions
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.getQuestionAnswers')}}">Questions</a></li>
        <li class="active">{{$tag}} Questions</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
        
              <li class="active"><a class="active" href="#settings" data-toggle="tab">Questions</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
               
              <div class="tab-pane" id="settings">
                <div id="err_msg"></div>
      		      @if (isset($errors) && count($errors) > 0)
      						<div class="alert alert-danger">
      							<ul>
      								@foreach ($errors->all() as $error)
      									<li>{!! $error !!}</li>
      								@endforeach
      							</ul>
      						</div>
      					@endif

    					@if(Session::has('success'))
    						<div class="alert alert-success  text-center"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success') !!}</em></div>
    					@endif

    					@if(Session::has('dbError'))
    						<div class="alert alert-danger text-center"> {!! session('dbError') !!}</div>
    					@endif
              
              {!! Form::open(array('method' => 'POST','url' => route('admin.saveQuestionAnswers'),'class'=>'sky-form','id'=>'add-new-question')) !!}
                <div class="modal-body">
                  <fieldset>
                    <div class="body-overlay-popup body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
                    <div class="hide Question-add-msg"></div>
                    <section>
                      <label class="label">Ask Question <span class="mandatory">*</span></label>
                      <label class="textarea ">
                        <textarea rows="2" class="field-border" name="question" id="Question_id" placeholder="Enter Question"><?php echo !empty($question) ? $question->question : ''; ?> </textarea>
                        <b class="error-text" id="question_error"></b>
                      </label>
                    </section>
                    <section>
                      <label class="label">Select Question Type <span class="mandatory">*</span></label>
                      <label class="select">
                        <select  class="field-border" name="question_type" id="question_type">
                          <option value="">Select Question Type</option>
                          <option value="2" <?php echo !empty($question) && $question->question_type ==2 ? 'selected' : ''; ?>>Buyer</option>
                          <option value="3" <?php echo !empty($question) && $question->question_type ==3 ? 'selected' : ''; ?>>Seller</option>
                          <option value="4" <?php echo !empty($question) && $question->question_type ==4 ? 'selected' : ''; ?>>Agent</option>
                        </select>
                        <i></i>
                        <b class="error-text" id="question_type_error"></b>
                      </label>
                    </section>
                    <section class="row">
                      <div class="col col-12">
                        <label class="label weight">Add question to Survey? </label>
                        <div class="inline-group">
                          <label class="radio"><input type="radio" name="survey" class="survey_1" <?php echo !empty($question) && $question->survey ==1 ? 'checked' : ''; ?> value="1" ><i class="rounded-x"></i>Yes</label>
                          <label class="radio"><input type="radio" name="survey" class="survey_2" <?php echo !empty($question) && $question->survey ==0 ? 'checked' : ''; ?> value="0" <?= ($id == '')?"checked":""?> ><i class="rounded-x"></i>No</label>
                        </div>
                      </div>
                    </section>
                  </fieldset>
                </div>
                <div class="modal-footer">
                  <input type="hidden" value="0" name="importance1" >
                  <input type="hidden" value="1" name="add_by" >
                  <input type="hidden" value="1" name="add_by_role" >
                  <input type="hidden" value="{{ $id }}" name="question_id" >
                  <a type="button" href="{{route('admin.getQuestionAnswers')}}" class="btn-u btn-u-default" data-dismiss="modal">Close</a>
                  <button type="submit" class="btn-u btn-u-primary" name="edit-profile-submit" value="Save changes" title="Save changes">Save</button>
                </div>
              {!!Form::close()!!}

              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  @endsection
@section('scripts')
<script>
$("#add-new-question").submit(function(){
  $('.alert.alert-success').fadeOut('fast');
  let ele_Question_id = $("#Question_id");
  let ele_question_type = $("#question_type");
  let ele_errMsg = $("#err_msg");
  if($.trim(ele_Question_id.val()) == ""){
    ele_errMsg.html(`<div class="alert alert-danger text-center">The question field is required.</div>`);
    ele_Question_id.focus();
    return false;
  }
  else if(ele_question_type.val() == ""){
    ele_errMsg.html(`<div class="alert alert-danger text-center">The question type field is required.</div>`);
    ele_question_type.focus();
    return false;
  }else{
    ele_errMsg.html("");
  }

})
setTimeout(function() {
    $('.alert.alert-success').fadeOut('fast');
}, 3000);
</script>

@stop