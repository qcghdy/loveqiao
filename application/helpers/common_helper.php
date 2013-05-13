<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-15
 * Time: 下午3:30
 * To change this template use File | Settings | File Templates.
 */

//自定义的分页，对于代码中的每一个参数设置，请参考//http://codeigniter.org.cn/user_guide/libraries/pagination.html#
//1、【上一页】、【起始链接】等等链接都是在我们定义的开始标签和结束标签中间，ci给自动插入一段<a>...</a>代码；但是【当前页】中，是在我们定义的开始标签和结束标签中间直接插入数字。这一点需要注意
//2、 $config['use_page_numbers'] = TRUE;这一项设置需要注意。默认分页URL中是显示每页记录数,启用use_page_numbers后显示的是当前页码，如下：
//      不启用：http://example.com/index.php/test/page/20：这里的20代表每页记录20条，
//      启用后：http://example.com/index.php/test/page/20  这里的20代表当前页为第20页，
//    <ul>
//        <li>
//            <a href="#">前一页</a>
//        </li>
//        <li class="active">
//            <a href="#">1</a>
//        </li>
//        <li>
//            <a href="http://localhost/loveqiao/blog?&p=2">2</a>
//        </li>
//        <li>
//            <a href="?p=3">3</a>
//        </li>
//        <li>
//            <a href="#">4</a>
//        </li>
//        <li>
//            <a href="#">后一页</a>
//        </li>
//    </ul>
function makePagination($total) {
    $this->load->library('pagination');
    $config['base_url'] = base_url("blog") . "?";
    $config['total_rows'] = 40;
    $config['per_page'] = 2;

//        $config['uri_segment'] = 1;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'p';

    //添加封装标签,如果你希望在整个分页周围围绕一些标签，你可以通过下面的两种方法：
    $config['full_tag_open'] = '<ul>';      //把打开的标签放在所有结果的左侧。
    $config['full_tag_close'] = '</ul>';    //把关闭的标签放在所有结果的右侧。

    //自定义起始链接.
    $config['first_link'] = FALSE;
//        $config['first_link'] = 'First';      //你希望在分页的左边显示“第一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
//        $config['first_tag_open'] = '<ul>';  //“第一页”链接的打开标签。
//        $config['first_tag_close'] = '</ul>';//“第一页”链接的关闭标签。

    //自定义“上一页”链接
    $config['prev_link'] = '前一页';   //你希望在分页中显示“上一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';

    //自定义“当前页”链接
    $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
    $config['cur_tag_close'] = '</a></li>';

    //自定义“数字”链接
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    //自定义“下一页”链接
    $config['next_link'] = '后一页';   //你希望在分页中显示“下一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';

    //自定义结束链接
    $config['last_link'] = FALSE;
//        $config['last_link'] = 'Last';      //你希望在分页的右边显示“最后一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
//        $config['last_tag_open'] = '<ul>';  //“最后一页”链接的打开标签。
//        $config['last_tag_close'] = '</ul>';//“最后一页”链接的关闭标签。

    $this->pagination->initialize($config);

    return $this->pagination->create_links();
}