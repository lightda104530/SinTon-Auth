<?php

namespace RegisterMS;

use pocketmine\utils\Config;

class RegisterMS{
	
	public function __construct($file){
		new Config($file."Question.yml", Config::YAML, array(
		   "4"=>array(
		   "a"=>"§cWelcome to §6SinTon §cServer~\(≧▽≦)/~",
		   "b"=>"§fFor the best gameing\nYou'll need to be login!!",
		   "c"=>"Please enter your MinecraftID to start the register system!!"),
		   "3"=>array(
		   "a"=>"Register system is starting...",
		   "b"=>"Please enter your password.",
		   "c"=>NULL ),
		   "2"=>array(
		   "a"=>"Saving your file...",
		   "b"=>"Please reenter your password that you just entered.",
		   "c"=>"If you want to change the password,enter remove to go back last move." ),
		   "1"=>array(
		   "a"=>"♚Please enter your password in the chatroom!!",
		   "b"=>NULL ,
		   "c"=>NULL )
		));
		
	}
}
