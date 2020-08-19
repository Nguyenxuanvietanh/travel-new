<?php if(isModuleActive( 'boats')){ ?>
</div>
<div class="featured">
<div class="container-fluid">
<div class="section-title text-left go-right">
<h2 class="float-none"><?php echo trans('0634');?></h2>
</div>
<div class="row equal-height cols-2 cols-md-2 cols-lg-4 gap-10 gap-md-20 gap-xl-30">
<?php foreach($featuredBoats as $item){ ?>
  <div class="col">
    <figure class="featured-image-grid-item with-highlight">
        <?php if(!empty($item->discount)){?><span class="discount"><?=$item->discount?> % <?=lang('0118')?></span><?php } ?>
      <div class="image">
        <img src="<?php echo $item->thumbnail;?>" alt="<?php echo character_limiter($item->title,25);?>" alt="image">
      </div>
      <figcaption class="content">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <?php if($item->price > 0){ ?>
            <span class="item-highlight text-secondary">
              <!--<?=lang('0388')?> <?=lang('059')?>--><br><span><?php echo $item->currSymbol;?><?php echo $item->price;?></span>
            </span>
            <?php } ?>
          </div>
          <div>
            <span class="item-expire"><?php echo $item->boatDays; ?> <?php echo trans('0275');?> / <?php echo $item->boatNights; ?> <?php echo trans('0276');?></span>
          </div>
        </div>
        <div class="rating-item rating-sm go-text-right">
        <?php echo $item->stars;?> <?php echo $item->avgReviews->overall ?> <?php echo trans('042');?>
        </div>
        <h5 class="mb-0 RTL" style="font-size:13px;margin-top:10px"><?php echo character_limiter($item->title,30);?></h5>
        <div class="clear"></div>
        <p class="location go-text-right" style="font-size: 12px;"><i class="fas fa-map-marker-alt text-primary go-right"></i> <?php echo character_limiter($item->location,20);?></p>
        <span class="act-as-btn text-secondary go-text-right"><?php echo trans( '0142'); ?></span>
      </figcaption>
      <a href="<?php echo $item->slug."?date=".date('d/m/Y')."&adults=1";?>" class="position-absolute-href"></a>
    </figure>
  </div>
  <?php } ?>
</div>
</div>
</div>
<div class="container-fluid">
<?php } ?>