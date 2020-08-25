<script type="text/javascript" src="<?php echo base_url(); ?>themes/default/assets/js/jspdf.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/default/assets/js/html2canvas.min.js"></script>
<script type="text/javascript">
  var specialElementHandlers = {
    '#editor': function (element, renderer) {
      return true;
    }
  };
</script>
<!DOCTYPE HTML>
<html>

<head>
  <meta name="author" content="PHPTRAVELS">
  <link rel="shortcut icon" href="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png';?>">
  <title><?php echo @$pageTitle; ?> <?php echo $invoice->id; ?></title>
  <style>
    .form-control {
      font-size: 1rem
    }

    .unpaid.success-box .icon {
      background: red;
      border-color: red;
    }

    .unpaid.success-box .content {
      border-color: red;
    }

    .reserved.success-box .icon {
      background: #ee8e06;
      border-color: #ee8e06;
    }

    .reserved.success-box .content {
      border-color: #ee8e06;
    }

    .cancelled.success-box .icon {
      background: red;
      border-color: red;
    }

    .cancelled.success-box .content {
      border-color: red;
    }

    .expired.success-box .icon {
      background: #ee8e06;
      border-color: #ee8e06;
    }

    .expired.success-box .content {
      border-color: #ee8e06;
    }
  </style>
  <!-- start Main Wrapper -->
  <?php $message = $this->session->flashdata('gateway_exception');
      if (! empty($message)): ?>
  <div class="alert alert-danger" style="max-width: 600px;margin: 0px auto;">
    <?=$message?>
  </div>
  <?php endif; ?>
  <div class="main-wrapper scrollspy-action">
    <div class="page-wrapper page-confirmation bg-light">
      <div class="container">
        <?php if($invoice->module != 'pass' && $invoice->module != 'golf_booking'){ include 'pay.php'; } ?>
        <?php if ($invoice->status == "unpaid") { if (time() < $invoice->expiryUnixtime) { ?>
        <div class="success-box unpaid">
          <div class="icon">
            <span><i class="ion-close"></i></span>
          </div>
          <div class="content">
            <h4><?=lang('0409')?> <?php echo trans("082"); ?></h4>
            <div class="clear"></div>
          </div>
        </div>
        <?php } else { ?>
        <div class="success-box expired">
          <div class="icon">
            <span><i class="ion-alert-circled"></i></span>
          </div>
          <div class="content">
            <h4><?=lang('0409')?> <?php echo trans("0519"); ?></h4>
            <div class="clear"></div>
          </div>
        </div>
        <?php }
            } elseif ($invoice->status == "reserved") { ?>
        <div class="success-box reserved">
          <div class="icon">
            <span><i class="ion-alert-circled"></i></span>
          </div>
          <div class="content">
            <h4><?=lang('0409')?> <?php echo trans("0445"); ?></h4>
            <div class="clear"></div>
            <?php if ($invoice->paymethod == "payonarrival") { ?>
            <p class="go-text-right"><?php echo trans("0474"); ?></p>
          </div>
        </div>
        <?php }
            } elseif ($invoice->status == "cancelled") { ?>
        <div class="success-box cancelled">
          <div class="icon">
            <span><i class="ion-android-alert"></i></span>
          </div>
          <div class="content">
            <h4><?=lang('0409')?> <?php echo trans("0347"); ?></h4>
            <div class="clear"></div>
          </div>
        </div>
        <?php } else { ?>
        <div class="success-box">
          <div class="icon">
            <span><i class="ion-android-checkbox-outline"></i></span>
          </div>
          <div class="content">
            <h4><?=lang('0409')?> <?php echo trans("081"); ?></h4>
            <div class="clear"></div>
            <p class="go-text-right"><?php echo trans("0410"); ?><?php echo $invoice->accountEmail; ?></p>
          </div>
        </div>
        <?php } ?>
        <div class="row gap-30 equal-height">
          <div class="col-12 col-lg-4 order-lg-last">
            <?php if($invoice->module == "hotels"){ ?>
            <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
              <a href="#" class="product-small-item">
                <div class="image">
                  <img src="<?php echo $invoice->thumbnail;?>" alt="image">
                </div>
                <div class="content">
                  <div class="content-body">
                    <div class="rating-item rating-sm rating-inline mb-7 go-text-right">
                      <?php echo $invoice->stars;?>
                    </div>
                    <h6><?php echo $invoice->title;?></h6>
                    <div class="clear"></div>
                    <span class="meta text-muted go-right"><i class="ion-location text-info"></i>
                      <?php echo $invoice->location;?></span>
                    <div class="clear"></div>
                  </div>
                </div>
              </a>
              <hr>
              <h3 class="heading-title"><span><?=lang('039')?></span></h3>
              <div class="clear"></div>
              <hr class="mb-30 mt-30" />
              <?php foreach($invoice->subItem as $subItem): ?>
              <div>
                <span class="room-count">( <?= $subItem->quantity ?> )</span>

                <?php echo trans("0435");?> <?php echo $subItem->title;?>

                <strong class="room-price float-right text-danger"><?= $invoice->currSymbol.$subItem->price ?></strong>
                <div class="clear"></div>
                <?php endforeach; ?>
                <ul class="confirmation-list mt-20">
                  <li>
                    <span class="font-weight-bold go-right"><?=lang('07')?></span>
                    <span class="float-right go-left"><?php echo $invoice->checkin; ?></span>
                    <div class="clear"></div>
                  </li>

                  <li>
                    <span class="font-weight-bold go-right"><?=lang('09')?></span>
                    <span class="float-right go-left"><?php echo $invoice->checkout; ?></span>
                    <div class="clear"></div>
                  </li>

                </ul>
                <div class="mb-40"></div>
                <!--<h3 class="heading-title"><span>Charge</span></h3>-->
                <div class="clear"></div>
                <ul class="confirmation-list">
                  <li>
                    <span class="font-weight-bold go-right"><?php echo trans("060");?>
                      <?php echo $invoice->nights;?></span>

                    <span class="go-left float-right"><?php $total_amount = 0;
                      foreach($invoice->subItem as $subItem): ?>
                      <?php $total_amount += ($subItem->quantity * $subItem->price * $invoice->nights); ?>
                      <?php endforeach; ?>
                      <?= $invoice->currSymbol.$total_amount; ?></span>
                    <div class="clear"></div>
                  </li>
                  <?php if(!empty($invoice->bookingExtras)){ ?>
                  <?php foreach($invoice->bookingExtras as $extra){ ?>
                  <li>
                    <span class="font-weight-bold go-right">
                      <?php echo $extra->title;?>
                      <!--(2)-->:
                    </span>

                    <span class="go-left float-right"><?php 
                      if(!empty($extra->price)) {
                          echo $invoice->currSymbol.$extra->price;
                      }
                      ?></span>
                    <div class="clear"></div>
                  </li>
                  <?php } } ?>
                  <?php if($invoice->extraBeds > 0){ ?>
                  <li>
                    <span class="font-weight-bold go-right"><?php echo trans('0428');?>
                      <?php echo $invoice->extraBeds; ?>:</span>
                    <span class="go-left">
                      <?php echo $invoice->currSymbol; ?><?php echo $invoice->extraBedsCharges; ?></span>
                    <div class="clear"></div>
                  </li>
                  <?php } ?>
                  <li>
                    <span class="font-weight-bold go-right">
                      <?=lang('0126')?>
                      <!--(2)-->
                    </span>
                    <span class="go-left float-right"> <?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutAmount,2)); ?></span>
                  </li>
                  <div class="clear"></div>
                  <li class="mt-20">
                    <span class="font-weight-bold go-right rtl-w-100"><?=lang('0153')?></span>
                    <span class="go-left float-right"><?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->tax,2));?></span>
                    <div class="clear"></div>
                  </li>
                  <li class="total">
                    <span class="font-weight-bold go-right"><?=lang('0124')?></span>
                    <span class="text-main text-secondary float-right go-left"><?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutTotal,2));?></span>
                    <div class="clear"></div>
                  </li>
                </ul>
            </aside>
            <?php } ?>
            <?php if($invoice->module == "tours"){ ?>
            <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
              <a href="#" class="product-small-item">
                <div class="image">
                  <img src="<?php echo $invoice->thumbnail;?>" alt="image">
                </div>
                <div class="content">
                  <div class="content-body">
                    <div class="rating-item rating-sm rating-inline mb-7">

                      <?php echo $invoice->stars;?>

                      <!--<p class="rating-text text-muted font-10">26 reviews</p>-->
                    </div>
                    <h6><?php echo $invoice->title;?></h6>
                    <span class="meta text-muted"><i class="ion-location text-info"></i>
                      <?php echo $invoice->location;?></span>
                  </div>
                  <!--<div class="price">from <span class="text-secondary font700">$895</span> /night</div>-->
                </div>
              </a>
              <hr>
              <h3 class="heading-title"><span><?=lang('039')?></span></h3>
              <hr class="mb-30 mt-30" />
              <ul class="confirmation-list">
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('010');?>
                    <?php echo $invoice->subItem->adults->count;?> <?php echo $invoice->currCode; ?> /
                    <?php echo $invoice->currSymbol;?>
                    <?php echo str_replace(".00",'',number_format($invoice->subItem->adults->price,2));?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo str_replace(".00",'',number_format($invoice->subItem->adults->price * $invoice->subItem->adults->count,2));?></span>
                </li>
                <?php if($invoice->subItem->child->count > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('011');?>
                    <?php echo $invoice->subItem->child->count;?> / <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->child->price;?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->child->price * $invoice->subItem->child->count;?></span>
                </li>
                <?php } if($invoice->subItem->infant->count > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0282');?>
                    <?php echo $invoice->subItem->infant->count;?> / <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->infant->price;?>:</span>
                  <span> <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->infant->price * $invoice->subItem->infant->count;?></span>
                </li>
                <?php } ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('07')?>:</span>
                  <span><?php echo $invoice->checkin; ?></span>
                </li>
                <!--                             <li class="clearfix">
                    <span class="font-weight-bold"><?=lang('09')?>:</span>
                    <span><?php echo $invoice->checkout; ?></span>
                    </li> -->
              </ul>
              <?php if(isset($invoice->subItem->golf) && $invoice->subItem->golf){ ?>
                <hr class="mb-30 mt-30" />
                <ul class="confirmation-list">
                  <li class="clearfix">
                    <span class="font-weight-bold">Golf hole</span>
                    <span><?php echo $invoice->subItem->golf->golf_hole; ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold">Golf location</span>
                    <span><?php echo $invoice->subItem->golf->golf_location; ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold">Golf time</span>
                    <span><?php echo $invoice->subItem->golf->golf_time; ?></span>
                  </li>
                </ul>
              <?php } ?>
              <div class="mb-40"></div>
              <h3 class="heading-title"><span>Charge</span></h3>
              <ul class="confirmation-list">
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans("060");?> <?php echo $invoice->nights;?></span>
                  <span><?php $total_amount = 0;
                      foreach($invoice->subItem as $subItem): ?>
                    <?php $total_amount += ($subItem->quantity * $subItem->price * $invoice->nights); ?>
                    <?php endforeach; ?>
                    <?= $invoice->currSymbol.$total_amount; ?></span>
                </li>
                <?php if(!empty($invoice->bookingExtras)){ ?>
                <?php foreach($invoice->bookingExtras as $extra){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold">
                    <?php echo $extra->title;?>
                    <!--(2)-->:
                  </span>
                  <span><?php 
                      if(!empty($extra->price)) {
                          echo $invoice->currSymbol.$extra->price;
                      }
                      ?></span>
                </li>
                <?php } } ?>
                <?php if($invoice->extraBeds > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0428');?> <?php echo $invoice->extraBeds; ?>:</span>
                  <span> <?php echo $invoice->currSymbol; ?><?php echo $invoice->extraBedsCharges; ?></span>
                </li>
                <?php } ?>
                <li class="clearfix">
                  <span class="font-weight-bold">
                    <?=lang('0126')?>
                    <!--(2)-->:
                  </span>
                  <span> <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutAmount,2)); ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('0153')?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->tax,2));?></span>
                </li>
                <li class="clearfix total">
                  <span class="font-weight-bold"><?=lang('0124')?></span>
                  <span class="text-main text-secondary"><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutTotal,2));?></span>
                </li>
              </ul>
            </aside>
            <?php } ?>
            <?php if($invoice->module == "rentals"){ ?>
            <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
              <a href="#" class="product-small-item">
                <div class="image">
                  <img src="<?php echo $invoice->thumbnail;?>" alt="image">
                </div>
                <div class="content">
                  <div class="content-body">
                    <div class="rating-item rating-sm rating-inline mb-7">

                      <?php echo $invoice->stars;?>

                      <!--<p class="rating-text text-muted font-10">26 reviews</p>-->
                    </div>
                    <h6><?php echo $invoice->title;?></h6>
                    <span class="meta text-muted"><i class="ion-location text-info"></i>
                      <?php echo $invoice->location;?></span>
                  </div>
                  <!--<div class="price">from <span class="text-secondary font700">$895</span> /night</div>-->
                </div>
              </a>
              <hr>
              <h3 class="heading-title"><span><?=lang('039')?></span></h3>
              <hr class="mb-30 mt-30" />
              <ul class="confirmation-list">
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('010');?>
                    <?php echo $invoice->subItem->adults->count;?> <?php echo $invoice->currCode; ?> /
                    <?php echo $invoice->currSymbol;?>
                    <?php echo str_replace(".00",'',number_format($invoice->subItem->adults->price,2));?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo str_replace(".00",'',number_format($invoice->subItem->adults->price * $invoice->subItem->adults->count,2));?></span>
                </li>
                <?php if($invoice->subItem->child->count > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('011');?>
                    <?php echo $invoice->subItem->child->count;?> / <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->child->price;?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->child->price * $invoice->subItem->child->count;?></span>
                </li>
                <?php } if($invoice->subItem->infant->count > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0282');?>
                    <?php echo $invoice->subItem->infant->count;?> / <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->infant->price;?>:</span>
                  <span> <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->infant->price * $invoice->subItem->infant->count;?></span>
                </li>
                <?php } ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('07')?>:</span>
                  <span><?php echo $invoice->checkin; ?></span>
                </li>
                <!--                             <li class="clearfix">
                    <span class="font-weight-bold"><?=lang('09')?>:</span>
                    <span><?php echo $invoice->checkout; ?></span>
                    </li> -->
              </ul>
              <div class="mb-40"></div>
              <h3 class="heading-title"><span>Charge</span></h3>
              <ul class="confirmation-list">
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans("060");?> <?php echo $invoice->nights;?></span>
                  <span><?php $total_amount = 0;
                                    foreach($invoice->subItem as $subItem): ?>
                    <?php $total_amount += ($subItem->quantity * $subItem->price * $invoice->nights); ?>
                    <?php endforeach; ?>
                    <?= $invoice->currSymbol.$total_amount; ?></span>
                </li>
                <?php if(!empty($invoice->bookingExtras)){ ?>
                <?php foreach($invoice->bookingExtras as $extra){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold">
                    <?php echo $extra->title;?>
                    <!--(2)-->:
                  </span>
                  <span><?php
                                            if(!empty($extra->price)) {
                                                echo $invoice->currSymbol.$extra->price;
                                            }
                                            ?></span>
                </li>
                <?php } } ?>
                <?php if($invoice->extraBeds > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0428');?> <?php echo $invoice->extraBeds; ?>:</span>
                  <span> <?php echo $invoice->currSymbol; ?><?php echo $invoice->extraBedsCharges; ?></span>
                </li>
                <?php } ?>
                <li class="clearfix">
                  <span class="font-weight-bold">
                    <?=lang('0126')?>
                    <!--(2)-->:
                  </span>
                  <span> <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutAmount,2)); ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('0153')?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->tax,2));?></span>
                </li>
                <li class="clearfix total">
                  <span class="font-weight-bold"><?=lang('0124')?></span>
                  <span class="text-main text-secondary"><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutTotal,2));?></span>
                </li>
              </ul>
            </aside>
            <?php } ?>

            <?php if($invoice->module == "boats"){ ?>
            <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
              <a href="#" class="product-small-item">
                <div class="image">
                  <img src="<?php echo $invoice->thumbnail;?>" alt="image">
                </div>
                <div class="content">
                  <div class="content-body">
                    <div class="rating-item rating-sm rating-inline mb-7">

                      <?php echo $invoice->stars;?>

                      <!--<p class="rating-text text-muted font-10">26 reviews</p>-->
                    </div>
                    <h6><?php echo $invoice->title;?></h6>
                    <span class="meta text-muted"><i class="ion-location text-info"></i>
                      <?php echo $invoice->location;?></span>
                  </div>
                  <!--<div class="price">from <span class="text-secondary font700">$895</span> /night</div>-->
                </div>
              </a>
              <hr>
              <h3 class="heading-title"><span><?=lang('039')?></span></h3>
              <hr class="mb-30 mt-30" />
              <ul class="confirmation-list">
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('010');?>
                    <?php echo $invoice->subItem->adults->count;?> <?php echo $invoice->currCode; ?> /
                    <?php echo $invoice->currSymbol;?>
                    <?php echo str_replace(".00",'',number_format($invoice->subItem->adults->price,2));?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo str_replace(".00",'',number_format($invoice->subItem->adults->price * $invoice->subItem->adults->count,2));?></span>
                </li>
                <?php if($invoice->subItem->child->count > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('011');?>
                    <?php echo $invoice->subItem->child->count;?> / <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->child->price;?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->child->price * $invoice->subItem->child->count;?></span>
                </li>
                <?php } if($invoice->subItem->infant->count > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0282');?>
                    <?php echo $invoice->subItem->infant->count;?> / <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->infant->price;?>:</span>
                  <span> <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol;?><?php echo $invoice->subItem->infant->price * $invoice->subItem->infant->count;?></span>
                </li>
                <?php } ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('07')?>:</span>
                  <span><?php echo $invoice->checkin; ?></span>
                </li>
                <!--                             <li class="clearfix">
                    <span class="font-weight-bold"><?=lang('09')?>:</span>
                    <span><?php echo $invoice->checkout; ?></span>
                    </li> -->
              </ul>
              <div class="mb-40"></div>
              <h3 class="heading-title"><span>Charge</span></h3>
              <ul class="confirmation-list">
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans("060");?> <?php echo $invoice->nights;?></span>
                  <span><?php $total_amount = 0;
                                    foreach($invoice->subItem as $subItem): ?>
                    <?php $total_amount += ($subItem->quantity * $subItem->price * $invoice->nights); ?>
                    <?php endforeach; ?>
                    <?= $invoice->currSymbol.$total_amount; ?></span>
                </li>
                <?php if(!empty($invoice->bookingExtras)){ ?>
                <?php foreach($invoice->bookingExtras as $extra){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold">
                    <?php echo $extra->title;?>
                    <!--(2)-->:
                  </span>
                  <span><?php
                                            if(!empty($extra->price)) {
                                                echo $invoice->currSymbol.$extra->price;
                                            }
                                            ?></span>
                </li>
                <?php } } ?>
                <?php if($invoice->extraBeds > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0428');?> <?php echo $invoice->extraBeds; ?>:</span>
                  <span> <?php echo $invoice->currSymbol; ?><?php echo $invoice->extraBedsCharges; ?></span>
                </li>
                <?php } ?>
                <li class="clearfix">
                  <span class="font-weight-bold">
                    <?=lang('0126')?>
                    <!--(2)-->:
                  </span>
                  <span> <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutAmount,2)); ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('0153')?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->tax,2));?></span>
                </li>
                <li class="clearfix total">
                  <span class="font-weight-bold"><?=lang('0124')?></span>
                  <span class="text-main text-secondary"><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutTotal,2));?></span>
                </li>
              </ul>
            </aside>
            <?php } ?>

            <?php if($invoice->module == "cars"){ ?>
            <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
              <a href="#" class="product-small-item">
                <div class="image">
                  <img src="<?php echo $invoice->thumbnail;?>" alt="image">
                </div>
                <div class="content">
                  <div class="content-body">
                    <div class="rating-item rating-sm rating-inline mb-7">
                      <div class="rating-icons">
                        <input type="hidden" class="rating" data-filled="rating-icon ri-star rating-rated"
                          data-empty="rating-icon ri-star-empty" data-fractions="2" data-readonly value="4.5" />
                      </div>
                      <!--<p class="rating-text text-muted font-10">26 reviews</p>-->
                    </div>
                    <h6><?php echo $invoice->title;?> <?php echo $invoice->stars;?></h6>
                    <span class="meta text-muted"><i class="ion-location text-info"></i>
                      <?php echo $invoice->location;?></span>
                  </div>
                  <!--<div class="price">from <span class="text-secondary font700">$895</span> /night</div>-->
                </div>
              </a>
              <hr>
              <h3 class="heading-title"><span><?=lang('039')?></span></h3>
              <hr class="mb-30 mt-30" />
              <ul class="confirmation-list">
                <li class="clearfix">
                  <span class="font-weight-bold"> <?php echo trans('08');?></span>
                  <span><?php echo $invoice->date; ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"> <?php echo trans('0275');?></span>
                  <span><?php echo $invoice->nights; ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('0210')?>:</span>
                  <span><?php echo $invoice->bookedItemInfo->pickupLocation; ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('0211')?>:</span>
                  <span> <?php echo $invoice->bookedItemInfo->dropoffLocation; ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"> <?php echo trans('0210');?> <?php echo trans('08'); ?>:</span>
                  <span> <?php echo $invoice->bookedItemInfo->pickupDate; ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0210');?> <?php echo trans('0259'); ?>:</span>
                  <span> <?php echo $invoice->bookedItemInfo->pickupTime; ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"> <?php echo trans('0211');?> <?php echo trans('08'); ?>:</span>
                  <span> <?php echo $invoice->bookedItemInfo->dropoffDate; ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0211');?> <?php echo trans('0259'); ?>:</span>
                  <span> <?php echo $invoice->bookedItemInfo->dropoffTime; ?></span>
                </li>
                <!--                             <li class="clearfix">
                    <span class="font-weight-bold"><?=lang('09')?>:</span>
                    <span><?php echo $invoice->checkout; ?></span>
                    </li> -->
              </ul>
              <div class="mb-40"></div>
              <h3 class="heading-title"><span>Charge</span></h3>
              <ul class="confirmation-list">

                <?php if(!empty($invoice->bookingExtras)){ ?>
                <?php foreach($invoice->bookingExtras as $extra){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold">
                    <?php echo $extra->title;?>
                    <!--(2)-->:
                  </span>
                  <span><?php 
                      if(!empty($extra->price)) {
                          echo $invoice->currSymbol.$extra->price;
                      }
                      ?></span>
                </li>
                <?php } } ?>
                <?php if($invoice->extraBeds > 0){ ?>
                <li class="clearfix">
                  <span class="font-weight-bold"><?php echo trans('0428');?> <?php echo $invoice->extraBeds; ?>:</span>
                  <span> <?php echo $invoice->currSymbol; ?><?php echo $invoice->extraBedsCharges; ?></span>
                </li>
                <?php } ?>
                <li class="clearfix">
                  <span class="font-weight-bold">
                    <?=lang('0126')?>
                    <!--(2)-->:
                  </span>
                  <span> <?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutAmount,2)); ?></span>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold"><?=lang('0153')?>:</span>
                  <span><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->tax,2));?></span>
                </li>
                <li class="clearfix total">
                  <span class="font-weight-bold"><?=lang('0124')?></span>
                  <span class="text-main text-secondary"><?php echo $invoice->currCode; ?>
                    <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutTotal,2));?></span>
                </li>
              </ul>
            </aside>
            <?php } ?>

            <?php if($invoice->module == "pass"){ ?>
              <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
                <h3 class="heading-title"><span><?=lang('039')?></span></h3>
                <hr class="mb-30 mt-30" />
                <ul class="confirmation-list">
                  <li class="clearfix">
                    <span class="font-weight-bold"> Pass</span>
                    <span><?php echo $item->pass_name; ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold"> Type</span>
                    <span><?php echo ($item->type == 1) ? 'National' : 'InterNational'; ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold"> Category</span>
                    <span><?php echo $item->category_name; ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold"> Price</span>
                    <span><?php echo $curr->symbol . ' ' . str_replace(".00","",number_format($item->ammount,2)); ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold"> Quantity</span>
                    <span><?php echo $item->quantity; ?></span>
                  </li>
                </ul>
                <div class="mb-40"></div>
                <h3 class="heading-title"><span>Charge</span></h3>
                <ul class="confirmation-list">
                  <li class="clearfix">
                    <span class="font-weight-bold">
                      <?=lang('0126')?>
                      <!--(2)-->:
                    </span>
                    <span> <?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutAmount,2)); ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold"><?=lang('0153')?>:</span>
                    <span><?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->tax,2));?></span>
                  </li>
                  <li class="clearfix total">
                    <span class="font-weight-bold"><?=lang('0124')?></span>
                    <span class="text-main text-secondary"><?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($item->total,2));?></span>
                  </li>
                </ul>
              </aside>
              <?php } ?>

              <?php if($invoice->module == "golf_booking"){ ?>
              <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
                <h3 class="heading-title"><span><?=lang('039')?></span></h3>
                <hr class="mb-30 mt-30" />
                <ul class="confirmation-list">
                  <li class="clearfix">
                    <span class="font-weight-bold"> Location</span>
                    <span><?php echo $subitem->golf_location; ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold"> Hole</span>
                    <span><?php echo $subitem->golf_hole; ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold"> Time</span>
                    <span><?php echo $subitem->golf_time; ?></span>
                  </li>
                </ul>
                <div class="mb-40"></div>
                <h3 class="heading-title"><span>Charge</span></h3>
                <ul class="confirmation-list">
                  <li class="clearfix">
                    <span class="font-weight-bold">
                      <?=lang('0126')?>
                      <!--(2)-->:
                    </span>
                    <span> <?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->checkoutAmount,2)); ?></span>
                  </li>
                  <li class="clearfix">
                    <span class="font-weight-bold"><?=lang('0153')?>:</span>
                    <span><?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($invoice->tax,2));?></span>
                  </li>
                  <li class="clearfix total">
                    <span class="font-weight-bold"><?=lang('0124')?></span>
                    <span class="text-main text-secondary"><?php echo $invoice->currCode; ?>
                      <?php echo $invoice->currSymbol; ?><?php echo str_replace(".00","",number_format($item->booking_total,2));?></span>
                  </li>
                </ul>
              </aside>
              <?php } ?>
          </div>

          <div class="col-12 col-lg-8">
            <div class="content-wrapper pt-30 pb-30 bg-white-shadow col-12">
              <h3 class="heading-title"><span><?=lang('0127')?></span></h3>
              <div class="clear"></div>
              <ul class="confirmation-list">
                <li>
                  <span class="font-weight-bold go-right"><?php echo trans("076"); ?>
                    <?php echo trans("0434"); ?></span>
                  <span class="go-left float-right"><?php echo $invoice->id; ?></span>
                  <div class="clear"></div>
                </li>
                <li>
                  <span class="font-weight-bold go-right"><?php echo trans("0398"); ?></span>
                  <span class="go-left float-right"><?php echo $invoice->code; ?></span>
                  <div class="clear"></div>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold go-right">Full Name</span>
                  <span class="go-left float-right"><?php echo $invoice->userFullName; ?></span>
                  <div class="clear"></div>
                </li>
                <li class="clearfix">
                  <span class="font-weight-bold go-right">Email</span>
                  <span class="go-left float-right"><?php echo $invoice->accountEmail; ?></span>
                  <div class="clear"></div>
                </li>
                <li>
                  <span class="font-weight-bold go-right"><?=lang('098')?></span>
                  <span class="go-left float-right"><?php echo $invoice->userAddress; ?></span>
                  <div class="clear"></div>
                </li>
                <li>
                  <span class="font-weight-bold go-right"><?=lang('0173')?></span>
                  <span class="go-left float-right"><?php echo $invoice->userMobile; ?></span>
                  <div class="clear"></div>
                </li>
                <?php $chk = (array)$invoice->guestInfo; $chk1 = reset($chk); ?>
                <?php if(!empty($chk1->name)){ ?>
                <?php foreach($invoice->guestInfo as $guest){ 
                    if(!empty($guest->name)){
                    ?>
                <li>
                  <span class="font-weight-bold go-right"><?php echo trans('0350');?>:</span>
                  <span class="go-left float-right"><?php echo $guest->name;?></span>
                  <div class="clear"></div>
                </li>
                <?php } if(!empty($guest->passportnumber)){?>
                <li>
                  <span class="font-weight-bold go-right"><?php echo trans('0523');?>:</span>
                  <span class="go-left float-right"><?php echo $guest->passportnumber;?></span>
                  <div class="clear"></div>
                </li>
                <?php } if(!empty($guest->age)){ ?>
                <li>
                  <span class="font-weight-bold go-right"><?php echo trans('0524');?>:</span>
                  <span class="go-left float-right"><?php echo $guest->age;?></span>
                  <div class="clear"></div>
                </li>
                <?php } ?>
                <?php }
                    }
                    ?>
              </ul>
              <div class="mb-40"></div>
              <hr>
              <?php if(!empty($invoice->additionaNotes)){ ?>
              <label for=""><?php echo trans('0178');?></label>
              <div class="clear"></div>
              <textarea name="" id="" cols="30" rows="10" class="form-control"
                disabled><?php echo $invoice->additionaNotes;?></textarea>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="row mt-25">
          <div class="col-md-6 o2">
            <h6 class="text-uppercase letter-spacing-2 line-1 font500"><span><?=lang('0293')?></span></h6>
            <div class="clear"></div>
            <ul class="list-icon-data-attr font-ionicons go-right go-text-right">
              <li data-content="&#xf383"><?=lang('0295')?></li>
              <li data-content="&#xf383"><?=lang('0308')?></li>
              <li data-content="&#xf383"><?=lang('0352')?></li>
            </ul>
          </div>
          <div class="col-md-6 o1">
            <div class="featured-contact-01 float-right">
              <h6 class="go-left">
                <small>
                  <p
                    style="font-size: 14px;font-family: tahoma; font-weight: 800; line-height: 0px; color: #002141;    margin-top: 5px;">
                    <?php echo $app_settings[0]->site_title; ?></p>
                  <p style="margin: 0px;"><i class="icon_set_1_icon-41"></i> <?php echo strip_tags($contactaddress); ?>
                  </p>
                  <p style="margin: 0px;"><i class="icon_set_1_icon-84"></i> <?php echo strip_tags($contactemail); ?>
                  </p>
                  <p style="margin: 0px;"><i class="icon_set_1_icon-90"></i> <?php echo strip_tags($phone); ?></p>
                </small>
              </h6>
              <div class="clear"></div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <br><br><br>
    </div>
  </div>
  <!-- end Main Wrapper -->

</html>
<script language="javascript" type="text/javascript">
  // Create invoice snap shot and download as a pdf
  $(document).ready(function () {
    $('#btn').click(function () {
      var container = document.getElementById("invoiceTable");
      html2canvas(container, {
        onrendered: function (snapshot) {
          var tempcanvas = document.createElement('canvas');
          tempcanvas.width = container.clientWidth;
          tempcanvas.height = container.clientHeight;
          var context = tempcanvas.getContext('2d');
          context.drawImage(snapshot, 0, 0);
          var base64ImageString = tempcanvas.toDataURL('image/jpeg');
          // Save as a pdf
          var doc = new jsPDF();
          doc.addImage(base64ImageString, 'JPEG', 5, 20, 200, 250);
          doc.save('invoice_<?php echo $invoice->id; ?>.pdf');
        }
      });
    });

    $('#downloadInvoice').click(function () {
      var container = document.getElementById("invoiceTable");
      html2canvas(container, {
        onrendered: function (snapshot) {
          var tempcanvas = document.createElement('canvas');
          tempcanvas.width = container.clientWidth;
          tempcanvas.height = container.clientHeight;
          var context = tempcanvas.getContext('2d');
          context.drawImage(snapshot, 0, 0);
          var base64ImageString = tempcanvas.toDataURL('image/jpeg');
          // Download image
          var image = base64ImageString.replace("image/png", "application/octet-stream;headers=Content-Disposition: attachment; filename=invoice.png");
          var anchor = document.getElementById('image');
          anchor.href = image;
          anchor.download = 'invoice_' + Date.now() + '.png';
          anchor.click();
        }
      });
    });
  });

  function printDiv() {
    var container = document.getElementById("invoiceTable");
    html2canvas(container, {
      onrendered: function (snapshot) {
        var tempcanvas = document.createElement('canvas');
        tempcanvas.width = container.clientWidth;
        tempcanvas.height = container.clientHeight;
        var context = tempcanvas.getContext('2d');
        context.drawImage(snapshot, 0, 0);
        var base64ImageString = tempcanvas.toDataURL('image/jpeg');
        // Print image
        var oldPage = document.body.innerHTML; //Get the HTML of whole page
        document.body.innerHTML = "<html><head><title></title></head><body><img style='margin:10px 60px' src='" + base64ImageString + "'/></body>";
        setTimeout(function () {
          window.print(); //Print Page
          document.body.innerHTML = oldPage; //Restore orignal HTML
        }, 1000)
      }
    });
  }
</script>
<script type="text/javascript">
  // set the date we're counting down to
  var target_date = new Date('<?php echo $invoice->expiryFullDate; ?>').getTime();
  var target_date = '<?php echo $invoice->expiryUnixtime * 1000; ?>';
  var invoiceStatus = "<?php echo $invoice->status; ?>";

  // variables for time units
  var days, hours, minutes, seconds;

  // get tag element
  var countdown = document.getElementById('countdown');
  var ccc = new Date().getTime();
  if (invoiceStatus == "unpaid") {
    // update the tag with id "countdown" every 1 second
    setInterval(function () {

      // find the amount of "seconds" between now and target
      var current_date = new Date().getTime();
      var seconds_left = (target_date - current_date) / 1000;

      // do some time calculations
      days = parseInt(seconds_left / 86400);
      seconds_left = seconds_left % 86400;
      hours = parseInt(seconds_left / 3600);
      seconds_left = seconds_left % 3600;
      minutes = parseInt(seconds_left / 60);
      seconds = parseInt(seconds_left % 60);

      // format countdown string + set tag value
      countdown.innerHTML = '<span class="days">' + days + ' <b><?php echo trans("0440");?></b></span> <span class="hours">' + hours + ' <b><?php echo trans("0441");?></b></span> <span class="minutes">'
        + minutes + ' <b><?php echo trans("0442");?></b></span> <span class="seconds">' + seconds + ' <b><?php echo trans("0443");?></b></span>';
    }, 1000);
  }

  $(function () {
    $(".submitresult").hide();
    loadPaymethodData();
    $(".arrivalpay").on("click", function () {
      var id = $(this).prop("id");
      var module = $(this).data("module");
      var check = confirm("<?php echo trans('0483')?>");
      if (check) {
        $.post("<?php echo base_url();?>invoice/updatePayOnArrival", { id: id, module: module }, function (resp) {
          location.reload();
        });
      }
    });

    $('#response').on('click', 'input[type="image"],input[type="submit"]', function () {
      setTimeout(function () {

        $("#response").html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
      }, 500)
    });

    $("#gateway").on("change", function () {
      var gateway = $(this).val();
      $("#response").html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
      $.post("<?php echo base_url();?>invoice/getGatewaylink/<?php echo $invoice->id?>/<?php echo $invoice->code;?>", { gateway: gateway }, function (resp) {

        var response = $.parseJSON(resp);
        console.log(response);
        if (response.gateway === 'mollie') {
          console.log(response.htmldata._links.checkout.href);
          window.location.href = response.htmldata._links.checkout.href;
        }
        if (response.gateway === 'paystack') {
          if (response.htmldata.status === 'success') {
            window.location.href = response.htmldata.message;
          }
        } else {
          if (response.iscreditcard == "1") {
            $(".creditcardform").fadeIn("slow");
            $("#creditcardgateway").val(response.gateway);
            $("#response").html("");
          } else {
            $(".creditcardform").hide();
            $("#response").html(response.htmldata);
          }
        }
      });
    })
  });
  function expcheck() {
    $(".submitresult").html("").fadeOut("fast");
    var cardno = $("#card-number").val();
    var firstname = $("#card-holder-firstname").val();
    var lastname = $("#card-holder-lastname").val();
    var minMonth = new Date().getMonth() + 1;
    var minYear = new Date().getFullYear();
    var month = parseInt($("#expiry-month").val(), 10);
    var year = parseInt($("#expiry-year").val(), 10);

    if ($.trim(firstname) == "") {
      $(".submitresult").html("Enter First Name").fadeIn("slow");
      return false;
    } else if ($.trim(lastname) == "") {
      $(".submitresult").html("Enter Last Name").fadeIn("slow");
      return false;
    } else if ($.trim(cardno) == "") {
      $(".submitresult").html("Enter Card number").fadeIn("slow");
      return false;
    } else if (month <= minMonth && year <= minYear) {
      $(".submitresult").html("Invalid Expiration Date").fadeIn("slow");
      return false;

    } else {
      $(".paynowbtn").hide();
      $(".submitresult").removeClass("alert-danger");
      $(".submitresult").html("<div class='matrialprogress'><div class='indeterminate'></div></div>").fadeIn("slow");
    }
  }

  function loadPaymethodData() {
    var gateway = $("#gateway").val();
    var invoiceStatus = "<?php echo $invoice->status; ?>";

    if (invoiceStatus == "unpaid") {
      if (gateway != "") {
        $.post("<?php echo base_url();?>invoice/getGatewaylink/<?php echo $invoice->id?>/<?php echo $invoice->code;?>", { gateway: gateway }, function (resp) {
          var response = $.parseJSON(resp);
          console.log(response);
          if (response.iscreditcard == "1") {
            $(".creditcardform").fadeIn("slow");
            $("#creditcardgateway").val(response.gateway);
            $("#response").html("");
          } else {
            $(".creditcardform").hide();
            $("#response").html(response.htmldata);
          }
        });
      }
    }
  }
</script>
<script src="<?php echo base_url(); ?>themes/default/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/js/scripts.js"></script>