<?php

namespace MCFTWARS;

use pocketmine\level\Position;
use pocketmine\Player;
class war {
	
	private $plugin, $isplay = false;
	private $soldiers = array();
	private $redteam, $blueteam;
	
	public function __construct(MCFTWARS $plugin) {
		$this->plugin = $plugin;
	}
	public function Start() {
		
	}
	public function setSpawn(Position $pos, $team) {
		$this->plugin->warDB["{$team}-spawn"]["pos"] = $pos->getX().$pos->getY().$pos->getZ();
		$this->plugin->warDB["{$team}-spawn"]["level"] = $pos->getLevel()->getName();
	}
	public function participate(Player $player) {
		
	}
	public function isPlay() {
		return $this->isplay;
	}
}