<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*	email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.     */
/*                                                                                   */
/*************************************************************************************/

namespace Thelia\Tests\Log;

use Thelia\Log\Tlog;

class TlogTest extends \PHPUnit_Framework_TestCase
{
    protected static $logger;

    protected $regex = "/(\\d)(:)(\\s+)(%s)(\\s+)(\\[.*?\\])(\\s+)(\\{.*?\\})(\\s+)((?:2|1)\\d{3}(?:-|\\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))(.)(\\s+)(%s)([\n])/is";

    public static function setUpBeforeClass()
    {   
        if (!\Propel::isInit()){
            \Propel::init(THELIA_ROOT . "/local/config/config_thelia.php");
        }
        
        self::$logger = Tlog::getInstance();
        
        self::$logger->setDestinations("Thelia\Log\Destination\TlogDestinationText");
        self::$logger->setLevel(Tlog::DEBUG);
        self::$logger->setFiles("*");
    }

    public function testDebugWithDebugLevel()
    {

        $logger = self::$logger;
        $logger->setLevel(Tlog::DEBUG);

        //"#NUM: #NIVEAU [#FICHIER:#FONCTION()] {#LIGNE} #DATE #HEURE: "
        $this->expectOutputRegex(sprintf($this->regex, "DEBUG", "foo"));
        $logger->debug("foo");
    }

    public function testDebugWithoutDebugLevel()
    {
        $logger = self::$logger;
        $logger->setLevel(Tlog::MUET);

        $this->expectOutputRegex("/^$/");
        $logger->debug("foo");
    }
    
    public function testDebugWithInfoLevel()
    {

        $logger = self::$logger;
        $logger->setLevel(Tlog::INFO);

        //"#NUM: #NIVEAU [#FICHIER:#FONCTION()] {#LIGNE} #DATE #HEURE: "
        $this->expectOutputRegex(sprintf($this->regex, "INFO", "foo"));
        $logger->info("foo");
    }

    public function testDebugWithoutInfoLevel()
    {
        $logger = self::$logger;
        $logger->setLevel(Tlog::MUET);

        $this->expectOutputRegex("/^$/");
        $logger->info("foo");
    }
    
    public function testDebugWithNoticeLevel()
    {

        $logger = self::$logger;
        $logger->setLevel(Tlog::NOTICE);

        //"#NUM: #NIVEAU [#FICHIER:#FONCTION()] {#LIGNE} #DATE #HEURE: "
        $this->expectOutputRegex(sprintf($this->regex, "NOTICE", "foo"));
        $logger->notice("foo");
    }

    public function testDebugWithoutNoticeLevel()
    {
        $logger = self::$logger;
        $logger->setLevel(Tlog::MUET);

        $this->expectOutputRegex("/^$/");
        $logger->notice("foo");
    }

    public function testWarningWithWarningLevel()
    {

        $logger = self::$logger;
        $logger->setLevel(Tlog::WARNING);

        //"#NUM: #NIVEAU [#FICHIER:#FONCTION()] {#LIGNE} #DATE #HEURE: "
        $this->expectOutputRegex(sprintf($this->regex, "WARNING", "foo"));
        $logger->warning("foo");
    }

    public function testWarningWithoutWarningLevel()
    {
        $logger = self::$logger;
        $logger->setLevel(Tlog::MUET);

        $this->expectOutputRegex("/^$/");
        $logger->warning("foo");
    }

    public function testErrorWithErrorLevel()
    {

        $logger = self::$logger;
        $logger->setLevel(Tlog::ERROR);

        //"#NUM: #NIVEAU [#FICHIER:#FONCTION()] {#LIGNE} #DATE #HEURE: "
        $this->expectOutputRegex(sprintf($this->regex, "ERROR", "foo"));
        $logger->error("foo");
    }

    public function testErrorWithoutErrorLevel()
    {
        $logger = self::$logger;
        $logger->setLevel(Tlog::MUET);

        $this->expectOutputRegex("/^$/");
        $logger->error("foo");
    }
    
    public function testErrorWithCriticalLevel()
    {

        $logger = self::$logger;
        $logger->setLevel(Tlog::CRITICAL);

        //"#NUM: #NIVEAU [#FICHIER:#FONCTION()] {#LIGNE} #DATE #HEURE: "
        $this->expectOutputRegex(sprintf($this->regex, "CRITICAL", "foo"));
        $logger->critical("foo");
    }

    public function testErrorWithoutCriticalLevel()
    {
        $logger = self::$logger;
        $logger->setLevel(Tlog::MUET);

        $this->expectOutputRegex("/^$/");
        $logger->critical("foo");
    }
    
    public function testErrorWithAlertLevel()
    {

        $logger = self::$logger;
        $logger->setLevel(Tlog::ALERT);

        //"#NUM: #NIVEAU [#FICHIER:#FONCTION()] {#LIGNE} #DATE #HEURE: "
        $this->expectOutputRegex(sprintf($this->regex, "ALERT", "foo"));
        $logger->alert("foo");
    }

    public function testErrorWithoutAlertLevel()
    {
        $logger = self::$logger;
        $logger->setLevel(Tlog::MUET);

        $this->expectOutputRegex("/^$/");
        $logger->alert("foo");
    }
    
    public function testErrorWithEmergencyLevel()
    {

        $logger = self::$logger;
        $logger->setLevel(Tlog::EMERGENCY);

        //"#NUM: #NIVEAU [#FICHIER:#FONCTION()] {#LIGNE} #DATE #HEURE: "
        $this->expectOutputRegex(sprintf($this->regex, "EMERGENCY", "foo"));
        $logger->emergency("foo");
    }

    public function testErrorWithoutEmergencyLevel()
    {
        $logger = self::$logger;
        $logger->setLevel(Tlog::MUET);

        $this->expectOutputRegex("/^$/");
        $logger->emergency("foo");
    }
}
