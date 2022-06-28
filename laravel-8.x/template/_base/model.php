<?php

function generate($className, $columns, $table, $table_attributes)
{

    //Template Prepearation
    $template = '<?php
namespace App\Models\_base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

abstract class ' . $className . ' extends BaseAbstractModel
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = \'' . $table . '\';' . PHP_EOL;

    $template .= 'protected $fillable = [' . PHP_EOL;
    foreach ($table_attributes as $column) {
        $template .= '\'' . $column->column_name . '\',' . PHP_EOL;
    }
    $template .= '];' . PHP_EOL . PHP_EOL;

    $template .= 'public function rules()
	{
		return [' . PHP_EOL;

    foreach ($table_attributes as $column) {
        $template .= '\'' . $column->column_name . '\' => \'' . $column->rules . '\',' . PHP_EOL;
    }

    $template .= '];' . PHP_EOL;
    $template .= '}' . PHP_EOL;



    $template .= '
    public function search($request)
    {' . PHP_EOL;

    foreach ($table_attributes as $column) {
        $template .= '$this->' . $column->column_name . ' = $request->get(\'' . $column->column_name . '\');' . PHP_EOL;
    }

    $template .= '$aWhere = [' . PHP_EOL;
    foreach ($table_attributes as $column) {
        $template .= '[\'' . $column->column_name . '\', \'LIKE\', \'%$this->' . $column->column_name . '%\'],' . PHP_EOL;
    }
    $template .= '];' . PHP_EOL;

    $template .= '$data = self::where($aWhere)->get();
        return $data;
    }' . PHP_EOL;

    $template .= PHP_EOL . '}';
    return $template;
}
