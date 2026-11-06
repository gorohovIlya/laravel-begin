<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function handle(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^(?:\+7|8)\d{10}$/'
            ],
            'agreed' => 'accepted'
        ]);

        $data['created_at'] = now()->toDateTimeString();

        $folder = 'users';
        $disk = Storage::disk('local');

        if (!$disk->exists($folder)) {
            $disk->makeDirectory($folder);
        }

        $files = $disk->files($folder);

        $maxId = 0;
        foreach ($files as $file) {
            $fileName = basename($file);
            if (preg_match('/^user_(\d+)\.json$/', $fileName, $matches)) {
                $currentId = (int)$matches[1];
                if ($currentId > $maxId) {
                    $maxId = $currentId;
                }
            }
        }

        $newId = $maxId + 1;
        $newFileName = $folder . '/user_' . $newId . '.json';
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $disk->put($newFileName, $jsonContent);

        return redirect()->route('register.success');
    }

    public function success()
    {
        return view('success');
    }

    public function participants()
    {
        $folder = 'users';
        $disk = Storage::disk('local');
        $participants = [];

        if ($disk->exists($folder)) {
            $files = $disk->files($folder);
            sort($files);

            foreach ($files as $file) {
                $fileName = basename($file);
                if (preg_match('/^user_\d+\.json$/', $fileName)) {
                    $content = $disk->get($file);
                    $decoded = json_decode($content, true);
                    if (is_array($decoded)) {
                        $participants[] = $decoded;
                    }
                }
            }
        }

        return view('participants', ['participants' => $participants]);
    }
}
