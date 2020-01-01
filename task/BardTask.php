<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/11/2017
 * Time: 11:54 PM
 */

namespace friscowz\hc\task;


use friscowz\hc\MDPlayer;
use friscowz\hc\Myriad;
use pocketmine\entity\EffectInstance;
use pocketmine\item\ItemIds;
use pocketmine\entity\Effect;
use pocketmine\scheduler\Task;

class BardTask extends Task
{
    public function __construct(Myriad $plugin)
    {
        $plugin->getScheduler()->scheduleRepeatingTask($this, 20);
    }

    /**
     * Actions to execute when run
     *
     * @param int $currentTick
     *
     * @return void
     */
    public function onRun(int $currentTick)
    {
        foreach (Myriad::getInstance()->getServer()->getOnlinePlayers() as $player){
            if ($player instanceof MDPlayer){
                if ($player->isBard()){
                    if ($player->getBardEnergy() < 100 ) $player->setBardEnergy($player->getBardEnergy() + 1);
                    if ($player->isInFaction()) {
                        switch ($player->getInventory()->getItemInHand()->getId()) {
                            case ItemIds::SUGAR:
                                foreach (Myriad::getFactionsManager()->getOnlineMembers($player->getFaction()) as $member) {
                                    if ($member->getName() !== $player->getName() and $member->distanceSquared($player) < 20) {
                                        if (!$member->hasEffect(Effect::SPEED)){
                                            $effect = new EffectInstance(Effect::getEffect(Effect::SPEED), 20 * 5, 0);
                                            $member->addEffect($effect);
                                        }
                                    }
                                }
                                break;

                            case ItemIds::FEATHER:
                                foreach (Myriad::getFactionsManager()->getOnlineMembers($player->getFaction()) as $member) {
                                    if ($member->getName() !== $player->getName() and $member->distanceSquared($player) < 20) {
                                        if (!$member->hasEffect(Effect::JUMP)){
                                            $effect = new EffectInstance(Effect::getEffect(Effect::JUMP), 20 * 5, 2);
                                            $member->addEffect($effect);
                                        }
                                    }
                                }
                                break;

                            case ItemIds::IRON_INGOT:
                                foreach (Myriad::getFactionsManager()->getOnlineMembers($player->getFaction()) as $member) {
                                    if ($member->getName() !== $player->getName() and $member->distanceSquared($player) < 20) {
                                        if (!$member->hasEffect(Effect::DAMAGE_RESISTANCE)){
                                            $effect = new EffectInstance(Effect::getEffect(Effect::DAMAGE_RESISTANCE), 20 * 5, 0);
                                            $member->addEffect($effect);
                                        }
                                    }
                                }
                                break;

                            case ItemIds::GHAST_TEAR:
                                foreach (Myriad::getFactionsManager()->getOnlineMembers($player->getFaction()) as $member) {
                                    if ($member->getName() !== $player->getName() and $member->distanceSquared($player) < 20) {
                                        if (!$member->hasEffect(Effect::REGENERATION)){
                                            $effect = new EffectInstance(Effect::getEffect(Effect::REGENERATION), 20 * 5, 0);
                                            $member->addEffect($effect);
                                        }
                                    }
                                }
                                break;

                            case ItemIds::BLAZE_POWDER:
                                foreach (Myriad::getFactionsManager()->getOnlineMembers($player->getFaction()) as $member) {
                                    if ($member->getName() !== $player->getName() and $member->distanceSquared($player) < 20) {
                                        if (!$member->hasEffect(Effect::STRENGTH)){
                                            $effect = new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20 * 5, 0);
                                            $member->addEffect($effect);
                                        }
                                    }
                                }
                                break;
                        }
                    }
                }
            }
        }
    }

}