<?php

namespace Model;

class Model
{
    protected $db;
    protected $table = '';
    protected $data = array();
    protected $id = 'ID';

    static function wrap($str)
    {
        $str = "'".$str."'";
        return $str;

    }

    public function __construct()
    {
        $this->db = \Clix\ClixMySQL::getSingleton();
    }

    public function set($data = array())
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function save() {

        $sql = 'INSERT INTO ' . $this->table . ' SET ' . $this->createSet() . ' ON DUPLICATE KEY UPDATE ' . $this->createSet();
        $this->db->query($sql);

        return $this;
    }

    public function loadById($id) {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->id . '=' . (int)$id;
        $_data = $this->db->fetchRow($sql);
        $this->data = array_merge($this->data, $_data);

        return $this;
    }

    protected function createSet()
    {
        $_data = array();
        $array = $this->data;

        foreach($array as $key => $val) {
            $_data[] = $key . "='".$val."'";
        }

        return implode(',', $_data);
    }

}