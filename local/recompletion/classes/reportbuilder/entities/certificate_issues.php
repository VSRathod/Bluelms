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

namespace local_recompletion\reportbuilder\entities;

use core_reportbuilder\local\entities\base;
use core_reportbuilder\local\helpers\format;
use core_reportbuilder\local\report\column;
use core_renderer;
use html_writer;
use lang_string;

/**
 * Report builder entity for mod_certificate archived records.
 *
 * @package    local_recompletion
 * @author     Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class certificate_issues extends base {

    /**
     * Database tables that this entity uses and their default aliases
     *
     * @return string[] Array of $tablename => $alias
     */
    protected function get_default_table_aliases(): array {
        return [
            'local_recompletion_cert' => 'rcert'
        ];
    }

    /**
     * The default title for this entity
     *
     * @return lang_string
     */
    protected function get_default_entity_title(): lang_string {
        return new lang_string('entity:local_recompletion_cert', 'local_recompletion');
    }

    /**
     * Initialise.
     *
     * @return \core_reportbuilder\local\entities\base
     */
    public function initialise(): base {
        $columns = $this->get_all_columns();
        foreach ($columns as $column) {
            $this->add_column($column);
        }

        return $this;
    }

    /**
     * Returns list of available columns.
     *
     * @return column[]
     */
    protected function get_all_columns(): array {
        $tablealias = $this->get_table_alias('local_recompletion_cert');

        // Course module.
        $columns[] = (new column(
            'certificate',
            new lang_string('pluginname', 'certificate'),
            $this->get_entity_name()
        ))
            ->add_joins($this->get_joins())
            ->set_type(column::TYPE_INTEGER)
            ->add_fields("{$tablealias}.certificateid, {$tablealias}.course")
            ->set_is_sortable(true)
            ->add_callback(static function($value, $row): string {
                global $PAGE;

                $renderer = new core_renderer($PAGE, RENDERER_TARGET_GENERAL);
                $modinfo = get_fast_modinfo($row->course);

                if (!empty($modinfo) && !empty($modinfo->get_instances_of('certificate')
                        && !empty($modinfo->get_instances_of('certificate')[$row->certificateid]))) {
                    $cm = $modinfo->get_instances_of('certificate')[$row->certificateid];
                    $modulename = get_string('modulename', $cm->modname);
                    $activityicon = $renderer->pix_icon('monologo', $modulename, $cm->modname, ['class' => 'icon']);

                    return $activityicon . html_writer::link($cm->url, format_string($cm->name), []);
                } else {
                    return (string) $row->certificateid;
                }
            });

        $columns[] = (new column(
            'code',
            new lang_string('code', 'certificate'),
            $this->get_entity_name()
        ))
            ->add_joins($this->get_joins())
            ->set_type(column::TYPE_TEXT)
            ->add_field("{$tablealias}.code")
            ->set_is_sortable(true);

        $columns[] = (new column(
            'issueddate',
            new lang_string('issueddate', 'certificate'),
            $this->get_entity_name()
        ))
            ->add_joins($this->get_joins())
            ->set_type(column::TYPE_TIMESTAMP)
            ->add_field("{$tablealias}.timecreated")
            ->set_is_sortable(true)
            ->add_callback([format::class, 'userdate']);

        $columns[] = (new column(
            'printdate',
            new lang_string('printdate', 'certificate'),
            $this->get_entity_name()
        ))
            ->add_joins($this->get_joins())
            ->set_type(column::TYPE_TIMESTAMP)
            ->add_field("{$tablealias}.printdate")
            ->set_is_sortable(true)
            ->add_callback([format::class, 'userdate']);

        return $columns;
    }
}
