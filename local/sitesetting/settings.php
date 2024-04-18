<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if ($hassiteconfig) {

	$admins = get_admins();
	$isadmin = false;
	foreach($admins as $admin) {
	    if ($USER->id == $admin->id) {
	        $isadmin = true;
	        break;
	    }
	}
	if($isadmin){
	    $ADMIN->add('root', new admin_category('sitesetting', get_string('pluginname','local_sitesetting')));
    
    $ADMIN->add('sitesetting', 
    		new admin_externalpage('sitesetting', get_string('sitesetting','local_sitesetting'),
               $CFG->wwwroot . '/local/sitesetting/customise.php'));
	}
}
    