<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    'block/course_sessions:addinstance' => [
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'editingteacher' => CAP_ALLOW,
            'student' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ],

        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ]
);