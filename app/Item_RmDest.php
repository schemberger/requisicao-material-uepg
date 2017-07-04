<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_RmDest extends Model
{

    protected $table = 'ITEM_RMDEST';

    public $timestamps = false;

    protected $primaryKey = 'NR_RM, ANO_RM, CD_CENTRO, NR_ITEM, NR_ITEM_DESTINO';

}
