<?php

function generate_model($className, $table, $parentClass, $table_attributes = [])
{

    $title = ucwords(str_replace('_', ' ', $table));
    $template = '<?php

    if (!defined(\'BASEPATH\'))
        exit(\'No direct script access allowed\');
    
    require APPPATH . \'/models/_base/' . $parentClass . '.php\';
    
    class ' . $className . ' extends ' . $parentClass . '
    {
        function __construct()
        {
            parent::__construct();
        }
    
        public function add()
        {
            $edit_id = $this->input->post(\'id\');
            $this->form_validation->set_rules(parent::rules());
            if ($this->form_validation->run() == TRUE) {
                $this->id = $edit_id;' . PHP_EOL;

    foreach ($table_attributes as $column) {

        $template .= '$this->' . $column->column_name . ' = $this->input->post(\'' . $column->column_name . '\', TRUE);' . PHP_EOL;
    }

    $template .= 'if ($this->save()) {
                    user_action(\'' . $title . ' details saved.\', \'PK :\' . $this->id);                  
                    $this->response[\'message\'] = \'' . $title . ' saved successfully\';
                } else {
                    $this->response[\'message\'] = $this->error();
                }
            } else {
                $this->response[\'message\'] = validation_errors();
            }
            return $this->response;
        }
    
        /**
         * list function
         *
         * @param string $select
         * @param array $aWhere
         */
        public function list($select = \'\', $aWhere = array())
        {
            $aWhere[\'t1.company_id\'] = $this->company_id;
            $search = $this->search($select, $aWhere);
            $total_count = count($search->get()->result());
            $search = $this->search($select, $aWhere);
            return  parent::applyPagination($search, $total_count);
        }
    
        /**
         * search function
         *
         * @param [type] $select
         * @param [type] $aWhere
         */
        private function search($select, $aWhere)
        {
            if (empty($select)) {
                $select = \'t1.*\';
            }
            $this->db->select($select);
            $this->db->from(tbl_prefix() . $this->tbl_name . \' as t1\');
            ';

    $count = 1;
    foreach ($table_attributes as $column) {

        $template .= 'if (!empty($_GET[\'' . $column->column_name . '\'])) {';
        if ($count == 1) {
            $template .= '$this->db->like(\'t1.' . $column->column_name . '\', $_GET[\'' . $column->column_name . '\']);' . PHP_EOL;
        } else {
            $template .= PHP_EOL . '$this->db->or_like(\'t1.' . $column->column_name . '\', $_GET[\'' . $column->column_name . '\']);';
        }
        $template .= '}' . PHP_EOL;
        if ($count == 5) {
            break;
        }
        $count++;
    }

    $template .= ';
            if (!empty($aWhere) && is_array($aWhere)) {
                $this->db->where($aWhere);
            }
            $this->db->order_by("t1.id", \'desc\');
            return $this->db;
        }
    }
    ';
    return $template;
}
