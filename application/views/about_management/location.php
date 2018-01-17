<?php
	//echo "<pre>"; print_r($locations);echo "</pre>"; 
?>

<div class="row">
	<?php
		if(isset($error)){
			echo $error;		
		}
	  ?>
	<section>
		<h1>Locations</h1>
		<?php echo form_open_multipart('about_management/location'); ?>
			<input type="hidden" name="firstImage_old" value="<?= $locations['firstImage']?>">
			<input type="hidden" name="secondImage_old" value="<?= $locations['secondImage']?>">
			<input type="hidden" name="deliveryImage_old" value="<?= $locations['deliveryImage']?>">

			<h4>First</h4>
			<div class="form-group">
				<img style="width:300px;" src="<?= site_url('/assets/img/about').'/'. $locations['firstImage'] ?>" alt="<?=$locations['firstImage'] ?>">
		    	<label for="image">Image</label>
		    	<input type="file" name="firstImage"/>
		  	</div>
		  	<div class="form-group">
		    	<label for="firstHeader">Header</label>
		    	<input type="text" class="form-control fullwidth" name="firstHeader" value="<?= $locations['firstHeader'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="firstDescription">Description</label>
		    	<textarea name='firstDescription' class="fullwidth">
		    		<?= $locations['firstDescription'] ?>
		    	</textarea>
		  	</div>
		  	<div class="form-group">
		    	<label for="firstbullet1">Bullet1</label>
		    	<input type="text" class="form-control fullwidth" name="firstbullet1"
		    	value="<?= $locations['firstbullet1'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="firstbullet2">Bullet2</label>
		    	<input type="text" class="form-control fullwidth" name="firstbullet2" value="<?= $locations['firstbullet2'] ?>">
		  	</div>
		  	<br><br><br>
		  	<h4>Second</h4>
			<div class="form-group">
				<img style="width:300px;" src="<?= site_url('/assets/img/about').'/'. $locations['secondImage'] ?>" alt="<?= $locations['secondImage'] ?>">
		    	<label for="image">Image</label>
		    	<input type="file" name="secondImage"/>
		  	</div>
		  	<div class="form-group">
		    	<label for="secondHeader">Header</label>
		    	<input type="text" class="form-control fullwidth" name="secondHeader" value="<?= $locations['secondHeader'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="secondDescription">Description</label>
		    	<textarea name='secondDescription' class="fullwidth">
		    		<?= $locations['secondDescription'] ?>
		    	</textarea>
		  	</div>
		  	<div class="form-group">
		    	<label for="secondbullet1">Bullet1</label>
		    	<input type="text" class="form-control fullwidth" name="secondbullet1"
		    	value="<?= $locations['secondbullet1'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="secondbullet2">Bullet2</label>
		    	<input type="text" class="form-control fullwidth" name="secondbullet2" value="<?= $locations['secondbullet2'] ?>">
		  	</div>
		  	<br><br><br>
		  	<h4>Delivery</h4>
			<div class="form-group">
				<img style="width:300px;"  src="<?= site_url('/assets/img/about').'/'. $locations['deliveryImage'] ?>" alt="<?= $locations['deliveryImage'] ?>">
				<label for="image">Image</label>
		    	<input type="file" name="deliveryImage" />
		  	</div>
		  	<div class="form-group">
		    	<label for="deliveryHeader">Header</label>
		    	<input type="text" class="form-control fullwidth" name="deliveryHeader" value="<?= $locations['deliveryHeader'] ?>">
		  	</div>
		  	<div class="form-group">
		    	<label for="deliveryDescription">Description</label>
		    	<textarea name='deliveryDescription' class="fullwidth">
		    		<?= $locations['deliveryDescription'] ?>
		    	</textarea>
		  	</div>
		  	<input type="submit" name="submit" class="btn btn-primary">
		</form>
	</section>
</div>