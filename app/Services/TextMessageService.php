<?php
namespace App\Services;

use App\Models\TextMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TextMessageService {

    public function sendMessage(array $data, Collection $records): void
    {
        // Validate that the 'message' key exists.
        if (!isset($data['message'])) {
            throw new \InvalidArgumentException("The 'message' key is required in the data array.");
        }

        $textMessages = collect([]);

        $records->each(function ($record) use ($data, $textMessages) {
            $msg = $this->sendTextMessage($record, $data);
            $textMessages->push($msg);
        });

        TextMessage::insert($textMessages->toArray());
    }

    public function sendTextMessage(User $record, array $data): array
    {
        $messageTemplate = $data['message'];
        $message = Str::replace('{name}', $record->name, $messageTemplate);

        return [
            'message'           => $message,
            'sent_by'           => auth()?->id() ?? null,
            'status'            => TextMessage::STATUS['PENDING'],
            'response_payload'  => '',
            'sent_to'           => $record->id,
            'remarks'           => $data['remarks'] ?? null,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}
