<?php 
//dd($toursearch['ToursSearchForm']->from_code);?>

<style>
    .form-control{
        overflow:hidden;
        -webkit-appearance:none;
    }
</style>
<?php $ci = get_instance();
$location = $ci->session->userdata('Viator_location');
$start_date = $ci->session->userdata('Viator_startdate');
$end_date = $ci->session->userdata('Viator_endDate');
$Viator_country = $ci->session->userdata('Viator_country');

?>
<div class="ftab-inner menu-horizontal-content">
    <div class="form-search-main-01 tour-search">
        <form autocomplete="off" action="<?php echo base_url()?>packages/search" method="get" role="search">
            <div class="form-inner">
                <div class="row gap-10 mb-20 row-reverse">
                    <div class="col-lg-2 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0120')?></label>
                            <div class="clear"></div>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <!-- id = textsearch is used to get data in jquery script -->
                                <input type="text" name="location" id="textsearch" class="form-control viatorsearch"   required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xs-12">
                        <div class="form-group">
                            <label>Location</label>
                            <div class="clear"></div>
                         <div class="form-icon-left">
                                            <select class="chosen-the-basic form-control" name="category_id" id="category_id">
                                                <option value="" selected>
                                                    Select
                                                </option>
                                               <!--  <?php foreach ($data['moduleTypesPass'] as $ttype) { ?>
                                                    <option value="<?php echo $ttype->id; ?>">
                                                        <?php echo $ttype->name; ?>
                                                    </option>
                                                <?php } ?> -->
                                            </select>
                                        </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xs-12">
                        <div class="form-group">
                            <label>Holes</label>
                            <div class="clear"></div>
                         <div class="form-icon-left">
                                            <select class="chosen-the-basic form-control" name="category_id" id="category_id">
                                                <option value="" selected>
                                                    Select
                                                </option>
                                               <!--  <?php foreach ($data['moduleTypesPass'] as $ttype) { ?>
                                                    <option value="<?php echo $ttype->id; ?>">
                                                        <?php echo $ttype->name; ?>
                                                    </option>
                                                <?php } ?> -->
                                            </select>
                                        </div>
                        </div>
                    </div>
                    <!--Starting Date-->
                    <div class="col-lg-2 col-xs-12">
                        <div class="col-inner">
                            <div class="row gap-10 mb-15">
                                <div class="col-md-12">
                                    <div class="col-inner">
                                        <div class="form-people-thread">
                                            <div class="row gap-5 align-items-center">
                                                <div id="airDatepickerRange-hotel" class="col">
                                                    <div class="form-group form-spin-group">
                                                        <label for="room-amount" class="text-left">Date</label>
                                                        <div class="clear"></div>
                                                        <div class="form-icon-left">
                                                            <span class="icon-font text-muted" style="margin-left:12px"><i class="bx bx-calendar"></i></span>
                                                            <input type="text" id="DateTours" class="DateTours form-control form-readonly-control" placeholder="dd/mm/yyyy" value="<?=!empty($start_date) ? $start_date : "" ?>" name="startDate" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-1 col-xs-12">
                        <div class="form-group">
                            <label>Time</label>
                            <div class="clear"></div>
                         <div class="form-icon-left">
                                            <select class="chosen-the-basic form-control" name="category_id" id="category_id">
                                                <option value="" selected>
                                                    Select
                                                </option>
                                               <!--  <?php foreach ($data['moduleTypesPass'] as $ttype) { ?>
                                                    <option value="<?php echo $ttype->id; ?>">
                                                        <?php echo $ttype->name; ?>
                                                    </option>
                                                <?php } ?> -->
                                            </select>
                                        </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-xs-12">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount">Player</label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="finfant" readonly />
                                        </div>
                                    </div>
                                </div>
                    <div class="col-lg-2 col-xs-12">
                        <input type="hidden" name="module_type"/>
                        <input type="hidden" value="<?=!empty($location) ? $location : "" ?>" name="slug"/>
                        <button type="submit"  class="btn btn-primary btn-block"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="searching" class="searching" value="<?php echo $_GET['searching']; ?>">
            <input type="hidden" class="modType" name="modType" value="<?php echo $_GET['modType']; ?>">
            
        </form>
    </div>
</div>

<!------------------------------------------------------------------->
<!-- ********************    TOURS MODULE    ********************  -->
<!------------------------------------------------------------------->