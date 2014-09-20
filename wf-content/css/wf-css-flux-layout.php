<?php header("Content-type: text/css"); ?>
/**
 *
 * Flux Layout - A dynamic percentage based layout engine - https://github.com/Jonnyauk/flux-layout
 * Built for the Wonderflux theme framework - https://github.com/Jonnyauk/Wonderflux
 *
 * Free to use on any project and released under the GPLv2 license
 * Created by Jonny Allbut (copyright 2014). Exceptions include, but are not limited to excerpts and inspiration from:
 * Normalize - https://git.io/normalize - MIT License - project by Nicolas Gallagher, co-created with Jonathan Neal
 * inuitcss - https://github.com/inuitcss - Apache 2 license - project by Harry Roberts
 *
 * NO DATA IS NOT ESCAPED - DANGER WILL ROBINSON!
 * THIS IS AN EXPERIMENTAL - NOT FOR PRODUCTION JUST YET!!
 *
 * @package Wonderflux
 * @since Wonderflux 2.0
 *
 */

/*! normalize.css v3.0.1 */

html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;}body{margin:0;}article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block;}audio,canvas,progress,video{display:inline-block;vertical-align:baseline;}audio:not([controls]){display:none;height:0;}[hidden],template{display:none;}a{background:transparent;}a:active,a:hover{outline:0;}abbr[title]{border-bottom:1px dotted;}b,strong{font-weight:bold;}dfn{font-style:italic;}h1{font-size:2em;margin:0.67em 0;}mark{background:#ff0;color:#000;}small{font-size:80%;}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline;}sup{top:-0.5em;}sub{bottom:-0.25em;}img{border:0;}svg:not(:root){overflow:hidden;}figure{margin:1em 40px;}hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0;}pre{overflow:auto;}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em;}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0;}button{overflow:visible;}button,select{text-transform:none;}button,html input[type="button"],input[type="reset"],input[type="submit"]{-webkit-appearance:button;cursor:pointer;}button[disabled],html input[disabled]{cursor:default;}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0;}input{line-height:normal;}input[type="checkbox"],input[type="radio"]{box-sizing:border-box;padding:0;}input[type="number"]::-webkit-inner-spin-button,input[type="number"]::-webkit-outer-spin-button{height:auto;}input[type="search"]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;}input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration{-webkit-appearance:none;}fieldset{border:1px solid #c0c0c0;margin:0 2px;padding:0.35em 0.625em 0.75em;}legend{border:0;padding:0;}textarea{overflow:auto;}optgroup{font-weight:bold;}table{border-collapse:collapse;border-spacing:0;}td,th{padding:0;}.cfix:before,.cfix:after{content:"";display:table;}.cfix:after{clear:both;}.gm-style img,img[width],img[height]{max-width:none;}

/* Other common new elements */

/**
 * Little oldschool clearfix
 */
.cfix:before, .cfix:after { content:""; display:table; }
.cfix:after { clear:both; }

/**
 * Google Maps breaks if 'max-width: 100%' acts upon it
 * If a 'width' and/or 'height' attribute have been explicitly defined,
 * don't make fluid
 */
.gm-style img, img[width], img[height] { max-width: none; }

<?php

/* DO IT! Just for testing and development */
$wf_grid = new wflux_layout;
$wf_grid->grid_container();
$wf_grid->grid_float_blocks();
$wf_grid->grid_blocks();
$wf_grid->grid_space_loops();
$wf_grid->grid_push_loops();
$wf_grid->grid_relative_loops(array(1,2,3,4,5,6,7,8,9,10,11,12));
$wf_grid->grid_media_queries();

/**
 * Percent based CSS layout generator
 * @since 2.0
 */
class wflux_layout {

	protected $rwd_width;				// Width of main container (% or pixels)
	protected $rwd_columns;				// Number of columns in layout
	protected $rwd_column_width;		// Width of columns (%)
	protected $rwd_class_prepend;		// Prepend all CSS selectors (or not!)
	protected $rwd_minify;			// CSS selector - column width blocks
	protected $rwd_class_space_left;	// CSS selector - padding left
	protected $rwd_class_space_right;	// CSS selector - padding right
	protected $rwd_class_move_left;		// CSS selector - margin left
	protected $rwd_class_move_right;	// CSS selector - margin right

	function __construct() {

		// TODO: - Add in filters
		// TODO: Build admin option controls

		$this->rwd_width = ( is_numeric( $_GET['w'] ) && $_GET['w'] <= 101 ) ? $_GET['w'] : 80;
		$this->rwd_columns = ( is_numeric( $_GET['c'] ) && $_GET['c'] <= 101 ) ? $_GET['c'] : 20;
		$this->rwd_column_width = 100 / $this->rwd_columns;
		$this->rwd_class_prepend = 'boxx-';
		$this->rwd_minify = "\n";

		$this->rwd_class_space_left = $this->rwd_class_prepend . 'pad-left';
		$this->rwd_class_space_right = $this->rwd_class_prepend . 'pad-right';
		$this->rwd_class_move_left = $this->rwd_class_prepend . 'move-left';
		$this->rwd_class_move_right = $this->rwd_class_prepend . 'move-right';
		$this->rwd_minify_2 = $this->rwd_minify . $this->rwd_minify;

	}

	/*
	 * Outputs main site container
	 */
	function grid_container(){

		echo '.container { '
		. 'width: ' . $this->rwd_width . '%; margin: 0 auto; }' . $this->rwd_minify_2;

	}

	/*
	 * Outputs float rules for all blocks
	 */
	function grid_float_blocks(){

		for ( $limit=1; $limit <= $this->rwd_columns; $limit++ ) {
			echo 'div.' . $this->rwd_class_prepend . $limit;
			echo ($limit == $this->rwd_columns) ? '' : ', ';
		}
		echo " { float: left; margin: 0; }" . $this->rwd_minify_2;

	}

	/*
	 * Outputs percent widths for blocks
	 */
	function grid_blocks(){

		for ( $limit=1; $limit <= $this->rwd_columns; $limit++ ) {
			echo '.' . $this->rwd_class_prepend . $limit . ' { width: '
			. $this->rwd_column_width * $limit . '%; ' . "} " . $this->rwd_minify;
		}
		echo $this->rwd_minify;

	}

	/*
	 * Outputs margin + padding rules
	 */
	function grid_mover( $type, $definition, $direction ){

		$negpos = ( $type == 'push' ) ? '-' : '';
		$css_type = ( $type == 'push' ) ? 'margin' : 'padding';

		$css_1 = ( $direction == 'l' ) ? '{ ' . $css_type . ': 0 ' . $negpos : '{ ' . $css_type . ': 0 0 0 ' . $negpos;
		$css_2 = ( $direction == 'l' ) ? ' 0 0; ' : '; ';

		for ( $limit=1; $limit <= $this->rwd_columns; $limit++ ) {
			echo '.' . $definition . '-' . $limit . ' ' . $css_1
			. $this->rwd_column_width * $limit . '%' . $css_2 . '} ' . $this->rwd_minify;
		}

	}

	function grid_space_loops(){

		$this->grid_mover( 'space', $this->rwd_class_space_left, 'l' );
		$this->grid_mover( 'space', $this->rwd_class_space_right, 'r' );
		echo $this->rwd_minify;

	}

	function grid_push_loops(){

		$this->grid_mover( 'push', $this->rwd_class_move_left, 'l' );
		$this->grid_mover( 'push', $this->rwd_class_move_right, 'r' );
		echo $this->rwd_minify;

	}

	/*
	 * Outputs main site container
	 * $sizes = array of integers representing what dividions to output
	 */
	function grid_relative_loops($sizes) {

		if ( !is_array($sizes) ) return;

		foreach( $sizes as $size ) {

			//if ( intval($size) < 16 ) return;

			switch( $size ){
				case 1: $def = array( 1, 'full' ); break;
				case 2: $def = array( 2, 'half' ); break;
				case 3: $def = array( 3, 'third' ); break;
				case 4: $def = array( 4, 'forth' ); break;
				case 5: $def = array( 5, 'fifth' ); break;
				case 6: $def = array( 6, 'sixth' ); break;
				case 7: $def = array( 7, 'seventh' ); break;
				case 8: $def = array( 8, 'eighth' ); break;
				case 9: $def = array( 9, 'ninth' ); break;
				case 10: $def = array( 10, 'tenth' ); break;
				case 11: $def = array( 11, 'eleventh' ); break;
				case 12: $def = array( 12, 'twelfth' ); break;
				case 13: $def = array( 13, 'thirteenth' ); break;
				case 14: $def = array( 14, 'fourteenth' ); break;
				case 15: $def = array( 15, 'fifteenth' ); break;
				case 16: $def = array( 16, 'sixteenth' ); break;
				case 17: $def = array( 17, 'seventeenth' ); break;
				case 18: $def = array( 18, 'eightteenth' ); break;
				case 19: $def = array( 19, 'nineteenth' ); break;
				case 20: $def = array( 20, 'twentieth' ); break;
				default: $def = array( 0, '' ); break;
			}

			if ( $def[0] > 0 ) {

				echo '/**** ' . $def[0] . ' - ' . $def[1] . ' ****/' . $this->rwd_minify;

				if ( $size == 1 ){

					echo $this->rwd_class_prepend . '1-1, .' . $this->rwd_class_prepend
					. $def[1] .' { width: 100%; ' . "} " . $this->rwd_minify;

				} else {

					for ( $limit=1; $limit < $size; $limit++ ) {

						echo '.' . $this->rwd_class_prepend . $limit . '-' . $def[0]
						. ', .' . $this->rwd_class_prepend . $limit . '-' . $def[1]
						. ' { width: ' . $limit * ( 100 / $size ) . '%; ' . 'float:left;' . " } " . $this->rwd_minify;

					}

				}

				echo $this->rwd_minify;

			}

		}

	}

	/*
	 * Media queries output for different sized screens
	 * 4 definitions:
	 * rwd-tiny Tiny screens - small portrait phones
	 * rwd-small Small screens - Lower spec landscape phones and some portrait tablets
	 * rwd-medium Medium screens - Standard computers and landscape tablets
	 * rwd-large Large screens - Swanky hi-res screens
	 */
	function grid_media_queries() {

		// TODO: Options and filters on min or max width
		// TODO: Options and filters on breakpoint integers
		$sizes = array(
			'tiny'	=> array(
							'def'	=> 'rwd-tiny',
							'min'	=> 0,
							'max'	=> 480,
							'units'	=> 'px',
							'note'	=> 'Tiny screens - small portrait phones'
						),
			'small'		=> array(
							'def'	=> 'rwd-small',
							'min'	=> 481,
							'max'	=> 768,
							'units'	=> 'px',
							'note'	=> 'Small screens - Lower spec landscape phones and some portrait tablets'
						),
			'medium'		=> array(
							'def'	=> 'rwd-medium',
							'min'	=> 769,
							'max'	=> 1409,
							'units'	=> 'px',
							'note'	=> 'Medium screens - Standard computers and landscape tablets'
						),
			'large'		=> array(
							'def'	=> 'rwd-large',
							'min'	=> 1410,
							'units'	=> 'px',
							'note'	=> 'Large screens - Swanky hi-res screens'
						),

		);

		// Array of just definitions - used for -hide-except rules
		$all_defs = array();

		foreach ($sizes as $size) {
			$all_defs[] = $size['def']; // Used to exclude in hider media queries
			$sizes_min[] = $size['min']; // Used to exclude in hider media queries
			$sizes_max[] = $size['max']; // Used to exclude in hider media queries
		}

		$all_defs_count = count( $all_defs );

		foreach ( $sizes as $size ) {

			// Units are only ever 2 characters...right?
			$units = ( !$size[units] && $size[units] == 'px' ) ? 'px' : substr( $size[units], 0, 2 );
			$min = ( !$size[min] && !is_numeric($size[min]) ) ? '' : 'and ( min-width:' . $size[min] . $units . ' )';
			$max = ( !$size[max] && !is_numeric($size[max]) ) ? '' : 'and ( max-width:' . $size[max] . $units . ' )';
			$size_queries = ( !empty($min) && !empty($max) ) ? $min . ' ' . $max : $min . $max;

			// Core media queries
			// TODO: More to come!
			echo '/* ' . $size['def'] . ': ' . $size['note'] . ' */' . $this->rwd_minify
			. '@media screen ' . $size_queries . ' {' . $this->rwd_minify
			. ' .' . $size['def'] . '-hide { display: none; }' . $this->rwd_minify;

			// Hiders
			$o_count = 2;
			foreach ( $all_defs as $def ) {
				$o_1 = ( ($all_defs_count) == $o_count ) ? ' ' : ',';
				echo ( $def != $size['def'] ) ? ' .' . $def . '-only' . $o_1 : '';
				$o_count = ( $def != $size['def'] ) ? $o_count+1 : $o_count;
			}
			echo '{ display: none; }' . $this->rwd_minify;


		}

	}

}

?>