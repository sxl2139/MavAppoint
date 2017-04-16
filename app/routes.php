<?php
//if the value is "view", return view, else return json format
return [
    "register" => [
        "default" => "RegisterView",
        "getMajors" => "getMajors",
        "registerStudent" => "registerStudent"
    ],
    "login" => [
        "default" => "LoginView",
        "test" => "testView",
        "check" => "check",
        "logout" => "IndexView",
    ],
    "index" => [
        "default" => "IndexView"
    ],
    "admin" => [
        "addAdvisor" => "CreateAdvisorView",
        "createNewAdvisor" => "createNewAdvisor",
        "showDepartmentSchedule" => "DepartmentScheduleView",
        "deleteTimeSlot" => "DepartmentScheduleView",
        "showAdvisorAssignment" => "AssignStudentView",
        "assignStudentToAdvisor" => "assignStudentToAdvisor",
        "success" => "SuccessView"
    ],
    "advisor" => [
        "showSchedule" => "AdvisorScheduleView",
        "addTimeSlot" =>  "AdvisorScheduleView",
        "deleteTimeSlot" => "AdvisorScheduleView"

    ],
    "advising" => [
        "getAdvisingInfo" => "AdvisingView",
        "schedule" => "ScheduleView",
        "getWaitListInfo" => "getWaitListInfo",
        "addToWaitList" => "addToWaitList",
        "success" => "SuccessView"
    ],
    "appointment" => [
        "makeAppointment" => "makeAppointment",
        "success" => "SuccessView",
        "showAppointment" => "AppointmentView",
        "cancelAppointment" => "cancelAppointment"
    ],
    "customizeSetting" => [
        "showAppointmentType" => "CustomizeSettingView",
        "cutOffTime" => "cutOffTime",
        "setEmailNotifications" => "setEmailNotifications",
        "success" => "SuccessView",
        "addTypeAndDuration" => "addTypeAndDuration",
        "deleteTypeAndDuration" => "deleteTypeAndDuration",
    ],
];