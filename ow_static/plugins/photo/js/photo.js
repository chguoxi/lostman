var photoView = function( params ) 
{
    var self = this;

	self.params = params;
	self.cache = new Array();

	this.setId = function( photo_id ) 
	{
		if ( !photo_id ) { return false; }

		$.bbq.pushState({ "view-photo" : photo_id });
	};

	this.checkIsCached = function( photo_id ) 
	{
		return (self.cache[photo_id] != undefined ? true : false);
	};

	this.cachePhotoCmp = function( photo_id, $markup ) 
	{
		self.cache[photo_id] = $markup;
	};

	this.showPhotoCmp = function( photo_id ) 
	{
        if ( !window.photoFB && self.params.layout != 'page' )
        {
			window.photoFB = new OW_FloatBox({ layout : 'empty' });

			window.photoFB.bind("close", function() {
				if ( history.pushState ) {
					history.pushState("", document.title, window.location.pathname + window.location.search );
				}
				else {
					document.location.hash = "";					
				}				
				window.photoFB = null;
				window.photoFBWidth = null;
				window.photoFBHeight = null;
			});
        }

		var load_current = "true";

		if ( self.checkIsCached(photo_id) ) 
		{
			self.loadCachedCmp(photo_id);
			var load_current = "false";
		}
		
		//if ( window.photoFBLoading ) { return; }

		var prev_id = $(".ow_photo_nav_l").attr("rel");
		
		if ( prev_id ) {
			var load_prev = self.checkIsCached(prev_id) ? "false" : "true";
		} else {
			var load_prev = "false";
		}

		var next_id = $(".ow_photo_nav_r").attr("rel");
		
		if ( next_id ) {
			var load_next = self.checkIsCached(next_id) ? "false" : "true";
		} else {
			var load_next = "false";
		}

		if ( load_current == "true" ) {
			var $preload = $(".ow_photo_preload");
			$('<div class="ow_floatbox_preloader"></div>').appendTo($preload);
			$preload.addClass('floatbox_preloader_container').show();
		}
		
		if ( load_current == "true" || load_prev == "true" || load_next == "true" )
		{
			// fetch component
			//window.photoFBLoading = true;
			
			$.ajax( {
				url : self.params.fbResponder,
				type : "POST",
				data : "photoId=" + photo_id + "&current=" + load_current + "&prev=" + load_prev + "&next=" + load_next,
				dataType : "json",
				success : function(data) {
					if ( data && data.result == "success" )
					{
						if ( load_current == "true" && data.current ) {
							var cmp = [];
							cmp['html'] = data.current.html;
							if ( data.current.onloadScript ) { cmp['onloadScript'] = data.current.onloadScript; }
							if ( data.current.scriptFiles ) { cmp['scriptFiles'] = data.current.scriptFiles; }
							if ( data.current.css ) { cmp['css'] = data.current.css; }
							self.cachePhotoCmp(photo_id, cmp);
							self.loadCachedCmp(photo_id);
						}
						if ( load_prev == "true" && data.prev ) {
							var cmp = [];
							cmp['html'] = data.prev.html;
							if ( data.prev.onloadScript ) { cmp['onloadScript'] = data.prev.onloadScript; }
							if ( data.prev.scriptFiles ) { cmp['scriptFiles'] = data.prev.scriptFiles; }
							if ( data.prev.css ) { cmp['css'] = data.prev.css; }
							self.cachePhotoCmp(data.prev.id, cmp);
						}
						if ( load_next == "true" && data.next ) {
							var cmp = [];
							cmp['html'] = data.next.html;
							if ( data.next.onloadScript ) { cmp['onloadScript'] = data.next.onloadScript; }
							if ( data.next.scriptFiles ) { cmp['scriptFiles'] = data.next.scriptFiles; }
							if ( data.next.css ) { cmp['css'] = data.next.css; }
							self.cachePhotoCmp(data.next.id, cmp);
						}
						//window.photoFBLoading = false;
					}
				}
			});
		}
	};

	this.loadCachedCmp = function(photo_id) 
	{
		var cmp = self.cache[photo_id];
		if ( cmp ) 
		{
            self.fitSize( cmp, function(newCmp) {
                var $contentHtml = $(cmp.html);
                if ( self.params.layout == 'page' ) {
                    $("#ow-photo-view").replaceWith($contentHtml);
                }
                else {
                    window.photoFB.fitWindow( { width : newCmp.width });
                    window.photoFB.setContent($contentHtml);
                }

                OW.bindAutoClicks($contentHtml);
                OW.bindTips($contentHtml);

                self.addCmpMarkup(newCmp);
                self.bindUI();
            });
		} 
		else {
			self.bindUI();
		}
	};
	
	this.addCmpMarkup = function( cmp ) 
	{
        if ( cmp.css ) { OW.addCss(cmp.css); }
        if ( cmp.scriptFiles ) 
        {
            OW.addScriptFiles(cmp.scriptFiles, function() {
                if ( cmp.onloadScript ) { OW.addScript(cmp.onloadScript); }
            });
        } 
        else {
            if ( cmp.onloadScript ) { OW.addScript(cmp.onloadScript); }
        }
	}

	this.bindUI = function() 
	{
		var $prevb = $(".ow_photo_nav_l");
		var $nextb = $(".ow_photo_nav_r");
		var $context = $(".ow_photo_context_action");

		$(".ow_photo_holder").hover(function() {
			$(".ow_photo_hover_info").slideDown("fast");
			$prevb.show(); $nextb.show(); $context.show();
		}, function() {
			$(".ow_photo_hover_info").slideUp("fast");
			$prevb.hide(); $nextb.hide(); $context.hide();
		});

		$(".ow_photo_holder").trigger("mouseenter");

		$prevb.on("click", function() {
			var photo_id = $(this).attr("rel");
			if ( !photo_id ) { return false; }
			self.setId(photo_id);
		});

		$nextb.on("click", function() {
			var photo_id = $(this).attr("rel");
			if ( !photo_id ) { return false; }
			self.setId(photo_id);
		});
		
		$("#btn-photo-edit").click(function() {
			var photo_id = $(this).attr("rel");
			window.edit_photo_floatbox = OW.ajaxFloatBox(
				"PHOTO_CMP_EditPhoto",
				{ photoId : photo_id },
				{ width : 500, iconClass : "ow_ic_edit", title : OW.getLanguageText('photo', 'tb_edit_photo'),
					onLoad : function() {
						var textarea = $("#photo-desc-area").get(0);
						textarea.htmlarea();
						textarea.htmlareaRefresh();
						
						owForms['photo-edit-form'].bind("success", function(data){
							self.cache[photo_id] = null;
							window.edit_photo_floatbox.close();
							self.showPhotoCmp(photo_id);
			            });
					}
				}
			);
		});
		
		$("#photo-mark-featured").click(function() {
			var status = $(this).attr('rel');
			var photo_id = $(this).attr('photo-id');
			var $this = this;
			
			$.ajax( {
				url : self.params.ajaxResponder,
				type : 'POST',
				data : { ajaxFunc : 'ajaxSetFeaturedStatus', photoId : photo_id, status : status },
				dataType : 'json',
				success : function(data) {
					if ( data.result == true ) {
						var newStatus = status == 'remove_from_featured' ? 'mark_featured' : 'remove_from_featured';
						var newLabel = status == 'remove_from_featured' ? OW.getLanguageText('photo', 'mark_featured') : OW.getLanguageText('photo', 'remove_from_featured');
						$($this).html(newLabel);
						$($this).attr('rel', newStatus);
						OW.info(data.msg);
					} else if ( data.error != undefined ) {
						OW.warning(data.error);
					}
				}
			});
		});
		
		$("#photo-delete").click(function() {
			var photo_id = $(this).attr("rel");
			
			if ( confirm(OW.getLanguageText('photo', 'confirm_delete')) ) {
				$.ajax( {
					url : self.params.ajaxResponder,
					type : 'POST',
					data : { ajaxFunc : 'ajaxDeletePhoto', photoId : photo_id },
					dataType : 'json',
					success : function(data) {
						if ( data.result == true ) {
							OW.info(data.msg);
							if ( data.url ) { document.location = data.url };
						} else if ( data.error != undefined ) {
							OW.warning(data.error);
						}
					}
				});
			} 
			else {
				return false;
			}
		});
		
		$("#btn-photo-flag").click(function() {
			var photo_id = $(this).attr("rel");
			var url = $(this).attr("url");
			var photoDesc = $("#photo-description").html();
			OW.flagContent("photo", photo_id, photoDesc, url, "photo+flags");
		});
		
		OW.bind('base.comment_add', function(e) {
			if ( e.entityType == "photo_comments" ) {
				if ( e.entityId && self.checkIsCached(e.entityId) ) { self.cache[e.entityId] = null; }	
			}
			
			OW.unbind("base.comment_add");
		});
		
		OW.bind('base.comment_delete', function(e) {
			if ( e.entityType == "photo_comments" ) {
				if ( e.entityId && self.checkIsCached(e.entityId) ) { self.cache[e.entityId] = null; }	
			}
			
			OW.unbind("base.comment_delete");
		});
		
		OW.bind('base.rate_update', function(e) {
			if ( e.entityType == "photo_rates" ) {
				if ( e.entityId && self.checkIsCached(e.entityId) ) { self.cache[e.entityId] = null; }	
			}
			
			OW.unbind("base.rate_update");
		});
	};

	this.fitSize = function(cmp, callback) {
		var $prerendered = $('<div id="fb-prerendered"></div>').html(cmp.html);

		$("body").append($prerendered);
		$prerendered.css( {
			"position" : "absolute",
			"left" : "-2000px"
		});

		var img = $prerendered.find("img.ow_photo_img");

		img.onImageLoad(function() {
			var $stage = $prerendered.find(".ow_photo_stage");
			
			var minW = 600, imgW = $(this).width();
			var minH = 400, imgH = $(this).height();
			
			var winHeight = $(window).height();
            var margin = 80;
            
            if ( winHeight < imgH + margin ) {
            	var adjusted = winHeight - margin;
            	$stage.height(adjusted);
            	$(this).height(adjusted);
            	imgH = adjusted;
            	imgW = $(this).width();
            }

			if ( imgW < minW ) { imgW = minW; }
			if ( imgH < minH ) { imgH = minH; }

			if ( window.photoFBWidth ) {
				if ( imgW > window.photoFBWidth ) {
					window.photoFBWidth = imgW;
				} else {
					imgW = window.photoFBWidth;
				}
			} else {
				window.photoFBWidth = imgW;
			}
            
            if ( self.params.layout != 'page' ) {
                $stage.width(imgW);
            }
            
            if ( window.photoFBHeight ) {
                if ( imgH > window.photoFBHeight ) {
                    window.photoFBHeight = imgH;
                } else {
                    imgH = window.photoFBHeight;
                }
            } else {
                window.photoFBHeight = imgH;
            }

			$stage.height(imgH);
			
			cmp.html = $prerendered.html();
			cmp.width = imgW;
			$prerendered.remove();

			callback(cmp);
		});

		return cmp;
	};

	$(document).bind('keydown', function(e){
		var target = e ? e.target : window.event.srcElement;
		if ( $(target).is('input') || $(target).is('textarea') ) { return; }

        var code = e.which;
        switch ( code ) {
            case 37:
                if ( !window.photoFB && self.params.layout != 'page' ) { return false; }
                e.preventDefault();
                var photo_id = $(".ow_photo_nav_l").attr("rel");
                if ( !photo_id ) { return false; }
                self.setId(photo_id);
            break;

            case 13:
            case 32:
            case 39:
                if ( !window.photoFB && self.params.layout != 'page' ) { return false; }
                e.preventDefault();
                var photo_id = $(".ow_photo_nav_r").attr("rel");
                if ( !photo_id ) { return false; }
                self.setId(photo_id);
            break;
        }
    });
}