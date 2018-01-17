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
  <h1>Recycled, OEM and Original parts supplied throughout the UK</h1>  
  <div>
    <h3></h3>
    <p>
      If you need parts anywhere in the UK, you can rely on Truck & Trailer Equipment. Call us to discuss your needs.
    </p>
  </div>
</div>
<section class="row contact_form" id="contact_form">
  <div>
    <h1>Enquiry</h1>
    <h3 class="bg_tertiary c-white"><?= $this->session->flashdata('success'); ?></h3>
    
    <p>Please fill in the contact form below and someone will be in touch shortly.</p>
    <?php echo validation_errors(); ?>
    <?php echo form_open("store/enquiry_form")?>
      <div class="form-group">
        <label for="name">Name*</label>
        <input type="text" class="form-control" name="name" required>
      </div>
      <div class="form-group">
        <label for="name">Company</label>
        <input type="text" class="form-control" name="company">
      </div>
      <div class="form-group">
        <label for="email">Email*</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="form-group">
        <label for="name">Phone</label>
        <input type="text" class="form-control" name="phone">
      </div>
      <div class="form-group">
        <label for="name">Part Number*</label>
        <input type="text" class="form-control" name="part_number" required>
      </div>
      <div class="form-group">
        <label for="name">Chassis Number</label>
        <input type="text" class="form-control" name="chassis_number">
      </div>
      <div class="form-group">
        <label for="description">Part Description*</label><br>
        <textarea name='description' class="form-control"></textarea>
      </div>
      <button type="submit" class="btn-ghost-full text-right">Submit</button>
    </form>
  </div>
</section>