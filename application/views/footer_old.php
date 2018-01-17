      <div class="bg-grey">
        <div class="container">

          <? $this->view('sitemap') ?>

        </div>
      </div>
      <div class="container">
        <div id="footer" class="links-white">
          <div class="row">
            <div class="col-sm-6">
              <a href="#" class="fixed-width" data-toggle="modal" data-target="#modalCallback" data-section="footer"><i class="fa fa-phone"></i> Call back</a>
              <a href="#" class="fixed-width" data-toggle="modal" data-target="#modalTestdrive" data-section="footer"><i class="fa fa-road"></i> Test drive</a>
              <a href="#" class="fixed-width" data-toggle="modal" data-target="#modalEmail" data-section="footer"><i class="fa fa-envelope"></i> Email</a>
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
                <span class="copyright">&#169; S&amp;B Commercials Plc <?=date('Y')?></span>
              </div>
            </div><!--/.col-->
          </div><!--/.row-->
        </div><!--/#footer-->
      </div><!--/.container-->


    </div><!-- /.snap-content-->

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
            <form action="/form/footer/callback" method="post" id="sb-contact-call-back-form" accept-charset="UTF-8">
              <div>
                <input type="hidden" name="request_path" value="<?=uri_string()?>" />
                <input type="hidden" name="request_page_section" value="footer" />
                <div class="form-type-textfield form-item-name form-item form-group">
                  <label for="edit-name">Name <span class="form-required" title="This field is required.">*</span></label>
                  <input class="form-control form-text required" type="text" id="edit-name" name="name" value="" size="60" maxlength="128" />
                </div>
                <div class="form-type-textfield form-item-number form-item form-group">
                  <label for="edit-number">Number <span class="form-required" title="This field is required.">*</span></label>
                  <input class="form-control form-text required" type="text" id="edit-number" name="number" value="" size="60" maxlength="128" />
                </div>
                <div class="form-type-textfield form-item-email form-item form-group">
                  <label for="edit-email">Email </label>
                  <input class="form-control form-text" type="text" id="edit-email" name="email" value="" size="60" maxlength="128" />
                </div>
                <div class="form-type-textarea form-item-honeypot form-item form-group">
                  <label for="edit-honeypot">Honeypot </label>
                  <div class="form-textarea-wrapper resizable"><textarea class="form-control form-textarea" id="edit-honeypot" name="honeypot" cols="60" rows="5"></textarea></div>
                </div>
                <div class="form-type-textarea form-item-message form-item form-group">
                  <label for="edit-message">Message </label>
                  <div class="form-textarea-wrapper resizable"><textarea class="form-control form-textarea" id="edit-message" name="message" cols="60" rows="5"></textarea></div>
                </div>
                <button class="btn btn-primary form-submit" id="edit-submit" name="op" value="Submit" type="submit">Submit</button>
              </div>
            </form>
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
            <form action="/form/footer/testdrive" method="post" id="sb-contact-test-drive-form" accept-charset="UTF-8">
              <div>
                <input type="hidden" name="request_path" value="<?=uri_string()?>" />
                <input type="hidden" name="request_page_section" value="footer" />
                <div class="form-type-textfield form-item-name form-item form-group">
                  <label for="edit-name--2">Name <span class="form-required" title="This field is required.">*</span></label>
                  <input class="form-control form-text required" type="text" id="edit-name--2" name="name" value="" size="60" maxlength="128" />
                </div>
                <div class="form-type-textfield form-item-number form-item form-group">
                  <label for="edit-number--2">Number <span class="form-required" title="This field is required.">*</span></label>
                  <input class="form-control form-text required" type="text" id="edit-number--2" name="number" value="" size="60" maxlength="128" />
                </div>
                <div class="form-type-textfield form-item-email form-item form-group">
                  <label for="edit-email--2">Email </label>
                  <input class="form-control form-text" type="text" id="edit-email--2" name="email" value="" size="60" maxlength="128" />
                </div>
                <div class="form-type-select form-item-vehicle form-item form-group">
                  <label for="edit-vehicle">Vehicle <span class="form-required" title="This field is required.">*</span></label>
                  <select class="form-control form-select required" id="edit-vehicle" name="vehicle"><option value="" selected="selected">- Select -</option><option value="citan">Citan</option><option value="vito">Vito</option><option value="sprinter">Sprinter</option><option value="canter">Canter</option><option value="atego">Atego</option><option value="antos">Antos</option><option value="actros">Actros</option><option value="arocs">Arocs</option><option value="econic">Econic</option></select>
                </div>
                <div class="form-type-textarea form-item-honeypot form-item form-group">
                  <label for="edit-honeypot--2">Honeypot </label>
                  <div class="form-textarea-wrapper resizable"><textarea class="form-control form-textarea" id="edit-honeypot--2" name="honeypot" cols="60" rows="5"></textarea></div>
                </div>
                <div class="form-type-textarea form-item-message form-item form-group">
                  <label for="edit-message--2">Message </label>
                  <div class="form-textarea-wrapper resizable"><textarea class="form-control form-textarea" id="edit-message--2" name="message" cols="60" rows="5"></textarea></div>
                </div>
                <button class="btn btn-primary form-submit" id="edit-submit--2" name="op" value="Submit" type="submit">Submit</button>
              </div>
            </form>
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
            <form action="/form/footer/email" method="post" id="sb-contact-email-form" accept-charset="UTF-8">
              <div>
                <input type="hidden" name="request_path" value="<?=uri_string()?>" />
                <input type="hidden" name="request_page_section" value="footer" />
                <div class="form-type-textfield form-item-name form-item form-group">
                  <label for="edit-name--3">Name <span class="form-required" title="This field is required.">*</span></label>
                  <input class="form-control form-text required" type="text" id="edit-name--3" name="name" value="" size="60" maxlength="128" />
                </div>
                <div class="form-type-textfield form-item-email form-item form-group">
                  <label for="edit-email--3">Email <span class="form-required" title="This field is required.">*</span></label>
                  <input class="form-control form-text required" type="text" id="edit-email--3" name="email" value="" size="60" maxlength="128" />
                </div>
                <div class="form-type-textarea form-item-honeypot form-item form-group">
                  <label for="edit-honeypot--3">Honeypot </label>
                  <div class="form-textarea-wrapper resizable"><textarea class="form-control form-textarea" id="edit-honeypot--3" name="honeypot" cols="60" rows="5"></textarea></div>
                </div>
                <div class="form-type-textarea form-item-message form-item form-group">
                  <label for="edit-message--3">Message </label>
                  <div class="form-textarea-wrapper resizable"><textarea class="form-control form-textarea" id="edit-message--3" name="message" cols="60" rows="5"></textarea></div>
                </div>
                <button class="btn btn-primary form-submit" id="edit-submit--3" name="op" value="Submit" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="/sites/all/themes/sbtheme/js/bootstrap.min.js"></script>
    <script src="/sites/all/themes/sbtheme/js/snap.min.js"></script>
    <script src="/sites/all/themes/sbtheme/js/jquery.blueimp-gallery.js"></script>
    <script src="/sites/all/themes/sbtheme/js/application.js"></script>
