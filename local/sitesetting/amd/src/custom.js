// Standard license block omitted.
/*
 * Note: All the logic written here is dependent on the HTML DOM structure
 *       defined in the customize.mustache file, so if any changes are made
 *       in the mustache file then changes need to be done here as well
 *
 * @package    local_sitesetting
 * @copyright  2020 Akash U (akash.u@paradisosolutions.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @paradiso
 */
 
 /**
  * @module local_sitesetting/custom
  */
 define(['jquery', 'core/ajax', 'core/notification'], function($, ajax, notification) {

    return { 
        init: function(params) {
            $(document).ready(function() {   
                
                /**
                * @author: Vaibhav G.
                * @since : 16 March 21 
                * @desc: keeping active for general tab.
                */
                $('#linkroot').addClass('active');

                /**
                * This function will check the checkboxes for saved settings
                * 
                * @params: array settings information
                * @author: Akash Uphade
                * @paradiso
                */
                function check_saved_settings(settings) {
                    
                    // Reset all checkboxes first
                    $('input:checkbox').prop('checked', false);
                
                    var classes = [];

                    settings.forEach(function(value, index) {

                        //check the checkbox for the setting
                        $('#' + value.setting).prop("checked", true);

                        if (!classes.includes($('#' + value.setting).attr('class'))) {
                            classes.push($('#' + value.setting).attr('class'));
                        }

                    });

                    // check if all the checkboxes for the child are 
                    // checked then check the parent checkbox also
                    classes.forEach(function(value, index) {
                        $childclass = value.replace('child-checkbox ', '');
                        check_uncheck_parent($childclass);
                    });
                }

                /**
                * It will check if all child checkboxes are checked/unchecked 
                * and as per that will check/uncheck parent 
                * 
                * @params: string childclass child element class
                * @author: Akash Uphade
                * @paradiso
                */
                function check_uncheck_parent(childclass) {
                    var unchecked = $('.' + childclass + ':checkbox:not(:checked)');
                    var parentclass = childclass.replace('child', 'parent');
                    if (unchecked.length > 0) {
                        $("input:checkbox." + parentclass).prop('checked',false);
                    } else {
                        $("input:checkbox." + parentclass).prop('checked',true);
                    }
                }

                /**
                * This function will get the saved settings if any for the role
                * 
                * @params: int role id
                * @author: Akash Uphade
                * @paradiso
                */
                function ajax_get_saved_settings(roleid) {

                    // call the web service
                    ajax.call([{
                        methodname: 'local_sitesetting_getsettings',
                        args: { roleid: roleid},
                        done: function(settings) {
                            check_saved_settings(settings);
                            toggle_save_button_status();
                        },
                        fail: notification.exception,
                    }]);

                }

                /**
                * This function will enable/disable save button 
                * 
                * @author: Akash Uphade
                * @paradiso
                */
                function toggle_save_button_status() {
                  
                    var roleid = $("#role").val();

                    // if role is selected and at least one checkbox is checked
                    // only then enable the save button
                    if (roleid > 0 && $(".child-checkbox").is(":checked")) {
                        $('#save').prop('disabled', false);    
                    } else {
                        $('#save').prop('disabled', true);    
                    }
                    
                }

                // Get the array of all collapsible divs
                var collapsibleElements = document.getElementsByClassName('collapse');
                
                // Set the data-parent so that accordion will work properly
                for (let [key, value] of Object.entries(collapsibleElements)) {
                    value.setAttribute('data-parent', '#'+value.parentNode.parentNode.id);
                }
                
                var count = 1;

                // Need to add parent-child classes also so we can make our checkboxes work
                // Get all the parent checkboxes
                var parentCheckboxes = document.getElementsByClassName('parent-checkbox');

                // Loop through all the parent and assign parent class and as well 
                // Get all the child checkboxes and assign respective child class to them
                for (let [key, parent] of Object.entries(parentCheckboxes)) {
                    
                    // Add parent class
                    parent.classList.add('parent-'+count);

                    // Get the main tab name for the setting item
                    var tab = parent.closest('div[class^="tab-pane"]').id;
                    
                    tab = tab.replace('link', '');

                    // Get all child checkboxes
                    let childCheckboxes = parent.parentNode.parentNode.parentNode.nextSibling.nextSibling.querySelectorAll('input[type="checkbox"]');

                    // Add child class
                    for (let [key, child] of Object.entries(childCheckboxes)) {
                        child.classList.add('child-'+count);
                        child.value = child.name + '--' + parent.name + '--' + tab;
                    }

                    count+= 1;

                }

                // Bind the event listner for all the checkboxes
                $('input[type=checkbox]').change(function() {
                           
                    // Get clicked element
                    var elementClass = $(this).attr('class');
                    var classArray = elementClass.split(' ');
                    var parentClassArray = classArray[1].split('-');

                    // Check if it is a parent checkbox and based on it's value 
                    // check/uncheck child checkboxes
                    if(parentClassArray[0] === 'parent' && !isNaN(parentClassArray[1])) {

                        // Form child class name
                        var childClass = classArray[1].replace('parent', 'child');
                        $("input:checkbox." + childClass).prop('checked',this.checked);

                    // Check if it is a child checkbox and if then based on child check 
                    // boxes status check/uncheck parent checkbox    
                    } else if (parentClassArray[0] === 'child' && !isNaN(parentClassArray[1])) {

                        check_uncheck_parent(classArray[1]);

                    }

                    toggle_save_button_status();
                    
                });

                // Bind the event lister for role select box
                $('#role').change(function () {
    
                    var roleid = $("#role").val(); 
                    
                    if ( roleid > 0 ) {
                        ajax_get_saved_settings(roleid);    
                    } else {
                        $('input:checkbox').prop('checked', false);
                        toggle_save_button_status();
                    }
                    
                });    
                        
            });
        }
    }
});
