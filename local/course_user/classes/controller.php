<?php

/**
 * Courses list with filters
 *
 * @package    local_course_user
 * @author     Mohammed Saad  
 * @copyright  
 * @license    
 */

namespace local_course_user;

use moodle_url;

defined('MOODLE_INTERNAL') || die;

class CatalogueController
{
    private $db = null;
    public array $courses = [];
    public array $pagination = [
        'hasNext' => true,
        'hasPrev' => false,
        'pagesCount' => 1,
        'totalData' => 0,
    ];

    public int $currentPage = 1;

    public int $PER_PAGE = 15;

    /**
     * filters data
     */

    public array $filters = [
        'search' => null,
        'tag' => null,
        'category' => null,
        'sbu' => null,
        'department' => null,
        'ignore_ids' => null,
    ];

    public array $categoriesFilterData = [];
    public array $categoriesFilterDataOptions = [];

    /*     public array $departmentsFilterData = [];
    public array $hpclCatFilterData = [];
    public array $sbuFilterData = [
        [
            'label' => 'Aviation',
            'value' => 'aviation',
            'isSelected' => false,
        ],
        [
            'label' => 'Pipeline',
            'value' => 'pipeline',
            'isSelected' => false,
        ],
        [
            'label' => 'Retail',
            'value' => 'retail',
            'isSelected' => false,
        ],
        [
            'label' => 'LPG',
            'value' => 'lpg',
            'isSelected' => false,
        ],
        [
            'label' => 'Lubes',
            'value' => 'lubes',
            'isSelected' => false,
        ],
        [
            'label' => 'Direct Sales',
            'value' => 'direct_sales',
            'isSelected' => false,
        ],
        [
            'label' => 'Refinery',
            'value' => 'refinery',
            'isSelected' => false,
        ],
        [
            'label' => 'OD & E',
            'value' => 'od&e',
            'isSelected' => false,
        ],
        [
            'label' => 'General',
            'value' => 'general',
            'isSelected' => false,
        ],
    ];
 */
    /**
     * function alredy called
     * Preventing multiple call of functions if data is null or empty
     * 
     * Kinda cache
     */
    private array $loadedFunction = [];

    public function __construct($setup = [])
    {
        global $DB;
        $this->db = $DB;
        if (isset($setup['per_page'])) {
            $this->PER_PAGE = (int) $setup['per_page'];
        }

        $this->currentPage = optional_param('page', 1, PARAM_INT);
        $this->filters['id'] = trim(optional_param('id', '', PARAM_RAW_TRIMMED));
        $this->filters['search'] = trim(optional_param('search', '', PARAM_RAW_TRIMMED));
        $this->filters['gender'] = optional_param('gender', '', PARAM_RAW);
        $this->filters['fullname'] = optional_param('fullname', '', PARAM_RAW);
        $this->filters['email'] = optional_param('email', '', PARAM_RAW);
        $this->filters['empid'] = optional_param('empid', '', PARAM_RAW);
        $this->filters['location'] = optional_param('location', '', PARAM_RAW);
        $this->filters['department'] = optional_param('department', '', PARAM_RAW);
        $this->filters['manager'] = optional_param('manager', '', PARAM_RAW);

        $this->filters['age'] = optional_param('age', '', PARAM_RAW);
        $this->filters['agemax'] = optional_param('agemax', '', PARAM_RAW);
        $this->filters['zone'] = optional_param('zone', '', PARAM_RAW);
        $this->filters['suspended'] = optional_param('suspended', '', PARAM_RAW);

        $this->filters['category'] = optional_param('category', null, PARAM_RAW_TRIMMED);
        $this->filters['sbu'] = optional_param('sbu', null, PARAM_RAW_TRIMMED);
        $this->filters['ignore_ids'] = optional_param('ignore_ids', null, PARAM_RAW_TRIMMED);
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

    public function getUsers($course_id = 0, $filter = null)
    {
        global $USER;
        if ($this->hasBeenCalled('getUsers')) return $this->courses;
        array_push($this->loadedFunction, 'getUsers');
        $limit = $this->PER_PAGE;
        $offset = $this->currentPage > 1 ? ($this->currentPage - 1) * $this->PER_PAGE : 0;
        $filterConditions = "";
        // search button..
        if ($this->filters['search']) {
            $filterConditions .= " AND (
                 u.username like '%" . strtolower($this->filters['search']) . "%'  
                OR  u.firstname like '%" . strtolower($this->filters['search']) . "%'  
                OR  u.lastname like '%" . strtolower($this->filters['search']) . "%'  
                OR  u.email like '%" . strtolower($this->filters['search']) . "%'  
                OR  u.department like '%" . strtolower($this->filters['search']) . "%'  
                ) ";
        }

        if ($USER->modifiedroleadmin != 1) {
            $filterConditions .= " AND u.id in(select userid from mdl_user_info_data WHERE fieldid = 1  AND data = '$USER->username') ";
        }

        if ($this->filters['fullname']) {
            $filterConditions .= " AND  
                concat(u.firstname, ' ', u.lastname) like '%" . strtolower($this->filters['fullname']) . "%'  
                ";
        }
        if ($this->filters['email']) {
            $filterConditions .= " AND  
                u.email like '%" . strtolower($this->filters['email']) . "%'  
                ";
        }

        if ($this->filters['empid']) {
            $empid = $this->filters['empid'];
            $managerQuery = "SELECT {user_info_data}.userid FROM {user_info_data} WHERE fieldid IN(
                SELECT id FROM {user_info_field} WHERE shortname = 'empid') AND mdl_user_info_data.data = '$empid'";
            $filterConditions .= " AND u.id IN($managerQuery)";
        }

