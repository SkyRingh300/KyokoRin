<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$moe_config = $this->config->item('moe');
?>
	</div> </div> </div>
	
	<div class="moe-footer">
		
	</div>
	
	<div id="window_layer" class="moe-fullscreen-mask">
	
		<div id="iframe_window" class="moe-window">
			<div class="moe-window-panel">
				<iframe frameborder="0" marginheight="0" marginwidth="0" border="0"></iframe>
			</div>
			<a class="moe-window-close" href="javascript:void(0)"></a>
		</div>
		
		<div id="content_window" class="moe-window">
			<div class="moe-window-panel"></div>
			<a class="moe-window-close" href="javascript:void(0)"></a>
		</div>
		
	</div>
	
	<div id="alert_layer" class="moe-fullscreen-mask">
	
		<div id="alert_window" class="moe-window">
			<div class="moe-window-panel"></div>
		</div>
		
	</div>
	
	<div class="moe-hint"></div>
	
	<script type="text/javascript">
		seajs.use("Loadbar", function () {
			window.Loadbar.setValue(20, "加载模块..."); 
			seajs.use("Site", function ( Site ) {
				var site = new Site("<?php echo base_url();?>");
			});
		}); 
	</script>
</body>

<!-- 
	这次改版感谢Ray Hwang提供的设计...
-->
	
</html>
