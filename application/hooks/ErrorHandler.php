<?php
class ErrorHandler 
{
    public function run() 
    {
        if (ENVIRONMENT == "development") 
        {
            $run     = new \Whoops\Run;
            $handler = new \Whoops\Handler\PrettyPageHandler;
            $handler->setPageTitle("Whoops! There was a problem.");
            $run->pushHandler($handler);
            if (\Whoops\Util\Misc::isAjaxRequest()) {
              $run->pushHandler(new \Whoops\Handler\JsonResponseHandler);
            }
            $run->register();
        } 
    }
}