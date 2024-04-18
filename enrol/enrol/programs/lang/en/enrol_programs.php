<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Program enrolment plugin language file.
 *
 * @package    enrol_programs
 * @copyright  Copyright (c) 2022 Open LMS (https://www.openlms.net/)
 * @author     Petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['addprogram'] = 'Add learning path';
$string['addset'] = 'Add new set';
$string['allocationend'] = 'Allocation end';
$string['allocationend_help'] = 'Allocation end date meaning depends on enabled allocation sources. Usually new allocation are not possible after this date if specified.';
$string['allocation'] = 'Allocation';
$string['allocations'] = 'Allocations';
$string['allocationdate'] = 'Allocation date';
$string['allocationsources'] = 'Allocation sources';
$string['allocationstart'] = 'Allocation start';
$string['allocationstart_help'] = 'Allocation start date meaning depends on enabled allocation sources. Usually new allocation are possible only after this date if specified.';
$string['allprograms'] = 'All learning paths';
$string['appenditem'] = 'Append item';
$string['appendinto'] = 'Append into item';
$string['archived'] = 'Archived';
$string['catalogue'] = 'Learning path catalogue';
$string['catalogue_dofilter'] = 'Search';
$string['catalogue_resetfilter'] = 'Clear';
$string['catalogue_searchtext'] = 'Search text';
$string['catalogue_tag'] = 'Filter by tag';
$string['cohorts'] = 'Visible to cohorts';
$string['cohorts_help'] = 'Non-public learning paths can be made visible to specified cohort members.

Visibility status does not affect already allocated learning paths.';
$string['completiondate'] = 'Completion date';
$string['creategroups'] = 'Course groups';
$string['creategroups_help'] = 'If enabled a group will be created in each course added to progam and all allocated users will be added as group members.';
$string['deleteallocation'] = 'Delete learning path allocation';
$string['deletecourse'] = 'Remove course';
$string['deleteprogram'] = 'Delete learning path';
$string['deleteset'] = 'Delete set';
$string['documentation'] = 'Learning paths for Moodle documentation';
$string['duedate'] = 'Due date';
$string['enrolrole'] = 'Course role';
$string['enrolrole_desc'] = 'Select role that will be used by learning path for course enrolment';
$string['errorcontentproblem'] = 'Problem detected in the learning path content structure, learning path completion will not be tracked correctly!';
$string['errornoallocations'] = 'No user allocations found';
$string['errornoallocation'] = 'Learning path is not allocated';
$string['errornomyprograms'] = 'You are not allocated to any learning paths.';
$string['errornoprograms'] = 'No learning paths found.';
$string['errornorequests'] = 'No learning path requests found';
$string['errornotenabled'] = 'Learning paths plugin is not enabled';
$string['event_program_completed'] = 'Learning path completed';
$string['event_program_created'] = 'Learning path created';
$string['event_program_deleted'] = 'Learning path deleted';
$string['event_program_updated'] = 'Learning path updated';
$string['event_program_viewed'] = 'Learning path viewed';
$string['event_user_allocated'] = 'User allocated to learning path';
$string['event_user_deallocated'] = 'User deallocated from learning path';
$string['evidence'] = 'Other evidence';
$string['evidence_details'] = 'Details';
$string['fixeddate'] = 'At a fixed date';
$string['item'] = 'Item';
$string['itemcompletion'] = 'Learning path item completion';
$string['management'] = 'Learning paths management';
$string['messageprovider:allocation_notification'] = 'Learning path allocation notification';
$string['messageprovider:approval_request_notification'] = 'Learning path approval request notification';
$string['messageprovider:approval_reject_notification'] = 'Learning path request rejection notification';
$string['messageprovider:completion_notification'] = 'Learning path completed notification';
$string['messageprovider:deallocation_notification'] = 'Learning path deallocation notification';
$string['messageprovider:duesoon_notification'] = 'Learning path due date soon notification';
$string['messageprovider:due_notification'] = 'Learning path overdue notification';
$string['messageprovider:endsoon_notification'] = 'Learning path end date soon notification';
$string['messageprovider:endcompleted_notification'] = 'Completed learning path ended notification';
$string['messageprovider:endfailed_notification'] = 'Failed learning path ended notification';
$string['messageprovider:start_notification'] = 'Learning path started notification';
$string['moveitem'] = 'Move item';
$string['moveitemcancel'] = 'Cancel moving';
$string['moveafter'] = 'Move "{$a->item}" after "{$a->target}"';
$string['movebefore'] = 'Move "{$a->item}" before "{$a->target}"';
$string['moveinto'] = 'Move "{$a->item}" into "{$a->target}"';
$string['myprograms'] = 'My learning paths';
$string['notification_allocation'] = 'User allocated';
$string['notification_completion'] = 'Learning path completed';
$string['notification_completion_subject'] = 'Learning path completed';
$string['notification_completion_body'] = 'Hello {$a->user_fullname},

you have completed learning path "{$a->program_fullname}".
';
$string['notification_deallocation'] = 'User deallocated';
$string['notification_duesoon'] = 'Learning path due date soon';
$string['notification_duesoon_subject'] = 'Learning path completion is expected soon';
$string['notification_duesoon_body'] = 'Hello {$a->user_fullname},

completion of learning path "{$a->program_fullname}" is expected on {$a->program_duedate}.
';
$string['notification_due'] = 'Learning path overdue';
$string['notification_due_subject'] = 'Learning path completion was expected';
$string['notification_due_body'] = 'Hello {$a->user_fullname},

completion of learning path "{$a->program_fullname}" was expected before {$a->program_duedate}.
';
$string['notification_endsoon'] = 'Learning path end date soon';
$string['notification_endsoon_subject'] = 'Learning path ends soon';
$string['notification_endsoon_body'] = 'Hello {$a->user_fullname},

Learning path "{$a->program_fullname}" is ending on {$a->program_enddate}.
';
$string['notification_endcompleted'] = 'Completed learning path ended';
$string['notification_endcompleted_subject'] = 'Completed learning path ended';
$string['notification_endcompleted_body'] = 'Hello {$a->user_fullname},

learning path "{$a->program_fullname}" ended, you have completed it earlier.
';
$string['notification_endfailed'] = 'Failed learning path ended';
$string['notification_endfailed_subject'] = 'Failed learning path ended';
$string['notification_endfailed_body'] = 'Hello {$a->user_fullname},

Learning path "{$a->program_fullname}" ended, you have failed to complete it.
';
$string['notification_start'] = 'Learning path started';
$string['notification_start_subject'] = 'Learning path started';
$string['notification_start_body'] = 'Hello {$a->user_fullname},

learning path "{$a->program_fullname}" has started.
';
$string['notificationdates'] = 'Notification dates';
$string['notset'] = 'Not set';
$string['plugindisabled'] = 'Learning path enrolment plugin is disabled, learning paths will not be functional.

[Enable plugin now]({$a->url})';
$string['pluginname'] = 'Learning paths';
$string['pluginname_desc'] = 'Learning paths are designed to allow creation of course sets.';
$string['privacy:metadata:field:programid'] = 'Learning path id';
$string['privacy:metadata:field:timeallocated'] = 'Learning path allocation date';
$string['privacy:metadata:field:timecompleted'] = 'Completion date';
$string['privacy:metadata:field:timecreated'] = 'Creation date';
$string['privacy:metadata:field:timerejected'] = 'Rejection date';
$string['privacy:metadata:field:timerequested'] = 'Request date';
$string['privacy:metadata:field:timesnapshot'] = 'Snapshot date';
$string['privacy:metadata:field:timestarted'] = 'learning path start date';
$string['privacy:metadata:field:userid'] = 'User id';
$string['privacy:metadata:table:enrol_programs_allocations'] = 'Information about learning path allocations';
$string['privacy:metadata:table:enrol_programs_evidences'] = 'Information about other completion evidences';
$string['privacy:metadata:table:enrol_programs_requests'] = 'Information about allocation request';
$string['privacy:metadata:table:enrol_programs_usr_snapshots'] = 'Learning path allocation snapshots';
$string['program'] = 'Learning path';
$string['programautofix'] = 'Auto repair learning path';
$string['programdue'] = 'Learning path due';
$string['programdue_help'] = 'Learning path due date indicates when users are expected to complete the learning path.';
$string['programdue_delay'] = 'Due after start';
$string['programdue_date'] = 'Due date';
$string['programend'] = 'Learning path end';
$string['programend_help'] = 'Users cannot enter learning path courses after learning path end.';
$string['programend_delay'] = 'End after start';
$string['programend_date'] = 'Learning path end date';
$string['programimage'] = 'Learning path image';
$string['programname'] = 'Learning path name';
$string['programs'] = 'Learning paths';
$string['programsactive'] = 'Active';
$string['programsarchived'] = 'Archived';
$string['programsarchived_help'] = 'Archived learning paths are hidden from users and their progress is locked.';
$string['programstart'] = 'Learning path start';
$string['programstart_help'] = 'Users cannot enter learning path courses before learning path start.';
$string['programstart_allocation'] = 'Start immediately after allocation';
$string['programstart_delay'] = 'Delay start after allocation';
$string['programstart_date'] = 'Learning path start date';
$string['programstatus'] = 'Learning path status';
$string['programstatus_completed'] = 'Completed';
$string['programstatus_any'] = 'Any learning path status';
$string['programstatus_archived'] = 'Archived';
$string['programstatus_archivedcompleted'] = 'Archived completed';
$string['programstatus_overdue'] = 'Overdue';
$string['programstatus_open'] = 'Open';
$string['programstatus_future'] = 'Not open yet';
$string['programstatus_failed'] = 'Failed';
$string['programs:addcourse'] = 'Add course to learning paths';
$string['programs:allocate'] = 'Allocate students to learning paths';
$string['programs:delete'] = 'Delete learning paths';
$string['programs:edit'] = 'Add and update learning paths';
$string['programs:admin'] = 'Advanced learning path administration';
$string['programs:manageevidence'] = 'Manage other completion evidence';
$string['programs:view'] = 'View learning path management';
$string['programs:viewcatalogue'] = 'Access learning path catalogue';
$string['public'] = 'Public';
$string['public_help'] = 'Public learning paths are visible to all users.

Visibility status does not affect already allocated learning paths.';
$string['sequencetype'] = 'Completion type';
$string['sequencetype_allinorder'] = 'All in order';
$string['sequencetype_allinanyorder'] = 'All in any order';
$string['sequencetype_atleast'] = 'At least {$a->min}';
$string['selectcategory'] = 'Select category';
$string['source'] = 'Source';
$string['source_approval'] = 'Requests with approval';
$string['source_approval_allownew'] = 'Allow approvals';
$string['source_approval_allownew_desc'] = 'Allow adding new _requests with approval_ sources to learning paths';
$string['source_approval_allowrequest'] = 'Allow new requests';
$string['source_approval_confirm'] = 'Please confirm that you want to request allocation to the learning path.';
$string['source_approval_daterequested'] = 'Date requested';
$string['source_approval_daterejected'] = 'Date rejected';
$string['source_approval_makerequest'] = 'Request access';
$string['source_approval_notification_allocation_subject'] = 'Learning path approval notification';
$string['source_approval_notification_allocation_body'] = 'Hello {$a->user_fullname},

your sign up for learning path "{$a->program_fullname}" was approved, the start date is {$a->program_startdate}.
';
$string['source_approval_notification_approval_request_subject'] = 'Learning path request notification';
$string['source_approval_notification_approval_request_body'] = '
User {$a->user_fullname} requested access to learning path "{$a->program_fullname}".
';
$string['source_approval_notification_approval_reject_subject'] = 'Learning path request rejection notification';
$string['source_approval_notification_approval_reject_body'] = 'Hello {$a->user_fullname},

your request to access "{$a->program_fullname}" learning path was rejected.

{$a->reason}
';
$string['source_approval_requestallowed'] = 'Requests are allowed';
$string['source_approval_requestnotallowed'] = 'Requests are not allowed';
$string['source_approval_requests'] = 'Requests';
$string['source_approval_requestpending'] = 'Access request pending';
$string['source_approval_requestrejected'] = 'Access request was rejected';
$string['source_approval_requestapprove'] = 'Approve request';
$string['source_approval_requestreject'] = 'Reject request';
$string['source_approval_requestdelete'] = 'Delete request';
$string['source_approval_rejectionreason'] = 'Rejection reason';
$string['source_base_notification_allocation_subject'] = 'Learning path allocation notification';
$string['source_base_notification_allocation_body'] = 'Hello {$a->user_fullname},

you have been allocated to learning path "{$a->program_fullname}", the start date is {$a->program_startdate}.
';
$string['source_base_notification_deallocation_subject'] = 'Learning path deallocation notification';
$string['source_base_notification_deallocation_body'] = 'Hello {$a->user_fullname},

you have been deallocated from learning paths "{$a->program_fullname}".
';
$string['source_cohort'] = 'Automatic cohort allocation';
$string['source_cohort_allownew'] = 'Allow cohort allocation';
$string['source_cohort_allownew_desc'] = 'Allow adding new _cohort auto allocation_ sources to learning paths';
$string['source_manual'] = 'Manual allocation';
$string['source_manual_allocateusers'] = 'Allocate users';
$string['source_manual_potusersmatching'] = 'Matching allocation candidates';
$string['source_manual_potusers'] = 'Allocation candidates';
$string['source_selfallocation'] = 'Self allocation';
$string['source_selfallocation_allocate'] = 'Sign up';
$string['source_selfallocation_allownew'] = 'Allow self allocation';
$string['source_selfallocation_allownew_desc'] = 'Allow adding new _self allocation_ sources to learning path';
$string['source_selfallocation_allowsignup'] = 'Allow new sign ups';
$string['source_selfallocation_confirm'] = 'Please confirm that you want to be allocated to the learning path.';
$string['source_selfallocation_enable'] = 'Enable self allocation';
$string['source_selfallocation_key'] = 'Sign up key';
$string['source_selfallocation_keyrequired'] = 'Sign up key is required';
$string['source_selfallocation_maxusers'] = 'Max users';
$string['source_selfallocation_maxusersreached'] = 'Maximum number of users self-allocated already';
$string['source_selfallocation_maxusers_status'] = 'Users {$a->count}/{$a->max}';
$string['source_selfallocation_notification_allocation_subject'] = 'Learning path allocation notification';
$string['source_selfallocation_notification_allocation_body'] = 'Hello {$a->user_fullname},

you have signed up for learning path "{$a->program_fullname}", the start date is {$a->program_startdate}.
';
$string['source_selfallocation_signupallowed'] = 'Sign ups are allowed';
$string['source_selfallocation_signupnotallowed'] = 'Sign ups are not allowed';
$string['set'] = 'Course set';
$string['settings'] = 'Learning path settings';
$string['scheduling'] = 'Scheduling';
$string['taballocation'] = 'Allocation settings';
$string['tabcontent'] = 'Content';
$string['tabgeneral'] = 'General';
$string['tabusers'] = 'Users';
$string['tabvisibility'] = 'Visibility settings';
$string['tagarea_program'] = 'Learning paths';
$string['taskcron'] = 'Learning path plugin cron';
$string['unlinkeditems'] = 'Unlinked items';
$string['updateprogram'] = 'Update learning path';
$string['updateallocation'] = 'Update allocation';
$string['updateallocations'] = 'Update allocations';
$string['updateset'] = 'Update set';
$string['updatescheduling'] = 'Update scheduling';
$string['updatesource'] = 'Update {$a}';
