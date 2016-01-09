<?php
namespace MCFTWARS\team;

use MCFTWARS;
class redTeam implements Team {
	
	private $soldiers = array();
	/**
	 * 
	 * @var \MCFTWARS\MCFTWARS
	 */
	private $plugin;
	
	public function __construct(MCFTWARS $plugin) {
		$this->plugin = $plugin;
	}
}