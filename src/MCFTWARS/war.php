<?php

namespace MCFTWARS;

use pocketmine\Player;
use MCFTWARS\team\redTeam;
use MCFTWARS\team\blueTeam;
use pocketmine\utils\TextFormat;
use pocketmine\level\Position;
class war {
	
	private $plugin, $isplay = false;
	public $redteam, $blueteam;
	/**
	 * 
	 * @var soldier
	 */
	private $soldiers = array();
	
	public function __construct(MCFTWARS $plugin) {
		$this->plugin = $plugin;
		$this->redteam = new redTeam($plugin);
		$this->blueteam = new blueTeam($plugin);
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
	 * @return soldier|null
	 */
	public function getSoldier($player) {
		if(!$player instanceof Player) {
			$player = $this->plugin->getServer()->getPlayer($player);
		}
		if(isset($this->soldiers[$player->getName()])) {
			return $this->soldiers[$player->getName()];
		} else {
			return null;
		}
	}
	public function getSoldiers() {
		return $this->soldiers;
	}
	/**
	 * 
	 * @param Player|string $player
	 * @return boolean
	 */
	public function leaveWar($player) {
		if(!$player instanceof Player) {
			$player = $this->plugin->getServer()->getPlayer($player);
		}
		if ($this->getSoldier($player) == null) {
			return false;
		} else {
			unset($this->soldiers[$player->getName()]);
		}
		return true;
	}
	public function StartWar() {
		$this->isplay = true;
		$this->plugin->getServer()->broadcastMessage(TextFormat::DARK_AQUA.$this->plugin->get("default-prefix")." ".$this->plugin->get("start-war"));
	}
	public function EndWar() {
		$this->isplay = false;
		$this->plugin->getServer()->broadcastMessage(TextFormat::DARK_AQUA.$this->plugin->get("default-prefix")." ".$this->plugin->get("end-war"));
		foreach ($this->soldiers as $soldier) {
			$soldier->getPlayer()->teleport($this->getLobby());
		}
		unset($this->soldiers);
	}
	public function setLobby(Position $pos) {
		$this->plugin->warDB["spawn"]["lobby"]["pos"] = "{$pos->getX()}.{$pos->getY()}.{$pos->getZ()}";
		$this->plugin->warDB["spawn"]["lobby"]["level"] = $pos->getLevel()->getName();
	}
	public function getLobby() {
		$pos = explode(".", $this->plugin->warDB["spawn"]["lobby"]["pos"]);
		$level = $this->plugin->getServer()->getLevelByName($this->plugin->warDB["spawn"]["lobby"]["level"]);
		return new Position($pos[0], $pos[1], $pos[2], $level);
	}
}