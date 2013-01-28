<?php
/*
Plugin Name:  Sched Embed
Description:  Embed event content from sched.org into your WordPress site
Version:      1.0
Author:       Code for the People
Author URI:   http://codeforthepeople.com/
Text Domain:  sched-embed
Domain Path:  /languages/
License:      GPL v2 or later

Copyright © 2013 Code for the People Ltd

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

defined( 'ABSPATH' ) or die();

if ( !class_exists( 'Sched_Embed_Plugin' ) ) {
class Sched_Embed_Plugin {

	private function __construct() {

		add_action( 'init',     array( $this, 'load_textdomain' ) );
		add_shortcode( 'sched', array( $this, 'do_shortcode' ) );

	}

	public function load_textdomain() {
		load_plugin_textdomain( 'sched-embed', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function do_shortcode( array $atts = null, $content = '' ) {

		$shortcode = new Sched_Embed_Shortcode( get_the_ID(), $atts, $content );
		return $shortcode->get_output();

	}

	public static function init() {
		static $instance = null;
		if ( null === $instance )
			$instance = new Sched_Embed_Plugin;
		return $instance;
	}

}
}

if ( !class_exists( 'Sched_Embed_Shortcode' ) ) {
class Sched_Embed_Shortcode {

	function __construct( $post_id, array $atts, $content = '' ) {

		$this->atts = shortcode_atts( array(
			'url'        => null,
			'view'       => 'default',
			'width'      => null,
			'sidebar'    => true,
			'background' => null,
		), $atts );
		$this->post_id = $post_id;
		$this->content = $content;

	}

	function get_att( $att ) {
		if ( isset( $this->atts[$att] ) )
			return $this->atts[$att];
		return null;
	}

	function get_post() {
		return get_post( $this->post_id );
	}

	function fetch_title() {

		# http://core.trac.wordpress.org/ticket/15058
		$cache_key = $this->url;

		if ( $cache = get_site_transient( $cache_key ) )
			return $cache;

		$request = wp_remote_get( $this->url );
		$body    = wp_remote_retrieve_body( $request );

		if ( empty( $body ) )
			return $this->url;

		preg_match( '|<title>([^<]+)</title>|i', $body, $m );

		if ( !isset( $m[1] ) or empty( $m[1] ) )
			return $this->url;

		$title = trim( $m[1] );

		set_site_transient( $cache_key, $title, 60*60*24 );

		return $title;

	}

	function get_output() {

		if ( !$this->get_att( 'url' ) or ( false === strpos( $this->get_att( 'url' ), '.sched.org' ) ) ) {
			if ( current_user_can( 'edit_post', $this->get_post()->ID ) )
				return sprintf( '<strong>%s</strong>', __( 'Sched Embed: Your shortcode should contain a sched.org URL.', 'sched-embed' ) );
			else
				return '';
		}

		switch ( $this->get_att( 'view' ) ) {

			case 'expanded':
				$suffix = '/list/descriptions';
				break;

			case 'grid':
				$suffix = '/grid';
				break;

			case 'venues':
				$suffix = '/venues';
				break;

			case 'attendees':
				$suffix = '/directory';
				break;

			case 'speakers':
				$suffix = '/directory/speakers';
				break;

			case 'sponsors':
				$suffix = '/directory/sponsors';
				break;

			case 'exhibitors':
				$suffix = '/directory/exhibitors';
				break;

			default:
				$suffix = '/';
				break;

		}

		$this->base_url = untrailingslashit( esc_url_raw( $this->get_att( 'url' ) ) );
		$this->url = $this->base_url . $suffix;

		if ( empty( $this->content ) )
			$this->content = esc_html( $this->fetch_title() );

		$atts = array();
		$attributes = '';

		if ( null !== $this->get_att( 'width' ) )
			$atts['data-sched-width'] = $this->get_att( 'width' );

		if ( in_array( $this->get_att( 'sidebar' ), array( 'no', 'false', '0' ) ) )
			$atts['data-sched-sidebar'] = 'no';

		if ( in_array( $this->get_att( 'background' ), array( 'dark' ) ) )
			$atts['data-sched-bg'] = $this->get_att( 'background' );

		foreach ( $atts as $k => $v )
			$attributes .= sprintf( ' %s="%s"', $k, esc_attr( $v ) );

		wp_enqueue_script(
			'sched-embed',
			sprintf( '%s/js/embed.js', $this->base_url ),
			array(),
			null,
			true
		);

		return sprintf( '<a id="sched-embed" href="%s"%s>%s</a>',
			esc_url( $this->url ),
			$attributes,
			$this->content
		);

	}

}
}

Sched_Embed_Plugin::init();

