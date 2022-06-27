<?php

function generate($className, $columns, $table, $table_attributes)
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
    $constructor .= "\t\t" . '$this->company_id =!empty($_SESSION["aUser"]->company_id) ? $_SESSION["aUser"]->company_id : "0";' . PHP_EOL;
    $constructor .= "\t}
";

    $methods = PHP_EOL . '
public function rules()
	{
		$rules = [' . PHP_EOL;

    $rules = '';
    foreach ($table_attributes as $column) {
        $rules .= '[\'' . $column->column_name . '\', \'' . $column->label  . '\', \'' . $column->rules . '\'],' . PHP_EOL;
    }

    $methods .= $rules . '];
		return array_map(\'set_validation_rules\', $rules);
	}
    ';

    $methods .= '
public function save()
{
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
return $this->db->update(tbl_prefix() . $this->tbl_name, $params, array("id" => $this->id));
} else {
return $this->db->insert(tbl_prefix() . $this->tbl_name, $params);
}
}

public function delete($delete_id)
{
return $this->db->delete(tbl_prefix() . $this->tbl_name, array("id" => $delete_id));
}';


    $methods .= 'public function all($aWhere = [], $select = \' * \')
{
return get_rows($this->tbl_name, $aWhere, $select);
}

public function one($aWhere = [], $select = \' * \')
{
return get_row($this->tbl_name, $aWhere, $select);
}

public function error()
{
return "Demo Error";
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
