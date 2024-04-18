<?php

/**
 * Courses list with filters
 *
 * @package    local_course_catalogue
 * @author     Mohammed Saad  
 * @copyright  
 * @license    
 */

namespace local_course_catalogue;

use moodle_url;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/theme/boost/lib.php');

class CatalogueController
{
    private $db = null;

    public array $courses = [];
    public array $pagination = [
        'hasNext' => true,
        'hasPrev' => false,
        'pagesCount' => 1,
    ];
    public int $currentPage = 1;
    private int $PER_PAGE = 12;
    public array $filters = [
        'search' => null,
        'tag' => null,
        'category' => null,
        'ignore_ids' => null,
        'only_ids' => null,
        'sort' => null,
    ];
    public array $categoriesFilterData = [];
    public array $categoriesFilterDataOptions = [];
    private array $loadedFunction = [];

    public function __construct($setup = [])
    {
        global $DB;

        $this->db = $DB;

        if (isset($setup['per_page'])) {
            $this->PER_PAGE = (int) $setup['per_page'];
        }

        if (isset($setup['filters'])) {
            $defaultFilters = array_merge($this->filters, $setup['filters']);
        }

        $this->currentPage = optional_param('page', 1, PARAM_INT);
        $this->filters['search'] = trim(optional_param('search', '', PARAM_RAW_TRIMMED));
        $this->filters['tag'] = trim(optional_param('tag', null, PARAM_RAW_TRIMMED));
        $this->filters['tag'] = $this->filters['search'];
        $this->filters['category'] = optional_param('category', null, PARAM_RAW_TRIMMED) ?? $defaultFilters['category'];
        $this->filters['ignore_ids'] = optional_param('ignore_ids', null, PARAM_RAW_TRIMMED) ?? $defaultFilters['ignore_ids'];
        $this->filters['only_ids'] = optional_param('only_ids', null, PARAM_RAW_TRIMMED) ?? $defaultFilters['only_ids'];
        $this->filters['sort'] = optional_param('sort', null, PARAM_RAW_TRIMMED) ?? $defaultFilters['sort'];
    }

    public function routeParams(): array
    {
        $filters = array_merge($this->filters, [
            'page' => $this->currentPage,
        ]);
        return array_filter($filters, function ($value) {
            return $this->isFilled($value);
        });
    }

