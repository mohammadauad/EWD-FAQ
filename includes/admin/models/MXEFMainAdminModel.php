<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFMainAdminModel class.
 *
 * Here you can pass a data to a view.
 * Also, here you can register an AJAX.
 */
class MXEFMainAdminModel extends MXEFModel
{

    /*
    * Observe function.
    */
    public static function wpAjax()
    {

        add_action( 'wp_ajax_mxef_update', ['MXEFMainAdminModel', 'prepareUpdateDatabaseColumn'] );
        add_action( 'wp_ajax_mxef_create_item', ['MXEFMainAdminModel', 'prepareItemCreation'] );
        add_action( 'wp_ajax_mxef_bulk_actions', ['MXEFMainAdminModel', 'prepareBulkActions'] );
    }

    /*
    * Prepare to bulk actions.
    */
    public static function prepareBulkActions()
    {        
        
        // Checked POST nonce is not empty.
        if (empty($_POST['nonce'])) wp_die( '0' );

        // Checked or nonce match.
        if (wp_verify_nonce($_POST['nonce'], 'bulk-mxef_plural')) {

            // Delete.
            if ($_POST['bulk_action']  == 'delete') {

                if (!current_user_can('edit_posts')) return;

                self::actionDelete( $_POST['ids'] );
                
                return;
            }
            
            // Restore.
            if ($_POST['bulk_action']  == 'restore') {

                if (!current_user_can('edit_posts')) return;

                self::actionRestore( $_POST['ids'] );
                
                return;
            }

            // Move to trash.
            if ($_POST['bulk_action']  == 'trash') {

                if (!current_user_can('edit_posts')) return;

                self::actionTrash( $_POST['ids'] );
                
                return;
            }

        }

        wp_die();
    }

    /**
     * Handle bulk actions.
     */
    // Delete permanently.
    public static function actionDelete( $ids )
    {

        foreach ($ids as $id) {
            ( new self )->deletePermanently( $id );
        }

        return;
    }

    // Restore.
    public static function actionRestore( $ids )
    {

        foreach ($ids as $id) {
            ( new self )->restoreItem( $id );
        }

        return;
    }

    // Move to Trash.
    public static function actionTrash( $ids )
    {

        foreach ($ids as $id) {
            ( new self )->moveToTrash( $id );
        }

        return;
    }

    /*
    * Prepare item creation.
    */
    public static function prepareItemCreation()
    {

        // Checked POST nonce is not empty.
        if (empty($_POST['nonce'])) wp_die( '0' );

        // Checked or nonce match.
        if (wp_verify_nonce($_POST['nonce'], 'mxef_nonce_request')) {

            // Create item
            $title = sanitize_text_field( $_POST['title'] );
            $description = esc_html( $_POST['description'] );

            $data = [
                'title' => $title,
                'description' => $description,
            ];

            self::createItem( $data );
        }

        wp_die();
    }

    // Create item.
    public static function createItem( $data )
    {

        global $wpdb;
        
        $tableName = $wpdb->prefix . MXEF_TABLE_SLUG;
        
        $created = $wpdb->insert(
            
            $tableName, 
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                '%s',
                '%s',
                '%s',
            ]

        );

        echo $created;
    }

    /*
    * Prepare item updating.
    */
    public static function prepareUpdateDatabaseColumn()
    {

        // Checked POST nonce is not empty.
        if (empty($_POST['nonce'])) wp_die( '0' );

        // Checked or nonce match.
        if (wp_verify_nonce($_POST['nonce'], 'mxef_nonce_request')) {

            // Update data
            $id = sanitize_text_field( $_POST['id'] );
            $title = sanitize_text_field( $_POST['title'] );
            $description = esc_html( $_POST['description'] );

            $data = [
                'id'          => $id,
                'title'       => $title,
                'description' => $description,
            ];

            self::updateDatabaseColumn( $data );
        }

        wp_die();
    }

    // Update item.
    public static function updateDatabaseColumn( $data )
    {

        global $wpdb;
        
        $tableName = $wpdb->prefix . MXEF_TABLE_SLUG;

        $wpdb->update(

            $tableName,
            [
                'title'       => $data['title'],
                'description' => $data['description'],
            ],
            [
                'id'          => $data['id']
            ],
            [
                '%s',
                '%s',
            ]

        );
    }

    /*
    * Actions.
    */
    // Restore item.
    public function restoreItem( $id )
    {

        global $wpdb;
        
        $tableName = $wpdb->prefix . MXEF_TABLE_SLUG;

        $wpdb->update(

            $tableName,
            [
                'status' => 'publish',
            ],
            [
                'id'     => $id
            ],
            [
                '%s',
            ]

        );
    }
    // Move to trash.
    public function moveToTrash( $id )
    {

        global $wpdb;
        
        $tableName = $wpdb->prefix . MXEF_TABLE_SLUG;

        $wpdb->update(

            $tableName,
            [
                'status' => 'trash',
            ],
            [
                'id'     => $id
            ],
            [
                '%s',
            ]

        );
    }

    // Delete permanently.
    public function deletePermanently( $id )
    {

        global $wpdb;

        $tableName = $wpdb->prefix . MXEF_TABLE_SLUG;

        $wpdb->delete( 
            $tableName, 
            [
                'id' => $id
            ], 
            [ 
                '%d'
            ] 
        );
    }

}
