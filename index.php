<?php

/**
 * View by week
 * 
 * Web application to provide a stripped-down, minimal page-load 
 * user experience similar to the original client download site.
 *
 * Built using creators_php API lib: 
 * https://github.com/creatorssyn/creators_php
 * 
 * Live demo: 
 * http://get.creators.com/hosted/view_by_week/login
 * 
 * @author Brandon Telle <btelle@creators.com>
 * @copyright (c) 2014, Creators <www.creators.com>
 */


/* ### Application Settings ################################################ */

// Location of the view_by_week directory 
define('APPLICATION_ROOT', './');

// Location of the Creators PHP API library 
define('LIB_DIR', APPLICATION_ROOT.'lib/');

// HTTP address of the service. Do not include a filename (like index.php)
define('SERVICE_ADDRESS', 'http://yourdomain.com/path/to/view_by_week/');

/* ### End Settings ######################################################## */


require_once(LIB_DIR.'creators_php/creators_php.php');

if(Creators_API::API_VERSION < 0.3)
    die('Error: Creators API version 0.3 or higher is required');

if(isset($_GET['api_key']) && strlen($_GET['api_key']) === Creators_API::API_KEY_LENGTH)
{
    $api = new Creators_API($_GET['api_key']);
}
else
{
    $api = new Creators_API();
    
    if(isset($_SERVER['PHP_AUTH_USER'])) 
    {
        if($api->authenticate($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']))
        {
            header('Location: '.SERVICE_ADDRESS.'?api_key='.$api->api_key);
            exit;
        }
    }
    
    header('WWW-Authenticate: Basic realm="Creators GET"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Error 401: Unauthorized';
    exit;
}

// Check for login failure, service errors, etc.
try {
    $api->syn();
}
catch(ApiException $e) {
    echo 'Error '.$e->getCode().': '.$e->getMessage();
    exit;
}

// Download proxy. Prevents re-authentication on file download.
// ?download_id=<int>&download_type=<file|zip>
if(isset($_GET['download_id']))    
{
    $dest = APPLICATION_ROOT.'tmp/'.time().rand();
    
    if($_GET['download_type'] == 'file')
        $ret = $api->download_file('/api/files/download/'.$_GET['download_id'], $dest, $headers);
    elseif($_GET['download_type'] == 'zip')
        $ret = $api->download_zip($_GET['download_id'], $dest, $headers);
    
    if($ret)
    {
        $filename = basename(substr($headers['Redirect-URL'], 0, strpos($headers['Redirect-URL'], '?')));
        
        header('Content-Type: '.$headers['Content-Type']);
        header('Content-Disposition: attachment; filename='.$filename);
        header('Content-Length: '.filesize($dest));
        readfile($dest);
    }
    else
    {
        echo "Error 500: Could not download that file.";
    }
    
    if(file_exists($dest) && !is_dir($dest))
        @unlink($dest);
    
    exit;
}

// Process form submission, show results
if(isset($_POST['submit']) && isset($_POST['features']) && !empty($_POST['features']))
{
    $start_date = date('Y-m-d', time()-(60*60*24*((int)$_POST['days'])));
    
    $releases = array();
    foreach($_POST['features'] as $file_code)
    {
        $releases = array_merge($releases, $api->get_releases($file_code, 100, 0, $start_date));
    }
    
    // Re-order the release array by release_date
    $releases = array_orderby($releases, 'release_date', SORT_DESC);
    
    foreach($releases as $i=>$release)
    {
        // Alter file download URLs to use our download proxy
        foreach($release['files'] as $f=>$file)
        {
            preg_match('#/api/files/download/([0-9]+)#', $file['url'], $matches);
            $releases[$i]['files'][$f]['url'] = SERVICE_ADDRESS.'?api_key='.$_GET['api_key'].'&amp;download_type=file&amp;download_id='.$matches[1];
        }
        
        // Add entire package file
        $releases[$i]['files'][] = array('description'=>'Entire Package', 'url'=>SERVICE_ADDRESS.'?api_key='.$_GET['api_key'].'&amp;download_type=zip&amp;download_id='.$release['id']);
    }
    
    show_releases($releases);
}

// Display form
else
{
    $features = array('Lifestyle'=>array(), 'Opinion'=>array(), 'Comic'=>array(), 'Cartoon'=>array());
    
    foreach($api->get_features() as $f)
    {
        $features[$f['category']][] = $f;
    }
    
    // Re-order each category arry by feature title
    foreach($features as $k=>$rows)
        $features[$k] = array_orderby($rows, 'title', SORT_ASC);
    
    show_form($features);
}

/**
 * Display the form view
 * @param array $features list of enabled features
 */
function show_form($features)
{
    show_header();
    require APPLICATION_ROOT.'views/form.php';
    show_footer();
}

/**
 * Display the results view
 * @param array $releases list of matched releases
 */
function show_releases($releases)
{
    show_header();
    require APPLICATION_ROOT.'views/results.php';
    show_footer();
}

/**
 * Display the header
 */
function show_header()
{
    require APPLICATION_ROOT.'views/header.php';
}

/**
 * Display the footer
 */
function show_footer()
{
    require APPLICATION_ROOT.'views/footer.php';
}

/**
 * Order a database-style array on one or more columns
 * http://php.net/manual/en/function.array-multisort.php#100534
 * 
 * @author jimpoz at jimpoz dot com
 */
function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

?>