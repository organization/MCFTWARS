<?php
namespace MCFTWARS;

use pocketmine\Player;

class soldier {
	
	private $player, $team;
	
	public function __construct(Player $player) {
		$this->player = $player;
	}
	public function getPlayer() {
		return $this->player;
	}
	public function setTeam($team) {
		$this->team = $team;
	}
	public function getTeam($team) {
		return $this->team;
	}
}