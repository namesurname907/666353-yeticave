<?php
require('data.php');
require('functions.php');

$content = render_template('templates/index.php', ['ads' => $ads]);
$all_content = render_template('templates/layout.php', ['ads' => $ads, 'categories' => $categories, 'content' => $content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'user_avatar' => $user_avatar]);
print($all_content);

?>