<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
    <title>MavAppoint</title>

    <meta name="description"
          content="Full view calendar component for twitter bootstrap with year, month, week, day views.">
    <meta name="keywords"
          content="jQuery,Bootstrap,Calendar,HTML,CSS,JavaScript,responsive,month,week,year,day">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="./components/bootstrap3/css/bootstrap.css">
    <link rel="stylesheet" href="./components/bootstrap3/css/bootstrap-datetimepicker.min.css">
    <link href="./components/mavappoint.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/fullcalendar.css">
    <link rel="icon" href="./img/mavlogo.gif" type="image/x-icon">

    <script type="text/javascript" src="./components/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="./components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="./components/bootstrap3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./components/jstimezonedetect/jstz.min.js"></script>
    <script type="text/javascript" src="./js/lib/moment.min.js"></script>
    <script type="text/javascript" src="./js/fullcalendar.js"></script>
    <script type="text/javascript" src="./components/bootstrap3/js/bootstrap-datetimepicker.min.js"></script>
</head>
<body>
<html>
<head>
    <title>Failed</title>
    <link rel="stylesheet"
	href="./components/bootstrap3/css/bootstrap.css">
	<script type="text/javascript"
	src="./components/bootstrap3/js/bootstrap.min.js"></script>
</head>
	<div class="container" style="margin-top:120px">
		<div class="jumbotron">
			<span>
				<img src="./img/wrong.png" style="float:left; height:90px; width:90px;">
				<h1>Failed!</h1>
			</span>

       	    <span id="second" >3</span> seconds will redirect to previous page...
       	    <div class="progress progress-striped active">
   <div id ="progress" class="progress-bar role="progressbar"
      aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
      style="width: 0%;">
      <span class="sr-only"></span>
   </div>
</div>
    	</div>
	</div>


<script type="text/javascript">


    setInterval("clock()", 1000);
    function clock() {
        var span = document.getElementById('second');
        var num = span.innerHTML;
        if(num != 0) {
            num--;
            span.innerHTML = num;
        }
        else{
            window.history.back();
        }
    };

    var num = 0;
    setInterval("clock2()", 100);
    function clock2() {
    	var prog = document.getElementById('progress');

        if(num <= 100) {
            num = num + 10/3;
            prog.setAttribute("style","width:"+num+"%");
        }
    };
</script>


</html>