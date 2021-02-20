<?php 
/*
    Plugin Name: AddFunc Adaptive Content
    Version: 2.0
    Plugin URI: https://wordpress.org/plugins/addfunc-adaptive-content
    Description: Adds functions and shortcodes to empower WordPress users to have better control of when content is served.
    Author: AddFunc 
    Author URI: http://profiles.wordpress.org/addfunc
    License: GPLv2 or later
           ______
       _  |  ___/   _ _ __   ____
     _| |_| |__| | | | '_ \ / __/™
    |_ Add|  _/| |_| | | | | (__
      |_| |_|   \__,_|_| |_|\___\
                    by Joe Rhoney
*/



/*
    I N C L U D E S
    ===============
*/

if(!class_exists('Mobile_Detect')){
  include plugin_basename('/mobile-detect.php');
}
$aFACdetect = new Mobile_Detect();



/*
    S H O R T C O D E S   &   F U N C T I O N S
    ===========================================
*/

# [mobileonly][/mobileonly]
function aFACsc_mobileonly($tats,$content=""){
  global $aFACdetect;
  if($aFACdetect->isMobile() && !$aFACdetect->isTablet()) return do_shortcode($content);
}
add_shortcode('mobileonly', 'aFACsc_mobileonly');
function aFAC_mobileonly(){
  global $aFACdetect;
  if($aFACdetect->isMobile() && !$aFACdetect->isTablet()) return true;
}

# [notmobile][/notmobile]
function aFACsc_notmobile($tats,$content=""){
  global $aFACdetect;
  if(!$aFACdetect->isMobile() || $aFACdetect->isTablet()) return do_shortcode($content);
}
add_shortcode('notmobile','aFACsc_notmobile');
function aFAC_notmobile(){
  global $aFACdetect;
  if(!$aFACdetect->isMobile() || $aFACdetect->isTablet()) return true;
}

# [tabletonly][/tabletonly]
function aFACsc_tabletonly($tats,$content=""){
  global $aFACdetect;
  if($aFACdetect->isTablet()) return do_shortcode($content);
}
add_shortcode('tabletonly', 'aFACsc_tabletonly');
function aFAC_tabletonly(){
  global $aFACdetect;
  if($aFACdetect->isTablet()) return true;
}

# [nottablet][/nottablet]
function aFACsc_nottablet($tats,$content=""){
  global $aFACdetect;
  if(!$aFACdetect->isTablet()) return do_shortcode($content);
}
add_shortcode('nottablet','aFACsc_nottablet');
function aFAC_nottablet(){
  global $aFACdetect;
  if(!$aFACdetect->isTablet()) return true;
}

# [desktoponly][/desktoponly]
function aFACsc_desktoponly($tats,$content=""){
  global $aFACdetect;
  if(!$aFACdetect->isMobile() && !$aFACdetect->isTablet()) return do_shortcode($content);
}
add_shortcode('desktoponly', 'aFACsc_desktoponly');
function aFAC_desktoponly(){
  global $aFACdetect;
  if(!$aFACdetect->isMobile() && !$aFACdetect->isTablet()) return true;
}

# [notdesktop][/notdesktop]
function aFACsc_notdesktop($tats,$content=""){
  global $aFACdetect;
  if($aFACdetect->isMobile() || $aFACdetect->isTablet()) return do_shortcode($content);
}
add_shortcode('notdesktop', 'aFACsc_notdesktop');
function aFAC_notdesktop(){
  global $aFACdetect;
  if($aFACdetect->isMobile() || $aFACdetect->isTablet()) return true;
}

# [iosonly][/iosonly]
function aFACsc_iosonly($tats,$content=""){
  global $aFACdetect;
  if($aFACdetect->isiOS()) return do_shortcode($content);
}
add_shortcode('iosonly', 'aFACsc_iosonly');
function aFAC_iosonly(){
  global $aFACdetect;
  if($aFACdetect->isiOS()) return true;
}

# [iphoneonly][/iphoneonly]
function aFACsc_iphoneonly($tats,$content=""){
  global $aFACdetect;
  if($aFACdetect->isiPhone()) return do_shortcode($content);
}
add_shortcode('iphoneonly', 'aFACsc_iphoneonly');
function aFAC_iphoneonly(){
  global $aFACdetect;
  if($aFACdetect->isiPhone()) return true;
}

# [ipadonly][/ipadonly]
function aFACsc_ipadonly($tats,$content=""){
  global $aFACdetect;
  if($aFACdetect->isiPad()) return do_shortcode($content);
}
add_shortcode('ipadonly', 'aFACsc_ipadonly');
function aFAC_ipadonly(){
  global $aFACdetect;
  if($aFACdetect->isiPad()) return true;
}

