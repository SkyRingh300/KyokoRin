<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	
	private $register_valid = array(
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'trim|alpha_dash|required|xss_clean|min_length[4]|max_length[16]|is_unique[account.account_name]'
		),
		
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required|min_length[6]|max_length[16]|matches[password_repeat]'
		),
		
		array(
			'field' => 'password_repeat',
			'label' => '密码确认',
			'rules' => 'trim|required'
		),

		array(
			'field' => 'email',
			'label' => '邮箱',
			'rules' => 'trim|strip_tags|required|valid_email|max_length[64]|is_unique[account.account_email]'
		),
		
		array(
			'field' => 'captcha',
			'label' => '验证码',
			'rules' => 'trim|alpha_dash|required|max_length[12]|callback_validation_captcha'
		)
	);

	private $login_valid = array(
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'trim|alpha_dash|required|xss_clean|min_length[4]|max_length[16]'
		),
		
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required|min_length[6]|max_length[16]'
		),
		
		array(
			'field' => 'captcha',
			'label' => '验证码',
			'rules' => 'trim|alpha_dash|required|max_length[12]|callback_validation_captcha'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper("Site");
		$this->load->helper("Account");
		
		$this->load->library("form_validation");
	}
	
	public function account_information( $type = "json" )
	{
		if ( $type == "json" )
		{
			$account = get_account_information();
			
			if ( ! $account )
			{
				$account = array("code" => 0);
			}
			else
			{
				$account = array(
					"code" 		=> 1,
					"id" 		=> $account['account_id'],
					"username" 	=> $account['account_name']
				);
			}
			
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($account));
			return;
		}
		
		redirect('/', 'refresh');
	}
	
	// Public login page.
	public function login( $do = "" )
	{
		if ( $do != "enter" )
		{
			$this->load->view("account/login");
			return;
		}
		
		$this->validation_login_form();
		
	}
	
	public function logout( $type = "json" )
	{
		if ( $type == "json" )
		{
			$return = array("code" => 1);
			
			account_logout();
			
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($return));
			
			return;
		}
		
		redirect('/', 'refresh');
	}
	
	public function validation_captcha( $captcha = "" )
	{
		// 首先删除旧的验证码
		$expiration = time() - 7200;
		$this->db->where('captcha_time <', $expiration); 
		$this->db->delete('captcha');
		
		// 然后再看是否有验证码存在:
		$this->db->where('captcha_word', $captcha); 
		$this->db->where('captcha_ip', $this->input->ip_address());
		$this->db->where('captcha_time >', $expiration);
		$query = $this->db->get('captcha');
		
		if ($query->num_rows() < 1)
		{
			if (isset($this->form_validation))
				$this->form_validation->set_message('validation_captcha', '%s 输入不正确.');
			
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	private function validation_login_form()
	{
		$post = $this->input->post();
		$data = array("post" => $post);
		
		$this->form_validation->set_rules($this->login_valid);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('account/login', $data);
		}
		else
		{
			$status = account_sign_in($post['username'], $post['password']);
			
			if ($status == 1)
			{
				$data['step'] = "login_successful";
				$this->load->view('account/redirect', $data);
			}
			else if ($status == -1)
			{
				$data['message'] = "用户名或密码输入错误.";
				$this->load->view('account/login', $data);
			}
			else if ($status == -2)
			{
				$data['message'] = "用户不存在, 您可以<a href='".base_url()."account/register'>注册</a>.";
				$this->load->view('account/login', $data);
			}
			else
			{
				$data['message'] = "服务器暂不可用, 请稍后重试.";
				$this->load->view('account/login', $data);
			}
		}
	}
	
	// Public register page.
	public function register( $do = "" )
	{
		if ( $do != "registration" )
		{
			$this->load->view("account/register");
			return;
		}
		
		$this->validation_registration_form();
	}
	
	private function validation_registration_form()
	{
		$post = $this->input->post();
		
		$this->form_validation->set_rules($this->register_valid);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('account/register');
		}
		else
		{
			$status = account_create($post['username'], $post['password'], $post['email']);
			$data['step'] = "registration_successful";
			$this->load->view('account/redirect', $data);
		}
	}
	
	public function captcha()
	{
		$r = get_site_captcha();
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('img' => $r['img_url'])));
	}
	
}