<?php

namespace Tests\Feature\Webcheckout;

use App\Request\CreateSessionRequest;
use App\Request\GetInformationRequest;
use App\Services\WebcheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\Matcher\Type;
use SebastianBergmann\Type\TypeName;
use Tests\TestCase;

use function PHPSTORM_META\type;

class WebcheckoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItCanGetInformationRequest()
    {
        $request = (new GetInformationRequest())->auth();
        $this->assertAuthSuccess($request);

    }
    public function testItCanGetCreateSessionRequest()
    {
        $request = (new CreateSessionRequest($this->getSessionData()))->toArray();
        
        $this->assertAuthSuccess($request);

        $this->assertArrayHasKey('payment',$request);
        $this->assertArrayHasKey('expiration',$request);
        $this->assertArrayHasKey('returnUrl',$request);
        $this->assertArrayHasKey('ipAddress',$request);
        $this->assertArrayHasKey('userAgent',$request);
    }

    public function testItCanCreateSessionFromService()
    {
        $data = $this->getSessionData();
        //dd($data);
        $request = (new WebcheckoutService())->createSession($data);
        //dd($request);
        $this->assertObjectHasAttribute('status',$request);
        $this->assertEquals('OK',$request->status->status);
        $this->assertObjectHasAttribute('requestId',$request);
        $this->assertObjectHasAttribute('processUrl',$request);
        $sessionId = $request->requestId;
        //dd($sessionId);
        $responseGetSession = $request = (new WebcheckoutService())->getInformation($sessionId);
        $this->assertEquals($sessionId,$responseGetSession->requestId);
        $this->assertObjectHasAttribute('status',$request);
        $this->assertEquals('PENDING',$request->status->status);
    }

    public function testItGetInformationFronServiceCorrectly()
    {
        $session_id = 51925;
        $responseGetSession = $request = (new WebcheckoutService())->getInformation($session_id);

        $this->assertEquals($session_id,$responseGetSession->requestId);
        $this->assertObjectHasAttribute('status',$request);
        //dd($request->status->status);
        $this->assertEquals('PENDING',$request->status->status);
    }

    
    /**
     * @param array $request
     * 51925
     */
    private function assertAuthSuccess(array $request): void
    {
        $this->assertArrayHasKey('auth',$request);
        $this->assertArrayHasKey('login',$request['auth']);
        $this->assertArrayHasKey('tranKey',$request['auth']);
        $this->assertArrayHasKey('nonce',$request['auth']);
        $this->assertArrayHasKey('seed',$request['auth']);
    }

    private function getSessionData(): array
    {
        return [
            'payment' => [
                'reference' => 'TEST_1000',
                'description' => 'conexion con webcheckout desde un test',
                'amount' => [
                    'currency' => 'COP',
                    'total' => '10000',
                ]
            ],
            'returnUrl' => route('productsClient.index'),
            'expiration' => date('c',strtotime('+2 days')),

        ];
    }
}