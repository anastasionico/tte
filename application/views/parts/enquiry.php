<div class="container main-container">
  <div class="row">
    <div class="col-xs-12">
      <? if($this->session->flashdata('alert')) { $alert = $this->session->flashdata('alert'); ?>
      <div class="alert alert-<?=$alert['type']?>">
        <?=$alert['message']?>
      </div>
      <? } ?>
      <div class="contact-stage contact-stage-1 contact-stage-active">
        <div class="contact-stage-header">
          <div class="contact-stage-indicator">1</div>
          <div class="contact-stage-header-text">Contact Request</div>
        </div>
        <form class="form-inline" action="/parts/" method="post" id="sb-contact-form" accept-charset="UTF-8">
          <div>
            <div class="form-type-radios form-item-request-type form-item form-group">
              <div id="edit-request-type" class="form-radios" title="Request Type">
                <div class="form-type-radio form-item-request-type form-item radio">
                  <input type="radio" id="edit-request-type-call-back" name="request_type" value="call_back" class="form-radio" />
                  <label for="edit-request-type-call-back">Call Back </label>
                </div>
                <div class="form-type-radio form-item-request-type form-item radio">
                  <input type="radio" id="edit-request-type-email" name="request_type" value="email" class="form-radio" /> 
                  <label for="edit-request-type-email">Email </label>
                </div>
              </div>
            </div>
            <input type="hidden" name="form_build_id" value="form-Pblkp6BJQYsvKTXqj9u-uWFySOxRng9tSpyDPvI_cW4" />
            <input type="hidden" name="form_id" value="sb_contact_form" />
          </div>
        </form>
      </div>
      <div class="contact-stage contact-stage-2">
        <div class="contact-stage-header">
          <div class="contact-stage-indicator">2</div>
          <div class="contact-stage-header-text">Your Details</div>
        </div>
        <form class="display-none" action="/form/parts/call_back" method="post" id="sb-contact-call-back-form" accept-charset="UTF-8">
          <input type="hidden" name="request_path" value="<?=uri_string()?>" />
          <div>
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
            <button class="btn btn-details form-submit" id="edit-submit" name="op" value="Submit" type="submit">Submit</button>
            <input type="hidden" name="form_build_id" value="form-P1fANdYg2F2WrvRFqfkoVM1YrwXpUoUvizyAVVseAL0" />
            <input type="hidden" name="form_id" value="sb_contact_call_back_form" />
          </div>
        </form>
        <form class="display-none" action="/form/parts/email" method="post" id="sb-contact-email-form" accept-charset="UTF-8">
          <input type="hidden" name="request_path" value="<?=uri_string()?>" />
          <div>
            <div class="form-type-textfield form-item-name form-item form-group">
              <label for="edit-name--3">Name <span class="form-required" title="This field is required.">*</span></label>
              <input class="form-control form-text required" type="text" id="edit-name--3" name="name" value="" size="60" maxlength="128" />
            </div>
            <div class="form-type-textfield form-item-email form-item form-group">
              <label for="edit-email--3">Email <span class="form-required" title="This field is required.">*</span></label>
              <input class="form-control form-text required" type="text" id="edit-email--3" name="email" value="" size="60" maxlength="128" />
            </div>
            <div class="form-type-textarea form-item-honeypot form-item form-group">
              <label for="edit-honeypot">Honeypot </label>
              <div class="form-textarea-wrapper resizable"><textarea class="form-control form-textarea" id="edit-honeypot" name="honeypot" cols="60" rows="5"></textarea></div>
            </div>
            <div class="form-type-textarea form-item-message form-item form-group">
              <label for="edit-message--3">Message </label>
              <div class="form-textarea-wrapper resizable">
                <textarea class="form-control form-textarea" id="edit-message--3" name="message" cols="60" rows="5"></textarea>
              </div>
            </div>
            <button class="btn btn-details form-submit" id="edit-submit--3" name="op" value="Submit" type="submit">Submit</button>
            <input type="hidden" name="form_build_id" value="form-U8ahYSPvYZtOnp-Hm8ltJtNPNAA71hgi7XUggpkOUqM" />
            <input type="hidden" name="form_id" value="sb_contact_email_form" />
          </div>
        </form>
      </div>
    </div><!--/.col-->
  </div><!--/.row-->
</div><!--/.container-->
