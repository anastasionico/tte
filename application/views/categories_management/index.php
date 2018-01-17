<?php
  //echo "<pre>"; print_r($this->data['groups']);   echo "</pre>";
?>
<div class="page-header">
  <h1>Category</h1>
  <a href="<?=site_url('categories_management/add')?>" class="btn btn-info">Add Category  &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></a>  
</div>
<table id="users" class="table table-striped table-hover table-bordered">
  <thead>
    <tr>
      <th>Category</th>
      <th>Name</th>
      <th>Address</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($groups as $group) { ?>
    <tr id="row_<?=$group['id']?>">
      	<td>
	      	<?php if($group['img']): ?>
	      		<img style="height: 75px" src="assets/img/category/<?= $group['img'] ?>" alt="<?=$group['name']?>">
	      	<?php endif ?>
	      	<?=$group['parentAddr']?>
  		</td>
      <td><?=$group['name']?></td>
      <td><?=$group['addr']?></td>
      <td><?=$group['description']?></td>
      <td>
        <div class="btn-group btn-group-justified">
      		<?php if(!$group['img']): ?>
      			<a href="categories_management/edit/<?=$group['id']?>" class="btn btn-primary">Edit  &nbsp;
          			<i class="fa fa-times-circle" aria-hidden="true"></i>
      			</a>
      			<a href="categories_management/delete/<?=$group['id']?>" class="btn btn-danger">Delete  &nbsp;
      				<i class="fa fa-times-circle" aria-hidden="true"></i>
  				</a>
          		
      		<?php endif; ?>      			
        </div>
      </td>
    </tr>
  <? } ?>
  </tbody>
</table>

<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript" charset="utf-8">

$.extend( $.fn.dataTableExt.oStdClasses, {
    "sWrapper": "dataTables_wrapper form-inline"
});
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function ( a ) {
        var ukDatea = a.split('/');
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },
    "date-uk-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "date-uk-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});


  $(document).ready(function() {


  $(".table-clickrow tbody")
    .on("click", "tr", function() {
      var n=$(this).attr('id').split("_");
      window.location = '/<?=$this->uri->segment(1)?>/users/'+ n[1];
    })
    .on("mouseover", "tr", function() {
      $(this)
        .addClass("over")
        .css('cursor', 'pointer');
    })
    .on("mouseout", "tr", function() {
      $(this)
        .removeClass("over")
        .css('cursor', 'auto');
    });

  });
</script>
