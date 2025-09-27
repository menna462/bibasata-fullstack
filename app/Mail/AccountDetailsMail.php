<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order; // استيراد موديل Order

class AccountDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order; 

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // تحديد عنوان البريد الإلكتروني والموضوع
        return new Envelope(
            subject: 'Your Subscription Account Details for Order #' . $this->order->id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // تحديد قالب البريد الإلكتروني الذي سيتم استخدامه
        return new Content(
            view: 'email.account_details',
            with: [
                'userName' => $this->order->user->name ?? 'Valued Customer',
                'accountEmail' => $this->order->account->email,
                'accountPassword' => $this->order->account->password,
                'productName' => $this->order->product->name_en ?? ($this->order->bundle->name_en ?? 'N/A'),
                'durationInDays' => $this->order->duration_in_days,
                'startDate' => $this->order->start_date ? $this->order->start_date->format('Y-m-d') : 'N/A',
                'endDate' => $this->order->end_date ? $this->order->end_date->format('Y-m-d') : 'N/A',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
