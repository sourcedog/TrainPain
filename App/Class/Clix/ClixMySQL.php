<?php

namespace Clix;

class ClixMySQL extends \Base
{

    protected static $instance;

    protected $db;

    public function __construct()
    {
        $this->config = ClixConfig::getSingleton()->getData();

        if (!$this->db = mysql_connect(
            $this->config['mysql']['host'],
            $this->config['mysql']['username'],
            $this->config['mysql']['password']
        )) {
            throw new ClixMySQLException("Can't connect to MySQL server on '{$this->config['mysql']['host']}' with username '{$this->config['mysql']['username']}'.");
        }
        if (!mysql_select_db($this->config['mysql']['dbname'], $this->db)) {
            throw new ClixMySQLException("Can't open database schema '{$this->config['mysql']['dbname']}'.");
        }
        if (!empty($this->config['mysql']['charset'])) {
            $this->query("SET NAMES {$this->config['mysql']['charset']}");
        }
    }

    public function query($sql)
    {
        if (!$res=mysql_query($sql, $this->db)) {
            throw new ClixMySQLException("Error while executing query: ".mysql_error($this->db));
        }
        return $res;
    }

    public function fetchRow($sql)
    {
        if ($res = $this->query($sql)) {
            if ($row = mysql_fetch_assoc($res)) {
                return $row;
            } else {
                return false;
            }
        }
    }

    public function fetchOne($sql)
    {
        if ($row = $this->fetchRow($sql)) {
            return reset($row);
        }
        return false;
    }

    public function fetchAll($sql)
    {
        if ($res = $this->query($sql)) {
            $ret = array();
            while ($row = mysql_fetch_assoc($res)) {
                $ret[] = $row;
            }
            return $ret;
        }
    }

    public function quote($text)
    {
        return "'".mysql_escape_string($text)."'";
    }

}

