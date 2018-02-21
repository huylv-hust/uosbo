<?php

return array(
    'driver' => 'file',
    'file'   => array(
        'cookie_name'    => 'fuelfid',				// name of the session cookie for file based sessions
        'path'           =>	APPPATH . '/tmp',		// path where the session files should be stored
        'gc_probability' =>	5,						// probability % (between 0 and 100) for garbage collection
    ),
);
