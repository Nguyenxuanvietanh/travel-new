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
        <form autocomplete="off" action="<?php echo base_url()?>tours/search_golf_booking" method="get" role="search">
            <div class="form-inner">
                <div class="row gap-10 mb-20 row-reverse">
                    <div class="col-lg-2 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0120')?></label>
                            <div class="clear"></div>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                        <input type="text" data-module="<?php echo $module; ?>" class="form-control hotelsearch locationlist_gk<?php echo $module; ?>" placeholder="<?php if ($module == 'hotels') { echo trans('026'); } elseif ($module == 'tours') { echo trans('0526'); } ?>" value="<?php echo $toursearch['ToursSearchForm']->from_code; ?>" required>
                        <input type="hidden" id="txtsearch_gk" name="txtsearch" value="<?php echo $toursearch['ToursSearchForm']->from_code; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xs-12">
                        <div class="form-group">
                            <label>Location</label>
                            <div class="clear"></div>
                         <div class="form-icon-left">
                                    <select class="form-control" name="location" id="location_id" required>
                                                <option value="" selected>
                                                    Select
                                                </option>
                                                <?php foreach ($data['defaultGolfBookingListForSearchField']['locations']['children'] as $location) { ?>
                                                    <option value="<?php echo $location->id; ?>">
                                                        <?php echo $location->location; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xs-12">
                        <div class="form-group">
                            <label>Holes</label>
                            <div class="clear"></div>
                         <div class="form-icon-left">
                                            <select class="form-control" name="hole_id" id="hole_id" required>
                                                <option value="" selected>
                                                    Select
                                                </option>
                                                <?php foreach ($data['defaultGolfBookingListForSearchField']['holes']['children'] as $hole) { ?>
                                                    <option value="<?php echo $hole->id; ?>">
                                                        <?php echo $hole->hole; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                        </div>
                    </div>
                    <!--Starting Date-->
                    <div class="col-lg-1 col-xs-12">
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


                    <div class="col-lg-2 col-xs-12">
                        <div class="form-group">
                            <label>Time</label>
                            <div class="clear"></div>
                         <div class="form-icon-left">
                                            <select class="form-control" name="time_id" id="time_id" required>
                                                <option value="" selected>
                                                    Select
                                                </option>
                                               <?php foreach ($data['defaultGolfBookingListForSearchField']['times']['children'] as $time) { ?>
                                                    <option value="<?php echo $time->id; ?>">
                                                        <?php echo $time->time; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xs-12">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount">Player</label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="1" value="1" name="finfant" readonly required />
                                        </div>
                                    </div>
                                </div>
                    <div class="col-lg-1 col-xs-12">
                        <input type="hidden" name="module_type"/>
                        <input type="hidden" value="<?=!empty($location) ? $location : "" ?>" name="slug"/>
                        <button type="submit"  class="btn btn-primary btn-block"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="searching" class="searching_gk" value="<?php echo $_GET['searching']; ?>">
            <input type="hidden" class="modType_gk" name="modType" value="<?php echo $_GET['modType']; ?>">
            
        </form>
    </div>
</div>
  <script>
        $(function () {
            $(".locationlist_gk<?php echo $module; ?>").select2({
                width: '100%',
                allowClear: true,
                maximumSelectionSize: 1,
                placeholder: "Start typing",
                data: JSON.parse('<?=$data['defaultGolfToursListForSearchField']?>'),
                initSelection: function (element, callback) {
                callback({id: 1, text: '<?=(!empty($toursearch['ToursSearchForm']->from_code))? $toursearch['ToursSearchForm']->from_code :lang('0526'); ?>'})
            }
            });

            $(".locationlist_gk<?php echo $module; ?>").on("select2-open",
                function (e) {
                    $(".select2-drop-mask");
                    $(".formSection").trigger("click")
                });
            $(".locationlist_gk<?php echo $module; ?>").on("select2-selecting", function (e) {
                $(".modType_gk").val(e.object.module);
                $(".searching_gk").val(e.object.id);
                $("#txtsearch_gk").val(e.object.text);
            })
        })
    </script>

<!------------------------------------------------------------------->
<!-- ********************    TOURS MODULE    ********************  -->
<!------------------------------------------------------------------->