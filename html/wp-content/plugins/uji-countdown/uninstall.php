<?php
// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

/**
 * Uninstall operations
 */
function single_uninstall() {
    // delete subscribers table
    $GLOBALS['wpdb']->query("DROP TABLE IF EXISTS {$GLOBALS['wpdb']->prefix}uji_counter");
    $GLOBALS['wpdb']->query("DROP TABLE IF EXISTS {$GLOBALS['wpdb']->prefix}uji_subscriptions");

    // delete options
    delete_option('ujic_set');
}

$_set = get_option('ujic_set');
$delete_set = (isset( $_set['ujic_remove'] ) && !empty( $_set['ujic_remove'] ) ) ? $_set['ujic_remove'] : false;

if( $delete_set == "true" ):
    // Let's do it!
    if (is_multisite()) {
        single_uninstall();

        // delete data foreach blog
        $blogs_list = $GLOBALS['wpdb']->get_results("SELECT blog_id FROM {$GLOBALS['wpdb']->blogs}", ARRAY_A);
        if (!empty($blogs_list)) {
            foreach ($blogs_list as $blog) {
                switch_to_blog($blog['blog_id']);
                single_uninstall();
                restore_current_blog();
            }
        }
    } else {
        single_uninstall();
    }

endif;