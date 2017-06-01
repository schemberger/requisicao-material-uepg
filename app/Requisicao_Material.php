<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class REQUISICAO_MATERIAL extends Model
{

    protected $table = 'REQUISICAO_MATERIAL';

    public $timestamps = false;

    protected $primaryKey = 'NR_RM, ANO_RM, CD_CENTRO';

}
