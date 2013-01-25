<?php

namespace Model;

class PunktModel extends Model
{
    protected $table = 'Punkt_Tab';
    protected $id = 'P_ID';

    public function __construct()
    {
        $this->data = array(
            'P_ID' => null,
            'GeoPosX' => null,
            'GeoPosY' => null,
            'Info'    => null
        );

        parent::__construct();
    }
}