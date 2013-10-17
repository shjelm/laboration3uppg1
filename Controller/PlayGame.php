<?php

namespace controller;

require_once("model/LastStickGame.php");
require_once("view/GameView.php");

class PlayGame {

	/**
	 * @var \model\LastStickGame
	 */
	private $game;

	/**
	 * @var \view\GameView
	 */
	private $view;

	/**
	 * @var string
	 */
	private $message = "";

	private $AIPlayer;

	public function __construct() {
		$this->game = new \model\LastStickGame();
		$this->view = new \view\GameView($this->game);
	}

	/**
	* @return String HTML
	*/
	public function runGame() {
		//Handle input
		if ($this->game->isGameOver()) {
			$this->doGameOver();
		} else {
			$this->playGame();
		}
		
		$this->setMsg();
		//Generate Output
		return $this->view->show($this->message);
	}

	/**
	* Called when game is still running
	*/
	private function playGame() {
		if ($this->playerSelectSticks()) {
			try {
				$sticksDrawnByPlayer = $this->getNumberOfSticks();
				$this->game->playerSelectsSticks($sticksDrawnByPlayer, $this->view);
			} catch(\Exception $e) {
				$this->message = $this->view->getUnauthorizedMsg(); //fixat html
			}
		}
	}

	private function doGameOver() {
		if ($this->playerStartsOver()) {
			$this->game->newGame();
		}		
	}

	/** 
	* @return boolean
	*/
	private function playerSelectSticks()
	{
		return $this->view->playerSelectSticks(); //fixat bort get
	}
	

	/** 
	* @return boolean
	*/
	private function playerStartsOver() {
		return $this->view->playerStartsOver(); //fixat bort get
	}

	/** 
	* @return \model\StickSelection
	*/
	private function getNumberOfSticks() {
		switch ($this->view->checkGetDraw()) {//fixat bort get
			case 1 : return \model\StickSelection::One(); break; 
			case 2 : return \model\StickSelection::Two(); break;
			case 3 : return \model\StickSelection::Three(); break;
		}
		throw new \Exception("Invalid input");
	}
	
	public function setMsg()
	{
		$this->view->setMsg($this->game->getMsg());
	}
}