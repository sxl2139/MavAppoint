$(function(){

    $("#signIn").on("click", function (e) {
        e.preventDefault();

        var passhash = md5($("#password").val());
        console.log(passhash);
        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#loginController").val(),
                a : $("#checkAction").val(),
                email : $("#email").val(),
                password : passhash
            },
            success: function(data){
                var data = JSON.parse(data);
                if (data.error == 0) {
                    if (data.data.validated == 0) {
                        alert("Please change your password on first login.");
                        window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#loginController").val() + "&a=" + $("#changePasswordDefaultAction").val();
                    }else if(data.data.daysBeforeExpired !=null && data.data.daysBeforeExpired<=14 && data.data.daysBeforeExpired>=1){
                        alert("The password for your account will expire in " + data.data.daysBeforeExpired + "days.");
                        window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#loginController").val() + "&a=" + $("#changePasswordDefaultAction").val();
                    }else if(data.data.daysBeforeExpired <=0){
                        $("#message2").css("visibility", "visible");
                    } else {
                        window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#indexController").val();
                    }
                }else{
                    $("#message").css("visibility", "visible");
                }
            }
        });
    });

    $('#loginForm').submit(function (event) {
        event.preventDefault();
        window.history.back();
    });

    $("#createAdvisorSubmit").on("click", function(){
        var email = $("#emailAdvisor").val();
        var pname = $("#pname").val();
        var drp_department = $("#drp_department").val();

        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#adminController").val(),
                a : $("#createNewAdvisorAction").val(),
                email : email,
                pname : pname,
                drp_department : drp_department
            },
            success: function(data){
                var data1 = JSON.parse(data);
                if (data1.error == 0) {
                    alert(data1.data.message);
                    $("#addAdvisorResult").text(data1.data.message);
                }else{
                    alert(data1.data.message);
                    $("#addAdvisorResult").text(data1.data.message);
                }
            }
        });
    });

    $(".advisorButton").on("click", function (e) {
        var advisorName = $(this).attr("value");
        window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#advisingController").val() + "&a=" + $("#getAdvisingInfoAction").val() + "&pName=" + advisorName;
    });

    $("#makeAppointment").on("click", function (e) {
        e.preventDefault();

        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#appointmentController").val(),
                a : $("#makeAppointmentAction").val(),
                appointmentId : $("#appointmentId").val(),
                appointmentType : $("#appointmentType").val(),
                duration : $("#duration").val(),
                pName : $("#pName").val(),
                start : $("#start").val(),
                email : $("#email").val(),
                studentId : $("#studentId").val(),
                phoneNumber : $("#phoneNumber").val(),
                description : $("#description").val(),

            },
            success: function(data){
                var data = JSON.parse(data);
                if (data.error == 0) {
                    window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#appointmentController").val() + "&a=" + $("#successAction").val()
                        + "&nc=advising&na=getAdvisingInfo";
                }else{
                    //TODO redirect to failure page
                    alert("Make appointment error");
                }
            }
        });
    });


    $("#assignStudentSubmit").on("click", function (e) {
        e.preventDefault();

        var length = $("#length").val();
        var advisors = [];

        for(var i = 0; i < length; i++){
            var advisor = {};

            var degType = 0;
            $("#degree"+i+" :selected").each(function(i, selected){
                if($(selected).text() == 'Bachelors')
                    degType += 1;
                if($(selected).text() == 'Masters')
                    degType += 2;
                if($(selected).text() == 'Doctorate')
                    degType += 4;
            });

            advisor.userId = $("#userId"+i).text();
            advisor.pName = $("#pName"+i).text();
            advisor.nameLow = $("#lowRange"+i+" option:selected").val();
            advisor.nameHigh = $("#highRange"+i+" option:selected").val();
            advisor.degreeType = degType;

            var majors = "";
            $("#majors"+i+" :selected").each(function(i, selected){
                majors = majors + "," +$(selected).text();
            });
            advisor.majors = majors;
            advisors.push(advisor);
        }

        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#adminController").val(),
                a : $("#assignStudentToAdvisorAction").val(),
                advisors : JSON.stringify(advisors)
            },
            success: function(data){
                data = JSON.parse(data);
                if (data.error == 0) {
                    window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#adminController").val() + "&a=" + $("#successAction").val();
                }else{
                    alert("advising error");
                }
            }
        });
    });

    $(".cancelButton").click(function(){
        var confirmMessage = 'Are you sure you want to delete this appointment?';
        if (confirm(confirmMessage)) {
            var appointmentId = $(this).attr("value");

            $.ajax({
                url: $(".mavAppointUrl").val(),
                type: "post",
                data: {
                    c : $("#appointmentController").val(),
                    a : $("#cancelAppointmentAction").val(),
                    appointmentId : appointmentId
                },
                success: function(data){
                    var data = JSON.parse(data);
                    if (data.error == 0) {
                        window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#appointmentController").val() + "&a=" + $("#successAction").val()
                        + "&nc=appointment&na=showAppointment";
                    }else{
                        //TODO redirect to failure page
                        alert("Cancel appointment error");
                    }
                }
            });
        }

    });

    $("#drp_department_register").change(function(){
        var department = $("#drp_department_register option:selected").text();
        //alert(department);
        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#registerController").val(),
                a : $("#getMajorsAction").val(),
                department : department
            },
            success: function(data){
                var data = JSON.parse(data);
                if (data.error == 0) {
                    $('#drp_major').empty();
                    $.each(data.data.majors, function(key, value) {
                        $('#drp_major')
                            .append($("<option></option>")
                                //.attr("value",key)
                                .text(value));
                    });
                }else{
                    alert("Error when getting majors from department");
                }
            }
        });
    });

    $("#registerSubmit").click(function(e){
        e.preventDefault();

        var email = $("#email").val();
        var studentId = $("#studentId").val();
        var phoneNumber = $("#phoneNumber").val();

        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#registerController").val(),
                a : $("#registerStudentAction").val(),
                email : email,
                studentId : studentId,
                phoneNumber : phoneNumber,
                department : $('#drp_department_register').find(":selected").text(),
                major : $('#drp_major').find(":selected").text(),
                degree : $('#drp_degreeType').find(":selected").text(),
                initial : $('#drp_last_name_initial').find(":selected").text()
            },
            success: function(data){
                var data = JSON.parse(data);
                if (data.error == 0) {
                    window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#registerController").val() + "&a=" + $("#successAction").val()
                        + "&nc=login&na=default";
                }else{
                    $("#registerErrorMessage").text(data.description).css({'color' : '#e67e22', 'font-size' : '16px'});
                }
            }
        });
    });

    $("#addToWaitListSubmit").click(function(e){
        e.preventDefault();

        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#advisingController").val(),
                a : $("#addToWaitListAction").val(),
                email : $("#email").val(),
                studentId : $("#studentId").val(),
                appointmentId : $("#appointmentId").val(),
                appointmentType : $("#appType").val(),
                phoneNumber : $("#phoneNumber").val(),
                description : $("#description").val()
            },
            success: function(data){
                var data = JSON.parse(data);
                if (data.error == 0) {
                    window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#advisingController").val() + "&a=" + $("#successAction").val()
                        + "&nc=advising&na=getAdvisingInfo";
                }else{
                    alert(data.description);
                }
            }
        });
    });

    $("#cutOffTimeSubmit").click(function(e){
        e.preventDefault();

        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#customizeSettingController").val(),
                a : $("#cutOffTimeAction").val(),
                cutOffTime : $("#cutOffTimeText").val()
            },
            success: function(data){
                var data = JSON.parse(data);
                if (data.error == 0) {
                    window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#customizeSettingController").val() + "&a=" + $("#successAction").val();
                }else{
                    alert("Error while updating cutOff time")
                }
            }
        });
    });


    $("#setEmailNotificationsSubmit").click(function(e){
        e.preventDefault();

        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#customizeSettingController").val(),
                a : $("#setEmailNotificationsAction").val(),
                notify : $("input[name=notify]:checked").val()
            },
            success: function(data){
                var data = JSON.parse(data);
                if (data.error == 0) {
                    window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#customizeSettingController").val() + "&a=" + $("#successAction").val();
                }else{
                    alert("Error while updating notification")
                }
            }
        });
    });

    $("#addTypeAndDurationSubmit").click(function(e){
        e.preventDefault();

        $.ajax({
            url: $(".mavAppointUrl").val(),
            type: "post",
            data: {
                c : $("#customizeSettingController").val(),
                a : $("#addTypeAndDurationAction").val(),
                apptypes : $("#apptypes").val(),
                minutes : $("#minutes").val(),
            },
            success: function(data){
                var data = JSON.parse(data);
                if (data.error == 0) {
                    window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#customizeSettingController").val() + "&a=" + $("#successAction").val();
                }else{
                    alert("Error while updating notification")
                }
            }
        });
    });

    $(".deleteTypeAndDurationSubmit").click(function(e){
        e.preventDefault();
        var confirmMessage = 'Are you sure you want to delete this appointment type?';
        if (confirm(confirmMessage)){
            var apptypes = $(this).parent().parent().children(":first").text();
            var minutes = $(this).parent().parent().children(":nth-child(2)").text();

            $.ajax({
                url: $(".mavAppointUrl").val(),
                type: "post",
                data: {
                    c : $("#customizeSettingController").val(),
                    a : $("#deleteTypeAndDurationAction").val(),
                    apptypes : apptypes,
                    minutes : minutes
                },
                success: function(data){
                    var data = JSON.parse(data);
                    if (data.error == 0) {
                        window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#customizeSettingController").val() + "&a=" + $("#successAction").val();
                    }else{
                        alert("Error while updating notification")
                    }
                }
            });
        }
    });

    $("#changePasswordSubmit").click(
        function(e)
        {
            e.preventDefault();
            $.ajax(
                {
                    url: $(".mavAppointUrl").val(),
                    type: "post",
                    data:
                        {
                            c : $("#loginController").val(),
                            a : $("#changePasswordAction").val(),
                            currentPassword : $("#currentPassword").val(),
                            newPassword : $("#newPassword").val(),
                            repeatPassword : $("#repeatPassword").val()
                        },
                    success: function(data) {
                        var data = JSON.parse(data);
                        if (data.error == 0) {
                            window.location.href = $(".mavAppointUrl").val() + "?c=" + $("#loginController").val() + "&a=" + $("#successAction").val() + "&nc=index&na=default";
                        }
                        else{
                            $("#changePasswordErrorMessage").text(data.description).css({'color' : '#e67e22', 'font-size' : '16px'});
                        }
                    }
                }
            );
        }
    );
});