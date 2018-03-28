<?php
/* 
Plugin Name: JMS URL Rewrite Rule
Plugin URI: https://jmsliu.com/products/jms-url-rewrite-rules.html
Description: The URL Rewrite Rule plugin will help to generate url rewrite rules which you can copy and paste in .htaccess files. Usually, it will be helpful when you want to restructure your website which has 50+ posts or pages. It works with post permalink, category permalink, and tag permalink.
Author: James Liu
Version: 1.0.0
Author URI: http://jmsliu.com/
License: GPL2

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//admin page
add_action( 'admin_menu', 'jmsPluginAdmin' );
function jmsPluginAdmin() {
    //top-level menu:
    add_menu_page(
        "JMS URL Rewrite",
        "JMS URL Rewrite",
        'manage_options',
        'jms-url-rewrite-top-menu',
        'jmsPostURLRewriteMenu' );

    // Add a submenu to the custom top-level menu:
    add_submenu_page(
        'jms-url-rewrite-top-menu',
        'POST URL',
        'POST URL',
        'manage_options',
        'jms-url-rewrite-top-menu',
        'jmsPostURLRewriteMenu');

    // Add a submenu to the custom top-level menu:
    add_submenu_page(
        'jms-url-rewrite-top-menu',
        'Fixed URL',
        'Fixed URL',
        'manage_options',
        'jms-fixed-url-rewrite-menu',
        'jmsFixedURLRewriteMenu');
}

//show a table
function jmsPostURLRewriteMenu() {
    global $wp;
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

    if(isset($_POST["action"]) && $_POST["action"] == "post_rule") {
        if(check_admin_referer( 'post_rule' )) {
            if(isset($_POST[ "old_permalink" ]) && trim($_POST[ "old_permalink" ]) != false
                && isset($_POST[ "new_permalink" ]) && trim($_POST[ "new_permalink" ]) != false) {

                $oldPermalink = esc_url(trim($_POST[ "old_permalink" ]));
                $newPermalink = esc_url(trim($_POST[ "new_permalink" ]));

                $patterns = array(
                    '/%year%/',
                    '/%monthnum%/',
                    '/%day%/',
                    '/%hour%/',
                    '/%minute%/',
                    '/%second%/',
                    '/%postname%/',
                    '/%post_id%/',
                    '/%category%/',
                    '/%author%/',
                    '/%pagename%/'
                );

                $permalink = get_option('permalink_structure');
                $args = array("numberposts" => -1);
                $postList = get_posts( $args );
                $rules = array();
                foreach ($postList as $k=>$post) {
                    $category = '';
                    if ( strpos($oldPermalink, '%category%') !== false
                        || strpos($newPermalink, '%category%') !== false ) {
                        $cats = get_the_category((int)$post->ID);
                        if ( $cats ) {
                            $cats = wp_list_sort( $cats, array(
                                'term_id' => 'ASC',
                            ) );
             
                            $category_object = apply_filters( 'post_link_category', $cats[0], $cats, $post );
                            $category_object = get_term( $category_object, 'category' );
                            $category = $category_object->slug;
                            // if ( $parent = $category_object->parent )
                            //     $category = get_category_parents($parent, false, '/', true) . $category;
                        }
                        // show default category in permalinks, without
                        // having to assign it explicitly
                        if ( empty($category) ) {
                            $default_category = get_term( get_option( 'default_category' ), 'category' );
                            if ( $default_category && ! is_wp_error( $default_category ) ) {
                                $category = $default_category->slug;
                            }
                        }
                    }
             
                    $author = '';
                    if ( strpos($oldPermalink, '%author%') !== false
                        || strpos($newPermalink, '%author%') !== false ) {
                        $authordata = get_userdata($post->post_author);
                        $author = $authordata->user_nicename;
                    }

                    $unixtime = strtotime($post->post_date);
                    $date = explode(" ",date('Y m d H i s', $unixtime));
                    $replacements = array(
                            $date[0],
                            $date[1],
                            $date[2],
                            $date[3],
                            $date[4],
                            $date[5],
                            $post->post_name,
                            $post->ID,
                            $category,
                            $author,
                            $post->post_name
                        );
                    $oldURL = preg_replace($patterns, $replacements, $oldPermalink);
                    $newURL = preg_replace($patterns, $replacements, $newPermalink);
                    $oldURLArray = parse_url($oldURL);
                    $newURLArray = parse_url($newURL);
                    $oldRule = "^/?" . substr($oldURLArray['path'], 1);
                    //$rules[] = "RewriteRule ^/?2804/([-a-z\.]+)$ android/$1 [R=301,L]";
                    $rules[] = "RewriteRule ".$oldRule." ".$newURLArray['path']." [R=301,L]";
                }                

                require_once(dirname(__FILE__)."/template/post_url_rules.php");
            } else {
                $message = sprintf(__('Your old url permalink setting or new url permalink setting is invalid! <a href="%s">Back</a>','jms-urlrewrite-rule'), $wp->request."admin.php?page=jms-url-rewrite-top-menu");
                echo "<h1>".$message."</h1>";
            }
        } else {
            $message = sprintf(__('Security Token Expired! <a href="%s">Back</a>','jms-urlrewrite-rule'), $wp->request."admin.php?page=jms-url-rewrite-top-menu");
            echo "<h1>".$message."</h1>";
        }
    } else {
        require_once(dirname(__FILE__)."/template/post_url_rules.php");
    }
}

function jmsFixedURLRewriteMenu() {
    global $wp;
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

    if(isset($_POST["action"]) && $_POST["action"] == "fixed_rule") {
        if(check_admin_referer( 'fixed_rule' )) {
            if(isset($_POST[ "old_permalink" ]) && trim($_POST[ "old_permalink" ]) != false
                && isset($_POST[ "new_permalink" ]) && trim($_POST[ "new_permalink" ]) != false) {

                $oldPermalink = esc_url(trim($_POST[ "old_permalink" ]));
                $newPermalink = esc_url(trim($_POST[ "new_permalink" ]));
                $oldURLArray = parse_url($oldPermalink);
                $newURLArray = parse_url($newPermalink);
                $oldRule = "^/?" . substr($oldURLArray['path'], 1);
                $rules = array();
                $rules[] = "RewriteRule ".$oldRule." ".$newURLArray['path']." [R=301,L]";
                require_once(dirname(__FILE__)."/template/fixed_url_rules.php");
            } else {
                $message = sprintf(__('Your old url permalink setting or new url permalink setting is invalid! <a href="%s">Back</a>','jms-urlrewrite-rule'), $wp->request."admin.php?page=jms-url-rewrite-top-menu");
                echo "<h1>".$message."</h1>";
            }
        } else {
            $message = sprintf(__('Security Token Expired! <a href="%s">Back</a>','jms-urlrewrite-rule'), $wp->request."admin.php?page=jms-url-rewrite-top-menu");
            echo "<h1>".$message."</h1>";
        }
    } else {
        require_once(dirname(__FILE__)."/template/fixed_url_rules.php");
    }
}

?>