        if ($this->filters['location']) {
            $filterConditions .= " AND  
                u.city like '%" . strtolower($this->filters['location']) . "%'  
                ";
        }
        if ($this->filters['department']) {
            $filterConditions .= " AND  
                u.department like '%" . strtolower($this->filters['department']) . "%'  
                ";
        }
        $genderqueryString = "";
        if ($this->filters['gender']) {
            $genArr = array_values($this->filters['gender']);
            $genderqueryString .= "";
            foreach ($genArr as $gen) {
                $genderqueryString .= "'$gen',";
            }
            $genderqueryString = substr($genderqueryString, 0, -1);     // remove last comma  
            if ($genderqueryString) {
                $genderQuery = "SELECT {user_info_data}.userid FROM {user_info_data} WHERE fieldid IN(
                    SELECT id FROM {user_info_field} WHERE shortname = 'gender' AND data iN($genderqueryString)
                )";
                $filterConditions .= " AND u.id IN($genderQuery)";
            }
        }

        if ($this->filters['manager']) {
            $managerdata = $this->filters['manager'];
            $managerQuery = "SELECT {user_info_data}.userid FROM {user_info_data} WHERE fieldid IN(
                SELECT id FROM {user_info_field} WHERE shortname = 'manager') AND mdl_user_info_data.data = '$managerdata'";
            $filterConditions .= " AND u.id IN($managerQuery)";
        }


        if ($this->filters['age']) {
            $agedata = $this->filters['age'];
            $ageQuery = "SELECT {user_info_data}.userid FROM {user_info_data} WHERE fieldid IN(
                SELECT id FROM {user_info_field} WHERE shortname = 'dob') AND TIMESTAMPDIFF(year, FROM_UNIXTIME({user_info_data}.data), CURDATE()) >= '$agedata'";
            $filterConditions .= " AND u.id IN($ageQuery)";
        }

        if ($this->filters['agemax']) {
            $agedataFrom1 = $this->filters['agemax'];
            $ageQuery = "SELECT {user_info_data}.userid FROM {user_info_data} WHERE fieldid IN(
                SELECT id FROM {user_info_field} WHERE shortname = 'dob') AND TIMESTAMPDIFF(year, FROM_UNIXTIME({user_info_data}.data), CURDATE()) < '$agedataFrom1'";
            $filterConditions .= " AND u.id IN($ageQuery)";
        }


        // if ($this->filters['zone']) {
        //     $zonedata = $this->filters['zone'];
        //     $ageQuery = "SELECT {user_info_data}.userid FROM {user_info_data} WHERE fieldid IN(
        //         SELECT id FROM {user_info_field} WHERE shortname = 'zone') AND {user_info_data}.data like '%$zonedata%'";;
        //     $filterConditions .= " AND u.id IN($ageQuery)";
        // }

        if ($this->filters['suspended']) {


            $susdata = ($this->filters['suspended'] == "yes") ? "1" : "0";

            $susQuery = "u.suspended= $susdata";;
            $filterConditions .= "  AND ($susQuery)";
        }




        $selectfileds = "SELECT u.id, u.username, u.email, u.firstname, u.lastname, u.department, r.roleid, r1.shortname, u.auth";
        $coursesSql = " $selectfileds
        FROM {user} u LEFT join {role_assignments} r ON r.userid = u.id
        LEFT JOIN {role} r1 ON r.roleid = r1.id
        WHERE u.deleted=0  $filterConditions group by u.id";
        $coursesSql .= ' ORDER BY u.firstname ASC';

        $coursesSql1 = "select count(*) as total from (" . $coursesSql . ") t";
        $pagesCountArr =  $this->db->get_record_sql($coursesSql1);
        $coursesSql .= " LIMIT {$limit}" . ($offset ? " OFFSET {$offset};" : ';');

        $this->courses = array_values($this->db->get_records_sql($coursesSql));
        $pagesCount = 0;
        if ($pagesCountArr) {
            $pagesCount =  $pagesCountArr->total;
        }
        $this->pagination['totalData'] = $pagesCountArr->total ?: 1;
        $this->pagination['pagesCount'] = ceil($pagesCount / $this->PER_PAGE) ?: 1;
        $this->pagination['hasNext'] = $this->pagination['pagesCount'] > $this->currentPage;
        $this->pagination['hasPrev'] = $this->currentPage > 1;
        $this->pagination['page'] = $this->currentPage;
        return $this->courses;
    }

    public function getFilters()
    {
        $filter = [];

        $filter['fullname'] = [
            'title' => 'Fullname',
            'isOpen' => $this->isFilled($this->filters['fullname']),
            'type' => 'text',
            'name' => 'fullname',
            'value' => $this->filters['fullname']
        ];


        $filter['email'] = [
            'title' => 'Email ID',
            'isOpen' => $this->isFilled($this->filters['email']),
            'type' => 'text',
            'name' => 'email',
            'value' => $this->filters['email']
        ];


        $filter['empid'] = [
            'title' => 'Employee ID',
            'isOpen' => $this->isFilled($this->filters['empid']),
            'type' => 'text',
            'name' => 'empid',
            'value' => $this->filters['empid']
        ];



        $filter['location'] = [
            'title' => 'Location (city)',
            'isOpen' => $this->isFilled($this->filters['location']),
            'type' => 'text',
            'name' => 'location',
            'value' => $this->filters['location']
        ];


        $filter['department'] = [
            'title' => 'Department',
            'isOpen' => $this->isFilled($this->filters['department']),
            'type' => 'text',
            'name' => 'department',
            'value' => $this->filters['department']
        ];


        $filter['gender'] = [
            'title' => 'Gender',
            'isOpen' => $this->isFilled($this->filters['gender']),
            'type' => 'checkbox',
            'name' => 'gender',
            'options' => [
                [
                    'label' => 'Male',
                    'value' => 'Male',
                    'isSelected' => $this->isSelected('gender', 'Male'),
                ],
                [
                    'label' => 'Female',
                    'value' => 'Female',
                    'isSelected' => $this->isSelected('gender', 'Female'),
                ],
                [
                    'label' => 'Other',
                    'value' => 'Other',
                    'isSelected' => $this->isSelected('gender', 'Other'),
                ],
            ],
        ];

        $filter['manager'] = [
            'title' => 'Manager',
            'isOpen' => $this->isFilled($this->filters['manager']),
            'type' => 'text',
            'name' => 'manager',
            'value' => $this->filters['manager']
        ];

        $filter['age'] = [
            'title' => 'Age (Min)',
            'isOpen' => $this->isFilled($this->filters['age']),
            'type' => 'text',
            'name' => 'age',
            'value' => $this->filters['age']
        ];

        $filter['agemax'] = [
            'title' => 'Age (MAX)',
            'isOpen' => $this->isFilled($this->filters['agemax']),
            'type' => 'text',
            'name' => 'agemax',
            'value' => $this->filters['agemax']
        ];

        /* $filter['zone'] = [
            'title' => 'Zone',
            'isOpen' => $this->isFilled($this->filters['zone']),
            'type' => 'text',
            'name' => 'zone',
            'value' => $this->filters['zone']
        ]; */
        $filter['suspended'] = [
            'title' => 'Suspended',
            'isOpen' => $this->isFilled($this->filters['suspended']),
            'type' => 'radio',
            'name' => 'suspended',
            'options' => [
                [
                    'label' => 'Yes',
                    'value' => 'yes',
                    'isSelected' => $this->filters['suspended'] === 'yes'
                ],
                [
                    'label' => 'No',
                    'value' => 'no',
                    'isSelected' => $this->filters['suspended'] === 'no'
                ]
            ]
        ];

        return $filter;
    }

   /*  public function getHpclCatFilterData($optionsFormat = true)
    {
        if (!$this->hasBeenCalled('getHpclCatFilterData')) {
            array_push($this->loadedFunction, 'getHpclCatFilterData');

            $this->hpclCatFilterData = $this->db->get_records_sql('select * from {hpcl_coursehours_categories} LIMIT 100');

            if (!$optionsFormat) return $this->hpclCatFilterData;
        }
        $options = [];
        foreach ($this->hpclCatFilterData as $hpclCat) {
            $options[] = [
                'label' => $hpclCat->hpclcategory,
                'value' => $hpclCat->hpclcategory,
                'isSelected' => $this->isSelected('hpcl_category', $hpclCat->hpclcategory),
            ];
        }
        return $options;
    } */

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

    public function updateuser($userid = null, $delete = 1)
    {
        global $USER, $SESSION;

        if (is_array($userid)) {
            $userids = implode(',', $userid);
        } else {
            $userids = $userid;
        }
        //auth type ldap user will not be deleted..
        if ($delete == 1) {
            $updatesql = "update {user} set deleted = 1 where id IN( $userids ) AND auth!='ldap'";
            $this->db->execute($updatesql);
            return 1;
        }
    }
    #endregion helpers
}
