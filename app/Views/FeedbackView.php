<?php
include("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include("template/" . $role . "_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];

$feedbackController = mav_encrypt("feedback");
$replyFeedbackAction = mav_encrypt("replyFeedback");

$content = json_decode($content, true);
$feedbackArray = $content['data']['feedback'];
?>

<input id="feedbackReplyPosition" type="hidden"/>
<input id="feedbackController" type="hidden" value="<?php echo $feedbackController?>"/>
<input id="replyFeedbackAction" type="hidden" value="<?php echo $replyFeedbackAction?>"/>

<div class="panel panel-default">
    <div class="panel-heading"><h2>Feedbacks</h2></div>
    <div class="panel-body">

            <?php
            $position = 0;
            foreach ($feedbackArray as $feedback) {
                echo "<div style='padding:5px;'>";

                echo "<input id='feedbackUid".$position."' type='hidden' value='".$feedback['uid']."'/>";
                echo "<input id='feedbackFid".$position."' type='hidden' value='".$feedback['fid']."'/>";

                echo "<div style='width:100px; float: right; top:0;'>";
                if ($feedback['isHandled'] == 0) {
                    echo "<button id='feedback_reply_button".$position."' type='button' value='".$position."' data-toggle='modal' data-target='#feedbackReplyModel'  class='btn btn-info btn-block feedbackReplyBtn'>Reply</button>";
                } else {
                    echo "<button type='button' disabled='disabled' class='btn btn-default btn-block'>Handled</button>";
                }
                echo "</div>";

                echo "<strong>";
                echo "<a id='feedback_title".$position."' style='color:black;' data-toggle='collapse' data-parent='#accordion' href='#collapse" . $position . "'>";
                echo $feedback['title'];
                echo "</a>";
                echo "</strong>";

                echo "<div id='collapse" . $position . "' class='panel-collapse collapse'>";
                echo "<p id='feedback_content".$position."' class='text-muted' style='overflow: hidden; text-overflow: ellipsis;'>";
                echo $feedback['content'];
                echo "</p>";
                echo "</div>";

                echo "</div>";
                echo "<hr>";

                $position++;
            }
            ?>

        <div class="modal fade" id="feedbackReplyModel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Reply</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label id="feedback_reply_comment_label" for="feedback_reply_comment">Comment</label>
                            <textarea style="z-index:0" class="form-control" rows="5" id="feedback_reply_comment"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="feedback_reply_loading_section" style="display:none; float:left; margin: 5px;">
                            <img id="feedback_reply_loading_img" style="margin-bottom:5px; width:15px; height:15px;">
                            <font id="feedback_reply_loading_text" size="3"></font>
                        </div>

                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button id="button_feedback_reply_submit" type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>
</div>

