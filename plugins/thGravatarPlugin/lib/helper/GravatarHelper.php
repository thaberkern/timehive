<?php
/**
 * Displays a gravatar image for a given email
 *
 * @param string  $email            Email of the gravatar
 * @param string  $gravatar_rating  Maximal rating of the gravatar
 * @param integer $gravatar_size    size of the gravatar
 * @param string  $alt_text         Alternative text
 * @param string  $class            CSS class
 * @return string
 * @see http://site.gravatar.com/site/implement#section_1_1
 */
function gravatar_image_tag($email, $gravatar_size = '30', $gravatar_rating = 'g', $alt_text = 'Gravatar', $class = 'gravatar') {

    $url = gravatar_url($email, $gravatar_size, $gravatar_rating);

    return image_tag($url,
        array('alt' => $alt_text,
        'width' => $gravatar_size,
        'height' => $gravatar_size,
        'class' => $class
        )
    );
}

function gravatar_url($email, $gravatar_size = '30', $gravatar_rating = 'g')
{
    $url = 'http://www.gravatar.com/avatar/'.md5(strtolower($email))."?s={$gravatar_size}&r={$gravatar_rating}";
    return $url;
}