<?php


namespace App\Tests\Helper;


use App\Helper\Util;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UtilHelperTest extends TestCase
{
    public function testStripHtmlTags()
    {
        $resp = Util::stripHtmlTags(['the field <span>name</span> is required']);

        $this->assertEquals('the field name is required', $resp[0]);
    }

    public function testGenerateRandomShortCode()
    {
        $resp = Util::generateRandomShortCode();

        $this->assertEquals(4, strlen($resp));
    }

    public function testGenerateRandomShortCodeWithLengthZero()
    {
        $resp = Util::generateRandomShortCode(0);

        $this->assertEquals(0, strlen($resp));
    }
}