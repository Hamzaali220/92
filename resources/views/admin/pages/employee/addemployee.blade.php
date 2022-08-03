@extends('admin.master')
@section('title', 'dashboard')
@section('style')
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<style>
.modal-content{
  border-radius:10px !important;
}
</style>
@stop
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Employee
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.employee.employeelist')}}">Employee</a></li>
        <li class="active">Add Employee</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content profile">

      <div class="row">
        <div class="col-md-12">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <div id='form_error'></div>
              @if(isset($success))
              <p class="alert alert-success">{{ $success }}</p>
              @endif

              @if(isset($error))
              <p class="alert alert-danger">{{ $error }}</p>
              @endif

              {!! Form::open(array('method' => 'POST','url' => route('admin.addemployee'),'class'=>'form-horizontal','role'=>'form','id'=>'add_employee')) !!}

                <div class="col-md-12">
                  <h5><strong>Basic Details</strong></h5>
                  <div class="col-md-4">
                      <label>Employee Name</label>
                      <input type="text" name="empname" class="form-control" placeholder="John Willson" required>
                  </div>
                  <div class="col-md-4">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" placeholder="exampl@domail.com" required>
                  </div>
                  <div class="col-md-4">
                      <label>Mobile</label>
                      <input type="number" name="mobile" class="form-control" placeholder="XXXXX XXXXX">
                  </div>
                  <div class="col-md-4">
                      <label>Password</label>
                      <input type="text" name="password" class="form-control" min="6" required="">
                  </div>
                </div>
                <div class="col-md-12">
                  <br>
                  <h5><strong>Assign Rights</strong></h5>
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="agent" id="agent" onclick="checkall(this.id)"> -->
                      <label for="agent">Agents</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="agentread" id="agentread" class="agent" onclick="validateall('agent')">
                      <label for="agentread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="agentchange" id="agentchange"  class="agent" onclick="validateall('agent')">
                      <label for="agentchange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="bs" id="bs" onclick="checkall(this.id)"> -->
                      <label for="bs">Buyer/Seller</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="bsread" id="bsread" class="bs" onclick="validateall('bs')">
                      <label for="bsread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="bschange" id="bschange"  class="bs" onclick="validateall('bs')">
                      <label for="bschange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="emp" id="emp" onclick="checkall(this.id)"> -->
                      <label for="emp">Employee</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="empread" id="empread" class="emp"  onclick="validateall('emp')">
                      <label for="empread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="empchange" id="empchange" class="emp"  onclick="validateall('emp')">
                      <label for="empchange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="postlist" id="postlist" onclick="checkall(this.id)"> -->
                      <label for="postlist">Post List</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="postlistread" id="postlistread" class="postlist"  onclick="validateall('postlist')">
                      <label for="postlistread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="postlistchange" id="postlistchange"  onclick="validateall('postlist')" class="postlist">
                      <label for="postlistchange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="badpost" id="badpost" onclick="checkall(this.id)"> -->
                      <label for="badpost">Bad Content</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="badpostread" id="badpostread"  onclick="validateall('badpost')" class="badpost">
                      <label for="badpostread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="badpostchange" id="badpostchange"  onclick="validateall('badpost')" class="badpost">
                      <label for="badpostchange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="ques" id="ques" onclick="checkall(this.id)"> -->
                      <label for="ques">Questions</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="quesread" id="quesread"  onclick="validateall('ques')" class="ques">
                      <label for="quesread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="queschange" id="queschange"  onclick="validateall('ques')" class="ques">
                      <label for="queschange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="sques" id="sques" onclick="checkall(this.id)"> -->
                      <label for="sques">Security Question</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="squesread" id="squesread"  onclick="validateall('sques')" class="sques">
                      <label for="squesread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="squeschange" id="squeschange"  onclick="validateall('sques')" class="sques">
                      <label for="squeschange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="skill" id="skill" onclick="checkall(this.id)"> -->
                      <label for="skill">Skills & Specialization</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="skillread" id="skillread"  onclick="validateall('skill')" class="skill">
                      <label for="skillread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="skillchange" id="skillchange"  onclick="validateall('skill')" class="skill">
                      <label for="skillchange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="franch" id="franch" onclick="checkall(this.id)"> -->
                      <label for="franch">Franchisees</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="franchread" id="franchread"  onclick="validateall('franch')" class="franch">
                      <label for="franchread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="franchchange" id="franchchange"  onclick="validateall('franch')" class="franch">
                      <label for="franchchange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="certification" id="certification" onclick="checkall(this.id)"> -->
                      <label for="certification">Certification</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="certificationread" id="certificationread"  onclick="validateall('certification')" class="certification">
                      <label for="certificationread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="certificationchange" id="certificationchange"  onclick="validateall('certification')" class="certification">
                      <label for="certificationchange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="state" id="state" onclick="checkall(this.id)"> -->
                      <label for="state">State</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="stateread" id="stateread"  onclick="validateall('state')" class="state">
                      <label for="stateread">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="statechange" id="statechange"  onclick="validateall('state')" class="state">
                      <label for="statechange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                      <!-- <input type="checkbox" value="1" name="area" id="area" onclick="checkall(this.id)"> -->
                      <label for="area">Area</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="arearead" id="arearead"  onclick="validateall('area')" class="area">
                      <label for="arearead">Read Only</label>
                  </div>
                  <div class="col-md-4">
                      <input type="checkbox" value="1" name="areachange" id="areachange"  onclick="validateall('area')" class="area">
                      <label for="areachange" >Change</label>
                  </div>
                </div>
                <div class="col-md-12 text-center">
                  <button class="btn-u btn-u-success">Submit</button>
                </div>
              {{ Form::close() }}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
@endsection
@section('scripts')
<script type="text/javascript">
  var agentsdata       = [];
  var valid = 0;
  
  // $( document ).ready(function() {
    
  //   $('#loadmoreagents').click(function(e){
  //     e.preventDefault();
  //     var limit = $(this).attr('title');
  //     loadagents(limit);
  //   });
  //   loadagents(0);
  // });

  function checkall(id){
    if ($("#"+id).prop('checked')) {
        $("."+id).each(function(index, el) {
            $(this).prop('checked', true);
        });
    }
    else{
        $("."+id).each(function(index, el) {
            $(this).prop('checked', false);
        });
    }
  }
  var i = 0;
  function validateall(clas){
    $('.'+clas).each(function(index, el) {
        if ($(this).prop('checked')) {
            i++;
        }
    });
  }

  $("#add_employee").submit(function(){
    let form_error = $("#form_error");
    if(i == 0){
      form_error.html(`<p class="alert alert-danger">Please select any rights for creating employee</p>`);
      return false;
    }else{
      form_error.html("");
    }
  });
  
</script> 
@stop