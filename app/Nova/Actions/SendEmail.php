<?php

namespace App\Nova\Actions;

use App\Notifications\CustomMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;

class SendEmail extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    public $name = 'Send Email';

    public $confirmButtonText = 'Send';

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each->notify(new CustomMail($fields->subject, $fields->body));

        return Action::message('Mails sent to selected users!');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Subject')->rules('required'),

            Markdown::make('Body')->rules('required'),
        ];
    }
}
