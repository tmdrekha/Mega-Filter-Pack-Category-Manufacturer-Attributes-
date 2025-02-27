<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-module" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><i class="fa fa-cog"></i> <?php echo $tab_general; ?></a></li>
            <li><a href="#tab-language" data-toggle="tab"><i class="fa fa-language"></i> <?php echo $tab_language; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="tmd_cmafilter_status" id="input-status" class="form-control">
                    <?php if ($tmd_cmafilter_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
                <div class="col-sm-10">
                  <select name="tmd_cmafilter_category" id="input-category" class="form-control">
                    <?php if ($tmd_cmafilter_category == "yes") { ?>
                    <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="no"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="yes"><?php echo $text_yes; ?></option>
                    <option value="no" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <fieldset id="sub_cate">    
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-sb_category"><?php echo $entry_sb_category; ?></label>
                  <div class="col-sm-10">
                    <select name="tmd_cmafilter_sub_category" id="input-sb_category" class="form-control">
                      <?php if ($tmd_cmafilter_sub_category == "yes") { ?>
                      <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                      <option value="no"><?php echo $text_no; ?></option>
                      <?php } else { ?>
                      <option value="yes"><?php echo $text_yes; ?></option>
                      <option value="no" selected="selected"><?php echo $text_no; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </fieldset>
              <fieldset id="sub_sub_cate">    
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ssb_category"><?php echo $entry_ssb_category; ?></label>
                  <div class="col-sm-10">
                    <select name="tmd_cmafilter_sub_sub_category" id="input-ssb_category" class="form-control">
                      <?php if ($tmd_cmafilter_sub_sub_category == "yes") { ?>
                      <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                      <option value="no"><?php echo $text_no; ?></option>
                      <?php } else { ?>
                      <option value="yes"><?php echo $text_yes; ?></option>
                      <option value="no" selected="selected"><?php echo $text_no; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </fieldset>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-brand"><?php echo $entry_brand; ?></label>
                <div class="col-sm-10">
                  <select name="tmd_cmafilter_brand" id="input-brand" class="form-control">
                    <?php if ($tmd_cmafilter_brand == "yes") { ?>
                    <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="no"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="yes"><?php echo $text_yes; ?></option>
                    <option value="no" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-attribute"><?php echo $entry_attributes; ?></label>
                <div class="col-sm-10">
                  <select name="tmd_cmafilter_attribute" id="input-attribute" class="form-control">
                    <?php if ($tmd_cmafilter_attribute == "yes") { ?>
                    <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="no"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="yes"><?php echo $text_yes; ?></option>
                    <option value="no" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-search_input"><?php echo $entry_search_input; ?></label>
                <div class="col-sm-10">
                  <select name="tmd_cmafilter_search_input" id="input-search_input" class="form-control">
                    <?php if ($tmd_cmafilter_search_input == "yes") { ?>
                    <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="no"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="yes"><?php echo $text_yes; ?></option>
                    <option value="no" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

              <div class="tab-pane" id="tab-language">
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_heading_title; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php foreach ($languages as $language) { ?>
                      <div class="col-sm-6">
                        <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="tmd_cmafilter_language[<?php echo $language['language_id']; ?>][heading_title]" value="<?php echo isset($tmd_cmafilter_language[$language['language_id']]) ? $tmd_cmafilter_language[$language['language_id']]['heading_title'] : ''; ?>" placeholder="<?php echo $entry_heading_title; ?>" class="form-control" />
                        </div>
                      </div>
                     <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_category; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php foreach ($languages as $language) { ?>
                      <div class="col-sm-6">
                       <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="tmd_cmafilter_language[<?php echo $language['language_id']; ?>][category]" value="<?php echo isset($tmd_cmafilter_language[$language['language_id']]) ? $tmd_cmafilter_language[$language['language_id']]['category'] : ''; ?>" placeholder="<?php echo $entry_category; ?>" class="form-control" />
                        </div>
                      </div>
                     <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_sb_category; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php foreach ($languages as $language) { ?>
                      <div class="col-sm-6">
                       <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="tmd_cmafilter_language[<?php echo $language['language_id']; ?>][sb_category]" value="<?php echo isset($tmd_cmafilter_language[$language['language_id']]) ? $tmd_cmafilter_language[$language['language_id']]['sb_category'] : ''; ?>" placeholder="<?php echo $entry_sb_category; ?>" class="form-control" />
                        </div>
                      </div>
                     <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_ssb_category; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php foreach ($languages as $language) { ?>
                      <div class="col-sm-6">
                       <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="tmd_cmafilter_language[<?php echo $language['language_id']; ?>][ssb_category]" value="<?php echo isset($tmd_cmafilter_language[$language['language_id']]) ? $tmd_cmafilter_language[$language['language_id']]['ssb_category'] : ''; ?>" placeholder="<?php echo $entry_ssb_category; ?>" class="form-control" />
                        </div>
                      </div>
                     <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_brand; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php foreach ($languages as $language) { ?>
                      <div class="col-sm-6">
                       <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="tmd_cmafilter_language[<?php echo $language['language_id']; ?>][brand]" value="<?php echo isset($tmd_cmafilter_language[$language['language_id']]) ? $tmd_cmafilter_language[$language['language_id']]['brand'] : ''; ?>" placeholder="<?php echo $entry_brand; ?>" class="form-control" />
                        </div>
                      </div>
                     <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_attributes; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php foreach ($languages as $language) { ?>
                      <div class="col-sm-6">
                       <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="tmd_cmafilter_language[<?php echo $language['language_id']; ?>][attributes]" value="<?php echo isset($tmd_cmafilter_language[$language['language_id']]) ? $tmd_cmafilter_language[$language['language_id']]['attributes'] : ''; ?>" placeholder="<?php echo $entry_attributes; ?>" class="form-control" />
                        </div>
                      </div>
                     <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $entry_search_input; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php foreach ($languages as $language) { ?>
                      <div class="col-sm-6">
                       <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="tmd_cmafilter_language[<?php echo $language['language_id']; ?>][search]" value="<?php echo isset($tmd_cmafilter_language[$language['language_id']]) ? $tmd_cmafilter_language[$language['language_id']]['search'] : ''; ?>" placeholder="<?php echo $entry_search_input; ?>" class="form-control" />
                        </div>
                      </div>
                     <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-bg-color"><?php echo $entry_title_color; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="tmd_cmafilter_title_color" value="<?php echo $tmd_cmafilter_title_color; ?>" id="input-bg-color" placeholder="<?php echo $entry_title_color; ?>" class="form-control color" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-text-color"><?php echo $entry_text_color; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="tmd_cmafilter_text_color" value="<?php echo $tmd_cmafilter_text_color; ?>" id="input-text-colo" placeholder="<?php echo $entry_text_color; ?>" class="form-control color" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-bg-color"><?php echo $entry_bgcolor; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="tmd_cmafilter_btn_bg_color" value="<?php echo $tmd_cmafilter_btn_bg_color; ?>" id="input-bg-color" placeholder="<?php echo $entry_bgcolor; ?>" class="form-control color" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="view/javascript/colorbox/jquery.minicolors.js"></script>
<link rel="stylesheet" href="view/stylesheet/jquery.minicolors.css"/>
<script type="text/javascript"><!--
$(document).ready( function() {
  $('.color').each( function() {
    $(this).minicolors({
      control: $(this).attr('data-control') || 'hue',
      defaultValue: $(this).attr('data-defaultValue') || '',
      inline: $(this).attr('data-inline') === 'true',
      letterCase: $(this).attr('data-letterCase') || 'lowercase',
      opacity: $(this).attr('data-opacity'),
      position: $(this).attr('data-position') || 'bottom left',
      change: function(hex, opacity) {
        if( !hex ) return;
        if( opacity ) hex += ', ' + opacity;
        try {
          console.log(hex);
        } catch(e) {}
      },
      theme: 'bootstrap'
    });
  });
});
</script>
<script type="text/javascript"><!--
  $('select[name=\'tmd_cmafilter_category\']').on('change', function() {
    if (this.value == 'yes') {
      $('#sub_cate').show();
      $('#sub_sub_cate').show();
    } else if(this.value == 'no'){
      $('#sub_cate').hide();
      $('#sub_sub_cate').hide();
    }
    });
    $('select[name=\'tmd_cmafilter_category\']').trigger('change');
</script>
<script type="text/javascript"><!--
  $('select[name=\'tmd_cmafilter_sub_category\']').on('change', function() {
    if (this.value == 'yes') {
      $('#sub_sub_cate').show();
    } else if(this.value == 'no'){
      $('#sub_sub_cate').hide();
    }
    });
    $('select[name=\'tmd_cmafilter_sub_category\']').trigger('change');
</script>
<style> 

#form-module ul li.active > a,#form-module ul li.active > a:hover,#form-module ul li.active > a:focus{
  background: #00a4e4 none repeat scroll 0 0 !important;
  color:#fff;
}
#form-module .nav-tabs li a{
  background:#E4E6EA;
}
#form-module .nav-tabs > li.active > a, #form-module .nav-tabs > li.active > a:hover,#form-module .nav-tabs > li.active > a:focus{
  color:#fff;
}
</style>
<?php echo $footer; ?>