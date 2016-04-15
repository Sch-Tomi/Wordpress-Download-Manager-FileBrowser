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
            $return .= '<tr>
                          <td>
                            <div class="ext_dir"></div>
                            <a rel="' . $cat->term_id . '" href="#">'.$cat->name.'</a><br/>
                          </td>
                          <td class="hidden-xs"></td>
                        </tr>';
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
        $return .= "FUTOTTAM!!";
        $packs->the_post();
        $ext = 'blank';
        $files = maybe_unserialize(get_post_meta(get_the_ID(), '__wpdm_files', true));

        if (count($files) == 1 && $files[0]!="") {
            $tfiles = $files;
            $file = array_shift($tfiles);
            $ext = explode(".", $file);
            $ext = end($ext);
        } elseif (count($files) > 1) {
            $ext = 'zip';
        }



        if(wpdm_user_has_access(get_the_ID())) {
            // if (wpdm_query_var('ddl', 'int') == 0 || wpdm_is_locked(get_the_ID()))
            //     echo "<li  class=\"file ext_$ext\"><a href='" . get_permalink(get_the_ID()) . "' rel='" . get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a></li>";
            // else
            //     echo "<li  class=\"file ext_$ext\"><a href='" . wpdm_download_url(get_the_ID()) . "' rel='" . wpdm_download_url(get_the_ID()) . "'>" . get_the_title() . "</a></li>";

            $return .= '<tr>
                          <td>
                            <div class="ext_'.$ext.'"></div>
                            <a href= '.get_permalink(get_the_ID()) .'>'.get_the_title().'</a><br/>
                          </td>
                          <td class="hidden-xs">'. get_the_date().'</td>
                        </tr>';



        }


    }

    return $return;
}

?>
