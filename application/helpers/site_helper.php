<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_site_option'))
{

	function get_site_option( $opt_key = FALSE )
	{
		$CI =& get_instance();
		
		// Load cache driver.
		$CI->load->driver('cache', array("adapter" => "memcached"));
		$data = $CI->cache->get("moe_dbtable_option");

		// Validate cache data
		if ( ! $data )
		{
			$query = $CI->db->get("moe_option");
			$data = $query->result();
			
			$CI->cache->save("moe_dbtable_option", $data, $CI->config->item('moe_memcached_time'));
		}

		// Find options.
		if ( $opt_key )
		{
			foreach ($data as $row) 
			{
				if ( $row->opt_key == $opt_key )
					return $row->opt_value;
			}
		}
		else
		{
			return $data;
		}

		return FALSE;

	}
	
}

if ( ! function_exists('set_site_option') )
{
	
	function set_site_option( $opt_key, $opt_value )
	{
		$CI =& get_instance();

		// Write data.
		$CI->db->where('opt_key', $opt_key);
		$CI->db->update('mytable', array('opt_value' => $opt_value)); 

		// Check data is updated.
		if ($CI->db->affected_rows < 0)
			return FALSE;

		// Rewrite cache data.
		$CI->load->driver('cache', array("adapter" => "memcached"));
		$data = $CI->cache->get("moe_dbtable_option");

		if ( ! $data )
		{
			$query = $CI->db->get("moe_site_option");
			$CI->cache->save("moe_dbtable_option", $query->result(), $CI->config->item('moe_memcached_time'));
		}

		return TRUE;
	}
	
}

if ( ! function_exists('get_site_group') )
{

	function get_site_group($id = -1, $title = "")
	{
		$CI =& get_instance();
		
		$CI->load->driver('cache', array("adapter" => "memcached"));
		$cached = $CI->cache->get("moe_dbtable_group");
		
		if ( ! $cached )
		{
			$query = $CI->db->get("group");
			$cached = $query->result();
			$CI->cache->save("moe_dbtable_group", $cached, $CI->config->item('moe_memcached_time'));
		}
		
		foreach ( $cached as $row )
		{
			if ( $id >= 0 && $row->group_id != $id ) continue;
			
			if ( $title != "" && $row->group_title != $title ) continue;
			
			return $row;
		}
	}
	
}

if ( ! function_exists('compare_address_by_group_order') )
{
	function compare_address_by_group_order($a, $b)
	{
		if ( $a->addr_group_order > $b->addr_group_order ) return -1;
		if ( $a->addr_group_order < $b->addr_group_order ) return 1;
		return 0; // equality
	}
}

if ( ! function_exists('get_site_address_list') )
{

	function get_site_address_list( $group = "" )
	{
		$CI =& get_instance();
		
		$group = get_site_group(-1, $group);
		$ad_cc = $CI->cache->get( "moe_dbtable_address_by_group_id_".$group->group_id );
		
		if ( ! $ad_cc )
		{
			$cache = $CI->cache->get( "moe_dbtable_address" );
			
			if ( ! $cache )
			{
				$cache = $CI->db->get("address")->result();
				uasort($cache, 'compare_address_by_group_order');
				$CI->cache->save("moe_dbtable_address", $cache, $CI->config->item('moe_memcached_time'));
			}
			
			$ad_cc = array();
			
			foreach ( $cache as $v ) 
			{
				if ( $v->addr_group_id == $group->group_id ) 
					$ad_cc[] = $v;
			}
		}
		
		return $ad_cc;
		
	}
	
}

if ( ! function_exists('get_site_address_by_id') )
{
	function get_site_address_by_id($id)
	{
		$CI =& get_instance();
		
		$CI->load->driver('cache', array("adapter" => "memcached"));
		$cache = $CI->cache->get( "moe_dbtable_address" );
	
		if ( ! $cache )
		{
			$cache = $CI->db->get("address")->result();
			uasort($cache, 'compare_address_by_group_order');
			$CI->cache->save("moe_dbtable_address", $cache, $CI->config->item('moe_memcached_time'));
		}
		
		foreach ( $cache as $v ) 
		{
			if ( $v->addr_id == $id ) 
				return $v;
		}
	}
	
}

if ( ! function_exists('get_site_captcha') )
{
	function get_site_captcha()
	{
		$CI =& get_instance();
		$CI->load->helper('captcha');
		
		$word = '';
		for ($i = 0; $i < 5; $i++)
		{
			$word .= substr('123456789abcdefghijkmnopqrstuvwxyz', mt_rand(0, 34), 1);
		}
	   
		$cap = create_captcha(array(
			'img_path' 	=> './data/captcha/',
			'img_url' 	=> base_url().'data/captcha/',
			'word'		=> $word
		));

		$cap_data = array(
			'captcha_time' 	=> $cap['time'],
			'captcha_ip' 	=> $CI->input->ip_address(),
			'captcha_word' 	=> $cap['word']
		);
		
		$cap['img_url'] = base_url().'data/captcha/'.$cap['time'].'.jpg';
		
		$CI->db->insert('captcha', $cap_data);
		
		return $cap;
	}
}

if ( ! function_exists('validation_captcha') )
{
	function validation_captcha( $captcha = "" )
	{
		$CI =& get_instance();
		
		// 首先删除旧的验证码
		$expiration = time() - 7200;
		$CI->db->where('captcha_time <', $expiration); 
		$CI->db->delete('captcha');
		
		// 然后再看是否有验证码存在:
		$CI->db->where('captcha_word', $captcha); 
		$CI->db->where('captcha_ip', $CI->input->ip_address());
		$CI->db->where('captcha_time >', $expiration);
		$query = $CI->db->get('captcha');
		
		if ($query->num_rows() < 1)
		{
			if (isset($CI->form_validation))
				$CI->form_validation->set_message('validation_captcha', '%s 输入不正确.');
			
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}

