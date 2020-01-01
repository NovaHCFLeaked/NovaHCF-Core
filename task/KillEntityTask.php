<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/1/2017
 * Time: 3:39 AM
 */

namespace friscowz\hc\task;


use friscowz\hc\Myriad;
use pocketmine\entity\Entity;
use pocketmine\scheduler\Task;

class KillEntityTask extends Task
{
    private $entity;
    private $time = 30;

    /**
     * KillEntityTask constructor.
     * @param Myriad $owner
     * @param Entity $entity
     */
    public function __construct(Myriad $owner, Entity $entity)
    {
        $this->setEntity($entity);
        $this->setHandler($owner->getScheduler()->scheduleRepeatingTask($this, 20));
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
        if(!$this->getEntity()->isAlive()){
            $this->getHandler()->cancel();
            return;
        }
        if($this->time == 0){
            $this->getEntity()->close();
            $this->getHandler()->cancel();
            return;
        }
        --$this->time;
    }

    /**
     * @return Entity
     */
    public function getEntity() : Entity
    {
        return $this->entity;
    }

    /**
     * @param Entity $entity
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;
    }
}