<?php
namespace common\models\base;

use yii\db\ActiveRecord;

/**
 * @Created by PhpStorm.
 * @Desc:
 * @Author: panyuting
 * @Date: 2016/11/25 9:33
 */
class Base extends ActiveRecord
{
    /**
     * @Description:获取分页数据
     * @Params:
     * @Return:
     * @Author: 潘玉婷 @panyuting
     * @Date: 2016/12/1 10:12
     * @Version 2.0
     */
    public function getPages($query,$curPage = 1 ,$pageSize = 10 ,$search=null)
    {
        if ($search)
            $query = $query->andFilerWhere($search);

        $data['count']= $query->count();
        if (!$data['count'])
        {
            return ['count'=>0,'curPage'=>$curPage ,'pageSize'=>$pageSize ,'start'=>0,'end'=>0,'data'=>[]];
        }

        //超过实际页数，不取curPage为当前页
        $curPage = (ceil($data['count']/$pageSize)<$curPage)?ceil($data['count']/$pageSize):$curPage;

        //当前页
        $data['curPage'] = $curPage;
        //每页显示条数
        $data['pageSize'] = $pageSize;
        //起始页
        $data['start']=($curPage - 1)*$pageSize+1;
        //末页
        $data['end']=(ceil($data['count']/$pageSize)==$curPage)?$data['count']:($curPage - 1)*$pageSize+$pageSize;
        //数据
        $data['data']=$query->offset(($curPage - 1)*$pageSize)->limit($pageSize)->asArray()->all();

        return $data;
    }

}