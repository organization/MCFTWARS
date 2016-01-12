<?php

namespace MCFTWARS;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Player;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;

class EventListener implements Listener {
	private $plugin;
	private $touchinfo = array ();
	public function __construct(MCFTWARS $plugin) {
		$this->plugin = $plugin;
		$plugin->getServer ()->getPluginManager ()->registerEvents ( $this, $plugin );
	}
	public function onAttack(EntityDamageEvent $event) {
		if ($event instanceof EntityDamageByEntityEvent) {
			$damager = $event->getDamager ();
			$player = $event->getEntity ();
			if ($damager instanceof Player and $player instanceof Player) {
				if ($this->plugin->war->getSoldier ( $player ) == null or $this->plugin->war->getSoldier ( $damager ) == null) {
					return true;
				} else {
					if ($this->is_sameTeam ( $this->plugin->war->getSoldier ( $player ), $this->plugin->war->getSoldier ( $damager ) )) {
						$event->setCancelled ( true );
					}
				}
			}
		}
	}
	public function is_sameTeam(soldier $soldier1, soldier $soldier2) {
		if ($soldier1->getTeam ()->getTeamName () == $soldier2->getTeam ()->getTeamName ()) {
			return true;
		} else {
			return false;
		}
	}
	public function onTouch(PlayerInteractEvent $event) {
		$player = $event->getPlayer();
		$block = $event->getBlock ();
		if ($block->getId () == 54) {
			$event->setCancelled ();
			$block = $event->getBlock();
			if(!isset($this->touchinfo[$player->getName()])) {
				$this->giveRandomItem($player);
				array_push($this->touchinfo[$player->getName()], "{$block->getX()}.{$block->getY()}.{$block->getZ()}");
				$this->plugin->message($player, $this->get("get-item-from-chest"));
			} else {
				foreach ($this->touchinfo[$player->getName()] as $stringpos) {
					if ($stringpos == "{$block->getX()}.{$block->getY()}.{$block->getZ()}") {
						$this->plugin->alert($player, $this->get("already-get-item"));
						return true;
					}
				}
				$this->giveRandomItem($player);
				array_push($this->touchinfo[$player->getName()], "{$block->getX()}.{$block->getY()}.{$block->getZ()}");
				$this->plugin->message($player, $this->get("get-item-from-chest"));
			}
		}
	}
	public function giveRandomItem(Player $player) {
		$inventory = $player->getInventory();
		$repeat = mt_rand(0, 3);
		for($i = 0; $i < $repeat; $i++) {
			$itemid = mt_rand(0, count($this->plugin->itemlist));
			if($itemid == 262) {
				$count = mt_rand(3, 10);
			} else {
				$count = 1;
			}
			$inventory->addItem(Item::get($itemid, 0, $count));
		}
	}
}