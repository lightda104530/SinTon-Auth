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
            $this->getLogger(TEXTFORMAT::GREEN . ">>　SinTon Auth is now loading!!")
              }
              
          public function onJoin(PlayerJoinEvent $event){
	    $user = strtolower($event->getPlayer()->getName());
		$id = $event->getPlayer()->getName();
			$tf=$this->keys->get("switch");
				$ip=$event->getPlayer()->getAddress();
					date_default_timezone_set('Asia/Taipei'); //時間設置在台灣台北
						if(!file_exists($this->newplayer."$user.yml")){
							$p = new Config($this->newplayer."$user.yml", Config::YAML, array(
								"username"=>$user,
								"address"=>null,
								"last-day"=>null,
								"last-hour"=>null,
								"password"=>null,
								"links"=>4
								));
								$p->save();				
	          $this->getServer()->getLogger()->info(TextFormat::YELLOW."$id ".TextFormat::BLUE.">>　File Create!!!");	
		}
		$pp = new Config($this->newplayer."$user.yml", Config::YAML);
		$sip=$pp->get("address");
		$sday=$pp->get("last-day");
		$shour=$pp->get("last-hour");
		$ttt=$pp->get("links");
                    $this->pper[$user] = "off";
	          $this->getServer()->getLogger()->info(TextFormat::BLUE."[SinTon]$id Join the server!!");
                    $event->getPlayer()->sendMessage("[Welcome system] ".TextFormat::GOLD."☆Welcome back to§eOur Server!!");
		$this->pper[$user]="on";
		}else{
		$pp->set("links",1);
		}}elseif($ttt > 1){
		$pp->set("links",4);
		if($tf == "on" and $ttt == "4"){
		$pp->set("links",5);}
		$this->getServer()->getLogger()->info(TextFormat::RED."[SinTon]$id Wasn't register");}
		$pp->save();
		$this->trust($event,$pp);
        $this->move[$user] = 0;
		$this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this,"timeout"],[$event]), $this->timeout*20);
	}	
	public function onCmdandChat(PlayerCommandPreprocessEvent $event){
		$player = $event->getPlayer();
	    $user = strtolower($player->getName());
		$id = $player->getName();
		$m = $event->getMessage();
		$ip = $player->getAddress();
		date_default_timezone_set('Asia/Taipei'); //System time set to Asia/Taipei
		$day=date("d");
		$hour=date("H");
		$pp =new Config($this->newplayer."$user.yml", CONFIG::YAML);
		$ttt=$pp->get("links");
	    if($ttt !== 0){$event->setCancelled(true);}
		if($ttt==5){
			$keys = $this->keys->getall();
			if(isset($keys[$m])){
			$pp->set("username","$user");
			if($keys[$m] == 1){
			unset($keys[$m]);
			}else{
			$keys[$m]--;}
			$this->keys->setall($keys);
			$pp->set("links",$ttt-1);
			$pp->save();
		    $player->sendMessage(TextFormat::BLUE."Ψ帳號激活成功！");
			$this->keys->save();
            $this->trust($event,$pp);
	        $this->getServer()->getLogger()->info(TextFormat::RED."[星童激活系統]$id 使用了$m 激活帳號成功!");
			}else{
			$player->sendMessage(TextFormat::RED."Ψ對不起，激活碼無效！");}
			}
        if($ttt==4){
		if($m==$id){
			$pp->set("links",$ttt-1);
			$pp->save();
			$player->sendMessage(TextFormat::BLUE."驗證成功！請開始註冊程序 !");
            $this->trust($event,$pp);
			}else{
			$player->sendMessage(TextFormat::DARK_RED."請輸入正確的遊戲ID，注意大小寫");
			$player->sendMessage(TextFormat::BLUE."您的遊戲ID，注意大小寫 >".TextFormat::RED." $id");
		}}
		if($ttt==3){
		    $m=trim($m);
			$pp->set("password",$m);
			$pp->set("links",$ttt-1);
			$pp->save();
			$player->sendMessage(TextFormat::GOLD."☆☆您所輸入的密碼為".TextFormat::BLUE." $m");
            $this->trust($event,$pp);
			}
        if($ttt==2){
			$re=$pp->get("password");
			if($m==$re){
			$time = date("y-m-d-H-i");
		    $pp->set("links",0);
			$pp->set("register-time","$time");
			$pp->save();
			$this->playerslogin1[$user]="false";
			$this->playerslogin2[$user]="true";
            $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this,"login2"],[$user]), 10*20);
	        $player->sendMessage(TextFormat::BLUE."☆註冊程序結束，歡迎加入§3星童 §6伺服器！");
			$this->pper[$user]="on";
            $this->trust($event,$pp);	
	        return $this->getServer()->getLogger()->info(TextFormat::RED."[星童註冊程序]$id 註冊完畢!");
			}elseif($m=="remove"){
			$pp->set("links",$ttt+1);
			$pp->save();
			$this->trust($event,$pp);
			}else{
			$player->sendMessage(TextFormat::RED."☆密碼錯誤，請再次輸入");
            $this->trust($event,$pp);
			}
		}
        $reg = $pp->get("password");
        if($ttt==1){
			if(!$m == NULL){
			if($m == $reg){
			$pp->set("links",$ttt-1);
			$pp->set("last-day",$day);
			$pp->set("last-hour",$hour);
			$pp->set("address",$ip);
			$pp->save();
			$this->playerslogin1[$user]="false";
			$this->playerslogin2[$user]="true";
            $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this,"login2"],[$user]), 10*20);
	        $this->getServer()->getLogger()->info(TextFormat::YELLOW."[星童登入系統]$id 登入成功");	
			$this->pper[$user] = "on";
	        return $player->sendMessage(TextFormat::GOLD."歡迎回到§3星童§6伺服器");
            }else{ 
			$player->sendMessage("♚密碼錯誤，請再次輸入！");
			}}}
        if($this->playerslogin2[$user]=="true"){
        if($m == $reg){
        $player->sendMessage("[星童保護] ".TextFormat::YELLOW."您差點透露您的密碼！");
	    $event->setCancelled(true);
		}}
	}
    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
          $user = strtolower($sender->getName());
            switch($command->getName()){
                    case "unregister":
	                    if(isset($args[1])){
	                              $y=$args[0];
	                                        $n=$args[1];
	                                         $pp =new Config($this->newplayer."$user.yml", CONFIG::YAML);
	                                                   $reg=$pp->get("password");
	                                                            if($y==$reg){
	                                                                      $pp->set("password",$n);
	                                                                      $pp->save();
	                                                            $msg="[密码修改] 恭喜你成功修改密码，新密码为 $n";
	                                                   }else{
	                                         $msg="[密码修改] 对不起原密码输入错误！";}
	                              }elseif($sender instanceof Player){
	                                        return false;
	                                        }else{
	                              $msg="[密码修改] 请在游戏中使用 ！";
	                                         }
	                              $sender->sendMessage($msg);
	                                        return true;
    public function onDisable() {
        $this->cfg->save();
          $this->getLogger()->warning("Did the server stop?");
            $this->getLogger(TEXTFORMAT::RED . "Configs are saved!!");
}
