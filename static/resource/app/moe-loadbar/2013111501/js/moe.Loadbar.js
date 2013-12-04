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
	
	function Loadbar() { 
		window.Loadbar = this;
		this._init();
	}
	
	Loadbar.prototype._init = function () {
		
		var self = this;
		
		self.$div_barContainer = 
			$("<div class='moe-loadbar-container'></div>")
				.appendTo("body");
		
		self.$div_barLine = 
			$("<div class='moe-loadbar-line'></div>")
				.appendTo(self.$div_barContainer);
		
		self.$div_hintContainer = 
			$("<div class='moe-loadbar-card'></div>")
				.appendTo("body");
		
		self.$div_hintBG = 
			$("<div class='moe-loadbar-card-bg'></div>")
				.appendTo(self.$div_hintContainer);
				
		self.$div_hintInner = 
			$("<div class='moe-loadbar-card-inner'></div>")
				.appendTo(self.$div_hintContainer);
		
		self.$div_hintTriangle = 
			$("<div class='moe-loadbar-card-triangle'></div>")
				.appendTo(self.$div_hintContainer);
		
		self.m_value = 20;
		
	}
	
	Loadbar.prototype.toggleLoadBar = function () {
		this.$div_barContainer.toggle();
		this.$div_hintContainer.toggle();
	}
	
	Loadbar.prototype.setValue = function ( value, hintHTML, close ) {
		
		this.m_value = value;
		
		this.$div_barLine.css({"width": this.m_value +"%"});
		this.$div_hintContainer.css({"left": this.m_value +"%"});
		
		if ( hintHTML )
		{
			this.$div_hintInner.html(hintHTML);
			
			if ( close )
				this.$div_hintContainer.stop(true, true).fadeOut();
			else
				this.$div_hintContainer.stop(true, true).fadeIn();
		}
		else
		{
			this.$div_hintContainer.stop(true, true).fadeOut('fast');
		}
		
		if ( close )
			this.$div_barContainer.delay(4000).stop(true, true).fadeOut('slow');
		else 
			this.$div_barContainer.stop(true, true).fadeIn();
	}
	
	Loadbar.prototype.getValue = function ( value ) {
	
		return this.m_value;
	}
	
	new Loadbar();
});