<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><? echo (isset($title)) ? $title : 'TTE'; ?></title>
    <? if(isset($meta['description'])) { ?><meta name="description" content="<?=$meta['description']?>"><? echo "\n"; } ?>
    <? if(isset($meta['noindex'])) { ?><meta name="robots" content="noindex"><? } ?>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? if(isset($meta['canonical'])) { ?><link rel="canonical" href="<?php echo $meta['canonical']; ?>" /><? } ?>
    


    <!--<link href="/sites/all/themes/sbtheme/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="/sites/all/themes/sbtheme/css/font-awesome.min.css" rel="stylesheet">
    <link href="/sites/all/themes/sbtheme/css/blueimp-gallery.min.css" rel="stylesheet">
    <link href="/sites/all/themes/sbtheme/css/bootstrap-image-gallery.min.css" rel="stylesheet">
    <link href="/assets/css/main.css" rel="stylesheet">
    <!--
      THE FOLLOWING FILE IS THE OLD STYLE COMING FROM S&B
      <link href="/sites/all/themes/sbtheme/css/style.css?v=7" rel="stylesheet">
    -->
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
    <script src="/sites/all/themes/sbtheme/js/jquery.js"></script>
    
  </head>
  <body>
    <? if(isset($dataLayer)) { echo $dataLayer; } ?>
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-ML5FSC"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-ML5FSC');</script>
    <!-- End Google Tag Manager -->

    <div id="nav-fixed">
      <div class="checkout_header">
        <div class="pull-left">
          <img src="/assets/img/sb_commercials-logo-small.png" class="logo">
        </div>
        <div class="basket pull-right text-right">
          <a href="#" class="basket-link">
            <div class="basket-count">0</div>
          </a>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>

    <div id="content" class="snap-content"  data-spy="scroll" data-target=".subnav .nav">

      <div class="container">
        <div class="row row-logos">
          <span class="number hidden-xs"></span>

          <div class="col-xs-6">
            <a href="/">
              <img src="/sites/all/themes/sbtheme/img/mercedes-benz-logo.png" id="logo-mercedes">
            </a>
          </div>
          <div class="col-xs-6 text-right">
            <a href="/">
              <img src="/sites/all/themes/sbtheme/img/sb_commercials-logo.png" id="logo-sb">
            </a>
          </div>
        </div>
      </div>

      <div class="navbar navbar-inverse hidden-xs">
        <div class="container">
          <div class="collapse navbar-collapse navbar-right">
              <?/*
            <ul class="nav navbar-nav">
              <li>
                <a href="/">
                  Home
                  <span class="childs"></span>
                </a>
              </li>
              <li>
                <a href="/mercedes-vans/">
                  Vans
                  <span class="childs"></span>
                </a>
              </li>
              <li>
                <a href="/mercedes-trucks/">Trucks</a>
                <span class="childs"></span>
              </li>
              <li>
                <a href="/mercedes/used/">Used</a>
                <span class="childs"></span>
              </li>
              <li>
                <a href="/mercedes-vans/vito/taxi" title="Mercedes-Benz Vito Taxi">Taxi</a>
                <span class="childs"></span>
              </li>
              <li>
                <a href="/mercedes-parts/">Parts</a>
                <span class="childs"></span>
              </li>
              <li<? if($this->uri->segment(1) == 'yourservice') echo ' class="highlight active"'; ?>>
                <a href="/service/">Service</a>
                <span class="childs"></span>
              </li>
              <li>
                <a href="/about-us/careers">Careers</a>
                <span class="childs"></span>
              </li>
              <li>
                <a href="/about-us/">About Us</a>
                <span class="childs"></span>
              </li>
              <li>
                <a href="/contact/">Contact</a>
                <span class="childs"></span>
              </li>
            </ul>
              */?>
          </div><!--/.nav-collapse -->
        </div>
      </div>

