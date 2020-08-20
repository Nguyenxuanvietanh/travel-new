<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
  <section class="page-wrapper bg-light-primary">
    <div class="container">
        <div id="change-search" class="collapse">
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
      <div class="row gap-20 gap-md-30 gap-xl-40">
        <div class="col-12 col-lg-3">
          <aside class="sidebar-wrapper filter-wrapper mb-10 mb-md-0">
          <form name="fFilters" action="<?php echo base_url().$appModule;?>/search" method="GET" role="search">
            <div class="box-expand-lg">
            </div>
              </form>
          </aside>
        </div>
        <div class="col-12 col-lg-9">
          <div class="content-wrapper">
            <div class="d-lg-flex mb-30">
              <div>
                <?php if (!empty(explode("/",uri_string())[3])) { ?>
                <h3 class="heading-title"><span><?=lang('0630')?> <span class="text-lowercase"></span> </span> <span class="text-primary"><?= explode("/",uri_string())[3]; ?></span></h3>
                <?php } ?>
                <p class="text-muted post-heading"><?= count($module) ?> <?=lang('0535')?></p>
              </div>
              <div class="ml-auto">
                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
              </div>
            </div>
            <div class="product-long-item-wrapper">
              <?php if(!empty($module)){ ?>
              <?php if($appModule != "offers"){ ?>
              <?php foreach($module as $item){ $detail_url = base_url() . 'pass/detail/' . $item->id; ?>
              <div class="product-long-item">
                <div class="row equal-height shrink-auto-md gap-15">
                  <div class="col-12 col-shrink">
                   <?php if(!empty($item->discount)){?><span class="discount"><?=$item->discount?> % <?=lang('0118')?></span> <?php } ?>
                    <div class="image">
                      <a href="<?php echo $detail_url?>">
                      <img src="<?php echo base_url(); ?>/uploads/images/boats/slider/thumbs/437667_02-Big-Sky-bird-view.jpg" alt="<?php echo character_limiter($item->title,20);?>" />
                      </a>
                    </div>
                  </div>
                  <div class="col-12 col-auto">
                    <div class="col-inner d-flex flex-column">
                      <div class="content-top">
                        <div class="d-flex">
                          <div>
                            <div class="rating-item rating-sm rating-inline">
                              <div class="rating-icons">
                                <input type="hidden" class="rating" data-filled="rating-icon fas fa-star rating-rated" data-empty="rating-icon far fa-star" data-fractions="2" data-readonly value="5.0"/>
                              </div>
                              <!--<p class="rating-text text-muted"><span class="font13">- (93 reviews</span></p>-->
                            </div>
                            <h5><a href="<?php echo $detail_url; ?>"><?php echo character_limiter($item->name,20);?></a></h5>
                            <span><?php echo $item->note; ?></span>
                          </div>
                          <?php  if($item->ammount > 0){ ?>
                          <div class="ml-auto">
                            <div class="price">
                              Price: 
                              <span class="text-secondary"><?php echo $curr->symbol; ?><?php echo $item->ammount;?></span>
                            </div>
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="content">
                        <?php echo character_limiter($item->desc,150);?>
                      </div>
                      <div class="content-bottom mt-auto">
                        <div class="d-flex align-items-center">
                          <div>
                            <p>
                              Pass type: <b><?php echo ($item->type) ? 'International' : 'National'; ?></b>
                              <i class="far"></i> Category: <b><?php echo $item->category_name; ?></b>
                            </p>
                          </div>
                          <div class="ml-auto">
                            <a href="<?php echo $detail_url?>" class="btn btn-primary btn-sm btn-wide"><?php echo trans('0177');?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
              <?php } ?>
            </div>
           <br><br>
           <nav class="mt-10 mt-md-0">
           <ul class="pagination justify-content-center justify-content-lg-left">
           <?php echo createPagination($info);?>
           </ul>
           </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- end Main Wrapper -->
<style>
  .summary  { border-right: solid 2px rgb(0, 93, 247); color: #ffffff; background: #4285f4; padding: 14px; float: left; font-size: 14px; }
  .sideline { margin-top: 15px; margin-bottom: 15px; padding-left: 15px; display: table-cell; border-left: solid 1px #e7e7e7; }
  .localarea { margin-top: 15px; margin-bottom: 15px; padding-left: 15px; }
  .captext  { display: block; font-size: 14px; font-weight: 400; color: #23527c; line-height: 1.2em; text-transform: capitalize; }
  .ellipsis { max-width: 250px; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; }
  .noResults { right: 30px; top: 26px; color: #008cff; font-size: 16px; }
  .table { margin-bottom: 5px; }
</style>
<div class="search_head">
  <div class="container">
    <div class="clearfix"></div>
  </div>
</div>
<div class="clearfix"></div>
<div style="margin-top:-15px" class="collapse" id="collapseMap">
  <div id="map" class="map"></div>
  <br>
</div>
<div style="margin-top:-15px" class="collapse" id="collapseMap">
  <div id="map" class="map"></div>
  <br>
</div>
<div class="listingbg">
  <div class="container offset-0">
    <div class="clearfix"></div>
    <?php if(!$ismobile): ?>
    <div class="col-md-3 hidden-sm hidden-xs filter"></div>
    <?php endif; ?>
    <div class="col-md-9 col-xs-12">
      <?php if($appModule != "ean" && $appModule != "hotels" && $appModule != "boats" && $appModule != "cars"){ ?>
      <?php if($appModule == "offers"); {?>
      <?php foreach($module as $item){ ?>
      <?php } ?>
      <?php } ?>
      <?php } ?>
      <div class="itemscontainer">
        <div class="clearfix"></div>

      </div>
      <?php }else{  echo '<h1 class="text-center">' . trans("066") . '</h1>'; } ?>
      <!-- End of offset1-->
      <!-- start EAN multiple locations found and load more hotels -->
      <?php if($appModule == "ean"){ if($multipleLocations > 0){ foreach($locationInfo as $loc){ ?>
      <p><?php echo $loc->link; ?></p>
      <?php } } ?>
      <!--This is for display cache Parameter-->
      <!-- END OF LIST CONTENT-->
      <?php } ?>
      <!-- End EAN multiple locations found and load more hotels  -->
    </div>
    <!-- END OF LIST CONTENT-->
  </div>
  <!-- END OF container-->
</div>
</div>
<!-- END OF CONTENT -->
<!-- End container -->
<!-- Map -->
<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div  class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo trans('0254');?></h4>
      </div>
      <div class="mapContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-block btn-lg pfb0" data-dismiss="modal"><?php echo trans('0234');?></button>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<script>
  <?php if($appModule == "cars"){ ?>
  $(function(){
    $(".saveDates").on("click",function(){
      var pickup = $("#departcar").val();
      var drop = $("#returncar").val();
      var htmlvar = pickup+' - '+drop;
      $(".datesModal").html(htmlvar);
    });
  })
  
  <?php } ?>
  
  $('#collapseMap').on('shown.bs.collapse', function(e){
  (function(A) {
  
  if (!Array.prototype.forEach)
   A.forEach = A.forEach || function(action, that) {
     for (var i = 0, l = this.length; i < l; i++)
       if (i in this)
         action.call(that, this[i], i, this);
     };
  
   })(Array.prototype);
  
   var
   mapObject,
   markers = [],
   markersData = {
  
     'map-red': [
      <?php foreach($module as $item): ?>
     {
       name: 'hotel name',
       location_latitude: "<?php echo $item->latitude;?>",
       location_longitude: "<?php echo $item->longitude;?>",
       map_image_url: "<?php echo $item->thumbnail;?>",
       name_point: "<?php echo $item->title;?>",
       description_point: "<?php echo character_limiter(strip_tags(trim($item->desc)),75);?>",
       url_point: "<?php echo $detail_url?>"
     },
      <?php endforeach; ?>
  
     ],
  
   };
     var mapOptions = {
        <?php if(empty($_GET)){ ?>
       zoom: 10,
        <?php }else{ ?>
         zoom: 12,
        <?php } ?>
       center: new google.maps.LatLng(<?php echo $item->latitude;?>, <?php echo $item->longitude;?>),
       mapTypeId: google.maps.MapTypeId.ROADMAP,
  
       mapTypeControl: false,
       mapTypeControlOptions: {
         style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
         position: google.maps.ControlPosition.LEFT_CENTER
       },
       panControl: false,
       panControlOptions: {
         position: google.maps.ControlPosition.TOP_RIGHT
       },
       zoomControl: true,
       zoomControlOptions: {
         style: google.maps.ZoomControlStyle.LARGE,
         position: google.maps.ControlPosition.TOP_RIGHT
       },
       scrollwheel: false,
       scaleControl: false,
       scaleControlOptions: {
         position: google.maps.ControlPosition.TOP_LEFT
       },
       streetViewControl: true,
       streetViewControlOptions: {
         position: google.maps.ControlPosition.LEFT_TOP
       },
       styles: [/*map styles*/]
     };
     var
     marker;
     mapObject = new google.maps.Map(document.getElementById('map'), mapOptions);
     for (var key in markersData)
       markersData[key].forEach(function (item) {
         marker = new google.maps.Marker({
           position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
           map: mapObject,
           icon: '<?php echo base_url(); ?>assets/img/' + key + '.png',
         });
  
         if ('undefined' === typeof markers[key])
           markers[key] = [];
         markers[key].push(marker);
         google.maps.event.addListener(marker, 'click', (function () {
       closeInfoBox();
       getInfoBox(item).open(mapObject, this);
       mapObject.setCenter(new google.maps.LatLng(item.location_latitude, item.location_longitude));
      }));
  
  });
  
   function hideAllMarkers () {
     for (var key in markers)
       markers[key].forEach(function (marker) {
         marker.setMap(null);
       });
   };
  
   function closeInfoBox() {
     $('div.infoBox').remove();
   };
  
   function getInfoBox(item) {
     return new InfoBox({
       content:
       '<div class="marker_info" id="marker_info">' +
       '<img style="width:280px;height:140px" src="' + item.map_image_url + '" alt=""/>' +
       '<h3>'+ item.name_point +'</h3>' +
       '<span>'+ item.description_point +'</span>' +
       '<a href="'+ item.url_point + '" class="btn btn-primary"><?php echo trans('0177');?></a>' +
       '</div>',
       disableAutoPan: true,
       maxWidth: 0,
       pixelOffset: new google.maps.Size(40, -190),
       closeBoxMargin: '0px -20px 2px 2px',
       closeBoxURL: "<?php echo $theme_url; ?>assets/img/close.png",
       isHidden: false,
       pane: 'floatPane',
       enableEventPropagation: true
     }); };  });
</script>