<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Filmek_Table extends CI_Migration {

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();
	}

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE
			),
			'cim' => array(
				'type' => 'VARCHAR',
				'constraint' => '150',
			),
			'kategoria' => array(
				'type' => 'VARCHAR',
				'constraint' => '150',
			),
			'hossz' => array(
				'type' => 'INT',
				'constraint' => '3',
			),
			'ertekeles' => array(
				'type' => 'INT',
				'constraint' => '2',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('filmek');
	}

	public function down()
	{
		$this->dbforge->drop_table('filmek');
	}
}

/* End of file Add_Filmek_Table.php */


?>
