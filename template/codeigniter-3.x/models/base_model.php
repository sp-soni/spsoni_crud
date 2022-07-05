<?php

function generate_base_model($className, $columns, $table, $table_attributes)
{
    //debug($table_attributes);

    //custructor
    $properties = "";
    foreach ($columns as $column) {
        $properties .= "\tprotected $" . $column . ";" . PHP_EOL;
    }
    $properties .= PHP_EOL;

    //custructor 
    $constructor = "\tfunction __construct()" . PHP_EOL;
    $constructor .= "\t{" . PHP_EOL;
    $constructor .= "\t\tparent::__construct();" . PHP_EOL;
    $constructor .= "\t\t$" . "this->tbl_name = '$table';" . PHP_EOL;
    $constructor .= "\t\t" . '$this->company_id = $_SESSION[\'aUser\']->company_id;' . PHP_EOL;
    $constructor .= "\t}
";

    $methods = PHP_EOL . '
    public function rules($pk)
	{
		$rules = [' . PHP_EOL;

    $rules = '';
    foreach ($table_attributes as $column) {
        $rules .= '[\'' . $column->column_name . '\', \'' . $column->label  . '\', \'' . $column->rules . '\'],' . PHP_EOL;
    }

    $methods .= $rules . '];
		return array_map(\'set_validation_rules\', $rules);
	}
    
    public function save()
    {
        $res = 0;
        parent::getCreatedUpdatedDetails($this, $this->id);
        $params = [' . PHP_EOL;
    $count = 1;
    foreach ($columns as $column) {
        if ($count > 1) {
            $methods .= "\t'" . $column . '\' => $this->' . $column . ',' . PHP_EOL;
        }
        $count++;
    }

    $methods .= '];
    if (!empty($this->id) && $this->id > 0) {
        $res = $this->db->update(tbl_prefix() . $this->tbl_name, $params, array("id" => $this->id));
    } else {
        $res = $this->db->insert(tbl_prefix() . $this->tbl_name, $params);
        if ($res) {
            $this->id = $this->db->insert_id();
        }
    }
    return $res;
    }

public function delete()
{
    $aWhere = [
        \'company_id\' => $this->company_id,
        \'id\' => $this->id
    ];
    return $this->db->delete(tbl_prefix() . $this->tbl_name, $aWhere);
}

public function findByPK($select = \'*\')
	{
		$aWhere = [\'id\' => $this->id];
		$this->db->select($select);
		$this->db->from(tbl_prefix() . $this->tbl_name);
		$this->db->where($aWhere);
		$res = $this->db->get()->row();
		return $res;
	}

	public function all($aWhere = [], $select = \'*\')
	{
		$this->db->select($select);
		$this->db->from(tbl_prefix() . $this->tbl_name);
		$this->db->where($aWhere);
		$this->db->order_by(\'id\', \'desc\');
		$res = $this->db->get()->result();
		return $res;
	}

	public function one($aWhere = [], $select = \'*\')
	{
		$this->db->select($select);
		$this->db->from(tbl_prefix() . $this->tbl_name);
		$this->db->where($aWhere);
		$res = $this->db->get()->row();
		return $res;
	}

	public function error()
	{
		return $this->error_logs;
	}
';


    //Template Prepearation
    $template = "
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class $className extends MY_Model
{" . PHP_EOL;

    $template .= $properties . $constructor . $methods;

    $template .= "
}
";
    return $template;
}
