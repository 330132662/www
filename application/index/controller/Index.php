<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\model\Banner;
use app\common\model\Category;
use app\common\model\Config;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
//   轮播图
        $banners = Banner::all();
        $this->assign("banners", $banners);
        $goodCond["cate_id"] = array("in", "3,4,14,19,20"); // 加载目前所有商品类别id下的商品  取最新 五条
        $goods = \app\common\model\Article::where($goodCond)->order("id", "desc")->limit(5)->select();

        $newsCond["cate_id"] = 12;
        $news = \app\common\model\Article::where($newsCond)->order("id", "desc")->limit(5)->select();
        $this->assign("goods", $goods);
        $this->assign("news", $news);
        return $this->view->fetch();
    }
    /*** /index/index/index1
     * @return string
     * @throws \think\Exception
     */
    /*public function index1()
    {
        return $this->view->fetch();
    }*/

    /* 单页区 */
    /* 公司简介 */
    function about()
    {
        $data = Config::get(18);
        $this->assign("data", $data);
        return $this->view->fetch();
    }

}
