<?php
namespace MCFTWARS\team;

use MCFTWARS;
class Team {
	/**
	 * 
	 * @var \MCFTWARS\MCFTWARS
	 */
	public $plugin;
	
	public function __construct(MCFTWARS $plugin) {
		$this->plugin = $plugin;
	}
	public function getTeamName();
}