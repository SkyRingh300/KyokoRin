/*
	░░░░░▄▄▄▄▀▀▀▀▀▀▀▀▄▄▄▄▄▄░░░░░░░
	░░░░░█░░░░▒▒▒▒▒▒▒▒▒▒▒▒░░▀▀▄░░░░
	░░░░█░░░▒▒▒▒▒▒░░░░░░░░▒▒▒░░█░░░
	░░░█░░░░░░▄██▀▄▄░░░░░▄▄▄░░░░█░░
	░▄▀▒▄▄▄▒░█▀▀▀▀▄▄█░░░██▄▄█░░░░█░
	█░▒█▒▄░▀▄▄▄▀░░░░░░░░█░░░▒▒▒▒▒░█
	█░▒█░█▀▄▄░░░░░█▀░░░░▀▄░░▄▀▀▀▄▒█
	░█░▀▄░█▄░█▀▄▄░▀░▀▀░▄▄▀░░░░█░░█░
	░░█░░░▀▄▀█▄▄░█▀▀▀▄▄▄▄▀▀█▀██░█░░
	░░░█░░░░██░░▀█▄▄▄█▄▄█▄████░█░░░
	░░░░█░░░░▀▀▄░█░░░█░█▀██████░█░░
	░░░░░▀▄░░░░░▀▀▄▄▄█▄█▄█▄█▄▀░░█░░
	░░░░░░░▀▄▄░▒▒▒▒░░░░░░░░░░▒░░░█░
	░░░░░░░░░░▀▀▄▄░▒▒▒▒▒▒▒▒▒▒░░░░█░
	░░░░░░░░░░░░░░▀▄▄▄▄▄░░░░░░░░█░░
	
	Author: Octopus
	Google+: +Tomomi Sawko
	Email: akatako@aka-tako.com
*/

