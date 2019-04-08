<?php
namespace Tests;

use Tests\BaseTestCase;
use Dr\Hc\System\Info;

class SystemTest extends BaseTestCase
{
    public function testCheckServiceInfoWithStatusUp()
    {
        $info = new Info;
        $response = $info->get();
        $this->assertEquals(12, count($response));
    }
}
