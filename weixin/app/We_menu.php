<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class We_menu extends Model
{
    protected $table = 'we_menu';
    //递归左侧菜单栏
    public function main()
    {
        $arr=DB::table('we_menu')->where('f_id',0)->where('p_id',1)->get();
        foreach($arr as $key=>$val){
            $ar=DB::table('we_menu')->where('f_id',$val->m_id)->where('p_id',1)->get();
            if(!empty($ar)){
                $arr[$key]->two=$ar;
                foreach($ar as $key=>$val){
                    $arl=DB::table('we_menu')->where('f_id',$val->m_id)->where('p_id',1)->get();
                    if(!empty($arl)){
                        $arr[$key]->two=$arl;
                    }
                }
            }
        }
        return $arr;
    }
    //递归左侧菜单栏基本设置
    public function cai(){
        $arr=DB::table('we_menu')->where('f_id',0)->where('p_id',0)->get();
        foreach($arr as $key=>$val){
            $ar=DB::table('we_menu')->where('f_id',$val->m_id)->where('p_id',0)->get();
            if(!empty($ar)){
                $arr[$key]->two=$ar;
                foreach($ar as $key=>$val){
                    $arl=DB::table('we_menu')->where('f_id',$val->m_id)->where('p_id',0)->get();
                    if(!empty($arl)){
                        $arr[$key]->two=$arl;
                    }
                }
            }
        }
        return $arr;
    }
}
?>