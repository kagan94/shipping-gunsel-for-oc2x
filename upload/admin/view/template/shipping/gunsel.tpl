<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="text" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary" onclick="$('#form').submit();"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($success) { ?>
      <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php } ?>

	<?php if ($error_warning) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
	<?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">

        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-general-settings" data-toggle="tab"><?php echo $text_general_settings; ?></a></li>
          <li><a href="#tab-support" data-toggle="tab"><?php echo $text_support; ?></a></li>
        </ul>


        <div class="tab-content">
          <div class="tab-pane active" id="tab-general-settings">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $entry_status; ?></label>
                <div class="col-sm-3">
                  <select name="gunsel_status" id="input-status" class="form-control">
                    <?php if ($gunsel_status) { ?>
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
                <label class="col-sm-4 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-3">
                  <select name="gunsel_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $gunsel_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-3">
                  <input type="text" name="gunsel_sort_order" value="<?php echo $gunsel_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>

    	      <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_fixed_shipping_price; ?></label>
                <div class="col-sm-3">
                  <input type="text" name="gunsel_fixed_price_for_delivery" value="<?php echo $gunsel_fixed_price_for_delivery; ?>" size="5" class="form-control"/>
                </div>
              </div>

    	      <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_min_total_for_free_delivery; ?></label>
                <div class="col-sm-3">
                  <input type="text" name="gunsel_min_total_for_free_delivery" value="<?php echo $gunsel_min_total_for_free_delivery; ?>" size="5" class="form-control"/>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_free_shipping; ?></label>
                <div class="col-sm-3" style="padding-top: 9px;">
                  <input type="checkbox" name="gunsel_free_shipping" value="1" <?php if(isset($gunsel_free_shipping)) echo "checked"; ?>>
                </div>
              </div>

              <div class="form-group" style="text-align:center; margin-right:15%;">
                  <button type="submit" class="btn btn-primary" style="padding: 10px 60px;"><?php echo $button_save; ?></button>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="tab-support">
            <iframe src="<?php echo $link_to_support; ?>"  frameborder="0" style="height: 100vh;" height="100%" width="100%"></iframe>
          </div>
        </div><!-- End .tab-content -->
      </div>
    </div>
  </div>
</div><!-- End #content -->
<?php echo $footer; ?>
