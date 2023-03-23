<?php

namespace yusovmax;

// use PDO;
// use FFI\Exception;
// use yusovmax\databaseSettings as dbconf;

class database
{
    private $host = databaseSettings::HOST;
    private $dbname = databaseSettings::DBNAME;
    private $username = databaseSettings::USERNAME;
    private $password = databaseSettings::PASSWORD;
    private $tables = databaseSettings::TABLES;
    private $charset = 'utf8';
    private $mysqli;


    public function __construct()
    {
        try {
            $this->mysqli = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
        } catch (\Exception $e) {
            echo "Не удалось подключиться к MySQL: " . $e->getMessage();
            die();
        }
    }

    public function CheckTable($tableName)
    {
        $dbh = $this->mysqli;
        $sql = $dbh->prepare('SHOW TABLES LIKE ?');
        $res = $sql->execute(array($tableName));
        $res = $sql->fetchAll();
        return (!empty($res));
    }

    public function CreateTable($tableName, $fields)
    {
        $dbh = $this->mysqli;
        $query = "CREATE TABLE `" . $tableName . "` 
            ( " . $fields . "
            ) 
            ENGINE = InnoDB;";
        $res = $dbh->query($query);
        return ($res);
    }

    public function addCheck($datacheck)
    {
        $dbh = $this->mysqli;
        $sql = $dbh->prepare("SELECT `category_id` FROM `" . $this->tables["category"] . "` WHERE `category_name` = ?");
        if ($sql->execute([htmlspecialchars(trim($datacheck["category"]))])) {
            if ($res = $sql->fetch(\PDO::FETCH_LAZY)) {
                $sql = $dbh->prepare("INSERT INTO " . $this->tables["check"] . " (product_name, category_id, sum, date) VALUES (?,?,?,?)");
                if ($sql->execute([
                    htmlspecialchars(trim($datacheck["product_name"])),
                    $res->category_id,
                    floatval(str_replace(",", ".", $datacheck["price"])),
                    $datacheck["date"],
                ])) {
                    return $this->listCheck();
                } else {
                }

                return $res->category_id;
            } else {
                return "Категория " . $datacheck["category"] . " не найдена";
            }
        } else {
            return ("Error updating record: " . $dbh->errorInfo());
        }

        // return ($datacheck);
    }

    public function AddCategory($name, $ruName)
    {
        # INSERT INTO `umi9956`.`mycache_category` (`ID`, `NAME`, `RU_NAME`) VALUES (NULL, 'eda', 'Еда');
    }

    public function listCheck()
    {
        $dbh = $this->mysqli;
        try {
            $query = "SELECT * FROM " . "`mycache_check`" . " ORDER BY `date` DESC";
            $query2 = "SELECT * FROM " . $this->tables["check"] . " LEFT JOIN " . $this->tables["category"] . " USING (category_id) ORDER BY `date` DESC, `check_id` DESC";
            $query3 = "SELECT * FROM ? ORDER BY `date` DESC";
            $sql  = $dbh->prepare($query2);
        } catch (\Throwable $th) {
            //throw $th;
            return ($th->getMessage());
        }
        try {
            $sql->execute();
            while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
                $res[] = ($row);
                //echo "<br>";
            }
            return ($res);
        } catch (\Throwable $th) {
            return ($this->tables["check"] . "<br>" . $th->getMessage() . "<br>" . $th->getLine());
        }
    }

}
