<?php
/**
 * UserAgent Deny Policy
 * Katana PHP Firewall
 * NinjaSentry.com
 * Last Updated : 28th Jan 2016
 */

/*
return [
    '(?:synapse|acunetix|nessus|appscan|fhscan|fingerprint|xenu|ympne|chroot|0day'
    . '|proxy\sgear\spro|bot\sfor\sjce|getintent|voltron|ahrefs|appengine|admant|common\.crawl\.zone'
    . '|http_client|\bscript\b|alert\('
    . '|\b(?:(?:crawl|check|spid|harvest|index|scrap)(?:er)?(?:ing)?)\b)'
];
*/

return [
    '(?:',
    '0day',
    '|(?:<|&lt;|\s)?script',
    '|\balert\(',

    //'|spider',

    '|(?:[cr][\d]{2,3}|g00n(\s?shell)?)', // c99, c100, r57, r58, g00n shell etc
    '|\b(?:(?:crawl|check|harvest|index|scrap(?:e)?|search|spid(?:er)?)(er|ing)?)\b',

    //'|spider',

    //'(blek(?:k(?:o))?m(?:j12)?|l?(?:t)?)bot', // ^_-
    '|(?:accelo|ad|aihit|bintelli|beetle|blekko|blex|buffer|career|compspy|disco|discovery|giga|istella|komodia|km|lt|mj12|ml|nb\-|ro|semrush|zum)?bot',
    //'|bot',
    // bot, adbot, accelobot, aihitbot,
    // bintellibot, beetle,
    // kmbot, mj12bot, mlbot, ltbot

    '|Google\sPage\sSpeed\sInsights',
    '|baidu',
    '|yandex',
    '|BingPreview',

    '|200please',
    '|360Spider',
    '|80legs\.com',

    '|a6corp',
    '|Aboundex',
    '|acoon\.de',
    '|admantx',
    '|Add\sCatalog',
    '|ahrefs',

    '|Anemone',
    '|appengine',
    '|acunetix',
    '|appscan',
    '|autoit',

    '|Babya\sDiscoverer',
    '|Bender',
    '|Blog\sSearch',
    '|bl\.uk_lddc_bot',
    '|BoardReader',
    '|bot\sfor\sjce',
    '|brandwatch\.net',
    '|Butterfly',

    '|Chilkat',
    '|chroot',
    '|ClickSense',
    '|cmscrawler',
    '|cmsworldmap\.com',
    '|coccoc',
    '|common\.crawl\.zone',
    //'|CompSpyBot',
    '|Content\sCrawler',
    '|Content\sParser',
    '|ContextAd',
    '|Covario\-IDS',
    '|crawler4j',

    '|CrystalSemanticsBot',

    '|DataCha0s',
    '|dataprovider',
    '|Daumoa',
    '|dcrawl',
    '|deepnet\sexplorer',
    '|DigExt',
   // '|discobot',
   // '|discoverybot',

    '|discoveryengine',
    '|dtsagent',

    '|distributed',
    '|Dolphin',
    '|DomainCrawler',
    '|dotbot',
    '|Drupal',
    '|Dynamic\sSignal',

    '|EasouSpider',
    '|EC2LinkFinder',
    '|elfinbot',
    '|EnaBot',
    '|envolk',
    '|EuripBot',
    '|EventMachine',
    '|evrinid',
    '|extractor',
    '|ezooms',

    '|Falconsbot',
    '|FairShare',
    '|fastbot',
    '|fhscan',
    '|findlinks',
    '|fingerprint',
    '|FlipboardProxy',
    '|FollowSite',
    '|FyberSpider',


    '|gamekitbot',
    '|Generalbot',
    '|Genieo',
    //'|Gigabot',
    '|GoScraper',
    '|GrapeshotCrawler',
    '|GrepNetstat',
    '|gsa\-crawler',
    '|GTmetrix',
    '|gvfs',

    '|getintent',
    '|gsa\-crawler',

    '|hackteam',
    '|http_client',
    '|hatena\.ne\.jp',
    '|heritrix',
    '|http_request2',
    '|httrack',
    '|HuaweiSymantecSpider',

    '|Identify',
    '|ifsdb\.com',
    '|InAGist',

    '|in(?:boundscore|fobot|stapaper|te(?:gromedb|lium_bot))',

    '|Infos\-du\-net\-bot',
   // '|istellabot',
    '|Jetslide',
    '|JikeSpider',
    '|JS\-Kit',
    '|Kimengi',
    // '|kmbot',
    // '|KomodiaBot',
    '|Kraken',
    '|larbin',
    '|lb\-spider',
    '|lemurwebcrawler',
    '|li(?:bcurl|bwww\-perl|nguee)', // libcurl, , libwww-perl, linguee

    '|link(?:s)(?:checker|crawler|dex\.com|fluence|man|)?',

    '|lipperhey',
    '|Liquida\sSpider',
    '|LSSRocketCrawler',

    '|lwp\-request',
    '|Mail\.RU',
    '|magpie\-crawler',
    '|meanpathbot',
    '|megaindex',
    '|MetaURI',
    '|MFE_expand',
    '|MittoTester',

    '|nessus',

    '|openlinkprofiler',
    '|opensiteexplore',

    '|proximic',
    '|proxy\sgear\spro',

    '|riddler\.io',

    '|search(?:dnabot|metricsBot)',
    '|semalt',

    '|snitch',
    '|snoopy',
    '|sogou',
    '|sosospider',

    '|Space Bison',
    '|spbot',
    '|speedy_spider',
    '|Spinn3r',
    '|socialbm_bot',
    '|sSearch',
    '|Statsbot',
    '|suggybot',
    '|SuperBot',
    '|surveybot',
    '|synapse',

    '|talktalk',
    '|tencenttraveler',
    '|tineye',
    '|TipTop',
    '|Toread\-Crawler',
    '|TurnitinBot',
    '|TweetmemeBot',
    '|twiceler',

    '|unister',
    '|unwindfetchor',
    '|updownerbot',

    '|vagabondo',
    '|verticalpigeon',
    '|voilabot',
    '|vbseo',
    '|vocus',
    '|voyager',

    '|wasalive\-bot',
    '|wbsearchbot',
    '|webdatacentrebot',
    '|webspider',
    '|web\-sniffer',
    '|wesee',

    '|wiamond\-bot',
    '|wikimpress',
    '|winhttp',
    '|wordpress',
    '|wotbox',

    '|YesupBot',
    '|YoudaoBot',
    '|your\-search\-bot',
    '|YYSpider',

    '|xenu',
    '|ympne',
    '|Zend_Http_Client',
    '|ZillaCrawler',
    ')'
];