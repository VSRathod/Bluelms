<?php

require_once('../../config.php');
require_once('classes/controller.php');

require_login();
$site = get_site();
$PAGE->set_title("$site->fullname: $stradduserstogroup");
$PAGE->set_heading($site->fullname);
$elementType       = optional_param('element', false, PARAM_RAW);
$assignId          = optional_param('assignId', false, PARAM_RAW);
$assignType        = optional_param('assigntype', false, PARAM_RAW);
$elementList       = optional_param('elementList', false, PARAM_RAW);
$programList       = optional_param('programList', false, PARAM_RAW);
$licence_guid      = optional_param('licence_guid', '0', PARAM_RAW);
$usercount_in_team = optional_param('usercount_in_team', '0', PARAM_RAW);
$action            = strtolower(optional_param('action', "", PARAM_RAW));
$isRequest         = optional_param('is_request', "", PARAM_RAW);
$ext               = optional_param('ext', 0, PARAM_INT);
$hideHeaderFooter  = optional_param('hideHeaderFooter', 0, PARAM_INT);
$modifiedRole = optional_param('modifiedRole', '', PARAM_RAW);
$optionList = array();
$label = "Selected Users";
$courselabel = get_string('recommend_string', 'local_course_user');
$coursecATlabel = "Select Course Category";

$where = " AND u.id IN (" . $elementList . ")";
$query = "SELECT DISTINCT(u.id), CONCAT(u.firstname,' ', u.lastname,' (',u.username,')') AS name FROM mdl_user AS u  WHERE   u.deleted = 0 $where";
$orderBy = "  ORDER BY COALESCE(NULLIF(u.firstname, ''), u.lastname), u.lastname ASC";
$query = $query . $orderBy;
$optionListArray = $DB->get_records_sql($query);


$queryC = "SELECT id, fullname as name from mdl_course where visible = ? order by fullname ASC";
$courseOptionListArray = $DB->get_records_sql($queryC, array('1'));

$queryC = "SELECT id, name from {course_categories} where visible = ? order by name ASC";
$coursecatOptionListArray = $DB->get_records_sql($queryC, array('1'));

?>
<form id="assignform" method="post" action="">
    <div class="enrol-main">
        <div class="alert alert-success" style="display: none;"></div>
        <div class="form-group selection_option1">
            <?php
            if (count($optionListArray) > 0) {
            ?>
                <label for="element_list" class="labelSelect"><?php echo $label; ?></label>
                <span class="element selectBoxPlace">
                    <div class="elements" id="element_list">
                        <?php
                        if (!empty($optionListArray)) {
                            foreach ($optionListArray as $optionList) {
                        ?>
                                <span rel="<?php echo $optionList->id; ?>" teamuserCount="<?php echo isset($optionList->group_user_count) ? $optionList->group_user_count : 0; ?>" enddate="<?php echo $optionList->enddate; ?>"><?php echo $optionList->name; ?></span>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </span>
            <?php
            }
            ?>
        </div>
        <div class="form-group">
            <?php
            if (count($coursecatOptionListArray) > 0) {
            ?>
                <label for="coursecat_element_list" class="labelSelect"><?php echo $coursecATlabel; ?></label>
                <select class="form-control" id="coursecat_element_list" name="coursecat_element_list">
                    <?php
                    if (!empty($coursecatOptionListArray)) {
                        foreach ($coursecatOptionListArray as $optionList) {                            ?>
                            <option value="<?php echo $optionList->id; ?>"><?php echo $optionList->name; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            <?php } ?>
        </div>
        <div class="form-group">
            <?php
            if (count($courseOptionListArray) > 0) {
            ?>
                <label for="course_element_list" class="labelSelect"><?php echo $courselabel; ?></label>
                <select multiple="multiple" class="form-control" id="course_element_list" name="course_element_list">
                    <?php
                    if (!empty($courseOptionListArray)) {
                        foreach ($courseOptionListArray as $optionList) {
                    ?>
                            <option rel="<?php echo $optionList->id; ?>" class="program" enddate="<?php echo $optionList->enddate; ?>"><?php echo $optionList->name; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            <?php } ?>
        </div>
        <div class="mt-3">
            <?php if ($action == 'update') : ?>
                <input type="button" name="save" id="save_data" value="Update" class="btn btn-primary">
            <?php else : ?>
                <input type="button" name="save" id="save_data" value="Save" class="btn btn-primary">
            <?php endif; ?>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</form>

<script>
    var assignElement = "<?php echo $assignType; ?>";
    var assignId = "<?php echo $assignId; ?>";
    var assignTo = "<?php echo $elementType; ?>";
    var action = "<?php echo $action; ?>";
    var isRequest = "<?php echo $isRequest; ?>";
    var base_url = window.location.origin;


    $(document).ready(function() {

        $("#coursecat_element_list").on('change', function() {
            var coursecat_element_list = $("#coursecat_element_list").val();
            $.ajax({
                url: base_url + '/local/course_user/classes/ajax.php',
                type: 'POST',
                data: 'action=getcourses&coursecat_element_list=' + coursecat_element_list,
                success: function(data1) {
                    $("#course_element_list").html(data1);
                }
            });
        });

        $("#save_data").click(function() {
            $(this).attr("disabled", "disabled");
            var end_date = '';
            // end_date = $("#start_date").val();
            var elementList = "";

            $("#element_list").find('span').each(function() {
                elementList += $(this).attr('rel') + ',';
            });

            var courseElementList = "";
            $("#course_element_list").find(':selected').each(function() {
                courseElementList += $(this).attr('rel') + ',';
            });

            elementList = elementList.substr(0, elementList.length - 1);
            courseElementList = courseElementList.substr(0, courseElementList.length - 1);

            // alert(elementList+"     "+courseElementList);

            if (elementList != "" || courseElementList != "") {
                saveCourseElementData('user', 'course', elementList, courseElementList, end_date);
            } else {
                alert("Please select courses to be enrolled.")
            }
        });
    });

    function saveCourseElementData(assignElement, assignTo, assignId, elementList, end_date) {

        if (assignElement != '' && assignTo != '' && assignId != '' && assignId != 0 && elementList != '' && elementList != 0) {
            $.ajax({
                url: base_url + '/local/course_user/classes/ajax.php',
                type: 'POST',
                data: 'action=saveCourseRecommendData&assignElement=' + assignElement + '&assignTo=' + assignTo + '&assignId=' + assignId + '&elementList=' + elementList + '&end_date=' + end_date,
                success: function(data1) {
                    $(".alert.alert-success").html("Record has been processed successfully.").slideDown();

                    setTimeout(() => {
                        $(".alert.alert-success").slideUp();
                        $('#userActionModal').modal('hide');
                    }, 2000);
                }
            });
        }

    }
</script>