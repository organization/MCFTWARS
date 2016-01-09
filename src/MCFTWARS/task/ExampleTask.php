<?php
//
namespace MCFTWARS\task;

use pocketmine\scheduler\PluginTask;
use pocketmine\plugin\Plugin;

class ExampleTask extends PluginTask {
	protected $owner;
	public function __construct(Plugin $owner) {
		parent::__construct ( $owner );
	}
	public function onRun($currentTick) {
		//일정 시간마다 실행할 내용
	}
}
?>