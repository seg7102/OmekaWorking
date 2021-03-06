<?php

require_once dirname(__FILE__) . '/functions.php';

add_plugin_hook('public_head', 'queue_theme_assets');

add_filter('exhibit_builder_display_random_featured_exhibit', 'hijack_exhibit_builder_random_featured_exhibit'); 

/*
** Adds a fancy read more button to whatever section
** $link URL to direct to
** $button_id css id to style the button later 
** $button_text "Read more" or "more" or "continue" or whatever
*/

function read_more_button($link, $button_id, $button_text){
    $read_more = '<a href = "'.$link.'"><p id = "'.$button_id.'" class = "read_more_button">'.$button_text.' >></p></a>';
    return $read_more;
}

/* Formats the homepage's about section, for desktop and for mobile.
*/
function home_about(){
    $text = '<div class="homepage-text" id = "homepage-text"><h3 id = "About_head">About</h3><p id = "n_about_text">'.get_theme_option('about').'</p>'.read_more_button('http://rochestercommunitymemory.com/about', 'About_read_more', 'Read more').'</div><div class="homepage-text" id = "homepage-text-mobile"><h3 id = "About_head">About</h3><p id = "m_about_text">'.get_theme_option('mobile_about').'</p>'.read_more_button('http://rochestercommunitymemory.com/about', 'About_read_more', 'Read more').'</div>';
    return $text;
}
                
/* Formats the featured text area under the homepagemap - the heading and body*/
function featured_text(){
    $text = '<div id="featured-text" class = "homepage-text"><h3 id = "Featured_head">'.get_theme_option('text_heading').'</h3><p id = featured_text_body>'.get_theme_option('text_area').'</p></div>';
    return $text;
}


/*
** Find the URL on the server of the logo file (omeka assigns nonsense file names)
*/
function home_logo_url()
{
	$logo = get_theme_option('lg_logo');
	$logo_url = $logo ? WEB_ROOT.'/files/theme_uploads/'.$logo : img('home-logo.png');
	return $logo_url;
}

/*
** Logo IMG Tag
*/
function home_logo(){
	return '<img src="'.home_logo_url().'" alt="'.option('site_title').'"/>';
}


/*
** Social media links for footer
** $class 'colored' uses a service-specific color as background
** $class 'no-label' visually hides the label and just uses the icon
*/
function media_footer($class=null, $max=9){
	$class.= get_theme_option('social_label') ? ' label' : ' no-label';
	$class.= get_theme_option('social_color') ? ' colored' : ' no-color';
	if( $social=media_array($max) ){
		return '<div class="link-icons '.$class.'">'.implode(' ',$social).'</div>';
	}
}

/*
** Build a series of social media link for the homepage
** $class 'colored' uses a service-specific color as background
** $class 'no-label' visually hides the label and just uses the icon
*/
function media_home($class="", $max=3){
	if( $social=media_array($max) ){
		return '<div class="link-icons '.$class.'">'.implode(' ',$social).'</div>';
	}
}

/*
** Inserts an iframe for the map on homepage 
*/

function map_home(){
    $map = get_theme_option('map_home');
    if (!empty($map)){
        return '<div id = "map_home"><iframe src="'.$map.'" seamless="seamless" scrolling="no" frameborder = "0" id = "map_iframe_home"></iframe></div><div id = "mobile_map_home"><img src ="'.image_url('mobile_map', 'mobile_map').'" id = "mobile_map"/><p id = "mobile_map_caption">For an interactive map, please visit our desktop site.</p></div>';
    } 
}

/* neatline browse page */ 
function neatline_iframe($exhibit){
    $link = nl_getExhibitUrl($exhibit, 'fullscreen', true);
    return '<iframe src="'.$link.'" seamless="seamless" scrolling="no" frameborder = "0" class = "nl_preview"></iframe>';
}


/*
** Formats exhibit title for the three featured exhibits
** on the homepage
*/
function exhibit_title($exhibitNumber){
    $option = 'ex_title_'.$exhibitNumber;
    $title = '<h4>'.get_theme_option($option).'</h4>';
    return $title;
}

/*
** Formats link each exhibit photo directs to for the three 
** featured exhibits on the homepage
*/
function exhibit_link($exhibitNumber){
    $option = 'ex_link_'.$exhibitNumber;
    $link = '<a href ="'.get_theme_option($option).'">';
    return $link;
}

/*
** Formats image for each exhibit for the three 
** featured exhibits on the homepage
*/
function exhibit_img($exhibitNumber){
    $option = 'ex_img_'.$exhibitNumber;
    $alt = 'ex_alt_'.$exhibitNumber;
    $img = '<img src="'.image_url($option, $option).'" id ="exhibit'.$exhibitNumber.'" class = "n_image" alt = "'.get_theme_option($alt).'"/>';
    return $img;
}

