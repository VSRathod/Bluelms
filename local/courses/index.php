<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once(__DIR__ . '/../../config.php');
global $DB, $CFG, $OUTPUT, $SITE, $PAGE;
require_once($CFG->libdir . '/adminlib.php');

$_GET['courseid'] = $_GET['course_id'];
// var_dump($_GET['course_id']);
global $OUTPUT, $PAGE;
?>

<?php
$pagetitle = 'courses';
$catalogue = $CFG->wwwroot . '/local/courses/index.php?course_id='.$_GET['courseid'] ;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url($catalogue);
$PAGE->set_heading($SITE->fullname);
$categoryid = NULL;
$courseid = NULL;
$coursesort = NULL;
$searchbycatid = NULL;
// load css file
$PAGE->requires->css('/local/courses/css/style.css');
$coursedinfo = $DB->get_record('course', array('id' => $_GET['courseid']), 'fullname');
$pagetitle = $coursedinfo->fullname;
$PAGE->set_title($pagetitle);
echo $OUTPUT->header();

if (isset($_GET['courseid']) && $_GET['courseid'] !== "") {
    $courseid = $_GET['courseid'];
    if (class_exists('local_courses\Course')) {
        $courseController = new \local_courses\Course($courseid);
    }
}

echo $OUTPUT->footer();

if (!isset($courseController) || !$courseController instanceof \local_courses\Course) {
    exit;
}

?>
<script>
require(['jquery'], function($) {
    $(document).ready(function() {

        const nextBtn = $('#pagination-button-next');
        const prevBtn = $('#pagination-button-prev');

        const loader = $('#related-courses-loader');

        let pagination = {
            next: null,
            prev: null,
        };

        let relatedCourseParams = {
            page: 1,
            response: 'html',
            per_page: 6,
            'ignore_ids[]': '<?= $courseController->course->id; ?>',
            'category[]': '<?= $courseController->course->category; ?>',
            animation: 'appear-animate',
        };

        const loadData = () => {
            $.ajax({
                url: '<?= $CFG->wwwroot; ?>/local/course_catalogue/api.php',
                type: 'GET',
                data: relatedCourseParams,
                success: function(response) {

                    if (response.data) {
                        $('.related-courses-data').html(response.data);
                    } else {
                        $('.related-courses').hide();
                    }

                    pagination.next = response.pagination.next;
                    pagination.prev = response.pagination.prev;

                    if (pagination.next) {
                        nextBtn.prop('disabled', false);
                    } else {
                        nextBtn.prop('disabled', true);
                    }

                    if (pagination.prev) {
                        prevBtn.prop('disabled', false);
                    } else {
                        prevBtn.prop('disabled', true);
                    }

                    loader.fadeOut();
                }
            });
        }

        loadData();

        nextBtn.on('click', function() {
            if (!pagination.next) return;

            relatedCourseParams.animation = 'appear-left-animate';
            relatedCourseParams.page = relatedCourseParams.page + 1;
            loader.show();
            setTimeout(() => {
                loadData();
            }, 320);
        });

        prevBtn.on('click', function() {
            if (!pagination.prev) return;
            relatedCourseParams.animation = 'appear-right-animate';
            relatedCourseParams.page = relatedCourseParams.page - 1;

            if (relatedCourseParams.page < 1) {
                relatedCourseParams.page = 1;
            }

            loader.show();

            setTimeout(() => {
                loadData();
            }, 320);
        });

        // $.get('/local/course_catalogue/api.php?response=html&per_page=5&',
        //     function(response) {
        //         if (response.data) {
        //             $('.related-courses-data').html(response.data);
        //         } else {
        //             $('.related-courses').hide();
        //         }
        //     });
    });
});
</script>