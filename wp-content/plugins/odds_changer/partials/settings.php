<h1>Odds Changer</h1>
<form action="options.php" method="post">
    <?php
    settings_fields( 'odds_changer_options' );
    do_settings_sections( 'odds_changer' );

    submit_button();
    ?>

    <!--<input name="submit" class="button button-primary" type="submit" value="<?php /*esc_attr_e('Save'); */?>"/>-->
</form>