<?php

namespace FiraAja\MagmaWorkaround;

use pocketmine\block\Magma;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;

final class Main extends PluginBase {

    protected function onEnable(): void
    {
        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function (): void {
            foreach ($this->getServer()->getOnlinePlayers() as $player) {
                $block = $player->getWorld()->getBlock($player->getPosition()->subtract(0, 1, 0));

                if ($player->getEffects()->has(VanillaEffects::FIRE_RESISTANCE()) || $player->isSneaking()) return;
                if ($block instanceof Magma) {
                    $player->attack(new EntityDamageByBlockEvent($block, $player, EntityDamageEvent::CAUSE_FIRE, 1));
                }
            }
        }), 20);
    }
}