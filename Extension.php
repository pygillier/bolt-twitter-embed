<?php
namespace Bolt\Extension\pygillier\TwitterEmbed;


use Bolt\Application;
use Bolt\BaseExtension;
use Bolt\Events\StorageEvents;
use Bolt\Events\StorageEvent;
use Freebird\Services\freebird\Client as FreeBirdClient;

class Extension extends BaseExtension
{
  
    private $regex = '#\[tweet (?:id=(?P<id>\d*))?(?:url=(?P<url>.*))?\s*\]#i';

    public function initialize() {
        // Pre-save event
        $this->app['dispatcher']->addListener(StorageEvents::PRE_SAVE, array($this,'preSave'));
    }

    public function getName() {
        return "TwitterEmbed";
    }

    /**
     * Replace shortcodes with actual tweet content
     *
     * @uses  getEmbed()
     * @param StorageEvent $event
     */
    function preSave(StorageEvent $event) {
        
        $record = $event->getContent();
        
        $newbody = preg_replace_callback(
            $this->regex, 
            array($this, 'getEmbed'),
            $record->get('body')
        );
        
        $record->setValue('body', $newbody);
    }
    
    private function getEmbed($match) {
        
        // Get keys from configuration
        $key = $this->config['consumer_key'];
        $secret = $this->config['consumer_secret'];
        
        $request_params = array();
        
        if($match['id'] !="")
            $request_params['id'] = $match['id'];
        elseif($match['url'] !="")
            $request_params['url'] = $match['url'];
        else // No params. Return original content
            return $match[0];
         
        
        try {
            $client = new \Freebird\Services\freebird\Client();
            $client->init_bearer_token($key, $secret);
        
            $response = $client->api_request('statuses/oembed.json', $request_params);
    
            $result = json_decode($response);
            return $result->html;
        }
        catch(\Exception $e) {
            // An error occured.
            // We return the original content for a later update if available
            return $match[0];
        }
        
    }
}