<?php
/**
 * Google Fonts
 */

function icore_google_fonts() {
    $fonts = array(
		'Helvetica-Neue' => array(
			'name' => 'Helvetica',
			'title' => 'Helvetica',
	        'parameter' => '400,700',
	        'font-family' => 'cursive'
	    ),
        'Allan' => array(
			'name' => 'Allan',
			'title' => 'Allan',
            'parameter' => '400,700',
            'font-family' => 'cursive'
        ),
        'Allerta' => array(
			'name' => 'Allerta',
			'title' => 'Allerta',
            'parameter' => '',
            'font-family' => 'sans-serif'
        ),
        'Anton' => array(
			'name' => 'Anton',
			'title' => 'Anton',
            'parameter' => '',
            'font-family' => 'sans-serif'
        ),
        'Arvo' => array(
			'name' => 'Arvo',
			'title' => 'Arvo',
            'parameter' => '400,700',
            'font-family' => 'serif'
        ),
        'Bevan' => array(
			'name' => 'Bevan',
			'title' => 'Bevan',
            'parameter' => '',
            'font-family' => 'cursive'
        ),
        'Bitter' => array(
			'name' => 'Bitter',
			'title' => 'Bitter',
            'parameter' => '400,700,400italic',
            'font-family' => 'serif'
        ),
        'Cabin' => array(
			'name' => 'Cabin',
			'title' => 'Cabin',
            'parameter' => '400,700,400italic',
            'font-family' => 'sans-serif'
        ),
        'Cardo' => array(
			'name' => 'Cardo',
			'title' => 'Cardo',
            'parameter' => '400,400italic,700',
            'font-family' => 'serif'
        ),
        'Crimson Text' => array(
			'name' => 'Crimson Text',
			'title' => 'Crimson Text',
            'parameter' => '400,400italic,700',
            'font-family' => 'serif'
        ),
        'Dancing Script' => array(
			'name' => 'Dancing Script',
			'title' => 'Dancing Script',
            'parameter' => '400,700',
            'font-family' => 'cursive'
        ),
        'Droid Serif' => array(
			'name' => 'Droid Serif',
			'title' => 'Droid Serif',
            'parameter' => '400,700,400italic,700italic',
            'font-family' => 'serif'
        ),
        'Goudy Bookletter 1911' => array(
			'name' => 'Goudy Bookletter 1911',
			'title' => 'Goudy Bookletter 1911',
            'parameter' => '',
            'font-family' => 'serif'
        ),
        'Junge' => array(
			'name' => 'Junge',
			'title' => 'Junge',
            'parameter' => '',
            'font-family' => 'serif'
        ),
        'Josefin Sans' => array(
			'name' => 'Josefin Sans',
			'title' => 'Josefin Sans',
            'parameter' => '100,300,400,700,400italic',
            'font-family' => 'sans-serif'
        ),
        'Lekton' => array(
			'name' => 'Lekton',
			'title' => 'Lekton',
            'parameter' => '400,700,400italic',
            'font-family' => 'sans-serif'
        ),
        'Molengo' => array(
			'name' => 'Molengo',
			'title' => 'Molengo',
            'parameter' => '',
            'font-family' => 'sans-serif'
        ),
        'Lora' => array(
			'name' => 'Lora',
			'title' => 'Lora',
            'parameter' => '400,700,400italic',
            'font-family' => 'serif'
        ),
        'Lobster' => array(
			'name' => 'Lobster',
			'title' => 'Lobster',
            'parameter' => '',
            'font-family' => 'cursive'
        ),
        'News Cycle' => array(
			'name' => 'News Cycle',
			'title' => 'News Cycle',
            'parameter' => '400,700',
            'font-family' => 'sans-serif'
            ),
        'Open Sans' => array(
			'name' => 'Open Sans',
			'title' => 'Open Sans',
            'parameter' => '400italic,400,300,700,800',
            'font-family' => 'sans-serif'
        ),
        'Oswald' => array(
			'name' => 'Oswald',
			'title' => 'Oswald',
            'parameter' => '400,300,700italic',
            'font-family' => 'sans-serif'
        ),
        'PT Sans' => array(
			'name' => 'PT Sans',
			'title' => 'PT Sans',
            'parameter' => '400,700,400italic',
            'font-family' => 'sans-serif'
        ),
        'Prociono' => array(
			'name' => 'Prociono',
			'title' => 'Prociono',
            'parameter' => '',
            'font-family' => 'serif'
        ),
        'Raleway' => array(
			'name' => 'Raleway',
			'title' => 'Raleway',
            'parameter' => '400,200,300,100',
            'font-family' => 'sans-serif'
        ),
        'Rokkitt' => array(
			'name' => 'Rokkitt',
			'title' => 'Rokkitt',
            'parameter' => '400,700',
            'font-family' => 'serif'
        ),
        'Shadows Into Light Two' => array(
			'name' => 'Shadows Into Light Two',
			'title' => 'Shadows Into Light Two',
            'parameter' => '',
            'font-family' => 'cursive'
        )
    );

    return $fonts;
}


function icore_google_fonts_choices(){
    $fonts = icore_google_fonts();
    $tmp = array();

    foreach( $fonts as $font => $attributes ){
        $tmp[$font] = $font;
    }
    return $tmp;
}