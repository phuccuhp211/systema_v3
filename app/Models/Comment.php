<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'Comments';

    public static function get_ct($data) {
        return self::join('uss','comments.id_us','=','uss.id')
                ->where('id_pd',$data)
                ->orderBy('date','DESC')
                ->get();
    }

}
