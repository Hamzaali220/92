@extends('dashboard.master')
@section('style')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/page_job.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/pricing/pricing_v1.css') }}">
<style type="text/css">
	hr{
		margin: 5px 0 !important;
	}
	.pricing-table-v1 .pricing-v1-content{
		background-color: #fff !important;
	}
	.pricing-v1-content td li{
		padding: 0px !important;
	}
	tr > th {
	    padding: 10px 1px !important;
	    position: relative;
	}
	tr > td{
		padding: 9px !important;
	    position: relative;
	}
	.popover {
	    max-width: inherit !important;
	}
</style>
@stop
@section('title', 'Agents Compare')
@section('content')
<?php  $topmenu='Home'; ?>
@include('dashboard.include.sidebar')
	<!--=== Content Part ===-->
	<div class="container content">

		<!-- Pricing Table v1-->
		<div class="row pricing-table-v1 box-shadow-profile  no-space-pricing table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class=""><div class="col-md-12">Staging Parameters</div></th>
						@if(!empty($result['count']))
							@foreach($result['result'] as $agentsdata)
								<?php 

									$selectedclass = '';
									$title='';
									if($agentsdata->applied_post == 1 && $agentsdata->applied_user_id == $agentsdata->details_id){
										$selectedclass = 'agents_selected';
										$title = 'Selected this agents for post ('.$agentsdata->posttitle.')';
									}
								 ?>
								<th class=" {{ $selectedclass }} agents_{{ $agentsdata->details_id }}" title="{{ $title }}">
		                            <div class="col-md-2"><img class="compare-property-img rounded-x" width="40" height="40" src="@if($agentsdata->photo != null && $agentsdata->photo != '') {{ url('assets/img/profile/') }}/{{ $agentsdata->photo }} @else {{ URL::asset('assets/img/testimonials/user.jpg') }} @endif" alt="" title=""></div>
		                            <div class="col-md-10"><h5 class="margin-top-10"> {{ $agentsdata->name }} </h5> 
		                            	@if($agentsdata->applied_post == 2)
		                            	<button class="btn-u pull-right agentsselectbutton select-for-post-button" onclick="selectagentforpost('{{  $agentsdata->post_id }}','{{  $agentsdata->details_id }}','{{  $agentsdata->name }}','{{ $agentsdata->photo }}');" >Select for post</button>
		                            	@endif
		                            </div>
								</th>
							@endforeach
						@endif
					</tr>
				</thead>
					<tbody class="list-unstyled pricing-v1-content">
						@if($sataging && $sataging['asked_question'] == 1 && $sataging['asked_question_list'] !='' && !empty($result['count']))
							@php $a=1 @endphp
							@foreach($sataging['asked_question_text'] as $key => $asked_question_text)
								<tr>
									<td><li> <strong class="hidetext2line popover-compare-hover"  data-original-title="Q.{{ $a}}" data-animation="false" data-easein="bounceLeftIn" rel="popover" data-placement="right" data-content="{{ $asked_question_text }}"> Q.{{ $a.') '. $asked_question_text}} </strong></li></td>
									@foreach($result['result'] as $agentsdata)
										<td><li> <strong class="hidetext2line popover-compare-hover" >Ans.</strong> {{ $agentsdata->asked_question[$key]->answers != '' ? $agentsdata->asked_question[$key]->answers : 'No Answer' }}</li></td>
									@endforeach
								</tr>
							@php ++$a @endphp
							@endforeach
						@endif
						@if($sataging && $sataging['bookmark_agents'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Bookmark </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> {{ $agentsdata->bookmark_agents != '' ? 'Yes' : ' - ' }}</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['bookmark_answers'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Bookmark Answers </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->bookmark_answers) !=0)
									@php $ba=1 @endphp
									@foreach($agentsdata->bookmark_answers as $key => $bookmark_answers)
										<strong> Q.{{ $ba }} ) </strong> {{ $bookmark_answers->question }} 
										<br> <strong> Ans.  </strong> {{ $bookmark_answers->answers }}
										<hr>
									@php ++$ba @endphp
									@endforeach
									@else
									 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['bookmark_messages'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Bookmark Messages </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->bookmark_messages) !=0)
									@php $ba=1 @endphp
									@foreach($agentsdata->bookmark_messages as $key => $bookmark_messages)
										<i class="fa fa-long-arrow-{{ $bookmark_messages->is_user }}"></i>{{ $bookmark_messages->message_text }}<hr>
									@php ++$ba @endphp
									@endforeach
									@else
									 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['bookmark_proposal'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Bookmark Proposal </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->bookmark_proposal) !=0)
									  @php $ba=1 @endphp
										@foreach($agentsdata->bookmark_proposal as $key => $bookmark_proposal)
											
											<strong> {{ $ba.') '.$bookmark_proposal->proposals_title }} </strong>
											<br>
											<?php 
												$extension = strtolower(substr($bookmark_proposal->proposals_attachments, strrpos($bookmark_proposal->proposals_attachments, '.')+1));
											 ?>
											<div class="thumbnails thumbnail-style thumbnail-kenburn">
												<div class="cbp-caption thumbnail-img">
													<div class="overflow-hidden cbp-caption-defaultWrap">
														@if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tif')
															<img	class="documen document_uploadfiles_{{ $bookmark_proposal->proposals_id }}" src="{{ $bookmark_proposal->proposals_attachments }}" frameborder="0" scrolling="no" width="100%" height="150">
														@else
															<iframe class="documen document_uploadfiles_{{ $bookmark_proposal->proposals_id }}" src="https://docs.google.com/viewer?url={{ $bookmark_proposal->proposals_attachments }}&embedded=true" frameborder="0" scrolling="no" width="100%" height="150"></iframe>
														@endif
													</div>
													<div class="removehover cbp-caption-activeWrap">
														<div class="cbp-l-caption-alignCenter">
															<div class="cbp-l-caption-body">
																<ul class="link-captions no-bottom-space">
																	@if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tif')
																		<li><a class="cursor" title="View" onclick="showdocs('{{ $bookmark_proposal->proposals_attachments }}','img');"><i class="rounded-x fa fa-eye"></i></a></li>
																	@else
																		<li><a class="cursor" title="View" onclick="showdocs('https://docs.google.com/viewer?url={{ $bookmark_proposal->proposals_attachments }}&embedded=true','doc');"><i class="rounded-x fa fa-eye"></i></a></li>
																	@endif
																</ul>
															</div>
														</div>		
													</div>
												</div>
											</div>

											@php ++$ba @endphp
										@endforeach
									@else
										 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['rating_answers'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Rating Answers </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->rating_answers) !=0)
									@php $ba=1 @endphp
									@foreach($agentsdata->rating_answers as $key => $rating_answers)
										<strong> Q.{{ $ba }} ) </strong> {{ $rating_answers->question }} 
										<br> <strong> Ans.  </strong> {{ $rating_answers->answers }}
										
										<span class="rating-show-only rating-show-only-compare">
                      						
					                        <input class="stars" disabled type="radio" id="star5rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating == '5' ? 'checked="checked"' : '' }} value="5" />
					                        <label class="full " data-original-title="Awesome " data-placement="top" for="star5rating{{$rating_answers->answers_id}}" title="Awesome"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star4_5rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating == '4_5' ? 'checked="checked"' : '' }} value="4_5" />
					                        <label class="half " data-original-title="Pretty good " data-placement="top" for="star4_5rating{{$rating_answers->answers_id}}" title="Pretty good"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star4rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating == '4' ? 'checked="checked"' : '' }}  value="4" />
					                        <label class = "full " data-original-title="Pretty good " data-placement="top" for="star4rating{{$rating_answers->answers_id}}" title="Pretty good"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star3_5rating{{$rating_answers->answers_id}}"  {{ $rating_answers->rating == '3_5' ? 'checked="checked"' : '' }} value="3_5" />
					                        <label class="half " data-original-title="Meh " data-placement="top" for="star3_5rating{{$rating_answers->answers_id}}" title="Meh"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star3rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating == '3' ? 'checked="checked"' : '' }} value="3" />
					                        <label class = "full " data-original-title="Meh " data-placement="top" for="star3rating{{$rating_answers->answers_id}}" title="Meh"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star2_5rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating == '2_5' ? 'checked="checked"' : '' }} value="2_5" />
					                        <label class="half " data-original-title="Kinda bad " data-placement="top" for="star2_5rating{{$rating_answers->answers_id}}" title="Kinda bad "></label>
					                       
					                        <input class="stars" disabled type="radio" id="star2rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating  == '2' ? 'checked="checked"' : '' }} value="2" />
					                        <label class = "full " data-original-title="Kinda bad " data-placement="top" for="star2rating{{$rating_answers->answers_id}}" title="Kinda bad"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star1_5rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating == '1_5' ? 'checked="checked"' : '' }} value="1_5" />
					                        <label class="half " data-original-title="Meh " data-placement="top" for="star1_5rating{{$rating_answers->answers_id}}" title="Meh"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star1rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating == '1' ? 'checked="checked"' : '' }} value="1" />
					                        <label class = "full " data-original-title="Sucks big time " data-placement="top" for="star1rating{{$rating_answers->answers_id}}" title="Sucks big time"></label>
					                       
					                        <input class="stars" disabled type="radio"  id="star0_5rating{{$rating_answers->answers_id}}" {{ $rating_answers->rating == '0_5' ? 'checked="checked"' : '' }} value="0_5" />
					                        <label class="half " data-original-title="Sucks big time " data-placement="top" for="star0_5rating{{$rating_answers->answers_id}}" title="Sucks big time"></label>
					                    </span>
										<hr>
									@php ++$ba @endphp
									@endforeach
									@else
									 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['rating_messages'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Rating Messages </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->rating_messages) !=0)
									@php $ba=1 @endphp
									@foreach($agentsdata->rating_messages as $key => $rating_messages)
										<i class="fa fa-long-arrow-{{ $rating_messages->is_user }}"></i>{{ $rating_messages->message_text }}
										<span class="rating-show-only rating-show-only-compare">
                      						
					                        <input class="stars" disabled type="radio" id="star5rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating == '5' ? 'checked="checked"' : '' }} value="5" />
					                        <label class="full " data-original-title="Awesome " data-placement="top" for="star5rating{{$rating_messages->messages_id}}" title="Awesome"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star4_5rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating == '4_5' ? 'checked="checked"' : '' }} value="4_5" />
					                        <label class="half " data-original-title="Pretty good " data-placement="top" for="star4_5rating{{$rating_messages->messages_id}}" title="Pretty good"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star4rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating == '4' ? 'checked="checked"' : '' }}  value="4" />
					                        <label class = "full " data-original-title="Pretty good " data-placement="top" for="star4rating{{$rating_messages->messages_id}}" title="Pretty good"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star3_5rating{{$rating_messages->messages_id}}"  {{ $rating_messages->rating == '3_5' ? 'checked="checked"' : '' }} value="3_5" />
					                        <label class="half " data-original-title="Meh " data-placement="top" for="star3_5rating{{$rating_messages->messages_id}}" title="Meh"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star3rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating == '3' ? 'checked="checked"' : '' }} value="3" />
					                        <label class = "full " data-original-title="Meh " data-placement="top" for="star3rating{{$rating_messages->messages_id}}" title="Meh"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star2_5rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating == '2_5' ? 'checked="checked"' : '' }} value="2_5" />
					                        <label class="half " data-original-title="Kinda bad " data-placement="top" for="star2_5rating{{$rating_messages->messages_id}}" title="Kinda bad "></label>
					                       
					                        <input class="stars" disabled type="radio" id="star2rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating  == '2' ? 'checked="checked"' : '' }} value="2" />
					                        <label class = "full " data-original-title="Kinda bad " data-placement="top" for="star2rating{{$rating_messages->messages_id}}" title="Kinda bad"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star1_5rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating == '1_5' ? 'checked="checked"' : '' }} value="1_5" />
					                        <label class="half " data-original-title="Meh " data-placement="top" for="star1_5rating{{$rating_messages->messages_id}}" title="Meh"></label>
					                       
					                        <input class="stars" disabled type="radio" id="star1rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating == '1' ? 'checked="checked"' : '' }} value="1" />
					                        <label class = "full " data-original-title="Sucks big time " data-placement="top" for="star1rating{{$rating_messages->messages_id}}" title="Sucks big time"></label>
					                       
					                        <input class="stars" disabled type="radio"  id="star0_5rating{{$rating_messages->messages_id}}" {{ $rating_messages->rating == '0_5' ? 'checked="checked"' : '' }} value="0_5" />
					                        <label class="half " data-original-title="Sucks big time " data-placement="top" for="star0_5rating{{$rating_messages->messages_id}}" title="Sucks big time"></label>
					                    </span>
										<hr>
									@php ++$ba @endphp
									@endforeach
									@else
									 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['notes_agents'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Notes </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> {!! !empty($agentsdata->notes_agents) && $agentsdata->notes_agents != '' ? $agentsdata->notes_agents->notes : ' - ' !!}</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['notes_asked_question'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Notes Asked Answers </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->notes_asked_question) !=0)
									 @php $ba=1 @endphp
										@foreach($agentsdata->notes_asked_question as $key => $notes_asked_question)
											<strong> Q.{{ $ba }} ) </strong> {{ $notes_asked_question->question }} 
											<br> <strong> Ans.  </strong> {{ $notes_asked_question->answers }}
											<br> <div> <strong> Notes.  </strong> {!! $notes_asked_question->notes !!}</div>
											<hr>
										@php ++$ba @endphp
										@endforeach
									@else
										 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['notes_answers'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Notes Answers </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->notes_answers) !=0)
									 @php $ba=1 @endphp
										@foreach($agentsdata->notes_answers as $key => $notes_answers)
											<strong> Q.{{ $ba }} ) </strong> {{ $notes_answers->question }} 
											<br> <strong> Ans.  </strong> {{ $notes_answers->answers }}
											<br> <div><strong> Notes. </strong>{!! $notes_answers->notes !!}</div>
											<hr>
										@php ++$ba @endphp
										@endforeach
									@else
										-
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['notes_messages'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Notes Messages </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->notes_messages) !=0)
									@php $ba=1 @endphp
									@foreach($agentsdata->notes_messages as $key => $notes_messages)
										<i class="fa fa-long-arrow-{{ $notes_messages->is_user }}"></i>{{ $notes_messages->message_text }}
										<br> <div><strong> Notes. </strong>{!! $notes_messages->notes !!}</div>
										<hr>
									@php ++$ba @endphp
									@endforeach
									@else
									 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['notes_proposal'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Notes Proposal </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->notes_proposal) !=0)
									  @php $ba=1 @endphp
										@foreach($agentsdata->notes_proposal as $key => $notes_proposal)
											
											<strong> {{ $ba.') '.$notes_proposal->proposals_title }} </strong>
											<div><strong> Notes: </strong> {!! $notes_proposal->notes !!}</div>
											<br>
											<?php 
												$extension = strtolower(substr($notes_proposal->proposals_attachments, strrpos($notes_proposal->proposals_attachments, '.')+1));
											 ?>
											<div class="thumbnails thumbnail-style thumbnail-kenburn">
												<div class="cbp-caption thumbnail-img">
													<div class="overflow-hidden cbp-caption-defaultWrap">
														@if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tif')
															<img	class="documen document_uploadfiles_{{ $notes_proposal->proposals_id }}" src="{{ $notes_proposal->proposals_attachments }}" frameborder="0" scrolling="no" width="100%" height="150">
														@else
															<iframe class="documen document_uploadfiles_{{ $notes_proposal->proposals_id }}" src="https://docs.google.com/viewer?url={{ $notes_proposal->proposals_attachments }}&embedded=true" frameborder="0" scrolling="no" width="100%" height="150"></iframe>
														@endif
													</div>
													<div class="removehover cbp-caption-activeWrap">
														<div class="cbp-l-caption-alignCenter">
															<div class="cbp-l-caption-body">
																<ul class="link-captions no-bottom-space">
																	@if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tif')
																		<li><a class="cursor" title="View" onclick="showdocs('{{ $notes_proposal->proposals_attachments }}','img');"><i class="rounded-x fa fa-eye"></i></a></li>
																	@else
																		<li><a class="cursor" title="View" onclick="showdocs('https://docs.google.com/viewer?url={{ $notes_proposal->proposals_attachments }}&embedded=true','doc');"><i class="rounded-x fa fa-eye"></i></a></li>
																	@endif
																</ul>
															</div>
														</div>		
													</div>
												</div>
											</div>

											@php ++$ba @endphp
										@endforeach
									@else
										 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['proposals'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Proposals </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->proposals) !=0)
									@php $ba=1 @endphp
									@foreach($agentsdata->proposals as $key => $proposals)
										<strong> {{ $ba.') '.$proposals->proposals_title }} </strong>
										<br>
										<?php 
											$extension = strtolower(substr($proposals->proposals_attachments, strrpos($proposals->proposals_attachments, '.')+1));
										 ?>
										<div class="thumbnails thumbnail-style thumbnail-kenburn">
											<div class="cbp-caption thumbnail-img">
												<div class="overflow-hidden cbp-caption-defaultWrap">
													@if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tif')
														<img	class="documen document_uploadfiles_{{ $proposals->proposals_id }}" src="{{ $proposals->proposals_attachments }}" frameborder="0" scrolling="no" width="100%" height="150">
													@else
														<iframe class="documen document_uploadfiles_{{ $proposals->proposals_id }}" src="https://docs.google.com/viewer?url={{ $proposals->proposals_attachments }}&embedded=true" frameborder="0" scrolling="no" width="100%" height="150"></iframe>
													@endif
												</div>
												<div class="removehover cbp-caption-activeWrap">
													<div class="cbp-l-caption-alignCenter">
														<div class="cbp-l-caption-body">
															<ul class="link-captions no-bottom-space">
																@if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tif')
																	<li><a class="cursor" title="View" onclick="showdocs('{{ $proposals->proposals_attachments }}','img');"><i class="rounded-x fa fa-eye"></i></a></li>
																@else
																	<li><a class="cursor" title="View" onclick="showdocs('https://docs.google.com/viewer?url={{ $proposals->proposals_attachments }}&embedded=true','doc');"><i class="rounded-x fa fa-eye"></i></a></li>
																@endif
															</ul>
														</div>
													</div>		
												</div>
											</div>
										</div>
										
										<hr>
									@php ++$ba @endphp
									@endforeach
									@else
									 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						@if($sataging && $sataging['documents'] == 1 && !empty($result['count']))
							<tr>
								<td><li> <strong> Documents </strong></li></td>
								@foreach($result['result'] as $agentsdata)
								<td><li> 
									@if(count($agentsdata->documents) !=0)
									@php $ba=1 @endphp
									@foreach($agentsdata->documents as $key => $documents)
										<?php 
											$extension = strtolower(substr($documents->attachments, strrpos($documents->attachments, '.')+1));
										 ?>
										
										<div class="thumbnails thumbnail-style thumbnail-kenburn">
											<div class="cbp-caption thumbnail-img">
												<div class="overflow-hidden cbp-caption-defaultWrap">
													@if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tif')
														<div onclick="showdocs('{{ $documents->attachments }}');"><img	class="documen document_uploadfiles_{{ $documents->upload_share_id }}" src="{{ $documents->attachments }}" frameborder="0" scrolling="no" width="100%" height="150"></div>
													@else
														<div onclick="showdocs('https://docs.google.com/viewer?url={{ $documents->attachments }}&embedded=true');"><iframe class="documen document_uploadfiles_{{ $documents->upload_share_id }}" src="https://docs.google.com/viewer?url={{ $documents->attachments }}&embedded=true" frameborder="0" scrolling="no" width="100%" height="150"></iframe></div>
													@endif
												</div>
												<div class="removehover cbp-caption-activeWrap">
													<div class="cbp-l-caption-alignCenter">
														<div class="cbp-l-caption-body">
															<ul class="link-captions no-bottom-space">
																@if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif' || $extension=='tif')
																	<li><a class="cursor" title="View" onclick="showdocs('{{ $documents->attachments }}','img');"><i class="rounded-x fa fa-eye"></i></a></li>
																@else
																	<li><a class="cursor" title="View" onclick="showdocs('https://docs.google.com/viewer?url={{ $documents->attachments }}&embedded=true','doc');"><i class="rounded-x fa fa-eye"></i></a></li>
																@endif
															</ul>
														</div>
													</div>		
												</div>
											</div>
										</div>
										<hr>
									@php ++$ba @endphp
									@endforeach
									@else
									 -
									@endif
								</li></td>
								@endforeach
							</tr>
						@endif
						<tr>
							<td><li> <strong> Details </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									<div class="hidetext2line ">{!! $agentsdata->description !!}</div>
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Additional Details </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									<div class="hidetext2line ">{!! $agentsdata->additional_details !!}</div>
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Real estate experience </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									{!! $agentsdata->years_of_expreience !='' ? '<span class="skill-lable label label-success">'.@str_replace('-', ' to ', $agentsdata->years_of_expreience).' Year + </span>' : '' !!}
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Associations Awards </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									{{  str_replace(',==,' , ', ',$agentsdata->associations_awards) }}
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Community involvement </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									{{  str_replace(',==,' , ', ',$agentsdata->community_involvement) }}
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Publications </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									{{  str_replace(',==,' , ', ',$agentsdata->publications) }}
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Certifications </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									@if($agentsdata->certifications !='')
										@foreach(explode(',',$agentsdata->certifications) as $certi)
											<span class="skill-lable label label-success"> {{ $certifications[$certi] }} </span> 
										@endforeach
									@endif
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Specialization </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									@if($agentsdata->specialization !='')
										@foreach(explode(',',$agentsdata->specialization) as $speciali)
											<span class="skill-lable label label-success"> {{ $specialization[$speciali] }} </span> 
										@endforeach
									@endif
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Skills </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									@if($agentsdata->skills !='')
										@foreach(explode(',',$agentsdata->skills) as $speciali)
											<span class="skill-lable label label-success"> {{ $specialization[$speciali] }} </span> 
										@endforeach
									@endif
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Franchise </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									@if($agentsdata->franchise !='')
										@if($agentsdata->franchise=='other')
											<span class="skill-lable label label-success"> {{ $agentsdata->other_franchise }} </span> 
										@else
											@foreach(explode(',',$agentsdata->franchise) as $franch)
												<span class="skill-lable label label-success"> {{ $franchise[$franch] }} </span> 
											@endforeach
										@endif
									@endif
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Represented Sales History </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									
									@if(!empty($agentsdata->show_individual_yearly_figures == 1))
										<div class="left-inner  padding-5-20">
											<ul class="list-unstyled" id="">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>Year</th>
															<th class="hidden-sm">Sellers</th>
															<th>Buyers</th>
															<th>Total Status</th>
														</tr>
													</thead>
													<tbody>
													@foreach(json_decode($agentsdata->sales_history) as $sales)
														<tr>
															<td>{{ $sales->year }}</td>
															<td class="hidden-sm">${{ number_format($sales->buyers_represented) }}</td>
															<td>${{ number_format($sales->sellers_represented) }}</td>
															<td>${{ number_format($sales->total_dollar_sales) }}</td>
														</tr>
													@endforeach
													</tbody>
												</table>
										 	</ul>
										</div>
										@else

											@if($agentsdata->total_sales !=0)
											<div class="left-inner  padding-5-20">
												<ul class="list-unstyled" id="">
													<li>Over all total for 5 years Sales History ${{ number_format($agentsdata->total_sales) }}</li>
											 	</ul>
											</div>
											@endif

										@endif
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Industry Experience </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									@if(!empty($agentsdata->industry_experience != null))
									<div class="left-inner  padding-5-20">
										<ul class="timeline-v2 timeline-me" id="">
											@foreach(json_decode($agentsdata->industry_experience) as $industry)
											<li>
												<time datetime="" class="cbp_tmtime"><span>{{$industry->post}}</span> <span>{{  str_replace('_',' ',$industry->from) }} - {{  str_replace('_',' ',$industry->to) }}</span></time>
												<i class="cbp_tmicon rounded-x hidden-xs"></i>
												<div class="cbp_tmlabel">
													<h2>{{$industry->organization}}</h2>
													<div class="hidetext2line ">{!! $industry->description !!}</div>
												</div>
											</li>
											@endforeach
									 	</ul>
									</div>
									@endif
								</li>
							</td>
							@endforeach
						</tr>

						<tr>
							<td><li> <strong> Real Estate Education </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									@if(!empty($agentsdata->real_estate_education != ''))
									<div class="left-inner  padding-5-20">
										<ul class="timeline-v2 timeline-me" id="">
											@foreach(json_decode($agentsdata->real_estate_education) as $employment)
											<li>
												<time datetime="" class="cbp_tmtime"><span>{{$employment->degree}}</span> <span>{{  str_replace('_',' ',$employment->from) }} - {{  str_replace('_',' ',$employment->to) }}</span></time>
												<i class="cbp_tmicon rounded-x hidden-xs"></i>
												<div class="cbp_tmlabel">
													<h2>{{$employment->school}}</h2>
													<div class="hidetext2line ">{!! $employment->description !!}</div>
												</div>
											</li>
											@endforeach
									 	</ul>
									</div>
									@endif
								</li>
							</td>
							@endforeach
						</tr>
						<tr>
							<td><li> <strong> Language Proficiency </strong></li></td>
							@foreach($result['result'] as $agentsdata)
							<td>
								<li> 
									@if(!empty($agentsdata->language_proficiency != ''))
									
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Language</th>
												<th>Speak</th>
												<th>Read</th>
												<th>Write</th>
											</tr>
										</thead>
										<tbody>
											@foreach(json_decode($agentsdata->language_proficiency) as $lang)
											<tr>
												<td>{{ $lang->language }}</td>
												<td>{{ $lang->speak }}</td>
												<td>{{ $lang->read }}</td>
												<td>{{ $lang->write }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
									 	
									@endif
								</li>
							</td>
							@endforeach
						</tr>
					</tbody>
				</table>

		</div><!--/row-->
		<!-- End Pricing Table v1 -->
		<!-- End Pricing Table v2-->
	</div><!--/container-->
	<!--=== End Content Part ===-->
	<div class="modal fade bs-example-modal-lg" id="open-docs-popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content not-top">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body src-ifram">
					
				</div>
			</div>
		</div>
	</div>
	<!-- important popup -->
	<div class="modal fade" id="uploadsharedeleteconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content not-top">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Confirm Selective agent for post</h4>
					</div>
					<div class="modal-body">
						<br>
						<div class="body-overlay"><div><img src="{{ url('/assets/img/loder/loading.gif') }}" width="64px" height="64px"/></div></div>
						<div id="upload-delete-msg"> </div>
						<p class="rempovemessag">Are you sure this question remove in survey list.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn-u btn-u-primary" id="delete">yes I'm Sure</button>
					</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
<script type="text/javascript">
	function showdocs(url,type) {
		$('#open-docs-popup').modal('show');
		if(type=='img'){
			var htmll ='<img 	 src="'+url+'" frameborder="0" scrolling="no" width="100%" height="500">';
		}else{
			var htmll ='<iframe  src="'+url+'" frameborder="0" scrolling="no" width="100%" height="500"></iframe>';
		}
		$('.src-ifram').html(htmll);
	}
	function selectagentforpost(post_id,agentid,name,photo) {
		$('#upload-delete-msg').addClass('hide');
		$('.rempovemessag').html('Are you sure that ('+name+') should be chosen for the post.');
		$('#uploadsharedeleteconfirm')
	        .modal({ backdrop: 'static', keyboard: false })
	        .one('click', '#delete', function (e) {
	           	$.ajax({
					url: "{{url('/')}}/appliedagents/"+post_id+'/'+agentid,
					type: 'get',
					processData:false,
					beforeSend: function(){$(".body-overlay").show();},
					success: function(result) {	
						$(".body-overlay").hide();						
						msgshowfewsecond(name+' successfully selected for this post.');
						$('#uploadsharedeleteconfirm').modal('hide');
						$('.agents_'+agentid).addClass('agents_selected');
						$('.agentsselectbutton').remove();
						
					},error: function(data) {	$(".body-overlay").hide(); 	}
				});        
        });

	}
</script> 
@stop