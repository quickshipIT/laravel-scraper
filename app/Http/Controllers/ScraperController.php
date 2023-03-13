<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as guzclient;  
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

use DOMDocument;
use DOMXPath;

class ScraperController extends Controller
{
    private $results = array();

    public function scraper()
    {
  
        $productName= 'Apple iPhone 14 mobile';
        
      $amazon=$this->amazon($productName);
      $aliexpress=$this->aliexpress($productName);
    $data []=["amazon"=>$amazon,'aliexpress'=>$aliexpress];
       
        //    $data['noon']=$this->noon($productName);
    return $data;

        $data = $this->results;
        return view('scraper', compact('data'));
    }
    public function amazon($productName)
    {
    $client = new Client();
    $url = 'https://www.amazon.ae/s?k='.$productName;
    $page = $client->request('GET', $url);
    
    $elements = $page->filter('.s-card-container')->each(function($node){   
        $product_details=[];
        $product_details['name']=$node->filter('h2')->text();
        $product_details['rating']=$node->filter('.a-size-base')->text();
        $product_details['review']=$node->filter('.a-size-base.s-underline-text')->text();
        $product_details['sold']='';
        $product_details['price']=$node->filter('span.a-offscreen')->text();
        $product_details['image']=$node->filter('img')->attr('src');
        $raw_url=$node->filter('a')->attr('href');
        $product_details['url']='https://www.amazon.ae'.$raw_url;
        $product_details['platform']='Amazon';
        return $product_details;
    });

    return response()->json($elements);
}
public function alibaba($productName)
{       

$xml = '
<books>
    <book>
        <title>Book 1</title>
        <author>Author 1</author>
    </book>
    <book>
        <title>Book 2</title>
        <author>Author 2</author>
    </book>
    <book>
        <title>Book 3</title>
        <author>Author 3</author>
    </book>
</books>';

$dom = new DOMDocument();
$dom->loadXML($xml);

$xpath = new DOMXPath($dom);
$nodes = $xpath->query('//book');
$book=[];
foreach ($nodes as $node) { 
    
    $title = $xpath->query('./title', $node)->item(0)->nodeValue;
    $author = $xpath->query('./author', $node)->item(0)->nodeValue;
   $book[]=['tittle'=>$title,'author'=>$author];
}
print_r($book);
}
public function aliexpress($productName)
{
 
    $cookieJar = new CookieJar();
    $cookie = new SetCookie([
        
    ]);
    $cookieJar->setCookie($cookie);
$client = new guzclient([
    'verify' => false,
]);
$url = 'https://www.aliexpress.com/w/wholesale-'.$productName.'.html';
$page = $client->request('GET', $url, 
    [
        'headers' => [
            'cookie' => 'xman_t=4vmlArKvY0adDbUOo89KMrOMzcOsoOxcEZnmOigBN0OX4vaHR8FdSaoAvoPQcEbc; ali_apache_id=33.3.33.180.1677742537222.231830.2; _fbp=fb.1.1677742546033.737173338; _gcl_au=1.1.2111924743.1677742548; _ym_uid=1677742549690216173; _ym_d=1677742549; ali_apache_track=; e_id=pt20; af_ss_a=1; _gid=GA1.2.574189742.1678086194; aep_history=keywords%5E%0Akeywords%09%0A%0Aproduct_selloffer%5E%0Aproduct_selloffer%091005005261745896; xman_f=o49HpxFKdVoCQQPiXBcFiENsybl2c8EuyRJbbbTP+RXsb08na5lNtvokZeqKW0qbReaRqDHeLQPHxkB0K8UMG7uLleicT0xrCpomGOr1HwvrdfVWonC7tQ==; cna=IriNHB/aoS4CAVZiIvZq9y/G; _ym_isad=2; aep_usuc_f=site=glo&c_tp=AED&s_locale=en_US&region=AE&b_locale=en_US; aeu_cid=2edba2063a1449d0baca4eb4ef41b7b5-1678167458717-00588-_Dlpp6P9; af_ss_b=1; _gac_UA-17640202-1=1.1678167460.EAIaIQobChMI3LX994zJ_QIVg9dRCh0hrgHREAAYASAAEgLAZPD_BwE; _gcl_aw=GCL.1678167460.EAIaIQobChMI3LX994zJ_QIVg9dRCh0hrgHREAAYASAAEgLAZPD_BwE; xlly_s=1; traffic_se_co=%7B%7D; acs_usuc_t=x_csrf=4oqcja4m49u_&acs_rt=e3540f0639384791a248186aa96c72d4; intl_locale=en_US; ali_apache_tracktmp=; AKA_A2=A; JSESSIONID=80932BA308201B3B101BB0F3D963D6F0; _m_h5_tk=3d77db8fb41bcd56103b1a67dfa42439_1678189291984; _m_h5_tk_enc=8edf126669b353ac4b91349e4bdc9d92; _ym_visorc=b; _gat=1; xman_us_f=x_locale=en_US&x_l=0&x_c_chg=0&x_as_i=%7B%22aeuCID%22%3A%222edba2063a1449d0baca4eb4ef41b7b5-1678167458717-00588-_Dlpp6P9%22%2C%22affiliateKey%22%3A%22_Dlpp6P9%22%2C%22channel%22%3A%22AFFILIATE%22%2C%22cv%22%3A%221%22%2C%22isCookieCache%22%3A%22N%22%2C%22ms%22%3A%221%22%2C%22pid%22%3A%22712794464%22%2C%22tagtime%22%3A1678167458717%7D&acs_rt=d834d6e620ee4d3fb72ff4620b93e14c; intl_common_forever=MsoStXBfzuadc7Hw8sixQ31gcHYVWTLLVzcsr1Xm/vZhGdEULI9pZw==; cto_bundle=cqkCxl9OWXM3UG1mVHNXNWlFN3hiNFZOJTJGM254SDBLcmFmdndVaGVsdUpQU2dUWWglMkJseTRUdmZhVzhqZWNBaURIWlB3Yk1SY0xDUXdwOHVpMyUyRkpqemJ3ZGFhY3NVc0dLRkp6RmlVTTEyMGNyZGowbFFaZGI5eTdLWTE1aFR3c3B2d1NrekNyUiUyQjBXbWk1bE9Bc3dsNmUyeXY1QSUzRCUzRA; _ga_VED1YSGNC7=GS1.1.1678187135.12.1.1678187241.0.0.0; _ga=GA1.1.803260664.1677742546; l=fBN8TyPnNQ_GCjQzBOfwFurza77tIIRA_uPzaNbMi9fPO01H5LKPW1GodoTMCnMNF6lkR3ub1k7yBeYBqIYGkkwjSTpDgQHmn_vWSGf..; tfstk=cZIhBV4y3w8CnIrR16tQmJwaxTPOZ7zeOgSNbRN-i_tWLejNi9gZuW4uIBFbT41..; isg=BDw8SA9udMgIJUCTl2KbY3aNDdruNeBfLqG5hha9TicK4dxrPkb17ZhTwRGZrhi3; RT="z=1&dm=aliexpress.com&si=c59abe36-2962-4020-854e-70386bab2ed1&ss=ley5ai98&sl=3&tt=wl&obo=2&rl=1&ld=2i6c&r=12jcsnrj3&ul=2i6d"',
]]); 

    if ($page->getStatusCode() == 200) {

        $html = (string) $page->getBody();
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
// Get any errors that occurred during parsing
$errors = libxml_get_errors();

// Process the document here

libxml_clear_errors();

$xpath = new DOMXPath($dom);

$nodes = $xpath->query("//*[contains(@class, 'cards--gallery')]");
$product_details=[];
foreach ($nodes as $node) {

    $url=  $xpath->query("@href", $node)->item(0)->nodeValue;
    $image_check = $xpath->query("./div//img/@src", $node)->item(0);
    $name =$xpath->query(".//*[contains(@class,'manhattan--title')]", $node)->item(0)->textContent;
    $price=$xpath->query(".//*[contains(@class,'manhattan--price')]", $node)->item(0)->textContent;
    $rating_check=$xpath->query(".//*[contains(@class,'manhattan--evaluation')]",$node)->item(0);
    $sold=$xpath->query(".//*[contains(@class,'manhattan--trade--')]", $node)->item(0)->textContent;
    $platform='aliexpress';
    if($image_check !== null)
    {
        $image =$image_check->nodeValue;
    }
    else
    {
        $image =''; 
    }
    if ($rating_check !== null) {
        $rating = $rating_check->textContent;
    } else {
       $rating='';
    }

    $product_details[]=['name'=>$name,'rating'=>$rating,'review'=>'','sold'=> $sold,'price'=>$price,'image'=>$image,'url'=>$url,'platform'=>$platform];
}
// print_r($product_details); 

return response()->json($product_details);  
    }
}
public function noon($productName)
{
$client = new Client(); 
$url = 'https://www.noon.com/uae-en/search/?q='.$productName;
$page = $client->request('GET', $url); 
echo $page->html();
//  $res= $page->filter('#root > div > div > div > div > div > div > div > div > div > div > div > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > a')->attr('href');
//  echo $res;
// $page_details = $client->request('GET',$res);

//  $response =[];
// $tittle =  $page_details->filter('#titleSection #title')->text();
// $price  =  $page_details->filter('#corePrice_feature_div .a-section .a-price .a-offscreen')->text();
// $rating =  $page_details->filter('.averageStarRating')->text();
// $review =  $page_details->filter('#acrCustomerReviewText')->text(); 
// $img    =  $page_details->filter('#imgTagWrapperId img')->attr("src");

// if($page_details->filter('#sellerProfileTriggerId')->count() >  0 )
// {
//     $supplier= $page_details->filter('#sellerProfileTriggerId')->text()."<br>";
    
// }
// else
// {
//     $supplier=$page_details->filter('#tabular-buybox .tabular-buybox-text-message')->text()."<br>";
// }
// $response=['Tittle'=>$tittle,'Price'=>$price,'Rating'=>$rating,'Review'=>$review,'Img'=>$img,'Supplier'=>$supplier,'Platform'=>"Amazon"];

// return $response;
}
}
?>