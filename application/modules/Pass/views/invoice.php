<div class="main-wrapper scrollspy-action">
    <div class="page-wrapper page-confirmation bg-light">
        <div class="container">
            <style>
                .chosen-single {
                    height: 3.5rem !important;
                    padding-top: 12px !important;
                    font-size: 1rem !important;
                }

                .chosen-container-single .chosen-single div {
                    top: 6px !important;
                }

                .active-result {
                    font-size: 1rem;
                }

                #response input[value="Pay Now"],
                #showPaymentPage {
                    transition: all .3s;
                    text-transform: uppercase;
                    font-size: 13px;
                    font-weight: 500;
                    padding-top: 9px;
                    padding-bottom: 7px;
                    border-radius: 3px;
                    background: #3F51B5;
                    border-color: #3F51B5;
                    color: #FFF;
                }
            </style>
            <div class="row gap-30 equal-height">
                <div class="col-12 col-lg-4 order-lg-last">
                    <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
                        <a href="#" class="product-small-item">
                            <h4 style="text-align: center"><?php echo $order->pass_name; ?></h4>
                        </a>
                        <hr>
                        <h3 class="heading-title"><span>Summary</span></h3>
                        <hr class="mb-30 mt-30">
                        <ul class="confirmation-list">
                            <li class="clearfix">
                                <span class="font-weight-bold">Total:</span>
                                <span><?php echo $curr->code . ' ' . $curr->symbol . ' ' . $order->ammount; ?></span>
                            </li>
                        </ul>
                        <div class="mb-40"></div>
                    </aside>


                </div>

                <div class="col-12 col-lg-8">
                    <div class="content-wrapper pt-30 pb-30 bg-white-shadow col-12">
                        <h3 class="heading-title"><span>Booking Details</span></h3>
                        <div class="clear"></div>
                        <ul class="confirmation-list">
                            <li>
                                <span class="font-weight-bold go-right">Booking Number</span>
                                <span class="go-left float-right"><?php echo $order->id; ?></span>
                                <div class="clear"></div>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold go-right">First Name</span>
                                <span class="go-left float-right"><?php echo $order->fullname; ?></span>
                                <div class="clear"></div>
                            </li>
                            <li class="clearfix">
                                <span class="font-weight-bold go-right">Email</span>
                                <span class="go-left float-right"><?php echo $order->email; ?></span>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <span class="font-weight-bold go-right">Address</span>
                                <span class="go-left float-right"><?php echo $order->address; ?></span>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <span class="font-weight-bold go-right">Mobile Number</span>
                                <span class="go-left float-right"><?php echo $order->phone; ?></span>
                                <div class="clear"></div>
                            </li>
                        </ul>
                        <div class="mb-40"></div>
                        <hr>

                    </div>
                </div>
            </div>
            <div class="row mt-25">
                <div class="col-md-6 o2">
                    <h6 class="text-uppercase letter-spacing-2 line-1 font500"><span>Why Book With Us?</span></h6>
                    <div class="clear"></div>
                    <ul class="list-icon-data-attr font-ionicons go-right go-text-right">
                        <li data-content="">100% Secured payments</li>
                        <li data-content="">Book online or call us anyone</li>
                        <li data-content="">We aim to provide the lowest rates possible </li>
                    </ul>
                </div>
                <div class="col-md-6 o1">
                    <div class="featured-contact-01 float-right">
                        <h6 class="go-left">
                            <small>
                                <p
                                    style="font-size: 14px;font-family: tahoma; font-weight: 800; line-height: 0px; color: #002141;    margin-top: 5px;">
                                    travel</p>
                                <p style="margin: 0px;"><i class="icon_set_1_icon-41"></i> 1355 Market St, Suite 900
                                    San Francisco, United States
                                </p>
                                <p style="margin: 0px;"><i class="icon_set_1_icon-84"></i> info@travelagency.com</p>
                                <p style="margin: 0px;"><i class="icon_set_1_icon-90"></i> +1-234-56789</p>
                            </small>
                        </h6>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <!--<div class="text-center">
          <div id="editor"></div>
          <input type="button" class="btn btn-success" value="Print" onclick="printDiv()"/>
          <button id="downloadInvoice" class="btn btn-default">Download Invoice</button>
          <a href="#" id="image"></a>
          <a href="javascript:void()" id="btn" class="btn btn-primary">Download PDF</a>
        </div>-->
        <br><br><br>
    </div>
</div>