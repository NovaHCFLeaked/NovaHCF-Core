<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 14/08/2017
 * Time: 01:16
 */

namespace friscowz\hc\task;

use friscowz\hc\MDPlayer;
use friscowz\hc\modules\ModulesManager;
use friscowz\hc\modules\SOTW;
use friscowz\hc\Myriad;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;
use friscowz\hc\utils\Utils;

class HudTask extends Task
{
    private $plugin;
    private $player;

    /**
     * HudTask constructor.
     * @param Myriad $plugin
     * @param MDPlayer $player
     */
    public function __construct (Myriad $plugin, MDPlayer $player)
    {
        $this->setPlayer($player);
        $this->setPlugin($plugin);
        $this->setHandler($this->getPlugin()->getScheduler()->scheduleRepeatingTask($this, 10));
    }

    /**
     * Actions to execute when run
     *
     * @param int $currentTick
     *
     * @return void
     */
    public function onRun (int $currentTick)
    {
        $player = $this->getPlayer();
        if(Myriad::getFactionsManager()->isSpawnClaim($player)){
            $player->setFood(20);
        }
        $space = str_repeat(" ", 70);
        $text = $space . TextFormat::BOLD . TextFormat::YELLOW . "Arcadium " . TextFormat::RESET . TextFormat::WHITE . "| Map 1\n";
        if (ModulesManager::get(ModulesManager::SOTW)->isEnabled()) {
            $text .= $space . TextFormat::BOLD . TextFormat::DARK_BLUE . "SOTW: " . TextFormat::RESET . TextFormat::GRAY . Utils::intToString(SOTW::getTime()) . "\n";
        }
        if (ModulesManager::get(ModulesManager::KOTH)->isRunning()) {
            $text .= $space . TextFormat::BOLD . TextFormat::BLUE . "KoTH: " . TextFormat::RESET . TextFormat::GRAY . Utils::intToString(ModulesManager::get(ModulesManager::KOTH)->getTask()->getTime()) . "\n";
        }
        if ($player->isPvp()) {
            $text .= $space . TextFormat::BOLD . TextFormat::RED . "PVPTimer: " . TextFormat::RESET . TextFormat::GRAY . Utils::intToString($player->getPvptime()) . "\n";
        }
        if ($player->isLogout()) {
            $text .= $space . TextFormat::BOLD . TextFormat::DARK_RED . "Logout: " . TextFormat::RESET . TextFormat::GRAY . Utils::intToString($player->getLogoutTime()) . "\n";
        }
        if ($player->isTagged()) {
            $text .= $space . TextFormat::BOLD . TextFormat::RED . "CombatTag: " . TextFormat::RESET . TextFormat::GRAY . Utils::intToString($player->getTagtime()) . "\n";
        }
        if ($player->isCoords()) {
            $text .= $space . TextFormat::BOLD . TextFormat::RED . "Coords: " . TextFormat::RESET . TextFormat::GRAY . $player->getFloorX() . ", " . $player->getFloorZ() . "\n";
        }
        if ($player->isBard()) {
            $text .= $space . TextFormat::BOLD . TextFormat::GOLD . "BardEnergy: " . TextFormat::RESET . TextFormat::GRAY . $player->getBardEnergy() . "\n";
        }
        if ($player->isTeleporting()) {
            if ($player->getTeleport() == MDPlayer::HOME) {
                $text .= $space . TextFormat::BOLD . TextFormat::YELLOW . "Home: " . TextFormat::RESET . TextFormat::GRAY . Utils::intToString($player->getTeleportTime()) . "\n";
            } elseif ($player->getTeleport() == MDPlayer::STUCK) {
                $text .= $space . TextFormat::BOLD . TextFormat::YELLOW . "Stuck: " . TextFormat::RESET . TextFormat::GRAY . Utils::intToString($player->getTeleportTime()) . "\n";
            }
        }
        $text .= str_repeat("\n", 12);
        $player->sendTip($text);

    }

    /**
     * @return Myriad
     */
    public function getPlugin () : Myriad
    {
        return $this->plugin;
    }

    /**
     * @param Myriad $plugin
     */
    public function setPlugin (Myriad $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return MDPlayer
     */
    public function getPlayer() : MDPlayer
    {
        return $this->player;
    }

    /**
     * @param MDPlayer $player
     */
    public function setPlayer(MDPlayer $player)
    {
        $this->player = $player;
    }
}