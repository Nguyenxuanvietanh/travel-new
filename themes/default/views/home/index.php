<style>
.home_hidden { display:none !important}
.form-search-main-01 .col-md-6,
.form-search-main-01 .col-md-5,
.form-search-main-01 .col-md-4,
.form-search-main-01 .col-md-3,
.form-search-main-01 .col-md-2
{ width:100% !important;  flex: 0 0 100%; max-width: 100%;}

</style>
<?php include $themeurl. 'views/home/slider.php';  ?>
<?php include $themeurl. 'views/blog/featured.php' ;?>
<div class="container-fluid">
<?php include $themeurl. 'views/modules/hotels/standard/featured.php';?>
<?php include $themeurl. 'views/modules/flights/standard/featured.php';?>
<?php include $themeurl. 'views/modules/tours/standard/featured.php';?>
<?php include $themeurl. 'views/modules/rentals/featured.php';?>
<?php include $themeurl. 'views/modules/boats/featured.php';?>
<?php include $themeurl. 'views/modules/extra/offers/featured.php';?>
<?php include $themeurl. 'views/modules/cars/standard/featured.php';  ?>
</div>