<?php

include("template/no_header.php");

$content = json_decode($content, true);
$url = $content['data'];
?>

<html>
<head>
    <title>Processing...</title>
    <link rel="stylesheet" href="app/Views/components/bootstrap3/css/bootstrap.css">
    <script type="text/javascript" src="app/Views/components/bootstrap3/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        var num = 0;
        setInterval("clock2()", 100);
        function clock2() {
            var prog = document.getElementById('progress');
            var title = document.getElementById('title');
            var loadImg = document.getElementById('loadImg');

            if(num <= 100) {
                num = num + 20;
                prog.setAttribute("style","width:"+num+"%");
            }

            if (num > 80) {
                title.innerHTML = "Success!";
                loadImg.src = "app/Views/img/correct.png";
            }
        };
        setTimeout("redirect()", 1000);
        function redirect(){
            window.location.replace("<?php echo $url?>");
        }

    </script>
</head>
<div class="container" style="margin-top:120px">
    <div class="jumbotron">
			<span>
				<img id="loadImg" src="app/Views/img/loader.gif" style="float:left; height:90px; width:90px; ">
				<h1 id="title" style="margin-left: 100px;">Processing...</h1>
			</span>

        <div class="progress progress-striped active">
            <div id ="progress" class="progress-bar role="progressbar"
            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
            style="width: 0%;">
            <span class="sr-only"></span>
        </div>
    </div>
</div>






</html>
