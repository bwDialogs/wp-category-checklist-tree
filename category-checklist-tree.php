<?php
/*
Plugin Name: Category Checklist Tree
Version: 1.3.3
Description: Preserves the category hierarchy on the post editing screen; disables top categories that have children (Forked from http://scribu.net/wordpress/category-checklist-tree)
Author: bwDialogs
Author URI: http://github.com/bwDialogs
Plugin URI: http://github.com/bwDialogs/wp-category-checklist-tree
*/

class Category_Checklist {

	static function init() {
		add_filter( 'wp_terms_checklist_args', array( __CLASS__, 'checklist_args' ) );
	}

	static function checklist_args( $args ) {
		add_action( 'admin_footer', array( __CLASS__, 'script' ) );

		$args['checked_ontop'] = false;

		return $args;
	}

	// Scrolls to first checked category
	static function script() {
?>
<script type="text/javascript">
	jQuery(function(){
		jQuery('[id$="-all"] > ul.categorychecklist').each(function() {
			var $list = jQuery(this);
			var $firstChecked = $list.find(':checkbox:checked').first();

			if ( !$firstChecked.length )
				return;

			var pos_first = $list.find(':checkbox').position().top;
			var pos_checked = $firstChecked.position().top;

			$list.closest('.tabs-panel').scrollTop(pos_checked - pos_first + 5);
		});

        // hide input of top level categories, if it has children present
        jQuery("#categorychecklist>li>label input").each(function(){
            if(jQuery(this).prop('checked')) return;
            if(!jQuery(this).closest('li').find('ul.children').length) return;
            jQuery(this).prop('disabled', true).prop('checked',false);
        });

	});
</script>
<?php
	}
}

Category_Checklist::init();

