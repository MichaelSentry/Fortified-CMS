<?php
namespace NinjaSentry\Katana\Firewall\Client;

/**
 * @author Michael
 * @site NinjaSentry
 * @description Client Public Access Group Controller
 *
 * ---------------------------------------------------------------------
 * Public Access Groups for non logged in visitors
 * ---------------------------------------------------------------------
 * 01 Banned   | Access Denied - History of Policy Violations
 * 02 Intruder | Intrusion attempts, attacks, probes, exploit scans
 * 04 SE Fraud | Fake search engine
 * 08 Parasite | Scraper, harvester, hot linking etc
 * 16 Bot      | Low risk crawler / bot
 * 32 SE       | Validated search engine
 * 64 Guest    | Standard public access group
 * ---------------------------------------------------------------------
 * 128 Staff   | eg : Admin group with Stealth Login / ACL policy match
 * ---------------------------------------------------------------------
 */

/**
 * Class Group
 * @package NinjaSentry\Katana\Firewall\Client
 */
class Group
{
    const BANNED         = 1;
    const INTRUDER       = 2;
    const SE_FRAUD       = 4;
    const PARASITE       = 8;
    const BOT            = 16;
    CONST SEARCH_ENGINE  = 32;
    CONST GUEST          = 64;
    CONST STAFF          = 128;
}
