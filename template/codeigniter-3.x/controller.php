<?php

function generate_controller($className, $model, $table, $title, $form_attributes)
{
	$module_url = strtolower(MODULE) . '/' . $table;
	$template = '<?php
if (!defined(\'BASEPATH\')) exit(\'No direct script access allowed\');

class ' . $className . 'Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		parent::setModule(\'' . $module_url . '\');
		$this->load->model(\'' . $model . '\', \'oMainModel\');
	}

	public function index()
	{
		$data[\'aGrid\'] = $this->oMainModel->list();
		$data[\'title\'] = \'' . $title . ' List\';
		$data[\'breadcrumb\'] = array(\'\' => $data[\'title\']);
		load_admin_view(\'' . $table . '/index\', $data);
		hide_message();
	}

	public function add($edit_id = 0)
	{
		if (isset($_POST[\'submitform\'])) {
			$response = $this->oMainModel->add();
			if ($response[\'is_error\'] == 0) {
				set_message($response[\'message\']);
				redirect(config_item(\'module\')->module_url);
			} else {
				set_message($response[\'message\'], \'e\');
			}
		}
		$aContentInfo = get_row(\'' . $table . '\', array("id" => $edit_id));
		$data[\'aContentInfo\'] = $aContentInfo;		
		$data[\'title\'] = \'' . $title . ' Manage\';
		$data[\'breadcrumb\'] = array(config_item(\'module\')->module_url => \'' . $title . ' List\', "" => $data[\'title\']);
		load_admin_view(\'' . $table . '/form\', $data);
		hide_message();
	}

	function delete($delete_id = 0)
	{
		$this->oMainModel->delete($delete_id);
		set_message("' . $title . ' deleted succesffully");
		redirect(config_item(\'module\')->module_url);
	}
}
    ';
	return $template;
}
