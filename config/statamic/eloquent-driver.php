<?php

return [

    'connection' => env('STATAMIC_ELOQUENT_CONNECTION', ''),
    'table_prefix' => env('STATAMIC_ELOQUENT_PREFIX', ''),

    'assets' => [
        'driver' => 'file',
        'container_model' => \Statamic\Eloquent\Assets\AssetContainerModel::class,
        'model' => \Statamic\Eloquent\Assets\AssetModel::class,
    ],

    'blueprints' => [
        'driver' => 'file',
    ],

    'collections' => [
        'driver' => 'file',
        'model' => \Statamic\Eloquent\Collections\CollectionModel::class,
        'tree' => \Statamic\Eloquent\Structures\CollectionTree::class,
        'tree_model' => \Statamic\Eloquent\Structures\TreeModel::class,
    ],

    'entries' => [
        'driver' => 'eloquent',
        'model' => \Statamic\Eloquent\Entries\UuidEntryModel::class,
        'entry' => \Statamic\Eloquent\Entries\Entry::class,
    ],

    'forms' => [
        'driver' => 'eloquent',
        'model' => \Statamic\Eloquent\Forms\FormModel::class,
        'submission_model' => \Statamic\Eloquent\Forms\SubmissionModel::class,
    ],

    'global_sets' => [
        'driver' => 'eloquent',
        'model' => \Statamic\Eloquent\Globals\GlobalSetModel::class,
        'variables_model' => \Statamic\Eloquent\Globals\VariablesModel::class,
    ],

    'navigations' => [
        'driver' => 'eloquent',
        'model' => \Statamic\Eloquent\Structures\NavModel::class,
        'tree' => \Statamic\Eloquent\Structures\NavTree::class,
        'tree_model' => \Statamic\Eloquent\Structures\TreeModel::class,
    ],

    'revisions' => [
        'driver' => 'eloquent',
        'model' => \Statamic\Eloquent\Revisions\RevisionModel::class,
    ],

    'taxonomies' => [
        'driver' => 'eloquent',
        'model' => \Statamic\Eloquent\Taxonomies\TaxonomyModel::class,
    ],

    'terms' => [
        'driver' => 'eloquent',
        'model' => \Statamic\Eloquent\Taxonomies\TermModel::class,
    ],
];
