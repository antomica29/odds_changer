<h1>Odds Changer</h1>
<form action="options.php" method="post">
    <?php
    settings_fields( 'odds_changer_options' );
    do_settings_sections( 'odds_changer' );

    submit_button();
    ?>
</form>
