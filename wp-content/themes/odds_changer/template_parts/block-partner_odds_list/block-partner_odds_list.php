<?php
$sites = get_field('sites', $post_id);

//creating more dummy data
$sites = array_merge($sites, $sites);

$odds_type = $sites[0]['odds'][0]['odds_type'];
?>

<select id="sort_odds">
    <option>Default</option>
    <option>Highest Home</option>
    <option>Highest Draw</option>
    <option>Highest Away</option>
</select>

<div class="match_row_container">
<?php
for ($j = 0; $j < count($sites); $j++) {

    $partner_nice = $sites[$j]['site_nice'];
    $odds_home = $sites[$j]['odds'][0]['home_odds'];
    $odds_draw = $sites[$j]['odds'][0]['draw_odds'];
    $odds_away = $sites[$j]['odds'][0]['away_odds'];
    ?>
    <div class="match_row_holder" data-pos="<?= $j ?>" data-home="<?= $odds_home ?>" data-draw="<?= $odds_draw ?>" data-away="<?= $odds_away ?>">
        <div class="match_row">
            <span class="match_row__odds_type"><?= $odds_type ?></span>
            <div class="match_row__title">
                <?= $partner_nice ?>
            </div>
            <div class="match_row__odds_row">
                <div class="match_row__odds_row_container">
                    <div class="match_row__odds_row_odds odds odds_home">
                        <?= $odds_home ?>
                    </div>
                    <div class="match_row__odds_row_team">
                        home
                    </div>
                </div>
                <div class="match_row__odds_row_container">
                    <div class="match_row__odds_row_odds odds odds_draw">
                        <?= $odds_draw ?>
                    </div>
                    <div class="match_row__odds_row_team">
                        draw
                    </div>
                </div>
                <div class="match_row__odds_row_container">
                    <div class="match_row__odds_row_odds odds odds_away">
                        <?= $odds_away ?>
                    </div>
                    <div class="match_row__odds_row_team">
                        away
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
}
?>
</div>
