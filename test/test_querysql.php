<?php

class MyPDOStatement extends PDOStatement
{
    protected $_debugValues = null;

    protected function __construct()
    {
        // need this empty construct()!
    }

    public function execute($values=array())
    {
        $this->_debugValues = $values;
        try {
            $t = parent::execute($values);
            // maybe do some logging here?
        } catch (PDOException $e) {
            // maybe do some logging here?
            throw $e;
        }

        return $t;
    }

    public function _debugQuery($replaced=true)
    {
        $q = $this->queryString;

        if (!$replaced) {
            return $q;
        }

        return preg_replace_callback('/:([0-9a-z_]+)/i', array($this, '_debugReplace'), $q);
    }

    protected function _debugReplace($m)
    {
        $v = $this->_debugValues[$m[1]];
        if ($v === null) {
            return "NULL";
        }
        if (!is_numeric($v)) {
            $v = str_replace("'", "''", $v);
        }

        return "'". $v ."'";
    }
}

// have a look at http://www.php.net/manual/en/pdo.constants.php
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_STATEMENT_CLASS => array('MyPDOStatement', array()),
);

// create PDO with custom PDOStatement class
$dsn = 'mysql:dbname=laravel5;host=127.0.0.1';
$pdo = new PDO($dsn, "root", "Dl~147456", $options);

// prepare a query
$query = $pdo->prepare("INSERT INTO users (`name`, `email`, `password`)
    VALUES (:col1, :col2, :col3)");

// execute the prepared statement
$query->execute(array(
    'col1' => "hello world",
    'col2' => "a@qq.com",
    'col3' => "111111",
));

// output the query and the query with values inserted
var_dump( $query->queryString, $query->_debugQuery() );
