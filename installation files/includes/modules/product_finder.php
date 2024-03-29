<?php
/**
 * Product Finder module
 * includes/modules/product_finder.php
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product_finder.php 16-07-2019
 */
$pfDebug = 0;//set to 1 (not '1') for debugging info
if ($pfDebug) {
    echo __LINE__ . ':Product Finder debug ON</div><br>';
}
////////////////////////////////////////////////////
$pf_base_category = (int)PRODUCT_FINDER_PARENT_ID; //USER defined base category
$pf_category_depth = (int)PRODUCT_FINDER_CATEGORY_DEPTH; //USER defined category depth
//Note that most of this convoluted POST and GET coding is purely to allow PF to work without javascript...and then behave logically when the dropdowns are changed in various non-logical orders
//noscript
$js_disabled = (isset($_POST['js_disabled']) && $_POST['js_disabled'] === 'true');
if (isset($_GET['pf_dd1_prev'])) {//this page load is a result of a complete PF selection and so was a redirect with GET parameters, and should be in a category
    $prev_dd1 = (int)$_GET['pf_dd1_prev'];
    $prev_dd2 = (int)$_GET['pf_dd2_prev'];
    $prev_dd3 = (int)$_GET['pf_dd3_prev'];
    if ($pfDebug) {
        echo __LINE__ . ':GET $prev_dd1=' . $prev_dd1 . ' | $prev_dd2=' . $prev_dd2 . ' | $prev_dd3=' . $prev_dd3 . '</div><br>';
    }
} else {//this page load is from a PF partial selection, or some other manual/unrelated link
//noscript, get previous POST selections
    $prev_dd1 = !empty($_POST['pf_dd1_prev']) ? (int)$_POST['pf_dd1_prev'] : -1;
    $prev_dd2 = !empty($_POST['pf_dd2_prev']) ? (int)$_POST['pf_dd2_prev'] : -1;
    $prev_dd3 = !empty($_POST['pf_dd3_prev']) ? (int)$_POST['pf_dd3_prev'] : -1;
}
//noscript, get current noscript POST selections
$post_dd1 = !empty($_POST['pf_dd1']) ? (int)$_POST['pf_dd1'] : -1;
$post_dd2 = !empty($_POST['pf_dd2']) ? (int)$_POST['pf_dd2'] : -1;
$post_dd3 = !empty($_POST['pf_dd3']) ? (int)$_POST['pf_dd3'] : -1;
if ($pfDebug) {
    echo __LINE__ . ':POST $post_dd1=' . $post_dd1 . ' | $post_dd2=' . $post_dd2 . ' | $post_dd3=' . $post_dd3 . '<br>';
    echo __LINE__ . ':PREV $prev_dd1=' . $prev_dd1 . ' | $prev_dd2=' . $prev_dd2 . ' | $prev_dd3=' . $prev_dd3 . '<br>';
}

if ($js_disabled && empty($_GET['pf_ns']) && ($post_dd1 === $prev_dd1) && ($post_dd2 === $prev_dd2) && ($post_dd3 > 0)) {//noscript, a complete NEW selection has been made, so go to that category
    $cp = $pf_base_category . '_' . $post_dd1 . '_' . $post_dd2 . '_' . $post_dd3;
    $link = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cp . '&pf_dd1_prev=' . $post_dd1 . '&pf_dd2_prev=' . $post_dd2 . '&pf_dd3_prev=' . $post_dd3 . '&pf_ns=1');

    if ($pfDebug) {
        echo __LINE__ . ': $link=' . $link . '<br>';
    }
    zen_redirect($link); //final parameter is the post value to know what was completely selected
} elseif (($post_dd1 !== $prev_dd1) && ($post_dd1 > 0) && ($post_dd3 === $prev_dd3)) {//noscript, only dd1 has changed: reload the existing page but reset dd2 and dd3
    $post_dd2 = -1;
    $post_dd3 = -1;
} elseif (($post_dd2 !== $prev_dd2) && ($post_dd2 > 0) && ($post_dd3 === $prev_dd3)) {//noscript, only dd2 has changed: reload the existing page but reset dd3
    $post_dd3 = -1;
}

//get current page location if in a category
if (isset($cPath) && $cPath !== '') {//$cPath is only set on a category/product page
    $pf_cPaths = explode('_', $cPath);
    if ((int)$pf_cPaths[0] !== $pf_base_category) {
        $pf_cPaths = '';
    }
} else {
    $pf_cPaths = ''; //for php notice undefined variable
}
if ($pfDebug) {
    echo __LINE__ . ':$cPath= ' . $cPath . '<br>';
    echo '$pf_cPaths=<pre>';
    print_r($pf_cPaths);
    echo '</pre></div><br>';
}

