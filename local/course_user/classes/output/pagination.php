<?php

/**
 * @package local_course_user
 */

namespace local_course_user\output;

use local_course_user\CatalogueController;
use moodle_url;
use renderable;
use templatable;
use renderer_base;
use stdClass;

class pagination implements renderable, templatable
{
    public CatalogueController $controller;

    public bool $simplePagination = false;

    public string $url = '';

    public array $pagination = [
        'next' => null,
        'prev' => null,
        'links' => [],
    ];

    public function __construct(CatalogueController $controller)
    {
        $this->controller = $controller;
    }

    public function simplePagination()
    {
        return $this->generateLinks(true);
    }

    public function fullPagination()
    {
        return $this->generateLinks(false);
    }

    public function generateLinks($simpleMode = false)
    {
        $this->buildUrl();

        $url = $this->url;

        $this->pagination['next'] = $this->controller->pagination['hasNext']
            ? $url . 'page=' . ($this->controller->pagination['page'] + 1)
            : null;

        $this->pagination['prev'] = $this->controller->pagination['hasPrev']
            ? $url . 'page=' . ($this->controller->pagination['page'] - 1)
            : null;

        if ($simpleMode) {
            $this->pagination['links'] = [];
        } else {
            $this->pagination['links'] = $this->paginationLinks();
        }
        return $this;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output)
    {
        return $this->fullPagination()->toObject();
    }

    public function toJson()
    {
        return json_encode($this->pagination);
    }

    public function toObject()
    {
        return (object) $this->pagination;
    }

    public function toArray()
    {
        return $this->pagination;
    }

    public function paginationLinks()
    {
        $links = [];
        // echo $this->url; die;
        if ($this->controller->pagination['pagesCount'] > 10) {
            for ($page = 1; $page <= 6; $page++) {
                $links[] = [
                    'label' => $page,
                    'url' => $this->url . 'page=' . $page,
                    'classes' => $this->controller->currentPage == $page ? 'active' : ''
                ];
            }

            if ($this->controller->currentPage == 7) {
                $links[] = [
                    'label' => '6',
                    'url' => $this->url . 'page=6',
                    'classes' => 'active'
                ];
            }

            $links[] = [
                'label' => '...',
                'url' => '#',
                'classes' => 'disabled'
            ];

            if ($this->controller->currentPage > 7 && $this->controller->pagination['pagesCount'] != $this->controller->currentPage) {
                $links[] = [
                    'label' => $this->controller->currentPage,
                    'url' => $this->url . 'page=' . $this->controller->currentPage,
                    'classes' => 'active'
                ];
                $links[] = [
                    'label' => '...',
                    'url' => '#',
                    'classes' => 'disabled'
                ];
            }

            $links[] = [
                'label' => $this->controller->pagination['pagesCount'],
                'url' => $this->url . 'page=' . $this->controller->pagination['pagesCount'],
                'classes' => $this->controller->pagination['pagesCount'] == $this->controller->currentPage ? 'active' : ''
            ];

            return $links;
        }

        for ($page = 1; $page <= $this->controller->pagination['pagesCount']; $page++) {
            $links[] = [
                'label' => $page,
                'url' => $this->url . 'page=' . $page,
                'classes' => $this->controller->currentPage == $page ? 'active' : ''
            ];
        }

        return $links;
    }

    public function buildUrl(): void
    {
        global $CFG;

        $params = $this->controller->routeParams();

        unset($params['page']);

        $base = $CFG->wwwroot . '/local/course_user/index.php';
      
        $query = http_build_query($params, '', '&');

        $this->url = $base . '?' . $query . '&';
    }
}