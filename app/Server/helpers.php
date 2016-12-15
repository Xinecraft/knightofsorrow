<?php
/**
 *
 * Copyright (c) 2014 Zishan Ansari
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Date: 7/26/2015
 * Time: 12:57 AM
 */

/**
 * Returns 'active' if Request is same as current.
 * This function is used to make a nav bar actived when in that page.
 *
 * @param $path
 * @param string $active
 * @return string
 */
function set_active($path, $active = 'active') {

    return call_user_func_array('Request::is', (array)$path) ? $active : '';

}

function set_active_or_disabled($path, $active = 'active') {

    return call_user_func_array('Request::is', (array)$path) ? $active : 'disabled';

}

    /**
    * Function that will create a link to sort rounds by specified coulmn name
    *
    * @param $column
    * @param $data
    * @return string
    */
    function sort_rounds_by($column,$data)
    {
    $sortDirCurrent = Request::get('direction') ? Request::get('direction') : 'desc';
    $getOrderBy = Request::has('orderBy') ? Request::get('orderBy') : 'created_at';

    $sortDir = Request::get('direction') == 'asc' ? 'desc' : 'asc' ;

    if($getOrderBy == $column)
        return link_to_route('round-reports',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary '.$sortDirCurrent]);
    else
        return link_to_route('round-reports',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary']);
    }

    /**
    * Function that will create a link to sort players by specified coulmn name
    *
    * @param $column
    * @param $data
    * @return string
    */
    function sort_players_by($column,$data)
    {
    $sortDirCurrent = Request::get('direction') ? Request::get('direction') : 'asc';
    $getOrderBy = Request::has('orderBy') ? Request::get('orderBy') : 'position';

    $sortDir = Request::get('direction') == 'desc' ? 'asc' : 'desc' ;

    if($getOrderBy == $column)
        return link_to_route('top-players',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary '.$sortDirCurrent]);
    else
        return link_to_route('top-players',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary']);
    }

/**
 * Function that will create a link to sort specific country's players by specified coulmn name
 *
 * @param $column
 * @param $data
 * @return string
 */
function sort_country_players_by($column,$data,$countryId,$countryName)
{
    $sortDirCurrent = Request::get('direction') ? Request::get('direction') : 'asc';
    $getOrderBy = Request::has('orderBy') ? Request::get('orderBy') : 'position';

    $sortDir = Request::get('direction') == 'desc' ? 'asc' : 'desc' ;

    if($getOrderBy == $column)
        return link_to_route('country-detail',$data,[$countryId,$countryName,'orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary '.$sortDirCurrent]);
    else
        return link_to_route('country-detail',$data,[$countryId,$countryName,'orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary']);
}

function sort_bans_by($column,$data)
{
    $sortDirCurrent = Request::get('direction') ? Request::get('direction') : 'desc';
    $getOrderBy = Request::has('orderBy') ? Request::get('orderBy') : 'updated_at';

    $sortDir = Request::get('direction') == 'desc' ? 'asc' : 'desc' ;

    if($getOrderBy == $column)
        return link_to_route('bans.index',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary '.$sortDirCurrent]);
    else
        return link_to_route('bans.index',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary']);
}

/**
 * Function creates a link to sort Countries by specific column
 *
 * @param $column
 * @param $data
 * @return string
 */
    function sort_countries_by($column,$data)
    {
        $sortDirCurrent = Request::get('direction') ? Request::get('direction') : 'desc';
        $getOrderBy = Request::has('orderBy') ? Request::get('orderBy') : 'total_players';

        $sortDir = Request::get('direction') == 'asc' ? 'desc' : 'asc' ;

        if($getOrderBy == $column)
            return link_to_route('countries-list',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary '.$sortDirCurrent]);
        else
            return link_to_route('countries-list',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary']);
    }


/**
 * This function returns after replace Youtube URLs
 *
 * Alt: preg_match_all("/^.*(youtu.be\/|v\/|e\/|u\/\w+\/|embed\/|v=)([^#\&\?]*).* /", $youtube,$matches);
 * @param  [type] $text [description]
 * @return [type]       [description]
 */
function embedYoutube($text)
{
    $search = '~
        # Match non-linked youtube URL in the wild. (Rev:20130823)
        (?:https?://)?    # Optional scheme.
        (?:[0-9A-Z-]+\.)? # Optional subdomain.
        (?:               # Group host alternatives.
          youtu\.be/      # Either youtu.be,
        | youtube         # or youtube.com or
          (?:-nocookie)?  # youtube-nocookie.com
          \.com           # followed by
          \S*             # Allow anything up to VIDEO_ID,
          [^\w\s-]        # but char before ID is non-ID char.
        )                 # End host alternatives.
        ([\w-]{11})       # $1: VIDEO_ID is exactly 11 chars.
        (?=[^\w-]|$)      # Assert next char is non-ID or EOS.
        (?!               # Assert URL is not pre-linked.
          [?=&+%\w.-]*    # Allow URL (query) remainder.
          (?:             # Group pre-linked alternatives.
            [\'"][^<>]*>  # Either inside a start tag,
          | </a>          # or inside <a> element text contents.
          )               # End recognized pre-linked alts.
        )                 # End negative lookahead assertion.
        [?=&+%\w.-]*      # Consume any URL (query) remainder.
        ~ix';

    $replace = '<object width="600" height="344">
        <param name="movie" value="http://www.youtube.com/v/$1?fs=1"</param>
        <param name="allowFullScreen" value="true"></param>
        <param name="allowScriptAccess" value="always"></param>
        <embed src="http://www.youtube.com/v/$1?fs=1"
            type="application/x-shockwave-flash" allowscriptaccess="always" width="600" height="344">
        </embed>
        </object>';

    return preg_replace($search, $replace, $text);
}

function embedYoutubeForComment($text)
{
    $search = '~
        # Match non-linked youtube URL in the wild. (Rev:20130823)
        (?:https?://)?    # Optional scheme.
        (?:[0-9A-Z-]+\.)? # Optional subdomain.
        (?:               # Group host alternatives.
          youtu\.be/      # Either youtu.be,
        | youtube         # or youtube.com or
          (?:-nocookie)?  # youtube-nocookie.com
          \.com           # followed by
          \S*             # Allow anything up to VIDEO_ID,
          [^\w\s-]        # but char before ID is non-ID char.
        )                 # End host alternatives.
        ([\w-]{11})       # $1: VIDEO_ID is exactly 11 chars.
        (?=[^\w-]|$)      # Assert next char is non-ID or EOS.
        (?!               # Assert URL is not pre-linked.
          [?=&+%\w.-]*    # Allow URL (query) remainder.
          (?:             # Group pre-linked alternatives.
            [\'"][^<>]*>  # Either inside a start tag,
          | </a>          # or inside <a> element text contents.
          )               # End recognized pre-linked alts.
        )                 # End negative lookahead assertion.
        [?=&+%\w.-]*      # Consume any URL (query) remainder.
        ~ix';

    $replace = '<br><object width="auto" height="auto">
        <param name="movie" value="http://www.youtube.com/v/$1?fs=1"</param>
        <param name="allowFullScreen" value="true"></param>
        <param name="allowScriptAccess" value="always"></param>
        <embed src="http://www.youtube.com/v/$1?fs=1"
            type="application/x-shockwave-flash" allowscriptaccess="always" width="auto" height="auto">
        </embed>
        </object>';

    return preg_replace($search, $replace, $text);
}


/**
 * Finds youtube videos links and makes them an embed.
 * search: http://www.youtube.com/watch?v=xg7aeOx2VKw
 * search: http://www.youtube.com/embed/vx2u5uUu3DE
 * search: http://youtu.be/xg7aeOx2VKw
 * replace: <iframe width="560" height="315" src="http://www.youtube.com/embed/xg7aeOx2VKw" frameborder="0" allowfullscreen></iframe>
 *
 * @param string
 * @return string
 * @see http://stackoverflow.com/questions/6621809/replace-youtube-link-with-video-player
 * @see http://stackoverflow.com/questions/5830387/how-to-find-all-youtube-video-ids-in-a-string-using-a-regex
 */
function generateVideoEmbeds($text) {
    // No youtube? Not worth processing the text.
    if ((stripos($text, 'youtube.') === false) && (stripos($text, 'youtu.be') === false)) {
        return $text;
    }

    $search = '@          # Match any youtube URL in the wild.
        [^"\'](?:https?://)?  # Optional scheme. Either http or https; We want the http thing NOT to be prefixed by a quote -> not embeded yet.
        (?:www\.)?        # Optional www subdomain
        (?:               # Group host alternatives
          youtu\.be/      # Either youtu.be,
        | youtube\.com    # or youtube.com
          (?:             # Group path alternatives
            /embed/       # Either /embed/
          | /v/           # or /v/
          | /watch\?v=    # or /watch\?v=
          )               # End path alternatives.
        )                 # End host alternatives.
        ([\w\-]{8,25})    # $1 Allow 8-25 for YouTube id (just in case).
        (?:               # Group unwanted &feature extension
            [&\w-=%]*     # Either &feature=related or any other key/value pairs
        )
        \b                # Anchor end to word boundary.
        @xsi';

    $replace = '<iframe width="560" height="315" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>';
    $text = preg_replace($search, $replace, $text);

    return $text;
}

/**
 * Linkify the string URL
 *
 * @param $string
 * @return mixed
 */
function linkify($string)
{
    //$new_string = preg_replace("~(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?~","<a target='_blank' href='http://www.knightofsorrow.in/redirects?to=\\0'>\\0</a>", $string);
    //$new_string = preg_replace("~(?:(https?)://([^\s<].+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i","<a target='_blank' href='http://www.knightofsorrow.in/redirects?to=\\0'>\\0</a>", $string);
    $new_string = preg_replace("~(?:(https?)://([^\s<].+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i","<a target='_blank' href='http://www.knightofsorrow.in/redirects?to=\\0'><sup class='tooltipster' title='\\0'> [link]</sup></a> ", $string);
    //$new_string = "";
    $regex = "~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i";
    if(preg_match($regex, $string, $matches))
    {
        $firstURL = $matches[0];
        $new_string = $new_string."<a href='http://www.knightofsorrow.in/redirects?to=$firstURL' target='_blank'><img class='img' style='width:100%;border:1px solid #e1e1e1'  src='http://free.pagepeeker.com/v2/thumbs.php?size=m&url=$firstURL'></a>";
    }
    return $new_string;
}

/**
 * @param $value
 * @param array $protocols
 * @param array $attributes
 * @return mixed
 */
function linkify_new($value, $protocols = array('http', 'mail'), array $attributes = array())
{
    // Link attributes
    $attr = '';
    foreach ($attributes as $key => $val) {
        $attr = ' ' . $key . '="' . htmlentities($val) . '"';
    }

    $links = array();

    // Extract existing links and tags
    $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);

    // Extract text links for each protocol
    foreach ((array)$protocols as $protocol) {
        switch ($protocol) {
            case 'http':
            case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>'; }, $value); break;
            case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
            case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;
            default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
        }
    }

    // Insert all link
    return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
}

function fixHostNameForServerList($str)
{
    $patt = "/\[[a-zA-Z0-9]=([^\]]+)\]/";
    $res  = preg_replace($patt, "", $str);
    $res = preg_replace("/\[\\\\[a-zA-Z0-9]\]/", "",$res);
    return $res;
}