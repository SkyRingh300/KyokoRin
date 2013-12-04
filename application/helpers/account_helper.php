<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists("account_login") )
{
	function account_sign_in($username, $se3ret)
	{
		$CI =& get_instance();
		
		$CI->db->where("account_name", $username);
		$query = $CI->db->get("account");
		$row = $query->row(1);
		
		if ($query->num_rows > 0)
		{
			$se3ret = md5(md5($se3ret).$row->account_salt);
			if (strcasecmp($row->account_se3ret, $se3ret) == 0)
			{
				$data = array(
					'account_last_login' 		=> time(),
					'account_last_ip_address' 	=> $CI->input->ip_address()
				);
				$CI->db->where('account_id', $row->account_id);
				$CI->db->update('account', $data); 
			
				$CI->session->set_userdata(array(
					"account" => array(
						"account_id"	=> $row->account_id,
						"account_name"	=> $row->account_name,
						"account_email"	=> $row->account_email,
					)
				));
				return 1;
			}
			else
			{
				return -1;
			}
		}
		else
		{
			return -2;
		}
		
		return 0;
	}
}

if ( ! function_exists("get_account_information") )
{
	function get_account_information()
	{
		$CI =& get_instance();
		return $CI->session->userdata("account");
	}
}

if ( ! function_exists("validation_account_id") )
{
	function validation_account_id( $account_id )
	{
		$account = get_account_information();
		
		if ( $account )
			return ( $account['account_id'] == $account_id );
		else return false;
	}
}

if ( ! function_exists("account_create") )
{
	function account_create($username, $se3ret, $email)
	{
		$CI =& get_instance();
		
		$salt = substr(uniqid(rand()), -6);
		
		$data = array(
			'account_name' 		=> $username,
			'account_se3ret' 	=> md5(md5($se3ret).$salt),
			'account_email' 	=> $email,
			'account_status'	=> "",
			'account_created'	=> time(),
			'account_salt'		=> $salt
		);
		
		$CI->db->insert("account", $data); 
	}
}

if ( ! function_exists("account_logout") )
{
	function account_logout()
	{
		$CI =& get_instance();
		$CI->session->unset_userdata('account');
	}
}

if ( ! function_exists("fetch_account") )
{
	function fetch_account($id)
	{
		$CI =& get_instance();
		
		$CI->db->where(array("account_id" => $id));
		$query = $CI->db->get("account");
		return $query->row();
	}
}

if ( ! function_exists("fetch_account_list") )
{
	function fetch_account_list($limit = 10, $offset = 0)
	{
		$query = $CI->db->get("account", $limit, $offset);
		return $query->result();
	}
}

if ( ! function_exists("account_sign_out") )
{
	function account_sign_out()
	{
		$CI =& get_instance();
		
		$CI->session->set_userdata(array("account" => NULL));
		$CI->session->sess_destroy();
	}
}