    public function getCourses()
    {
        global $CFG;

        if ($this->hasBeenCalled('getCourses')) return $this->courses;
        array_push($this->loadedFunction, 'getCourses');
        $sort = $this->filters['sort'];
        $sql = "SELECT * FROM {courses}";

        $filterConditions = '';
        $filterConditionApplied = false;

        // if (isset($CFG->show_courses_with_course_hourse_only) && !empty($CFG->show_courses_with_course_hourse_only)) {
        //     $filterConditionApplied = $CFG->show_courses_with_course_hourse_only;
        // }

        $dbParams = [];
        $sql = 'SELECT %s';
        $sql .= ' FROM {course} c';
        $sql .= ' INNER JOIN {course_categories} cat ON cat.id = c.category ';
        $sql .= " LEFT JOIN {customfield_data} cd ON cd.instanceid = c.id ";
        $orderBy = ' ORDER BY c.sortorder DESC';

        if ($this->isFilled($this->filters['only_ids'])) {
            $sql .= ' WHERE c.visible = 1 ';

            if (!is_array($this->filters['only_ids'])) $this->filters['only_ids'] = [$this->filters['only_ids']];

            $sql .= ' AND c.id IN (';

            foreach ($this->filters['only_ids'] as $key => $value) {
                $sql .= ":only_ids_{$key},";
                $dbParams["only_ids_{$key}"] = $value;
            }

            $sql = substr($sql, 0, -1);
        }

        $applyFilterCondition = function ($filterKey, $dbField = null, $table = 'ch') use (&$filterConditions, &$filterConditionApplied, &$dbParams) {
            $filter = $this->filters[$filterKey];

            if (is_null($dbField)) $dbField = $filterKey;

            if (!is_array($filter)) $filter = [$filter];

            $filterConditions .= " AND {$table}.$dbField IN (";

            foreach ($filter as $key => $value) {
                $filterConditions .= ":{$filterKey}_{$key},";
                $dbParams["{$filterKey}_{$key}"] = $value;
            }

            $filterConditions = substr($filterConditions, 0, -1);
            $filterConditions .= ')';

            if ($filterKey != 'category') {
                $filterConditionApplied = true;
            }
        };

        if ($this->isFilled($this->filters['category'])) {
            $applyFilterCondition('category', 'category', 'c');
        }
        
        if ($this->isFilled($this->filters['sort'])) {
            if ($this->filters['sort'] == 'latest') {
                $orderBy = ' ORDER BY c.timemodified DESC';
            } elseif ($this->filters['sort'] == 'oldest') {
                $orderBy = ' ORDER BY c.timecreated ASC';
            } elseif ($this->filters['sort'] == 'name') {
                $orderBy = ' ORDER BY c.fullname ASC';
            } elseif ($this->filters['sort'] == 'name_desc') {
                $orderBy = ' ORDER BY c.fullname DESC';
            } elseif ($this->filters['sort'] == 'enrolled') {
                $sql .= " LEFT JOIN {enrol} e ON e.courseid = c.id ";
                $orderBy = " ORDER BY COUNT(e.id) DESC, c.sortorder DESC";
            } elseif ($this->filters['sort'] == 'rating') {
               
                $orderBy = " ORDER BY rating DESC, c.sortorder ASC";
            }             
           
        }
        
        
        

       // Join tag table if tag filter is applied
if ($this->isFilled($this->filters['tag'])) {
    $sql .= ' LEFT JOIN {tag_instance} ti ON (ti.itemid = c.id AND ti.itemtype = "course")';
    $sql .= ' INNER JOIN {tag} t ON t.id = ti.tagid';
}

// Add WHERE condition
$sql .= ' WHERE c.visible = 1';
       
        // if both search and tag filter is applied
        // then group where condition and apply OR condition
        if ($this->isFilled($this->filters['search']) && $this->isFilled($this->filters['tag'])) {
           
            $sql .= ' AND (LOWER(c.fullname) LIKE :search0 OR LOWER(c.shortname) LIKE :search1 OR LOWER(cat.name) LIKE :search2 OR LOWER(t.name) LIKE :tag)';

            $searchDbParam = '%' . strtolower($this->filters['search']) . '%';

            $dbParams['search0'] = $searchDbParam;
            $dbParams['search1'] = $searchDbParam;
            $dbParams['search2'] = $searchDbParam;

            $dbParams['tag'] = '%' . strtolower($this->filters['tag']) . '%';
          
        }
        // either search or tag filter is applied
        // apply both separately
        else {
            if ($this->isFilled($this->filters['search'])) {
                $sql .= ' AND (LOWER(c.fullname) LIKE :search0 OR LOWER(c.shortname) LIKE :search1 OR LOWER(cat.name) LIKE :search2)';

                $searchDbParam = '%' . strtolower($this->filters['search']) . '%';

                $dbParams['search0'] = $searchDbParam;
                $dbParams['search1'] = $searchDbParam;
                $dbParams['search2'] = $searchDbParam;
            }

            if ($this->isFilled($this->filters['tag'])) {
                $sql .= ' AND LOWER(t.name) LIKE :tag';
                $dbParams['tag'] = '%' . strtolower($this->filters['tag']) . '%';
            }
        }
        
        // ignore_ids filter
        if ($this->isFilled($this->filters['ignore_ids'])) {

            if (!is_array($this->filters['ignore_ids'])) $this->filters['ignore_ids'] = [$this->filters['ignore_ids']];

            $sql .= ' AND c.id NOT IN (';

            foreach ($this->filters['ignore_ids'] as $key => $value) {
                $sql .= ":ignore_ids_{$key},";
                $dbParams["ignore_ids_{$key}"] = $value;
            }

            // remove last comma
            $sql = substr($sql, 0, -1);

            $sql .= ')';
        }

        $sql .= $filterConditions;

        
        // === SQL END === //

        $limit = $this->PER_PAGE;
        $offset = $this->currentPage > 1 ? ($this->currentPage - 1) * $this->PER_PAGE : 0;

        $coursesSql = sprintf($sql, 'c.*, cat.name as category_name, REGEXP_REPLACE(cd.value, "<[^>]*>", "") as rating');

        // sprintf showing error when LIKE is used in SQL
        // we will  use str_replace to replace %s with $coursesSql  
        $coursesSql = str_replace('%s', 'c.*, cat.name as category_name, REGEXP_REPLACE(cd.value, "<[^>]*>", "") as rating', $sql);

        $coursesSql .= ' GROUP BY c.id ';
        $coursesSql .= $orderBy;

        $coursesSql .= " LIMIT {$limit}" . ($offset ? " OFFSET {$offset};" : ';');
       
        // print_r([$coursesSql, $dbParams]);
        // exit();

        // dd([$coursesSql, $dbParams]);
        
        $this->courses = $this->db->get_records_sql($coursesSql, $dbParams);

        // dd($this->courses);
        
       
        // get pagination links
        $pagesCount = (int) $this->db->get_record_sql(str_replace('%s', 'COUNT(*) as total', $sql), $dbParams)->total ?: 1;

        $this->pagination['pagesCount'] = ceil($pagesCount / $this->PER_PAGE) ?: 1;
        $this->pagination['hasNext'] = $this->pagination['pagesCount'] > $this->currentPage;
        $this->pagination['hasPrev'] = $this->currentPage > 1;

        return $this->courses;
    }

