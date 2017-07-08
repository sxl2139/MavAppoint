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
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <!-[if lt IE 7]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.0(beta)/IE7.js" type="text/javascript"></script>
    <![endif]">
    <!-[if lt IE 8]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.0(beta)/IE8.js" type="text/javascript"></script>
    <![endif]">
    <!-[if lt IE 9]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <![endif]">
    <link rel="stylesheet"
          href="app/Views/components/bootstrap3/css/bootstrap.css">
    <link rel="stylesheet" href="app/Views/components/bootstrap3/css/bootstrap-datetimepicker.min.css">
    <link href="app/Views/components/mavappoint.css" rel="stylesheet"/>
    <link rel="stylesheet" href="app/Views/css/fullcalendar.css">
    <link rel="icon" href="app/Views/img/mavlogo.gif" type="image/x-icon">

    <script type="text/javascript" src="app/Views/js/lib/md5.js"></script>
    <script type="text/javascript" src="app/Views/components/jquery/jquery.min.js"></script>
    <script type="text/javascript"
            src="app/Views/components/underscore/underscore-min.js"></script>
    <script type="text/javascript"
            src="app/Views/components/bootstrap3/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="app/Views/components/jstimezonedetect/jstz.min.js"></script>
    <script type="text/javascript" src="app/Views/js/lib/moment.min.js"></script>
    <script type="text/javascript" src="app/Views/js/fullcalendar.js"></script>
    <script type="text/javascript" src="app/Views/js/mav_app.js"></script>
    <script type="text/javascript"
            src="app/Views/components/bootstrap3/js/bootstrap-datetimepicker.min.js"></script>
</head>
<!--<%String load = new String();-->
<!--if (request.getRequestURI().contains("assignstudents")){-->
<!--load = "assignStudents()";-->
<!--}else{-->
<!--load = "";-->
<!--}%>-->
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div id="inversenavbar" class="container-fluid"
         style="background-color: #104E8B;">

