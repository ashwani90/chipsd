<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributor extends CI_Controller
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
                  "uid"=>$result[0]['dist_id'],
                    'username'=>$result[0]['dist_name'],
                    'email'=>$result[0]['dist_email'],
                    'profile_pic'=>$result[0]['dist_image']
                );
                 $data['user_data']=$this->session->set_userdata($ses_data);
                $this->session->set_tempdata('msg','success',30);
                redirect('Distributor/show_dashboard');
            }else
            {
                $this->session->set_tempdata('msg','success',30);
                redirect('Distributor/');
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
              $dist=$this->session->userdata('uid');
            $this->load->model('Login_model');
            $name=$data['username'];
           // $count=$this->Login_model->get_client_dist($dist);
            $count=$this->Login_model->get_all_clients($dist);
            $data['clients']=$count;
            $data['ac_clients']=$this->Login_model->get_all_active_clients($dist);
            //$data['create_games']=$this->Login_model->all_created_games($name);

            //$data['ac_games']=$this->Login_model->active_games($dist);
            $data['balance']=$this->Login_model->balance_chips($dist);
            
            $this->load->view('admin/dashboard',$data);

        }else{
            redirect('Distributor/');
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


//adding clients
    public function add_clients()
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $data['errors']=$this->session->tempdata('msg');
            $this->load->view('admin/add_client_form',$data);

        }else{
            redirect('Distributor/');
        }
    }
    //saving clients
    public function save_client()
    {
        $data=$this->input->post();
        unset($data['add_client']);
        $this->form_validation->set_rules('client_name','Client Name','required|trim');
        $this->form_validation->set_rules('client_email','Client Email','required|trim');
        $this->form_validation->set_rules('password','Password','required|trim');

        $this->form_validation->set_error_delimiters("<p class='text-danger'>","</p>");
        if($this->form_validation->run())
        {
            $client_name=$data['client_name'];
            $client_email=$data['client_email'];
            if(!empty($_FILES['client_image']['name']))
            {
                $config['upload_path'] = 'uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $_FILES['client_image']['name'];
                $this->upload->initialize($config);
                if($this->upload->do_upload('client_image'))
                {
                    $fileData = $this->upload->data();
                    $client_image = $fileData['file_name'];
                }else{
                    $client_image='user.png';
                }
            }else{
                $client_image='user.png';
            }

            
            $client_table=$data['password'];
            $username=$this->session->userdata('uid');
            $this->load->model('Login_model');
            $result=$this->Login_model->save_client($client_name,$client_email,$client_image,$client_table,$username);
            if($_SESSION['username'])
            {
                $dist_id=$this->session->userdata('uid');
            }
            
            if($result){
                $this->session->set_tempdata('msg','Client created successfully',30);
                
                redirect('Distributor/add_clients');
            }
        }else{
            $this->session->set_tempdata('msg','fail',30);
                redirect('Distributor/add_clients');
        }
    }
//getting all clients
    public function get_client()
    {
        if($_SESSION['username'])
        {
            $data['uid']=$this->session->userdata('uid');
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
        $this->load->model('Login_model');
        $distributor=$data['uid'];
        $data['dists']=$this->Login_model->get_client($distributor);

        $this->load->view('admin/clients',$data);
        }else{
            redirect('Distributor/');
        }
    }
//giving coins to the clients
    public function give_coins_client($id)
    {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $dist_id=$this->session->userdata('uid');
            $this->load->model('Login_model');
            $data['dists']=$this->Login_model->get_clients($id);
            $data['balance']=$this->Login_model->balance_chips($dist_id);
            $data['client_balance']=$this->Login_model->get_all_balance($id);
            $this->load->view('admin/coin_page_client',$data);
        }else{
            redirect('Distributor/');
        }
    }
