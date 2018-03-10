<?php
class Login_model extends CI_Model{
    //VALIDATING A LOGIN
	public function is_valid_login($user_email,$user_password)
	{

		 $q=$this->db->where(['admin_email'=>$user_email,'admin_password'=>$user_password])
				->get('admin');
		//$q="SELECT * FROM users where user_email='$user_email' AND user_password='$user_password;'";

				//$res=$this->db->query($q);
		if($q->num_rows())
		{
			return $res= $q->result_array();
		}else{
			return false;
		}
    }
    //SAVING A DISTRIBUTOR
    public function save_distributor($dist_name,$dist_email,$dist_pass,$dist_image)
    {
        $data=array(
            'dist_name'=>$dist_name,
            'dist_email'=>$dist_email,
            'dist_pass'=>$dist_pass,
            'dist_image'=>$dist_image
        );
            $this->db->insert('distributor',$data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
    }
    //GETTING A DISTRIBUTOR
    public function get_dist()
    {
        $q=$this->db->get('distributor');
        $res=$q->result_array();
        $i=0;
        foreach($res as $result)
        {
            $dist_id=$result['dist_id'];
            $sql1="SELECT SUM(chips_amount) as total_gain FROm all_transactions where transaction_reciever=$dist_id ";
            $q1=$this->db->query($sql1);
            $my_res=$q1->result_array()[0];
            $sum=$my_res['total_gain'];
            $sql2="SELECT SUM(chips_amount) as total_loss FROm all_transactions where transaction_giver=$dist_id ";
            $q2=$this->db->query($sql2);
            $my_res=$q2->result_array()[0];
            $loss=$my_res['total_loss'];
            $final=$sum-$loss;
            $res[$i]['total_gain']=$final;
            $i++;
            
        }
        
        return $res;
    }
//GETTING DETAILS OF A DISTRIBUTOR
    public function get_details($id)
    {
        $q=$this->db->where(['dist_id'=>$id])->get('distributor');
		return $res=$q->result_array()[0];	
    }
//ADDING CHIPS TO A DEISTRIBUTOR
    public function add_chips_to_distributor($id,$c)
    {
        $sql="UPDATE distributor SET dist_balance=dist_balance+$c where dist_id=$id ";
        $q=$this->db->query($sql);
        
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }
//SAVING CLIENT NOT NEEDED
    public function save_client($client_name,$client_email,$client_image,$client_chips,$client_table,$username)
    {
        $data=array(
            'client_name'=>$client_name,
            'client_email'=>$client_email,
            'client_image'=>$client_image,
            'client_chips'=>$client_chips,
            'client_table'=>$client_table,
            'client_dist'=>$username
        );
        $this->db->insert('clients',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }
    //GETTING ALL CLIENTS 
    public function get_client()
    {
        $q=$this->db->get('clients');

        $res=$q->result_array();
        $i=0;
        foreach($res as $result)
        {
            $dist_id=$result['client_id'];
            $sql1="SELECT SUM(chips_amount) as total_gain FROm all_transactions where transaction_reciever=$dist_id ";
            $q1=$this->db->query($sql1);
            $my_res=$q1->result_array()[0];
            $sum=$my_res['total_gain'];
            $sql2="SELECT SUM(chips_amount) as total_loss FROm all_transactions where transaction_giver=$dist_id ";
            $q2=$this->db->query($sql2);
            $my_res=$q2->result_array()[0];
            $loss=$my_res['total_loss'];
            $final=$sum-$loss;
            $res[$i]['total_gain']=$final;
            $i++;
        }
        return $res;
    }
//GETTING CLIENT AS PER CLIENT ID
    public function get_clients($id)
    {
        $q=$this->db->where(['client_id'=>$id])->get('clients');
		return $res=$q->result_array()[0];
    }
    //ADDING CHIPS TO CLIENT

    public function add_chips_client($id,$chips)
    {
        $sql="UPDATE clients SET client_balance=client_balance+$chips,client_total_chips=client_total_chips+$chips WHERE client_id=$id";
        $q=$this->db->query($sql);
        
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }
    //GETTING ALL TRANSACTIONS
    public function get_transactions($dist_id)
    {
        $this->db->select('*')->where("(transaction_reciever=$dist_id OR transaction_giver=$dist_id)", NULL, FALSE)->from('all_transactions a')->join('games g','g.game_id=a.game_id');
        $q=$this->db->get();
        $data=$q->result_array();

       for($i=0;$i<count($data);$i++)
        {
            $name=$data[$i]['transaction_reciever'];
            if($name==0){
                $final_name="Admin";
            }else if($name<999){
                
                $q=$final_name=$this->db->where(['dist_id'=>$name])->get('distributor');
                $res=$q->result_array()[0];
                $final_name=$res['dist_name'];
            }else{
                $q=$final_name=$this->db->where(['client_id'=>$name])->get('clients');
                $res=$q->result_array()[0];
                $final_name=$res['client_name'];
            }
            
            
            $data[$i]['transaction_reciever']=$final_name;
            $name=$data[$i]['transaction_giver'];
            if($name==0){
                $final_name="Admin";
            }else if($name<999){
                $q=$this->db->where(['dist_id'=>$name])->get('distributor');
                $res=$q->result_array()[0];
                $final_name=$res['dist_name'];
            }else{
                $q=$this->db->where(['client_id'=>$name])->get('clients');
                $res=$q->result_array()[0];
                $final_name=$res['client_name'];
            }

            $data[$i]['transaction_giver']=$final_name;
        }
        return $data;
        
    }
        //MAKING CHIPS ZERO ALSO NOT NEEDED
    public function make_chips_zero($dist_id)
    {
        $res=$this->db->select('dist_chips')->where(['dist_id'=>$dist_id])->get('distributor');
        $data1=$res->result_array()[0];
        $chips=$data1['dist_chips'];
        $sql="UPDATE admin SET admin_chips=admin_chips+$chips WHERE admin_id=1";
        $q1=$this->db->query($sql);
        $data=array('dist_chips'=>0,'dist_balance'=>0);
        $this->db->set('dist_chips','dist_chips',false);
        $this->db->set('dist_balance','dist_balance',false);
        $this->db->where('dist_id',$dist_id);
        $q=$this->db->update('distributor',$data);
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }
    //DELETING A DISTRIBUTOR NOT NEEDED
    public function delete_distributor($dist_id)
    {
        $q=$this->db->delete('all_transactions',array('transaction_reciever'=>$dist_id));
        $q=$this->db->delete('all_transactions',array('transaction_giver'=>$dist_id));
        $q=$this->db->delete('distributor', array('dist_id' => $dist_id));
        
        if($q){
            return true;

        }else{
            return false;
        }
    }
    //GETTING ALL GAMES ALSO OLD
    public function get_games()
    {
        $q=$this->db->select('game_status,dist_name,game_name,table_no,players')->from('games g')->join('distributor d','g.distributor_id=d.dist_id')->get();
        $res=$q->result_array();
        $i=0;
        
        foreach($res as $result)
        {
            $data['game_details'][$i]['game_status']=$result['game_status'];
            $data['game_details'][$i]['game_name']=$result['game_name'];
            $data['game_details'][$i]['table_no']=$result['table_no'];
            $players=$result['players'];
            $players_array=explode(",",$players);
            $j=0;
            foreach($players_array as $pl_arr){
                $q1=$this->db->select('client_name')->where(['client_id'=>$pl_arr])->get('clients');
                $res1=$q1->result_array()[0];
                $data['game_details'][$i]['player_details'][$j]['player_name']=$res1['client_name'];
                $j++;
            }
            $data['game_details'][$i]['distributor']=$result['dist_name'];
            $i++;
            
        }
        
        return $data;
    }
    
        //DASHBOARD
    public function get_all_clients($dist)
		{
			$q=$this->db->select('count(*) as data_need')->get('clients');
			return $q->result_array()[0]['data_need'];
        }
        //DASHBOARD
		public function get_all_active_clients($dist)
		{
			$q=$this->db->select('count(*) as data_need')->get('clients');
			return $q->result_array()[0]['data_need'];
        }
        
        //DASHBOARD
        public function get_all_distributors()
        {
            $q=$this->db->select('count(*) as all_distributors')->get('distributor');
            return $q->result_array()[0]['all_distributors'];
        }
//NEW TRANSACTIONS GETTING
        public function get_transaction()
        {
           $sql='SELECT * FROM transactions ORDER By trans_date desc'; 
        $q=$this->db->query($sql);
        $data=$q->result_array();

       for($i=0;$i<count($data);$i++)
        {
            $name=$data[$i]['client_id'];
            if($name==0){
                $final_name="Admin";
            }else if($name<999){
                
                $q=$final_name=$this->db->where(['dist_id'=>$name])->get('distributor');
                $res=$q->result_array()[0];
                $final_name=$res['dist_name'];
            }else{
                $q=$final_name=$this->db->where(['client_id'=>$name])->get('clients');
                $res=$q->result_array()[0];
                $final_name=$res['client_name'];
            }
            
            
            $data[$i]['name']=$final_name;
            }
        return $data;
        }
//OLD
        public function save_transaction1($dist_id,$dist_chips)
        {
            $data=array(
                'transaction_reciever'=>$dist_id,
                'transaction_giver'=>0,
                'chips_amount'=>$dist_chips,
                'c_to_d'=>3
            );
            $result=$this->db->insert('all_transactions',$data);
            return $result;
        }
        //saving transaction old
        public function save_transaction2($dist_id,$dist_chips)
        {
            $data=array(
                'transaction_reciever'=>$dist_id,
                'transaction_giver'=>0,
                'chips_amount'=>$dist_chips,
                'c_to_d'=>2
            );
            $result=$this->db->insert('all_transactions',$data);
            return $result;
        }
        //old and not important
        public function get_transactions_client($client_id)
        {
            $this->db->select('*')->where("(transaction_reciever=$client_id OR transaction_giver=$client_id)", NULL, FALSE)->from('all_transactions a')->join('games g','g.game_id=a.game_id');
        $q=$this->db->get();
        $data=$q->result_array();

       for($i=0;$i<count($data);$i++)
        {
            $name=$data[$i]['transaction_reciever'];
            if($name==0){
                $final_name="Admin";
            }else if($name<999){
                
                $q=$final_name=$this->db->where(['dist_id'=>$name])->get('distributor');
                $res=$q->result_array()[0];
                $final_name=$res['dist_name'];
            }else{
                $q=$final_name=$this->db->where(['client_id'=>$name])->get('clients');
                $res=$q->result_array()[0];
                $final_name=$res['client_name'];
            }
            
            
            $data[$i]['transaction_reciever']=$final_name;
            $name=$data[$i]['transaction_giver'];
            if($name==0)
            {
                $final_name="Admin";
            }else if($name<999){
                $q=$this->db->where(['dist_id'=>$name])->get('distributor');
                $res=$q->result_array()[0];
                $final_name=$res['dist_name'];
            }else{
                $q=$this->db->where(['client_id'=>$name])->get('clients');
                $res=$q->result_array()[0];
                $final_name=$res['client_name'];
            }

            $data[$i]['transaction_giver']=$final_name;
        }
        return $data;
        }
        //transaction to the distributor from admin 
        public function save_dist_transaction($dist_id,$dist_chips)
        {
            $data=array(
                'trans_type'=>1,
                'amount'=>$dist_chips,
                'client_id'=>$dist_id,
                'trans_date'=>date("Y-m-d h:i:s"),
                'descrip'=>"Admin Gave chips to the distributor"
            );
            $result=$this->db->insert('transactions',$data);
            return $result;
        }

        //subtracting chips from admin
        public function subtract_chips_from_admin($chips)
        {
            $qry="UPDATE admin SET admin_chips=admin_chips-$chips WHERE admin_id=1";
            $exec_qry=$this->db->query($qry);
            return $exec_qry;
        }
        //getting distributor of the client
        public function get_clients_dist($dist_id)
		{
			$q=$this->db->where(['client_dist'=>$dist_id])->get('clients');
			$res=$q->result_array();
			return $res;
        }
        //getting all transactions old
        public function get_all_transactions($clients_string)
		{
			$sql="SELECT * FROM transactions t JOIN clients c ON t.client_id=c.client_id  where t.client_id In $clients_string ORDER BY trans_date desc";
			$q=$this->db->query($sql);
			return $q->result_array();
        }
        //getting client transactions old
        public function get_client_transactions($client_id)
        {
            $sql="SELECT * FROM transactions where client_id=$client_id order by trans_date desc";
            $q=$this->db->query($sql);
              return $q->result_array();
        }
        //getting client name
        public function get_client_name($client_id)
        {
          $q=$this->db->where(['client_id'=>$client_id])->get('clients');
          return $q->result_array()[0]['client_name'];
        }
        //getting all bets
        public function get_bets()
        {
            $sql="SELECT * FROM bets b JOIN clients c On b.client_id=c.client_id JOIN games g On g.game_id=b.game_id";
            $q=$this->db->query($sql);
            return $q->result_array();
        }
        //saving transaction it is important
        public function save_transaction($id,$chips,$msg,$type,$bal,$t)
        {
            $date=date('Y-m-d H:i:s');
            $data=array(
                'trans_type'=>$type,
                'client_id'=>$id,
                'descrip'=>$msg,
                'amount'=>$chips,
                'trans_date'=>$date,
                'total'=>$bal,
                'type'=>$t
            );
            $q=$this->db->insert('transactions',$data);
            return $q;

        }
        //distributor transactions
        public function get_distributor_transactions($dist_id)
        {
            $sql="SELECT * FROM transactions where client_id=$dist_id ORDER BY trans_date desc";
            $q=$this->db->query($sql);
            $res= $q->result_array();
            return $res;
        }
            //getting chips of the distributor repeated
        public function get_chips_distributor($dist_id)
        {
            $q=$this->db->where(['dist_id'=>$dist_id])->get('distributor');
            $res=$q->result_array()[0]['dist_balance'];
            return $res;
        }
        //getting bet amount
        public function get_bet_amount($bet_id)
        {
            $q=$this->db->where(['bet_id'=>$bet_id])->get('bets');
            return $q->result_array()[0];
        }
        //subtract chips from client
        public function subtract_chips_from_client($client_id,$balance)
        {
            $sql="UPDATE clients SET client_balance=client_balance-$balance where client_id=$client_id";
            return $this->db->query($sql);
        }
        //adding chips to client
        public function add_chips_to_client($client_id,$balance)
        {
            $sql="UPDATE clients SET client_balance=client_balance+$balance where client_id=$client_id";
            return $this->db->query($sql);
        }
        //changing game status
        public function change_game_status($bet_id,$winner)
        {
            $sql="UPDATE bets SET winner=$winner where bet_id=$bet_id";
            return $this->db->query($sql);
        }
        //adding chips to admin
        public function add_chips_to_admin($chips)
        {
            $sql="UPDATE admin SET admin_chips=admin_chips+$chips where admin_id=1";
            return $this->db->query($sql);
        }
        //getting admin balance
        public function get_balance()
        {
            $q=$this->db->where(['admin_id'=>1])->get('admin');
            return $q->result_array()[0]['admin_chips'];
        }
        //get balance of a distributor
        public function get_balance1($dist_id)
        {
            $q=$this->db->where(['dist_id'=>$dist_id])->get('distributor');
            return $q->result_array()[0]['dist_balance'];
        }
        //getting balance of a client
        public function get_balance_client($client_id)
        {
            $q=$this->db->where(['client_id'=>$client_id])->get('clients');
            return $q->result_array()[0]['client_balance'];
        }
        //to get all clients of a distributor
        public function get_client_of_distributor($dist_id)
        {
            $q=$this->db->where(['client_dist'=>$dist_id])->get('clients');
            return $q->result_array();
        }

        //subtracting chips from distributor
        public function subtract_chips_from_distributor($id,$c)
        {
            $sql="UPDATE distributor SET dist_balance=dist_balance-$c where dist_id=$id ";
            $q=$this->db->query($sql);
            
            if($q)
            {
                return true;
            }else{
                return false;
            }
        }
        //getting name for transactions
        public function get_client_name1($dist_id)
        {
            if($dist_id==0){
                $name="Admin";
            }else if($dist_id>999){
                $q=$this->db->where(['client_id'=>$dist_id])->get('clients');
                $name=$q->result_array()[0]['client_name'];
            }else{
                $q=$this->db->where(['dist_id'=>$dist_id])->get('distributor');
                $name=$q->result_array()[0]['dist_name'];
            }
            return $name;
        }
        //getting balance of any one
        public function get_all_balance($id)
        {
            if($id==0){
                $q=$this->db->where(['admin_id'=>1])->get('admin');
                $bal=$q->result_array()[0]['admin_chips'];
            }else if($id>999){
                $q=$this->db->where(['client_id'=>$id])->get('clients');
                $bal=$q->result_array()[0]['client_balance'];
            }else{
                $q=$this->db->where(['dist_id'=>$id])->get('distributor');
                $bal=$q->result_array()[0]['dist_balance'];
            }
            return $bal;
        }

        //getting distributor details
        public function get_distributor($dist_id)
        {
            $q=$this->db->where(['dist_id'=>$dist_id])->get('distributor');
            return $q->result_array()[0];

        }

        //resetting password of the distributor
        public function reset_pass($dist_id,$dist_pass)
        {
            $sql="UPDATE distributor SET dist_pass='$dist_pass' WHERE dist_id=$dist_id";
            return $this->db->query($sql);
        }
    
        public function get_requests()
		{
			$sql="SELECT * FROM requests r JOIN distributor c ON r.client_id=c.dist_id where r.client_id<1000";
			$q=$this->db->query($sql);
			return $q->result_array();
		}
    
    //getting game details
     public function get_game_details($client_id)
      {
            $q=$this->db->from('games g')->join('clients c','c.client_id=g.client_id')->where(['g.client_id'=>$client_id])->get();
            return $q->result_array();
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