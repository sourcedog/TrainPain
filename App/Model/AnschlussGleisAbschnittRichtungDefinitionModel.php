<?php

namespace Model;

class AnschlussGleisAbschnittRichtungDefinitionModel extends Model
{
    protected $table = 'Anschluss_Tab'
    protected $id = 'GARD_ID';
    protected $data;

    public function __construct()
    {
        $this->data = array(
            'GARD_ID' => null,
            'AGARD_ID' => null
        );

        parent::__construct();
    }
}
