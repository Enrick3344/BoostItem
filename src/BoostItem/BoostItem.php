<?php 

namespace BoostItem;

use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Config;

class BoostItem extends PluginBase implements Listener{

    public function onEnable(){
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->notice("BoostItem Enabled.");
    }
    
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $inventory = $player->getInventory();
        $item = $this->getConfig()->get("Item-ID");
        $name = $this->getConfig()->get("Item-Name");
        $inventory->setItem(0, Item::fromString()->setCustomName($name));
    }
    
    public function onTap(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $inventory = $player->getInventory();
        $hand = $inventory->getItemInHand();
        $item = $this->getConfig()->get("Item-ID");
        $name = $this->getConfig()->get("Item-Name");
        if($hand->getId() == $item){
            if($hand->getName() === $name){
                $this->boostPlayer($player);
            }
        }
    }
    
    public function boostPlayer(Player $player){
        switch($player->getDirection()){
                case 0:
                    $player->knockBack($player, 0, $this->getLaunchDistance(), 0, $this->getBaseValue());
                    break;
                case 1:
                    $player->knockBack($player, 0, 0, $this->getLaunchDistance(), $this->getBaseValue());
                    break;
                case 2:
                    $player->knockBack($player, 0, -$this->getLaunchDistance(), 0, $this->getBaseValue());
                    break;
                case 3:
                    $player->knockBack($player, 0, 0, -$this->getLaunchDistance(), $this->getBaseValue());
                    break;
          }
     }
}
