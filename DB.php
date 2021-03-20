<?php 
/**
 * Database live search with Javascript fetch() and a PHP backend
 * 
 * Copyright (C) 2021 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 *
 * @author BITJUNGLE Rune Mathisen <devel@bitjungle.com>
 */
class DB extends PDO {
    private $_ini;

    /**
     * Create a new DB object
     * 
     * @param string $file INI file name.
     */
    public function __construct($file = 'settings.ini') {
        $this->_ini = parse_ini_file($file, true);

        $dsn = $this->_ini['db']['driver'] . 
        ':dbname=' . $this->_ini['db']['dbname'] .
        ';host=' . $this->_ini['db']['host'];
        
        parent::__construct($dsn, $this->_ini['db']['user'], $this->_ini['db']['passwd']);

    }

    /**
     * Select all data in the database table
     * 
     * @return array|false
     */
    public function getAllData() {
        $query = "SELECT * FROM {$this->_ini['db']['table']} ";
        $query .= "ORDER BY {$this->_ini['db']['descfield']} ASC;";
        $stmt = $this->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Search the database table descfield and idxfield
     * 
     * @param string $str The search string
     * @return array|false
     */
    public function searchData($str) {
        $query = "SELECT {$this->_ini['db']['idxfield']}, "
               . "{$this->_ini['db']['descfield']}, {$this->_ini['db']['urlfield']} "
               . "FROM {$this->_ini['db']['table']}  "
               . "WHERE {$this->_ini['db']['descfield']} LIKE :search_string  "
               . "OR {$this->_ini['db']['idxfield']} LIKE :search_string  "
               . "ORDER BY {$this->_ini['db']['descfield']} ASC;";
        $stmt = $this->prepare($query);
        $stmt->execute(['search_string' => "%{$str}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return info on database table name and field names
     * 
     * @return array
     */
    public function getDbInfo() {
        return [
            'table' => $this->_ini['db']['table'],
            'descfield' => $this->_ini['db']['descfield'],
            'idxfield' => $this->_ini['db']['idxfield'],
            'urlfield' => $this->_ini['db']['urlfield']
        ];
    }
}

?>