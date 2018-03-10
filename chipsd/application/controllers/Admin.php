<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
    public function index()
    {
        $this->load->view('login');
    }
//login validation
    public function validate_login()
    {
        $data=$this->input->post();
        unset($data['submit']);
        $this->form_validation->set_rules('email','Email','required|trim');
        $this->form_validation->set_rules('pass','Password','required|trim');
        $this->form_validation->set_error_delimiters("<p class='text-danger'>","</p>");
        if($this->form_validation->run())
        {
            $email=$data['email'];
            $pass=$data['pass'];
            $this->load->model('Login_model');
            $result=$this->Login_model->is_valid_login($email,$pass);
            
            if($result)
            {
                $ses_data=array(
                    'username'=>$result[0]['admin_name'],
                    'email'=>$result[0]['admin_email'],
                    'profile_pic'=>$result[0]['admin_pic']
                );
                $data['user_data']=$this->session->set_userdata($ses_data);
                $this->session->set_tempdata('msg','success',30);
                redirect('Admin/show_dashboard');
            }else
            {
                $this->session->set_tempdata('msg','success',30);
                redirect('Admin/');
            }

        }else
        {
            
        }
    }
    //taking to dashboard page
    public function show_dashboard()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $name=$data['username'];
            $this->load->model('Login_model');
            $count=$this->Login_model->get_all_clients($name);
            $data['clients']=$count;
            $data['ac_clients']=$this->Login_model->get_all_active_clients($name);
            $data['distributors']=$this->Login_model->get_all_distributors();
            $data['balance']=$this->Login_model->get_balance();
            $this->load->view('admin/dashboard',$data);

        }else{
            redirect('Admin/');
        }
       
    }
//logout method
    public function logout()
    {
       
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('profile_pic');
        $this->session->sess_destroy();
        $this->load->view('login','refresh');
     
    }
//form to add a distributor
    public function show_add_dist_form()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');

            $this->load->view('admin/add_dist_form',$data);

        }else{
            redirect('Admin/');
        } 
    }
    //saving distributor into database
    public function save_distributor()
    {
        $data=$this->input->post();
        unset($data['submit']);
        $this->form_validation->set_rules('dist_name','Distributor Name','required|trim');
        $this->form_validation->set_rules('dist_email','Distributor Email','required|trim');
        $this->form_validation->set_rules('dist_pass','Distributor Password','required|trim');
        
        $this->form_validation->set_error_delimiters("<p class='text-danger'>","</p>");
        if($this->form_validation->run())
        {
            $dist_name=$data['dist_name'];
            $dist_email=$data['dist_email'];
            $dist_pass=$data['dist_pass'];
            if(!empty($_FILES['dist_image']['name']))
            {
                $config['upload_path'] = base_url().'uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $_FILES['dist_image']['name'];
                $this->upload->initialize($config);
                if($this->upload->do_upload('dist_image'))
                {
                    $fileData = $this->upload->data();
                    $dist_image = $fileData['file_name'];
                }else{
                    $dist_image="user.png";
                }
            }else{
                $dist_image='user.png';
            }

            
            $this->load->model('Login_model');
             $result=$this->Login_model->save_distributor($dist_name,$dist_email,$dist_pass,$dist_image);
            
            if($result){
                $this->session->set_tempdata('msg','success',30);
                redirect('Admin/show_add_dist_form');  
            }else{
                $this->session->set_tempdata('msg','error',30);
                redirect('Admin/show_add_dist_form');
            }
        }else{
            $this->session->set_tempdata('msg','fail',30);
                redirect('Admin/show_add_dist_form');
        }

    }
    //showing all distributors
    public function show_distributors()
    {

        if($_SESSION['username'])
        {

            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
        $this->load->model('Login_model');
        $data['errros']=$this->session->tempdata('msg');
        $data['dists']=$this->Login_model->get_dist();
        
        $this->load->view('admin/distributors',$data);
        }else{
            redirect('Admin/');
        }
    }
//giving coin to a distributor
    public function give_coins($id)
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['dists']=$this->Login_model->get_details($id);
            $data['balance']=$this->Login_model->get_balance();
            $data['balance1']=$this->Login_model->get_balance1($id);
            $this->load->view('admin/coin_page',$data);
        }else{
            redirect('Admin/');
        }
    }
    //adding coins to a distributor
    
