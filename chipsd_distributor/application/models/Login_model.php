<?php
class Login_model extends CI_Model{
	public function is_valid_login($user_email,$user_password)
	{

		 $q=$this->db->where(['dist_email'=>$user_email,'dist_pass'=>$user_password])
				->get('distributor');
		//$q="SELECT * FROM users where user_email='$user_email' AND user_password='$user_password;'";

				//$res=$this->db->query($q);
		if($q->num_rows())
		{
			return $res= $q->result_array();
		}else{
			return false;
		}
	}

    

    public function save_client($client_name,$client_email,$client_image,$client_table,$username)
    {	
        $data=array(
            'client_name'=>$client_name,
            'client_email'=>$client_email,
            'client_image'=>$client_image,
            'client_password'=>$client_table,
			'client_dist'=>$username,
			'client_status1'=>1
        );
        $this->db->insert('clients',$data);
        $insert_id = $this->db->insert_id();
		return $insert_id;
 	}
    public function get_client($distributor)
    {
        $q=$this->db->where(['client_dist'=>$distributor])->get('clients');
        return $res=$q->result_array();
    }

    public function get_clients($id)
    {
        $q=$this->db->where(['client_id'=>$id])->get('clients');
		return $res=$q->result_array()[0];
    }

    public function add_chips_client($id,$chips,$dist_id)
    {
			$sql1="SELECT * FROM distributor where dist_id=$dist_id";
			$q1=$this->db->query($sql1);
			$res=$q1->result_array()[0]['dist_balance'];
			if($res>$chips)
			{
				$sql2="UPDATE distributor SET dist_balance=dist_balance-$chips WHERE dist_id=$dist_id";
				$q2=$this->db->query($sql2);
			$sql="UPDATE clients SET client_balance=client_balance+$chips,client_total_chips=client_total_chips+$chips WHERE client_id=$id";
			$q=$this->db->query($sql);
			return true;
		}else{
			return false;
		}
    }

