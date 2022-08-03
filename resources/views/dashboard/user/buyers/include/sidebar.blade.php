<?php
$segment=Request::segments();
if(!isset($segment[0])){
	$segment[0]="dashboard";
}
if(!isset($segment[1])){
	$segment[1]="";
}
// dd(Auth::user()->agents_users_role_id);
if(Auth::user()->agents_users_role_id != 3 && Auth::user()->agents_users_role_id != 2 && Auth::user()->agents_users_role_id != 4):
	echo '<script>window.location = "/dashboard";</script>';
endif
?>

<div class="modal fade in" id="postcheck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="body-overlay"><div><img src="{{ url('/') }}/assets/img/loder/loading.gif" width="64px" height="64px"></div></div>
			{!! Form::open(array('url' => '#','class'=>'sky-form','id'=>'edit-posttitle')) !!}
				<div class="modal-header">
					<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
					<h4 class="modal-title"> Welcome To {{ env('user_role_'.$user->agents_users_role_id) }} Account. Fill Up Post Title Here </h4>
				</div>
				<div class="modal-body">
					<fieldset>
						<div id="postmsgcheckpost"> </div>
						<section>
							<!--<label class="label">Post Details of {{ Auth::user()->agents_users_role_id ==2 ? 'Buy' : 'Sell' }}</label>-->
							<label class="label">Post Title</label>
							<label class="input">
								<input type="text" class="form-control" id="posttitle" name="posttitle" value="{{ @$postdetails->posttitle }}">
								<b class="error-text" id="posttitle_error"></b>
							</label>
						</section>					
						<p class="success-text" id="success-pic-checkpost"></p>
					</fieldset>
				</div>
				<div class="modal-footer">
					<input type="hidden" value="{{ $user->id }}" name="agents_user_id" >
					<input type="hidden" value="{{ $user->agents_users_role_id }}" name="agents_users_role_id" >
					<button type="submit" class="btn-u btn-u-primary" name="edit-profile-pic-submit" value="Save changes" title="Save changes">Save</button>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
</div> 
<div class="modal fade" id="changeprofilepic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content">

			<div id="body-overlay" class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>

			{!! Form::open(array('url' => '#','class'=>'sky-form','enctype'=>'multipart/form-data','id'=>'edit-profile-pic')) !!}

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

					<h4 class="modal-title">{{ucfirst($userdetails->name)}}</h4>

				</div>

				<div class="modal-body">

					<fieldset>

						<section>

							<label for="file" class="input input-file">

								<div class="button"><input type="file" id="profile-img" name="image" multiple onchange="this.parentNode.nextSibling.value = this.value">Upload Picture </div><input type="text" placeholder="Upload Picture" readonly>

							</label>

						</section>					

						<p class="success-text" id="success-pic"></p>

						<img src="@if($userdetails->photo != '') {{ url('/assets/img/profile/'.$userdetails->photo) }} @else {{ url('/assets/img/team/img32-md.jpg') }} @endif" alt="img04" id="profile-img-tag" width="200px" />

					</fieldset>

				</div>

				<div class="modal-footer">

					<input type="hidden" value="<?php echo $user->id; ?>" name="id" >

					<button type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>

					<button type="submit" class="btn-u btn-u-primary" name="edit-profile-pic-submit" value="Save changes" title="Save changes">Save Changes</button>

				</div>

			{!!Form::close()!!}

		</div>

	</div>

</div>