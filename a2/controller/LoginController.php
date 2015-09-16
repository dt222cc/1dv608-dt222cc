<?php

class LoginController {
    
    /**
     * Location for Redirect, have one for the local(cloud9) server and another for the public server
     * @var String
     */
    private static $headerLocation = "location: /a2/index.php"; //c9 (local)
    // private static $headerLocation = "location: /portfolio/1dv608-a2/index.php"; //public
    
    /**
     * @var \model\LoginModel
     */
    private $login;
    
    /**
     * @var \view\LoginView
     */
    private $loginView;
    
    /**
     * @var \view\DateTimeView
     */
    private $dateTimeView;
    
    /**
     * @var \view\LayoutView
     */
    private $layoutView;
    
    public function __construct(LoginModel $login) {
        $this->login = $login;
        $this->loginView = new LoginView($this->login);
        $this->dateTimeView = new DateTimeView();
        $this->layoutView = new LayoutView();
    }
    
    /**
    * If user just submitted a LOGIN form or a LOGOUT form
    * Checks if user is logged in or not, process data from form, toggles loginState
    * @return void, BUT writes the response message from the results
    */
    public function doLogin() {
        if (!$this->login->getIsLoggedIn()) {
            if (isset($_POST['LoginView::Login'])) {
                if (empty($_POST['LoginView::UserName'])) {
                    $this->login->changeMessage("Username is missing");
                } elseif (empty($_POST['LoginView::Password'])) {
                    $this->login->changeMessage("Password is missing");
                } elseif ($_POST['LoginView::UserName'] == "Admin" && $_POST['LoginView::Password'] == "Password") {
                    $this->login->changeMessage("Welcome");
                    $this->login->toggleIsLoggedIn();
                    header(self::$headerLocation);
                    exit(); // For manual testing (or else the "Welcome" text is missing). Note: Conflicts with auto test (causes errors: 1.7, 1.8, 1.8.1).
                } else {
                    $this->login->changeMessage("Wrong name or password");
                }
            }
        } else {
            if (isset($_POST['LoginView::Logout'])) {
                $this->login->changeMessage("Bye bye!");
                $this->login->toggleIsLoggedIn();
                header(self::$headerLocation);
                exit(); // For manual testing (or else the "Bye bye!" text is missing). Note: Conflicts with auto test (causes errors: 2.1, 2.4).
            }
        }
    }
    
    /**
     * Renders the view/s
     */
    public function getHTML() {
        $this->layoutView->render($this->login->getIsLoggedIn(), $this->loginView, $this->dateTimeView);
    }
}