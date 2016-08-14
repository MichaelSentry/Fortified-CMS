<?php
// Category list view
?>
<h2>Category Index</h2>
<div class="inner-content">

    <?php if( empty( $list ) ) { ?>

     <p>Category list is unavailable</p>

    <?php } else {

     if( is_array( $list ) ){ ?>

         <table class="table table-striped table-bordered table-condensed table-hover">

         <?php
         foreach( $list as $category )
         {
             if( ! empty( $category ) && is_string( $category ) ) {
                 echo '<tr><td><a href="#">' . escaped( $category ) . '</a></td></tr>';
             }
         }
         ?>
         </table>
        <?php
     }
 }

?>
</div>