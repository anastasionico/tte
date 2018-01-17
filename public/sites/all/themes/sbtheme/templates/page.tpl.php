<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['topbar_second']: Items for the top navigation bar (where it says more).
 * - $page['sidebar_more']: Items for the hidden left sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<div id="nav-fixed">
</div>
<div class="snap-drawers">
  <div class="snap-drawer snap-drawer-left">
    <div>
      <?php print render($page['sidebar_more']); ?>
    </div>
  </div>
</div>

<div id="content" class="snap-content"  data-spy="scroll" data-target=".subnav .nav">

  <div class="container">
    <div class="row row-logos">
      <span class="number hidden-xs">Welham Green: 01707 261111 / Thurrock: 01708 892500 / Stansted: 01279 712200</span>
      <div class="col-xs-6">
        <a href="/">
          <img src="<?php print $path; ?>/img/mercedes-benz-logo.png" id="logo-mercedes">
        </a>
      </div>
      <div class="col-xs-6 text-right">
        <a href="/">
          <img src="<?php print $path; ?>/img/sb_commercials-logo.png" id="logo-sb">
        </a>
      </div>
    </div>
  </div>

  <div class="navbar navbar-inverse hidden-xs">
    <div class="container">
      <div class="collapse navbar-collapse navbar-right">
        <?php if (!empty($primary_nav)): ?>
          <?php print render($primary_nav); ?>
        <?php endif; ?>
        <?php if (!empty($secondary_nav)): ?>
          <?php print render($secondary_nav); ?>
        <?php endif; ?>
        <?php if (!empty($page['navigation'])): ?>
          <?php print render($page['navigation']); ?>
        <?php endif; ?>
      </div><!--/.nav-collapse -->
      <?/*
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      */?>
    </div>
  </div>

  <div class="container">
    <div class="subnav">
      <?php print render($page['topbar_second']); ?>
    </div>
  </div>

  <div class="main-container container">

    <header role="banner" id="page-header">
      <?php if (!empty($site_slogan)): ?>
        <p class="lead"><?php print $site_slogan; ?></p>
      <?php endif; ?>

      <?php print render($page['header']); ?>
    </header> <!-- /#page-header -->

    <div class="row">

      <section<?php print $content_column_class; ?>>
        <?php if (!empty($page['highlighted'])): ?>
          <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
        <?php endif; ?>
        <?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
        <a id="main-content"></a>
        <?php print render($title_prefix); ?>
        <?php if (!empty($title)): ?>
          <h1 class="page-header"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php print $messages; ?>
        <?php if (!empty($tabs)): ?>
          <?php print render($tabs); ?>
        <?php endif; ?>
        <?php if (!empty($page['help'])): ?>
          <?php print render($page['help']); ?>
        <?php endif; ?>
        <?php if (!empty($action_links)): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print render($page['content']); ?>
      </section>

    </div>
  </div>

  <div class="bg-grey">
    <div class="container">
      <div id="sitemap" class="box-padded">
        <?php print render($page['footer']); ?>
      </div>
    </div>
  </div>

  <div class="container">
    <div id="footer" class="links-white">
      <div class="row">
        <div class="col-sm-6">
          <a href="#" class="fixed-width" data-toggle="modal" data-target="#modalCallback" data-section="footer"><i class="fa fa-phone"></i> Call back</a>
          <a href="#" class="fixed-width" data-toggle="modal" data-target="#modalTestdrive" data-section="footer"><i class="fa fa-road"></i> Test drive</a>
          <a href="#" class="fixed-width" data-toggle="modal" data-target="#modalEmail" data-section="footer"><i class="fa fa-envelope"></i> Email</a>
          <?/*<a href="#" class="fixed-width" data-toggle="modal" data-target="#modalBrochure" data-section="footer"><i class="fa fa-file-text"></i> Brochure</a>*/?>
          <a href="/about_us/brochures" class="fixed-width"><i class="fa fa-file-text"></i> Brochure</a>
        </div>
        <div class="col-sm-6">
          <div class="right">
            <div id="socialWrapper">
              <div id="socialIcons">
                <div class="socialGroups" id="si-share">
                  <a id="shareIcon"></a>
                  <div class="socialIconWindow" id="socialShareWindow">
                    <a href="https://www.facebook.com/pages/S-and-B-Commercials-Mercedes-Benz/167366122080" target="_top" id="facebook"></a>
                    <a href="https://twitter.com/sandb_mercedes" target="_top" id="twitter"></a>
                    <a href="https://www.youtube.com/user/SandBCommercials" target="_top" id="youtube"></a>
                    <a href="https://plus.google.com/+SbcommercialsCoUkWelhamGreen/posts" target="_top" id="googleplus"></a>           
                  </div>
                </div>
                <div class="socialGroups" id="si-legal">
                  <a href="#" data-toggle="modal" data-target="#modalLegal"><i class="fa fa-gavel fa-lg"></i></a>
                </div>
              </div>
            </div>
            <span class="copyright">© S&amp;B Commercials Plc <?=date("Y")?></span>
          </div>
        </div><!--/.col-->
      </div><!--/.row-->
    </div><!--/#footer-->
  </div>

</div><!--/.snap-content-->

<div class="modal fade" id="modalLegal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Cookie Policy</h4>
      </div>
      <div class="modal-body">
        <p>S and B Commercials Plc uses cookies to record the preferences of visitors, to enable us to optimize the design of our web site. Cookies are small files which are stored on your hard drive. They ease navigation, and increase the user-friendliness of a web site. Cookies also help us to identify the most popular sections of our web site. This enables us to provide content that is more accurately suited to your needs, and in so doing improve our service. Cookies can be used to determine whether there has been any contact between us and your computer in the past. Only the cookie on your computer is identified. Personal details can be saved in cookies, provided that you have consented to this, for example, in order to facilitate secure online access so that you not need to enter your user ID and password again.</p>
        <p>Most browsers automatically accept cookies. You can prevent cookies from being stored on your hard drive by setting your browser to not accept cookies. The exact instructions for this can be found in the manual for your browser. You can delete cookies already on your hard drive at any time. If you choose not to accept cookies, you can still visit our website, however this may result in a reduced availability of the services provided by our web site.</p>
        <p>Authorised and regulated by the Financial Conduct Authority.</p>
        <p>Registered in England 1635078.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalCallback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Call Back</h4>
      </div>
      <div class="modal-body">
        <?php print drupal_render(drupal_get_form('sb_contact_call_back_form')); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalTestdrive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Test Drive</h4>
      </div>
      <div class="modal-body">
        <?php print drupal_render(drupal_get_form('sb_contact_test_drive_form')); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Email</h4>
      </div>
      <div class="modal-body">
        <?php print drupal_render(drupal_get_form('sb_contact_email_form')); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalBrochure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Brochure</h4>
      </div>
      <div class="modal-body">
        <?php print drupal_render(drupal_get_form('sb_contact_brochure_form')); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
