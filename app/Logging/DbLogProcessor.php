<?php

namespace App\Logging;

use Illuminate\Support\Facades\Auth;
use Monolog\Processor\IntrospectionProcessor;

class DbLogProcessor extends IntrospectionProcessor
{
    public function __invoke(array $record): array
    {
        //add introspection fileds from parent processor to $record['extra']
        $record = parent::__invoke($record);

        //we are adding
        //favor context over Auth ... if passed along */
        $record['extra']['user'] = isset($record['context']['user']) ? $record['context']['user'] : (Auth::user() ? Auth::user()->email : NULL);
        $record['extra']['origin'] = request()->headers->get('origin');
        $record['extra']['ip'] = request()->server('REMOTE_ADDR');
        $record['extra']['user_agent'] = request()->server('HTTP_USER_AGENT');

        return $record;
    }
}
