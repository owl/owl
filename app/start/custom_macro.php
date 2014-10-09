<?php

//
HTML::macro('gravator', function($email, $s = 80, $d = 'mm', $r = 'g', $img = true, $atts = array())
{
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
});

HTML::macro('tags', function($array)
{
    $tag_lists = "";
    foreach($array as $tag){
        if($tag === end($array)) {
            $tag_lists .= $tag["name"];
            break;
        }
        $tag_lists .= $tag["name"] . ",";
    }
    return $tag_lists;
});

HTML::macro('markdown', function($str)
{
    $parser = new CustomMarkdown;
    $parser->enableNewlines = true;
    return $parser->parse($str);
});

HTML::macro('date_replace', function($str)
{
    $str = str_replace("%{Year}",date('Y'), $str);
    $str = str_replace("%{month}",date('m'), $str);
    $str = str_replace("%{day}",date('d'), $str);
    return $str;
});



