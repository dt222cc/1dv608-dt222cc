/**
 * toString returns a human readable String from the book object.
 * 
 * @uses  http://se1.php.net/manual/en/function.strip-tags.php
 * 
 * @return String
 */

public function toString() {
	return strip_tags("$this->title by $this->author, for $this->price SEK");
}

/**
 * input:  $myBook = new Book("J. K. Rowling", "Harry Potter and the Philosopher's Stone", 150);
 *         echo $myBook->toString();
 *
 * output: Harry Potter and the Philosopher's Stone by J. K. Rowling, for 150 SEK
 */