<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class SendMessageModal extends Component
{
    public $title;
    public $message;

    protected $rules = [
        'title' => 'required|string|max:255',
        'message' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.send-message-modal');
    }

    public function submit()
    {
        $this->validate();

        try {
            Message::create([
                'title' => $this->title,
                'message' => $this->message,
            ]);

            $this->dispatch(
                'toast-show',
                type: 'success',
                message: 'Message Sent',
                description: 'Your message has been successfully submitted'
            );

            $this->dispatch('close-message-modal');
            $this->reset(['title', 'message']);
        } catch (\Exception $e) {
            $this->dispatch(
                'toast-show',
                type: 'danger',
                message: 'Error',
                description: 'Failed to send message. Please try again.'
            );
        }
    }
}
