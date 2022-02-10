<?php

$post_id = get_the_ID();

$show_all = get_field('show_all');
$choose_matches = get_field('choose_matches');

$posts = array();

if ($show_all) {
    $args = array(
        'post_type' => 'matches',
    );

    $posts = get_posts($args);
} else {
    for ($i = 0; $i < count($choose_matches); $i++) {
        $post = get_post($choose_matches[$i]);
        array_push($posts, $post);
    }
}

for ($i = 0; $i < count($posts); $i++) {

    $title = get_field('home_team', $posts[$i]->ID) . " VS " . get_field('away_team', $posts[$i]->ID);
    $sites = get_field('sites', $posts[$i]->ID);

    $partner_nice = $sites[0]['site_nice'];
    $odds_type = $sites[0]['odds'][0]['odds_type'];
    $odds_home = $sites[0]['odds'][0]['home_odds'];
    $odds_draw = $sites[0]['odds'][0]['draw_odds'];
    $odds_away = $sites[0]['odds'][0]['away_odds'];

    ?>

    <div class="match_row">
        <span class="match_row__odds_type"><?= $odds_type ?></span>
        <div class="match_row__title">
            <?= $title ?>
        </div>
        <div class="match_row__odds_row">
            <div class="match_row__odds_row_container">
                <div class="match_row__odds_row_partner">
                    <?= $partner_nice ?>
                </div>
                <div class="match_row__odds_row_odds odds">
                    <?= $odds_home ?>
                </div>
            </div>
            <div class="match_row__odds_row_container">
                <div class="match_row__odds_row_partner">
                    <?= $partner_nice ?>
                </div>
                <div class="match_row__odds_row_odds odds">
                    <?= $odds_draw ?>
                </div>
            </div>
            <div class="match_row__odds_row_container">
                <div class="match_row__odds_row_partner">
                    <?= $partner_nice ?>
                </div>
                <div class="match_row__odds_row_odds odds">
                    <?= $odds_away ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php
}
?>
