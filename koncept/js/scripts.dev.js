/* ALL THE SCRIPTS IN THIS FILE ARE MADE BY KROWNTHEMES.COM AND ARE LICENSED UNDER ENVATO'S REGULAR/EXTENDED LICENSE --- REDISTRIBUTION IS NOT ALLOWED! */

(function($) {

	var resizeT = null;

	/* ----------------------------------------------------
	---------- !! RESIZING !! -----------------
	------------------------------------------------------- */

	// Needs to be done when page finishes loading

	$(window).load(function(){

		var $body = $('body');

	    /* Enable fit vid & custom solution for posts videos */

	    if ( ! $body.hasClass('ie8') ) {
	   		$('.page #article, .single-portfolio #article').fitVids();
	   	}

	    if ( $body.hasClass('single-post') ) {

	   		var postIframes = Array();

		    $('.single-post #article iframe').each(function(){

		    	$(this).on('load', function(){

		    		$(this).data('ratio', $(this).prop('width') / $(this).prop('height'));
		    		postIframes.push($(this));
		    		$(window).trigger('resize');

		    	});

		    });

			$(window).on('resize', function(){
				if ( postIframes.length > 0 ) { 
		    		for ( var i = 0; i < postIframes.length; i++ ) {
		    			postIframes[i].height(postIframes[i].width()/postIframes[i].data('ratio'));
		    		}
				}
			});

		}

		// Resizing engine - there's a plugin which handles the matching heights, and we also create a custom media query to minimize paddings for all columns on lower screens

		var columnsQuery = '<style type="text/css" id="columns-query">@media all and (max-width:960px){';

		var i = 0, j = 0;
		$('.krown-column-row').each(function(){

			var imagesI = 0;

			$(this).children('.krown-column-container').each(function(){

				if ( $(this).children('.krown-image-holder').length > 0 || $(this).children('.flexslider.mini').length > 0 ) {
					imagesI++;
				}

				$(this).data('mh', 'group-' + i);
				$(this).attr('id', 'col-' + j);

				var pT = '', pR = '', pB = '', pL = '';

				if ( $(this)[0].style.paddingTop != '' ) {
					pT = 'padding-top:' + (parseInt($(this)[0].style.paddingTop) / 2) + ( $(this)[0].style.paddingTop.indexOf('%') > 0 ? '%' : 'px' ) + ' !important;';
				} else {
					pT = 'padding-top:' + (parseInt($(this).css('paddingTop')) / 2) + 'px !important;';
				}

				if ( $(this)[0].style.paddingRight != '' ) {
					pR = 'padding-right:' + (parseInt($(this)[0].style.paddingRight) / 2) + ( $(this)[0].style.paddingRight.indexOf('%') > 0 ? '%' : 'px' ) + ' !important;';
				} else {
					pR = 'padding-right:' + (parseInt($(this).css('paddingRight')) / 2) + 'px !important;';
				}

				if ( $(this)[0].style.paddingBottom != '' ) {
					pB = 'padding-bottom:' + (parseInt($(this)[0].style.paddingBottom) / 2) + ( $(this)[0].style.paddingBottom.indexOf('%') > 0 ? '%' : 'px' ) + ' !important;';
				} else {
					pB = 'padding-bottom:' + (parseInt($(this).css('paddingBottom')) / 2) + 'px !important;';
				}

				if ( $(this)[0].style.paddingLeft != '' ) {
					pL = 'padding-left:' + (parseInt($(this)[0].style.paddingLeft) / 2) + ( $(this)[0].style.paddingLeft.indexOf('%') > 0 ? '%' : 'px' ) + ' !important;';
				} else {
					pL = 'padding-left:' + (parseInt($(this).css('paddingLeft')) / 2) + 'px !important;';
				}

				if ( pT != '' || pR != '' || pB != '' || pL != '' ) {
					columnsQuery += '#col-' + j + '{' + pT + pR + pB + pL + '}';
				}

				j++;

			});

			i++;

			if ( imagesI == $(this).children('.krown-column-container').length ) {
				$(this).addClass('only-images');
			}

		});

		columnsQuery += '}</style>';

		if ( columnsQuery != '<style type="text/css" id="columns-query">@media all and (max-width:960px){}</style>' ) {
			$('head').append(columnsQuery);
		}
		
		// Match height plugin

		var $krownImages = $('.krown-column-container .krown-single-image, .krown-column-container .flexslider img');

		$('body:not(.woocommerce-page) .krown-column-row > .krown-column-container').matchHeight();

		// We need to add a fail safe for images, because these will resize after height, resulting in various distortions

		$(window).resize(function(){

			$krownImages.each(function(){

	        	if($(this)[0].naturalWidth > 0 || $(this)[0].complete) {

		            var $img = $(this);

		            var maxHeight = $img.closest('.krown-column-container').height(),
		                maxWidth = $img.closest('.krown-column-container').width(),
		                oldHeight = $img[0].naturalHeight,
		                oldWidth = $img[0].naturalWidth,
		                ratio = Math.max(oldWidth / oldHeight, oldHeight / oldWidth),
		                newHeight = 0,
		                newWidth = 0;

		            // Complex calculations to get the perfect size

		            if(oldWidth > oldHeight){

		                if(maxWidth / ratio < maxHeight){
		                    newHeight = maxHeight;
		                    newWidth = maxHeight * ratio;
		                } else {
		                    newWidth = maxWidth;
		                    newHeight = maxWidth / ratio;
		                }

		            } else {

		                if(maxHeight / ratio < maxWidth){
		                    newWidth = maxWidth;
		                    newHeight = maxWidth * ratio;
		                } else {
		                    newHeight = maxHeight;
		                    newWidth = maxHeight / ratio;
		                }

		            }

		            // Apply the correct size and reposition

		            $img.css({
		                'width': Math.ceil(newWidth),
		                'height': Math.ceil(newHeight),
		                'top': Math.round((maxHeight-newHeight)/2),
		                'left': Math.round((maxWidth-newWidth)/2)
		            });

		        }

			});

		}).trigger('resize');

		$('.krown-single-image').css('maxWidth', 'none');

		setTimeout(function(){
			$(window).trigger('resize');
		}, 1000);

	});

    $(document).ready(function(){

        "use strict";

/* ----------------------------------------------------
---------- !! GENERAL STUFF !! -----------------
------------------------------------------------------- */
    
    var $html = $('html'),
        $body = $('body'),
        $menu = $('#main-menu'),
        $search = $('#main-search #searchform'),

        touchM = "ontouchstart" in window;

    if(touchM) {
        $body.removeClass('no-touch')
            .addClass('touch');
    }

    $body.removeClass('no-js');

	// -- MENUS

	if ( $('#menu-class').hasClass('menu-one') ) {

		// The first menu needs some help in achieving a responsive layout (based on the size of the menu - as each user might have a different menu so we cannot provide a general rule)

		var mW = 0;

		$('.top-menu').children('li').each(function(){
			mW += $(this).outerWidth(true);
		});	

		$('head').append('<style type="text/css" id="menu-query">@media all and (max-width:' + (mW + 200) + 'px){.menu-one .top-menu > li {display:block;margin-right:0;}.menu-one .sub-menu {position:relative;width:100% !important;text-align:center;top:-15px;}.menu-one .top-menu > li:last-child {margin-right:0;}}</style>');

	}

/* ----------------------------------------------------
---------- !! MENU !! -----------------
------------------------------------------------------- */

    var optionsString = '';

	// Menu Variables

	var menuOpened = false,
		$menuClass = $('#menu-class'),
		$mainMenu = $('#main-menu'),
		$menuHolder2 = $('.menu-two .top-menu'),
		$menuHolder3 = $('.menu-one #main-menu'),
		$menuLi = $('.top-menu > li'),
		$menuText = $('#menu-text'),
		$menuOpener = $('#menu-opener'),
		$menuCloser = $('#menu-closer'),
		$filterOpener = $('#filter-opener').length > 0 ? $('#filter-opener') : null,
		$headerWidgets = $('#header-widgets').length > 0 ? $('#header-widgets') : null;

    /* -------------------------------
    -----   Anmiations  -----
    ---------------------------------*/

	// Opening animations (various styles)

	$menuOpener.click(function(e){

		if ( ! menuOpened ) {

			menuOpened = true;

			$mainMenu.css('visibility', 'visible');

			$(this).animate({
				'opacity': 0
			}, 150).addClass('disabled');

			if ( $filterOpener != null ) {
				$filterOpener.stop().animate({
					'opacity': 0
				}, 150, function(){
					$(this).css('visibility', 'hidden');
				});
			}

			if ( $headerWidgets != null ) {
				$headerWidgets.stop().animate({
					'opacity': 0
				}, 150, function(){
					$(this).css('visibility', 'hidden');
				});
			}

			if ( $menuClass.hasClass('menu-one') ) {

				$(this).animate({
					'top': -50
				}, 150);

				$menuHolder3.stop().delay(100).animate({
					'height': '100%',
					'opacity': 1
				}, 250, 'easeInQuad');

				var i = 0;

				$menuLi.each(function(){
					$(this).stop().delay(i++*50+150).animate({
						'top': 0,
						'opacity': 1
					}, 200, 'easeInQuad');
				});

				$menuText.stop().delay(i*50+250).animate({
					'bottom': 80,
					'opacity': 1
				}, 200, 'easeInQuad');

				$menuCloser.stop().delay(i*50).animate({
					'top': 80,
					'opacity': 1
				}, 200, 'easeInQuad').addClass('active');

			} else if ( $menuClass.hasClass('menu-two') ) {

				if ( ! $body.hasClass('rtl') ) {

					$(this).animate({
						'right': 50
					}, 200);

					$menuHolder2.stop().delay(50).animate({
						'right': 0
					}, 350, 'easeInQuad');

					var i = 0;

					$menuLi.each(function(){
						$(this).stop().delay(i++*50+100).animate({
							'right': 0,
							'opacity': 1
						}, 150, 'easeInQuad');
					});

					$menuText.stop().delay(i*50+50).animate({
						'right': -90,
						'opacity': 1
					}, 200, 'easeInQuad');

					$menuCloser.stop().delay(i*50).animate({
						'right': 40,
						'opacity': 1
					}, 200, 'easeInQuad').addClass('active');

				} else {

					$(this).animate({
						'left': 50
					}, 200);

					$menuHolder2.stop().delay(50).animate({
						'left': 0
					}, 350, 'easeInQuad');

					var i = 0;

					$menuLi.each(function(){
						$(this).stop().delay(i++*50+100).animate({
							'left': 0,
							'opacity': 1
						}, 150, 'easeInQuad');
					});

					$menuText.stop().delay(i*50+50).animate({
						'left': 10,
						'opacity': 1
					}, 200, 'easeInQuad');

					$menuCloser.stop().delay(i*50).animate({
						'left': 40,
						'opacity': 1
					}, 200, 'easeInQuad').addClass('active');

				}

			} else if ( $menuClass.hasClass('menu-three') ) {

				$(this).animate({
					'top': -50
				}, 200);

				$menuCloser.stop().delay(100).animate({
					'top': -15,
					'opacity': 1
				}, 200, 'easeInQuad').addClass('active');

				var i = $menuLi.length;

				$menuLi.each(function(){
					$(this).css('visibility', 'visible').stop().delay(i--*50).animate({
						'bottom': 0,
						'opacity': 1
					}, 200, 'easeInQuad');
				});

			}

		}

		e.preventDefault();

	});

	// Closing animations (various styles)

	$menuCloser.click(function(e){

		if ( menuOpened ) {

			menuOpened = true;

			if ( $filterOpener != null ) {
				$filterOpener.stop().delay(1000).animate({
					'opacity': 1
				}, 250, function(){
					$(this).css('visibility', 'visible');
				});
			}

			if ( $headerWidgets != null ) {
				$headerWidgets.stop().delay(1000).animate({
					'opacity': 1
				}, 250, function(){
					$(this).css('visibility', 'visible');
				});
			}

			if ( $menuClass.hasClass('menu-one') ) {

				var i = $menuLi.length;

				$menuCloser.stop().animate({
					'top': 120,
					'opacity': 0
				}, 150, 'easeInQuad', function(){
					$(this).removeClass('active');
				});

				var i = $menuLi.length;

				$menuLi.each(function(){
					$(this).stop().delay(i--*50).animate({
						'top': -80,
						'opacity': 0
					}, 150, 'easeInQuad');
				});

				$menuText.stop().delay(50).animate({
					'bottom': 120,
					'opacity': 0
				}, 150, 'easeInQuad');

				$menuHolder3.stop().delay(150).animate({
					'height': 0,
					'opacity': 0
				}, 350, 'easeInQuad');

				$menuOpener.stop().delay($menuLi.length*50).animate({
					'top': 0,
					'opacity': 1
				}, 200, 'easeInQuad', function(){
					$(this).removeClass('disabled');
					menuOpened = false;
					$mainMenu.css('visibility', 'hidden');
				});

			} else if ( $menuClass.hasClass('menu-two') ) {

				if ( ! $body.hasClass('rtl') ) {

					$menuCloser.stop().animate({
						'right': -20,
						'opacity': 0
					}, 150, 'easeInQuad', function(){
						$(this).removeClass('active');
					});

					var i = $menuLi.length;

					$menuLi.each(function(){
						$(this).stop().delay(i--*50).animate({
							'right': -150,
							'opacity': 0
						}, 150, 'easeInQuad');
					});

					$menuText.stop().delay(50).animate({
						'right': -200,
						'opacity': 0
					}, 150, 'easeInQuad');

					$menuHolder2.stop().delay(100).animate({
						'right': -500
					}, 350, 'easeInQuad');

					$menuOpener.stop().delay($menuLi.length*50).animate({
						'right': 0,
						'opacity': 1
					}, 200, 'easeInQuad', function(){
						$(this).removeClass('disabled');
						menuOpened = false;
						$mainMenu.css('visibility', 'hidden');
					});

				} else {

					$menuCloser.stop().animate({
						'left': -20,
						'opacity': 0
					}, 150, 'easeInQuad', function(){
						$(this).removeClass('active');
					});

					var i = $menuLi.length;

					$menuLi.each(function(){
						$(this).stop().delay(i--*50).animate({
							'left': -150,
							'opacity': 0
						}, 150, 'easeInQuad');
					});

					$menuText.stop().delay(50).animate({
						'left': -200,
						'opacity': 0
					}, 150, 'easeInQuad');

					$menuHolder2.stop().delay(100).animate({
						'left': -500
					}, 350, 'easeInQuad');

					$menuOpener.stop().delay($menuLi.length*50).animate({
						'left': 0,
						'opacity': 1
					}, 200, 'easeInQuad', function(){
						$(this).removeClass('disabled');
						menuOpened = false;
						$mainMenu.css('visibility', 'hidden');
					});

				}

			} else if ( $menuClass.hasClass('menu-three') ) {

				$menuCloser.stop().animate({
					'top': 25,
					'opacity': 0
				}, 200, 'easeInQuad', function(){
					$(this).removeClass('active');
				});

				var i = $menuLi.length-1;

				$menuLi.each(function(){
					$(this).delay(i*50).animate({
						'opacity': 0
					}, 150, 'easeInQuad');

					$(this).stop().delay(i--*50).animate({
						'bottom': -60
					}, 180, 'easeInQuad', function(){
						var $this = $(this);
						setTimeout(function(){
							$this.css('visibility', 'hidden');
						}, 100);
					});
				});

				$menuOpener.stop().delay($menuLi.length*50-50).animate({
					'top': 0,
					'opacity': 1
				}, 200, 'easeInQuad', function(){
					$(this).removeClass('disabled');
					menuOpened = false;
					$mainMenu.css('visibility', 'hidden');
				});

			}

		}

		e.preventDefault();

	});

    // Submenus animation

    if ( touchM || $menuClass.hasClass('menu-two') ) {

		var $openedMenu = null;

	    $menu.find('a').click(function(){

	    	var $this = $(this).parent();

	        if ( $this.children('ul').length > 0 ) {

	        	var $menu = $this,
	        		$submenu = $this.children('ul');

	        	if ( $openedMenu != null && $openedMenu[0] != $submenu[0] ) {
	        		$menu.removeClass('opened');
	        		$openedMenu.stop().slideUp({
		            	duration: 150,
		            	easing: 'easeOutQuad'
		            });
	        		$openedMenu = null;
	        	}

	        	if ( $menu.hasClass('opened') ) {

	        		$menu.removeClass('opened');
	        		$submenu.stop().slideUp({
		            	duration: 150,
		            	easing: 'easeOutQuad'
		            });

	        	} else {

	        		$menu.addClass('opened');
	        		$openedMenu = $submenu;
	        		$submenu.stop().slideDown({
		            	duration: 200,
		            	easing: 'easeInQuad',
		            	complete: function(){
		                	$(this).css('overflow', 'visible');
		            	}
		            });

	        	}

	            return false;

	        }

	    });

    } else {
    	
	    $menu.find('li').hover(function(){

	        if ( $(this).children('ul').length > 0 ) {

	            $(this).children('ul').stop().slideDown({
	            	duration: 200,
	            	easing: 'easeInQuad',
	            	complete: function(){
	                	$(this).css('overflow', 'visible');
	            	}
	            })

	        }

	    }, function(){

	        if ( $(this).children('ul').length > 0 ) {

	            $(this).children('ul').stop().slideUp({
	            	duration: 150,
	            	easing: 'easeOutQuad'
	            });

	        }

	    })

	}

	$menu.find('li').each(function(){

        // This iteration takes each submenu and modifies it's width according to the content present in there

        var $submenu = $(this).children('ul');

        if($submenu.length > 0){

            var minW = 0;

            $submenu.css('display', 'block');

            $submenu.children('li').each(function(){
                $(this).addClass('menu-fix');
                if($(this).width() > minW)
                minW = $(this).width();
                $(this).removeClass('menu-fix');
            });

            $submenu.css('display', 'none').width(minW+10);
            $submenu.find('ul').css('left', minW+10);

        }

    });

    /* -------------------------------
    -----   Search form  -----
    ---------------------------------*/

    $search.find('.fa-search').click(function(e){
        
        if($search.hasClass('opened')) {
            $search.removeClass('opened');
            $('html').off('click.searchout');
        } else {
            $search.addClass('opened');
            $('html').on('click.searchout', function(){
            	$search.removeClass('opened');
            });
            $search.find('#s').focus();
        }
        e.stopPropagation();

    });

    /* -------------------------------
    -----   Responsive menu (only for #3 & #4)  -----
    ---------------------------------*/

    if ( $('#menu-class').hasClass('menu-three' ) ) {

	    var optionsString = '';

	    // Create responsive navigaton based on menu items

	    $mainMenu.find('.top-menu').children('li').each(function(){

	        var $a = $(this).children('a');

	        optionsString += '<option data-href="' + $a.prop('href') + '"' + ($a.prop('target') == 'blank' ? ' data-target="_blank"' : '') + '>' + $a.text() + '</option>';

	        if($(this).hasClass('parent')) {
	            $(this).find('ul').find('a').each(function(){

	                optionsString += '<option data-href="' + $(this).prop('href') + '"' + ($(this).prop('target') == 'blank' ? ' data-target="_blank"' : '') + '> -- ' + $(this).text() + '</option>';

	            });

	        }

	    });

	    // Append the navigation from above

	    $mainMenu.append('<div class="responsive-menu"><select><option>' + $mainMenu.data('nav-text') + '</option>' + optionsString + '</select></div>');

	    // Bind proper events for it

	    $('.responsive-menu').children('select').on('change', function(){

	        var href = $(this).find('option:selected').data('href'),
	        target = $(this).find('option:selected').data('target');

	        if(target == undefined) {

	        	if(href.indexOf('#')>0){
	                document.location.hash = href.slice(href.indexOf('#')+1, href.length);
	        	} else {
	            	document.location.href = href;
	            }

	            return false;

	        } else {
	            window.open(href, '_blank');
	        }

	    });

	}

    /* -------------------------------
    -----   Sticky menu   -----
    ---------------------------------*/

    var $mHeaderA = $('#header'),
        $pContent = null,
        origOffset = 0;

         // Function that adds a "smaller" class to the menu when needed

    function scrollParallaxMenu(){
        if($(window).scrollTop() <= 100) {
            if($mHeaderA.hasClass('smaller')) {
                $mHeaderA.removeClass('smaller');
            }
        } else if (!$mHeaderA.hasClass('smaller')) {
            $mHeaderA.addClass('smaller');
        }
    }

    // Activate proper handles

    if($body.hasClass('sticky') && !$body.hasClass('ie8')) {
        $body.addClass('sactive');
        $(window).on('scroll.parallax-menu', scrollParallaxMenu);
        scrollParallaxMenu();
    }

/* ----------------------------------------------------
---------- !! WOOCOMMERCE !! -----------------
------------------------------------------------------- */

	if ( $('.woocommerce-ordering').length > 0 ) {
		$('.woocommerce-ordering').prependTo('#shop-sidebar');
		$('.woocommerce-ordering').wrap('<div class="widget">');
		$('.woocommerce-ordering').parent().prepend('<span class="title">' + themeObjects.sortText + '</span>');
	}

    $('#shop-sidebar select').each(function(){
    	$(this).styledSelect({
	        coverClass: 'shop-select-cover',
	        innerClass: 'shop-select-inner'
	    }).addClass('styled');
    });

    if ( $('.price_slider_wrapper').length > 0 ) {

	    $('.price_slider_wrapper').on('slidecreate', 
	        function(event, ui) { 
	        	$('#shop-sidebar').show();
	        } 
	    );

    } else {

		$('#shop-sidebar').show();

    }

   $('.wcml_currency_switcher').closest('.textwidget').addClass('wcml_currency');

    // Variations fix

    if ( $('.variations_form.cart').length > 0 ) {

	   /* var variations = $('.variations_form.cart').data('product_variations');

	    setTimeout(function(){
	    	$('.variations_form.cart').on('reset_image', function(){
	    		console.log('catchq')
	    	});
	    	console.log('off');
	    }, 3000);
	    console.log($('.variations_form.cart'))

	   console.log(variations);

		for ( var i = 0; i < variations.length; i++ ) {
			variations[i].image_src = variations[i].image_link;
		}
/*
		var oI = $('.variations_form.cart').find('option:selected').index()-1;

		if ( oI == -1 ) oI = 0;

		if(oI != 0 && variations[oI] != undefined && variations[oI].image_link != undefined) {
			$('.images .flex-active-slide img').prop('src', variations[oI].image_link);
		}
		
	    if ( $('.images').children('.flexslider').length > 0 ) {

		    var $zoom = $('.images .zoom'),
		    	zoomImg = $zoom.attr('href');

		    setInterval(function(){

		    	if ( $zoom.attr('href') != zoomImg && $zoom.attr('href') != '#' ) {

		    		$('.flexslider.mini').flexslider(0);
					$('.images .flex-active-slide img').prop('src', zoomImg);

		    		zoomImg = $zoom.attr('href');

		    	}

		    }, 100);

		}*/

		$('.variations').find('select').blur(function(){
			if($(this).parent().hasClass('simple-select-cover')){
				$(this).parent().find('.simple-select-inner').text($(this).find('option:selected').text());
			}

		});

	}

    // Quantity buttons (2.3+)

    if ( themeObjects.wooCommerce23 == '1' ) {

		$( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );

		$( document ).on( 'click', '.plus, .minus', function() {

			var $qty		= $( this ).closest( '.quantity' ).find( '.qty' ),
				currentVal	= parseFloat( $qty.val() ),
				max			= parseFloat( $qty.attr( 'max' ) ),
				min			= parseFloat( $qty.attr( 'min' ) ),
				step		= $qty.attr( 'step' );

			// Format values
			if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
			if ( max === '' || max === 'NaN' ) max = '';
			if ( min === '' || min === 'NaN' ) min = 0;
			if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

			if ( $( this ).is( '.plus' ) ) {

				if ( max && ( max == currentVal || currentVal > max ) ) {
					$qty.val( max );
				} else {
					$qty.val( currentVal + parseFloat( step ) );
				}

			} else {

				if ( min && ( min == currentVal || currentVal < min ) ) {
					$qty.val( min );
				} else if ( currentVal > 0 ) {
					$qty.val( currentVal - parseFloat( step ) );
				}

			}
			
			$qty.trigger( 'change' );

		});

	}

/* ----------------------------------------------------
---------- !! PORTFOLIO !! -----------------
------------------------------------------------------- */

    /* -------------------------------
    -----   Dedicated page   -----
    ---------------------------------*/

    // Set up the filter first. It works with the Isotope plugin

    var $folioItems = $('#portfolio'),
        $folioElements = $('#portfolio .item'),
        $activeFilter = $('#filter a.selected'),
        $responsiveFilter = null;

    var $article = $('#article');

    if($folioItems.length > 0){

	    $folioItems.imagesLoaded(function(){

	    	// Setup initial thumbnail's size

			var columWidthh = getFolioColWidth();

	        if ( $folioItems.hasClass('layout-fixed') ) {

				$folioElements.each(function(){
					$(this).width(columWidthh[0]);
				});

	        } else {

				$folioElements.each(function(){
					$(this).width(columWidthh[0]*(columWidthh[1] == 1 ? 1 : $(this).data('factor')));
				});

	        }

	        // Setup the isotope plugin

	        $folioItems.isotope({
	        	isOriginLeft: ! $body.hasClass('rtl') ? true : false,
	            itemSelector: '.item',
	            masonry: {
	            	columnWidth: columWidthh[0]
	            },
	            isResizeBound: false
	        });

	        // Add resizing events

	        if ( $folioItems.hasClass('layout-fixed') ) {

	        	// Fixed layout

		        $(window).resize(function(){

					var columWidthh = getFolioColWidth();

			        var elems = $folioItems.isotope('getItemElements');
			        for ( var i = 0; i < elems.length; i++ ) {
			        	$(elems[i]).width(columWidthh[0]);
			        }

			        $folioItems.isotope({
			            masonry: {
			            	columnWidth: columWidthh[0]
			            }
			        });

		        }).trigger('resize');

	        } else {

	        	// Masonry grid

		        $(window).resize(function(){

					var columWidthh = getFolioColWidth();

			        var elems = $folioItems.isotope('getItemElements');
			        for ( var i = 0; i < elems.length; i++ ) {
			        	$(elems[i]).width(columWidthh[0]*(columWidthh[1] == 1 ? 1 : $(elems[i]).data('factor')));
			        }

			        $folioItems.isotope({
			            masonry: {
			            	columnWidth: columWidthh[0]
			            }
			        });

		        }).trigger('resize');

		    }

	    });

		// Add thumbnail breaking points

	    $body.append('<div id="responsive-queries"><div id="break-43"></div><div id="break-42"></div><div id="break-41"></div><div id="break-32"></div><div id="break-31"></div><div id="break-21"></div></div>');

	    var $break21 = $('#break-21'),
	    	$break32 = $('#break-32'),
	    	$break31 = $('#break-31'),
	    	$break43 = $('#break-43'),
	    	$break42 = $('#break-42'),
	    	$break41 = $('#break-41');

	};

	// fail safe for mobile devices

	if ( window.addEventListener ) {
		window.addEventListener('orientationchange', function(){
		    setTimeout(function(){
		    	$(window).trigger('resize');
		    }, 500);
		}, false);
	}

	// This function gets the current width of the portfolio items (based on various calculations)

	function getFolioColWidth() {

		var colWidth = 0,
			factor = 0,
			containerWidth = $article.width();

		if ( $folioItems.hasClass('cols-two') ) {

			if ( $break21.css('display') == 'block' ) {
				colWidth = containerWidth;
				factor = 1;
			} else {
				colWidth = containerWidth / 2;
			}

		} else if ( $folioItems.hasClass('cols-three') ) {

			if ( $break31.css('display') == 'block' ) {
				colWidth = containerWidth;
				factor = 1;
			} else if ( $break32.css('display') == 'block' ) {
				colWidth = containerWidth / 2;
			} else {
				colWidth = containerWidth / 3;
			}

		} else {

			if ( $break41.css('display') == 'block' ) {
				colWidth = containerWidth;
				factor = 1;
			} else if ( $break42.css('display') == 'block' ) {
				colWidth = containerWidth / 2;
			} else if ( $break43.css('display') == 'block' ) {
				colWidth = containerWidth / 3;
			} else {
				colWidth = containerWidth / 4;
			}
			
		}

		return Array(colWidth, factor);

	}

	// Setup of some animations that require a bit of javascript

	if($folioItems.hasClass('style-two') && $body.hasClass('no-touch')){

		$folioItems.find('.item').each(function(){
			$(this).hoverdir();
		});

	}

    if($('#filter').length > 0){

    	var $filter = $('#filter'),
    		filterOpened = false;

    	$('#filter-opener').click(function(e){

    		if ( ! filterOpened ) {

    			filterOpened = true;
    			$filter.stop().slideDown(250);
    			$(this).addClass('opened');

        		$('html,body').animate({scrollTop: 0}, 500, 'easeInQuad');

    		} else {

    			filterOpened = false;
    			$filter.stop().slideUp(250);
    			$(this).removeClass('opened');

    		}

    		e.preventDefault();

    	});

	    $('#filter').find('a').click(function(e){

	        $folioElements.removeClass('disable-resize');

	        $activeFilter.removeClass('selected');
	        $activeFilter = $(this);
	        $activeFilter.addClass('selected');

	        var f = $(this).data('filter');

	        $folioItems.isotope({
	            filter: f
	        });

	        $responsiveFilter.val($(this).text());
	        $responsiveFilter.parent().find('.regular-select-inner').text($(this).text());

	        e.preventDefault();

	    });

	    // Create responsive navigaton based on filter items

	    optionsString = '';

	    $('#filter').find('li').each(function(){

	        optionsString += '<option data-filter="' + $(this).data('filter') + '"' + '>' + $(this).text() + '</option>';

	    });

	    // Append the navigation from above

	    $('#filter').append('<div class="responsive-filter"><select>' + optionsString + '</select></div>');
	    $responsiveFilter = $('.responsive-filter').find('select');

	    $responsiveFilter.change(function(){
	        $(this).closest('#filter').find('ul').children('li').eq($(this).find(':selected').index()).find('a').trigger('click');
	    });

	}

	/* -------------------------------
	-----   Infinite loading   -----
	---------------------------------*/


	if ( $('#infinite-link').length > 0 && $('#portfolio').length > 0 ) {

	    var $infinite = $('.infinite-barrier'),
	        $infiniteLink = $('#infinite-link'),
	        $infiniteContainer = $('#portfolio');

        $(window).on('scroll.infinite', listenInfiniteScrollingFolio);

    }

    /* -------------------------------
    -----   Infinite loading (blog)  -----
    ---------------------------------*/

    function listenInfiniteScrollingFolio(){

        if ( $(window).scrollTop() + $(window).height() - 100 >= $infiniteContainer.offset().top + $infiniteContainer.height() ) {

            // Prepare loading

            $(window).off('scroll.infinite');
            $infinite.stop().slideDown(200);

            // Start AJAX call

            $.ajax({
                type: 'POST',
                url: $infinite.find('a').prop('href'),
                dataType: 'html',
                success: function(data){

                    var $data = $(data),
                        $items = $data.find('.item');

                    if($items.length>0){

                        // If there are items

                        $items.imagesLoaded(function(){

                            // Write item width

							var columWidthh = getFolioColWidth();
                        	
        					if ( $folioItems.hasClass('layout-fixed') ) {

						       	$items.each(function(){
						        	$(this).width(columWidthh[0]);
						        });

        					} else {

						       	$items.each(function(){
						        	$(this).width(columWidthh[0]*(columWidthh[1] == 1 ? 1 : $(this).data('factor')));
						        });

        					}

                            // When the images are loaded, setup & insert elements

                            $infiniteContainer.isotope()
                            	.append($items) 
                            	.isotope('appended', $items)
                            	.isotope('layout');

                            // Apply animation

							if($infiniteContainer.hasClass('style-two') && $body.hasClass('no-touch')){
								$items.each(function(){
									$(this).hoverdir();
								});
							}

                            // Prepare for next page

                            $infinite.stop().slideUp(200);
                            $infiniteLink.prop('href', $data.find('#infinite-link').prop('href'));
                            $(window).on('scroll.infinite', listenInfiniteScrollingFolio);

                        });

                    } else {

                        // If no more posts

                        $infinite.find('span').stop().fadeOut(100);
                        $infinite.find('p').stop().fadeIn(100);

                        setTimeout(function(){
                        	$infinite.stop().slideUp(200);
                        }, 2500);

                    }

                },
                error: function(){
                	
                    $infinite.find('span').stop().fadeOut(100);
                    $infinite.find('p').stop().fadeIn(100);

                    setTimeout(function(){
                    	$infinite.stop().slideUp(200);
                    }, 2500);

                }

            });

        }

	}

/* ----------------------------------------------------
---------- !! BLOG !! -----------------
------------------------------------------------------- */

	if ( $('#posts-container').length > 0 ) {

		if ( ! $('#posts-container').hasClass('classic') ) {
			$('.post').on('mouseenter', blogMouseEnter).on('mouseleave', blogMouseLeave);
		}

	    var $infinite = $('.infinite-barrier'),
	        $infiniteLink = $('#infinite-link'),
	        $infiniteContainer = $('#posts-container');

        $(window).on('scroll.infinite', listenInfiniteScrollingBlog);

    }

	/* -------------------------------
	-----   Animations   -----
	---------------------------------*/

	function blogMouseEnter(){

		if ( ! $body.hasClass('rtl') ) {

			$(this).find('.caption').stop().animate({
				'left': 280
			}, 300, 'swing');

			$(this).find('.post-back').stop().animate({
				'opacity': 1
			}, 250, 'swing');

			$(this).find('img').stop().animate({
				'opacity': 1,
				'left': 0
			}, 250, 'swing');

			$(this).find('.post-arrow').stop().animate({
				'opacity': 1,
				'right': 60
			}, 150, 'swing');

		} else {

			$(this).find('.caption').stop().animate({
				'right': 280
			}, 300, 'swing');

			$(this).find('.post-back').stop().animate({
				'opacity': 1
			}, 250, 'swing');

			$(this).find('img').stop().animate({
				'opacity': 1,
				'right': 0
			}, 250, 'swing');

			$(this).find('.post-arrow').stop().animate({
				'opacity': 1,
				'left': 60
			}, 150, 'swing');

		}

	}

	function blogMouseLeave(){

		if ( ! $body.hasClass('rtl') ) {

			$(this).find('.post-back').stop().animate({
				'opacity': 0
			}, 250, 'swing');

			$(this).find('.post-arrow').stop().animate({
				'opacity': 0,
				'right': 120
			}, 150, 'swing');

			$(this).find('.caption').stop().animate({
				'left': 0
			}, 250, 'swing');

			$(this).find('img').stop().animate({
				'opacity': 0,
				'left': -200
			}, 250, 'swing');

		} else {

			$(this).find('.post-back').stop().animate({
				'opacity': 0
			}, 250, 'swing');

			$(this).find('.post-arrow').stop().animate({
				'opacity': 0,
				'left': 120
			}, 150, 'swing');

			$(this).find('.caption').stop().animate({
				'right': 0
			}, 250, 'swing');

			$(this).find('img').stop().animate({
				'opacity': 0,
				'right': -200
			}, 250, 'swing');

		}
		
	}

    /* -------------------------------
    -----   Infinite loading (blog)  -----
    ---------------------------------*/

    function listenInfiniteScrollingBlog(){

        if ( $(window).scrollTop() + $(window).height() - 100 >= $infiniteContainer.offset().top + $infiniteContainer.height() ) {

            // Prepare loading

            $(window).off('scroll.infinite');
            $infinite.stop().slideDown(200);

            // Start AJAX call

            $.ajax({
                type: 'POST',
                url: $infinite.find('a').prop('href'),
                dataType: 'html',
                success: function(data){

                    var $data = $(data),
                        $posts = $data.find('.post');

                    if($posts.length>0){

                        // If there are posts

                        $posts.imagesLoaded(function(){

                            // When the images are loaded, setup & insert elements

                            $infiniteContainer.append($posts);

                            $posts.stop().css({
                            	'display': 'none',
                            	'opacity': 0
                            });
                            var i = 0;

                            $posts.each(function(){

                            	$(this).delay(++i*100).slideDown(200)
                            		.animate({
                            			'opacity': 1
                            		}, 200);

								if ( ! $('#posts-container').hasClass('classic') ) {
									$(this).on('mouseenter', blogMouseEnter).on('mouseleave', blogMouseLeave);
								}

                            });

                            // Prepare for next page

                            $infinite.stop().slideUp(200);
                            $infiniteLink.prop('href', $data.find('#infinite-link').prop('href'));
                            $(window).on('scroll.infinite', listenInfiniteScrollingBlog);

                        });

                    } else {

                        // If no more posts

                        $infinite.find('span').stop().fadeOut(100);
                        $infinite.find('p').stop().fadeIn(100);

                        setTimeout(function(){
                        	$infinite.stop().slideUp(200);
                        }, 2500);

                    }

                },
                error: function(){
                	
                    $infinite.find('span').stop().fadeOut(100);
                    $infinite.find('p').stop().fadeIn(100);

                    setTimeout(function(){
                    	$infinite.stop().slideUp(200);
                    }, 2500);

                }

            });

        }

	}

/* ----------------------------------------------------
---------- !! CONTACT PAGE !! -----------------
------------------------------------------------------- */
    
    if($('.insert-map').length>0) {

        $('.insert-map').each(function(){

            var $mapInsert = $(this);

            var map;

            var stylez = [
                {
                  featureType: "all",
                  elementType: "all",
                  stylers: [
                    { saturation: -100 }
                  ]
                }
            ];
            
            var mapOptions = {
                zoom: $mapInsert.data('zoom'),
                center: new google.maps.LatLng($mapInsert.data('map-lat'), $mapInsert.data('map-long')),
                streetViewControl: false,
                scrollwheel: false,
                panControl: true,
                mapTypeControl: false,
                overviewMapControl: false,
                zoomControl: false,
                draggable: touchM ? false : true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE
                },
                mapTypeControlOptions: {
                     mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'krownMap']
                }
            };

            map = new google.maps.Map(document.getElementById($mapInsert.attr('id')), mapOptions);

            if($mapInsert.data('greyscale') == 'd-true') {

                var mapType = new google.maps.StyledMapType(stylez, { name:"Grayscale" });    
                map.mapTypes.set('krownMap', mapType);
                map.setMapTypeId('krownMap');

            }

            if($mapInsert.data('marker') == 'd-true') {

                var myLatLng = new google.maps.LatLng($mapInsert.data('map-lat'), $mapInsert.data('map-long'));
                var beachMarker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    icon: $mapInsert.data('marker-img')
                });

            }

            setTimeout(function(){
            	$mapInsert.animate({'opacity': 1}, 400)
            		.parent().addClass('remove-preloader');
            }, 2000);

        });

    }

