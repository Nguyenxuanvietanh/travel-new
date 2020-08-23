<style>
    @media(min-width:992px) {
        .header-waypoint-sticky.header-main {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99999
        }
    }

    .amint-text {
        display: inline-block;
        transform: translateY(-10px)
    }

    .form-icon-left {
        display: flex
    }

    .form-icon-left>label {
        flex: 2
    }

    .form-icon-left>select {
        flex: 2
    }

    .collapse .card-body {
        margin-bottom: 10px
    }

    .table-condensed>tbody>tr>td {
        padding: 5px
    }

    .section-title h3 {
        font-family: inherit !important
    }

    .header-main .header-nav {
        box-shadow: none !important
    }

    .panel-heading {
        padding: 11px 18px;
        background-color: #f8f8f8;
        border-bottom: 1px solid #e7e7e7;
        font-size: 14px;
        color: #000;
        border-top-right-radius: 3px;
        border-top-left-radius: 3px;
        text-transform: uppercase;
        letter-spacing: 2px
    }

    .tchkin {
        height: calc(2.7em+.75rem+2px);
        margin-top: 20px !important
    }

    ul.booking-amount-list:before {
        content: ''
    }

    ul.booking-amount-list li {
        width: 100%;
        float: none
    }

    .tour-child h6,
    .tour-child select,
    .tour-child .childPrice {
        flex: 0 0 33%;
        margin-right: 0 !important;
        letter-spacing: 0 !important;
        width: 33% !important
    }

    .tour-child select,
    .tour-infant select,
    .adult-Price select {
        transform: translateX(10px)
    }

    .tour-child .childPrice {
        display: flex !important;
        justify-content: flex-end
    }

    .tour-infant h6,
    .tour-infant select,
    .tour-infant .infantPrice {
        flex: 0 0 33%;
        margin-right: 1px !important;
        letter-spacing: 0 !important;
        width: 33% !important
    }

    .tour-infant .infantPrice {
        display: flex !important;
        justify-content: flex-end
    }

    .adult-Price h6,
    .adult-Price select,
    .adult-Price .adultPrice {
        flex: 0 0 33%;
        margin-right: 1px !important;
        letter-spacing: 0 !important;
        width: 33% !important
    }

    .adultPrice {
        display: flex !important;
        justify-content: flex-end
    }