    public function getFilters()
    {
        $filter = [];

        // sort
        $filter['sort'] = [
            'title' => 'Sort by',
            'isOpen' => true,
            'type' => 'radio',
            'name' => 'sort',
            'options' => [
                [
                    'label' => 'Relevance',
                    'value' => 'relevance',
                    'isSelected' => $this->isSelected('sort', 'relevance'),
                ],
                [
                    'label' => 'Latest',
                    'value' => 'latest',
                    'isSelected' => $this->isSelected('sort', 'latest'),
                ],
                [
                    'label' => 'Course rating',
                    'value' => 'rating',
                    'isSelected' => $this->isSelected('sort', 'rating'),
                ],
                [
                    'label' => 'Most enrolled',
                    'value' => 'enrolled',
                    'isSelected' => $this->isSelected('sort', 'enrolled'),
                ],
                
            ],
        ];

        // Duration
        // $filter['duration'] = [
        //     'title' => 'Duration',
        //     'isOpen' => $this->isFilled($this->filters['duration']),
        //     'type' => 'radio',
        //     // 'name' => 'duration',
        //     'options' => [
        //         [
        //             'label' => 'All durations',
        //             'value' => 0,
        //             'isSelected' => !$this->isFilled($this->filters['duration']),
        //         ],
        //         [
        //             'label' => 'Less than 1 hour',
        //             'value' => 'lt-1',
        //             'isSelected' => $this->isSelected('duration', 'lt-1'),
        //         ],
        //         [
        //             'label' => 'Up to 4 hours',
        //             'value' => '0-4',
        //             'isSelected' => $this->isSelected('duration', '0-4'),
        //         ],
        //         [
        //             'label' => '4 to 8 hours',
        //             'value' => '4-8',
        //             'isSelected' => $this->isSelected('duration', '4-8'),
        //         ],
        //         [
        //             'label' => 'More than 8 hours',
        //             'value' => 'gt-8',
        //             'isSelected' => $this->isSelected('duration', 'gt-8'),
        //         ],
        //     ],
        // ];

        // mandatory
        // $filter['mandatory'] = [
        //     'title' => 'Mandatory',
        //     'isOpen' => $this->isFilled($this->filters['mandatory']),
        //     'type' => 'checkbox',
        //     'name' => 'mandatory',
        //     'options' => [
        //         [
        //             'label' => 'Mandatory',
        //             'value' => 'Mandatory',
        //             'isSelected' => $this->isSelected('mandatory', 'Mandatory'),
        //         ],
        //         // [
        //         //     'label' => 'No, Not Mandatory',
        //         //     'value' => 'Optional',
        //         //     'isSelected' => $this->isSelected('mandatory', 'Optional'),
        //         // ],
        //     ],
        // ];

        // categories
        $filter['category'] = [
            'title' => 'Category',
            'isOpen' => $this->isFilled($this->filters['category']),
            'type' => 'checkbox',
            'name' => 'category',
            'options' => $this->getCategoriesFilterData(),
        ];

        // sbu
        // $filter['sbu'] = [
        //     'title' => 'SBU',
        //     'isOpen' => $this->isFilled($this->filters['sbu']),
        //     'type' => 'checkbox',
        //     'name' => 'sbu',
        //     'options' => [],
        // ];

        // foreach (get_hpcl_property('course_sbus') as $sbuID => $sbu) {
        //     array_push($filter['sbu']['options'], [
        //         'label' => $sbu,
        //         'value' => $sbuID,
        //         'isSelected' => $this->isSelected('sbu', $sbuID),
        //     ]);
        // }

        // learning_type
        // $filter['learning_type'] = [
        //     'title' => 'Type of content',
        //     'isOpen' => $this->isFilled($this->filters['learning_type']),
        //     'type' => 'checkbox',
        //     'name' => 'learning_type',
        //     'options' => [],
        // ];

        // foreach ($this->db->get_records_sql('SELECT DISTINCT learnigtype FROM {hpcl_coursehours}') as $lt) {
        //     if (!$lt->learnigtype || !isset(get_hpcl_property('course_learning_types')[$lt->learnigtype])) continue;

        //     array_push($filter['learning_type']['options'], [
        //         'label' => get_hpcl_property('course_learning_types')[$lt->learnigtype],
        //         'value' => $lt->learnigtype,
        //         'isSelected' => $this->isSelected('learning_type', $lt->learnigtype),
        //     ]);
        // }

        return $filter;
    }