<?/*<script src="/sites/all/themes/sbtheme/js/bootstrap-image-gallery.min.js"></script>*/?>
    <script type="text/javascript" src="/sites/all/themes/sbtheme/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="/sites/all/themes/sbtheme/js/jquery-ui-1.9.2.custom.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/assets/js/jquery.scrollTo.min.js" type="text/javascript" charset="utf-8"></script>


    <? if($this->uri->segment(1) == 'yourservice') { ?>
      <script src="/sites/all/themes/sbtheme/js/service.js"></script>
        var borderless = $(this).is(':checked');
        $('#blueimp-gallery').data('useBootstrapModal', !borderless);
        $('#blueimp-gallery').toggleClass('blueimp-gallery-controls', borderless);
      <? if($this->uri->segment(2) == 'booking') { ?>
        <script type="text/javascript" src="/sites/all/themes/sbtheme/js/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="/sites/all/themes/sbtheme/js/jquery-ui-1.8.23.custom.min.js"></script>
        <link type="text/css" href="/sites/all/themes/sbtheme/css/smoothness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
      <? } ?>
    <? } ?>

    <? if(isset($inline_modal)) { ?>
      <?=$inline_modal?>
    <? } ?>

    <? if(isset($inline_javascript)) { ?>
      <script>
        <?=$inline_javascript?>
      </script>
    <? } ?>

    <!-- Start of LiveChat (www.livechatinc.com) code -->
<script type="text/javascript">
window.__lc = window.__lc || {};
window.__lc.license = 3276202;
(function() {
  var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
  lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
})();
</script>
<!-- End of LiveChat code -->
  </body>
</html>
