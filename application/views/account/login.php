<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$form_error = validation_errors();
$form_error = trim(preg_replace('/\s+/', ' ', $form_error));

$message = ( ! isset( $message ) ) ? "" : $message;

if ( isset( $post ) )
{
	$username = $post['username'];
}
else
{
	$username = "";
}
?>
<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>账号登陆</title>
		
		<link rel="icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon" />
		
		<script type="text/javascript" src="<?php echo $this->config->item('jquery_bundle');?>"></script>
		<script type="text/javascript">
			if (typeof window.parent.Site !== "undefined")
			{
				var Site = window.parent.Site;
			}
			else
			{
				window.location.replace( "<?php echo base_url()?>" ); 
			}
			
			function onLogin( event )
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
			
			.login-button {
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
			
			.login-button:hover { 
				color: white;
				text-decoration: none;
			}
			
		</style>
		
	</head>
	
	<body>
	
		<form action="<?php echo base_url();?>account/login/enter" method="post">
			
			<br />
			
			<div class="input-wrapper">
				<div class="input-label">用户名</div>
				<input type="text" id="username" name="username" value="<?php echo $username;?>" placeholder="请输入用户名">
			</div>
			
			<div class="input-wrapper">
				<div class="input-label">密码</div>
				<input type="password" id="password" name="password" placeholder="请输入密码">
			</div>
			
			<div class="input-wrapper" style="height: 38px;">
				<div class="input-captcha" onClick="refreshCaptch();">
					<img id="captcha_img" src="<?php echo $this->config->item("static");?>img/please-click-captcha.jpg"></img>
				</div>
				<input type="text" id="captcha" name="captcha">
			</div>
			
			<div style="text-align: center;">
				<a class="login-button">登 陆</a><br /><br />
				<a href="javascript:void(0)" style="text-decoration: underline;" id="register">没有账号，立刻注册</a>
			</div>
		</form>
		
		<script type="text/javascript">
			
			$("#register").click(function () {
				Site.popupIframeWindow( "<?php echo base_url()?>account/register", 340, 370 );
			});
			
			$(".login-button").click( onLogin );
			
			<?php if( $form_error || $message ) { ?>
			Site.popupHint("<?php echo $form_error."<p>".$message."</p>";?>");
			<?php } ?>
			
		</script>
		
	</body>
</html>