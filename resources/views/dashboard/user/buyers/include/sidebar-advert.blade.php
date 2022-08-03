<!-- Start of side advert -->
		<div class="col-md-3">
			@foreach($square_ads as $ad)
				@if($ad->image == 1)
					<div class="col-md-12 img-advert squareAds">
						<a href="{{ url('/adclicks/'.$ad->id) }}" target="_blank">
							<img src="{{ asset('storage/'.$ad->ad_banner) }}" class="img-responsive ">
						</a>
					</div>
				@endif

				@if($ad->content == 1)
					<div class="col-md-12 squareAds">
						<a href="{{ url('/adclicks/'.$ad->id) }}" target="_blank">
							<div class="text-advert">
								{!! $ad->ad_content !!}
							</div>
						</a>
					</div>
				@endif
				
			@endforeach

			<div class="col-md-12 img-advert squareAds">
				<a href="#" target="_blank">
					<img src="https://via.placeholder.com/250" class="img-responsive ">
				</a>
			</div>

			<div class="col-md-12 squareAds">
				
				
			</div>
		</div> <!-- End of side advert --> 