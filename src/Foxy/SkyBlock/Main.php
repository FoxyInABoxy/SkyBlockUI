<?php

namespace Foxy\SkyBlock;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener {

    public function onEnable(){
        $this->getLogger()->info("SkyBlockUI is up and running, NO MALFUNCTIONS DETECTED!!");
        $this->getLogger()->info("This plugin was created by FoxInTheBox");
    }
    public function onDisable(){
        $this->getLogger()->info("SkyBlockUI is now offline, NO MALFUNCTIONS DETECTED!!");  
        $this->getLogger()->info("This plugin was created by FoxInTheBox");
    }

  public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args): bool {
    switch($cmd->getName()){
			case "sbui":
			if($sender instanceof Player){
				$this->sbui($sender);
			}else{
        $sender->sendMessage("Please run this command in-game.");
      }
		}
	  return true;
  }

  public function sbui($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, int $data = null){
      if($data === null){
				return true;
			}
      switch($data){
        case 0:
            $this->generalsettings($player);
        break;

        case 1:
            $this->playersettings($player);
        break;

        case 2:
            $this->membersettings($player);
        break;

        case 3:
            $this->islandsettings($player);
        break;
      }
    });
    $form->setTitle("SkyBlockUI");
    $form->addButton("General Setting\n Manage general settings");
    $form->addButton("Player Setting\nManage Player\Vistor settings");
    $form->addButton("Member Setting\nManage Island member settings");
    $form->addButton("Island Settings\n Manage main island settings");
    $form->sendToPlayer($player);
    return $form;
  }

  public function generalsettings($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, int $data = null){
      if($data === null){
				return true;
			}
      switch($data){
        case 0:
            $this->getServer()->dispatchCommand($player, "is create");
        break;

        case 1:
            $this->getServer()->dispatchCommand($player, "is join");
        break;

        case 2:
            $this->visit($player);
        break;

        case 3:
            $this->getServer()->dispatchCommand($player, "is leave");
        break;

        case 4:
            $this->sbui($player);
        break;
      }
    });
    $form->setTitle("SkyBlockUI - General Settings");
    $form->addButton("Create Island\n Create a skyblock island");
    $form->addButton("Join Island\nTeleport to your own island");
    $form->addButton("Visit Island\nVisit a publically open island");
    $form->addButton("Leave Island\nLeave your island");
    $form->addButton("Back\nOpen the main menu");
    $form->sendToPlayer($player);
    return $form;
  }

  public function visit($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
        return true;
      }
      $this->getServer()->dispatchCommand($player, "is visit " . $data[0]);
    });
    $form->setTitle("SkyBlockUI - Island Visiting");
		$form->addInput("Enter the GamerTag/Name of the player");
		$form->sendToPlayer($player);
		return $form;
  }

  public function playersettings($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, int $data = null){
      if($data === null){
        return true;
      }
      switch($data){
        case 0:
            $this->invite($player);
        break;

        case 1:
            $this->accept($player);
        break;

        case 2:
            $this->deny($player);
        break;

        case 3:
            $this->ban($player);
        break;

        case 4:
            $this->coop($player);
        break;

        case 5:
            $this->sbui($player);
        break;
      }
    });
    $form->setTitle("SkyBlockUI - Player Settings");
    $form->addButton("Invite Player\nInvite a player to your island");
    $form->addButton("Accept Invite\nAccept an invite to a island");
    $form->addButton("Deny Invite\nDeny an invite to a island");
    $form->addButton("Ban Player\nBan a player from our island");
    $form->addButton("Co-Op\nAdd a player as your island co-op");
    $form->addButton("Back\nOpen the main menu");
		$form->sendToPlayer($player);
		return $form;
  }

  public function invite($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
        return true;
      }
      $this->getServer()->dispatchCommand($player, "is invite " . $data[0]);
    }); 
    $form->setTitle("SkyBlockUI - Invite Players");
		$form->addInput("Enter the GamerTag/Name of the player");
		$form->sendToPlayer($player);
		return $form;
  }

  public function deny($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
        return true;
      }
      $this->getServer()->dispatchCommand($player, "is deny " . $data[0]);
    });
    $form->setTitle("SkyBlockUI - Deny Island Invite");
		$form->addInput("Enter the GamerTag/Name of the player");
		$form->sendToPlayer($player);
		return $form;
  }

  public function ban($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
        return true;
      }
      $this->getServer()->dispatchCommand($player, "is banish " . $data[0]);
    });
    $form->setTitle("SkyBlockUI - Island Ban Player");
		$form->addInput("Enter the GamerTag/Name of the player");
		$form->sendToPlayer($player);
		return $form;
  }

  public function coop($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
        return true;
      }
      $this->getServer()->dispatchCommand($player, "is cooperate " . $data[0]);
    });
    $form->setTitle("SkyBlock - Add as CO-OP");
		$form->addInput("Enter the GamerTag/Name of the player");
		$form->sendToPlayer($player);
		return $form;
  }

  public function membersettings($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, int $data = null){
      if($data === null){
        return true;
      }
      switch($data){
        case 0:
            $this->promote($player);
        break;

        case 1:
            $this->demote($player);
        break;

        case 2:
            $this->fire($player);
        break;

        case 3:
            $this->getServer()->dispatchCommand($player, "is members");
        break;

        case 4:
            $this->sbui($player);
        break;
      }
    });
    $form->setTitle("SkyBlockUI - Member Settings");
    $form->addButton("Promote Member\nPromote island members");
    $form->addButton("Demote Member\nDemote Island member");
    $form->addButton("Fire Member\nRemove a island member");
    $form->addButton("Check Members\nCheck the number & name of your members");
    $form->addButton("Back\nOpen the main menu");
		$form->sendToPlayer($player);
		return $form;
  }

  public function promote($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
        return true;
      }
      $this->getServer()->dispatchCommand($player, "is promote " . $data[0]);
    });
    $form->setTitle("SkyBlockUI - Promote Members");
		$form->addInput("Enter the GamerTag/Name of the player");
		$form->sendToPlayer($player);
		return $form;
  }

  public function demote($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
        return true;
      }
      $this->getServer()->dispatchCommand($player, "is demote " . $data[0]);
    });
    $form->setTitle("SkyBlockUI - Demote Members");
		$form->addInput("Enter the GamerTag/Name of the player");
		$form->sendToPlayer($player);
		return $form;
  }

  public function fire($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
        return true;
      }
      $this->getServer()->dispatchCommand($player, "is fire " . $data[0]);
    });
    $form->setTitle("SkyBlockUI - Fire Members");
		$form->addInput("Enter the GamerTag/Name of the player");
		$form->sendToPlayer($player);
		return $form;
  }

  public function islandsettings($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, int $data = null){
      if($data === null){
        return true;
      }
      switch($data){
        case 0:
            $this->getServer()->dispatchCommand($player, "is lock");
        break;

        case 1:
            $this->getServer()->dispatchCommand($player, "is chat");
        break;

        case 2:
            $this->disband($player);
        break;

        case 3:
            $this->getServer()->dispatchCommand($player, "is setspawn");
        break;

        case 4:
            $this->getServer()->dispatchCommand($player, "is blocks");
        break;

        case 5:
            $this->transfer($player);
        break;

        case 6:
            $this->sbui($player);
        break;
      }
    });
    $form->setTitle("SkyBlock - Main settings");
    $form->addButton("Island Lock \nToggle island lock for visitors");
    $form->addButton("Island Chat \nToggle island Chat");
    $form->addButton("Delete Island\n Delete your skyblock island");
    $form->addButton("Set Spawn Point\nSet the default spawn for your island");
    $form->addButton("Island Blocks \n§rCheck The Blocks Placed");
    $form->addButton("Island Transfer\nTransfer your island ownership");
    $form->addButton("Back\n Open the main menu");
		$form->sendToPlayer($player);
		return $form;
  }

  public function disband($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, int $data = null){
      if($data === null){
				return true;
			}
      switch($data){
        case 0:
            $this->getServer()->dispatchCommand($player, "is disband");
        break;
      }
    });
    $form->setTitle("SkyBlockUI - Disband Island");
    $form->addButton("Yes");
    $form->addButton("No");
    $form->sendToPlayer($player);
    return $form;
  }

  public function transfer($player){
    $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
      if($data === null){
				return true;
			}
      $this->getServer()->dispatchCommand($player, "is transfer " . $data[0]);
    });
    $form->setTitle("SkyBlockUI - Tranfer Island Ownership");
    $form->addInput("Enter the GamerTag/Name of the player");
    $form->sendToPlayer($player);
    return $form;
  }
}
