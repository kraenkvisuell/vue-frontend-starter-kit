<?php

test('lasso-bundle.json exists', function () {
    expect(base_path('lasso-bundle.json'))->toBeFile();
});

test('assets are built or not needed', function () {
    $jsonTimestamp = File::lastModified(base_path('lasso-bundle.json'));

    $jsFiles = Storage::disk('resources')->allFiles('js');
    $cssFiles = Storage::disk('resources')->allFiles('css');

    $allFiles = array_merge($jsFiles, $cssFiles);

    $newerFiles = [];

    foreach ($allFiles as $file) {
        if (!Str::startsWith($file, '.')) {
            $timestamp = File::lastModified(base_path('resources/' . $file));

            if ($timestamp > $jsonTimestamp) {
                $newerFiles[] = $file;
            }
        }
    }

    expect($newerFiles)->toBeEmpty();
});