    // public function getHpclCatFilterData($optionsFormat = true)
    // {
    //     if (!$this->hasBeenCalled('getHpclCatFilterData')) {
    //         array_push($this->loadedFunction, 'getHpclCatFilterData');

    //         $this->hpclCatFilterData = $this->db->get_records_sql('select * from {hpcl_coursehours_categories} LIMIT 100');

    //         if (!$optionsFormat) return $this->hpclCatFilterData;
    //     }

    //     $options = [];

    //     foreach ($this->hpclCatFilterData as $hpclCat) {
    //         $options[] = [
    //             'label' => $hpclCat->hpclcategory,
    //             'value' => $hpclCat->hpclcategory,
    //             'isSelected' => $this->isSelected('hpcl_category', $hpclCat->hpclcategory),
    //         ];
    //     }

    //     return $options;
    // }

    public function getCategoriesFilterData($optionsFormat = true)
    {
        if (!$this->hasBeenCalled('getCategoriesFilterData')) {
            array_push($this->loadedFunction, 'getCategoriesFilterData');

            $this->categoriesFilterData = $this->db->get_records_sql('select * from {course_categories} ORDER BY sortorder ASC LIMIT 100');

            if (!$optionsFormat) return $this->categoriesFilterData;

            if ($optionsFormat && count($this->categoriesFilterData) > 0 && count($this->categoriesFilterDataOptions) > 0)
                return $this->categoriesFilterDataOptions;
        }

        $this->categoriesFilterDataOptions = [];

        $parentCategories = array_filter($this->categoriesFilterData, function ($cat) {
            return $cat->parent == 0;
        });

        foreach ($parentCategories as $category) {
            $this->categoriesFilterDataOptions[$category->id] = [];

            // check if there are sub categories
            $subCategories = array_filter($this->categoriesFilterData, function ($cat) use ($category) {
                return $cat->parent == $category->id;
            });

            if (count($subCategories) > 0) {
                $this->categoriesFilterDataOptions[$category->id]['title'] = $category->name;
                $this->categoriesFilterDataOptions[$category->id]['type'] = 'checkbox';
                $this->categoriesFilterDataOptions[$category->id]['name'] = 'category';

                $this->categoriesFilterDataOptions[$category->id]['multilevel'] = true;
                $this->categoriesFilterDataOptions[$category->id]['isOpen'] = $this->isSelected('category', $category->id);
                $this->categoriesFilterDataOptions[$category->id]['options'] = [];

                // add self as option
                $this->categoriesFilterDataOptions[$category->id]['options'][$category->id] = [
                    'label' => $category->name,
                    'value' => $category->id,
                    'isSelected' => $this->isSelected('category', $category->id),
                ];

                foreach ($subCategories as $subCategory) {
                    $isSelected = $this->isSelected('category', $subCategory->id);

                    $this->categoriesFilterDataOptions[$category->id]['options'][$subCategory->id] = [
                        'label' => $subCategory->name,
                        'value' => $subCategory->id,
                        'isSelected' => $isSelected,
                    ];

                    // if any of the sub categories is selected, then the parent category should be open
                    if ($isSelected) {
                        $this->categoriesFilterDataOptions[$category->id]['isOpen'] = true;
                    }
                }
            } else {
                $this->categoriesFilterDataOptions[$category->id] = [
                    'label' => $category->name,
                    'value' => $category->id,
                    'isSelected' => $this->isSelected('category', $category->id),
                ];
            }
        }

        return $this->categoriesFilterDataOptions;
        
    }
   

