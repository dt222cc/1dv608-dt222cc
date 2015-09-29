<?php

class LayoutView {
  
  private static $registerURL = "register";
  private $actualLink;

  public function render($isLoggedIn, LoginView $v, RegisterView $r, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login dt222cc</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->getLink() . '
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          <div class="container">
              ' . $this->getResponse($v, $r) . '
              ' . $dtv->show() . '
          </div>

          <div>
            <em>This site uses cookies to improve user experience. By continuing to browse the site you are agreeing to our use of cookies.</em>
          </div>
         </body>
      </html>
    ';
  }

  /**
   * @return link to register or login
   */
  private function getLink() {
    if (isset($_GET[self::$registerURL]) == false) {
      return '<a href="?' . self::$registerURL . '">Register a new user</a>';
    }
    else {
      return '<a href="index.php">Back to login</a>';
    }
  }

  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  /**
   * @return login form or register form
   */
  private function getResponse($loginView, $registerView) {
    if (isset($_GET[self::$registerURL]) == true) {
      return $registerView->response();
    } else {
      return $loginView->response();
    }
  }
}