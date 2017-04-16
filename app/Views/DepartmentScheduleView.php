<?php
include ("template/header.php");
if (!isset($_SESSION)) {
    session_start();
}
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include ("template/" . $role . "_navigation.php");
$content = json_decode($content, true);
$schedules = isset($content['data']['schedules']) ? $content['data']['schedules'] : null;
$appointments = isset($content['data']['appointments']) ? $content['data']['appointments'] : null;
$dispatch = isset($content['dispatch']) ? $content['dispatch'] : null;
//$msg = isset($content['msg']) ? $content['msg'] : null;
if($dispatch == "success")
{?>
    <script type='text/javascript'>
        window.location.href="app/Views/success.php";
    </script>
    <?php  unset($content['dispatch']);
}
if($dispatch == "failure")
{?>
    <script type='text/javascript'>
        window.location.href="app/Views/failure.php";
    </script>
    <?php  unset($content['dispatch']);
} ?>


<div id='calendar'></div>

<!--  begin processing schedules -->
<div class="container-fluid">
    <script>

        $(document).ready(function(){

            $('#calendar').fullCalendar({
                header:
                    {
                        left:'month,basicWeek,basicDay',
                        right: 'today, prev,next',
                        center: 'title'
                    },
                displayEventEnd :
                    {
                        month: true,
                        basicWeek: true,
                        'default' : true,
                    },
                eventMouseOver: function(event,jsEvent,view){
                    $('.fc-event-inner', this).append('<div id=\"'+event.id+'\" class=\"hover-end\">'+$.fullCalendar.formatDate(event.end, 'h:mmt')+'</div>');
                },
                eventMouseout: function(event, jsEvent, view) {
                    $('#'+event.id).remove();
                },
                dayClick: function(date,jsEvent,view){
                    document.getElementById("opendate").value = date.format('YYYY-MM-DD');
                    $("#addTimeSlotModal").modal();
                }

                ,
                eventClick: function(event,element){
                    if (event.id != null){
                        document.getElementById("StartTime2").value = event.start.format('HH:mm');
                        document.getElementById("EndTime2").value = event.end.format('HH:mm');
                        document.getElementById("pname").value = event.title;
                        document.getElementById("Date").value = event.start.format('YYYY-MM-DD');
                        $("#deleteTimeSlotModal").modal();
                    }
                    else{
                        updateAppt.submit();
                    }
                },
                events: [
                    <?php
                    if(count($schedules) != 0)
                    {
                    $i = 0;
                    foreach ($schedules as $schedule)
                    {?>
                    {
                        title: '<?=$schedule['name']?>',
                        start: '<?php echo $schedule['date'] . "T" . $schedule['startTime']?>',
                        end: '<?php echo $schedule['date'] . "T" . $schedule['endTime']?>',
                        id:<?=$i?>,
                        backgroundColor: 'blue'
                    }
                    <?php
                    if ($i != count($schedules) - 1 || count($appointments) != 0) {
                        echo ",";
                    }
                    $i++;
                    }
                    }

                    if (count($appointments) != 0) {
                    $i = 1;
                    foreach ($appointments as $appointment) {
                    ?>
                    {
                        title:'<?=$appointment['appointmentType']?>',
                        start:'<?php echo $appointment['advisingDate'] . "T" . $appointment['advisingStartTime']?>',
                        end:'<?php echo $appointment['advisingDate'] . "T" . $appointment['advisingEndTime']?>',
                        id:<?=-$i?>,
                        backgroundColor: 'orange'
                    }
                    <?php
                    if ($i != count($appointments)) {echo ",";}
                    }
                    }

                    ?>
                ]


            });
        });
    </script>

    <form name=deleteTimeSlot id="delete_time_slot" action="?c=<?=$adminController?>&a=<?=$deleteTimeSlotAction?>" method="post">
        <div class="modal fade" id="deleteTimeSlotModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteTimeSlotTitle">Delete Time
                            Slot</h4>
                    </div>
                    <div class="modal-body">
                        <label for="StartTime">Start Time:</label>
                        <input type="time" class="form-control" name=StartTime2 id="StartTime2" step="300">
                        <label for="EndTime">End Time:</label>
                        <input type="time" class="form-control" name=EndTime2 id="EndTime2" step="300">
                        <label for="Date">Date:</label>
                        <input type="date" class="form-control" name=Date id="Date">
                        <input type="hidden" name=pname id="pname">
                        <label id="result2"><font style="color: #e67e22" size="4"></font></label>
                        <label for="delete_repeat">Weekly repeat duration:</label>
                        <input type="text" class="form-control" name=delete_repeat id="delete_repeat" value="0">
                        <label for="delete_reason">Reason:</label>
                        <input type="text" class="form-control" name=delete_reason id="delete_reason" placeholder="Reason for cancelling slot/s.">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close</button>
                        <input type="submit" value="submit"
                               onclick="return validate();">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script> function FormSubmit(){
            var starttime = document.getElementById("starttime").value;
            var endtime = document.getElementById("endtime").value;
            var date = document.getElementById("opendate").value;
            var repeat = document.getElementById("repeat").value;
            var params = ('starttime='+starttime+'&endtime='+endtime+'&opendate='+date+'&repeat='+repeat);
            document.getElementById('add_time_slot').submit();
        }

    </script>
    <script>
        function validate(){
            var valid = confirm('Are you sure you want to delete?');
            if (valid == true){
                document.getElementById('delete_time_slot').submit();
            }
            else {
                return false;
            }
        }
    </script>
</div>
<style>
    #calendar {
        background-color: white;
    }
</style>
