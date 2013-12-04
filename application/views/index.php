<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load header
$this->load->view("common/header", array("index" => true));
?>

<div id="moe_launcher" class="moe-launcher">
	<ul class="moe-launcher-right-panel">
		<li class="moe-loader"></li>
	</ul>
	<ul class="moe-launcher-left-tab">
		<li class="on"><i class="arrow"></i></li>
		<li></li>
		<li></li>
	</ul>
</div>

<div class="moe-content-wrapper">

	<div class="moe-left-area">

		<div id="moe_people_choice_site" class="moe-module">
			<div class="moe-module-title">
				<div class="moe-module-title-inner">
					<div class="moe-module-title-tab">
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>address/list?data=json&category=popular" class="on">综合</a>
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>address/list?data=json&category=moe">萌系</a>
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>address/list?data=json&category=bl">耽美</a>
					</div>
				</div>
				<div class="moe-module-title-mark">
					<span>大家常用的站点</span>
				</div>
			</div>
			<ul class="moe-module-content">
				<li class="moe-index-panel-hotsite">
					<div class="week-suggest-part">
						<a class="week-suggest-img moe-effect-light-aero" target="_blank" href="http://www.bilibili.tv" style="background-image: url(<?php echo $this->config->item("static");?>img/logo/115px/bilibili2233.gif);"></a>
						<div class="week-suggest-title">
							<div class="t1">本周推荐站点</div>
							<div class="t2"><a href="http://www.bilibili.tv" target="_blank">哔哩哔哩</a></div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		
		<div class="moe-h-grid">
			<ul class="moe-h-grid-list">
				<li data-source="<?php echo base_url();?>address/list?data=json&category="></li>
				<li data-source="<?php echo base_url();?>address/list?data=json&category="></li>
				<li data-source="<?php echo base_url();?>address/list?data=json&category="></li>
			</ul>
			<ul class="moe-bg-three-line"><li class="green"></li><li class="pink"></li><li class="blue"></li></ul>
		</div>
		
		<div class="moe-v-grid">
			<ul class="moe-v-grid-list" data-source="<?php echo base_url();?>address/list?data=json">
				
			</ul>
		</div>
		
	</div>

	<div class="moe-right-area">

		<div class="moe-module">
			<div class="moe-module-title">
				<div class="moe-module-title-inner">
					<div class="moe-module-title-tab">
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>news/list?data=json&category=hexieshe" class="on">和邪社</a>
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>news/list?data=json&category=aem">AEM</a>
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>news/list?data=json&category=178">178</a>
					</div>
				</div>
				<div class="moe-module-title-mark">
					<span>ACG综合信息</span>
				</div>
			</div>
			<ul class="moe-module-content moe-loader">
				<li></li>
			</ul>
		</div>
		
		<div class="moe-module">
			<div class="moe-module-title">
				<div class="moe-module-title-inner">
				</div>
				<div class="moe-module-title-mark">
					<span>近期访问</span>
				</div>
			</div>
			<ul class="moe-module-content moe-loader">
				<li></li>
			</ul>
		</div>
		
		<div class="moe-module">
			<div class="moe-module-title">
				<div class="moe-module-title-inner">
					<div class="moe-module-title-tab">
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>video/list?data=json&category=acfun" class="on">A站</a>
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>video/list?data=json&category=bili">B站</a>
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>video/list?data=json&category=tucao">吐槽</a>
					</div>
				</div>
				<div class="moe-module-title-mark">
					<span>热门动画</span>
				</div>
			</div>
			<ul class="moe-module-content moe-loader">
				<li></li>
			</ul>
		</div>
		
		<div class="moe-module">
			<div class="moe-module-title">
				<div class="moe-module-title-inner">
					<div class="moe-module-title-tab">
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>news/list?data=json&category=moegirl" class="on">萌娘百科</a>
						<a href="javascript:void(0);" data-source="<?php echo base_url();?>news/list?data=json&category=mdman">萌喵茶会</a>
					</div>
				</div>
				<div class="moe-module-title-mark">
					<span>宅闻趣事</span>
				</div>
			</div>
			<ul class="moe-module-content moe-loader">
				<li></li>
			</ul>
		</div>
		
	</div>

</div>

<div style="margin:0;padding:0;height:0;clear:both;font-size:0px;overflow:hidden"></div>

<div class="moe-wide-panel">
	<div class="moe-wide-panel-title">友情链接<div>
</div>

<?php 
// Load footer
$this->load->view("common/footer");
?>
