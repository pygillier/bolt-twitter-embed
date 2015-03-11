<?php
namespace Bolt\Extension\pygillier\TwitterEmbed;

// Dev mode

include_once(dirname(__FILE__).'/lib/freebird/Client.php');
include_once(dirname(__FILE__).'/lib/freebird/RequestHandler.php');

$app['extensions']->register(new Extension($app));
