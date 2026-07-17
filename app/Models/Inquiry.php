<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'type', 'name', 'email', 'phone', 'subject', 'message',
        'status', 'notes', 'ip_address',
    ];

    const TYPE_QUOTE          = 'quote';
    const TYPE_CONTACT_WIDGET = 'contact_widget';
    const TYPE_CONTACT_PAGE   = 'contact_page';

    const STATUS_NEW     = 'new';
    const STATUS_READ    = 'read';
    const STATUS_REPLIED = 'replied';

    public function typeLabel(): string
    {
        return [
            'quote'          => 'Get A Free Quote',
            'contact_widget' => 'Contact Widget',
            'contact_page'   => 'Contact Page',
        ][$this->type] ?? $this->type;
    }
}
