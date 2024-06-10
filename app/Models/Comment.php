<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function get_list() {
        $innerQuery = DB::table('products as pd')
            ->join('comments as cmt', 'pd.id', '=', 'cmt.id_pd')
            ->select('pd.id', 'pd.name', DB::raw('COUNT(cmt.id_pd) as luot'), 'cmt.id_us')
            ->groupBy('pd.id', 'pd.name', 'cmt.id_us');

        $result = DB::table(DB::raw("({$innerQuery->toSql()}) as TB"))
            ->mergeBindings($innerQuery)
            ->select('TB.id', 'TB.name', DB::raw('SUM(TB.luot) as cmts'), DB::raw('COUNT(TB.id_us) as users'))
            ->groupBy('TB.name', 'TB.id')
            ->get();

        return $result;
    }
}
