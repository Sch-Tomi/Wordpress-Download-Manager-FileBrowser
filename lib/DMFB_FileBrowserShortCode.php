<?php

include_once(dirname(__FILE__) .'/../DMFB_ShortCodeScriptLoader.php');

class DMFB_FileBrowserShortCode extends DMFB_ShortCodeScriptLoader {
    static $addedAlready = false;

    /**
     * @param  $atts shortcode inputs
     * @return string shortcode content
     */
    public function handleShortcode($atts) {

        return '<table id="DMFB_FileBrowser">
        <thead>
            <tr role="row">
              <th rowspan="1" colspan="1">Title</th>
              <th>Create Date</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        </table>';
    }

    public function addScript() {
        if (!self::$addedAlready) {
            self::$addedAlready = true;

            wp_register_script('FileBrowser', plugins_url('../js/FileBrowser.js', __FILE__), array('jquery'), '1.0', true);
            $translation_array = array(
            	'ajax_url' => admin_url('admin-ajax.php') . '?action=get_dir_tds'
            );
            wp_localize_script( 'FileBrowser', 'DMFB', $translation_array );
            wp_print_scripts('FileBrowser');

            wp_enqueue_style('my-style', plugins_url('../css/files.css', __FILE__));
        }
    }


}

?>
