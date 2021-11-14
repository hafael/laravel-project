<?php

namespace Autum\SAML\Http\Controllers\Auth;

use App\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LightSaml\Model\Protocol\AuthnRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\URL;

class SamlController extends BaseController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        Log::info('SAML RESPONSE START');
        Log::info(json_encode($request->all()));

        if($request->filled('SAMLResponse'))
        {
            $response = base64_decode($request->input('SAMLResponse'));
            Log::info($response);

            $dom = new DOMDocument();
            $dom->loadXML($response);
            $doc = $dom->documentElement;
            $xpath = new DOMXPath($dom);
            $xpath->registerNamespace('samlp', 'urn:oasis:names:tc:SAML:2.0:protocol');
            $xpath->registerNamespace('saml', 'urn:oasis:names:tc:SAML:2.0:assertion');
            
            $data = [];

            foreach ($xpath->query('/samlp:Response/saml:Assertion/saml:AttributeStatement/saml:Attribute', $doc) as $attr) {
                Log::info(" # Attribute: " . $attr->getAttribute('Name') . "\n");
                foreach ($xpath->query('saml:AttributeValue', $attr) as $value) {
                    Log::info("   Value: " . $value->textContent . "\n");
                    $data[basename($attr->getAttribute('Name'))] = $value->textContent;
                }
            }

            $id = collect($data)->only(['privatepersonalidentifier'])->first();
            $name = collect($data)->only(['CommonName'])->first();
            $email = collect($data)->only(['emailaddress'])->first();

            $user = User::where('email', $email)->first();

            if(empty($user))
            {
                $user = User::make([
                    'id' => $id,
                    'email' => $email,
                    'name' => $name,
                ]);

                $user->forceFill(['id' => $id])
                     ->save();
            }else{
                $diff = collect([
                    'name' => $name,
                ])->diffAssoc($user->only(['name']));

                $user->update($diff->all());
            }

            Log::info(json_encode($user->toArray()));

            Log::info(json_encode($data));

            Auth::login($user);

            return redirect()->route(config('saml.auth_redirect_route'));
        }
        

        Log::info('SAML RESPONSE END');

        return redirect()->route(config('saml.redirect_route'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        $authnRequest = new AuthnRequest();
        $authnRequest
            ->setAssertionConsumerServiceURL(route(config('saml.signin_route', 'signin')))
            ->setProtocolBinding(\LightSaml\SamlConstants::BINDING_SAML2_HTTP_POST)
            ->setID(\LightSaml\Helper::generateID())
            ->setIssueInstant(new \DateTime())
            ->setDestination(config('saml.autum_auth_url', 'https://autum.com.br/login'))
            ->setIssuer(new \LightSaml\Model\Assertion\Issuer(URL::to('/')));


            $bindingFactory = new \LightSaml\Binding\BindingFactory();
            $redirectBinding = $bindingFactory->create(\LightSaml\SamlConstants::BINDING_SAML2_HTTP_REDIRECT);

            $messageContext = new \LightSaml\Context\Profile\MessageContext();
            $messageContext->setMessage($authnRequest);

            /** @var \Symfony\Component\HttpFoundation\RedirectResponse $httpResponse */
            $httpResponse = $redirectBinding->send($messageContext);
            $targetUrl =  $httpResponse->getTargetUrl();
            
            return redirect()->away($targetUrl);
    }

}