    public function get_transactions($dist_id)
    {
        $this->db->where("(transaction_reciever=$dist_id OR transaction_giver=$dist_id)", NULL, FALSE);
        $q=$this->db->get('all_transactions');
        $data=$q->result_array();

       for($i=0;$i<count($data);$i++)
        {
            $name=$data[$i]['transaction_reciever'];
            if($name<999){

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
            if($name<999){
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

    public function make_chips_zero($dist_id)
    {
        $data=array('dist_chips'=>0);
        $this->db->set('dist_chips','dist_chips',false);
        $this->db->where('dist_id',$dist_id);
        $q=$this->db->update('distributor',$data);
        if($q)
        {
            return true;
        }else{
            return false;
        }
    }

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
		public function get_distributor()
		{
			$q=$this->db->get('distributor');
			return $q->result_array();
		}

		public function save_game($game_name,$table_name,$player_list,$distributor)
		{
			$data=array("game_name"=>$game_name,"table_no"=>$table_name,"players"=>$player_list,"distributor_id"=>$distributor);
			$this->db->insert("games",$data);
		}

		public function get_games()
		{
			$q=$this->db->where(['game_status'=>0])->get('games');
			return $q->result_array();

		}

		public function get_clients_game($game_id)
		{
			$sql="SELECT * FROM games where game_id=$game_id";
			$res=$this->db->query($sql);
			$result=$res->result_array();
			$players=$result[0]['players'];
			$player_array=explode(",",$players);
			$player_com="('".implode("','",$player_array)."')";
			$sql1="SELECT * FROM clients where client_id In $player_com ";
			$res1=$this->db->query($sql1);
			$result1=$res1->result_array();
			return $result1;
		}

		public function get_table_no($game_id)
		{
			$q=$this->db->select('table_no')->where(['game_id'=>$game_id])->get('games');
			return $q->result_array();
		}

		public function save_transaction1($game_id,$client_name,$chips_amount,$table_no,$payment_to,$distributor)
		{
			if($payment_to==0)
			{
				$q=$this->db->where(['client_id'=>$client_name])->get('clients');
				$res=$q->result_array()[0];
				$chips_of_client=$res['client_balance'];
				if($chips_of_client >= $chips_amount)
				{
					$sql1="UPDATE clients SET client_balance=client_balance-$chips_amount WHERE client_id=$client_name";
					$res=$this->db->query($sql1);
					$sql1="UPDATE distributor SET dist_balance=dist_balance+$chips_amount WHERE dist_id=$distributor";
					$res=$this->db->query($sql1);
					$data=array('transaction_reciever'=>$distributor,'transaction_giver'=>$client_name,'chips_amount'=>$chips_amount,'c_to_d'=>$payment_to,'table_no'=>$table_no,'game_id'=>$game_id);
					$query=$this->db->insert('all_transactions',$data);
					$myvalue= '1' ;
				}
				else {
					$myvalue=='2';
				}
			}else{
				$q=$this->db->where(['dist_id'=>$distributor])->get('distributor');
				$res=$q->result_array()[0];
				$chips_of_client=$res['dist_balance'];
				if($chips_of_client >= $chips_amount)
				{
					$sql1="UPDATE clients SET client_balance=client_balance+$chips_amount WHERE client_id=$client_name";
					$res=$this->db->query($sql1);
					$sql1="UPDATE distributor SET dist_balance=dist_balance-$chips_amount WHERE dist_id=$distributor";
					$res=$this->db->query($sql1);
					$data=array('transaction_reciever'=>$client_name,'transaction_giver'=>$distributor,'chips_amount'=>$chips_amount,'c_to_d'=>$payment_to,'table_no'=>$table_no,'game_id'=>$game_id);

					$query=$this->db->insert('all_transactions',$data);
					$myvalue='1';
				}
				else {
					$myvalue='3';
				}
			}
			return $myvalue;
		}
		public function get_active_games()
		{
			$q=$this->db->where(['game_status'=>0])->get('games');
			$res=$q->result_array();
			return $res;
		}

		public function save_game_status($game_id)
		{
			$sql1="SELECT * FROM games where game_id=$game_id";
			$q1=$this->db->query($sql1);
			$res1=$q1->result_array()[0];
			$players=$res1['players'];
			$distributor=$res1['distributor_id'];
			$players_ids=explode(",",$players);
			$i=0;
			$data=array();
			foreach($players_ids as $player_id)
			{
				$sql_pl="SELECT SUM(chips_amount) as gain from all_transactions WHERE transaction_reciever=$player_id";
				$q_pl=$this->db->query($sql_pl);
				$res_pl=$q_pl->result_array()[0];
				$gain=$res_pl['gain'];
				$sql_pla="SELECT SUM(chips_amount) as loss from all_transactions WHERE transaction_giver=$player_id";
				$q_pla=$this->db->query($sql_pla);
				$res_pla=$q_pla->result_array()[0];
				$loss=$res_pla['loss'];
				$total=$gain-$loss;
				$sql_ins="INSERT INTO game_details(game_id,chips_won,chips_lost,player_id,total_chips) VALUES('$game_id','$gain','$loss','$player_id','$total')";
				$q_ins=$this->db->query($sql_ins);

				$i++;
			}
			$sql_pl="SELECT SUM(chips_amount) as gain from all_transactions WHERE transaction_reciever=$distributor";
			$q_pl=$this->db->query($sql_pl);
			$res_pl=$q_pl->result_array()[0];
			$gain=$res_pl['gain'];
			$sql_pla="SELECT SUM(chips_amount) as loss from all_transactions WHERE transaction_giver=$distributor";
			$q_pla=$this->db->query($sql_pla);
			$res_pla=$q_pla->result_array()[0];
			$loss=$res_pla['loss'];
			$total=$gain-$loss;
			$sql_ins="INSERT INTO game_details(game_id,chips_won,chips_lost,player_id,total_chips) VALUES('$game_id','$gain','$loss','$distributor','$total')";
			$q_ins=$this->db->query($sql_ins);

			$sql="UPDATE games SET game_status=1 where game_id=$game_id";
			$q=$this->db->query($sql);
			if($q)
			{
				return true;
			}else{
				return false;
			}
		}
		public function get_all_clients($dist)
		{
			$q=$this->db->select('count(*) as data_need')->where(['client_dist'=>$dist])->get('clients');
			return $q->result_array()[0]['data_need'];
		}
		public function get_all_active_clients($dist)
		{
			$q=$this->db->select('count(*) as data_need')->where(['client_dist'=>$dist,'client_status1'=>1])->get('clients');
			return $q->result_array()[0]['data_need'];
		}
		public function all_created_games($dist)
		{
			$q=$this->db->select('count(*) as data_need')->where(['client_dist'=>$dist])->get('clients');
			return $q->result_array()[0]['data_need'];
		}
		public function active_games($dist)
		{
			$q=$this->db->select('count(*) as data_need')->where(['game_status'=>0])->get('games');
			return $q->result_array()[0]['data_need'];
		}
		public function balance_chips($dist)
		{
			if($dist>999){
				$q=$this->db->get('clients');
				return $q->result_array()[0]['client_balance'];
			}else{
			$q=$this->db->select('dist_balance')->where(['dist_id'=>$dist])->get('distributor');
			return $q->result_array()[0]['dist_balance'];
			}
		}
		

		public function save_transaction2($dist_id,$dist_chips,$dist)
        {
            $data=array(
                'transaction_reciever'=>$dist_id,
                'transaction_giver'=>$dist,
                'chips_amount'=>$dist_chips,
                'c_to_d'=>1
            );
            $result=$this->db->insert('all_transactions',$data);
            return $result;
		}
		
		public function save_client_transaction($result,$dist_chips)
		{
			$data=array(
                'trans_type'=>2,
                'amount'=>$dist_chips,
                'client_id'=>$result,
                'trans_date'=>date("Y-m-d h:i:s"),
                'descrip'=>"Client Bought Chips from the distributor"
            );
            $result=$this->db->insert('transactions',$data);
            return $result;
		}
		public function get_withdrawl($dist_id)
		{
			$sql="SELECT * FROM withdrawl_requests w JOIN clients c ON w.client_id=c.client_id where client_dist=$dist_id";
			$q=$this->db->query($sql);
			$res=$q->result_array();
			return $res;
		}
		public function approve_withdrawl($dist_id)
		{
			
			$sql="UPDATE withdrawl_requests SET status=1 WHERE with_id=$dist_id";
			$res=$this->db->query($sql);
			return $res;
		}
		public function decline_withdrawl($dist_id)
		{

			$sql="UPDATE withdrawl_requests SET status=2 WHERE with_id=$dist_id";
			$res=$this->db->query($sql);
			return $res;
		}
//getting clients of a distributor
		public function get_clients_dist($dist_id)
		{
			$q=$this->db->where(['client_dist'=>$dist_id])->get('clients');
			$res=$q->result_array();
			return $res;
		}

		//getting requests
		public function get_requests($clients_string)
		{
			$sql="SELECT * FROM requests r JOIN clients c ON r.client_id=c.client_id where r.client_id In $clients_string";
			$q=$this->db->query($sql);
			return $q->result_array();
		}
		public function get_all_transactions($clients_string)
		{
			$sql="SELECT * FROM transactions t JOIN clients c ON t.client_id=c.client_id  where t.client_id In $clients_string ORDER BY trans_date desc";
			$q=$this->db->query($sql);
			return $q->result_array();
		}

		public function get_dist_balance($dist_id)
		{
			if($dist_id>999){
				$q=$this->db->get('clients');
				return $q->result_array()[0]['client_balance'];
			}else{
			$q=$this->db->get('distributor');
			return $q->result_array()[0]['dist_balance'];
			}
		}


		//subtracting chips to distributor
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
		//adding chips to distributor
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
	
	//get client's transactions
	public function get_client_transactions($client_id)
        {
            $sql="SELECT * FROM transactions where client_id=$client_id order by trans_date desc";
            $q=$this->db->query($sql);
              return $q->result_array();
		}
		
		
		
		//get transactions
		public function get_distributor_transactions($dist_id)
        {
            $sql="SELECT * FROM transactions where client_id=$dist_id ORDER BY trans_date desc";
            $q=$this->db->query($sql);
            $res= $q->result_array();
            return $res;
		}
		
		//adding chips to client
		public function add_chips_to_client($client_id,$balance)
        {
            $sql="UPDATE clients SET client_balance=client_balance+$balance where client_id=$client_id";
            return $this->db->query($sql);
        }
		//subtracting chips from client
        public function subtract_chips_from_client($client_id,$balance)
        {
            $sql="UPDATE clients SET client_balance=client_balance-$balance where client_id=$client_id";
            return $this->db->query($sql);
		}
		public function get_client_transactions1($dist_id)
        {
            $sql="SELECT * FROM transactions t JOIN clients c On c.client_id=t.client_id where t.client_id=$dist_id ORDER BY trans_date desc";
            $q=$this->db->query($sql);
            $res= $q->result_array();
            return $res;
		}
		public function get_dist_transactions($dist_id)
        {
            $sql="SELECT * FROM transactions t JOIN distributor c On c.dist_id=t.client_id where t.client_id=$dist_id ORDER BY trans_date desc";
            $q=$this->db->query($sql);
            $res= $q->result_array();
            return $res;
		}
		public function get_final($client_id)
		{
			$qry="SELECT SUM(amount) as gain from transactions where client_id=$client_id AND trans_type=1";
			$res=$this->db->query($qry);
			$result=$res->result_array()[0]['gain'];
			$qry1="SELECT SUM(amount) as loss from transactions where client_id=$client_id AND trans_type=0";
			$res1=$this->db->query($qry1);
			$result1=$res1->result_array()[0]['loss'];
			return $result-$result1;
		}

		public function get_with_details($with_id)
		{
			$qry=$this->db->where(['with_id'=>$with_id])->get('withdrawl_requests');
			$res=$qry->result_array()[0];
			return $res;
		}

		public function get_distributor_as($client_id)
		{
			$qry=$this->db->where(['client_id'=>$client_id])->get('clients');
			$res=$qry->result_array()[0]['client_dist'];
			return $res;
			}
    
        //get balance of the client
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
    //getting name of anyone based on their id
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
    
    //adding chips
    public function add_chips($id,$chips)
    {
        if($id==0){
            $q="Update admin SET admin_chips=admin_chips+$chips where admin_id=1";
            $name=$this->db->query($q);
        }else if($id>999){
            $q="Update clients SET client_balance=client_balance+$chips where client_id=$id";
            $name=$this->db->query($q);
        }else{
            $q="Update distributor SET dist_balance=dist_balance+$chips where dist_id=$id";
            $name=$this->db->query($q);
        }
        return $name;
    }
    //subtracting chips
    public function subtract_chips($id,$chips)
    {
        if($id==0){
            $q="Update admin SET admin_chips=admin_chips-$chips where admin_id=1";
            $name=$this->db->query($q);
        }else if($id>999){
            $q="Update clients SET client_balance=client_balance-$chips where client_id=$id";
            $name=$this->db->query($q);
        }else{
            $q="Update distributor SET dist_balance=dist_balance-$chips where dist_id=$id";
            $name=$this->db->query($q);
        }
        return $name;
	}
	
	//getting details of the distributor
	public function get_details($id)
	{
		if($id==0){
			$q=$this->db->where(['admin_id'=>1])->get('admin');
			return $q->result_array()[0];
		}else if($id>999){
			$q=$this->db->where(['client_id'=>$id])->get('clients');
			return $q->result_array()[0];
		}else{
			$q=$this->db->where(['dist_id'=>$id])->get('distributor');
			return $q->result_array()[0];
		}
	}

	public function reset_pass($client_id,$client_pass)
	{
		$sql="UPDATE clients SET client_password=$client_pass where client_id=$client_id ";
		return $this->db->query($sql);
	}

	public function save_request($dist_id,$amount)
	{
		$data=array(
			'amount'=>$amount,
			'client_id'=>$dist_id
		);
		return $this->db->insert('requests',$data);
	}
}
