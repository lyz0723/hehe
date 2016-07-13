<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
class We_rule extends Model{
    public function add($name,$type,$content,$key){
        $array=array('r_name'=>$name,
            'r_type'=>$type,
            'r_content'=>$content,
            'r_key'=>$key,
            'p_id'=>Session::get('p_id'),
            'uid'=>Session::get('uid'),
        );
       $insert=DB::table('we_rule')->insert($array);
        //print_r($insert);
        return $insert;
    }
}
?>