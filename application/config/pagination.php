<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-4-11
 * Time: 下午2:45
 * To change this template use File | Settings | File Templates.
 */
//        $config['uri_segment'] = 1;
$config['use_page_numbers'] = TRUE;
$config['page_query_string'] = TRUE;
$config['query_string_segment'] = 'p';

$config['per_page'] = 5;
$config['num_links'] = 10;

//添加封装标签,如果你希望在整个分页周围围绕一些标签，你可以通过下面的两种方法：
$config['full_tag_open'] = '<ul>';      //把打开的标签放在所有结果的左侧。
$config['full_tag_close'] = '</ul>';    //把关闭的标签放在所有结果的右侧。

//自定义起始链接.
//        $config['first_link'] = FALSE;
//        $config['first_link'] = 'First';      //你希望在分页的左边显示“第一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
//        $config['first_tag_open'] = '<ul>';  //“第一页”链接的打开标签。
//        $config['first_tag_close'] = '</ul>';//“第一页”链接的关闭标签。

$config['first_link'] = '第一页';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

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
//        $config['last_link'] = FALSE;
//        $config['last_link'] = 'Last';      //你希望在分页的右边显示“最后一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
//        $config['last_tag_open'] = '<ul>';  //“最后一页”链接的打开标签。
//        $config['last_tag_close'] = '</ul>';//“最后一页”链接的关闭标签。

$config['last_link'] = '最后一页';      //你希望在分页的右边显示“最后一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
$config['last_tag_open'] = '<li>';  //“最后一页”链接的打开标签。
$config['last_tag_close'] = '</li>';//“最后一页”链接的关闭标签。