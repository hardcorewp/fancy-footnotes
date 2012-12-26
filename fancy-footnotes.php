<?php
/*
 * Plugin Name: Fancy Footnotes
 * Plugin URI: http://hardcorewp.com/plugins/fancy-footnotes
 * Description: A Footnotes plugin for WordPress that uses syntax similar to Markdown Extra, smooth scrolling to footnotes and yellow-fade highlighting of paragraphs contains footnotes and references. Developed for use on <a href="http://hardcorewp.com">HardcoreWP.com</a>.
 * Version: 0.1
 * Author: Mike Schinkel
 * Author URI: http://about.me/mikeschinkel
 * Text Domain: revostock-gallery
 * License: GPLv2
 *
 *  Copyright 2012 NewClarity LLC
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License, version 2, as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

 class Fancy_Footnotes_Plugin {
  private static $_this;
  var $plugin_file;
  var $plugin_slug;
  var $footnote_references = array();
  function this() {
    return $_this;
  }
  function __construct() {
    global $plugin, $mu_plugin, $network_plugin;
    $this->plugin_file = isset( $plugin ) ? $plugin : ( isset( $mu_plugin ) ? $mu_plugin : $network_plugin );
    if ( ! $this->plugin_file && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) )
      wp_die( __( 'Plugin filename not available when loading Fancy Footnotes Plugin.', 'fancy-footnotes' ) );
    $this->plugin_slug = preg_replace( '#.*/plugins/(.*?)$#', '$1', $this->plugin_file );
    self::$_this = $this;
    add_filter( 'the_content', array( $this, 'the_content' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
    add_shortcode( 'footnotes', array( $this, 'shortcode' ) );
  }
  function shortcode( $args, $content ) {
    $args = wp_parse_args( $args, array(
      'id' => 'footnotes',
      'head' => 'h2',
    ));
    $html = array();
    preg_match_all( '#\[\^([^]]+)\]:(.*)#', $content, $matches );
    $footnotes = array_flip( $matches[1] );
    $footnote_text = $matches[2];
    foreach( $this->footnote_references as $index => $footnote_label ) {
      if ( isset( $footnotes[$footnote_label] ) ) {
        $number = $index+1;
        $html[] = <<<HTML
<dt><a class="footnote-link" name="{$footnote_label}-footnote" href="#{$footnote_label}-reference">[{$number}]</a></dt>
<dd>{$footnote_text[$index]}</dd>
HTML;
      }
    }
    $html = implode( "\n", $html );
    $html =<<<HTML
<div id="{$args['id']}">
  <{$args['head']}>Footnotes</{$args['head']}>
  <dl>{$html}</dl>
</div>
<div class="clear"></div>
HTML;
    return $html;
  }
  function wp_enqueue_scripts() {
    wp_enqueue_script( 'fancy-footnotes',  plugins_url( '/js/script.js', $this->plugin_file ), array('jquery') );
  }
  function the_content( $content ) {
    return preg_replace_callback( '#\[\^([^]]+)\][^:]#', array( $this, '_generate_footnote_reference_html' ), $content );
  }
  function _generate_footnote_reference_html($footnote) {
    $this->footnote_references[] = $footnote[1];
    $number = count( $this->footnote_references );
    $html =<<<HTML
<a class="footnote-link" name="{$footnote[1]}-reference" href="#{$footnote[1]}-footnote"><sup>[{$number}]</sup></a>
HTML;
    return $html;
  }
}
new Fancy_Footnotes_Plugin();
