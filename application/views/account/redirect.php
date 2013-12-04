<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!DOCTYPE html>

<html>	
	<head>
		
		<script>
			
			if (typeof window.parent.Site !== "undefined")
			{
				var Site = window.parent.Site;
			}
			else
			{
				window.location.replace("<?php echo base_url()?>"); 
			}
			
<?php 
switch ( $step ) {
	
	case "login_successful":
?>
			Site.popupHint("登录成功~");
			Site.refreshAccount();
			Site.hideWindow();
<?php 
		break;
		
	case "registration_successful":
?>
			Site.popupHint("注册成功,请登录.");
			Site.popupIframeWindow( "<?php echo base_url()?>account/login", 340, 320 );
<?php 
		break;
}
?>
			
		</script>
		
	</head>
</html>