<?php

namespace Model;

class AbschnittModel extends Model
{
    protected $table = 'Abschnitt_Tab';
    protected $id = 'Abschnitt_ID';
    protected $data;

    public function __construct()
    {
        $this->data = array(
            'Abschnitt_ID' => null,
            'AbschnittName' => null
        );

        parent::__construct();
    }
}