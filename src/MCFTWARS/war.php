<?php

namespace MCFTWARS;

use pocketmine\Player;
use MCFTWARS\team\redTeam;
use MCFTWARS\team\blueTeam;
class war {
	
	private $plugin, $isplay = false;
	public $redteam, $blueteam;
	private $soldiers = array();
	
	public function __construct(MCFTWARS $plugin) {
		$this->plugin = $plugin;
		$this->redteam = new redTeam($plugin);
		$this->blueteam = new blueTeam($plugin);
	}
	public function Start() {
		
	}
	public function participate(Player $player) {
		$soldier = new soldier($player);
		if(mt_rand(0, 1)) {
			$soldier->setTeam($this->redteam);
		} else {
			$soldier->setTeam($this->blueteam);
		}
		$player->teleport($soldier->getTeam()->getSpawnPoint());
		$this->soldiers[$player->getName()] = $soldier;
	}
	public function isPlay() {
		return $this->isplay;
	}
	/**
	 * 
	 * @param Player|string $player
	 * @return soldier
	 */
	public function getSoldier($player) {
		if(!$player instanceof Player) {
			$player = $this->plugin->getServer()->getPlayer($player);
		}
		return $this->soldiers[$player->getName()];
	}
	public function getSoldiers() {
		return $this->soldiers;
	}
}