# [androidonly][/androidonly]
function aFACsc_androidonly($tats,$content=""){
  global $aFACdetect;
  if($aFACdetect->isAndroidOS()) return do_shortcode($content);
}
add_shortcode('androidonly', 'aFACsc_androidonly');
function aFAC_androidonly(){
  global $aFACdetect;
  if($aFACdetect->isAndroidOS()) return true;
}

# [windowsmobileonly][/windowsmobileonly]
function aFACsc_windowsmobileonly($tats,$content=""){
  global $aFACdetect;
  if($aFACdetect->isWindowsMobileOS()) return do_shortcode($content);
}
add_shortcode('windowsmobileonly', 'aFACsc_windowsmobileonly');
function aFAC_windowsmobileonly(){
  global $aFACdetect;
  if($aFACdetect->isWindowsMobileOS()) return true;
}



/*
    Q U I C K T A G S
    =================
*/
function aFAC_QTags() {
    if (wp_script_is('quicktags')){
?>
 <script type="text/javascript">
    QTags.addButton('aFAC_mob_only','mobileonly','[mobileonly]','[/mobileonly]','','Mobile Only',300);
    QTags.addButton('aFAC_not_mob','notmobile','[notmobile]','[/notmobile]','','Not Mobile',301);
    QTags.addButton('aFAC_tab_only','tabletonly','[tabletonly]','[/tabletonly]','','Tablet Only',302);
    QTags.addButton('aFAC_not_tab','nottablet','[nottablet]','[/nottablet]','','Not Tablet',303);
    QTags.addButton('aFAC_dsk_only','desktoponly','[desktoponly]','[/desktoponly]','','Desktop Only',304);
    QTags.addButton('aFAC_not_dsk','notdesktop','[notdesktop]','[/notdesktop]','','Not Desktop',305);
    QTags.addButton('aFAC_iPh_only','iphoneonly','[iphoneonly]','[/iphoneonly]','','iPhone Only',306);
    QTags.addButton('aFAC_iPd_only','ipadonly','[ipadonly]','[/ipadonly]','','iPad Only',307);
    QTags.addButton('aFAC_iOS_only','iosonly','[iosonly]','[/iosonly]','','iOS Only',308);
    QTags.addButton('aFAC_droid_only','androidonly','[androidonly]','[/androidonly]','','Andriod Only',309);
    QTags.addButton('aFAC_win_mob_only','windowsmobileonly','[windowsmobileonly]','[/windowsmobileonly]','','Windows Mobile Only',310);
 </script>
<?php
    }
}
add_action( 'admin_print_footer_scripts', 'aFAC_QTags' );



/*
    H E L P   T A B
    ===============
*/

function aFACHelpTab(){
    $screen = get_current_screen();
    $screen->add_help_tab(array(
        'id'      => 'aFACHelpTab',
        'title'   => __('Adaptive Content'),
        'content' => '
        <p>'.__('You can use these shortcodes to designate what devices you want specific content to display on:').'</p>
        <ul>
          <li>
            <code>[mobileonly]</code> '.__('Displays only on mobile devices.').'<code>[/mobileonly]</code></li>
          <li>
            <code>[notmobile]</code> '.__('Displays on devices, that are not mobile.').'<code>[/notmobile]</code></li>
          <li>
            <code>[tabletonly]</code> '.__('Displays only on tablets.').'<code>[/tabletonly]</code></li>
          <li>
            <code>[nottablet]</code> '.__('Displays on devices, that are not tablets.').'<code>[/nottablet]</code></li>
          <li>
            <code>[desktoponly]</code> '.__('Displays only on desktop computers.').'<code>[/desktoponly]</code></li>
          <li>
            <code>[notdesktop]</code> '.__('Displays on devices that are not desktops.').'<code>[/notdesktop]</code></li>
          <li>
            <code>[iphoneonly]</code> '.__('Displays only on iPhones.').'<code>[/iphoneonly]</code></li>
          <li>
            <code>[ipadonly]</code> '.__('Displays only on iPads.').'<code>[/ipadonly]</code></li>
          <li>
            <code>[iosonly]</code> '.__('Displays only on devices running iOS.').'<code>[/iosonly]</code></li>
          <li>
            <code>[androidonly]</code> '.__('Displays only on devices running Android.').'<code>[/androidonly]</code></li>
          <li>
            <code>[windowsmobileonly]</code> '.__('Displays only on devices running Windows Mobile.').'<code>[/windowsmobileonly]</code></li>
        </ul>',
   ));
}
add_action('load-post.php', 'aFACHelpTab');