define(function(require, exports, module) {
	
	function Launcher( serviceBase ) 
	{ 
		this.serviceBase = serviceBase;
		this.siteData = [];
		this._init();
	}
	
	Launcher.prototype._init = function () 
	{
		$(document).ready(this._pageRendered());
	}
	
	Launcher.prototype._pageRendered = function () 
	{
		var self = this;
		
		return function () {
			
			$("#moe_launcher .moe-launcher-left-tab").empty();
			$("#moe_launcher .moe-launcher-right-panel").empty();
			
			self._createAddressPanel();
			self._createBangumiPanel();
			self._createGamePanel();
			
			$("#moe_launcher .moe-launcher-left-tab li:eq(0)").trigger("click");
		}
	}
	
	Launcher.prototype._onTabButtonClick = function () 
	{
		var self = this;
		
		return function (e) {
			if ( $(this).hasClass("on") ) return;
			
			$("#moe_launcher .moe-launcher-left-tab li").removeClass("on");
			$(this).addClass("on");
			
			self._switchPanel($(this).attr('data-type'));
		}
	}
	
	Launcher.prototype._createAddressPanel = function () 
	{
		var tab = $('<li data-type="address"><i class="moe-icon-fav"></i><span>收藏夹</span><i class="arrow"></i></li>')
					.click(this._onTabButtonClick())
					.appendTo("#moe_launcher .moe-launcher-left-tab"),
			panel = $('<li class="address" data-type="address"></li>').appendTo("#moe_launcher .moe-launcher-right-panel");
	}
	
	Launcher.prototype._onEditAddressListClicked = function ( event ) 
	{
		var self = this;
		return function () {
			if ( Site.userData != false )
			{
				self._renderModifyAddressList( Site.popupWindow( 580, 460 ) );
			}
			else
			{
				Site.refreshAccount( true );
			}
		}
	}
	
	Launcher.prototype._renderModifyAddressList = function ( panel )
	{
		panel.append('<div class="moe-add-address-thin-form-options"></div>');
		$("<a href='javascript:void(0)'>恢复为默认网址</a>").click(function () {
			Site.popupAlert(250, 100, "是否要恢复默认?", function () {
				$.post( self.serviceBase + "reset", function( data ) {
					if ( data.code == 1 )
					{
						self._refreshAddressList(true, function () {
							self._renderModifyAddressList( Site.popupWindow( 580, 460 ) );
						});
					}
					else
					{
						Site.popupHint(data.message);
					}
				}).fail(function() {
					Site.popupHint("与服务器通信失败,请重试操作.");
				});
			})
		}).appendTo(".moe-add-address-thin-form-options");
		
		list = $("<ul class='moe-launcher-site-modify-list'>").appendTo( panel );
		
		if ( this.siteData.length > 0 )
		{
			for ( var i = 0; i < this.siteData.length; i++ )
			{
				var data = this.siteData[i];
				
				var li = $("<li data-id='" + data.id + "' ><span>" + data.name + "</span></li>");
				
				$("<i class='close'></i>")
					.click( this._onDeleteAddress() )
					.appendTo(li);
				
				li.appendTo( list );
			}
		}
		else
		{
			list.addClass("moe-nothing");
		}
		
		list.sortable({
		
			update: function (event, ui){
				var id_list = "";
				list.find("li").each(function () {
					id_list += ( $(this).attr("data-id") + "," );
				});
				id_list = id_list.slice(0, id_list.length - 1);
				
				Loadbar.setValue(20, "与服务器通信中,请稍后...");
				$.post( self.serviceBase + "sorts", { ids: id_list }, function( data ) {
					if ( data.code == 1 )
					{
						self._refreshAddressList(true, function () {
							self._renderModifyAddressList( Site.popupWindow( 580, 460 ) );
						});
					}
					else
					{
						Site.popupHint(data.message);
					}
				}).fail(function(data) {
					Site.popupHint("与服务器通信失败,请重试操作.");
				});
			}
			
		});
		
		list.disableSelection();
		
		var form = $('<div class="moe-add-address-thin-form">').appendTo(panel),
			self = this;
		
		form.append('<div class="moe-input-wrapper" id="website_name"><div class="moe-input-label">网站名称</div><input placeholder="例：萌导航"></div>')
			.append('<div class="moe-input-wrapper" id="website_address"><div class="moe-input-label">网址</div><input placeholder="例：www.moe123.com"></div>');
		
		$('<a href="javascript:void(0)" class="moe-button">保 存</a>')
			.click( function ( event ) {
				$.post( self.serviceBase + "add", { 
					name: $("#website_name input").val(), 
					url: $("#website_address input").val() 
				}, function( data ) {
					if ( data.code == 1 )
					{
						self._refreshAddressList(true, function () {
							self._renderModifyAddressList( Site.popupWindow( 580, 460 ) );
						});
					}
					else
					{
						Site.popupHint(data.message);
					}
				}).fail(function() {
					Site.popupHint("与服务器通信失败,请重试操作.");
				});
			}).appendTo( form );
	}
	
	Launcher.prototype._onAddAddressClicked = function ( event ) 
	{
		var self = this;
		return function () {
			if ( Site.userData != false )
			{
				self._renderAddAddress( Site.popupWindow( 320, 193 ) );
			}
			else
			{
				Site.refreshAccount( true );
			}
		}
	}
	
	Launcher.prototype._renderAddAddress = function ( panel )
	{
		var form = $('<div class="moe-add-address-form">').appendTo(panel),
			self = this;
		
		form.append('<div class="moe-input-wrapper" id="website_name"><div class="moe-input-label">网站名称</div><input placeholder="例：萌导航"></div>')
			.append('<div class="moe-input-wrapper" id="website_address"><div class="moe-input-label">网址</div><input placeholder="例：www.moe123.com"></div>');
		
		$('<a href="javascript:void(0)" class="moe-button">保 存</a>')
			.click( function ( event ) {
				$.post( self.serviceBase + "add", { 
					name: $("#website_name input").val(), 
					url: $("#website_address input").val() 
				}, function( data ) {
				
					if ( data.code == 1 )
					{
						self._refreshAddressList(true);
						Site.hideWindow();
					}
					else
					{
						Site.popupHint(data.message);
					}
					
				}).fail(function() {
					
				});
			}).appendTo( form );
	}
	
	Launcher.prototype._onDeleteAddress = function ()
	{
		var self = this;
		return function ( event ) {
			$.post( self.serviceBase + "delete", { 
				id: $(this).parent().attr("data-id")
			}, function( data ) {
			
				if ( data.code == 1 )
				{
					self._refreshAddressList(true, function () {
						self._renderModifyAddressList( Site.popupWindow( 580, 460 ) );
					});
				}
				else
				{
					Site.popupHint(data.message);
				}
				
			}).fail(function() {
				
			});
		}
	}
	
	Launcher.prototype._refreshAddressList = function ( loggedIn, callback ) 
	{
		var self = this;
		var panel = $("#moe_launcher .moe-launcher-right-panel .address");
		
		if ( ! loggedIn )
		{
			panel.empty();
			panel.addClass("moe-loader");
			
			Loadbar.setValue(20, "与服务器通信中...");
			
			$.getJSON(this.serviceBase + "lists", function ( data ) {
			
				Loadbar.setValue(100, false, true);
				panel.removeClass("moe-loader");
				self.siteData = data;
				self._renderAddressList(data);
				
				if ( callback ) callback();
				
			}).fail(function( data ) {
			
				Loadbar.setValue(100, false, true);
				Site.popupHint("与服务器通信失败,请重试操作.");
				
			});
		}
		else
		{
			panel.empty();
			panel.addClass("moe-loader");
			
			Loadbar.setValue(20, "与服务器通信中...");
			
			$.getJSON( this.serviceBase + "lists", function ( data ) {
			
				Loadbar.setValue(100, false, true);
				panel.removeClass("moe-loader");
				self.siteData = data;
				self._renderAddressList(data);
				
				if ( callback ) callback();
				
			}).fail(function( data ) {
			
				Loadbar.setValue(100, false, true);
				Site.popupHint("与服务器通信失败,请重试操作.");
				
			});
		}
	}
	
	Launcher.prototype._renderAddressList = function () 
	{
		var panel = $("#moe_launcher .moe-launcher-right-panel .address");
		panel.empty();
		
		$("<a class='backward' href='javascript:void(0)'><i class='moe-icon-backward disable'></i></a>")
			.addClass("moe-launcher-thin-button")
			.click( this._onAddressListBackward() )
			.appendTo( panel );
		
		$("<a class='forward' href='javascript:void(0)'><i class='moe-icon-forward disable'></i></a>")
			.addClass("moe-launcher-thin-button")
			.click( this._onAddressListForward() )
			.appendTo( panel );
		
		var dataPanel = 
			$("<div class='data-panel'></div>")
				.appendTo( panel );
		
		if ( this.siteData.length > 0 ) {
			for ( var l = 0; l < this.siteData.length; l++ ) {
				var item = $( "<a class='item' href='" + this.siteData[l].url + "' target='_blank'></a>" ),
					icon = this.siteData[l].favicon98x41;
				item.append("<div class='img" + ( ( icon ) ? "' style='background:url(" + icon + "); border: 1px solid transparent;'>" : " empty'>" ) + "</div>");
				item.append("<span>" + this.siteData[l].name + "</span>");
				item.appendTo( dataPanel );
			}
		}
		else
		{
			dataPanel.addClass("moe-nothing");
		}
		
		this._makeAddressListPage();
		
		var controlPanel = 
			$("<div class='contronl-panel'></div>")
				.appendTo( panel );
		
		var modifyButton = 
			$("<a class='item' href='javascript:void(0)'><i class='moe-icon-modify'></i><span>修改网站</span></a>")
				.appendTo( controlPanel )
				.click( this._onEditAddressListClicked() );
		
		var addButton = 
			$("<a class='item' href='javascript:void(0)'><i class='moe-icon-add'></i><span>收藏网站</span></a>")
				.appendTo( controlPanel )
				.click( this._onAddAddressClicked() );
	}
	
	Launcher.prototype._makeAddressListPage = function () 
	{
		$("#moe_launcher .address > .data-panel > .item").show();
		$("#moe_launcher .address > .backward > i").addClass("disable");
		$("#moe_launcher .address > .forward > i").addClass("disable");
		
		if ( $(".moe-widescreen").length > 0 )
		{
			if ( $("#moe_launcher .address > .data-panel > .item").length <= 14 ) return;
			
			$("#moe_launcher .address > .forward > i").removeClass("disable");
			$("#moe_launcher .address > .data-panel > .item:gt(13)").hide();
		}
		else
		{
			if ( $("#moe_launcher .address > .data-panel > .item").length <= 8 ) return;
			
			$("#moe_launcher .address > .forward > i").removeClass("disable");
			$("#moe_launcher .address > .data-panel > .item:gt(7)").hide();
		}
		
	}
	
	Launcher.prototype._onAddressListBackward = function () 
	{
		var self = this;
		
		return function ( event ) {
			
			if ( $(this).find("i").hasClass("disable") ) return;
			
			var start = $("#moe_launcher .address > .data-panel > .item:visible:first").index();
			var offset = ( $(".moe-widescreen").length > 0 ) ? 14 : 8;
			
			$("#moe_launcher .address > .forward > i").removeClass("disable");
			
			if ( start - offset > 0 )
			{
				$("#moe_launcher .address > .data-panel > .item").stop(true, true).fadeIn();
				$("#moe_launcher .address > .data-panel > .item:gt(" + ( start - 1 ) + ")").hide();
				$("#moe_launcher .address > .data-panel > .item:lt(" + ( start - offset ) + ")").hide();
			}
			else
			{
				$("#moe_launcher .address > .backward > i").addClass("disable");
				
				$("#moe_launcher .address > .data-panel > .item").stop(true, true).fadeIn();
				$("#moe_launcher .address > .data-panel > .item:gt(" + ( start - 1 ) + ")").hide();
			}
			
		}
		
	}
	
	Launcher.prototype._onAddressListForward = function () 
	{
		var self = this;
		
		return function ( event ) {
			
			if ( $(this).find("i").hasClass("disable") ) return;
			
			var start = $("#moe_launcher .address > .data-panel > .item:visible:last").index();
			var offset = ( $(".moe-widescreen").length > 0 ) ? 14 : 8;
			var total = $("#moe_launcher .address > .data-panel > .item").length - 1;
			
			$("#moe_launcher .address > .backward > i").removeClass("disable");
			
			if ( start + offset < total )
			{
				$("#moe_launcher .address > .data-panel > .item").stop(true, true).fadeIn();
				$("#moe_launcher .address > .data-panel > .item:lt(" + ( start + 1 ) + ")").hide();
				$("#moe_launcher .address > .data-panel > .item:gt(" + ( start + offset ) + ")").hide();
			}
			else
			{
				$("#moe_launcher .address > .forward > i").addClass("disable");
				
				$("#moe_launcher .address > .data-panel > .item").stop(true, true).fadeIn();
				$("#moe_launcher .address > .data-panel > .item:lt(" + ( start + 1 ) + ")").hide();
			}
			
		}
		
	}
	
	Launcher.prototype._createBangumiPanel = function () 
	{
		$("#moe_launcher .moe-launcher-left-tab").append('<li data-type="bangumi"><i class="moe-icon-time"></i><span>敬请期待</span><i class="arrow"></i></li>');
	/*
		var tab = $('<li data-type="bangumi"><i class="moe-icon-bangumi"></i><span>看新番</span><i class="arrow"></i></li>')
					.click(this._onTabButtonClick())
					.appendTo("#moe_launcher .moe-launcher-left-tab"),
			panel = $('<li data-type="bangumi"></li>').appendTo("#moe_launcher .moe-launcher-right-panel")
			lang = ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
			today = new Date().getDay();
			
		var title = $("<div class='title'></div>").appendTo(panel);
		var swtich = $("<ul class='switch'></ul>").appendTo(title);
		var sort = $("<div class='sort'></div>").appendTo(title);
		
		for (var i = 1; i < 7; i++)
		{
			swtich.append("<li data-weekday='" + i + "'" + (( i == today ) ? " class='on'" : "") + ">" + lang[i] + "</li>");
		}
		
		swtich.append("<li data-weekday='0'" + (( 0 == today ) ? " class='on'" : "") + ">" + lang[0] + "</li>");
		
		sort.append(
			"<li data-source='bilibili'>B站</li>" +
			"<li data-source='acfun'>A站</li>" +
			"<li data-source='tucao'>吐槽</li>"
		);
	*/
	}
	
	Launcher.prototype._createGamePanel = function () 
	{
		$("#moe_launcher .moe-launcher-left-tab").append('<li data-type="bangumi"><i class="moe-icon-time"></i><span>敬请期待</span><i class="arrow"></i></li>');
	/*
		var tab = $('<li data-type="game"><i class="moe-icon-game"></i><span>玩游戏</span><i class="arrow"></i></li>')
					.click(this._onTabButtonClick())
					.appendTo("#moe_launcher .moe-launcher-left-tab"),
			panel = $('<li data-type="game"></li>').appendTo("#moe_launcher .moe-launcher-right-panel");
	*/
	}
	
	Launcher.prototype._switchPanel = function ( type ) 
	{
		$("#moe_launcher .moe-launcher-right-panel li").each(function (k, v) {
			if ( $(this).attr("data-type") != type ) return;
			$("#moe_launcher .moe-launcher-right-panel > li").hide();
			$(this).stop(true, true).fadeIn('fast');
		});
	}
	
	Launcher.prototype._getTabPanel = function ( type ) 
	{
		var tab = false, panel = false;
		
		$("#moe_launcher .moe-launcher-left-tab li").each(function (k, v) {
			tab = ( $( this ).attr("data-type") == type ) ? $( this ) : false;
		});
		
		$("#moe_launcher .moe-launcher-right-panel li").each(function (k, v) {
			panel = ( $( this ).attr("data-type") == type ) ? $( this ) : false;
		});
		
		return [tab, panel];
		
	}
	
	Launcher.prototype._adjustPageContainer = function ( event ) 
	{
		this._renderAddressList();
	}
	
	Launcher.prototype.onAccountLoggedIn = function ( data )
	{
		this._refreshAddressList( true );
	}
	
	Launcher.prototype.onAccountLoggedOut = function ( data )
	{
		this._refreshAddressList( false );
	}
	
	module.exports = Launcher;
});