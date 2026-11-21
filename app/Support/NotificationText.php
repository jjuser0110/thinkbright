<?php

namespace App\Support;

/**
 * Notifications are stored with an untranslated message key and parameters, so each
 * reader sees them in their own language. Parameters listed in "translate" (e.g. a
 * weekday or leave type) are translated too; names and dates are shown as stored.
 */
class NotificationText
{
    /** Build the data array to store for a notification. */
    public static function make(string $key, array $params, string $url, array $translate = []): array
    {
        return [
            'key' => $key,
            'params' => $params,
            'translate' => $translate,
            'message' => __($key, $params, 'en'),
            'url' => $url,
        ];
    }

    /** Render a stored notification's data in the current locale. */
    public static function render(array $data): string
    {
        if (empty($data['key'])) {
            return $data['message'] ?? __('Notification');
        }

        $params = $data['params'] ?? [];
        foreach ($data['translate'] ?? [] as $name) {
            if (isset($params[$name]) && is_string($params[$name])) {
                $params[$name] = __($params[$name]);
            }
        }

        $text = __($data['key'], $params);

        return isset($data['suffix']) && $data['suffix'] !== '' ? $text.': '.$data['suffix'] : $text;
    }
}