//adding coins to the clients
    public function add_coins_client()
    {
        $id=$this->input->post('client_id');

       $chips_entered=$this->input->post('client_add');
        if($_SESSION['username'])
        {
        $dist_id=$this->session->userdata('uid');

        $this->load->model('Login_model');
        $balance=$this->Login_model->get_all_balance($dist_id);
        $client_balance=$this->Login_model->get_all_balance($id);
            if($balance>$chips_entered){
        if(isset($_POST['add_chips']))
        {
            $this->load->model('Login_model');
            $dist_name=$this->Login_model->get_client_name1($dist_id);
            $client_name=$this->Login_model->get_client_name1($id);
            
        $msg='Distributor:->'.$dist_name. ' Gave Chips to Client:->'.$client_name;
        $result=$this->Login_model->add_chips($id,$chips_entered);
        $this->Login_model->subtract_chips($dist_id,$chips_entered);
        $total=$this->Login_model->get_all_balance($id);
        $this->Login_model->save_transaction($id,$chips_entered,$msg,1,$total,3);
        $total=$this->Login_model->get_all_balance($dist_id);
        $this->Login_model->save_transaction($dist_id,$chips_entered,$msg,0,$total,3);
       
        
        }else{
                    redirect('Distributor/get_client');
                }
            }
            if($client_balance>$chips_entered)
            {
                if(isset($_POST['sub_chips']))
                {
                    
            $this->load->model('Login_model');
            $dist=$this->Login_model->get_details($id);
            $dist_name=$dist['dist_name'];
        $msg='Distributor:->'.$dist_name. ' took Chips from Client:->'.$client_name;
        $this->Login_model->subtract_chips($id,$chips_entered);
        
        $this->Login_model->add_chips($dist_id,$chips_entered);
        echo $total=$this->Login_model->get_all_balance($id);
        $this->Login_model->save_transaction($id,$chips_entered,$msg,0,$total,4);
        echo $total=$this->Login_model->get_all_balance($dist_id);die;
        $this->Login_model->save_transaction(0,$chips_entered,$msg,1,$total,4);
        
                    }else{
                    redirect('Distributor/get_client');
                }
        }else{
                $this->session->set_tempdata('msg','you do not have enough chips',30);
            redirect('Distributor/get_client');
        }
        redirect('Distributor/get_client');
      }else{
        redirect('Distributor/get_client');
      }
    }

    public function start_game()
    {
      if($_SESSION['username'])
      {
          $data['username']=$this->session->userdata('username');
          $data['email']=$this->session->userdata('email');
          $data['profile_pic']=$this->session->userdata('profile_pic');
          $this->load->model('Login_model');
          $distributor=$data['username'];
          $data['tables']=$this->Login_model->get_client($distributor);
          $data['distributors']=$this->Login_model->get_distributor();
          $this->load->view('start_game',$data);
      }else{
          redirect('Distributors/');
      }

    }
      public function save_game()
      {
        $data=$this->input->post();
        unset($data['add_game']);
        $this->form_validation->set_rules('game_name','Game Name','required|trim');
        $this->form_validation->set_rules('table_name','Table Name','required|trim');

        if($this->form_validation->run())
        {
          $game_name=$data['game_name'];
          $table_name=$data['table_name'];
          $players=$data['players'];
          $player_list=implode(',',$players);
          //$distributor=$data['distributor'];
          $distributor=$this->session->userdata('uid');
          $this->load->model('Login_model');
          $result=$this->Login_model->save_game($game_name,$table_name,$player_list,$distributor);
          if($result)
          {
              redirect('Distributor/start_game');
          }
          else
          {
            redirect('Distributor/start_game');
          }

        }else{
          redirect('Distributor/start_game');
        }
      }

      public function make_transaction()
      {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['games']=$this->Login_model->get_games();
            $data['errors']=$this->session->userdata('msg');

            $this->load->view('transaction',$data);
        }else{
            redirect('Distributors/');
        }

      }
      public function get_clients_of_game($id)
      {
          $this->load->model('Login_model');
          $data['clients']=$this->Login_model->get_clients_game($id);
          $data['table_no']=$this->Login_model->get_table_no($id);
          echo json_encode($data);
      }

      public function confirm_transaction()
      {
        $data=$this->input->post();
        unset($data['make_transaction']);
        $this->form_validation->set_rules('chips_amount','Chips Amount','required|trim');
        $this->form_validation->set_rules('client_name','Client Name','required|trim');

        if($this->form_validation->run())
        {
          $game_id=$data['game_id'];
          $client_name=$data['client_name'];
          $chips_amount=$data['chips_amount'];
          $table_no=$data['table_number'];
          $payment_to=$data['payment_to'];

          $distributor=$this->session->userdata('uid');
          $this->load->model('Login_model');
          $result=$this->Login_model->save_transaction($game_id,$client_name,$chips_amount,$table_no,$payment_to,$distributor);
          if($result=='1')
            {
                $this->session->set_userdata('msg','Transaction Completed successfully',30);
                redirect('Distributor/make_transaction');
            }
            else if($result=='2')
            {
              $this->session->set_userdata('msg','You do not have enough chips to give to client',30);
              redirect('Distributor/make_transaction');
            }else{
              $this->session->set_userdata('msg','Client does not have enough chips',30);
              redirect('Distributor/make_transaction');
            }

          }else{
            redirect('Distributor/make_transaction');
          }
      }
      public function finish_game()
      {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $this->load->model('Login_model');
            $data['games']=$this->Login_model->get_active_games();
            $data['errors']=$this->session->userdata('msg');

            $this->load->view('admin/game_end',$data);
        }else{
            redirect('Distributors/');
        }

      }

      public function save_game_status()
      {
        $data=$this->input->post();
        unset($data['finish_game']);
        $this->form_validation->set_rules('game_id','Chips Amount','required|trim');

        if($this->form_validation->run())
        {
          $game_id=$data['game_id'];

          $this->load->model('Login_model');
          $result=$this->Login_model->save_game_status($game_id);
          if($result)
            {
                $this->session->set_userdata('msg','Game Ended Successfully',30);
                redirect('Distributor/finish_game');
            }
            else{
              $this->session->set_userdata('msg','Some error occured',30);
              redirect('Distributor/finish_game');
            }

          }else{
            $this->session->set_userdata('msg','Please select some game',30);
            redirect('Distributor/finish_game');
          }
      }

      public function get_withdrawl_page()
      {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $dist_id=$this->session->userdata('uid');
            $this->load->model('Login_model');
            $data['withs']=$this->Login_model->get_withdrawl($dist_id);
            $data['errors']=$this->session->userdata('msg');

            $this->load->view('withdrawl_page',$data);
        }else{
            redirect('Distributor/');
        }
      }

      public function approve_withdrawl($with_id)
      {
            $this->load->model('Login_model');
            $data=$this->Login_model->get_with_details($with_id);
            $balance=$data['amount'];
            $client_id=$data['client_id'];
            $dist_id=$this->Login_model->get_distributor_as($client_id);
            $this->Login_model->subtract_chips_from_client($client_id,$balance);
            $this->Login_model->add_chips_to_distributor($dist_id,$balance);
            $msg="Withdrawl From Client";
            $this->Login_model->save_transaction($client_id,$balance,$msg,0);
            $this->Login_model->save_transaction($dist_id,$balance,$msg,1);
            $result=$this->Login_model->approve_withdrawl($with_id);
            if($result)
            {
                redirect('Distributor/get_withdrawl_page');
            }
            else
            {
                redirect('Distributor/get_withdrawl_page');
            }
      }
      public function decline_withdrawl($with_id)
      {
            $this->load->model('Login_model');
            $result=$this->Login_model->decline_withdrawl($with_id);
            if($result)
            {
                redirect('Distributors/get_withdrawl_page');
            }
            else
            {
                redirect('Distributors/get_withdrawl_page');
            }
      }

      public function coin_requests()
      {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $dist_id=$this->session->userdata('uid');
            $this->load->model('Login_model');

            $clients=$this->Login_model->get_clients_dist($dist_id);
            if($clients!=array()){
            $i=0;
            foreach($clients as $client)
            {
                $clients_array[$i]=$client['client_id'];
                $i++;
            }
            $clients_string="('".implode("','",$clients_array)."')";
            $data['requests']=$this->Login_model->get_requests($clients_string);
          }else{
            $data['requests']=array();
          }
            
            $data['errors']=$this->session->userdata('msg');

            $this->load->view('coin_requests',$data);
        }
        else
        {
            redirect('Distributor/');
        }
      }

      //get all transactions of the distributor

      public function see_all_transactions()
      {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $dist_id=$this->session->userdata('uid');
            $this->load->model('Login_model');
            // $clients=$this->Login_model->get_clients_dist($dist_id);
            // $i=0;
            // foreach($clients as $client)
            // {
            //     $clients_array[$i]=$client['client_id'];
            //     $i++;
            // }
            // $clients_string="('".implode("','",$clients_array)."')";
            $dist=$this->Login_model->get_details($dist_id);
            $data['client_name']=$dist['dist_name'];
            $data['transactions']=$this->Login_model->get_dist_transactions($dist_id);
            $data['errors']=$this->session->userdata('msg');
            $data['final_tally']=$this->Login_model->get_final($dist_id);
            $data['balance']=$this->Login_model->balance_chips($dist_id);
            $this->load->view('all_transactions',$data);
        }
        else
        {
            redirect('Distributor/');
        } 
      }

      public function get_client_transactions($client_id)
      {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $dist_id=$this->session->userdata('uid');
            $this->load->model('Login_model');
            $dist=$this->Login_model->get_details($client_id);
            $data['client_name']=$dist['client_name'];
            $data['transactions']=$this->Login_model->get_client_transactions1($client_id);
            $data['final_tally']=$this->Login_model->get_final($client_id);
            $data['errors']=$this->session->userdata('msg');
            $balance=$this->Login_model->get_details($client_id);
            $data['balance']=$balance['client_balance'];
            $this->load->view('all_transactions',$data);
        }
        else
        {
            redirect('Distributor/');
        } 
      }

      //deposit form
        public function deposit_form($id)
        {
            if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $dist_id=$this->session->userdata('uid');
            $this->load->model('Login_model');
            $data['dists']=$this->Login_model->get_clients($id);
            $data['balance']=$this->Login_model->balance_chips($dist_id);
            $data['client_balance']=$this->Login_model->get_all_balance($id);
            $this->load->view('deposit_form',$data);
        }else{
            redirect('Distributor/');
        }
        }
      //getting withdrawl form
      public function withdraw_form($id)
      {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
            $dist_id=$this->session->userdata('uid');
            $this->load->model('Login_model');
            $data['dists']=$this->Login_model->get_clients($id);
            $data['balance']=$this->Login_model->balance_chips($dist_id);
            $data['client_balance']=$this->Login_model->get_all_balance($id);
            $this->load->view('credit_form',$data);
        }else{
            redirect('Distributor/');
        }
      }

      //deposit form
      public function deposit_coins_client()
      {
        $id=$this->input->post('client_id');

        $chips_entered=$this->input->post('client_add');
         if($_SESSION['username'])
         {
         $dist_id=$this->session->userdata('uid');
 
         $this->load->model('Login_model');
         $balance=$this->Login_model->get_all_balance($dist_id);
         $client_balance=$this->Login_model->get_all_balance($id);
             if($balance>=$chips_entered){
         if(isset($_POST['add_chips']))
         {
             $this->load->model('Login_model');
             $dist=$this->Login_model->get_details($dist_id);
        $dist_name=$dist['dist_name'];
        $dist=$this->Login_model->get_details($id);

        $client_name=$dist['client_name'];
         $msg='Distributor:->'.$dist_name. ' Gave Chips to Client:->'.$client_name;
         $result=$this->Login_model->add_chips($id,$chips_entered);
         $this->Login_model->subtract_chips($dist_id,$chips_entered);
         $total=$this->Login_model->get_all_balance($id);
         $this->Login_model->save_transaction($id,$chips_entered,$msg,1,$total,3);
         $total=$this->Login_model->get_all_balance($dist_id);
         $this->Login_model->save_transaction($dist_id,$chips_entered,$msg,0,$total,3);
         redirect('Distributor/get_client');
         
         }else{
                     redirect('Distributor/get_client');
                 }
             }else{
                redirect('Distributor/get_client');
            }
            }else{
                redirect('Distributor/get_client');
            }
      }

      //withdraw form

      public function withdraw_coins_client()
      {
        $id=$this->input->post('client_id');

        $chips_entered=$this->input->post('client_add');
         if($_SESSION['username'])
         {
         $dist_id=$this->session->userdata('uid');
 
         $this->load->model('Login_model');
         $balance=$this->Login_model->get_all_balance($dist_id);
         $client_balance=$this->Login_model->get_all_balance($id);
        if($client_balance>=$chips_entered)
        {
            if(isset($_POST['sub_chips']))
            {
                
        $this->load->model('Login_model');
        $dist=$this->Login_model->get_details($dist_id);
        $dist_name=$dist['dist_name'];
        $dist=$this->Login_model->get_details($id);

        $client_name=$dist['client_name'];
    $msg='Distributor:->'.$dist_name. ' took Chips from Client:->'.$client_name;
    $this->Login_model->subtract_chips($id,$chips_entered);
    
    $this->Login_model->add_chips($dist_id,$chips_entered);
    $total=$this->Login_model->get_all_balance($id);
    $this->Login_model->save_transaction($id,$chips_entered,$msg,0,$total,4);
    $total=$this->Login_model->get_all_balance($dist_id);
    $this->Login_model->save_transaction($dist_id,$chips_entered,$msg,1,$total,4);
    redirect('Distributor/get_client');
                }else{
                redirect('Distributor/get_client');
                 }
            }else{
             $this->session->set_tempdata('msg','you do not have enough chips',30);
                redirect('Distributor/get_client');
            }
            redirect('Distributor/get_client');
        }else{
                redirect('Distributor/get_client');
        }
      }
      public function reset_password($client_id)
      {
        if($_SESSION['username'])
        {
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
        $this->load->model('Login_model');
        $data['dist']=$this->Login_model->get_details($client_id);
        
        $this->load->view('reset_password',$data);
        
        }else{
            redirect('Distributor/');
        } 
      }

      public function reset_pass($client_id)
      {
        $data=$this->input->post();
        unset($data['submit']);
        $this->form_validation->set_rules('dist_pass','Password','required|trim');
        if($this->form_validation->run())
        {
            
            $dist_pass=$data['dist_pass'];
            $this->load->model('Login_model');
            $res=$this->Login_model->reset_pass($client_id,$dist_pass);
            if($res){
                $this->session->set_tempdata('msg',"password updated successfully",30);
                redirect('Distributor/get_client');
            }else{
                $this->session->set_tempdata('msg',"Some error occured",30);
                redirect('Distributor/get_client');
            }
        }
      }

      public function request_coins()
      {
        if($_SESSION['username'])
        {
            $dist_id=$this->session->userdata('uid');
            $data['username']=$this->session->userdata('username');
            $data['email']=$this->session->userdata('email');
            $data['profile_pic']=$this->session->userdata('profile_pic');
        
        $this->load->view('request_coin',$data);
        
        }else{
            redirect('Distributor/');
        }  
      }
      public function request_coin()
      {
        $data=$this->input->post();
        unset($data['submit']);
        $this->form_validation->set_rules('dist_pass','Password','required|trim');
        if($this->form_validation->run())
        {
            $dist_id=$this->session->userdata('uid');
            $dist_pass=$data['dist_pass'];
            $this->load->model('Login_model');
            $res=$this->Login_model->save_request($dist_id,$dist_pass);
            if($res){
                $this->session->set_tempdata('msg',"password updated successfully",30);
                redirect('Distributor/get_client');
            }else{
                $this->session->set_tempdata('msg',"Some error occured",30);
                redirect('Distributor/get_client');
            }
        } 
      }
}
