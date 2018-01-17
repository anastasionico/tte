<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1>Truck & Trailer Equipment</h1> 
    <p>No. 1 for makes of truck and trailer parts</p> 
  </div>
</div>
<div class="row contact_description">
  <h1>About TTE</h1>  
  <div>
    <h3><?= $about['aboutHeader']?></h3>
    <p><?= $about['aboutDescription']?></p>
    <ul>
      <li><i class="fa fa-bullseye" aria-hidden="true"></i>&nbsp;&nbsp;<?= $about['bullet1']?></li>
      <li><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;&nbsp;<?= $about['bullet2']?></li>
      <li><i class="fa fa-fast-forward" aria-hidden="true"></i></i>&nbsp;&nbsp;<?= $about['bullet3']?></li>
    </ul>  
  </div>
</div>
<div class="row contact_description">
  <h1>What we do</h1>  
  <div>
    <h3><?= $about['whatwedoHeader']?></h3>
    <p><?= $about['whatwedoDescription']?></p>
  </div>
</div>
<div class="row contact_location">
  <h1>Our Locations</h1>
  <ul class="clearfix">
    <li>
      <article>
        <img src="/assets/img/about/<?= $location['firstImage']?>">
        <h3><?= $location['firstHeader']?></h3>
        <p class=""><?= $location['firstDescription']?></p>
        <ul class="bullet_point clearfix">
          <li>
            <p>
              <i class="fa fa-home" aria-hidden="true"></i> 
              <?= $location['firstbullet1']?>
            </p>
          </li>
          <li>
            <p>
              <i class="fa fa-check" aria-hidden="true"></i> 
              <?= $location['firstbullet2']?>
            </p>
          </li>
        </ul>
      </article>
    </li>
    <li>
      <article>
        <img src="/assets/img/about/<?= $location['secondImage']?>">
        <h3><?= $location['secondHeader']?></h3>
        <p class=""><?= $location['secondDescription']?></p>
        <ul class="bullet_point clearfix">
          <li>
            <p>
              <i class="fa fa-home" aria-hidden="true"></i> 
              <?= $location['secondbullet1']?>
            </p>
          </li>
          <li>
            <p>
              <i class="fa fa-check" aria-hidden="true"></i> 
              <?= $location['secondbullet2']?>
            </p>
          </li>
        </ul>
      </article>
    </li>
    <li>
      <article>
        <img src="/assets/img/about/<?= $location['deliveryImage']?>">
        <h3><?= $location['deliveryHeader']?></h3>
        <p class=""><?= $location['deliveryDescription']?></p>
      </article>
    </li>
</div>
<section class="row contact_form" id="contact_form">
  <div>
    <h1>Contact Us</h1>
    <p>Please fill in the contact form below and someone will be in touch shortly.</p>
    <?php echo validation_errors(); ?>
    <?php echo form_open("store/contact_form")?>
      <div class="form-group">
        <label for="name">Name*</label>
        <input type="text" class="form-control" name="name">
      </div>
      <div class="form-group">
        <label for="email">Email*</label>
        <input type="email" class="form-control" name="email">
      </div>
      <div class="form-group">
        <label for="message">Message*</label><br>
        <textarea name='message' class="form-control"></textarea>
      </div>
      <button type="submit" class="btn-ghost-full text-right">Submit</button>
    </form>
    <a href="/enquiry" class="">or Send us an enquiry</a>
  </div>
</section>