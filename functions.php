<?php

function Redirect($url, $permanent = false) {
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

function POST_value($post) {
    return filter_input(INPUT_POST, $post);
}

function COOKIE_value($post) {
    return filter_input(INPUT_COOKIE, $post);
}

function SERVER_value($post) {
    return filter_input(INPUT_SERVER, $post);
}