<?php

function generate_base_model($className, $columns, $table, $table_attributes)
{

    //Template Prepearation
    $template = '<?php
namespace App\Models\_base;' . PHP_EOL;

    $template .= 'use App\CustomComponents\BaseAbstractModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;' . PHP_EOL;

    if ($table == 'users') {
        $template .= 'use Illuminate\Foundation\Auth\User as Authenticatable;' . PHP_EOL;
        $template .= PHP_EOL . 'abstract class ' . $className . ' extends Authenticatable' . PHP_EOL;
    } else {
        $template .= PHP_EOL . 'abstract class ' . $className . ' extends BaseAbstractModel' . PHP_EOL;
    }

    $template .= '{
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
        if (!empty($column->rules)) {
            $template .= '\'' . $column->column_name . '\' => \'' . $column->rules . '\',' . PHP_EOL;
        }
    }

    $template .= '];' . PHP_EOL;
    $template .= '}' . PHP_EOL;



    $template .= '
    public function search($request)
    {' . PHP_EOL;

    $count = 1;
    foreach ($table_attributes as $column) {
        $template .= '$this->' . $column->column_name . ' = $request->get(\'' . $column->column_name . '\');' . PHP_EOL;
        if ($count == 5) {
            break;
        }
        $count++;
    }

    $template .= '$aWhere = [' . PHP_EOL;
    $count = 1;
    foreach ($table_attributes as $column) {
        $template .= '[\'' . $column->column_name . '\', \'LIKE\', \'%\'.$this->' . $column->column_name . '.\'%\'],' . PHP_EOL;
        if ($count == 5) {
            break;
        }
        $count++;
    }
    $template .= '];' . PHP_EOL;

    $template .= '$data = self::where($aWhere)->orderBy(\'id\', \'desc\')->get();
        return $data;
    }' . PHP_EOL;

    $template .= '
    public function delete_record($id){
        //Delete Actions
    }
    ';
    $template .= PHP_EOL . '}';
    return $template;
}
