<?php

// Require the Composer autoloader
require 'vendor/autoload.php';

// Load the Mustache template from a file
$template = file_get_contents('render_template.php.mustache');

// Define sample data to be passed to the template
$data = [
    'data' => [
        'actionurl' => 'data.actionurl',
        'rolelabel' => 'Role Label',
        'roles' => [
            ['id' => 1, 'shortname' => 'Role 1'],
            ['id' => 2, 'shortname' => 'Role 2'],
            // Add more roles if needed
        ],
        // Define 'node' and other required data here
    ]
];

// Create a Mustache engine instance
$mustache = new Mustache_Engine;

// Render the template with the provided data
echo $OUTPUT->render_from_template('local_sitesetting/admin_setting', ['node' => $node, 'data' => $data]); 

?>
    