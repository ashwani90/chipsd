<?php
class Login_model extends CI_Model{

    //validating the login
	public function is_valid_login($user_email,$user_password)
	{

		 $q=$this->db->where(['client_email'=>$user_email,'client_password'=>$user_password])
				->get('clients');
		//$q="SELECT * FROM users where user_email='$user_email' AND user_password='$user_password;'";

				//$res=$this->db->query($q);
		if($q->num_rows())
		{
            $res=$q->result_array();
			return $res;
		}else{
			return false;
		}
	}
 
  //get all games
    public function get_games()
    {
        $q=$this->db->where(['game_status'=>0])->get('games');
        $data=$q->result_array();
        return $data;
    }

    //check if the client has enough chips
      public function has_enough_chips($client_id,$chips)
      {
          $q=$this->db->select('client_balance')->where(['client_id'=>$client_id])->get('clients');
          $result_data=$q->result_array()[0];
          
          $client_chips=$result_data['client_balance'];
          if($client_chips >= $chips)
          {
              $data=true;
          }else{
              $data=false;
      }
     
      return $data;
      }
//subtracting chips from the client
      public function subtract_chips($client_id,$chips)
      {
          $q="UPDATE clients SET client_balance=client_balance-$chips where client_id=$client_id";
          $result=$this->db->query($q);
          return $result;
      }

      //check the active games
      public function check_active_game($game_id)
      {
          $date=date('Y-m-d');
          $query="SELECT DATEDIFF($date,start_date) as date_got,total_days from games where game_id=$game_id";
          $q=$this->db->query($query);
          $res=$q->result_array()[0];
          $date=$res['total_days'];
          $got=$res['date_got'];
          if($got>$date){
                $sql="UPDATE games SET game_status=0 where game_id=$game_id";
                $q1=$this->db->query($sql);
                return false;
          }else{
              return true;
          }
      }
            //storing a bet
      public function store_bet($game_id,$client_id,$chips)
      {
            $data=array(
                'client_id'=>$client_id,
                'amount'=>$chips,
                'game_id'=>$game_id
            );
            $res=$this->db->insert('bets',$data);
            return $res;
      }
      //storing the request
      
      public function save_request($client_id,$amount)
      {
            $data=array(
                'client_id'=>$client_id,
                'amount'=>$amount
            );
            $res=$this->db->insert('requests',$data);
            return $res;
      }

      //get game details

      public function get_game_details($client_id)
      {
            $q=$this->db->from('games g')->join('clients c','c.client_id=g.client_id')->where(['g.client_id'=>$client_id])->get();
            return $q->result_array();
      }
      //get transactions

      public function get_transactions($client_id)
      {
          $sql="SELECT * FROM transactions where client_id=$client_id order by trans_date desc";
          $q=$this->db->query($sql);
            return $q->result_array();
      }

      public function get_client_name($client_id)
      {
        $q=$this->db->where(['client_id'=>$client_id])->get('clients');
        return $q->result_array()[0]['client_name'];
      }
      

      public function get_won_chips($client_id)
      {
          $q="SELECT SUM(amount) as total_won from bets WHERE client_id=$client_id and winner=2";
          $res=$this->db->query($q);

          
          $result=$res->result_array()[0]['total_won'];
          return $result;
      }
      public function get_lost_chips($client_id)
      {
          $q="SELECT SUM(amount) as total_lost from bets where client_id=$client_id and winner=1";
          $res=$this->db->query($q);
          $result=$res->result_array()[0]['total_lost'];
            return $result;
      }
      public function get_balance($client_id)
      {
          $q=$this->db->where(['client_id'=>$client_id])->get('clients');
          return $q->result_array()[0]['client_balance'];
      }

      public function save_withdrawl($client_id,$amount)
      {
          $data=array(
              'client_id'=>$client_id,
              'amount'=>$amount
              
          );
          $q=$this->db->insert('withdrawl_requests',$data);
          return $q;
      }

      //getting name for transactions
      public function get_client_name1($dist_id)
      {
          if($dist_id==0){
              $name="Admin";
          }else if($dist_id>999){
              $q=$this->db->get('clients');
              $name=$q->result_array()[0]['client_name'];
          }else{
              $q=$this->db->get('distributor');
              $name=$q->result_array()[0]['dist_name'];
          }
          return $name;
      }
      //getting name for transactions
      public function get_details($dist_id)
      {
          if($dist_id==0){
              $data=$this->db->where(['admin_id'=>1])->get('admin');
              return $data->result_array()[0];
          }else if($dist_id>999){
              $q=$this->db->where(['client_id'=>$dist_id])->get('clients');
              $name=$q->result_array()[0];
          }else{
              $q=$this->db->where(['dist_id'=>$dist_id])->get('distributor');
              $name=$q->result_array()[0]['dist_name'];
          }
          return $name;
      }

      //getting profit of the client

      public function get_profit($client_id)
      {
            $sql="SELECT SUM(amount) as profit from games where client_id=$client_id AND winner=1 ";
            $res=$this->db->query($sql);
            return $res->result_array()[0]['profit'];
      }
      //get the final loss
      public function get_loss($client_id)
      {
          $sql="SELECT SUM(amount) as loss from games where client_id=$client_id and winner=0 ";
          $res=$this->db->query($sql);
          return $res->result_array()[0]['loss'];
      }

      public function get_final($client_id)
      {
        $sql="SELECT SUM(amount) as profit from games where client_id=$client_id AND winner=1";
        $res=$this->db->query($sql);
        $pro=$res->result_array()[0]['profit'];
        $sql="SELECT SUM(amount) as loss from games where client_id=$client_id AND winner=0";
        $res=$this->db->query($sql);
        $los=$res->result_array()[0]['loss'];
        $final=$pro-$los;
        if($final>=0){
            return "The total gain is ".$final;
        }else{
            $fi=abs($final);
            return "The total loss is ".$fi;
        }
      }
}