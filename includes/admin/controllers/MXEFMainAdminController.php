<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFMainAdminController class.
 *
 * Here you can connect your model with a view.
 */
class MXEFMainAdminController extends MXEFController
{

    protected $modelInstance;

    public function __construct()
    {

        $this->modelInstance = new MXEFMainAdminModel();
    }
    
    public function index()
    {

        return new MXEFMxView( 'main-page' );
    }

    public function submenu()
    {

        return new MXEFMxView( 'sub-page' );
    }

    public function hidemenu()
    {

        return new MXEFMxView( 'hidemenu-page' );
    }

    public function settingsMenuItemAction()
    {

        return new MXEFMxView( 'settings-page' );
    }

    public function singleTableItem()
    {

        // Delete action.
        $deleteId = isset( $_GET['delete'] ) ? trim( sanitize_text_field( $_GET['delete'] ) ) : false;
        
        if ($deleteId) {

            if (isset($_GET['mxef_nonce']) || wp_verify_nonce($_GET['mxef_nonce'], 'delete')) {

                $this->modelInstance->deletePermanently( $deleteId );
            }

            mxefAdminRedirect( admin_url( 'admin.php?page=' . MXEF_MAIN_MENU_SLUG . '&item_status=trash' ) );

            return;
        }

        // Restore action.
        $restore_id = isset( $_GET['restore'] ) ? trim( sanitize_text_field( $_GET['restore'] ) ) : false;
        
        if ($restore_id) {

            if (isset( $_GET['mxef_nonce']) || wp_verify_nonce($_GET['mxef_nonce'], 'restore')) {

                $this->modelInstance->restoreItem( $restore_id );

            }

            mxefAdminRedirect( admin_url( 'admin.php?page=' . MXEF_MAIN_MENU_SLUG . '&item_status=trash' ) );

            return;
        }

        // Trash action.
        $trash_id = isset( $_GET['trash'] ) ? trim( sanitize_text_field( $_GET['trash'] ) ) : false;

        if ($trash_id) {

            if (isset($_GET['mxef_nonce']) || wp_verify_nonce($_GET['mxef_nonce'], 'trash')) {

                $this->modelInstance->moveToTrash( $trash_id );

            }

            mxefAdminRedirect( admin_url( 'admin.php?page=' . MXEF_MAIN_MENU_SLUG ) );

            return;

        }

        // Edit action.
        $item_id = isset( $_GET['edit-item'] ) ? trim( sanitize_text_field( $_GET['edit-item'] ) ) : 0;
        
        $data = $this->modelInstance->getRow( NULL, 'id', intval( $item_id ) );

        if ($data == NULL) {
            if (!isset( $_SERVER['HTTP_REFERER'] ) || $_SERVER['HTTP_REFERER'] == NULL) {
                mxefAdminRedirect( admin_url( 'admin.php?page=' . MXEF_MAIN_MENU_SLUG ) );
            } else {
                mxefAdminRedirect( $_SERVER['HTTP_REFERER'] );
            }
            
            return;
        }
        
        return new MXEFMxView( 'single-table-item', $data );
    }        

    // Create a table item.
    public function createTableItem() {

        return new MXEFMxView( 'create-table-item' );
    }

}
