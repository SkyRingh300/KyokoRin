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
	
	function Site( serviceBase ) 
	{ 
	
		window.Site = this;
		
		this.serviceBase = serviceBase;
		this.userData = false;
		this.launcher = new (require('Launcher'))( serviceBase + "favorite/" );
		this._init();
		
		window.Loadbar.setValue(100, false, true);
	}
	
	Site.prototype._init = function () 
	{
		
		// Bind event.
		$( "body" ).bind( "contextmenu activate resize focus keyup keydown mouseleave mousemove mouseenter mousedown mouseup", this._bindBodyHandlers());
		$( window ).bind( "resize", this._bindWindowHandlers() );
		
		var self = this;
		
		$("img.lazy_img").lazyload({ effect : "fadeIn", failure_limit : 10 });
		
		$(".moe-site-navi-container .login").click(function ( event ) {
			self.popupIframeWindow( self.serviceBase + "account/login", 340, 280 );
		});
		
		$(".moe-site-navi-container .register").click(function ( event ) {
			self.popupIframeWindow( self.serviceBase + "account/register", 340, 370 );
		});
		
		$(".moe-site-navi-container .logout").click(function ( event ) {
			$.getJSON(self.serviceBase + "account/logout" , function ( data ) {
				self.refreshAccount();
			});
		});
		
		$(".moe-window-close").click(this.hideWindow);
		$(".moe-hint").click(this.hideHint);
		
		setInterval(self._updateTime, 1000);
		
		this._handleWindowResize( false );
		this._updateTime();
		this.refreshAccount();
	}
	
	Site.prototype._updateTime = function () 
	{
		var currentTime = new Date()
		var hours = currentTime.getHours(), minutes = currentTime.getMinutes()
		if (minutes < 10) minutes = "0" + minutes;
		var t_str = hours + ":" + minutes + " ";
		if (hours > 11) t_str += "PM"; else t_str += "AM";
		$('#time_span').html(t_str);
		$('#time_span_2').html(t_str);
	}
	
	Site.prototype._bindBodyHandlers = function () 
	{
	
		var self = this;
		
		return function ( event ) {
			
			// Body Events Condition Tree
			switch (event.type)
			{
				case 'contextmenu':
					self._handleBodyContextMenu( event );
					break;
				
				case 'activate':
					break;
				
				case 'resize':
					self._handleWindowResize( event );
					break;
				
				case 'mousemove':
					break;
				
				case 'focus':
					//break;
				
				case 'keyup':
					//break;
					
				case 'keydown':
					//break;
					
				case 'mouseleave':
					//break;
				
				case 'mouseenter':
					//break;
					
				case 'mousedown':
					//break;
				
				case 'mouseup':
					//break;
				
				default:
					break;
			}
		}
	}
	
	Site.prototype._bindWindowHandlers = function () 
	{
	
		var self = this;
		
		return function ( event ) {
		
			// Window Events Condition Tree
			switch ( event.type )
			{
				case 'resize':
					self._handleWindowResize( event );
					break;
					
				default: 
					break;
			}
		}
	}
	
	Site.prototype._handleBodyContextMenu = function ( event ) 
	{
		
		//event.preventDefault();
		
	}
	
	Site.prototype.popupIframeWindow = function ( url, width, height )
	{
		$("#window_layer, .moe-window").hide();
		
		$("#iframe_window")
			.css({
				"margin-top" : "-" + (height / 2) + "px",
				"height" : height + "px",
				"margin-left" : "-" + (width / 2) + "px",
				"width" : width + "px"
			})
			.show()
			.find("iframe")
			.attr("src", url);
		
		$("#window_layer").stop(true, true).fadeIn( "fast" );
	}
	
	Site.prototype.hidePopupIframeWindow = function ()
	{
		$("#window_layer, .moe-window").hide();
	}
	
	Site.prototype.popupWindow = function ( width, height )
	{
		$("#window_layer .moe-window").hide();
		
		$("#content_window").css({
			"margin-top" : "-" + (height / 2) + "px",
			"height" : height + "px",
			"margin-left" : "-" + (width / 2) + "px",
			"width" : width + "px"
		}).show();
		
		$("#window_layer").stop(true, true).fadeIn( "fast" );
		
		return $("#content_window .moe-window-panel").empty();
	}
	
	Site.prototype.hideWindow = function ()
	{
		$("#window_layer, .moe-window").hide();
	}
	
	Site.prototype.popupAlert = function ( width, height, text, callback )
	{
		var self = this;
		
		$("#alert_window").css({
			"margin-top" : "-" + (height / 2) + "px",
			"height" : height + "px",
			"margin-left" : "-" + (width / 2) + "px",
			"width" : width + "px"
		}).show();
		
		$("#alert_window .moe-window-panel").empty();
		$("<div class='moe-window-text'>" + text + "</div>").appendTo("#alert_window .moe-window-panel");
		
		var button_group = $("<div class='moe-window-button-group'></div>");
		
		$("<a href='javascript:void(0)' class='moe-button'>")
			.html("确认")
			.click(function () {
				self.hideAlert();
				if ( callback ) callback();
			}).appendTo(button_group);
		
		$("<a href='javascript:void(0)' class='moe-button'>")
			.html("取消")
			.click(function () {
				self.hideAlert();
			}).appendTo(button_group);
		
		button_group.appendTo("#alert_window .moe-window-panel");
		
		$("#alert_layer").stop(true, true).fadeIn( "fast" );
	}
	
	Site.prototype.hideAlert = function ()
	{
		$("#alert_layer").hide();
	}
	
	Site.prototype.refreshAccount = function ( needLogin, callback ) 
	{
		var self = this;
		
		Loadbar.setValue(20, "与服务器通信中...");
		
		$.getJSON( this.serviceBase + "account/account_information", function( data ) {
		
			Loadbar.setValue(100, false, true);
			
			if ( data.code == 1 )
			{
				self.onAccountLoggedIn( data );
				if ( callback ) callback();
			}
			else
			{
				self.onAccountLoggedOut();
				if ( needLogin ) 
					self.popupIframeWindow( self.serviceBase + "account/login", 340, 280 );
			}
			
		}).fail(function( data ) {
		
			Loadbar.setValue(100, false, true);
			self.popupHint("与服务器通信失败! T口T");
			
			self.onAccountLoggedOut();
			if ( needLogin ) 
				self.popupIframeWindow( self.serviceBase + "account/login", 340, 280 );
			
		});
	}
	
	Site.prototype.onAccountLoggedIn = function ( data )
	{
		this.userData = data;
		
		$(".login-panel").hide();
		$(".account-panel").stop(true, true).fadeIn("fast");
		$(".account-panel .account-name").html(data.username);
		
		this.launcher.onAccountLoggedIn( data );
	}
	
	Site.prototype.onAccountLoggedOut = function ()
	{
		this.userData = false;
		
		$(".login-panel").stop(true, true).fadeIn("fast");
		$(".account-panel").hide();
		
		this.launcher.onAccountLoggedOut();
	}
	
	Site.prototype.popupHint = function ( hint )
	{
		$(".moe-hint").html(hint);
		$(".moe-hint").stop(true, true).fadeIn( "fast" );
		
		if ( this.hintTimerID )
			clearInterval( this.hintTimerID );
		
		this.hintTimerID = setInterval( this.hideHint , 3000 );
	}
	
	Site.prototype.hideHint = function ()
	{
		$(".moe-hint").stop(true, true).fadeOut( "fast" );
		clearInterval( this.hintTimerID );
	}
	
	Site.prototype.onLoginCallback = function ()
	{
		
	}
	
	Site.prototype._buildPeopleChoice = function () 
	{
		
	}
	
	Site.prototype._handleWindowResize = function ( event ) 
	{
		( $(window).width() > 1280 ) ? 
			$("body").addClass("moe-widescreen") : 
			$("body").removeClass("moe-widescreen");
		this.launcher._adjustPageContainer( event );
	}
	
	module.exports = Site;
});