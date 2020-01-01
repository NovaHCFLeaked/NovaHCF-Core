<?php

declare(strict_types = 1);

namespace friscowz\hc\item;

use pocketmine\item\{
    Armor, Durable, Item
};

class Elytra extends Durable{

    public function __construct($meta = 0){
        parent::__construct(Item::ELYTRA, $meta, "Elytra Wings");
    }

    public function getMaxDurability(): int{
        return 433;
    }
}