//adding clients 
    // public function add_clients()
    // {
    //     if($_SESSION['username'])
    //     {
    //         $data['username']=$this->session->userdata('username');
    //         $data['email']=$this->session->userdata('email');
    //         $data['profile_pic']=$this->session->userdata('profile_pic');

    //         $this->load->view('admin/add_client_form',$data);

    //     }else{
    //         redirect('Admin/');
    //     } 
    // }
    //saving clients
    // public function save_client()
    // {
    //     $data=$this->input->post();
    //     unset($data['add_client']);
    //     $this->form_validation->set_rules('client_name','Client Name','required|trim');
    //     $this->form_validation->set_rules('client_email','Client Email','required|trim');
    //     $this->form_validation->set_rules('table','Table Number','required|trim');
        
    //     $this->form_validation->set_error_delimiters("<p class='text-danger'>","</p>");
    //     if($this->form_validation->run())
    //     {
    //         $client_name=$data['client_name'];
    //         $client_email=$data['client_email'];
    //         if(!empty($_FILES['client_image']['name']))
    //         {
    //             $config['upload_path'] = 'uploads/';
    //             $config['allowed_types'] = 'gif|jpg|png';
    //             $config['file_name'] = $_FILES['client_image']['name'];
    //             $this->upload->initialize($config);
    //             if($this->upload->do_upload('client_image'))
    //             {
    //                 $fileData = $this->upload->data();
    //                 $client_image = $fileData['file_name'];
    //             }
    //         }else{
    //             $client_image='';
    //         }
            
    //         $client_chips=$data['chips'];
    //         $client_table=$data['table'];
    //         $username=$this->session->userdata('username');
    //         $this->load->model('Login_model');
    //         $result=$this->Login_model->save_client($client_name,$client_email,$client_image,$client_chips,$client_table,$username);
    //         $this->Login_model->save_transaction2($result,$client_chips);
    //         if($result){
    //             $this->session->set_tempdata('msg','success',30);
    //             redirect('Admin/add_clients');  
    //         }else{
    //             $this->session->set_tempdata('msg','error',30);
    //             redirect('Admin/add_clients');
    //         }
    //     }else{
    //         $this->session->set_tempdata('msg','fail',30);
    //             redirect('Admin/add_clients');
    //     }
    // }
//getting all clients
    public function get_client()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
        $this->load->model('Login_model');
        $data['dists']=$this->Login_model->get_client();
        $this->load->view('admin/clients',$data);
        }else{
            redirect('Admin/');
        } 
    }
//giving coins to the clients
    // public function give_coins_client($id)
    // {
    //     if($_SESSION['username'])
    //     {
    //         $data['username']=$this->session->userdata('username');
    //         $data['email']=$this->session->userdata('email');
    //         $data['profile_pic']=$this->session->userdata('profile_pic');
    //         $this->load->model('Login_model');
    //         $data['dists']=$this->Login_model->get_clients($id);
            
    //         $this->load->view('admin/coin_page_client',$data);
    //     }else{
    //         redirect('Admin/');
    //     }
    // }
//adding coins to the clients
    // public function add_coins_client()
    // {
    //     $id=$this->input->post('client_id');
    //     $chips=$this->input->post('client_chips');
    //     $chips_entered=$this->input->post('client_add');
    //     $client_chips=$chips+$chips_entered;
        
    //     $this->load->model('Login_model');
    //     $result=$this->Login_model->add_chips_client($id,$client_chips);
    //     $this->Login_model->save_transaction2($id,$chips_entered);
    //     if($result)
    //     {
    //         redirect('Admin/get_client');
    //     }else
    //     {
    //         redirect('Admin/give_coins_client');
    //     }
    // }
//see all transactions
    public function see_transactions($dist_id)
    {
        
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['client_name']=$this->Login_model->get_client_name1($dist_id);
            $data['transactions']=$this->Login_model->get_distributor_transactions($dist_id);
            $data['errors']=$this->session->userdata('msg');
            $data['balance']=$this->Login_model->get_balance1($dist_id);
            $this->load->view('all_transactions',$data);
            
        }else{
            redirect('Admin/show_distributors');
        }
    }
    //making the distributor chips to zero
    public function make_chips_zero($dist_id)
    {
        $this->load->model('Login_model');
        $balance=$this->Login_model->get_chips_distributor($dist_id);
        $this->Login_model->add_chips_to_admin($balance);
        $msg='Admin Made distributor chips zero';
        $this->Login_model->save_transaction($dist_id,$balance,$msg,0);
        $this->Login_model->save_transaction(0,$balance,$msg,1);
        $result=$this->Login_model->make_chips_zero($dist_id);
        
            redirect('Admin/show_distributors');
        
    }

    public function remove_dist($dist_id)
    {
        $this->load->model('Login_model');
        $balance=$this->Login_model->get_chips_distributor($dist_id);
        $this->Login_model->add_chips_to_admin($balance);
        $msg='Admin Made distributor chips zero';
        $this->Login_model->save_transaction($dist_id,$balance,$msg,0);
        $this->Login_model->save_transaction(0,$balance,$msg,1);
        $result = $this->Login_model->delete_distributor($dist_id);
        redirect('Admin/show_distributors');
    }

    public function get_games()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['games']=$this->Login_model->get_games();
            $this->load->view('admin/all_games',$data);
        }else{
            redirect('Admin/show_distributors');
        }
    }

