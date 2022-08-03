				<br>
				<div class="row text-center">
				@foreach($horizontal_ads as $ad)
					<div class="col-md-offset-2 col-md-8">
						<a href="{{ url('/adclicks/'.$ad->id) }}" target="_blank">
							<img class="img-responsive" src="{{ asset('storage/'.$ad->ad_banner) }}">
						</a>
					</div>
				@endforeach
				</div>
				<br>