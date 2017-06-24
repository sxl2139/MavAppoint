<?php
//if the value is "view", return view, else return json format
return array(
    "register" => array(
        "default" => "RegisterView",
        "getMajors" => "getMajors",
        "registerStudent" => "registerStudent",
        "success" => "SuccessView"
    ),
    "login" => array(
        "default" => "LoginView",
        "test" => "testView",
        "check" => "check",
        "logout" => "IndexView",
        "changePasswordDefault" => "ChangePasswordView",
        "changePassword" => "changePassword",
        "success" => "SuccessView"
    ),
    "index" => array(
        "default" => "IndexView"
    ),
    "admin" => array(
        "addAdvisor" => "CreateAdvisorView",
//        "addAdvisor" => "addAdvisor",
        "createNewAdvisor" => "createNewAdvisor",
        "showDepartmentSchedule" => "DepartmentScheduleView",
        "deleteTimeSlot" => "DepartmentScheduleView",
        "showAdvisorAssignment" => "AssignStudentView",
        "assignStudentToAdvisor" => "assignStudentToAdvisor",
        "success" => "SuccessView"
    ),
    "advisor" => array(
        "showSchedule" => "AdvisorScheduleView",
        "showAppointment" => "AppointmentView",
        "addTimeSlot" => "AdvisorScheduleView",
        "deleteTimeSlot" => "AdvisorScheduleView"

    ),
    "advising" => array(
        "getAdvisingInfo" => "AdvisingView",
        "schedule" => "ScheduleView",
        "getWaitListInfo" => "getWaitListInfo",
        "addToWaitList" => "addToWaitList",
        "success" => "SuccessView"
    ),
    "appointment" => array(
        "makeAppointment" => "makeAppointment",
        "success" => "SuccessView",
        "showAppointment" => "AppointmentView",
        "cancelAppointment" => "cancelAppointment"
    ),
    "customizeSetting" => array(
        "showAppointmentType" => "CustomizeSettingView",
        "cutOffTime" => "cutOffTime",
        "setEmailNotifications" => "setEmailNotifications",
        "success" => "SuccessView",
        "addTypeAndDuration" => "addTypeAndDuration",
        "deleteTypeAndDuration" => "deleteTypeAndDuration",
    ),
);