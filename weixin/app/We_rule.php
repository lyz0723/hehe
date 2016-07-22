<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
class We_rule extends Model{
    public function add($name,$type,$content,$key,$title,$image,$i_content,$url){
        $array=array('r_name'=>$name,
            'r_type'=>$type,
            'r_content'=>$content,
            'r_key'=>$key,
            'p_id'=>Session::get('p_id'),
            'uid'=>Session::get('uid'),
        );


       if($r_id=DB::table('we_rule')->insertGetId($array)){
           //echo $r_id;
           $array1=array(
               'i_title'=>$title,
               'i_image'=>$image,

               'i_content'=>$i_content,
               'i_url'=>$url,
               'rid'=>$r_id
           );

           $insert=DB::table('we_img')->insert($array1);
       }
        //print_r($insert);
        return $insert;
    }
}
?>