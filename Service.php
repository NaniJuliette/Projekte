<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class ExamService extends Page
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
        $stmt = $this->_database->prepare("SELECT name FROM user");
        $stmt->execute();
        $result = $stmt->get_result();
        if(!$result){
            throw new Exception("Error: " . $this->_database->error);
        }
        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        $stmt->close();
        return $data;
        
        
    }

    protected function generateView():void
    {
        $data = $this->getViewData();
        $this->generatePageHeader('Exam');
        
        echo '<h1>H_DA - Registrierung</h1>';
        echo '<nav>';
        echo '<a href="">Home</a>';
        echo '<a href="">Impressum</a>';
        echo '<a href="">Datenschutz</a>';
        echo '</nav>';
        echo '<hr>';
        echo '<h2>Alle registrierten Nutzer</h2>';
        $i = 1;
        foreach($data as $user){
            echo '<p>'.$i.'. '.htmlspecialchars($user['name']).'</p>';
            $i++;
        }

        
        $this->generatePageFooter();

    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();

    }

    public static function main():void
    {
        try {
            $page = new ExamService();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

ExamService::main();
