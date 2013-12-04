<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!DOCTYPE html>

<html>	
	<head>
		
		<meta charset="utf-8">
		<title>收藏列表</title>
		
		<link rel="icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon" />
		
		<script type="text/javascript" src="<?php echo $this->config->item('jquery');?>"></script>
		<script type="text/javascript">
			if (typeof window.parent.Site !== "undefined")
			{
				var Site = window.parent.Site;
				var Launcher = window.parent.Launcher;
			}
			else
			{
				window.location.replace( "<?php echo base_url()?>" ); 
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
			
		</style>
		
	</head>
	
	<body>
		
		
		
	</body>
	
</html>