/*function bnner_img(){
    return '<img src="'.get_theme_option('bnner_img').'" id ="banner_image" />';
}*/

/*
** Builds exhibit using the previous exhibit functions
*/
function build_exhibit($exhibitNumber){
    $exhibit = exhibit_link($exhibitNumber).exhibit_img($exhibitNumber).'</a><div class = "descr" id = "exhibit_title_'.$exhibitNumber.'">'.exhibit_title($exhibitNumber).'</div>';
    return $exhibit;
}

/*
** Builds banner code with the link the banner directs to
** and the link to the banner image 
*/
function build_banner(){
    $bannerText = '<a href ="'.get_theme_option('banner_url').'"/><img src = "'.image_url('banner_img', 'banner_home').'" id = "front_banner" alt = "'.get_theme_option('banner_alt').'"/><img src = "'.image_url('mobile_ban', 'banner_home_mobile').'" id = "front_banner_mobile" alt = "'.get_theme_option('banner_alt').'"/></a>';
    return $bannerText;
}


/*
** Formats logo url after uploading
*/
function logo_url()
{
	$logo = get_theme_option('main_logo');
	$logo_url = $logo ? WEB_ROOT.'/files/theme_uploads/'.$logo : img('home-logo.png');
	return $logo_url;
}

function logo_url_test()
{
	$logo = get_theme_option('main_logo');
	$logo_url = $logo ? WEB_ROOT.'/files/theme_uploads/'.$logo : img('home-logo.png');
	return $logo;
}

function logo_url_test_name(){
    $logo = get_theme_option('main_logo');
    rename($logo, 'Main_logo.png');
}

function get_file_name($file){
    $name = get_theme_option($file);
    return $name;
}


/* $file variable as it appears in Config.ini*/
function rename_file($file, $new){
    $oldName = WEB_ROOT.'/files/theme_uploads/'.logo_url_test($file);
    $newName = WEB_ROOT.'/files/theme_uploads/'.$new;
    rename($oldName, $newName);
}

/*
** Formats logot to insert 
*/
function insert_logo(){
	return '<a href = "http://www.rochestercommunitymemory.com/"><img src="'.logo_url().'" alt="'.option('site_title').'" id = "home_Logo"/></a>';
}

/*
** Checks whether or not the site title should be shown
** If not, search container goes in line with the logo
** If yes, search container goes in line with the title 
*/
function hide_title(){
    $show = get_theme_option('title_off');
    if ($show ==1){
        $show = '</a><div id="search-container" class = "no_title">'.search_form(array('form_attributes' => array('role' => 'search'))).'</div>';
    }else{
        $show = '</div><div id = "head_row_2"><h1 id="site-title">'.link_to_home_page(theme_logo()).'</h1><a href = "#" id ="nav_icon"><img src = "https://i.imgur.com/GH9aF56.png"/></a><div id="search-container">'.search_form(array('form_attributes' => array('role' => 'search'))).'</div></div>';
    }
    return $show;
}

/*
** Build footer text 
*/
function build_footer_text(){
    $foot_text = get_theme_option('foot_text');
    return '<div id = "footer_text" class = "foot_section"><p>'.$foot_text.'</p></div>';
}



/*
** Generates a URL and stores file locally for any image
** $upload refers to the name of the item in the config.ini file
** $name refers to a name to store the file under 
*/

function image_url($upload, $name){
    $image = get_theme_option($upload);
    $image_url = $image ? WEB_ROOT.'/files/theme_uploads/'.$image : img($name);
    return $image_url;
}

/*
** Build footer logo section
*/
function build_footer_logos(){
    $logo1 = '<a href = "'.get_theme_option('foot_url_1').'"><img src = "'.image_url('foot_img_1', 'foot_img_1').'" id = "foot_logo_1" alt = "'.get_theme_option('foot_alt_1').'"></a>';
    $logo2 = '<a href = "'.get_theme_option('foot_url_2').'"><img src = "'.image_url('foot_img_2', 'foot_img_2').'" id = "foot_logo_2" alt = "'.get_theme_option('foot_alt_2').'"></a>';
    return '<div id = "footer_logo" class = "foot_section">'.$logo1.$logo2.'</div>';
}

/*
** Build footer contact 
*/
function build_footer_contact(){
    $address = '<p>'.get_theme_option('foot_address').'</p>';
    $phone = '<p>'.get_theme_option('foot_phone').'</p>';
    $email = '<p>'.get_theme_option('contact_email').'</p>';
    return '<div id = "footer_contact" class = "foot_section"><h4>Contact</h4>'.$address.$phone.$email.'</div>';
}

