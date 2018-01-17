<?php //echo "<pre>"; print_r($about);echo "</pre>"; ?>
<div class="row">
	<section style="">
		<h1>About us</h1>
		<?php echo form_open('about_management'); ?>
		  	<div class="form-group">
		    	<label for="about-header">About- Header</label>
		    	<input type="text" class="form-control fullwidth" name="about-header" value="<?= $about['aboutHeader'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="about-description">About - Description</label>
		    	<textarea name='about-description'  class="fullwidth">
		    		<?= $about['aboutDescription'] ?>
		    	</textarea>
		  	</div>
		  	
		  	<div class="form-group">
		    	<label for="bullet1">Bullet1</label>
		    	<input type="text" class="form-control fullwidth" name="bullet1" value="<?= $about['bullet1'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="bullet2">Bullet2</label>
		    	<input type="text" class="form-control fullwidth" name="bullet2" value="<?= $about['bullet2'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="bullet3">Bullet3</label>
		    	<input type="text" class="form-control fullwidth" name="bullet3" value="<?= $about['bullet3'] ?>">
		  	</div>
		  	
		  	<div class="form-group">
		    	<label for="whatwedo-header">What we do - Header</label>
		    	<input type="text" class="form-control fullwidth" name="whatwedo-header" value="<?= $about['whatwedoHeader'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="whatwedo-description">What we do - Description</label>
		    	<textarea name='whatwedo-description' class="fullwidth">
		    		<?= $about['whatwedoDescription'] ?>
		    	</textarea>
		  	</div>
			<button type="submit" class="btn btn-default btn btn-primary">Change</button>
		</form>
	</section>
	<a href="/location_management" class="btn btn-default">Go To Locations</a>
</div>