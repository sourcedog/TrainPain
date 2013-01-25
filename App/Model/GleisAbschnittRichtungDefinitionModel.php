<?php

namespace Model;

class GleisAbschnittRichtungDefinitionModel extends Model
{
    protected $table = 'GleisAbschnittRichtungDefinition_Tab';
    protected $id = 'GARD_ID';
    protected $data;

    public function __construct()
    {
        $this->data = array(
            'GARD_ID'       => null,
            'Abschnitt_ID'  => null,
            'Richtung'      => null,
            'StartPunkt_ID' => null
        );

        parent::__construct();
    }
}
