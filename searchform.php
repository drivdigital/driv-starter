<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
    <div class="searchform-inner">
        <label for="s" class="screen-reader-only"><?php _e('Search for:','pneumatic-theme'); ?></label>
        <input type="search" id="s" name="s" value="" />
        <input type="submit" id="searchsubmit" ><?php _e('Search','pneumatic-theme'); ?></input>
    </div>
</form>
