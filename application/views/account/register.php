<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$form_error = validation_errors();
$form_error = trim(preg_replace('/\s+/', ' ', $form_error));

$message = ( ! isset( $message ) ) ? "" : $message;
?>
<!DOCTYPE html>

<html>
	
	<head>
		<meta charset="utf-8">
		<title>账号注册</title>
		
		<link rel="icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon" />
		<script src="<?php echo $this->config->item('jquery_bundle');?>"></script>
		
		<script type="text/javascript">
			if (typeof window.parent.Site !== "undefined")
			{
				var Site = window.parent.Site;
			}
			else
			{
				window.location.replace("<?php echo base_url()?>"); 
			}
			
			function onRegister()
			{
				$("form").submit();
			}
			
			function refreshCaptch()
			{
				$("#captcha_img").attr("src", "<?php echo $this->config->item("static");?>img/none-captcha.jpg");
				
				$.getJSON("<?php echo base_url()?>account/captcha", function (data) {
					$("#captcha_img").attr("src", data.img);
				});
			}
		</script>
		
		<style type="text/css">
			body, h1, h2, h3, h4, h5, h6, hr, p, blockquote, dl, dt, dd, ul, ol, li, pre, form, fieldset, legend, button, input, textarea, th, td { margin: 0;padding: 0;}

			html, body { 
				_zoom: 1; 
				height: 100%;
				font: 13px/100% Arial,Helvetica,sans-serif; 
				color: #666; 
			}
			
			a { 
				outline: 0; 
				color: #666; 
				font-weight: normal; 
				text-decoration: none; 
			} 

			a:hover{ 
				color: #f30;
				text-decoration: underline; 
			} 

			a img { 
				border: 0px;
			}
		
			.input-wrapper {
				border: 1px solid #DEDEDE;
				position: relative;
				margin: 10px auto;
				border-radius: 4px;
				height: 33px;
				width: 265px;
				background: white;
			}
			
			.input-label {
				position: relative;
				width: 70px;
				height: 26px;
				margin: 4px;
				margin-right: 0px;
				line-height: 26px;
				float: left;
				border-right: 1px solid #DEDEDE;
			}
			
			.input-captcha {
				position: relative;
				width: 153px;
				height: 30px;
				margin: 4px;
				margin-right: 0px;
				line-height: 30px;
				float: left;
				cursor: pointer;
				border-right: 1px solid #DEDEDE;
			}
			
			.input-wrapper input {
				width: 186px;
				position: absolute;
				right: 2px;
				top: 2px;
				height: 28px;
				line-height: 28px;
				border: none;
				background: none;
			}
			
			#captcha { 
				width: 102px; 
				height: 32px;
				line-height: 32px;
			}
			
			.register-button {
				margin: 7px;
				margin-left: 0px;
				border-radius: 4px;
				width: 200px;
				height: 32px;
				border-bottom: 3px solid #70B8B7;
				background: #8CD1D1;
				text-align: center;
				display: inline-block;
				*display: inline;
				*zoom: 1;
				line-height: 32px;
				color: white;
				text-shadow: 1px 1px 2px #111;
				cursor: pointer;
				-webkit-touch-callout: none;
				-webkit-user-select: none;
				-khtml-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}
			
			.register-button:hover { 
				color: white;
				text-decoration: none;
			}
			
		</style>
		
	</head>
	
	<body>
	
		<form action="<?php echo base_url();?>account/register/registration" method="post">
			
			<br />
			
			<div class="input-wrapper">
				<div class="input-label">用户名</div>
				<input type="text" id="username" name="username">
			</div>
			
			<div class="input-wrapper">
				<div class="input-label">密码</div>
				<input type="password" id="password" name="password">
			</div>
			
			<div class="input-wrapper">
				<div class="input-label">重复密码</div>
				<input type="password" id="password_repeat" name="password_repeat">
			</div>
			
			<div class="input-wrapper">
				<div class="input-label">电子邮箱</div>
				<input type="text" id="email" name="email">
			</div>
			
			<div class="input-wrapper" style="height: 38px;">
				<div class="input-captcha" onClick="refreshCaptch();">
					<img id="captcha_img" src="<?php echo $this->config->item("static");?>img/please-click-captcha.jpg"></img>
				</div>
				<input type="text" id="captcha" name="captcha">
			</div>
			
			<div style="text-align: center;">
				<a href="javascript:void(0)" class="register-button">注 册</a><br /><br />
				<a href="javascript:void(0)" style="text-decoration: underline;" id="login">已有账号？点我登陆</a>
			</div>
		</form>
		
		<script>
			$("#login").click(function () {
				Site.popupIframeWindow( "<?php echo base_url()?>account/login", 340, 280 );
			});
			
			$(".register-button").click(onRegister);
			
			<?php if( $form_error || $message ) { ?>
			Site.popupHint("<?php echo $form_error."<p>".$message."</p>";?>");
			<?php } ?>
		</script>
		
	</body>
</html>