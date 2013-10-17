<?php

namespace model;

require_once("model/StickSelection.php");
require_once("model/AIPlayer.php");
require_once("model/PersistantSticks.php");

class LastStickGame {

	public function __construct() {
		$this->ai = new \model\AIPlayer();
		$this->sticks = new \model\PersistantSticks(\view\GameView::StartingNumberOfSticks); 
	}

	public function playerSelectsSticks(\model\StickSelection $playerSelection, \model\StickGameObserver $observer) {
		$this->sticks->removeSticks($playerSelection); 

		if ($this->isGameOver()) {
			$observer->playerWins();
		} else {
			$this->AIPlayerTurn($observer);
		} 
	}	

	private function AIPlayerTurn(\model\StickGameObserver $observer) {
		$sticksLeft = $this->getNumberOfSticks();
		$selection = $this->ai->getSelection($sticksLeft);

		$this->sticks->removeSticks($selection);
		$observer->aiRemoved($selection);

		if ($this->isGameOver()) {
			$observer->playerLoose();
		}
	}

	/** 
	* @return boolean
	*/
	public function isGameOver() {
		return $this->sticks->getNumberOfSticks() < 2;
	}

	/** 
	* @return int
	*/
	public function getNumberOfSticks() {
		return $this->sticks->getNumberOfSticks();
	}
	
	public function newGame() {
		$this->sticks->newGame(\view\GameView::StartingNumberOfSticks); 
	}
	
	/** 
	* @return int
	*/
	public function getMsg()
	{
		return $this->ai->setMsg();
	}
}