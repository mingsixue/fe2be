<?php
    class Blog extends CI_Controller {

        public function index()
        {
            $this->load->view('blogdetail.html');
        }

        public function comments($a, $b)
        {
            //echo 'Look at this!';
            echo $a;
            echo $b;
        }

        // 方法名前加下划线将变成私有方法
        public function _output($output)
        {
            echo $output;
        }

        private function _utility()
        {
            echo 'vic';
        }

        // 调用视图
        public function look()
        {
            $data['title'] = 'blog';
            $this->load->view('common/header.html', $data);
            $this->load->view('bloglook.html');
            $this->load->view('common/footer.html');
        }

        // 加载模型
        public function models()
        {
            $this->load->model('User_model');
        }

        // 日历类
        public function calendar()
        {
            $this->load->library('calendar');
            echo $this->calendar->generate();
        }

        //数据库
        public function database()
        {
            $this->load->database();

            $query = $this->db->query('SELECT name, title, email FROM my_table');

            foreach ($query->result() as $row)
            {
                echo $row->title;
                echo $row->name;
                echo $row->email;
                echo '<br/>';
            }

            echo 'Total Results:' . $query->num_rows();
        }

        public function database1()
        {
            $this->load->database();

            $query = $this->db->query('SELECT name, title, email FROM my_table');

            foreach($query->result_array() as $row)
            {
                echo $row['title'];
                echo $row['name'];
                echo $row['email'];
                echo '<br/>';
            }
        }

        public function database2()
        {
            $this->load->database();

            $query = $this->db->query('SELECT name FROM my_table LIMIT 1');
            $row = $query->row();
            echo $row->name;

        }

        public function database3()
        {
            $name = 'ssss';
            $title = 'smslsm';

            $this->load->database();

            $sql = "INSERT INTO my_table (name, title) VALUES (". $this->db->escape($name) .", ". $this->db->escape($title) .")";
            $this->db->query($sql);
            echo $this->db->affected_rows();
        }

        public function database4()
        {
            $this->load->database();
            echo $this->db->version();
        }
    }
