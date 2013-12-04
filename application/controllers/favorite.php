<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorite extends CI_Controller {
	
	private $account = array();
	
	private $add_address_valid = array(
		array(
			'field' => 'name',
			'label' => '网站名',
			'rules' => 'trim|required|xss_clean|min_length[1]|max_length[32]'
		),
		array(
			'field' => 'url',
			'label' => '网站地址',
			'rules' => 'trim|required|min_length[3]|max_length[1024]'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->driver('cache', array("adapter" => "memcached"));
		$this->load->helper("account");
		
		$this->load->library("form_validation");
		
		$this->account = get_account_information();
	}
	
	public function lists ( ) 
	{
		if ( $this->account )
		{
			$list = $this->get_app_list( $this->account['account_id'] );
		}
		else 
		{
			$list = $this->get_default_list();
		}
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($list));
	}
	
	public function add ( )
	{
		$return = array();
		
		if ( $this->account )
		{
			$this->form_validation->set_rules($this->add_address_valid);
			if ($this->form_validation->run() == FALSE)
			{
				$return['message'] = validation_errors();
				$return['code'] = -1;
			}
			else
			{
				$this->db->where(array( "furl_account_id" => $this->account["account_id"] ));
				
				$num_rows = $this->db->get( "site_favorite" )->num_rows();
				
				if ( $num_rows >= 32 )
				{
					$return['message'] = "最多只能保存 32 条网址哟~";
					$return['code'] = -1;
					
					$this->output
						->set_content_type('application/json')
						->set_output(json_encode($return));
					
					return;
				}
				
				$post = $this->input->post();
				
				// Clean XSS & Injection
				$post['name'] = str_replace(array('\'', '<', '>', '"'), "", $post['name']);
				$post['url'] = str_replace(array('\'', '<', '>', '"'), "", $post['url']);
				
				// Validation URL.
				$url = parse_url($post['url']);
				if (  ! $url OR ! isset($url['host']) )
				{
					$return['message'] = "网址不符合规则，请仔细检查~";
					$return['code'] = -2;
					
					$this->output
						->set_content_type('application/json')
						->set_output(json_encode($return));
					
					return;
				}
				
				// Add scheme.
				if ( ! isset($url['scheme']) )
					$post['url'] = 'http://'.$post['url'];
				
				// Find available record.
				$this->db->where(array( "furl_account_id" => $this->account["account_id"], "furl_url" => $post['url']));
				$num_exist = $this->db->get( "site_favorite" )->num_rows();
				if ( $num_exist > 0 )
				{
					$return['message'] = "网址已经存在了哟~";
					$return['code'] = -3;
					
					$this->output
						->set_content_type('application/json')
						->set_output(json_encode($return));
					
					return;
				}
				
				$data = array(
					'furl_account_id' 	=> $this->account["account_id"],
					'furl_name' 		=> $post['name'],
					'furl_host'			=> $url['host'],
					'furl_url'			=> $post['url'],
					'furl_order'		=> $num_rows,
					'furl_created'		=> time()
				);
				
				$this->db->insert("site_favorite", $data); 
				
				$return['code'] = 1;
				
			}
			
		}
		else 
		{
			$return['message'] = "您尚未登录，请点击 <a href='javascript:void(0)' onClick='location.reload();'>这里</a> 刷新后登陆。";
			$return['code'] = 0;
		}
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($return));
	}
	
	public function delete ()
	{
		$return = array();
		
		if ( $this->account )
		{
			$this->db->delete("site_favorite", array('furl_id' => (int) $this->input->post("id"))); 
			$return['code'] = 1;
		}
		else 
		{
			$return['message'] = "您尚未登录，请点击 <a href='javascript:void(0)' onClick='location.reload();'>这里</a> 刷新后登陆。";
			$return['code'] = 0;
		}
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($return));
	}
	
	public function sorts ()
	{
		$return = array();
		
		if ( $this->account )
		{
			$ids = $this->input->get_post('ids');
			$ids = explode(",", $ids);
			
			$this->db->where(array( "furl_account_id" => $this->account["account_id"] ));
			
			if ( $this->db->get( "site_favorite" )->num_rows() != count($ids) )
			{
				$return['message'] = "未知错误。";
				$return['code'] = -1;
			}
			else
			{
				for ( $i = 0, $l = count($ids); $i < $l; $i ++ )
				{
					$ids[$i] = (int) $ids[$i];
				}
				
				$this->db->where(array( "furl_account_id" => $this->account["account_id"] ));
				$list = $this->db->get("site_favorite")->result();
				
				foreach ( $list as $row )
				{
					$sort = array_search($row->furl_id, $ids);
					
					if ( $sort !== FALSE)
					{
						$this->db->where('furl_id', $row->furl_id); 
						$this->db->update('site_favorite', array('furl_order' => $sort)); 
					}
				}
				
				$return['code'] = 1;
			}
		}
		else 
		{
			$return['message'] = "您尚未登录，请点击 <a href='javascript:void(0)' onClick='location.reload();'>这里</a> 刷新后登陆。";
			$return['code'] = 0;
		}
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($return));
	}
	
	public function reset()
	{
		$return = array();
		
		if ( $this->account )
		{
			$this->db->where("furl_account_id", $this->account["account_id"]);
			$this->db->delete("site_favorite");
			
			$default_list = $this->cache->get("moe_default_list");
		
			if ( ! $default_list )
			{
				// Get default user list.
				$this->db->where(array( "url_default" => 1 ));
				$default_list = $this->db->get( "site_url" )->result();
				$this->cache->save("moe_default_list", $default_list, $this->config->item('moe_memcached_time'));
			}
			
			$i = 0;
			
			foreach ( $default_list as $row )
			{
				$data = array(
					'furl_account_id' 	=> $this->account["account_id"],
					'furl_name' 		=> $row->url_name,
					'furl_host'			=> $row->url_host,
					'furl_url'			=> $row->url_url,
					'furl_favicon'		=> $row->url_favicon,
					'furl_favicon98x41'	=> $row->url_favicon98x41,
					'furl_order'		=> $i,
					'furl_created'		=> time()
				);
				
				$this->db->insert("site_favorite", $data);
				
				$i++;
			}
			
			$return['code'] = 1;
		}
		else 
		{
			$return['message'] = "您尚未登录，请点击 <a href='javascript:void(0)' onClick='location.reload();'>这里</a> 刷新后登陆。";
			$return['code'] = 0;
		}
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($return));
	}
	
	private function get_app_list ( $account_id )
	{
		// Get default user list.
		$this->db->where(array( "furl_account_id" => $account_id ));
		$this->db->order_by("furl_order", "asc");
		$favorite_list = $this->db->get( "site_favorite" )->result();
		$list = array();
		
		foreach ( $favorite_list as $row )
		{
			$list[] = array(
				"id"			=> $row->furl_id,
				"name"			=> $row->furl_name,
				"url"			=> $row->furl_url,
				"favicon"		=> $row->furl_favicon,
				"favicon98x41"	=> $row->furl_favicon98x41
			);
		}
		
		return $list;
	}
	
	private function get_default_list()
	{
		$default_list = $this->cache->get("moe_default_list");
		
		if ( ! $default_list )
		{
			// Get default user list.
			$this->db->where(array( "url_default" => 1 ));
			$default_list = $this->db->get( "site_url" )->result();
			$this->cache->save("moe_default_list", $default_list, $this->config->item('moe_memcached_time'));
		}
		
		$list = array();
		
		foreach ( $default_list as $row )
		{
			$list[] = array(
				"id"			=> $row->url_id,
				"name"			=> $row->url_name,
				"url"			=> $row->url_url,
				"favicon"		=> $row->url_favicon,
				"favicon98x41"	=> $row->url_favicon98x41
			);
		}
		
		return $list;
	}
	
	private function get_suggest_list()
	{
		$suggest_list = $this->cache->get("moe_suggest_list");
		
		if ( ! $suggest_list )
		{
			// Get default user list.
			$this->db->where(array( "url_suggest" => 1 ));
			$default_list = $this->db->get( "site_url" )->result();
			$this->cache->save("moe_suggest_list", $default_list, $this->config->item('moe_memcached_time'));
		}
		
		$list = array();
		
		foreach ( $default_list as $row )
		{
			$list[] = array(
				"id"			=> $row->url_id,
				"name"			=> $row->url_name,
				"url"			=> $row->url_url,
				"weight"		=> $row->url_weight,
				"favicon"		=> $row->url_favicon,
				"favicon98x41"	=> $row->url_favicon98x41
			);
		}
		
		return $list;
	}
	
}