/*
** Build footer social links 
*/

function build_footer_social(){
    $twitter_url = get_theme_option('twitter_username');
    $youtube_url = get_theme_option('youtube_username');
    $facebook_url = get_theme_option('facebook_link');
    
    $twitter = null;
    $youtube = null;
    $facebook = null; 
    $title = '<h4>Follow Us</h4>';

    if (!empty($twitter_url)){
        $twitter = '<a href = "'.$twitter_url.'"><img src = "http://www.rochestercommunitymemory.com/files/original/74b85d88aab80c6226f0b27cc81a7add.png" id = "twitter" alt = "twitter" /></a>';
    }
    
    if (!empty($youtube_url)){
        $youtube = '<a href = "'.$youtube_url.'"><img src = "http://www.rochestercommunitymemory.com/files/original/b6529d01bb8b723d406cb5ed5030b179.png" id = "youtube" alt = "youtube" /></a>';
    }
    
    if (!empty($facebook_url)){
        $facebook = '<a href = "'.$faceboook_url.'"><img src = "http://www.rochestercommunitymemory.com/files/original/44587117d53d392342695e86b9185ba5.png" id = "facebook" alt = "facebook" /></a>';
    }
    
    if (empty($twitter) && empty($youtube) && empty($facebook)){
        $title = null;
    }
    
    return '<div id = "footer_social" class = "foot_section">'.$title.$twitter.$youtube.$facebook.'</div>';
    
    
}



/*
    Takes in $textBlock of titles and urls, 
    splits into paired title/url groups at semicolons
    splits into individual pieces at commas 
    puts everything into a 2D array
    HTML formats a block of iframes for each video in the array
    in rows of 3 

*/
function generate_video_mosaic($textBlock){
    $dump = get_theme_option($textBlock);
    $dump = str_replace(array("\r", "\n", "<br />"), '', $dump);
    $couples = explode(';', $dump);
    $count = 0;
    $rowCount=1;
    $arrayCount = count($couples);
    
    $html = null;
    
    foreach ($couples as $group){
        $group = explode(',,', $group);
        $couples[$count] = array($group[0],$group[1]);
        
        $batch = generate_videos($couples[$count][0], $couples[$count][1]);
        
        if ($count==($arrayCount-1)){
            if (($count%3)==0){
                if ($count==0){
                    $html = $html.'<div id = "iframe_row'.$rowCount.'" class ="iframe_row">'.$batch.'</div>';
                    $rowCount++;
                }else{
                    $html = $html.'</div><div id = "iframe_row'.$rowCount.'" class ="iframe_row">'.$batch.'</div>';
                    $rowCount++;
                }
            }else{
                $html = $html.$batch.'</div>';
            }
        }else{
            if (($count%3)==0){
                if ($count==0){
                    $html = $html.'<div id = "iframe_row'.$rowCount.'" class ="iframe_row">'.$batch;
                    $rowCount++;
                }else{
                    $html = $html.'</div><div id = "iframe_row'.$rowCount.'" class ="iframe_row">'.$batch;
                    $rowCount++;
                }    
            }else{
                $html = $html.$batch;
            }
        }
        
        $count++;
        
    }
    
    return $html;
    
    
}

/*
    Generates the HTML container for titles and links to videos
*/

function generate_videos($title, $link){
    $iframe = '<iframe width="315" height="315" class ="oral_video" src="'.$link.'?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
    $caption = '<h3 class = "oral_caption">'.$title.'</h3>';
    return '<aside class ="oral_video_">'.$iframe.$caption.'</aside>';
    
}

function generate_map($title, $link){
    $heading = '<a href = "'.$link.'" target = "_blank" ><h2 class = "map_heading">'.$title.'</h2></a>';
    $iframe = '<iframe src="'.$link.'" seamless="seamless" scrolling="no" frameborder = "0" class = "map_iframe"></iframe>';
    return '<div class = "map_container">'.$heading.$iframe.'</div>';
}


/*
    Takes in $textBlock of titles and urls, 
    splits into paired title/url groups at semicolons
    splits into individual pieces at commas 
    puts everything into a 2D array
    HTML formats a block of iframes for each map in the array
    in rows of 3 

*/
function generate_map_mosaic($textBlock){
    $dump = get_theme_option($textBlock);
    $dump = str_replace(array("\r", "\n", "<br />"), '', $dump);
    $couples = explode(';', $dump);
    $count = 0;
    
    $html = null;
    
    foreach ($couples as $group){
        $group = explode(',,', $group);
        $couples[$count] = array($group[0],$group[1]);
        
        $batch = generate_map($couples[$count][0], $couples[$count][1]);
        
        $html = $html.$batch;
        
        $count++;
        
    }
    
    return $html;
    
}




?>