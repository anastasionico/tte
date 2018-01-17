<div class="main-container container">
  <div class="row">
    <section class="col-sm-12">
      <? if($this->session->flashdata('alert')) { $alert = $this->session->flashdata('alert'); ?>
      <div class="alert alert-<?=$alert['type']?>">
        <?=$alert['message']?>
      </div>
      <? } ?>
      <h1 class="page-header">Mercedes-Benz Van Parts - UK Wide Free Delivery</h1>
      <div class="region region-content">
        <section id="block-sb-parts-order-form" class="block block-sb clearfix">


          <div id="order_online" class="row">
            <div class="col-xs-8 col-md-6 col-lg-5">

              <form method="post" action="<?php echo site_url('go/reg')?>" class="form">
                <div class="form-group">
                  <label for="my-reg">Enter your reg below</label>
                  <input type="text" name="my-reg" id="my-reg" class="form-control" placeholder="YOUR REG">
                </div>
                <input type="submit" value="GO" id="lookupsub" class="btn btn-details">
              </form>

              <form id="vehicle-select-form" class="form part-grid">
                <div class="form-group">
                  <label for="optone">Or, select your vehicle</label>
                  <select id="vehicle_model" name="vehicle_model" class="form-control">
                    <? 
                    $last_vehicle = '';
                    foreach($vehicles as $vehicle) {
                    if($last_vehicle != $vehicle['vehicle_text']) {
                    if($last_vehicle == '') { //first loop
                    ?>
                    <option value="" selected="selected">Vehicle</option>
                    <? } ?>
                    <option value="dropdown-<?=url_title($vehicle['vehicle_text'], '_', TRUE)?>"><?=$vehicle['vehicle_text']?></option>
                    <?
                    } // end last vehicle != current
                    ?>
                    <?
                    $last_vehicle = $vehicle['vehicle_text'];
                    $last_vehicle_vin = $vehicle['vehicle_vin'];
                    } // foreach vehicle
                    ?>

                  </select>
                </div>
              </form>
              <? 
              $last_vehicle = '';
              foreach($vehicles as $vehicle) {
              if($last_vehicle != $vehicle['vehicle_text']) {
              if($last_vehicle == '') { //first loop
              ?>
              <form id="dropdown-<?=url_title($vehicle['vehicle_text'], '_', TRUE)?>" class="form vehicle_models hidden" method="post" action="<?php echo site_url('go/model')?>">
                <div class="form-group">
              <? } else { ?>
                  </select>
                </div>
                <input type="submit" id="go" name="go" value="GO" class="btn btn-details">
              </form>
              <form id="dropdown-<?=url_title($vehicle['vehicle_text'], '_', TRUE)?>" class="form vehicle_models hidden" method="post" action="<?php echo site_url('go/model')?>">
                <div class="form-group">
                <? } ?>
                  <select name="vehicle_id" class="form-control">
                    <?
                    } // end last vehicle != current
                    ?>
                    <option value="<?=$vehicle['id']?>"><?=$vehicle['model']?></option>
                    <?
                    $last_vehicle = $vehicle['vehicle_text'];
                    $last_vehicle_vin = $vehicle['vehicle_vin'];
                    } // foreach vehicle
                    ?>
                  </select>
                </div>
                <input type="submit" id="go" name="go" value="GO" class="btn btn-details">
              </form>

              <form method="post" action="<?php echo site_url('go/part')?>" class="form part-grid">
                <div class="form-group">
                  <label for="part_number">Or, enter a part number</label>
                  <input type="text" name="part_number" id="part_number" class="form-control" placeholder="Part Number">
                </div>
                <input type="submit" id="go" name="go" value="GO" class="btn btn-details">
              </form>

            </div>
          </div>
          <div class="row addpadding">
            <div class="col-xs-12">
              <div class="accessorie-button">
                <a href="/mercedes-parts/accessories" class="btn btn-details btn-lg">Mercedes-Benz<br>Accessories</a>
              </div>
            </div>
          </div>
          <div class="row">
<h2>Mercedes-Benz Van Parts</h2>
<p>The S&amp;B Commercials parts store features a comprehensive selection of spare parts for a range of Mercedes-Benz commercial vehicles. With over 700 Mercedes-Benz spare parts and accessories listed there’s no better place to find parts for popular van ranges such as the Citan, Vito or Sprinter.</p>
<p>Whether you’re after Mercedes engine parts, brake pads or a new bonnet we pride ourselves on only offering genuine Mercedes products.</p>
<h3>Looking for Mercedes Sprinter spares or Mercedes Vito parts?</h3>
<p>Finding the product you’re after should be a quick and easy process. Our search tool is designed to help you track down the part you need in an instant. Simply select your model from the drop down menu then click ‘Go’ to view the full selection of Mercedes spare parts for your van.</p>
<p>Alternatively you can use the parts search function or the smart registration plate look-up option, which makes it easy to accurately match parts with your model. Just type your registration or a specific part number into the relevant box and click ‘Go’.</p>
<p>Our support agents are on hand to assist you in finding the right Mercedes parts online via our LiveChat feature. </p>
          </div>
        
          <div class="row addpadding">
            <? 
            $last_vehicle = '';
            foreach($vehicles as $vehicle) {
              if($last_vehicle != $vehicle['vehicle_text']) {
                if($last_vehicle == '') { //first loop
            ?>
            <div class="col-xs-6 col-md-4 col-lg-3">
              <h3><?=$vehicle['vehicle_text']?></h3>
              <ul>
                <? } else { ?>
              </ul>
            </div>
            <? if($vehicle['vehicle_text'] == 'Sprinter 1995-2006') { ?></div><div class="row"><? } ?>
            <div class="col-xs-6 col-md-4 col-lg-3">
              <h3><?=$vehicle['vehicle_text']?></h3>
              <ul>
                <? } ?>
              <?
              } // end last vehicle != current
              ?>
                  <li><a href="/mercedes-parts/<?=$vehicle['url']?>"><?=$vehicle['model']?></a></li>
            <?
              $last_vehicle = $vehicle['vehicle_text'];
              $last_vehicle_vin = $vehicle['vehicle_vin'];
            } // foreach vehicle
            ?>
              </ul>
            </div>


            <div class="clearfix visible-xs"></div>
          </div>
        </section> <!-- /.block -->

      </div>
    </section>

  </div>
</div>
