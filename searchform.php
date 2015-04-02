<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
    <div class="searchform--inner cf">
        <label for="s" class="screen-reader-text"><?php _e('Search for:','pneumatic-theme'); ?></label>
        <input type="search" id="s" name="s" value="" placeholder="" />
        <input type="submit" id="searchsubmit" value="<?php _e('Search','pneumatic-theme'); ?>">
    </div>
</form>
