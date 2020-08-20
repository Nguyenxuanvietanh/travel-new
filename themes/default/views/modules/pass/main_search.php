<style>
    .form-control {
        overflow: hidden;
        -webkit-appearance: none;
    }
</style>
<div class="ftab-inner menu-horizontal-content">
    <div class="form-search-main-01">
        <form name="fCustomPassSearch" autocomplete="off" action="<?php echo base_url() . $module; ?>/search"
              method="GET" role="search">
            <div class="form-inner">
                <div class="col-lg-3 col-xs-12" id="name">
                    <div class="form-group">
                        <label> Pass name</label>
                        <div class="clear"></div>
                        <div class="form-icon-left typeahead__container">
                            <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                            <input type="text" placeholder="Search pass by name" name="name"
                                   class="form-control hotelsearch locationlist<?php echo $module; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-12" id="ammount">
                    <div class="form-group">
                        <label>Amount</label>
                        <div class="clear"></div>
                        <div class="form-icon-left typeahead__container">
                            <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                            <input type="number" placeholder="Amount" name="ammount" class="form-control hotelsearch">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-12">
                    <div class="col-inner">
                        <div class="row gap-10 mb-15">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="room-amount">Types</label>
                                    <div class="clear"></div>
                                    <div class="form-icon-left">
                                        <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                        <select class="chosen-the-basic form-control" name="type" id="tourtype">
                                            <option value="0" selected>National</option>
                                            <option value="1" selected>International</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-12">
                    <div class="col-inner">
                        <div class="row gap-10 mb-15">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="room-amount">Types</label>
                                    <div class="clear"></div>
                                    <div class="form-icon-left">
                                        <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                        <select class="chosen-the-basic form-control" name="type" id="tourtype">
                                            <option value="0" selected>National</option>
                                            <option value="1" selected>International</option>
                                        </select>
                                        <select class="ichosen-the-basic form-control" name="category_id" id="category_id">
                                            <option value="" selected>
                                                <?php echo trans('0158'); ?>
                                            </option>
                                            <?php foreach ($data['moduleTypes'] as $ttype) { ?>
                                                <option value="<?php echo $ttype->id; ?>">
                                                    <?php echo $ttype->name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-xs-12">
                    <div class="row">
                        <!--<label class="hidden-xs go-right"><?php echo trans('0222'); ?> </label>-->
                        <div class="clearfix"></div>
                        <i class="iconspane-lg icon_set_1_icon-8"></i>
                        <select class="input-lg form selectx" name="category_id" id="category_id">
                            <option value="" selected>
                                <?php echo trans('0158'); ?>
                            </option>
                            <?php foreach ($data['moduleTypes'] as $ttype) { ?>
                                <option value="<?php echo $ttype->id; ?>" <?php makeSelected($pass_category, $ttype->id); ?> >
                                    <?php echo $ttype->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-xs-12">
                    <input type="hidden" name="module_type"/>
                    <input type="hidden" name="slug"/>
                    <button type="submit" class="btn btn-primary btn-block"><i
                                class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
                </div>
            </div>
        </form>
    </div>
    <input type="hidden" name="searching" class="searching" value="<?php echo $_GET['searching']; ?>">
    <input type="hidden" class="modType" name="modType" value="<?php echo $_GET['modType']; ?>">
</div>
<script>
    $(document).ready(function () {
        let fCustomPassSearch = $("form[name=fCustomPassSearch]");
        fCustomPassSearch.on("submit", function (e) {
            e.preventDefault();
            let values = {};
            $.each($(this).serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            console.log($(this).attr('action') + create_slug(values));
            window.location.href = $(this).attr('action') + create_slug(values);
        });
        function create_slug(data) {
            let p_1 = data['name'];
            p_1 = (p_1) ? p_1 : "null";
            let p_3 = data['ammount'];
            p_3 = (p_3) ? p_3 : 0;
            let p_4 = data['type'];
            p_4 = (p_4) ? p_4 : 0;
            let p_5 = data['category_id'];
            p_5 = (p_5) ? p_5 : "null";
            let url = "";
            return url + "/" + p_1 + "/" + p_3 + "/" + p_4 +"/" + p_5 +;
        }
    });
</script>
<!------------------------------------------------------------------->
<!-- ********************    TOURS MODULE    ********************  -->
<!------------------------------------------------------------------->