</style>
<div class="main-wrapper scrollspy-action">
    <div class="page-wrapper page-detail bg-light">
        <div class="detail-header">
            <div class="container">
                <div class="d-flex flex-column flex-lg-row sb">
                    <?php if($appModule != "offers"){ ?>
                    <div class="o2">
                        <h2 id="detail-content-sticky-nav-00" class="name">
                            <?php echo character_limiter($module->name, 50);?></h2>

                        <div class="star-rating-wrapper">
                            <div class="rating-item rating-inline">
                                <div class="rating-icons">
                                    <input type="hidden" class="rating" data-filled="rating-icon fas fa-star rating-rated" data-empty="rating-icon far fa-star" data-fractions="2" data-readonly value="5"/>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($module->discount)): ?>
                        <div class="discount"><?= $module->discount; ?> % <?=lang('0118')?></div>
                        <?php endif ?>
                        <div class="clear"></div>
                    </div>
                    <?php } ?>
                    <div class="ml-lg-auto text-left text-lg-right mt-20 mt-lg-0 o1">
                        <?php  if($item->price > 0){ ?>
                        <div class="price">
                            <span
                                class="text-secondary"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                        </div>
                        <?php } ?>
                        <a href="#detail-content-sticky-nav-01" class="anchor btn btn-primary btn-wide mt-5">
                            <?php echo trans('046');?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <span id="detail-content-sticky-nav-00" class="d-block"></span>
        <div class="fullwidth-horizon-sticky d-none d-lg-block">
            <div class="fullwidth-horizon-sticky-inner">
                <div class="container">
                    <div class="fullwidth-horizon-sticky-item clearfix">
                        <ul id="horizon-sticky-nav" class="horizon-sticky-nav clearfix">
                            <li>
                                <a href="#detail-content-sticky-nav-01"><?php echo trans('0248');?></a>
                            </li>
                            <li>
                                <a href="#detail-content-sticky-nav-05"><?php echo trans('040');?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="change-search" class="collapse mt-30">
                <div class="change-search-wrapper">
                    <div class="row gap-10 gap-xl-20 align-items-end">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <?php echo searchForm($appModule, $data); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row gap-30">
                <div class="col-12 col-lg-4 col-xl-3 order-lg-last">
                    <aside class="sticky-kit sidebar-wrapper">
                        <!--<button class="btn btn-secondary btn-wide btn-toggle collapsed btn-block btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>-->
                        <div class="booking-selection-box">
                            <div class="heading clearfix">
                                <div class="d-flex align-items-end fe">
                                    <div>
                                        <h5 class="text-white font-serif font400"><?php echo trans('0463'); ?></h5>
                                    </div>
                                    <!--<div class="ml-auto">
                                      <a href="#" class="booking-selection-filter">reset</a>
                                      </div>-->
                                </div>
                            </div>
                            <form action="/pass/booking" method="POST">
                                <div class="content">
                                    <form
                                        action="<?php echo base_url().$appModule;?>/book/<?php echo $module->bookingSlug;?>"
                                        method="GET" role="search" style="width: 100%">
                                        <input type="hidden" name="id" value="<?php echo $module->id;?>">
                                        <div class="hotel-room-sm-item">
                                            <div class="the-room-item">
                                                <div class="d-flex align-items-center adult-Price">
                                                    <h6>Quantity: </h6>
                                                    <input type="number" min="1" max="99" value="1"
                                                        style="min-width:50px;height: 35px !important;min-height: 35px !important;"
                                                        name="quantity" class="changeInfo input-sm form-control"
                                                        id="quantity">
                                                    </input>
                                                    <span class="price adultPrice" <strong><?php echo $curr->symbol;?>
                                                        </strong><b class="money"><?php echo $module->ammount;?></b>
                                                    </span>
                                                </div>
                                                <!--  <a href="#" class="remove"><i class="fa fa-times"></i></a> -->
                                            </div>
                                        </div>
                                        <?php if(!empty($modulelib->error)){ ?>
                                        <div class="alert alert-danger go-text-right">
                                            <?php echo trans($modulelib->errorCode); ?>
                                        </div>
                                        <?php } ?>
                                        <div class="hotel-room-sm-item">
                                        </div>
                                        <div class="hotel-room-sm-item">
                                            <div class="the-hotel-item">
                                                <h4 class="well well-sm text-center strong"
                                                    style="margin-top: 4px; line-height: 20px;">
                                                    <?php echo trans('0334'); ?> <span style="color:#333333;"
                                                        class="totalCost"><?php echo $module->currCode;?>
                                                        <?php echo $module->currSymbol;?><strong><?php echo $module->totalCost;?></strong></span>

                                                </h4>
                                                <div class="clear"></div>
                                                <h5 class="text-center">
                                                    <span style="color:red;"
                                                        class="totalCost"><?php echo $curr->symbol;?></span>
                                                    <span class="total-money"><?php echo $module->ammount;?></span>
                                                </h5>
                                            </div>
                                        </div>
                                        <button style="height: 59px; margin: 3px;" type="submit"
                                            class="btn btn-secondary btn-block mt-20 btn-action btn-lg loader"><?php echo trans('0142');?></button>
                                </div>
                            </form>
                        </div>
                        </form>
                    </aside>
                </div>
                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="content-wrapper">
                        <?php include $themeurl.'views/includes/copyURL.php';?>
                        <div id="detail-content-sticky-nav-001" class="fullwidth-horizon-sticky-section tour-over">
                            <h3 class="heading-title"><span>Note</span></h3>
                            <div class="clear"></div>
                            <?php echo $module->html_note; ?>
                            <hr>
                        </div>
                        <div id="detail-content-sticky-nav-01" class="fullwidth-horizon-sticky-section tour-over">
                            <h3 class="heading-title"><span><?php echo trans('0248'); ?></span></h3>
                            <p><?php echo $module->name; ?></p>
                            <p>Price: <?php echo $curr->symbol . ' ' . $module->ammount; ?></p>
                            <p>Type: <?php echo ($module->type) ? 'International' : 'National'; ?></p>
                            <p>Category: <?php echo $module->category_name; ?></p>
                            <p>Note: <?php echo $module->note; ?></p>
                            <hr>
                        </div>
                        <div class="clear"></div>
                        <div id="detail-content-sticky-nav-05" class="fullwidth-horizon-sticky-section">
                            <h3 class="heading-title"><span>Privacy Policy</span></h3>
                            <div class="clear"></div>
                            <div class="feature-box-2 mb-0 bg-white">
                                <div class="feature-row">
                                    <div class="row gap-10 gap-md-30">
                                        <div class="col-xs-12 col-sm-4 col-md-3 o2">
                                            <h6>Privacy Policy</h6>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="col-xs-12 col-sm-8 col-md-9 o1">
                                            <p>Pass policy</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="feature-row">
                                    <div class="row gap-10 gap-md-30">
                                        <div class="col-xs-12 col-sm-4 col-md-3 o2">
                                            <h6>Payment Types</h6>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="col-xs-12 col-sm-8 col-md-9 o1">
                                            <p> Credit Card -
                                                American Express -
                                                Master/ Visa Card -
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    </section>
                    <script>
                        $("[name^=rooms").on('click', function () {
                            if ($('[name="rooms[]"]:checked').length > 0) {
                                $('[type=submit]').prop('disabled', false);
                            } else {
                                $('[type=submit]').prop('disabled', true);
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fullwidth-horizon-sticky border-0">&#032;</div>
<!-- is used to stop the above stick menu -->
</div>
</div>
<?php if(!empty($module->relatedItems)){ ?>
<section class="bg-white section-sm">
    <div class="container">
        <div class="section-title mb-25">
            <h3><?= trans('0636'); ?></h3>
            <div class="clear"></div>
        </div>
        <div class="row equal-height cols-1 cols-sm-2 cols-lg-3 gap-10 gap-lg-20 gap-xl-30">
            <?php foreach($module->relatedItems as $item){ ?>
            <div class="col">
                <div class="product-grid-item">
                    <a href="<?php echo $item->slug;?>">
                        <div class="image">
                            <img src="<?php echo $item->thumbnail;?>" alt="Image">
                        </div>
                        <div class="content clearfix">
                            <div class="rating-item rating-sm go-text-right">
                                <div class="rating-icons">
                                    <?php echo $item->stars;?>
                                </div>
                                <!-- <p class="rating-text text-muted"><span class="bg-primary">9.3</span> <strong class="text-dark">Fabulous</strong> - 367 reviews</p> -->
                            </div>
                            <div class="short-info">
                                <h5 class="RTL"><?php echo character_limiter($item->title,25);?></h5>
                                <div class="clear"></div>
                                <p class="location go-text-right"><i class="fas fa-map-marker-alt text-primary"></i>
                                    <?php echo character_limiter($item->location,20);?></p>

                                <?php if($item->price > 0){ ?>
                                <div class="mt-10">
                                    <?php echo trans( '0368');?>
                                    <span
                                        class="text-secondary"><strong><?php echo $item->currSymbol; ?><?php echo $item->price;?></strong></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>
</div>

<input type="hidden" id="loggedin" value="<?php echo $usersession;?>" />
<input type="hidden" id="itemid" value="<?php echo $module->id; ?>" />
<input type="hidden" id="module" value="<?php echo $appModule;?>" />
<input type="hidden" id="addtxt" value="<?php echo trans('029');?>" />
<input type="hidden" id="removetxt" value="<?php echo trans('028');?>" />

<script>

    function show_model(package_id) {
        var package = getPackage(package_id, JSON.parse('<?=json_encode($packages)?>'));
        $("#packages_modal").modal('show');
        $("#package_id").val(package_id)
    }
    function getPackage(id, array) {
        for (var i = 0; i < array.length; i++) {
            if (array[i].id == id) {
                return array[i];
            }
        }
    }

    $(".changeInfo").on("change", function () {
        var quantity = $(this).val();
        var total = quantity * parseInt('<?php echo $module->ammount; ?>');
        $('.price.adultPrice b.money').html(total)
        $('span.total-money').html(total)
        console.log(total)
    }); //end of change info

    //------------------------------
    // Write Reviews
    //------------------------------

    $('.reviewscore').change(function () {
        var sum = 0;
        var avg = 0;
        var id = $(this).attr("id");
        $('.reviewscore_' + id + ' :selected').each(function () {
            sum += Number($(this).val());
        });
        avg = sum / 5;
        $("#avgall_" + id).html(avg);
        $("#overall_" + id).val(avg);
    });

    $("#send_enquery").submit(function (e) {
        e.preventDefault();
        $("#ClickMyButton").attr("disabled", true);
        $.ajax({
            url: '<?=base_url('boats/ do_boats_guest_booking')?>',
            type: 'post',
            data: $('#send_enquery').serialize(),
            success: function (data) {
                window.location.href = data + "";
            }
        });
    });

    $('.collapse').on('show.bs.collapse', function () {
        $('.collapse.in').collapse('hide');
    });
</script>