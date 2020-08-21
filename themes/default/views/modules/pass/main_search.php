<style>
    .form-control {
        overflow: hidden;
        -webkit-appearance: none;
    }
</style>
<div class="ftab-inner menu-horizontal-content">
    <div class="form-search-main-01">
        <form autocomplete="off" action="<?php echo base_url($module.'/search'); ?>" method="GET" role="search">
            <div class="form-inner">
                <div class="row gap-10 mb-20 row-reverse">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label>Name</label>
                            <div class="clear"></div>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"></span>
                                <input placeholder="Search by pass name" type="text" name="name" class="form-control passlist<?php echo $module; ?>">
                                <input type="hidden" name="id_pass" class="id_pass">
                            </div>
                        </div>
                    </div>
<!--                    <div class="col-lg-2 col-xs-12">-->
<!--                        <div class="form-group">-->
<!--                            <label>Price</label>-->
<!--                            <div class="clear"></div>-->
<!--                            <div class="form-icon-left typeahead__container">-->
<!--                                <span class="icon-font "</i></span>-->
<!--                                <input type="number" name="ammount" class="form-control">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="col-lg-3 col-xs-12">
                        <div class="col-inner">
                            <div class="row gap-10 mb-15">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="room-amount">Type</label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <select class="chosen-the-basic form-control" name="type" id="type">
                                                <option value="" selected>
                                                    <?php echo trans('0158'); ?>
                                                </option>
                                                <option value="0">
                                                    National
                                                </option>
                                                <option value="1">
                                                    International
                                                </option>
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
                                        <label for="room-amount">Category</label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <select class="chosen-the-basic form-control" name="category_id" id="category_id">
                                                <option value="" selected>
                                                    <?php echo trans('0158'); ?>
                                                </option>
                                                <?php foreach ($data['moduleTypesPass'] as $ttype) { ?>
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
                        <button type="submit"  class="btn btn-primary btn-block"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
            // let p_3 = data['ammount'];
            // p_3 = (p_3) ? p_3 : 0;
            let p_4 = data['type'];
            p_4 = (p_4) ? p_4 : 0;
            let p_5 = data['category_id'];
            p_5 = (p_5) ? p_5 : "null";
            let url = "";
            return url + "/" + p_1 + "/" + p_4 + "/" + p_5;
        }
    });

</script>
 <script>
        $(function () {
            $(".passlist<?php echo $module; ?>").select2({
                width: '100%',
                allowClear: true,
                maximumSelectionSize: 1,
                placeholder: "Start typing",
                data: JSON.parse('<?=$data['modulePassList']?>'),
                initSelection: function (element, callback) {
                callback({id: 1, text: 'Search by pass name'})
            }
            });

            $(".passlist<?php echo $module; ?>").on("select2-open",
                function (e) {
                });
            $(".passlist<?php echo $module; ?>").on("select2-selecting", function (e) {
                $(".id_pass").val(e.object.id);
            })
        })
    </script>