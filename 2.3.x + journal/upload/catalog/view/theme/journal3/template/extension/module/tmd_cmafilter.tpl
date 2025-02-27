<?php if($tmd_status == "1") { ?>
<div id="filter">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-filter"></i> <b><span  style="color: <?php echo $tmd_title_color; ?>;"><?php echo $heading_title1; ?></span></b></h3>
        </div>
        <div class="panel-body">
        	<?php if($tmd_category == "yes") { ?>
			<div class="form-group">
			    <label class="control-label" for="input-category_id"><?php echo $text_category; ?></label> 
			    <select name="filter_first_level" id="input-category_id" class="form-control">
			      <option value="0"><?php echo $text_select; ?></option>
			      <?php foreach ($categories as $categorie) { ?>
			      <?php if($categorie['category_id'] == $filter_first_level) { ?>
			      <option value="<?php echo $categorie['category_id']; ?>" selected="selected"><?php echo $categorie['name']; ?></option>
			      <?php } else { ?>
			      <option value="<?php echo $categorie['category_id']; ?>"><?php echo $categorie['name']; ?></option>
			      <?php } ?>
			      <?php } ?>
			    </select>
			</div>
			<?php } ?>

			<?php if($tmd_sub_category == "yes") { ?>
			<div class="form-group">
				<label  class="control-label" for="input-subcategory"><?php echo $text_sb_category; ?></label>	
				<select name="filter_second_level" id="input-subcategory" class="form-control">
				<option value="0"><?php echo $text_select; ?></option>
				</select>
			</div>
			<?php } ?>

			<?php if($tmd_sub_subcategory == "yes") { ?>
			<div class="form-group">
				<label  class="control-label" for="input-subsubcategory"><?php echo $text_ssb_category; ?></label>	
				<select name="filter_third_level" id="input-subsubcategory" class="form-control">
				<option value="0"><?php echo $text_select; ?></option>
				</select>
			</div>
			<?php } ?>

			<?php if($tmd_brand == "yes") { ?>
			<div class="form-group">
			    <label class="control-label" for="input-brand"><?php echo $text_brand; ?></label> 
			    <select name="filter_brand" id="input-brand" class="form-control">
			      <option value="0"><?php echo $text_select; ?></option>
			      <?php foreach ($manufacturers as $manufacturer) { ?>
			      <?php if($manufacturer['manufacturer_id'] == $filter_brand) { ?>
			      <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
			      <?php } else { ?>
			      <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
			      <?php } ?>
			      <?php } ?>
			    </select>
			</div>
			<?php } ?>

			<?php if($tmd_attribute == "yes") { ?>
			<div class="form-group">
			    <label class="control-label" for="input-filter_model"><?php echo $text_attributes; ?></label> 
			    <select name="filter_model" id="input-filter_model" class="form-control">
			      <option value="0"><?php echo $text_select; ?></option>
			      <?php foreach ($attributes as $attribute) { ?>
			      <?php if($attribute['attribute_id'] == $filter_model) { ?>
			      <option value="<?php echo $attribute['attribute_id']; ?>" selected="selected"><?php echo $attribute['name']; ?></option>
			       <?php } else { ?>
			      <option value="<?php echo $attribute['attribute_id']; ?>"><?php echo $attribute['name']; ?></option>
			      <?php } ?>
			      <?php } ?>
			    </select>
			</div>
			<?php } ?>

			<?php if($tmd_search_input == "yes") { ?>
			<div class="form-group">
			    <label class="control-label" for="input-filter_search"><?php echo $text_search ; ?></label> 
			    <input type="text" name="filter_search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" id="input-filter_search" class="form-control" />   
			</div>
			<?php } ?>
		</div>
		<div class="panel-body">
			<div class="form-group text-right">
          		<button type="button" class="btn btn-primary tmdcmafilter" id="button-filter" data-loading-text="<?php echo $text_loading; ?>"><?php echo $button_filter; ?></button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = '';

  var filter_first_level = $('select[name=\'filter_first_level\']').val();

  if (filter_first_level!='0') {
    url += '&filter_first_level=' + encodeURIComponent(filter_first_level);
  }

  var filter_second_level = $('select[name=\'filter_second_level\']').val();

  if (filter_second_level!='0') {
    url += '&filter_second_level=' + encodeURIComponent(filter_second_level);
  }

  var filter_third_level = $('select[name=\'filter_third_level\']').val();

  if (filter_third_level!='0') {
    url += '&filter_third_level=' + encodeURIComponent(filter_third_level);
  }

  var filter_brand = $('select[name=\'filter_brand\']').val();

  if (filter_brand!='0') {
    url += '&filter_brand=' + encodeURIComponent(filter_brand);
  }

  var filter_model = $('select[name=\'filter_model\']').val();

  if (filter_model!='0') {
    url += '&filter_model=' + encodeURIComponent(filter_model);
  }

  var filter_search = $('input[name=\'filter_search\']').val();

  if (filter_search) {
    url += '&search=' + encodeURIComponent(filter_search);
  }

  location = 'index.php?route=product/search' + url;
});
$(document).bind('keypress', function(e) {
  if(e.keyCode==13){
       $('#button-filter').trigger('click');
   }
});
//--></script>

<script type="text/javascript">
$('select[name=\'filter_first_level\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=extension/module/tmd_cmafilter/subcategory&filter_first_level=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'filter_first_level\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			
			html = '<option value="0"><?php echo $text_select; ?></option>';

			if (json['subcategory'] && json['subcategory'] != '') {
				for (i = 0; i < json['subcategory'].length; i++) {
					html += '<option value="' + json['subcategory'][i]['category_id'] + '"';

					if (json['subcategory'][i]['category_id'] == '<?php echo $filter_second_level; ?>') {
						html += ' selected="selected"';
					}
					
					html += '>' + json['subcategory'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			$('select[name=\'filter_second_level\']').html(html);
			<?php if($filter_first_level) { ?>
			$('select[name=\'filter_second_level\']').trigger('change');
			<?php } ?>
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
<?php if($filter_first_level) { ?>
$('select[name=\'filter_second_level\']').trigger('change');
<?php } ?>

$('select[name=\'filter_second_level\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=extension/module/tmd_cmafilter/subsubcategory&filter_second_level=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'filter_second_level\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			
			html = '<option value="0"><?php echo $text_select; ?></option>';

			if (json['subsubcategory'] && json['subsubcategory'] != '') {
				for (i = 0; i < json['subsubcategory'].length; i++) {
					html += '<option value="' + json['subsubcategory'][i]['category_id'] + '"';

					if (json['subsubcategory'][i]['category_id'] == '<?php echo $filter_third_level; ?>') {
						html += ' selected="selected"';
					}
					
					html += '>' + json['subsubcategory'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			$('select[name=\'filter_third_level\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
<?php if($filter_first_level) { ?>
$('select[name=\'filter_first_level\']').trigger('change');
<?php } else{ ?>
$('select[name=\'filter_third_level\']').trigger('change');
<?php } ?>
</script>
<style type="text/css">
.tmdcmafilter{
    width: 100%;
	border: none;
	background: <?php echo $tmd_btn_bg_color; ?>;
    color: <?php echo $tmd_text_color; ?>;
}
</style>