//Pre-populate each dropdown if it reflects the current subcategory (get value from $cPath) or noscript (get values from POST)
if ($post_dd1 > 0) {
    $pf_dd1_selected = $post_dd1;
} elseif (is_array($pf_cPaths) && !empty($pf_cPaths['1'])) {
    $pf_dd1_selected = (int)$pf_cPaths['1'];
} else {
    $pf_dd1_selected = -1; //Please Select
}

if ($post_dd2 > 0) {
    $pf_dd2_selected = $post_dd2;
} elseif (is_array($pf_cPaths) && !empty($pf_cPaths['2'])) {
    $pf_dd2_selected = (int)$pf_cPaths['2'];
} else {
    $pf_dd2_selected = -1;
}

if ($post_dd3 > 0) {
    $pf_dd3_selected = $post_dd3;
} elseif (is_array($pf_cPaths) && !empty($pf_cPaths['3'])) {
    $pf_dd3_selected = (int)$pf_cPaths['3'];
} else {
    $pf_dd3_selected = -1;
}
if ($pfDebug) {
    echo __LINE__ . ':$pf_dd1_selected=' . $pf_dd1_selected . ' | $pf_dd2_selected=' . $pf_dd2_selected . ' | $pf_dd3_selected=' . $pf_dd3_selected . '<br>';
}
//prepopulate dropdowns when arriving at a product/category page inside the Product Finder parent category
$pf_dd1_array = pf_get_subcategories($pf_base_category); //build the array for dropdown1
$pf_dd2_array = pf_get_subcategories($pf_dd1_selected); //build the array for dropdown2
$pf_dd3_array = pf_get_subcategories($pf_dd2_selected); //build the array for dropdown3

$cp = isset($cPath) && $cPath !== '' ? 'cPath=' . $cPath : ''; //if on a category page, stay there until a complete new selection made (redirect). If on another page, stay there too!
echo zen_draw_form('productFinderform', zen_href_link($_GET['main_page'], $cp), 'post', 'id="productFinderform"'); //this action is overridden when JS in use
//pass current states so code can determine what has changed on each submit and act according, or not.
echo zen_draw_hidden_field('pf_dd1_prev', $pf_dd1_selected);
echo zen_draw_hidden_field('pf_dd2_prev', $pf_dd2_selected);
echo zen_draw_hidden_field('pf_dd3_prev', $pf_dd3_selected);
?>
<!--bof product finder -->
<div id="productFinder">
<noscript>
    <?php echo zen_draw_hidden_field('js_disabled', 'true'); ?>
</noscript>
<span id="pf_title"><?php echo PF_TEXT_TITLE; ?></span>
<ul id="pfList">
    <li>
        <span><?php echo zen_draw_label(PF_TEXT_DD1, 'pf_dd1', 'class="pf_selectBoxLabel"'); ?></span>
        <?php echo zen_draw_pull_down_menu('pf_dd1', $pf_dd1_array, $pf_dd1_selected, 'id="pf_dd1" class="pf_selectBoxContent" title="' . PF_TEXT_DD1 . '"'); ?>
    </li>
    <li class="pf_go">
        <noscript>
            <?php echo zen_image_submit(PF_NOSCRIPT_SUBMIT, PF_NOSCRIPT_SUBMIT_ALT, '', 'pf_go_css_button'); ?>
        </noscript>
    </li>

    <li>
        <span><?php echo zen_draw_label(PF_TEXT_DD2, 'pf_dd2', 'class="pf_selectBoxLabel"'); ?></span>
        <?php echo zen_draw_pull_down_menu('pf_dd2', $pf_dd2_array, $pf_dd2_selected, 'id="pf_dd2" class="pf_selectBoxContent" title="' . PF_TEXT_DD2 . '"'); ?>
    </li>
    <li class="pf_go">
        <noscript>
            <?php echo zen_image_submit(PF_NOSCRIPT_SUBMIT, PF_NOSCRIPT_SUBMIT_ALT, '', 'pf_go_css_button'); ?>
        </noscript>
    </li>

    <li>
        <span><?php echo zen_draw_label(PF_TEXT_DD3, 'pf_dd3', 'class="pf_selectBoxLabel"'); ?></span>
        <?php echo zen_draw_pull_down_menu('pf_dd3', $pf_dd3_array, $pf_dd3_selected, 'id="pf_dd3" class="pf_selectBoxContent" title="' . PF_TEXT_DD3 . '"'); ?>
    </li>
    <li class="pf_go">
        <noscript>
            <?php echo zen_image_submit(PF_NOSCRIPT_SUBMIT, PF_NOSCRIPT_SUBMIT_ALT, '', 'pf_go_css_button'); ?>
        </noscript>
    </li>
</ul>
</div>
<?php echo '</form>'; ?>
<!--eof product finder -->

