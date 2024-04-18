<?php

/**
 * @package local_course_catalogue
 */

namespace local_course_catalogue\output;

use context_system;
use local_course_catalogue\CatalogueController;
use renderable;
use templatable;
use renderer_base;
use stdClass;

class searchbar implements renderable, templatable
{
    public CatalogueController $controller;

    public function __construct(CatalogueController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output)
    {
        $data = new stdClass();

        $data->search = $this->controller->filters['search'] ?? null;
        $data->tag = $this->controller->filters['tag'] ?? null;

        $data->morelinks = $this->getMoreLinks();
        $data->showmorelinks = count($data->morelinks) > 0;
        
        return $data;
        
    }
    
    public function getMoreLinks(): array
    {
        $links = [];

        if (has_capability('moodle/course:create', context_system::instance())) {
            $links[] = [
                'url' => new \moodle_url('/course/edit.php?category=1&returnto=topcat'),
                'text' => get_string('addnewcourse'),
            ];
        }

        if (has_capability('moodle/category:manage', context_system::instance())) {
            $links[] = [
                'url' => new \moodle_url('/course/editcategory.php?parent=0'),
                'text' => get_string('addsubcategory'),
            ];
        }

        if (has_capability('moodle/course:create', context_system::instance())) {
            $links[] = [
                'url' => new \moodle_url('/course/management.php?categoryid=0'),
                'text' => get_string('managecourses'),
            ];
        }

        return $links;
    }
}