    // public function getMySbus()
    // {
    //     global $USER;

    //     $data = $this->db->get_records_sql("
    //             SELECT DISTINCT hm.sbu_name
    //             FROM mdl_hpcl_capb_emp_master em
    //             JOIN hp_properties_map hm ON hm.sbu = em.sbucd
    //             WHERE em.emp_no = ?
    //             ", [$USER->username]);

    //     if (!$data || count($data) == 0) return [];

    //     $rename = [
    //         'Retail SBU' => 'Retail',
    //         'O&D' => 'OD&E',
    //         'Projects and Pipelines' => 'Pipeline',
    //         'Mumbai Refinery' => 'Refinery',
    //     ];

    //     $data = array_keys($data);

    //     foreach ($data as $key => $value) {
    //         if (array_key_exists($value, $rename)) {
    //             $data[$key] = $rename[$value];
    //         }
    //     }

    //     return $data;
    // }

    #region helpers

    /**
     * check if function has been called
     * to prevent multiple calls if variable is null or empty
     *
     * @param string $functionName
     * @return boolean
     */
    private function hasBeenCalled(string $functionName): bool
    {
        return in_array($functionName, $this->loadedFunction);
    }

    /**
     * Check if there is a value
     *
     * @param [type] $data
     * @return boolean
     */
    private function isFilled($data = null): bool
    {
        if (is_array($data)) return count($data) > 0;

        return $data && !empty($data) && trim($data) != '';
    }

    public function isSelected($filterName, $value): bool
    {
        if (!isset($this->filters[$filterName])) return false;

        if (!$this->isFilled($this->filters[$filterName])) return false;

        if (is_array($this->filters[$filterName])) {
            return in_array($value, $this->filters[$filterName]);
        }

        return $this->filters[$filterName] == $value;
    }

    
    #endregion helpers
}

