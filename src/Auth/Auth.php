<?php

namespace Auth;

/* Loading things in pocketmine core:D */
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\Textformat;

class Auth extends PluginBase implments listener{
          
        public $auth
        public $cfg
        
    public function onEnable(){
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml")
          $this->cfg = new Config($this->getDataFolder() . "config.yml");
            $this->getLogger(TEXTFORMAT::GREEN . "SinTon Auth is now loading!!")
              }
              
    public function isAuthenticated(Player $p) {
      if(isset($this->auth[strtolower($p->getName())])) {
        $p->sendMessage("You have been authenticated!");
          }else{
            $p->sendMessage("You are not authenticated! Please login using /l [password]");
              }
        
    public function onDisable() {
        $this->cfg->save();
          $this->getLogger()->warning("Did the server stop?");
            $this->getLogger(TEXTFORMAT::RED . "Configs are saved!!");
}
