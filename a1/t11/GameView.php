<?php

class GameView {
	/**
	 * creates a GameView object
	 * 
	 * @param Gamer $toBeViewed 
	 */
	public function __construct(Gamer $toBeViewed) {
		$this->gamer = $toBeViewed;
	}

	/**
	 * echoes a simple HTML representation of the Gamer object ot the output buffer
	 * 
	 * @return void
	 */
	public function show() {

		echo $this->toHTML();
	}

	/**
	 * toHTML creates a simple HTML representation of a Gamer and games
	 * 
	 * @return String HTML
	 */
	public function toHTML() {
		//change this code
		$ret = "
<div>
	<h1>Gamer: {$this->gamer->getNick()}</h1>
	<p>
		Email: <a href='mailto:{$this->gamer->getEmail()}'>{$this->gamer->getEmail()}</a>
	</p>
	<h2>Games</h2>
	
	<ul>
		{$this->gamer->getGames()}
	</ul>
</div>	

";
		return $ret;
	}
}