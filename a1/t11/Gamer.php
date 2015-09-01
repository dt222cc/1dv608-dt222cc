<?php
class Gamer {
	/**
	 * private members, these should not be made public!
	 * @var String
	 */
	private $nick;
	private $email;		
	private $clan;
	private $clanTag;

	/**
	 * @var array of Game objects
	 */
	private $games = array();

	/**
	 * creates a gamer object
	 * @param String $nick    Gamer nickname
	 * @param String $email   gamer email adress
	 * @param String $clan    gamer clan name
	 * @param String $clanTag gamer clan tag
	 */
	public function __construct($nick, $email, $clan, $clanTag) {
		$this->nick = $nick;
		$this->email = $email;
		$this->clan = $clan;
		$this->clanTag = $clanTag;
	}

	/**
	 * adds a game to the gamers collection
	 * 
	 * @param Game $gameToAdd
	 */
	public function add(Game $gameToAdd) {
		$this->games[] = $gameToAdd;
	}
	
	/**
	 * access methods (getters)
	 */
	public function getNick() {
		return $this->nick;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getClan() {
		return $this->clan;
	}
	
	public function getClanTag() {
		return $this->clanTag;
	}
	
	/**
	 * returns a list of games
	 * 
	 * the array games has objects the public "Game" methods
	 */
	 
	public function getGames() {
		foreach ($this->games as $game){
			$re .= "<li>{$game->getManufacturer()}: {$game->getTitle()}</li>";
		}
		return $re;
	}
}