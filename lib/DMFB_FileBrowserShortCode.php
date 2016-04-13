<?php

include_once(dirname(__FILE__) .'/../DMFB_ShortCodeLoader.php');

class DMFB_FileBrowserShortCode extends DMFB_ShortCodeLoader {
    /**
     * @param  $atts shortcode inputs
     * @return string shortcode content
     */
    public function handleShortcode($atts) {
        return admin_url('admin-ajax.php') . '?action=get_dir_tds&dir=2';
    }
}

?>
