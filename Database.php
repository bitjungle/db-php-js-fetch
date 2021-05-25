<?php 
/**
 * Database live search with Javascript fetch() and a PHP backend
 * 
 * CREATE TABLE `Fagkoder` (
 *   `kode` varchar(8) NOT NULL,
 *   `uri` varchar(32) NOT NULL,
 *   `urldata` varchar(64) NOT NULL,
 *   `fagnavn` varchar(255) NOT NULL,
 *   `sistendret` datetime NOT NULL,
 *   `gyldigfra` date NOT NULL,
 *   `gyldigtil` date DEFAULT NULL,
 *   PRIMARY KEY (`kode`),
 *   KEY `fagnavn` (`fagnavn`(191))
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 * 
 * Copyright (C) 2021 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 *
 * @author  BITJUNGLE Rune Mathisen <devel@bitjungle.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU GPLv3
 */
class Database extends PDO 
{
    private $_ini;

    /**
     * Create a new DB object
     * 
     * @param string $file INI file name.
     */
    public function __construct($file = '/path/to/settings.ini') 
    {
        $this->_ini = parse_ini_file($file, true);

        $dsn = $this->_ini['db']['driver'] . 
        ':dbname=' . $this->_ini['db']['dbname'] .
        ';host=' . $this->_ini['db']['host'];
        
        parent::__construct(
            $dsn, 
            $this->_ini['db']['user'], 
            $this->_ini['db']['passwd']
        );
    }

    /**
     * Select all data in the database table
     * 
     * @return array|false
     */
    public function getAllData() 
    {
        $query = 'SELECT * FROM Fagkoder ORDER BY fagnavn ASC;';
        $stmt = $this->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Search the database for a specific string
     * 
     * @param string $str The search string
     * 
     * @return array|false
     */
    public function searchData($str) 
    {
        $query = 'SELECT kode, fagnavn, urldata FROM Fagkoder 
                  WHERE fagnavn LIKE :search_string  
                  OR kode LIKE :search_string  
                  ORDER BY fagnavn ASC;';
        $stmt = $this->prepare($query);
        $stmt->execute(['search_string' => "%{$str}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>