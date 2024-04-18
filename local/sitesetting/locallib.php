<?php 

// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * create some plugin related functions
 *
 * @package local_sitesetting
 * @copyright 2020 Akash Uphade (akash.u@paradisosolutions.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @paradiso 
 */

defined('MOODLE_INTERNAL') || die();
require_once(dirname(__FILE__) . '/../../config.php');


class customise {


    /**
     * Get the roles which are meant to be 
     * having ability to access site settings
     *
     * @author  Akash Uphade
     * @since   29-07-2020
     * @return  array roles array
     * @paradiso
     */

    public function local_sitesetting_get_roles()
    {
        global $DB;
      
        $roles = $DB->get_records_list('role', 'shortname', 
                ['manager', 'admin','siteadmin', ]);
           
        return $roles;
    }

}


/**
* @author: Vaibhav G.
* @since : 16 March 21 
* @desc : getting overall assigned settings for that role user & view it.
*/
class search {
    
    //getting logged in user's role
    public function local_get_logged_user_role(){
        global $USER;
        $context = context_system::instance();
      
        $roles = get_user_roles($context, $USER->id);
        $role = key($roles);
        $roleid = $roles[$role]->roleid;

        return $roles[$role];
    }

    //getting assigned site settings
    public function local_search_settings() {
        global $DB;
        $settings = array();

        $role = $this->local_get_logged_user_role();
        

        //getting main heading
        // Getting main headings
if (is_siteadmin()) {
    $settings_level_1 = $DB->get_records('local_sitesetting', array('level' => 1, 'parent_id' => 0));
} else {
    $settings_level_1 = $DB->get_records('local_sitesetting', array('role_id' => $role->roleid, 'level' => 1, 'parent_id' => 0));
}

foreach ($settings_level_1 as $key1 => $value1) {
    // Getting subheadings
    if (is_siteadmin()) {
        $settings_level_2 = $DB->get_records('local_sitesetting', array('level' => 2, 'parent_id' => $value1->id));
    } else {
        $settings_level_2 = $DB->get_records('local_sitesetting', array('role_id' => $role->roleid, 'level' => 2, 'parent_id' => $value1->id));
    }

    foreach ($settings_level_2 as $key2 => $value2) {
        // Getting subheading's children
        if (is_siteadmin()) {
            $settings_level_3 = $DB->get_records('local_sitesetting', array('level' => 3, 'parent_id' => $value2->id));
        } else {
            $settings_level_3 = $DB->get_records('local_sitesetting', array('role_id' => $role->roleid, 'level' => 3, 'parent_id' => $value2->id));
        }

        // Building the nested array
        foreach ($settings_level_3 as $key3 => $value3) {
            $settings[$value1->setting][$value2->setting][$value3->url] = get_string($value3->setting, 'local_sitesetting');
        }
    }
}

return $settings;

    }

    //viewing assigned site settings
    public function local_search_view(){
        
        $settings = $this->local_search_settings();

        
        $role = $this->local_get_logged_user_role();

        $out = '';

        if(!empty($settings) || is_siteadmin()){
            //showing main hedings
            $out .= '<ul class="nav nav-tabs" role="tablist">';
                foreach($settings as $p1 => $p1value){
                    if($p1 == 'root'){
                        $out .= '<li class="nav-item">';
                            $out .= '<a class="nav-link active" href="#linkroot" data-toggle="tab" role="tab">'.get_string('root', 'local_sitesetting').'</a>';
                        $out .= '</li>';
                    }else{
                        $out .= '<li class="nav-item adminBtn">';
                            $out .= '<a class="nav-link" href="#link'.$p1.'" data-toggle="tab" role="tab">'.get_string($p1, 'local_sitesetting').'</a>';
                        $out .= '</li>';
                    }
                }
            $out .= '</ul>';


                $out .= '<div class="tab-content">';        
                    foreach($settings as $p1 => $p1value){                 
                        $out .= '<div class="tab-pane" id="link'.$p1.'" role="tabpanel">';              
                            $out .= '<div class="card">';
                                $out .= '<div class="card-block pl-0">';
                                    $out .= '<div class="container-fluid">';
                                        foreach($p1value as $p2 => $p2value){
                                            $out .= '<div class="row">';                                    
                                                $out .= '<div class="col-sm-3 pl-0">';
                                                    $out .= '<h4 class="heading-settings">';
                                                        $out .= '<button type="button" class="btn btn-link text-info" data-toggle="collapse" data-target="#'.$p2.'" aria-expanded="true" aria-controls="'.$p2.'">';
                                                                //showing sub headings
                                                                if($p2 != 'General')
                                                                    $sub_head = new moodle_url("/admin/category.php?category=".$p2);
                                                                $out .= '<label><a href="'.$sub_head.'">'.get_string($p2, 'local_sitesetting').'</a></label>';
                                                        $out .= '</button>';
                                                    $out .= '</h4>';
                                                $out .= '</div>';
                                                
                                                $out .= '<div class="col-sm-9">';
                                                    foreach($p2value as $p3 => $p3value){
                                                        $out .= '<ul class="list-unstyled admin-settings">';
                                                            //showing sub heading's childrens
                                                            $child = new moodle_url($p3);
                                                            $out .= '<li style="margin-top: 5px;"><a href="'.$child.'">'.$p3value.'</a></li>';
                                                        $out .= '</ul>';                                 
                                                    }
                                                $out .= '</div>';
                                                
                                            $out .= '</div>';
                                            $out .= '<hr>';
                                        }
                                    $out .= '</div>';
                                $out .= '</div>';
                            $out .= '</div>';
                        $out .= '</div>';
                    }
                $out .= '</div>';
        }else{
            echo get_string('warning', 'local_sitesetting');
        }

        return $out;
    }
}