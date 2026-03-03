<?php

namespace App\Http\Controllers\utility;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PrintingController extends Controller
{
    public function print($model, $id)
    {
        $className = '\\App\\Models\\' . Str::studly($model);
        $modelName = Str::afterLast($model, '\\');

        if (!class_exists($className)) {
            abort(404, 'Model not found.');
        }

        $record = $className::findOrFail($id);

        // Convert to displayable array
        $data = collect($record->getAttributes())
            ->filter(fn($val, $key) => $key !== 'id' && !Str::endsWith($key, '_id'))
            ->map(fn($val, $key) => [
                'label' => Lang::has('general.' . $key) ? __('general.' . $key) : Str::headline(str_replace('_', ' ', $key)),
                'value' => $this->translateValue($val, $key),
            ])
            ->values();

        $modelTranslationKey = 'general.' . Str::snake($modelName);
        $modelTranslated = Lang::has($modelTranslationKey) ? __($modelTranslationKey) : $modelName;

        if ($model == 'client\Client' || $model == 'user\User') {
            $title = $modelTranslated . ' - ' . $record->name;
        } else {
            $title = $modelTranslated . ' - ' . ($record->subject ?? $record->name ?? $record->number);
        }

        $createdAtLabel = Lang::has('general.created_at') ? __('general.created_at') : 'created at';
        $printedAtLabel = Lang::has('general.printed_at') ? __('general.printed_at') : 'printed at';

        $subtitle = $createdAtLabel . ': ' . $record->created_at . ' | ' . $printedAtLabel . ': ' . now()->format('Y-m-d H:i:s');

        return view('utility.print.index', compact('data', 'title', 'subtitle'));
    }

    private function translateValue($val, $key)
    {
        if (empty($val)) {
            return null;
        }

        if (is_string($val)) {
            $snakeVal = Str::snake($val);
            if (Lang::has('general.' . $snakeVal)) {
                return __('general.' . $snakeVal);
            }
        }

        return is_string($val) || is_numeric($val) ? $val : json_encode($val);
    }
}
