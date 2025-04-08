<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class Registrierung extends Page
{
    private $message = "";

    protected function __construct()
    {
    
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData():array
    {
        
        
    }

    protected function generateView():void
    {
        $this->generatePageHeader('Registrierung');
        echo '<h1>Registrierung</h1>';
        echo '<nav>';
        echo '<a href="">Home</a>';
        echo '<a href="">Impressum</a>';
        echo '<a href="">Datenschutz</a>';
        echo '</nav>';
        echo '<hr>';
        echo '<h2>Benutzer anlegen</h2>';
        if( $this->message){
            echo '<p>'.htmlspecialchars($this->message).'</p>';
        }
        echo '<form method="post">';
        echo '<div id="eintrag">';
        echo '<input type="text" id="username" name="username" required>';
        echo '<input type="password" id="password" name="password" required>';
        echo '<input type="submit" value="Registrieren" id="schicken" disabled>';
        echo '</div>';
        echo '<p id="nameprüfen"></p>';
        echo '</form>';
        echo '<hr>';
        echo '<h2>Passwortstärke</h2>';
        echo '<p id="starkheit"></p>';
        $this->generatePageFooter();

    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();
        // ein nutzer darf in der Datenbank nur einmal vorkommen
        // password verschlüsseln


        // nutzer in Datenbank eintragen
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
            
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $this->_database->prepare("INSERT INTO user (name, password) VALUES (?, ?)");
            if($stmt){
                $stmt->bind_param('ss', $username, $password);
                if ($stmt->execute()) {
                    $this->message = 'Registrierung erfolgreich!';
                } else {
                    $this->message = 'Fehler bei der Registrierung: ' . $stmt->error;
                }
                $stmt->close();
            } 
        }

    }

    public static function main():void
    {
        try {
            $page = new Registrierung();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Registrierung::main();
