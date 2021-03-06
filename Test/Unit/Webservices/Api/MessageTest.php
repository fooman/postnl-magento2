<?php
/**
 *
 *          ..::..
 *     ..::::::::::::..
 *   ::'''''':''::'''''::
 *   ::..  ..:  :  ....::
 *   ::::  :::  :  :   ::
 *   ::::  :::  :  ''' ::
 *   ::::..:::..::.....::
 *     ''::::::::::::''
 *          ''::''
 *
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Creative Commons License.
 * It is available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to servicedesk@tig.nl so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact servicedesk@tig.nl for more information.
 *
 * @copyright   Copyright (c) Total Internet Group B.V. https://tig.nl/copyright
 * @license     http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 */
namespace TIG\PostNL\Test\Unit\Webservices\Api;

use TIG\PostNL\Test\TestCase;
use TIG\PostNL\Webservices\Api\Message;
use TIG\PostNL\Helper\Data as postNLhelper;

class MessageTest extends TestCase
{
    protected $instanceClass  = Message::class;

    public function testGet()
    {
        $messageIdString = 'string';

        $helperMock = $this->getFakeMock(postNLhelper::class)->getMock();
        $getCurrentTimeStampExpects = $helperMock->expects($this->once());
        $getCurrentTimeStampExpects->method('getCurrentTimeStamp');
        $getCurrentTimeStampExpects->willReturn('31-12-1969 16:00:00');

        $instance = $this->getInstance(
            ['postNLhelper' => $helperMock]
        );
        $this->setProperty('messageIdStrings', ['' => $messageIdString], $instance);

        $result = $instance->get('');

        $this->assertEquals([
            'MessageID' => 'b45cffe084dd3d20d928bee85e7b0f21',
            'MessageTimeStamp' => '31-12-1969 16:00:00',
        ], $result);
    }

    public function getExtraProvider()
    {
        return [
            [['extraTest' => 'test']],
            [['Message' => 'test', 'extraTest' => 'test']],
        ];
    }

    /**
     * @dataProvider getExtraProvider
     *
     * @param $arrayMustContain
     */
    public function testGetExtra($arrayMustContain)
    {
        $instance = $this->getInstance();
        $result = $instance->get('', $arrayMustContain);

        foreach ($arrayMustContain as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($value, $result[$key]);
        }
    }
}
