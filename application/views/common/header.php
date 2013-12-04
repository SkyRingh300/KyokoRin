<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('P3P:CP="NON DSP COR CURa ADMa DEVa TAIa PSAa PSDa IVAa IVDa CONa HISa TELa OTPa OUR UNRa IND UNI COM NAV INT DEM CNT PRE LOC"');

$title = ( isset($title) ) ? $title." - 萌导航" : get_site_option('site_index_title');
$index = ( isset($index) && $index );
$moe_config = $this->config->item('moe');
?>
<!DOCTYPE html>

<html>

<head>
	
	<title><?php echo $title;?></title>

	<meta charset="utf-8">
	<meta name="Description" content="<?php echo get_site_option('meta_description');?>" />
	<meta name="Keywords" content="<?php echo get_site_option('meta_keywords');?>" />
	<meta name="Author" content="<?php echo get_site_option('meta_author');?>">
	<?php if ( $index ) { ?>
	<!--[if gte IE 9]>
	<meta name="application-name" content="萌导航" />
	<meta name="msapplication-tooltip" content="<?php echo get_site_option('meta_description');?>" />
	<meta name="msapplication-starturl" content="http://www.moe123.com/" />
	<meta name="msapplication-navbutton-color" content="#FFC0CB" />
	<meta name="msapplication-task" content="name=打开萌导航;action-uri=http://www.moe123.com/;icon-uri=http://www.moe123.com/favicon.ico" />
	<script type="text/javascript">
		window.external.msSiteModeClearJumpList();
		window.external.msSiteModeCreateJumplist("常用网址");
		window.external.msSiteModeAddJumpListItem("Google","http://www.google.com/","http://www.google.com/favicon.ico", "tab");
		window.external.msSiteModeAddJumpListItem("GMail","http://mail.google.com/","http://mail.google.com/favicon.ico","tab");
		window.external.msSiteModeShowJumpList(); 
	</script>
	<link rel="shortcut icon" href="<?php echo $this->config->item('static');?>img/icon/moe123-icon-32.ico?v=2" type="image/x-icon" />
	<![endif]-->
	<?php } ?>
	
	<link rel="icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?php echo $this->config->item('static');?>img/icon/moe123-icon-64.png" />
	<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo base_url();?>favicon.ico?v=2" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('jqueryui_css');?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $moe_config['loadbar_css'];?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $moe_config['site_css'];?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $moe_config['launcher_css'];?>"/>
	
	<script src="<?php echo $this->config->item('json2');?>"></script>
	<script src="<?php echo $this->config->item('seajs');?>"></script>
	<script src="<?php echo $this->config->item('seajs-text');?>"></script>
	<script src="<?php echo $this->config->item('jquery_bundle');?>"></script>
	<script src="<?php echo $this->config->item('jquery_plugin');?>"></script> 
	<script type="text/javascript">
		$.ajax( { cache : false } );
		seajs.config({ 
			alias: { 
				"Loadbar" : "<?php echo $moe_config['loadbar_js'];?>", 
				"Site" : "<?php echo $moe_config['site_js'];?>",
				"Launcher" : "<?php echo $moe_config['launcher_js'];?>"
			}
		});
	</script>
</head>

<body>

<script type="text/javascript"> ( $(window).width() > 1280 ) ? $("body").addClass("moe-widescreen") : $("body").removeClass("moe-widescreen"); </script>

<div class="moe-site-navi">
	<div class="moe-site-navi-container">
		<a href="javascript:void(0)" class="time" id="time_span">准备中.....</a>
		<a href="http://www.moe123.com/portal/switch_mobile" style="padding-left: 5px; padding-right: 8px;"><i class="icon-phone"></i> 移动版</a>
		<div class="login-panel">
			<a href="javascript:void(0)" class="login">登录</a>
			<a href="javascript:void(0)" class="register moe-effect-flashing">注册</a>
		</div>
		<div class="account-panel">
			<a href="javascript:void(0)" class="account-name">wangze500</a>
			<a href="javascript:void(0)" class="logout">注销</a>
		</div>
	</div>
</div>

<div class="moe-header">
	<div class="moe-header-showbox">
		<img src="<?php echo $this->config->item('static');?>img/sp/kyoko-2013-summer-1380x450.jpeg"/>
	</div>
	<div class="moe-header-search">
		<div class="moe-header-search-input">
			<div class="moe-header-search-select">
				<span>Google</span>
				<select>
					<option></option>
				</select>
			</div>
			<input type="text"></input>
		</div>
		<div class="moe-header-search-button">搜 索</div>
	</div>
	<a class="moe-header-logo" href="<?php echo base_url();?>" title="萌导航"><img src="<?php echo $this->config->item('static');?>img/spaceball.gif"></a>
</div>

<div class="moe-container">
