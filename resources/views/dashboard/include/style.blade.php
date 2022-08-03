	<!-- Web Fonts -->

	<link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin'>



	<!-- CSS Global Compulsory -->

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/summernote/css/summernote.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/summernote/css/summernote-bs3.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">



	<!-- CSS Header and Footer -->

	<!-- <link rel="stylesheet" href="{{ URL::asset('assets/css/headers/header-default.css') }}"> -->

	<link rel="stylesheet" href="{{ URL::asset('assets/css/headers/header-v6.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/css/footers/footer-v1.css') }}">

	

	<!-- CSS Theme -->

	<link rel="stylesheet" href="{{ URL::asset('assets/css/theme-colors/default.css') }}" id="style_color">

	<link rel="stylesheet" href="{{ URL::asset('assets/css/theme-skins/dark.css') }}">



	

	<!-- CSS Implementing Plugins -->

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/animate.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/line-icons-pro/styles.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/line-icons/line-icons.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/font-awesome/css/font-awesome.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">

	<!-- CSS Page Style -->

	

	<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/profile.css') }}">



	<!-- CSS caption hover effects -->

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/captionhovereffects/css/component.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/hover-effects/css/hover.css') }}">

	

	<!-- CSS Customization -->

	<link rel="stylesheet" href="{{ URL::asset('assets/css/custom.css') }}">

	<!-- text editer -->

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/classyedit/css/jquery-te-1.4.0.css') }}">

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/tour/css/bootstrap-tour.css') }}"> 

	<link rel="stylesheet" href="{{ URL::asset('assets/plugins/tour/css/bootstrap-tour.min.css') }}"> 
	<style>
	.modal-footer > .btn-u-default {
	display: none;
	}
	.main-dashboard .modal button[class="close"]{
		color:black
	}
	.notif-profile{
		display:flex;
		flex-direction:row;
	}
	</style>
	@yield('style')
        <script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        
	<script type="text/javascript">
		

		Date.fromISO= (function(){		     

		    return function(s){

	    	 	var day 	= s.split("-")

	    	 	var day1  	= day[2] != 'undefined' ? day[2].split(" ") : null;

	    	 	var hh  	= day1[1] != 'undefined' ? day1[1].split(":") : null;

		    	return new Date(Date.UTC( 

		    		(day[0] != 'undefined' && day[0] != null ?  parseInt(day[0]) : 0),

		    		(day[0] != 'undefined' && day[0] != null ?  (parseInt(day[1])-1) : 0),

		    		(day[0] != 'undefined' && day[0] != null ?  parseInt(day1[0]) : 0),

		    		(day[0] != 'undefined' && day[0] != null ?  parseInt(hh[0]) : 0),

		    		(day[0] != 'undefined' && day[0] != null ?  parseInt(hh[1]) : 0),

		    		(day[0] != 'undefined' && day[0] != null ?  parseInt(hh[2]) : 0)

		    		));

		    }

		})();



		function timeDifference(current, previous) {



		    var msPerMinute = 60 * 1000;

		    var msPerHour = msPerMinute * 60;

		    var msPerDay = msPerHour * 24;

		    var msPerMonth = msPerDay * 30;

		    var msPerYear = msPerDay * 365;

		    var elapsed = current - previous;

			var now = new Date(previous);

		    if (elapsed < msPerMinute) {

		         return Math.round(elapsed/1000) + 's ago';   

		    }

		    

		    else if (elapsed < msPerHour) {

		         return Math.round(elapsed/msPerMinute) + 'm ago';   

		    }

		    

		    else if (elapsed < msPerDay ) {

		    	if(now.customFormat( "#hhhh#" ) > '12'){



		    	 return now.customFormat( "#DD# #MMM# #YYYY# #h#:#mm# #AMPM#" );

		    	}else{

		    	 return now.customFormat( "#DD# #MMM# #YYYY# #h#:#mm# #AMPM#" );

		    	}

		    }



		    else if (elapsed < msPerMonth) {

		    	if(now.customFormat( "#hhhh#" ) > '12'){



		    	 return now.customFormat( "#DD# #MMM# #YYYY#  #h#:#mm# #AMPM#" );

		    	}else{

		    	 return now.customFormat( "#DD# #MMM# #YYYY#  #h#:#mm# #AMPM#" );

		    	}

		    }

		    

		    else if (elapsed < msPerYear) {

		    	return now.customFormat( "#DD# #DDDD# #MMM# #YYYY#  #h#:#mm# #AMPM#" );

		    }

		    

		    else {

		    	return now.customFormat( "#DD# #DDDD# #MMM# #YYYY#  #h#:#mm# #AMPM#" );

		    }

		}



		Date.prototype.customFormat = function(formatString){

			

		  var YYYY,YY,MMMM,MMM,MM,M,DDDD,DDD,DD,D,hhhh,hhh,hh,h,mm,m,ss,s,ampm,AMPM,dMod,th;

		  YY = ((YYYY=this.getFullYear())+"").slice(-2);

		  MM = (M=this.getMonth()+1)<10?('0'+M):M;

		  MMMM=["January","February","March","April","May","June","July","August","September","October","November","December"][M-1];

		  MMM = MMMM != '' && MMMM != null ? MMMM.substring(0,3) : '';

		  DD = (D=this.getDate())<10?('0'+D):D;

		  DDDD=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][this.getDay()];

		  DDD = DDDD != '' && DDDD != null ? DDDD.substring(0,3) : '';

		  th=(D>=10&&D<=20)?'th':((dMod=D%10)==1)?'st':(dMod==2)?'nd':(dMod==3)?'rd':'th';

		  formatString = formatString.replace("#YYYY#",YYYY).replace("#YY#",YY).replace("#MMMM#",MMMM).replace("#MMM#",MMM).replace("#MM#",MM).replace("#M#",M).replace("#DDDD#",DDDD).replace("#DDD#",DDD).replace("#DD#",DD).replace("#D#",D).replace("#th#",th);

		  h=(hhh=this.getHours());

		  if (h==0) h=24;

		  if (h>12) h-=12;

		  hh = h<10?('0'+h):h;

		  hhhh = hhh<10?('0'+hhh):hhh;

		  AMPM=(ampm=hhh<12?'am':'pm').toUpperCase();

		  mm=(m=this.getMinutes())<10?('0'+m):m;

		  ss=(s=this.getSeconds())<10?('0'+s):s;

		  return formatString.replace("#hhhh#",hhhh).replace("#hhh#",hhh).replace("#hh#",hh).replace("#h#",h).replace("#mm#",mm).replace("#m#",m).replace("#ss#",ss).replace("#s#",s).replace("#ampm#",ampm).replace("#AMPM#",AMPM);

		};

	</script>