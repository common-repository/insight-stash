<?php

/*
Plugin Name: Insight Stash
Plugin URI: https://insightstash.com
Description: Feedback platform integration for Insight Stash surveys. Fast, Simple feedback and NPS surveys.
Author: Insight Stash
Version: 1.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

define( 'anu_aweber_path', plugin_dir_path( __FILE__ ) );

function insight_stash(){
    $anu_opt = (array)get_option('as_script_save');
	$is_account = (empty($anu_opt['is_account']) === false) ? $anu_opt['is_account'] : null ;
    wp_register_script( 'insight-stash', 'https://cdn.insightstash.com/a.js', array(), 1.0, false );
    wp_localize_script( 'insight-stash', 'stash_data',
		   array( 
			   'account'   => $is_account
		   )
	   );
    wp_enqueue_script('insight-stash');
}
add_action('wp_enqueue_scripts','insight_stash');


function insight_stash_menu(){
	add_options_page('Insight Stash','Insight Stash', 'manage_options', 'insight_stash', 'insight_stash_display');
}
add_action('admin_menu','insight_stash_menu');
function insight_stash_display(){
?>

<div class="wrap" style="position:relative;overflow: hidden;">
<?php
echo '<a href="https://insightstash.com" target="_blank">
		<img style="width: 180px;" src="' . plugins_url('assets/m-dark.png', __FILE__) . '"> </a>'
	?>
<p>
Insight Stash platform allows you to run visitor satisfaction surveys on your wordpress site. In order to start using this plugin
you need to obtain <strong>Account ID</strong> from administrator panel <a target="_blank" href="https://app.insightstash.com/manage/code_center">
Code Center</a>.
</p>
<p>Simply copy and paste account ID into the box below, and you are all set!</p>
    	<?php settings_errors(); ?>
    <form action="options.php" method="POST">
	    <?php do_settings_sections('insight_stash_form'); ?>
	    <?php settings_fields('insight_stash_sections'); ?>
	    <?php submit_button(); ?>
    </form>
</div>


<?php
}



function insight_stash_all_options(){
    add_settings_section('insight_stash_sections','Options', 'insight_stash_section_display','insight_stash_form');
    add_settings_field('as_script_value', 'Account ID' , 'insight_stash_variable_display','insight_stash_form', 'insight_stash_sections');
    register_setting('insight_stash_sections','as_script_save');
}
add_action('admin_init', 'insight_stash_all_options');

function insight_stash_section_display(){
	return false;
}

function insight_stash_variable_display(){
	$anu_opt = (array)get_option('as_script_save');
	$anu_opt = (empty($anu_opt['is_account']) === false) ? $anu_opt['is_account'] : null ;
	?>
<input type="text" name="as_script_save[is_account]" class="regular-text" value="<?php echo $anu_opt; ?>">
<p>Insert Insight Stash account ID</p>
	<?php
}



