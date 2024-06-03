<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'Comments';
    protected $primaryKey = 'id';
    protected $fillable = ['content', 'id_pd', 'id_us', 'date'];
    public $timestamps = false;

    public static function get_ct($data) {
        return self::join('users','comments.id_us','=','users.id')
            ->where('id_pd',$data)
            ->orderBy('comments.id','DESC')
            ->get();
    }

    public static function add_cmt($cmt, $idp, $uid, $date) {
        self::create([
            'content' => $cmt,
            'id_pd' => $idp,
            'id_us' => $uid,
            'date' => $date
        ]);
    }
}