//    public function get_game_details($game_id)
//    {
//        if($_SESSION['username'])
//        {
//            $data['username']=$this->session->userdata('username');
//            $data['email']=$this->session->userdata('email');
//            $data['profile_pic']=$this->session->userdata('profile_pic');
//            $this->load->model('Login_model');
//            $data['got_game_detail']=$this->Login_model->get_game_details($game_id);
//            
//            $this->load->view('admin/game_details',$data);
//        }else{
//            redirect('Admin/show_distributors');
//        }
//    }
//work editing from here 

    public function every_transaction()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['client_name']=$this->Login_model->get_client_name1(0);
            
            $data['transactions']=$this->Login_model->get_distributor_transactions(0);
            $data['balance']=$this->Login_model->get_balance();
       // $data['transactions']=$this->Login_model->get_transaction();
        $this->load->view('every_transaction',$data);
        }else{
            redirect('Admin/show_distributors');
        }
        
    }

    public function see_transactions_client($client_id)
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['transactions']=$this->Login_model->get_distributor_transactions($client_id);
            //$data['transactions']=$this->Login_model->get_client_transactions($client_id);
            $data['client_name']=$this->Login_model->get_client_name1($client_id);
            $data['balance']=$this->Login_model->get_balance_client($client_id);
            $this->load->view('client_transactions',$data);
            
        }else{
            redirect('Admin/show_distributors');
        }
    }
    public function get_bets()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['bets']=$this->Login_model->get_bets();
            $this->load->view('bets',$data);
            
        }else{
            redirect('Admin/show_distributors');
        }
    }
    public function declare_winner($game_id,$bet_id)
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['game_id']=$game_id;
            $data['bet_id']=$bet_id;
            $this->load->view('declare_winner',$data);
            
        }else{
            redirect('Admin/show_distributors');
        }
    }

    public function add_winner($game_id,$bet_id)
    {
        $data=$this->input->post();
        unset($data['declare_winner']);
        $winner=$data['winner'];
        $this->load->model('Login_model');
        $data=$this->Login_model->get_bet_amount($bet_id);
        $client_id=$data['client_id'];
        $balance=$data['amount'];
        if($winner==1)
        {
            $this->Login_model->subtract_chips_from_client($client_id,$balance);
            $this->Login_model->add_chips_to_admin($balance);
            $msg="Admin Won the bet";
            $this->Login_model->save_transaction($client_id,$balance,$msg,0);
            $this->Login_model->save_transaction(0,$balance,$msg,1);
            
        }
        else if($winner==2)
        {
            $this->Login_model->add_chips_to_client($client_id,$balance);
            $this->Login_model->subtract_chips_from_admin($balance);
            $msg="Client Won the bet";
            $this->Login_model->save_transaction($client_id,$balance,$msg,1);
            $this->Login_model->save_transaction(0,$balance,$msg,0);
        }
            $this->Login_model->change_game_status($bet_id,$winner);
        redirect('Admin/get_bets');
    }
    public function see_clients($dist_id)
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
        $this->load->model('Login_model');
        $data['dists']=$this->Login_model->get_client_of_distributor($dist_id);
        $this->load->view('admin/clients',$data);
        }else{
            redirect('Admin/');
        } 
    }
        public function reset_password($dist_id)
        {
            if($_SESSION['username'])
            {
                $data['username']=$this->session->userdata('username');
                $data['email']=$this->session->userdata('email');
                $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['dist']=$this->Login_model->get_distributor($dist_id);
            $this->load->view('admin/header',$data);
            $this->load->view('admin/navbar',$data);
            $this->load->view('admin/sidebar',$data);
            $this->load->view('stuff/reset_password',$data);
            $this->load->view('admin/footer',$data);
            }else{
                redirect('Admin/');
            } 
        }

        public function reset_pass($dist_id)
        {
            $data=$this->input->post();
        unset($data['submit']);
        $this->form_validation->set_rules('dist_pass','Password','required|trim');
        if($this->form_validation->run())
        {
            
            $dist_pass=$data['dist_pass'];
            $this->load->model('Login_model');
            $res=$this->Login_model->reset_pass($dist_id,$dist_pass);
            if($res){
                $this->session->set_tempdata('msg',"password updated successfully",30);
                redirect('Admin/show_distributors');
            }else{
                $this->session->set_tempdata('msg',"Some error occured",30);
                redirect('Admin/show_distributors');
            }
        }
        }

        //add coins
        public function add_coins_dist($id)
        {
            if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['dists']=$this->Login_model->get_details($id);
            $data['balance']=$this->Login_model->get_balance();
            $data['balance1']=$this->Login_model->get_balance1($id);
            $this->load->view('add_coin_page',$data);
        }else{
            redirect('Admin/');
        }
        }
        //subtract coins
        public function take_coins($id)
        {
            if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['dists']=$this->Login_model->get_details($id);
            $data['balance']=$this->Login_model->get_balance();
            $data['balance1']=$this->Login_model->get_balance1($id);
            $this->load->view('take_coin_page',$data);
        }else{
            redirect('Admin/');
        }
        }
        // add coins method
        public function add_coins_method()
        {
            $id=$this->input->post('dist_id');
            $chips_entered=$this->input->post('dist_add');
            $this->load->model('Login_model');
            $dist=$this->Login_model->get_details($id);
            $dist_name=$dist['dist_name'];
            $balance=$this->Login_model->get_all_balance(0);
            if($balance>=$chips_entered){
            $msg='Admin Gave Chips to Distributor:->'.$dist_name;
            $result=$this->Login_model->add_chips_to_distributor($id,$chips_entered);
            $this->Login_model->subtract_chips_from_admin($chips_entered);
            $total=$this->Login_model->get_all_balance($id);
            $this->Login_model->save_transaction($id,$chips_entered,$msg,1,$total,1);
            $total=$this->Login_model->get_all_balance(0);
            $this->Login_model->save_transaction(0,$chips_entered,$msg,0,$total,1);
        
            if($result)
            {
                redirect('Admin/show_distributors');
            }else
            {
                redirect('Admin/give_coins');
            }
        }else{
            $this->session->set_tempdata('msg',"You do not have enough chips",30);
            redirect('Admin/show_distributors');
        }
        } 

        //subtract chips from distributor
        public function subtract_chips()
        {
            $id=$this->input->post('dist_id');
            $chips_entered=$this->input->post('dist_add');
            $this->load->model('Login_model');
            $dist=$this->Login_model->get_details($id);
            $dist_name=$dist['dist_name'];
            $balance=$this->Login_model->get_all_balance($id);
            if($balance>=$chips_entered){
        $msg='Admin Took Chips from Distributor:->'.$dist_name;
        $this->Login_model->subtract_chips_from_distributor($id,$chips_entered);
        
        $result=$this->Login_model->add_chips_to_admin($chips_entered);
        $total=$this->Login_model->get_all_balance($id);
        $this->Login_model->save_transaction($id,$chips_entered,$msg,0,$total,2);
        $total=$this->Login_model->get_all_balance(0);
        $this->Login_model->save_transaction(0,$chips_entered,$msg,1,$total,2);
        
        
        if($result)
        {
            redirect('Admin/show_distributors');
        }else
        {
            redirect('Admin/give_coins');
        } 
    }else{
        $this->session->set_tempdata('msg',"You do not have enough chips",30);
            redirect('Admin/show_distributors');
    }
        }
    
    public function show_requests()
    {
         if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['requests']=$this->Login_model->get_requests();
            $this->load->view('requests',$data);
        }else{
            redirect('Admin/');
        }
    }
    public function get_game_details($client_id)
    {
       if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['profit']=$this->Login_model->get_profit($client_id);
            $data['loss']=$this->Login_model->get_loss($client_id);
            $data['final']=$this->Login_model->get_final($client_id);
            $data['games']=$this->Login_model->get_game_details($client_id);
            $this->load->view('game_details',$data);
        }else{
            redirect('Admin/');
        } 
    }
}