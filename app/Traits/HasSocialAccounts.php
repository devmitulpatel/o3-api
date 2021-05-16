<?php

namespace App\Traits;

trait HasSocialAccounts
{
    public function social_accounts()
    {
        return $this->hasMany(\App\Models\SocialAccount::class);
    }
}