/* ----------------------------------------------------
---------- !! VARIOUS SHORTCODES !! -----------------
------------------------------------------------------- */

    // Dirty but working

    $('p:empty').remove();

    /* -------------------------------
    -----   Accordions   -----
    ---------------------------------*/

    $('.krown-accordion').each(function(){

        var toggle = $(this).hasClass('toggle') ? true : false,
            $sections = $(this).children('section'),
            $opened = $(this).data('opened') == '-1' ? null : $sections.eq(parseInt($(this).data('opened')));

        if($opened != null){
            $opened.addClass('opened');
            $opened.children('div').slideDown(0);
        }

        $(this).children('section').children('h5').click(function(){

            var $this = $(this).parent();

            if(!toggle){
                if($opened != null){
                    $opened.removeClass('opened');
                    $opened.children('div').stop().slideUp(300);
                }
            }

            if($this.hasClass('opened') && toggle){
                $this.removeClass('opened');
                $this.children('div').stop().slideUp(300);
            } else if(!$this.hasClass('opened')){
                $opened = $this;
                $this.addClass('opened');
                $this.children('div').stop().slideDown(300);
            }

        });

    });

    /* -------------------------------
    -----   Contact Forms   -----
    ---------------------------------*/

    $('.krown-form').each(function(){

        var $form = $(this).find('form'),
        $name = $(this).find('.name'),
        $email = $(this).find('.email'),
        $subject = $(this).find('.subject'),
        $message = $(this).find('.message'),
        $success = $(this).find('.success-message'),
        $error = $(this).find('.error-message');

        $name.focus(function(){resetError($(this))});
        $email.focus(function(){resetError($(this))});
        $subject.focus(function(){resetError($(this))});
        $message.focus(function(){resetError($(this))});

        function resetError($input){
            $input.removeClass('contact-error-border');
            $error.fadeOut();
        }

        $form.submit(function(e){

            var ok = true;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

            if($name.val().length < 3 || $name.val() == $name.data('value')){
                showError($name);
                ok = false;
            }

            if($email.val() == '' || $email.val() == $email.data('value') || !emailReg.test($email.val())){
                showError($email);
                ok = false;
            }

            if($message.val().length < 5 || $message.val() == $message.data('value')){
                showError($message);
                ok = false;
            }

            if($(this).hasClass('full') && ($subject.val().length < 3 || $subject.val() == $subject.data('value'))){
                showError($subject);
                ok = false;
            }

            function showError($input){
                $input.val($input.data('value'));
                $input.addClass('contact-error-border');
                $error.fadeIn();
            }

            if(ok){

                $form.fadeOut();

                $.ajax({
                    type: $form.prop('method'),
                    url: $form.prop('action'),
                    data: $form.serialize(),
                    success: function(){
                      $success.fadeIn();
                  }
              });

            }

            e.preventDefault();

        });

    });

    /* -------------------------------
    -----   Fancybox   -----
    ---------------------------------*/

    $('img.alignleft, img.alignright, img.aligncenter').parent('a').each(function(){
        $(this).attr('class', 'fancybox fancybox-thumb ' + $(this).children('img').attr('class'));
    });

    if($('.fancybox').length > 0 || $('div[id*="attachment"]').length > 0){

        $('.fancybox, div[id*="attachment"] > a').fancybox({
            padding: 0,
            margin: 50,
            aspectRatio: true,
            scrolling: 'no',
            mouseWheel: false,
            openMethod: 'zoomIn',
            closeMethod: 'zoomOut',
            nextEasing: 'easeInQuad',
            prevEasing: 'easeInQuad'
        }).append('<span></span>');
    }

    /* -------------------------------
    -----   Tabs   -----
    ---------------------------------*/

    $('.krown-tabs').each(function(){

        var $titles = $(this).children('.titles').children('li'),
        $contents = $(this).children('.contents').children('div, section'),
        $openedT = $titles.eq(0),
        $openedC = $contents.eq(0);

        $openedT.addClass('opened');
        $openedC.stop().slideDown(0);

        $titles.find('a').prop('href', '#').off('click');;

        $titles.click(function(e){

            $openedT.removeClass('opened');
            $openedT = $(this);
            $openedT.addClass('opened');

            $openedC.stop().slideUp(200);
            $openedC = $contents.eq($(this).index());
            $openedC.stop().delay(200).slideDown(200);

            e.preventDefault();

        });

    });

    /* -------------------------------
    -----   Twitter Widget   -----
    ---------------------------------*/

    $('.krown-twitter.rotenabled').each(function(){

        var $tW = $(this).children('ul').children('li'),
            tI = 0,

        tV = setInterval(function(){

            $tW.eq(tI).fadeOut(250);

            if(++tI == $tW.length)
                tI = 0;

            $tW.eq(tI).delay(260).fadeIn(300);

        }, 6000);

    });

    /* -------------------------------
    -----   Sliders   -----
    ---------------------------------*/

    // Regular slider

    $('.flexslider.mini').each(function(){

   		var $slider = $(this);

    	if ( $slider.find('li').length > 1 ) {

	        $(this).flexslider({
	            animation: 'slider',
	            easing: 'easeInQuad',
	            animationSpeed: 300,
	            slideshow: $body.hasClass('single-product') ? false : true,
	            directionNav: true,
	            controlNav: false,
	            keyboard: false,
	            prevText: '',
	            nextText: '',
	            smoothHeight: $body.hasClass('single-product') ? true : false,
	            start: function(e){
	                e.container.delay(300).animate({'opacity': 1}, 300);
	            }
	        });

    	} else {

    		$slider.removeClass('flexslider');

    	}

    });

    // Content slider

    $('.flexslider.krown-tour').each(function(){

        var $slider = $(this);

        $(this).flexslider({
            selector: '.slides > div, .slides > section',
            animation: 'fade',
            easing: 'easeInQuad',
            animationSpeed: 300,
            slideshow: $slider.data('autoplay'),
            directionNav: $slider.data('nav-arrows'),
            controlNav: $slider.data('nav-bullets') != 'none' ? true : false,
            keyboard: false,
            prevText: '',
            nextText: '',
            smoothHeight: true
        });

    });

    /* -------------------------------
    -----   Video / Audio elements   -----
    ---------------------------------*/

    $('.rev_slider_wrapper').find('video').data('no-mejs', 'true');

    if($('#content').find('audio, video').length > 0 ) {
        $('#content').find('audio, video').each(function(){
            if($(this).data('no-mejs') != 'true'){
                $(this).mediaelementplayer({
                    alwaysShowControls: false,
                    iPadUseNativeControls: false,
                    iPhoneUseNativeControls: false,
                    AndroidUseNativeControls: false,
                    enableKeyboard: false,
                    pluginPath: themeObjects.base + '/js/mediaelement/',
                    success: function(me) {
                        $(window).trigger('resize');
                    }
                });
            }
        });
    }

    /* -------------------------------
    -----   OTHER   -----
    ---------------------------------*/

    // Style select boxes

    $('.responsive-filter select, .responsive-menu select').each(function(){
    	$(this).styledSelect({
	        coverClass: 'regular-select-cover',
	        innerClass: 'regular-select-inner'
	    }).addClass('styled');
    });

	$('select.country_select').addClass('styled');

    $('select:not(.styled)').styledSelect({
        coverClass: 'simple-select-cover',
        innerClass: 'simple-select-inner'
    });

    // Set retina cookie

    var retina = window.devicePixelRatio > 1;
    $.cookie('dpi', retina, {expires: 365, path: '/'});

    // Go to top button

    var $top = $('#top');

    $top.click(function(e){
        $('html,body').animate({scrollTop: 0}, 500, 'easeInQuad');
        e.preventDefault();
    });

    $(window).on('scroll.menu', checkMenu);
    $(window).trigger('scroll');

    function checkMenu(){
        if($(this).scrollTop() < 500 && $top.hasClass('show')) {
            $top.removeClass('show');
        } else if ($(this).scrollTop() > 500 && !$top.hasClass('show')) {
            $top.addClass('show');
        }
    }
    
///////////////

    });

})(jQuery);