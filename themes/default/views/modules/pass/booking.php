<br><br>
<style>
    body {
        background: #eee
    }

    .nav-tabs>li.active>a,
    .nav-tabs>li.active>a:hover,
    .nav-tabs>li.active>a:focus {
        color: white !important;
        cursor: default;
        background: #76ce85;
    }

    .nav-tabs>li>a {
        background: rgba(0, 0, 0, 0.09);
        border-radius: 0px;
        color: #000 !important;
        padding: 10px;
        font-size: 14px;
    }

    .switch-ios.switch-light {
        margin-top: 5px !important;
    }

    .table_summary td {
        padding-left: 0;
        padding-right: 0;
    }
</style>

<style>
    .btn-circle {
        border-radius: 50%;
        font-size: 54px;
        padding: 10px 20px;
    }
</style>

<?php if($result == "success" && $appModule == "ean"){ ?>

<!-- End Result of Expedia booking for submit -->
<?php  }else{ ?>
<div class="container booking">
    <!-- Start Fail Result of Expedia booking for submit -->
    <?php if($result == "fail" && $appModule == "ean"){ ?>
    <div class="alert alert-danger wow bounce" role="alert">
        <p><?php echo $msg;?></p>
    </div>
    <?php } ?>
    <!-- End Fail Result of Expedia booking for submit -->
    <div class="container offset-0">
        <div class="loadinvoice">
            <div class="acc_section">
                <!-- RIGHT CONTENT -->
                <div class="row">
                    <div class="col-md-8 offset-0 go-right" style="margin-bottom:50px;">
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="result"></div>
                            <?php if(!empty($error)){ ?>
                            <h1 class="text-center strong"><?php echo trans('0432');?></h1>
                            <h3 class="text-center"><?php echo trans('0431');?></h3>
                            <?php }else{ ?>
                            <!-- Start Other Modules Booking left section -->
                            <?php if($appModule != "ean") { ?>
                            <div class="bg-white-shadow pt-25 ph-30 pb-40">
                                <?php include $themeurl.'views/includes/booking/profile.php'; ?>
                            </div>
                            <p class="RTL go-right"><?php echo trans('0416');?></p>
                            <div class="clear"></div>
                            <div class="form-group">
                                <span id="waiting"></span>
                                <button type="submit" class="btn btn-success btn-lg btn-block completebook"
                                    name="<?php if(empty($usersession)){ echo "guest";}else{ echo "logged"; } ?>"
                                    onclick="return completebook('<?php echo base_url();?>','<?php echo trans('0159')?>');"><?php echo trans('0306');?></button>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- Booking Final Starting -->
                    <div class="col-md-12 offset-0 final_section go-right" style="display:none;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="step-pane" id="step4">
                                    <div id="rotatingDiv" class="show"></div>
                                    <h2 class="text-center"><?php echo trans('0179');?></h2>
                                    <p class="text-center"><?php echo trans('0180');?></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <br />
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($appModule == "ean"){ ?>
    <!-- Start JS for Expedia -->
    <script type="text/javascript">
        $(function () { $(".submitresult").hide() })
        function expcheck() {
            $(".submitresult").html("").fadeOut("fast"); var cardno = $("#card-number").val(); var cardtype = $("#cardtype").val(); var email = $("#card-holder-email").val(); var country = $("#country").val(); var cvv = $("#cvv").val(); var city = $("#card-holder-city").val(); var state = $("#card-holder-state").val(); var postalcode = $("#card-holder-postalcode").val(); var firstname = $("#card-holder-firstname").val(); var lastname = $("#card-holder-lastname").val(); var policy = $("#policy").val(); var minMonth = new Date().getMonth() + 1; var minYear = new Date().getFullYear(); var month = parseInt($("#expiry-month").val(), 10); var year = parseInt($("#expiry-year").val(), 10); if (country == "US") { if ($.trim(postalcode) == "") { $(".submitresult").html("Enter Postal Code").fadeIn("slow"); return !1 } else if ($.trim(state) == "") { $(".submitresult").html("Enter State").fadeIn("slow"); return !1 } }
            if ($.trim(firstname) == "") { $(".submitresult").html("Enter First Name").fadeIn("slow"); return !1 } else if ($.trim(lastname) == "") { $(".submitresult").html("Enter Last Name").fadeIn("slow"); return !1 } else if ($.trim(cardno) == "") { $(".submitresult").html("Enter Card number").fadeIn("slow"); return !1 } else if ($.trim(cardtype) == "") { $(".submitresult").html("Select Card Type").fadeIn("slow"); return !1 } else if (month <= minMonth && year <= minYear) { $(".submitresult").html("Invalid Expiration Date").fadeIn("slow"); return !1 } else if ($.trim(cvv) == "") { $(".submitresult").html("Enter Security Code").fadeIn("slow"); return !1 } else if ($.trim(country) == "") { $(".submitresult").html("Select Country").fadeIn("slow"); return !1 } else if ($.trim(city) == "") { $(".submitresult").html("Enter City").fadeIn("slow"); return !1 } else if ($.trim(email) == "") { $(".submitresult").html("Enter Email").fadeIn("slow"); return !1 } else if (!$('#policy').is(':checked')) { $(".submitresult").html("Please Accept Cancellation Policy").fadeIn("slow"); return !1 } else { $(".paynowbtn").hide(); $(".submitresult").removeClass("alert-danger"); $(".submitresult").html("<div id='rotatingDiv'></div>").fadeIn("slow") }
        }
        function isNumeric(evt) {
            var e = evt || window.event; var charCode = e.which || e.keyCode; if (charCode > 31 && (charCode < 47 || charCode > 57))
                return !1; if (e.shiftKey) return !1; return !0
        }
    </script>
    <!-- End JS for Expedia -->
    <?php }?>
    <style>
        #rotatingImg {
            display: none;
        }

        .booking-bg {
            padding: 10px 0 5px 0;
            width: 100%;
            background-image: url('<?php echo $theme_url; ?>assets/images/step-bg.png');
            background-color: #222;
            text-align: center;
        }

        .bookingFlow__message {
            color: white;
            font-size: 18px;
            margin-top: 5px;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .select2-choice {
            font-size: 13px !important;
            padding: 0 0 0 10px !important;
        }
    </style>

    <div class="clearfix"></div>