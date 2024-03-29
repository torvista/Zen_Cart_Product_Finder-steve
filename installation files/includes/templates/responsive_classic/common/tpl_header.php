<?php
/**
 * Common Template - tpl_header.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_header.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_header = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2019 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: lat9 2019 Mar 03 Modified in v1.5.6b $
 */
?>

<?php
  // Display all header alerts via messageStack:
  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }
  if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
    echo zen_output_string_protected(urldecode($_GET['error_message']));
  }
  if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
   echo zen_output_string_protected($_GET['info_message']);
}
?>


<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
?>

<div id="headerWrapper">

<!--bof navigation display-->
<div id="navMainWrapper" class="group onerow-fluid">
<?php 
 if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) {
echo '<div class="header Fixed"><a href="#menu" title="Menu"><i class="fa fa-bars"></i></a></div>';
 } else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' ){
echo '<div class="header Fixed"><a href="#menu" title="Menu"><i class="fa fa-bars"></i></a></div>';
} else { 
//
}
?>

<?php if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) { ?>
  
<div id="navMain">
  <ul>
    <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><i class="fa fa-home" title="Home"></i></a></li>
    <li><a href="#top"><i class="fa fa-arrow-circle-up" title="Back to Top"></i></a></li>
<?php
    if (zen_is_logged_in() && !zen_in_guest_checkout()) {
?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><i class="fa fa-sign-out" title="Log Off"></i></a></li>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><i class="fa fa-user" title="My Account"></i></a></li>
<?php } else { ?>
    <li class="last"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><i class="fa fa-user" title="My Account"></i></a></li>
<?php } ?>
<?php
      } else {
        if (STORE_STATUS == '0') {
?>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><i class="fa fa-sign-in" title="Log In"></i></a></li>
<?php } else { ?>
    <li class="last"><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><i class="fa fa-sign-in" title="Log In"></i></a></li>
<?php } ?>
<?php 
  } 
} 
?>

<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>"><i class="fa fa-shopping-cart" title="Shopping Cart"></i></a></li>
    <li class="last"><a class="blue" href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><i class="fa fa-check-square" title="Checkout"></i></a></li>
<?php }?>
  </ul>
<div id="navMainSearch" class="forward">
  <?php require(DIR_WS_MODULES . zen_get_module_sidebox_directory('search_header.php')); ?>
</div>
</div>
</div>

<!--eof navigation display-->

<?php  } else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' ){ ?> 

<div id="navMain">
    <ul>
<li class="hide"><a href="#top"><i class="fa fa-arrow-circle-up" title="Back to Top"></i></a></li>
    <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a></li>
<?php
        if (zen_is_logged_in() && !zen_in_guest_checkout()) {
?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGOFF; ?></a></li>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
<li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
	    <?php } else { ?>
<li class="last"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
      
      <?php } ?>
<?php
      } else {
        if (STORE_STATUS == '0') {
?>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></li>
	    <?php } else { ?>
    <li class="last"><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></li>

	    <?php } ?>
<?php } } ?>

<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>"><?php echo HEADER_TITLE_CART_CONTENTS; ?></a></li>
    <li class="last"><a class="blue" href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><?php echo HEADER_TITLE_CHECKOUT; ?></a></li>
<?php }?>
</ul>
<div id="navMainSearch" class="forward">
   <?php require(DIR_WS_MODULES . zen_get_module_sidebox_directory('search_header.php')); ?>
</div>
</div>
</div>
<!--eof navigation display-->

<?php  } else { ?>
<div id="navMain">
  <ul class="back">
    <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a></li>
<?php
    if (zen_is_logged_in() && !zen_in_guest_checkout()) {
?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGOFF; ?></a></li>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
<?php } else { ?>
    <li class="last"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
<?php } ?>
<?php
      } else {
        if (STORE_STATUS == '0') {
?>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></li>
	    <?php } else { ?>
    <li class="last"><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></li>
<?php } ?>
<?php
  }
 }
?>

<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>"><?php echo HEADER_TITLE_CART_CONTENTS; ?></a></li>
    <li class="last"><a class="blue" href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><?php echo HEADER_TITLE_CHECKOUT; ?></a></li>
<?php }?>
  </ul>
<div id="navMainSearch" class="forward">
     <?php require(DIR_WS_MODULES . zen_get_module_sidebox_directory('search_header.php')); ?>
</div>
</div>
</div>
<!--eof navigation display-->

<?php  } ?>

<!--bof branding display-->
<div id="logoWrapper" class="group onerow-fluid">
    <div id="logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT, HEADER_LOGO_WIDTH, HEADER_LOGO_HEIGHT) . '</a>'; ?>
<?php if (HEADER_SALES_TEXT != '' || (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2))) { ?>
    <div id="taglineWrapper">
<?php
  if (HEADER_SALES_TEXT != '') {
?>
      <div id="tagline"><?php echo HEADER_SALES_TEXT;?></div>
<?php
  }
?>
<?php
  if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) {
    if ($banner->RecordCount() > 0) {
?>
  <div id="bannerTwo" class="banners"><?php echo zen_display_banner('static', $banner);?></div>
<?php
    }
  }
?>
  </div>
<?php } // no HEADER_SALES_TEXT or SHOW_BANNERS_GROUP_SET2 ?>
  </div>
</div>

<!--eof branding display-->
<!--eof header logo and navigation display-->

<?php if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) { ?>
  <div id="navMainSearch1" class="forward">
     <?php require(DIR_WS_MODULES . zen_get_module_sidebox_directory('search_header.php')); ?>
  </div>
<?php  } else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' ) { ?>
  <div id="navMainSearch1" class="forward">
     <?php require(DIR_WS_MODULES . zen_get_module_sidebox_directory('search_header.php')); ?>
  </div>
<?php  } else if ( $_SESSION['layoutType'] == 'full' ) {
  } else {
//
  }
?>

<!--bof optional categories tabs navigation display-->
<?php require($template->get_template_dir('tpl_modules_categories_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_categories_tabs.php'); ?>
<!--eof optional categories tabs navigation display-->

<!--bof header ezpage links-->
<?php if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
<?php   require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
<?php } ?>
<!--eof header ezpage links-->
</div>
<?php
//BOF Product Finder
if ( defined('PRODUCT_FINDER_TEMPLATE_ENABLE') && (PRODUCT_FINDER_TEMPLATE_ENABLE == 'true' && PRODUCT_FINDER_PARENT_ID != '') ) {
    include(DIR_WS_MODULES . zen_get_module_directory('product_finder.php'));
    }
//EOF Product Finder
?>
<?php } ?>
