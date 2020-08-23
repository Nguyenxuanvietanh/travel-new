<script type="text/javascript">
  $(function(){
    $("#image_default").change(function(){
      var preview_default = $('.default_preview_img');

   preview_default.fadeOut();

    /* html FileRender Api */
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("image_default").files[0]);

    oFReader.onload = function (oFREvent) {
      preview_default.attr('src', oFREvent.target.result).fadeIn();

    };

  });
  })

</script>
<script type="text/javascript">
  $(function(){
    $(".posttitle").blur(function(){
      var title = $(this).val();
      var postid = $("#postid").val();
      $.post("<?php echo base_url();?>admin/ajaxcalls/createBlogPermalink",{title: title, postid: postid},function(response){
          $(".permalink").val(response);
      });
    })
  })
</script>
<form method="post" action="" enctype="multipart/form-data" >
<div class="col-md-12">
    <?php $validationerrors = validation_errors();
      if(isset($errormsg) || !empty($validationerrors)){  ?>
    <div class="alert alert-danger">
      <i class="fa fa-times-circle"></i>
      <?php
        echo @$errormsg;
        echo $validationerrors; ?>
    </div>
    <?php  } ?>
    <div class="panel panel-default">
      <ul class="nav nav-tabs nav-justified" role="tablist">
        <li class="active"><a href="#GENERAL" data-toggle="tab"><?php echo ucfirst($action);?> Post</a></li>
        <li class=""><a href="#TRANSLATE" data-toggle="tab">Translate</a></li>
      </ul>
      <div class="panel-body">
        <br>
        <div class="tab-content">
          <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Pass Name</label>
            <div class="col-md-4">
              <input name="name" type="text" placeholder="Pass Name" class="form-control"
                value="<?php echo @$pass_data[0]->name;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Ammount</label>
            <div class="col-md-4">
              <input name="ammount" type="text" placeholder="Ammount" class="form-control"
                value="<?php echo @$pass_data[0]->ammount;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Status</label>
            <div class="col-md-2">
              <select data-placeholder="Select" class="form-control" name="status">
                <option value="Yes" <?php if(@$pass_data[0]->status == "yes"){ echo 'selected'; } ?>>Enabled</option>
                <option value="No" <?php if(@$pass_data[0]->status == "no"){ echo 'selected'; } ?>>Disabled</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <?php if($isadmin){ ?>
            <label class="col-md-2 control-label text-left">Pass Type</label>
            <div class="col-md-2">
              <select data-placeholder="Select" class="form-control" name="type">
                <option value="1" <?php if(@$pass_data[0]->type == "1"){ echo 'selected'; } ?>>National</option>
                <option value="2" <?php if(@$pass_data[0]->type == "2"){ echo 'selected'; } ?>>InterNational</option>
              </select>
            </div>
            <?php } ?>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Pass Category</label>
            <div class="col-md-2">
              <select data-placeholder="Select" class="form-control" name="category_id">
                <?php foreach($categories as $category){ ?>
                <option value="<?php echo $category->id;?>" <?php if(@$pass_data[0]->category_id == $category->id){ echo 'selected'; } ?>>
                  <?php echo $category->name;?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <?php if($isadmin){ ?>
            <label class="col-md-2 control-label text-left">Sales date</label>
            <div class="col-md-2">
              <input name="sales_date" type="text" placeholder="Sales date" class="form-control dpd1"
                value="<?php echo pt_show_date_php(@$pass_data[0]->sales_date); ?>" />
            </div>
            <?php } ?>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Notes</label>
            <div class="col-md-10">
              <textarea id="note" name="note" rows="5" cols="100" placeholder="Note"><?php echo @$pass_data[0]->note; ?></textarea>
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">HTML Notes</label>
            <div class="col-md-10">
              <?php $this->ckeditor->editor('html_note', @$pass_data[0]->html_note, $ckconfig,'html_note'); ?>
            </div>
          </div>
            <div class="clearfix"></div>
            <hr>
          </div>
          <!----Translation Tab---->
          <div class="tab-pane wow fadeIn animated in" id="TRANSLATE">
            
            <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getBackPassTranslation($lang,$pass_data[0]->id);  ?>
              <div class="panel panel-default">
              <div class="panel-heading"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" /> <?php echo $val['name']; ?></div>
              <div class="panel-body">
                <div class="row form-group">
                  <label class="col-md-2 control-label text-left">Pass Name</label>
                  <div class="col-md-10">
                    <input name='<?php echo "translated[$lang][title]"; ?>' type="text" placeholder="Post Title" class="form-control" value="<?php echo @$trans[0]->trans_title;?>" />
                  </div>
                </div>
                <div class="row form-group">
                  <label class="col-md-2 control-label text-left">Post Content</label>
                  <div class="col-md-10">
                    <?php  $this->ckeditor->editor("translated[$lang][desc]", @$trans[0]->trans_desc, $ckconfig,"translated[$lang][desc]"); ?>
                  </div>
                </div>
                <hr>
                <div class="row form-group">
                  <label class="col-md-2 control-label text-left">Meta Keywords</label>
                  <div class="col-md-10">
                    <textarea name='<?php echo "translated[$lang][keywords]"; ?>' placeholder="Keywords" class="form-control" id="" cols="30" rows="2"><?php echo @$trans[0]->trans_keywords;?></textarea>
                  </div>
                </div>
                <div class="row form-group">
                  <label class="col-md-2 control-label text-left">Meta Description</label>
                  <div class="col-md-10">
                    <textarea name='<?php echo "translated[$lang][metadesc]"; ?>' placeholder="Description" class="form-control" id="" cols="30" rows="4"><?php echo @$trans[0]->trans_meta_desc;?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <?php } } ?>
          </div>
        </div>
      </div>
      <div class="panel-footer">
        <input type="hidden" name="action" value="<?php echo $action;?>" />
        <input type="hidden" id="passid" name="passid" value="<?php echo @$pass_data[0]->id;?>" />
        <button class="btn btn-primary" type="submit">Submit</button>
      </div>
    </div>

</div>
</form>