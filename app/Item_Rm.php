<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_Rm extends Model
{

    protected $table = 'ITEM_RM';

    public $timestamps = false;

    protected $primaryKey = 'NR_RM, ANO_RM, CD_CENTRO, NR_ITEM';

}
