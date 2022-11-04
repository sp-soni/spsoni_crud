<?php
function get_css_class($type)
{
    $class = '';
    $aCssClasses=['date','datetime','number','int','integer'];
    if (in_array($type,$aCssClasses)) {
        $class = 'class="'.$type.'"';
    }
    return $class;
}

function generate_index($form_attributes, $module_url)
{
    //--Preparing Search Fields
    $thead = '<tr>';
    $count = 1;
    foreach ($form_attributes as $attribute) {
        $label = $attribute->label;
        $thead .= '<td>' . $label . '</td>' . PHP_EOL;
        if ($count == INDEX_FIELD_COUNT) {
            break;
        }
        $count++;
    }

    $thead .= '<td>Action</td>
    </tr>';

    $tbody = '<tr>';
    $count = 1;
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $id = $attribute->column_name;
        $label = $attribute->label;
        $tbody .= '<td>
        @php
            $' . $name . ' = !empty($_GET[\'' . $name . '\']) ? $_GET[\'' . $name . '\'] : \'\';            
        @endphp
        <input type="text" name="' . $name . '" class="form-control" value="{{ $' . $name . ' }}">
    </td>' . PHP_EOL;
        if ($count == INDEX_FIELD_COUNT) {
            break;
        }
        $count++;
    }
    $tbody .= '<td class="search-action">   
    <input type="submit" name="search" value="Search" class="btn btn-sm btn-primary">
    @if (!empty($_GET[\'search\']))
        <a href="{{ $module_url }}" class="btn btn-sm btn-warning">Reset</a>
    @endif
    <a href="{{ $module_url . \'/add/0\' }}" class="btn btn-sm btn-success">+Add</a>
</td>
</tr>';

    $search_fields = '<form method="get">
    <table class="table table-bordered">';
    $search_fields .= $thead . PHP_EOL;
    $search_fields .= $tbody . PHP_EOL;
    $search_fields .= '</table>
    </form>';


    //--Preparing GRID

    //thead
    $thead = '<thead>
                <tr>
                    <th width="5%" class="sn">#</th>' . PHP_EOL;
    $count = 1;
    foreach ($form_attributes as $attribute) {
        $label = $attribute->label;       
        $thead .= '<th width="10%">' . $label . '</th>' . PHP_EOL;
        if ($count == INDEX_FIELD_COUNT) {
            break;
        }
        $count++;
    }

    $thead .= '<th width="10%" class="action">Action</th>
                </tr>
            </thead>' . PHP_EOL;

    //tbody
    $tbody = '<tbody> 
    @php
    $sn = 1;
    @endphp
    @foreach ($aGrid as $item)
    <tr>
        <td>{{ $sn++ }}</td>';
    $count = 1;
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $css_class = get_css_class($attribute->type);
        $tbody .= ' <td '.$css_class.'>{{ $item->' . $name . ' }}</td>';
        if ($count == INDEX_FIELD_COUNT) {
            break;
        }
        $count++;
    }

    $tbody .= '<td class="action">' . PHP_EOL;    
    $tbody .= '{{ html_button(["btn"=>"edit_delete","id"=>$item->id,"url"=>"' . $module_url . '"]) }}' . PHP_EOL;
    $tbody .= '</td>
    </tr>
    @endforeach
</tbody>';


    $grid_fields = '<table class="table table-bordered">' . PHP_EOL;
    $grid_fields .= $thead;
    $grid_fields .= $tbody . PHP_EOL;
    $grid_fields .= '</table>';

    $template = '@extends(\'layouts.admin_layout\')
    @section(\'content\')

        <div class="content">
        {{ showMessage() }}
            ' . $search_fields . PHP_EOL . $grid_fields . '       
    </div>

@endsection';

    return $template;
}
