<?php
/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or
 *   'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see bootstrap_preprocess_html()
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup themeable
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces;?>>
<head profile="<?php print $grddl_profile; ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
    <?php if (drupal_is_front_page()) { ?>
    <meta name="description" content="There is no better vehicle to own than a Mercedes-Benz, and to ensure that you get the best deal on your van or truck, be sure to pay a visit to S & B Commercials.">
    <?php } ?>

  <style>
*, ::before, ::after { box-sizing: border-box; }
html { font-family: sans-serif; font-size: 62.5%; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); }
html, body { -webkit-font-smoothing: antialiased; margin: 0px; padding: 0px; width: 100%; font-family: CorporateSRegular, sans-serif; font-size: 16px; color: rgb(240, 240, 240); line-height: 1.3; height: 100% !important; }
body { margin: 0px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.42857; color: rgb(51, 51, 51); background-color: rgb(0, 0, 0); }
a { background: transparent; color: rgb(255, 255, 255); text-decoration: none; outline: 0px; transition-property: color; transition-duration: 200ms; }
.element-invisible { clip: rect(1px 1px 1px 1px); overflow: hidden; height: 1px; position: absolute !important; }
#nav-fixed { position: fixed; top: -70px; opacity: 0; left: 0px; z-index: 9; height: 60px; width: 100%; background-color: rgb(23, 23, 23); }
.subnav { border: 0px; font-family: CorporateSRegular, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1; }
ul, ol { margin-top: 0px; margin-bottom: 10px; }
.nav { padding-left: 0px; margin-bottom: 0px; list-style: none; }
.subnav ul { padding: 3px 0px 10px; height: 30px; width: 100%; display: table; table-layout: fixed; }
.nav > li { position: relative; display: block; }
.subnav ul li { padding: 0px 2px; width: auto; text-align: center; position: static; display: none; }
.subnav ul li.slim, .subnav ul li.slim-only { display: table-cell; }
.nav > li > a { position: relative; display: block; padding: 7px 12px; }
.subnav ul li a, .subnav .nav a { display: block; color: rgb(240, 240, 240); position: relative; padding-top: 7px; height: 30px; line-height: 16px; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: rgb(51, 51, 51); }
.subnav ul li a, .subnav ul li a:active, .subnav ul li a:focus, .subnav ul li a:hover { transition: color 400ms ease; }
.subnav .nav a { padding: 0px; }
.subnav ul li a span.icon-label { padding-left: 10px; display: block; background: url(https://www.sbcommercials.co.uk/sites/all/themes/sbtheme/img/menu.png) 10px 0px no-repeat; }
.snap-drawers { overflow: hidden; position: absolute; top: 0px; right: 0px; bottom: 0px; left: 0px; width: auto; height: auto; }
.snap-drawer-left { overflow: auto; padding-top: 146px; left: 0px; z-index: 1; background: rgb(23, 23, 23); }
.snap-drawer { position: absolute; top: 0px; right: auto; bottom: 0px; left: auto; width: 266px; height: auto; overflow: auto; transition: width 0.3s ease; }
article, aside, details, figcaption, figure, footer, header, hgroup, main, nav, section, summary { display: block; }
.sidenav { list-style: none; padding: 20px 0px; border-right-width: 2px; border-right-style: solid; border-right-color: rgb(0, 173, 239); }
.sidenav > li { margin-bottom: 1px; font-family: CorpoADemRegular, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1; }
.sidenav > li a { display: block; position: relative; color: rgb(240, 240, 240); padding: 11px 20px; transition: color 400ms ease; }
.snap-content { position: absolute; top: 0px; right: 0px; bottom: 0px; left: 0px; width: auto; height: auto; z-index: 2; overflow: auto; transform: translate3d(0px, 0px, 0px); }
#content { padding-top: 31px; background: url(https://www.sbcommercials.co.uk/sites/all/themes/sbtheme/img/bg.jpg) 50% 0% no-repeat scroll rgb(0, 0, 0); overflow: auto; }
.container { padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto; }
.row { margin-right: -15px; margin-left: -15px; }
.row-logos { position: relative; margin-bottom: 10px; }
span.number { font-family: CorpoADemRegular, Helvetica, Arial, sans-serif; color: rgb(240, 240, 240); font-size: 16px; display: block; position: absolute; right: 40px; top: -20px; }
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 { position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; }
.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11 { float: left; }
.col-xs-6 { width: 50%; }
img { border: 0px; vertical-align: middle; }
#logo-mercedes { width: 100%; max-width: 193px; max-height: 51px; }
.text-right { text-align: right; }
#logo-sb { width: 100%; max-width: 225px; max-height: 62px; }
.navbar { position: relative; min-height: 34px; margin-bottom: 20px; border: 1px solid transparent; }
.navbar-inverse { border-color: rgb(8, 8, 8); background-color: transparent; border: 0px; font-size: 16px; line-height: 1; font-family: CorpoADemRegular, Helvetica, Arial, sans-serif; }
.collapse { display: none; }
.navbar-collapse { max-height: 340px; padding-right: 15px; padding-left: 15px; overflow-x: visible; border-top-width: 1px; border-top-style: solid; border-top-color: transparent; box-shadow: rgba(255, 255, 255, 0.0980392) 0px 1px 0px inset; }
.container > .navbar-header, .container > .navbar-collapse { margin-right: -15px; margin-left: -15px; }
.navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form { border-color: rgb(16, 16, 16); }
.navbar-nav { margin: 7.5px -15px; }
.navbar-inverse li.active, .navbar-inverse li.active-trail { height: 40px; background: url(https://www.sbcommercials.co.uk/sites/all/themes/sbtheme/img/down-arrow.png) 50% 100% no-repeat; }
.navbar-nav > li > a { padding-top: 10px; padding-bottom: 10px; line-height: 20px; }
.navbar-inverse .navbar-nav > li > a { color: rgb(240, 240, 240); }
.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus { color: rgb(255, 255, 255); background-color: rgb(8, 8, 8); }
.navbar-inverse .navbar-nav > .highlight > a, .navbar-inverse .navbar-nav > .highlight > a:hover, .navbar-inverse .navbar-nav > .highlight > a:focus, .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus, .navbar-inverse .navbar-nav > .active-trail > a, .navbar-inverse .navbar-nav > .active-trail > a:hover, .navbar-inverse .navbar-nav > .active-trail > a:focus { color: rgb(0, 173, 239); background-color: transparent; }
#content .subnav { animation: showMenu 1s; position: relative; }
.main-container { padding-bottom: 30px; }
.carousel { position: relative; margin-bottom: 10px; }
.carousel-inner { position: relative; width: 100%; overflow: hidden; margin-bottom: 7px; }
.carousel-inner > .item { position: relative; display: none; transition: left 0.6s ease-in-out; }
.carousel-inner > .item > img, .carousel-inner > .item > a > img { display: block; height: auto; max-width: 100%; line-height: 1; }
.carousel-inner > .active, .carousel-inner > .next, .carousel-inner > .prev { display: block; }
.carousel-inner > .active { left: 0px; }
.carousel-indicators { position: absolute; bottom: 10px; left: 50%; z-index: 15; width: 60%; padding-left: 0px; margin-left: -30%; text-align: center; list-style: none; }
#carousel-bootstrap .carousel-indicators { position: static; width: 100%; font-size: 12px; left: 0px; margin: 0px; }
.carousel-indicators li { display: inline-block; width: 10px; height: 10px; margin: 1px; text-indent: -999px; cursor: pointer; border: 1px solid rgb(255, 255, 255); border-radius: 10px; background-color: rgba(0, 0, 0, 0); }
#carousel-bootstrap .carousel-indicators li { display: block; width: 100%; height: 20px; margin: 8px 0px 0px; text-align: left; text-indent: 0px; cursor: pointer; border: 0px; color: rgb(75, 74, 74); transition-property: color; transition-duration: 200ms; }
#carousel-bootstrap .carousel-indicators li span { width: 100%; height: 2px; margin-top: 4px; display: block; position: absolute; background: rgb(82, 82, 82); }
#carousel-bootstrap .carousel-indicators li span em { display: block; position: absolute; width: 0px; float: right; height: 2px; background: rgb(0, 173, 239); }
.carousel-indicators .active { width: 12px; height: 12px; margin: 0px; background-color: rgb(255, 255, 255); }
#carousel-bootstrap .carousel-indicators li.active, #carousel-bootstrap .carousel-indicators li:hover { color: rgb(0, 173, 239); }
#carousel-bootstrap .carousel-indicators li.active { width: 200px; height: 20px; margin: 8px 0px 0px; background-color: transparent; }
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; }
h1, h2, h3 { margin-top: 20px; margin-bottom: 10px; }
h2, .h2 { font-size: 30px; }
h1, h2, h3, h4, h5, h6 { font-family: CorporateACondensedRegular, sans-serif; }
#node-539 > h2, body.front #block-sb-vehicles-used h2.block-title { display: none; }
.col-xs-12 { width: 100%; }
.wysiwyg-block { margin-bottom: 10px; }
.carrot { position: relative; }
.carrot-inner { position: relative; overflow: hidden; width: 100%; }
.carrot-inner > .item { display: none; position: relative; transition: left 0.6s ease-in-out; }
.carrot-inner > .active, .carrot-inner > .next, .carrot-inner > .prev { display: block; }
.carrot-inner > .active { left: 0px; }
.vehicle-thumb { display: block; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(51, 51, 51); padding: 0px 0px 20px; margin-bottom: 20px; }
.used-item > a { display: block; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(51, 51, 51); padding-bottom: 10px; margin-bottom: 20px; }
.img-responsive { display: block; height: auto; max-width: 100%; }
small { font-size: 80%; }
small, .small { font-size: 85%; }
.used-item small { display: block; width: 100%; color: rgb(142, 142, 142); font-size: 11px; line-height: 28px; text-transform: uppercase; }
h3, .h3 { font-size: 24px; }
.used-item h3 { font-family: CorporateACondensedRegular; font-size: 20px; font-weight: normal; color: rgb(230, 230, 230); line-height: 20px; margin: 0px; }
.used-item .price { display: block; line-height: 22px; font-size: 14px; }
.used-item .desc { display: block; padding-top: 15px; color: rgb(240, 240, 240); line-height: 22px; font-size: 14px; }
.carrot-control { position: absolute; top: 0px; left: 0px; bottom: 0px; width: 15%; opacity: 0.5; font-size: 20px; color: rgb(255, 255, 255); text-align: center; text-shadow: rgba(0, 0, 0, 0.6) 0px 1px 2px; }
.carousel-control, .carrot-control { left: -70px; text-align: left; color: rgb(240, 240, 240); width: 50px; }
.carrot-control.left { background-image: linear-gradient(to right, rgba(0, 0, 0, 0.498039) 0px, rgba(0, 0, 0, 0) 100%); background-repeat: repeat-x; }
.carousel-control.left, .carrot-control.left, .carrot-control.right, .carousel-control.right { background-image: none; }
.carrot-control .chevron-right, .carrot-control .chevron-left, .carousel-control .chevron-left, .carousel-control .chevron-right { position: absolute; top: 40%; display: inline-block; width: 50px; color: rgb(255, 255, 255); height: 90px; z-index: 999; text-indent: -999px; overflow: hidden; background: url(https://www.sbcommercials.co.uk/sites/all/themes/sbtheme/img/slider-arrows-new.png) 0px 0px no-repeat; }
.carrot-control .chevron-left, .carousel-control .chevron-left { background-position: 100% 0px; }
.carrot-control.right { left: auto; right: 0px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0) 0px, rgba(0, 0, 0, 0.498039) 100%); background-repeat: repeat-x; }
.carrot-control.right, .carousel-control.right { right: -70px; text-align: right; }
.carrot-control .chevron-right, .carousel-control .chevron-right { right: 0px; }
.fade { opacity: 0; transition: opacity 0.15s linear; }
.modal { position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 1040; display: none; overflow-x: auto; overflow-y: scroll; color: rgb(51, 51, 51); }
.modal-dialog { position: relative; z-index: 1050; width: auto; padding: 10px; margin-right: auto; margin-left: auto; }
.modal.fade .modal-dialog { transform: translate(0px, -25%); transition: transform 0.3s ease-out; }
.modal-content { position: relative; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 0px; outline: 0px; box-shadow: rgba(0, 0, 0, 0.498039) 0px 3px 9px; background-color: rgb(255, 255, 255); background-clip: padding-box; }
.modal-header { min-height: 16.4286px; padding: 15px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(229, 229, 229); }
button, input, select, textarea { margin: 0px; font-family: inherit; font-size: 100%; }
button, input { line-height: normal; }
button, select { text-transform: none; }
button, html input[type="button"], input[type="reset"], input[type="submit"] { cursor: pointer; -webkit-appearance: button; }
input, button, select, textarea { font-family: inherit; font-size: inherit; line-height: inherit; }
.close { float: right; font-size: 21px; font-weight: bold; line-height: 1; color: rgb(0, 0, 0); text-shadow: rgb(255, 255, 255) 0px 1px 0px; opacity: 0.2; }
button.close { padding: 0px; cursor: pointer; border: 0px; -webkit-appearance: none; background: transparent; }
.modal-header .close { margin-top: -2px; }
h4, h5, h6 { margin-top: 10px; margin-bottom: 10px; }
h4, .h4 { font-size: 18px; }
.modal-title { margin: 0px; line-height: 1.42857; }
.modal-header h4 { font-size: 22px; }
.modal-body { position: relative; padding: 20px; }
p { margin: 0px 0px 10px; }
.modal-footer { padding: 19px 20px 20px; margin-top: 15px; text-align: right; border-top-width: 1px; border-top-style: solid; border-top-color: rgb(229, 229, 229); }
.btn { display: inline-block; padding: 6px 12px; margin-bottom: 0px; font-size: 14px; font-weight: normal; line-height: 1.42857; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; border: 0px; border-radius: 4px; -webkit-user-select: none; background-image: none; box-shadow: rgba(255, 255, 255, 0) 0px 1px 0px inset, rgba(0, 0, 0, 0.2) 0px 1px 2px 0px; font-family: CorporateSRegular, Arial, sans-serif; background-repeat: no-repeat; border-color: rgba(0, 0, 0, 0.14902) rgba(0, 0, 0, 0.14902) rgba(0, 0, 0, 0.247059); }
.btn-default { color: rgb(51, 51, 51); border-color: rgb(204, 204, 204); background-color: rgb(255, 255, 255); }
.btn, .btn-lg { border-radius: 2px; }
.form-group { margin-bottom: 15px; }
label { display: inline-block; margin-bottom: 5px; font-weight: bold; }
.form-required { color: rgb(0, 173, 239); }
.form-control { display: block; width: 100%; height: 34px; padding: 6px 12px; font-size: 14px; line-height: 1.42857; color: rgb(85, 85, 85); vertical-align: middle; border: 1px solid rgb(204, 204, 204); border-radius: 4px; box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px inset; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; background-image: none; background-color: rgb(255, 255, 255); }
.form-item-honeypot { display: none; }
textarea { overflow: auto; vertical-align: top; }
textarea.form-control { height: auto; }
.form-textarea-wrapper textarea { display: block; margin: 0px; width: 100%; box-sizing: border-box; }
.resizable-textarea .grippie { border-width: 0px 1px 1px; border-style: solid; border-color: rgb(221, 221, 221); cursor: s-resize; height: 9px; overflow: hidden; background: url(https://www.sbcommercials.co.uk/misc/grippie.png) 50% 2px no-repeat rgb(238, 238, 238); }
.btn-primary { color: rgb(255, 255, 255); border-color: rgba(0, 0, 0, 0.0980392) rgba(0, 0, 0, 0.0980392) rgba(0, 0, 0, 0.247059); background-color: rgb(46, 144, 187); text-shadow: rgba(0, 0, 0, 0.247059) 1px 1px; background-image: linear-gradient(rgb(67, 183, 234), rgb(13, 81, 110)); background-repeat: repeat-x; }
.snap-drawers{overflow:hidden;position:absolute;top:0;right:0;bottom:0;left:0;width:auto;height:auto}.snap-drawer-left{overflow:auto}.snap-content{right:0;left:0;width:auto;z-index:2;-webkit-overflow-scrolling:touch;-webkit-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}.snap-content,.snap-drawer{position:absolute;top:0;bottom:0;height:auto;overflow:auto}.snap-drawer{right:auto;left:auto;width:266px;-webkit-overflow-scrolling:touch;-webkit-transition:width .3s ease;-moz-transition:width .3s ease;-ms-transition:width .3s ease;-o-transition:width .3s ease;transition:width .3s ease}.snap-drawer-left{padding-top:146px;left:0;z-index:1;background:#171717}.snap-drawer-right{right:0;z-index:1}.snapjs-left .snap-drawer-right,.snapjs-right .snap-drawer-left{display:none}.snapjs-expand-left .snap-drawer-left,.snapjs-expand-right .snap-drawer-right{width:100%}
</style>

</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <!-- Google Tag Manager -->
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-ML5FSC"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-ML5FSC');</script>
  <!-- End Google Tag Manager -->
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>

  <link type="text/css" rel="stylesheet" href="/sites/all/themes/sbtheme/css/bootstrap.min.css" media="all" />
  <?php print $styles; ?>
  <?php print $page_bottom; ?>
  <?php print $scripts; ?>
  <script src="/sites/all/themes/sbtheme/js/bootstrap.min.js"></script>
  <script src="/sites/all/themes/sbtheme/js/application.js"></script>
  <script src="/sites/all/themes/sbtheme/js/livechat.js" type="text/javascript" charset="utf-8"></script>
  <!--[if lt IE 9]>
    <script src="/sites/all/themes/sbtheme/js/html5shiv.js"></script>
    <script src="/sites/all/themes/sbtheme/js/respond.min.js"></script>
    <style>
      .subnav ul li.highlight a,
      .subnav ul li a:hover,
      .subnav ul li.active a {
          border-bottom: 2px solid #00ADEF;
      }
    </style>
  <![endif]-->
</body>
</html>
