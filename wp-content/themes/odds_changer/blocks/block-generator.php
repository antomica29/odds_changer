<?php

foreach ($blocks as $block) {
    output_content(render_block($block));
}
