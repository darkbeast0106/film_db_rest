<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_Filmek_Table extends CI_Migration {

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();
		$this->faker = Faker\Factory::create();
	}

	public function up()
	{
		$kategoriak = ['akció', 'kaland', 'sci-fi', 'horror', 'dráma', 'vígjáték', 'fantasy', 'romantikus'];

		for ($i=0; $i < 10; $i++) { 	
			$film = [
				"cim" => $this->faker->sentence($this->faker->numberBetween(3, 5)),
				"kategoria" => implode(", ", $this->faker->randomElements($kategoriak, $this->faker->numberBetween(1, 5))),
				"hossz" => $this->faker->numberBetween(60, 200),
				"ertekeles" => ($this->faker->randomDigit() + 1)
			];
			$this->db->insert('filmek', $film);
		}
	}

	public function down()
	{
		$this->db->truncate('filmek');
	}
}

/* End of file Seed_Filmek_Table.php */


?>
