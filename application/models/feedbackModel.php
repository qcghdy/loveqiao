<?php
/**
 * Created by JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-28
 * Time: 上午9:47
 * To change this template use File | Settings | File Templates.
 */
class FeedbackModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
    }

    //用户提交反馈建议
    public function submit(){
        //参数
        $username = urldecode($this->input->post("username", true));
        $email = urldecode($this->input->post("email"));
        $feedback = urldecode($this->input->post("feedback", true));
        //访问数据库，插入数据
        $insertId = null;
        date_default_timezone_set('Asia/Shanghai');
        $feedbackInfo = array(
            'username' => $username
            ,'email' => $email
            ,'feedback' => empty($feedback) ? " " : $feedback
            ,'type' => 0//已发布
            ,'feedbacktime' => date("Y-m-d H:i:s") //只有"Y-m-d h:i:s"这个固定的字符串才能得到2013-03-15 09:24:48这样的值
        );
        $this->db->insert('feedback', $feedbackInfo);   //便捷插入
        return $this->db->insert_id();
    }

    //拉取反馈列表
    public function getFeedbackList(){
        $type = $this->input->get("type", TRUE);
        $typeArray = [0, 1];
        $type = empty($type) || !isset($typeArray[(int)$type]) ? 0 : (int)$type;
        $sql = "select * from feedback where type = ? order by feedbacktime desc";
        $query = $this->db->query($sql, $type);
        if($query->num_rows() > 0){
            $rows = $query->result_array();
            return array('feedbacks' => $rows);
        }else{
            return false;
        }
    }

    //这种批量的写法，参考的是http://codeigniter.org.cn/user_guide/database/active_record.html#update，但是修改了源码 DB_active_rec.php:$not[] = $k2.'-'.$v2;
    public function batchSetFeedbackRead0(){
        $feedbackid = $this->input->get("fbid", TRUE);
        $feedbackIdArray = explode('+',$feedbackid);
        $data = array();
        foreach($feedbackIdArray as $fbArray){
            $data[] = array('feedbackid' => (int)$fbArray,'type' => 1);
        }
        $this->db->update_batch('feedback', $data, 'feedbackid');

        return;
    }

    public function batchSetFeedbackRead(){
        $feedbackid = $this->input->get("fbid", TRUE);
        $feedbackIdArray = explode('+',$feedbackid);

        $this->db->where_in('feedbackid', $feedbackIdArray);
        $this->db->set('type', 1 ,FALSE);//第三个参数($escape)，如果此参数被设置为 FALSE，就可以阻止数据被转义。denniszhu注：通常需要设置为FALSE
        $this->db->update('feedback');

        return true;
    }
    //这种批量的写法，参考的是http://codeigniter.org.cn/forums/forum.php?mod=viewthread&tid=15195
    public function batchDeleteFeedback(){
        $feedbackid = $this->input->get("fbid", TRUE);
        $feedbackIdArray = explode('+',$feedbackid);

        $this->db->where_in('feedbackid', $feedbackIdArray);
        $this->db->delete('feedback');

        return true;
    }
}
