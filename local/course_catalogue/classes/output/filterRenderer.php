<?php

/**
 * @package local_course_catalogue
 */

namespace local_course_catalogue\output;

class FilterRenderer
{
    public $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function render(): string
    {
        $html = '<div class="accordion">';

        foreach ($this->filters as $filterID => $filter) {
            $html .= '<div class="accordion-item">';
            $html .= '<button type="button" data-toggle="collapse" data-target="#' . $filterID . 'Filter" class="accordion-btn btn btn-link ' . ($filter['isOpen'] ? '' : 'collapsed') . '">';
            $html .= '<span>' . $filter['title'] . '</span>';
            $html .= '<i class="fa fa-chevron-up"></i>';
            $html .= '</button>';

            $html .= '<div id="' . $filterID . 'Filter" class="collapse ' . ($filter['isOpen'] ? 'show' : '') . '">';

            $html .= '<div class="accordion-content">';

            foreach ($filter['options'] as $optionIndex => $option) {
                if (isset($option['multilevel']) && $option['multilevel']) {
                    // dd($option);

                    $html .= (new FilterRenderer([
                        'subfilter_' . $filterID . '_' . $optionIndex => $option
                    ]))->render();
                } else {
                    $html .= '<div class="custom-control custom-' . $filter['type'] . '">';
                    $html .= '<input type="' . $filter['type'] . '" id="' . $filterID . '-' . $optionIndex . '" name="' . $filter['name'] . ($filter['type'] == 'checkbox' ? '[]' : '') . '" class="custom-control-input input-catalogue-filter" value="' . $option['value'] . '" ' . ($option['isSelected'] ? 'checked' : '') . '>';
                    $html .= '<label for="' . $filterID . '-' . $optionIndex . '" class="custom-control-label">' . $option['label'] . '</label>';
                    $html .= '</div>';
                }
            }

            $html .= '</div>'; // accordion-content
            $html .= '</div>'; // collapse
            $html .= '</div>'; // accordion-item
        }

        return $html . '</div>';
    }
}