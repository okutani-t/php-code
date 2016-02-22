<?php
function short_php($params = array()) {
  extract(shortcode_atts(array(
    'file' => 'default'
  ), $params));
  ob_start();
  // include(get_theme_root() . '/' . get_template() . "/$file.php");
  // ↓子テーマ
  include(STYLESHEETPATH . "/$file.php");
  return ob_get_clean();
}

add_shortcode('myphp1', 'short_php');
