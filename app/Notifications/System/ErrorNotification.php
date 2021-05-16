<?php

namespace App\Notifications\System;

use Throwable;
use Illuminate\Http\Request;
use App\Base\SlackNotification;
use Illuminate\Contracts\Auth\Authenticatable;

class ErrorNotification extends SlackNotification
{
    /** @var Throwable */
    private $exception;

    /** @var \Illuminate\Http\Request */
    public $request;

    /** @var \App\User|null */
    public $user;

    protected $content = 'Whoops! Something went wrong.';

    protected $level = 'error';

    /**
     * @param \Throwable $exception
     * @param \Illuminate\Http\Request $request
     * @param Authenticatable $user
     */
    public function __construct(Throwable $exception, Request $request, Authenticatable $user = null)
    {
        $this->exception = $exception;
        $this->request = $request;
        $this->user = $user;
    }

    protected function channel(): string
    {
        return config('services.slack.log-channel');
    }

    protected function fields(): array
    {
        $e = $this->exception;

        $fields = collect([
            'Request URL'  => $this->request->fullUrl(),
            'Request Type' => $this->request->getMethod(),
            'Code'         => $e->getCode(),
            'Message'      => $e->getMessage(),
            'File'         => $e->getFile(),
            'Line'         => $e->getLine(),
        ]);

        if ($this->user) {
            $fields->put('User ID', $this->user->id);
            $fields->put('User Name', $this->user->name);
        }

        return $fields->toArray();
    }
}
