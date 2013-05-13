<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-2-26
 * Time: 下午4:17
 * To change this template use File | Settings | File Templates.
 */
require_once APPPATH . 'libraries/phpQuery/phpQuery.php';

define("PAGESIZE", 3); //Word amount of the Briefing of an Article

class BlogModel extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
    }

    public function spider(){
        phpQuery::newDocumentFile('http://news.sina.com.cn/china');
        return pq(".blkTop h1:eq(0)")->html();
    }

    /**
     * 碎碎念发布
     * 返回的是新插入db的碎碎念id
     */
    public function submitBlog(){
        //参数
        $token = urldecode($this->input->post("token", true));
        $type = urldecode($this->input->post("type", true));
        $myEditor = urldecode($this->input->post("myEditor"));
        $tags = urldecode($this->input->post("tags", true));
        $topic = urldecode($this->input->post("topic", true));
        $title = urldecode($this->input->post("title", true));
        //访问数据库，插入数据
        $insertId = null;
        date_default_timezone_set('Asia/Shanghai');
        $blog = array(
            'title' => $title
            ,'content' => $myEditor
            ,'brief' => $this->generateBrief($myEditor,300) . "..."
            ,'type' => 0//已发布
            ,'userid' => !$this->session->userdata('userid') ? $this->session->userdata('userid') : 5
            ,'topicid' => empty($topic) ? 1 : $topic
            ,'uploadtime' => date("Y-m-d H:i:s") //只有"Y-m-d h:i:s"这个固定的字符串才能得到2013-03-15 09:24:48这样的值
            ,'lastupdatetime' => date("Y-m-d H:i:s")
        );
        $this->db->insert('blog', $blog);   //便捷插入
        return $this->db->insert_id();
    }

    /**
     * 碎碎念更新
     * 返回的是新插入db的碎碎念id
     */
    public function updateBlog(){
        //参数
        $type = urldecode($this->input->post("type", true));
        $myEditor = urldecode($this->input->post("myEditor"));
        $tags = urldecode($this->input->post("tags", true));
        $topic = urldecode($this->input->post("topic", true));
        $title = urldecode($this->input->post("title", true));
        $sid = urldecode($this->input->post("sid", true));
        //访问数据库，插入数据
        date_default_timezone_set('Asia/Shanghai');
        $data = array(
            'title' => $title
            ,'content' => $myEditor
            ,'brief' => $this->generateBrief($myEditor,300) . "..."
            ,'type' => 0//已发布
            ,'topicid' => empty($topic) ? 1 : $topic
            ,'lastupdatetime' => date("Y-m-d H:i:s")
        );

        $this->db->where('blogid', $sid);
        $this->db->update('blog', $data);
        return $sid;
    }
    /**
     * @param $sid
     * @return mixed 通过看ci源代码了解到，调用delete 函数后，会进行一次查询，返回true表示删除成功，返回false表示失败
     */
    public function deleteBlog($sid){
        $this->db->where('blogid', $sid);
        return $this->db->delete('blog');
    }


    //获取碎碎念的完整信息
    public function getSuiSuiNian($sid){
        $sql = "select * from blog where blogid = ?";
        $parameters = array($sid);
        $query = $this->db->query($sql, $parameters);
        if($query->num_rows() > 0){
            $row = $query->result_array();
            return $row[0];
        }else{
            return false;
        }
    }

    public function getSuiSuiList($pageId, $pageSize =  PAGESIZE, $url = "blog"){
        $sql = "select * from blog  order by lastupdatetime desc limit ?,?";
        $parameters = array(($pageId-1) * $pageSize, $pageSize);//默认拉取的条数
        $query = $this->db->query($sql, $parameters);
        if($query->num_rows() > 0){
            $rows = $query->result_array();
            return array('archives' =>$rows, 'pager' =>$this->paging($this->db->count_all('blog'), $pageSize, $url));
        }else{
            return false;
        }
    }


    //生成摘要
    public function generateBrief($content, $size){
        return mb_substr(strip_tags($content),0,$size,'utf-8');
    }


    public function paging($total, $pageSize, $url){
        //http://codeigniter.org.cn/user_guide/libraries/pagination.html#
        $this->load->library('pagination');
        $config['base_url'] = base_url($url) . "?";
        $config['total_rows'] = $total;
//        $config['per_page'] = $pageSize;

        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
}