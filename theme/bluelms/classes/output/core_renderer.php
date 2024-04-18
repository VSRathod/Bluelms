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



namespace theme_bluelms\output;

use block_contents;
use context_course;
use custom_menu;
use custom_menu_item;
use html_writer;
use moodle_url;
use navigation_node;
use stdClass;

define('PROTENANT_COURSE_STARRED', 'starred');
define('PROTENANT_COURSE_IN_PROGRESS', 'inprogress');
define('PROTENANT_COURSE_PAST', 'past');
define('PROTENANT_COURSE_FUTURE', 'future');
define('PROTENANT_COURSE_HIDDEN', 'hidden');

/**
 * Trait for core and core maintenance renderers.
 *
 * @copyright 2015 Jeremy Hopkins (Coventry University)
 * @copyright 2015 Fernando Acedo (3-bits.com)
 * @copyright 2021 Gareth J Barnard
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * Core renderer for  theme
 */
trait core_renderer_toolbox {
    /** @var custom_menu_item language The language menu if created */
    protected $language = null;

    /**
     * Returns HTML attributes to use within the body tag. This includes an ID and classes.
     *
     * @since Moodle 2.5.1 2.6
     * @param string|array $additionalclasses Any additional classes to give the body tag,
     * @return string
     */
    
    /**
     * Returns language menu
     *
     * @param bool $showtext
     *
     * @return string
     */
    public function lang_menu($showtext = true) {
        global $CFG;
        $langmenu = new custom_menu();

        $addlangmenu = true;
        $langs = get_string_manager()->get_list_of_translations();
        if (count($langs) < 2 || empty($CFG->langmenu) || ($this->page->course != SITEID && !empty($this->page->course->lang))) {
            $addlangmenu = false;
        }

        if ($addlangmenu) {
            $strlang = get_string('language');
            $currentlang = current_language();

            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $strlang;
            }

            if ($showtext != true) {
                $currentlang = '';
            }

            $this->language = $langmenu->add('<i class="icon fa fa-globe fa-lg"></i><span class="langdesc">'.$currentlang.'</span>',
                new moodle_url($this->page->url), $strlang, 10000);

            foreach ($langs as $langtype => $langname) {
                $this->language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }
        }
        return $this->render_custom_menu($langmenu, '', '', 'langmenu');
    }

    /**
     * Display custom menu in the format required for the nav drawer. Slight cludge here to make this work.
     * The calling function can't call the default custom_menu() method as there is no way to know to
     * render custom menu items in the format required for the drawer (which is different from displaying on the normal navbar).
     *
     * @return Custom menu html
     */
    public function custom_menu_drawer() {
        global $CFG;

        if (!empty($CFG->custommenuitems)) {
            $custommenuitems = $CFG->custommenuitems;
        } else {
            return '';
        }

        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu, '', '', 'custom-menu-drawer');
    }

    /**
     * This renders the bootstrap top menu.
     * This renderer is needed to enable the Bootstrap style navigation.
     *
     * @param custom_menu $menu
     * @param string $wrappre
     * @param string $wrappost
     * @param string $menuid
     *
     * @return string
     */
    protected function render_custom_menu(custom_menu $menu, $wrappre = '', $wrappost = '', $menuid = '') {
        if (!$menu->has_children()) {
            return '';
        }

        $content = '';
        foreach ($menu->get_children() as $item) {
            if (stristr($menuid, 'drawer')) {
                $content .= $this->render_custom_menu_item_drawer($item, 0, $menuid, false);
            } else {
                $content .= $this->render_custom_menu_item($item, 0, $menuid);
            }
        }
        $content = $wrappre . $content . $wrappost;
        return $content;
    }

    /**
     * This code renders the custom menu items for the bootstrap dropdown menu.
     *
     * @param custom_menu_item $menunode
     * @param int $level = 0
     * @param int $menuid
     *
     * @return string
     */
    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0, $menuid = '') {
        static $submenucount = 0;

        // If the node has a url, then use it, even if it has children as the URL could be that of an overview page.
        if ($menunode->get_url() !== null) {
            $url = $menunode->get_url();
        } else {
            $url = '#';
        }
        if ($menunode->has_children()) {
            $content = '<ul class="protenant-flatnavigation protenant-flatnavigation-box ">';
            $content .= '<li class="nav-item dropdown my-auto">';
            $content .= html_writer::start_tag('a', array('href' => $url,
                'class' => 'nav-link dropdown-toggle my-auto', 'role' => 'button',
                'id' => $menuid . $submenucount,
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false',
                'aria-controls' => 'dropdown' . $menuid . $submenucount,
                'data-target' => $url,
                'data-toggle' => 'dropdown',
                'title' => $menunode->get_title())
            );
            $content .= $menunode->get_text();
            $content .= '</a>';
            $content .= '<ul role="menu" class="dropdown-menu" id="dropdown' . $menuid . $submenucount . '" aria-labelledby="'
                .$menuid . $submenucount . '">';

            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 1, $menuid . $submenucount);
            }
            $content .= '</ul></li>';
        } else {
            if (preg_match("/^#+$/", $menunode->get_text())) {
                // This is a divider.
                $content = html_writer::start_tag('li', array('class' => 'dropdown-divider'));
            } else {
                if ($level == 0) {
                    $content = '<li class="nav-item">';
                    $linkclass = 'nav-link';
                } else {
                    $content = '<li>';
                    $linkclass = 'dropdown-item';
                }

                /* This is a bit of a cludge, but allows us to pass url, of type moodle_url with a param of
                 * "helptarget", which when equal to "_blank", will create a link with target="_blank" to allow the link to open
                 * in a new window.  This param is removed once checked.
                 */
                $attributes = array(
                    'title' => $menunode->get_title(),
                    'class' => $linkclass
                );
                if (is_object($url) && (get_class($url) == 'moodle_url')) {
                    $helptarget = $url->get_param('helptarget');
                    if ($helptarget != null) {
                        $url->remove_params('helptarget');
                        $attributes['target'] = $helptarget;
                    }
                }
                $content .= html_writer::link($url, $menunode->get_text(), $attributes);

                $content .= "</li>";
            }
        }
        return $content;
    }

    /**
     * This code renders the custom menu items for the bootstrap dropdown menu.
     *
     * @param custom_menu_item $menunode
     * @param int $level = 0
     * @param int $menuid
     * @param bool $indent
     *
     * @return string
     */
    protected function render_custom_menu_item_drawer(custom_menu_item $menunode, $level = 0, $menuid = '', $indent = false) {
        static $submenucount = 0;

        if ($menunode->has_children()) {
            $submenucount++;
            $content = '<ul class="protenant-flatnavigation protenant-flatnavigation-box ">';
            $content .= '<li class="m-l-0">';
            $content .= html_writer::start_tag('a', array('href' => '#' . $menuid . $submenucount,
                'class' => 'list-group-item dropdown-toggle',
                'aria-haspopup' => 'true', 'data-target' => '#', 'data-toggle' => 'collapse',
                'title' => $menunode->get_title()));
            $content .= $menunode->get_text();
            $content .= '</a>';

            $content .= '<ul class="collapse" id="'.$menuid . $submenucount . '">';
            $indent = true;
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item_drawer($menunode, 1, $menuid . $submenucount, $indent);
            }
            $content .= '</ul></li></ul>';
        } else {
            // The node doesn't have children so produce a final menuitem.
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#';
            }

            if ($indent) {
                $dataindent = 1;
                $marginclass = 'protenant-sidebar-nav-item';
            } else {
                $dataindent = 0;
                $marginclass = 'protenant-sidebar-nav-item';
            }
            $content = '<ul class="protenant-flatnavigation protenant-flatnavigation-box ">';
            $content .= '<li class="'.$marginclass.'">';
            $content .= '<a class="protenant-sidebar-nav-item-link" href="'.$url.'" ';
            $content .= 'data-key="" data-isexpandable="0" data-indent="'.$dataindent;
            $content .= '" data-showdivider="0" data-type="1" data-nodetype="1"';
            $content .= 'data-collapse="0" data-forceopen="1" data-isactive="1" data-hidden="0" ';
            $content .= 'data-preceedwithhr="0" data-parent-key="'.$menuid.'">';
            $content .= '<span class="protenant-sidebar-nav-icon">';
            $content .= "<i class='icon fa-regular fa-bell'></i>";
            $content .= '</span>';
            $content .= '<span class="protenant-sidebar-nav-text">';
            $content .= $menunode->get_text();
            $content .= '</div></a></li></ul>';

        }
        return $content;
    }
}