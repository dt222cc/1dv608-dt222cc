<?php

class Game {
	/**
	 * private members, these should not be made public!
	 * @var String
	 */
	private $title;
	private $manufacturer;
	private $maxPlayers;

	/**
	 * creates a Game object
	 * 
	 * @param String $title        Name of the game
	 * @param String $manufacturer Name of the game-maker
	 * @param Integer $maxPlayers   Number of players in a session
	 */
	public function __construct($title, $manufacturer, $maxPlayers) {
		$this->title = $title;
		$this->manufacturer = $manufacturer;
		$this->maxPlayers = $maxPlayers;
	}
	
	/**
	 * access methods (getters)
	 */
	public function getTitle() {
		return $this->title;
	}
	
	public function getManufacturer() {
		return $this->manufacturer;
	}
}