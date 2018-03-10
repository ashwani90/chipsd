<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller 
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
                    'username'=>$result[0]['client_name'],
                    'email'=>$result[0]['client_email'],
                    'profile_pic'=>$result[0]['client_image'],
                    'client_id'=>$result[0]['client_id']
                );
                $data['user_data']=$this->session->set_userdata($ses_data);
                
                $this->session->set_tempdata('msg','success',30);
                redirect('Client/show_dashboard');
            }else
            {
                $this->session->set_tempdata('msg','success',30);
                redirect('Client/');
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
            $data['errors']=$this->session->tempdata('msg');
            $client_id=$this->session->userdata('client_id');
            $this->load->model('Login_model');
            $data['balance']=$this->Login_model->get_balance($client_id);
            $data['won_chips']=$this->Login_model->get_profit($client_id);
            $data['lost_chips']=$this->Login_model->get_loss($client_id);
            $fia=$data['won_chips']-$data['lost_chips'];
            
            $data['final_tally']=$this->Login_model->get_final($client_id);
            

            $this->load->view('dashboard',$data);

        }else{
            redirect('Client/');
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

    //playing game
    public function play_game()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['games']=$this->Login_model->get_games();
            if(isset($_SESSION['msg'])){
            $data['errors']=$this->session->tempdata('msg');
        }
            $this->load->view('game_form',$data);
        }else{
            redirect('Client/');
        }
    }
    //place a bet
    public function place_bet()
    {
        $data=$this->input->post();
        unset($data['submit']);
        $this->form_validation->set_rules('game_id','game','required|trim');
        $this->form_validation->set_rules('bet_chips','bet_chips','required|trim');
        if($_SESSION['username'])
        {
            $client_id=$this->session->userdata('client_id');
        }
        if($this->form_validation->run())
        {
            $game_id=$data['game_id'];
           $chips=$data['bet_chips'];
            $this->load->model('Login_model');
            $res1=$this->Login_model->has_enough_chips($client_id,$chips);
            if($res1){
                $resu=$this->Login_model->check_active_game($game_id);
                if($resu){
                    $this->Login_model->store_bet($game_id,$client_id,$chips);
                    $this->session->set_tempdata('msg',"Successfully placed a bet",30);
                    redirect('Client/play_game');
                }else{
                $this->session->set_tempdata('msg',"The game is no longer active",30);
                redirect('Client/play_game');
                }
            }else{
                $this->session->set_tempdata('msg',"You don't have enough chips",30);
                redirect('Client/play_game');
            }
        }
    }

    //demand game
    public function demand_coins()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            if(isset($_SESSION['msg'])){
            $data['errors']=$this->session->tempdata('msg');
        }
            $this->load->view('request_chips',$data);
        }else{
            redirect('Client/');
        }
    }

    //add coins
    public function save_request()
    {
        if($_SESSION['username'])
        {
            $client_id=$this->session->userdata('client_id');
        }
        $data=$this->input->post();
        unset($data['submit']);
        $this->form_validation->set_rules('amount','amount','required|trim');
        if($this->form_validation->run())
        {
            $amount=$data['amount'];
            $this->load->model('Login_model');
            $res=$this->Login_model->save_request($client_id,$amount);
            if($res)
            {
                $this->session->set_tempdata('msg','Successfully Requested',30);
            }else{
                $this->session->set_tempdata('msg','Some error occured try again',30);
            }
            redirect('client/demand_coins');
        }else{
            redirect('Client/demand_coins/');
        }
    }
    //withdrawl requests
    public function withdrawl_coins()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            if(isset($_SESSION['msg'])){
            $data['errors']=$this->session->tempdata('msg');
        }
            $this->load->view('withdrawl_requests',$data);
        }else{
            redirect('Client/');
        }
    }

    //save the withdrawl details
    public function save_withdrawl()
    {
        if($_SESSION['username'])
        {
            $client_id=$this->session->userdata('client_id');
        }
        $data=$this->input->post();
        unset($data['submit']);
        $this->form_validation->set_rules('amount','amount','required|trim');
        if($this->form_validation->run())
        {
            $amount=$data['amount'];
            $this->load->model('Login_model');
            $res1=$this->Login_model->has_enough_chips($client_id,$amount);
            if($res1){
            $res=$this->Login_model->save_withdrawl($client_id,$amount);
            if($res)
            {
                $this->session->set_tempdata('msg','Successfully Requested',30);
            }else{
                $this->session->set_tempdata('msg','Some error occured try again',30);
            }
            redirect('client/withdrawl_coins');
        }else{
            $this->session->set_tempdata('msg',"You don't have enough chips",30);
            redirect('client/withdrawl_coins');
        }
        }else{
            redirect('Client/withdrawl_coins/');
        }
    }

    public function game_details()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $client_id=$this->session->userdata('client_id');
            $this->load->model('Login_model');
            $data['profit']=$this->Login_model->get_profit($client_id);
            $data['loss']=$this->Login_model->get_loss($client_id);
            $data['final']=$this->Login_model->get_final($client_id);
            $data['games']=$this->Login_model->get_game_details($client_id);
            $this->load->view('game_details',$data);
        }else{
            redirect('Client/');
        }
    }

    public function get_transactions()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $client_id=$this->session->userdata('client_id');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['transactions']=$this->Login_model->get_transactions($client_id);
            $client=$this->Login_model->get_details($client_id);
            $data['client_name']=$client['client_name'];
            $data['balance']=$this->Login_model->get_balance($client_id);
            $this->load->view('all_transactions',$data);
        }else{
            redirect('Client/');
        }
    }
}