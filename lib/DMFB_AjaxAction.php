<?php

function get_TDS($dir)
{
    global $wpdb;
    $cats = get_terms('wpdmcategory', array('hide_empty' => false));


    // All Cats
    $scat = $dir == '/' ? '' : $dir;

    $return = "";

    // DIR LIST
    foreach ($cats as $id => $cat) {
        if ($cat->parent == intval($scat))
            $return .= "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . $cat->term_id . "\">" . $cat->name . "</a></li>";

    }

    // All files
    $params = array(
        'post_type' => 'wpdmpro',
        'posts_per_page' => 9999
    );

    if($scat==''){
        $params['tax_query'] = array(
            array(
                'taxonomy' => 'wpdmcategory',
                'field' => 'term_id',
                'terms' => get_terms( 'wpdmcategory', array( 'fields' => 'ids'  ) ),
                'operator' => 'NOT IN',
            )
        );
    } else {
        $params['tax_query'] = array(
            array(
                'taxonomy' => 'wpdmcategory',
                'field' => 'term_id',
                'terms' => $scat,
                'include_children' => false
            )
        );
    }


    $packs = new WP_Query($params);


    while ($packs->have_posts()) {
        $packs->the_post();

        $files = maybe_unserialize(get_post_meta(get_the_ID(), '__wpdm_files', true));
        if (count($files) == 1) {
            $tfiles = $files;
            $file = array_shift($tfiles);
            $ext = explode(".", $file);
            $ext = end($ext);
        }
        if (count($files) > 1) {
            $ext = 'zip';
        }
        if (!is_array($files) || count($files) == 0) {
            $ext = '_blank';
        }



        if(wpdm_user_has_access(get_the_ID())) {
            // if (wpdm_query_var('ddl', 'int') == 0 || wpdm_is_locked(get_the_ID()))
            //     echo "<li  class=\"file ext_$ext\"><a href='" . get_permalink(get_the_ID()) . "' rel='" . get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a></li>";
            // else
            //     echo "<li  class=\"file ext_$ext\"><a href='" . wpdm_download_url(get_the_ID()) . "' rel='" . wpdm_download_url(get_the_ID()) . "'>" . get_the_title() . "</a></li>";

            $return .= '<tr>
                <td style=";background-size: 32px;background-position: 5px 8px;background-repeat:  no-repeat;padding-left: 43px;line-height: normal;">
                    <a class="package-title" href= '.wpdm_download_url(get_the_ID()) .'>'.the_title().'</a><br/>
                    <small><i class="fa fa-folder"></i> &nbsp; '.count($files).' '. _e('files','wpdmpro').' &nbsp;&nbsp;
                        <i class="fa fa-download"></i> &nbsp; '.count($files).'
                    </small>
                </td>
                <td class="hidden-xs">'. get_the_date().'</td>
                <td><a href=' . wpdm_download_url(get_the_ID()) . ' rel=' . wpdm_download_url(get_the_ID()) . '>Letöltés</a></td>
            </tr>';


        }

        return $return;
    }


}

?>
