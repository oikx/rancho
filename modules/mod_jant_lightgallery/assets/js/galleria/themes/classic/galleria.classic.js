/**
 * @preserve Galleria Classic Theme 2011-08-01
 * http://galleria.aino.se
 *
 * Copyright (c) 2011, Aino
 * Licensed under the MIT license.
 */

/*global jQuery, Galleria */

Galleria.requires(1.25, 'This version of Classic theme requires Galleria 1.2.5 or later');

(function($) {

Galleria.addTheme({
    name: 'classic',
    author: 'Galleria',
    css: 'galleria.classic.css',
    defaults: {
        transition: 'slide',
        thumbCrop:  'height',

        // set this to false if you want to show the caption all the time:
        _toggleInfo: true
    },
    init: function(options) {

        // add some elements
        this.addElement('info-link','info-close');
        this.append({
            'info' : ['info-link','info-close']
        });

        // cache some stuff
        var info = this.$('info-link,info-close,info-text'),
            touch = Galleria.TOUCH,
            click = touch ? 'touchstart' : 'click';

        // show loader & counter with opacity
        this.$('loader,counter').show().css('opacity', 0.4);

        // some stuff for non-touch browsers
        if (! touch ) {
            this.addIdleState( this.get('image-nav-left'), { left:-50 });
            this.addIdleState( this.get('image-nav-right'), { right:-50 });
            this.addIdleState( this.get('counter'), { opacity:0 });
        }
       
        /***************** JOOMANT DEV BEGIN ***************************/
        if (options.thumbnails)
        {
			this._stageHeight   = this._stageHeight - options.thumbHeight;   
			var tmpStageHeight 	= this._stageHeight*0.05;
			var top 			= tmpStageHeight;
			var bottom 			= options.thumbHeight + 15 + tmpStageHeight;
			this.$('stage').css({top: top, bottom: bottom});
			this.rescale();      	
        } 
        
		if(!options.thumbnails)
        {
        	this.$('thumbnails-container').hide();
        }
		else
		{
			this.$('thumbnails-container').css({display: 'inline-block'});
		}
		
        if (options.imageCrop)
        {
        	var width = this.$( 'container' ).width();
        	this.$('stage').css({top: 0, bottom: 0, left:0, right:0});
        	if (!options.thumbnails)
        	{
        		this.rescale(width, options.height);
        	}
        	else
        	{
        		var height = options.height - options.thumbHeight - 10;
        		this.rescale(width, height);
        		var top = options.thumbHeight + 10;
        	}
        }		
        /***************** JOOMANT DEV BEGIN ***************************/
        // bind some stuff
        this.bind('thumbnail', function(e) {     	
            if (! touch ) {
                // fade thumbnails
                $(e.thumbTarget).css('opacity', 0.6).parent().hover(function() {
                    $(this).not('.active').children().stop().fadeTo(100, 1);
                }, function() {
                    $(this).not('.active').children().stop().fadeTo(400, 0.6);
                });

                if ( e.index === this.getIndex() ) {
                    $(e.thumbTarget).css('opacity',1);
                }
            } else {
                $(e.thumbTarget).css('opacity', this.getIndex() ? 1 : 0.6);
            }
        });

        this.bind('loadstart', function(e) {
            if (!e.cached) {
                this.$('loader').show().fadeTo(200, 0.4);
            }
            
            this.$('info').toggle( this.hasInfo() );

            $(e.thumbTarget).css('opacity',1).parent().siblings().children().css('opacity', 0.6);
        });

        this.bind('loadfinish', function(e) {
            this.$('loader').fadeOut(200);
        });
    }
});

}(jQuery));
