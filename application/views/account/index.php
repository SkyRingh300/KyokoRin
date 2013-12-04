<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$moe_config = $this->config->item('moe');
?>
<!DOCTYPE html>

<html>	
	<head>
		
		<script>
			
			if (typeof window.parent.Index !== "undefined")
			{
				var Index = window.parent.Index;
				Index.refreshAccount();
				Index.hideWindow();
			}
			else
			{
				window.location.replace("<?php echo base_url()?>"); 
			}
			
		</script>
		
	</head>
</html>