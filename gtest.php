<?php
set_time_limit(0);

$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname );

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
//exit;
include('csvs/simple_html_dom.php');
$l=2000;
//echo $sql = "SELECT * FROM ripoff_urls limit   $l  ($l + 10) ";
while($l<767118) {
//while($l<112) {

    $k=$l+1000;
    echo $sql = "SELECT * FROM ripoff_urls limit  $l , 10000";
    //exit;
    $result = $conn->query($sql);
print_r($result->num_rows);
    echo "<br/>";
    if ($result->num_rows > 0) {
        // output data of each row
        $i=0;
        while ($row = $result->fetch_assoc()) {
            //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";


            echo '<pre>';
            //$s = (fgetcsv($file));
            //print_r($s[9]);

            if (strlen($row['url']) > 4) {
               echo  $mylink = "http://ripoffreport.com/" . $row['url'];
                echo "<br/>";
                echo "<br/>";
                echo $i++;
                echo "<br/>";
                echo "<br/>";
                echo "<br/>";
                echo "<br/>";

///print_r(get_headers($mylink));

//print_r(get_headers($mylink, 1));
               $x = (get_headers($mylink, 1));
                //$x = '';
//print_r($x['Location'][0]);
                print_r($x['Location'][1]);
                echo "<br/>";
                if (strlen($x['Location'][1]) > 5) {

                    //echo "https://www.google.co.in/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=site%3A".$x['Location'][1];

                    //$y=url_get_contents("https://www.google.co.in/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=site%3A".$x['Location'][1]);
                    $in = $x['Location'][1];
                    $in = str_replace(' ', '+', $in); // space is a +
                    $url = "https://www.google.co.in/search?q=site%3A" . $x['Location'][1];

                    print $url . "<br>";


                    /* $html = file_get_html($url);
                     //print_r($html);
                     $i=0;
                     $linkObjs = $html->find('h3.r a');
                     foreach ($linkObjs as $linkObj) {
                         echo 99;
                         //print_r($linkObj);
                         echo "<br/>";
                         $title = trim($linkObj->plaintext);
                         $link  = trim($linkObj->href);
                         print_r($title);
                         print_r($link);

                         // if it is not a direct link but url reference found inside it, then extract
                         if (!preg_match('/^https?/', $link) && preg_match('/q=(.+)&amp;sa=/U', $link, $matches) && preg_match('/^https?/', $matches[1])) {
                             $link = $matches[1];
                         } else if (!preg_match('/^https?/', $link)) { // skip if it is not a valid link
                             continue;
                         }

                         $descr = $html->find('span.st',$i); // description is not a child element of H3 thereforce we use a counter and recheck.
                         $i++;
                         echo '<p>Title: ' . $title . '<br />';
                         echo 'Link: ' . $link . '<br />';
                         echo 'Description: ' . $descr . '</p>';
                     }*/

                    //print_r($y);
                    echo "<br/>";
                    echo "<br/>";
                    echo "<br/>";
                    echo "<br/>";
                    echo "<br/>";
                    echo "<br/>";


                } else {


                    echo $sqlu = "update  ripoff_urls set url_status='notfound url' where id = " .$row['id'];
                    $conn->query($sqlu);

                }

            }
            echo '</pre>';
        }
    }
    $l+=10000;
}

fclose($file);

/*function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}


// Set path to CSV file
$csvFile = 'csvs/Ripoff_Report_URLs.csv';

$csv = readCSV($csvFile);
echo '<pre>';
print_r($csv);
echo '</pre>';*/







/*$mylink="http://ripoffreport.com//Cash-Services/CHECK-INTO-CASH-OREG/check-into-cash-state-of-orego-G8E5D.htm
/Cash-Services/Check-Into-Cash/check-into-cash-ripoff-omaha-n-2W97D.htm";

$url = $mylink;


$url = 'http://www.example.com';

///print_r(get_headers($mylink));

//print_r(get_headers($mylink, 1));
$x=(get_headers($mylink, 1));
//print_r($x['Location'][0]);
print_r($x['Location'][1]);*/



function url_get_contents($url, $useragent='cURL', $headers=false, $follow_redirects=true, $debug=false) {

    // initialise the CURL library
    $ch = curl_init();

    // specify the URL to be retrieved
    curl_setopt($ch, CURLOPT_URL,$url);

    // we want to get the contents of the URL and store it in a variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    // specify the useragent: this is a required courtesy to site owners
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

    // ignore SSL errors
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // return headers as requested
    if ($headers==true){
        curl_setopt($ch, CURLOPT_HEADER,1);
    }

    // only return headers
    if ($headers=='headers only') {
        curl_setopt($ch, CURLOPT_NOBODY ,1);
    }

    // follow redirects - note this is disabled by default in most PHP installs from 4.4.4 up
    if ($follow_redirects==true) {
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    }

    // if debugging, return an array with CURL's debug info and the URL contents
    if ($debug==true) {
        $result['contents']=curl_exec($ch);
        $result['info']=curl_getinfo($ch);
    }

    // otherwise just return the contents as a variable
    else $result=curl_exec($ch);

    // free resources
    curl_close($ch);

    // send back the data
    return $result;
}


function strip_tags_content($text, $tags = '', $invert = FALSE) {
    /*
    This function removes all html tags and the contents within them
    unlike strip_tags which only removes the tags themselves.
    */
    //removes <br> often found in google result text, which is not handled below
    $text = str_ireplace('<br>', '', $text);

    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);

    if(is_array($tags) AND count($tags) > 0) {
        //if invert is false, it will remove all tags except those passed a
        if($invert == FALSE) {
            return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            //if invert is true, it will remove only the tags passed to this function
        } else {
            return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
        }
        //if no tags were passed to this function, simply remove all the tags
    } elseif($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }

    return $text;
}

function file_get_contents_curl($url) {
    /*
    This is a file_get_contents replacement function using cURL
    One slight difference is that it uses your browser's idenity
    as it's own when contacting google.
    */
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_USERAGENT,	$_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}



?>