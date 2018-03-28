<?php
class Test extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        // 数据表名定义常量
        define('TABLE_NAME', 'my_table');

        // 数据库
        $this->load->database();
    }

    private function _ajax_output($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function index(){

        // 执行select时返回受影响的行数
        //$query->num_rows()

        // 返回新插入行的ID
        //$this->db->insert_id();

        // 执行insert update时返回受影响的行数
        //$this->db->affected_rows();

        // 返回上一次执行的查询语句
        //$this->db->last_query();

        // 返回数据表的总行数
        //$this->db->count_all('my_table');
    }

    public function getlist()
    {
        // 获取表单数据
        $page_num   = (int)$this->input->get('pageNum');
        $page_size  = (int)$this->input->get('pageSize');
        $name       = (string)$this->input->get('name');
        $email      = (string)$this->input->get('email');

        // 数据库
        //$sql = 'SELECT id, name, title, email FROM my_table';
        //$query = $this->db->query($sql);
        //$this->db->select('id,name');

        // where子句
        /*if (!empty($name)) {
            $this->db->where('name', $name);
        }*/

        /*if (!empty($email)) {
            $this->db->where('email', $email);
        }*/

        // like子句
        if (!empty($name)) {
            $this->db->like('name', $name);
        }

        if (!empty($email)) {
            $this->db->like('email', $email);
        }

        // select
        $query = $this->db->get(TABLE_NAME, $page_size, ($page_num - 1) * $page_size);

        // 获取上一条查询语句
        $sqlstr = $this->db->last_query();

        // 查询总条数
        $total_line = $this->db->count_all(TABLE_NAME);

        // 接口返回值组装
        $this->data['data']['pageNum']    = $page_num;
        $this->data['data']['pageSize']   = $page_size;
        $this->data['data']['realLine']   = $query->num_rows();
        $this->data['data']['totalLine']  = $total_line;
        $this->data['data']['totalPage']  = ceil($total_line / $page_size);
        $this->data['data']['dataList']   = $query->result();
        $this->data['retMsg']             = '获取成功';
        $this->data['retCode']            = 200;
        $this->data['sql'] = $sqlstr;

        $this->_ajax_output($this->data);
    }

    public function add()
    {
        // 获取表单数据
        $name   = $this->input->post('name');
        $title  = $this->input->post('title');
        $email  = $this->input->post('email');

        $data = array(
            'name'  => $name,
            'title' => $title,
            'email' => $email
        );

        // insert into
        $sql = $this->db->insert_string(TABLE_NAME, $data);
        $this->db->query($sql);

        // 接口返回值组装
        $this->data['data']['id'] = $this->db->insert_id();
        $this->data['retMsg'] = '新增成功';
        $this->data['retCode'] = 200;

        $this->data['sql'] = $this->db->last_query();

        $this->_ajax_output($this->data);
    }

    public function update()
    {
        $id = (int)$this->input->post('id');
        $name = (string)$this->input->post('name');
        $title = (string)$this->input->post('title');
        $email = (string)$this->input->post('email');

        $data = array(
            'name'  => $name,
            'title' => $title,
            'email' => $email
        );

        $where = "id = {$id}";

        $sql = $this->db->update_string(TABLE_NAME, $data, $where);
        $this->db->query($sql);

        $this->data['data']['id']   = $id;
        $this->data['retMsg']       = '修改成功';
        $this->data['retCode']      = 200;
        $this->data['sql']          = $this->db->last_query();

        $this->_ajax_output($this->data);
    }

    public function delete()
    {
        $id = (int)$this->input->get('id');

        if (!empty($id)) {
            $this->db->delete(TABLE_NAME, array('id' => $id));
            $this->data['retMsg']  = '删除成功';
            $this->data['retCode'] = 200;
            $this->data['sql'] = $this->db->last_query();
        } else {
            $this->data['retMsg']  = '缺少参数id';
            $this->data['retCode'] = 110;
        }

        $this->_ajax_output($this->data);
    }

    public function detail()
    {
        $id = (int)$this->input->get('id');

        if (!empty($id)) {
            $this->db->where('id', $id);
            $query = $this->db->get(TABLE_NAME);
            $row = $query->row();

            $this->data['data']     = $row;
            $this->data['retMsg']   = '查询成功';
            $this->data['retCode']  = 200;
            $this->data['sql']      = $this->db->last_query();
        } else {
            $this->data['retMsg']  = '缺少参数id';
            $this->data['retCode'] = 110;
        }

        $this->_ajax_output($this->data);
    }

    public function check()
    {
        $name = (string)$this->input->get('name');

        $this->db->where('name', $name);
        $query = $this->db->get(TABLE_NAME);
        $num = $query->num_rows();

        if ($num) {
            $this->data['data']     = $num;
            $this->data['retMsg']   = '已存在该数据';
            $this->data['retCode']  = 122;
        } else {
            $this->data['retMsg']   = '没有该数据';
            $this->data['retCode']  = 200;
        }

        $this->_ajax_output($this->data);
    }
}
