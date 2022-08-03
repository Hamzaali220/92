<div id="snackbar">Some text some message..</div>
<script src="{{ URL::asset('admin/plugins/jquery/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
<!-- jquery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jquery UI tooltip with Bootstrap tooltip -->
<script type="text/javascript">
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('admin/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"> </script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js" type="text/javascript"></script>
<script src="{{ URL::asset('admin/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<!-- Sparkline -->
<script src="{{ URL::asset('admin/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<!-- jvectormap -->
<script src="{{ URL::asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
<!-- jquery Knob Chart -->
<script src="{{ URL::asset('admin/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js" type="text/javascript"></script>
<script src="{{ URL::asset('admin/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<!-- datepicker -->
<script src="{{ URL::asset('admin/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<!-- <script src="{{ URL::asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
 --><!-- Slimscroll -->
<script src="{{ URL::asset('admin/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{ URL::asset('admin/plugins/fastclick/fastclick.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('admin/dist/js/adminlte.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ URL::asset('admin/dist/js/pages/dashboard.js') }}" type="text/javascript"></script>
<!-- AdminLTE for demo purposes --> 
<script src="{{ URL::asset('admin/dist/js/demo.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	function msgshowfewsecond(text) {
	    var x = document.getElementById("snackbar")
	    x.className  = "show";
	    x.innerHTML  = text;
	    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
	}
	function anymodelhideinfewsecond(id) {
		
	    setTimeout(function(){ $(id).modal('hide'); }, 2000);
	}
	function timeDifference(current, previous) {
	    var msPerMinute = 60 * 1000;
	    var msPerHour = msPerMinute * 60;
	    var msPerDay = msPerHour * 24;
	    var msPerMonth = msPerDay * 30;
	    var msPerYear = msPerDay * 365;
	    
	    var elapsed = current - previous;
	    var now = new Date(previous);
	    if (elapsed < msPerMinute) {
			let elapsed_s = (elapsed/1000 < 0)?0:elapsed/1000;
			return Math.round(elapsed_s) + 's ago';   
	    }
	    
	    else if (elapsed < msPerHour) {
			let elapsed_m = (elapsed/msPerMinute < 0)?0:elapsed/msPerMinute;
			return Math.round(elapsed_m) + 'm ago';   
	    }
	    
	    else if (elapsed < msPerDay ) {
	    	if(now.customFormat( "#hhhh#" ) > '12'){

	    	 return now.customFormat( "#h#:#mm##AMPM#" );
	    	}else{
	    	 return now.customFormat( "#h#:#mm##ampm#" );
	    	}
	    }

	    else if (elapsed < msPerMonth) {
	    	if(now.customFormat( "#hhhh#" ) > '12'){

	    	 return now.customFormat( "#DDD# #h#:#mm##AMPM#" );
	    	}else{
	    	 return now.customFormat( "#DDD# #h#:#mm##ampm#" );
	    	}
	    }
	    
	    else if (elapsed < msPerYear) {
	    	return now.customFormat( "#MMM# #DD#" );
	    }
	    
	    else {
	    	return now.customFormat( "#YYYY# #MMM# #DD#" );
	    }
	}

	Date.prototype.customFormat = function(formatString){
	  var YYYY,YY,MMMM,MMM,MM,M,DDDD,DDD,DD,D,hhhh,hhh,hh,h,mm,m,ss,s,ampm,AMPM,dMod,th;
	  YY = ((YYYY=this.getFullYear())+"").slice(-2);
	  MM = (M=this.getMonth()+1)<10?('0'+M):M;
	  MMM = (MMMM=["January","February","March","April","May","June","July","August","September","October","November","December"][M-1]).substring(0,3);
	  DD = (D=this.getDate())<10?('0'+D):D;
	  DDD = (DDDD=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][this.getDay()]).substring(0,3);
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
@yield('scripts')