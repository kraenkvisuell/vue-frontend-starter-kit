<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Collection;

class CreateImportedArticleFilesCollection extends Command
{
    protected $signature = 'shop:create-imported-article-files-collection';

    public function handle()
    {
        $this->createOrUpdateCollection();

        $this->info('done creating imported article files collection.');
    }

    protected function createOrUpdateCollection()
    {
        $collection = Collection::make('imported_article_files');

        $collection
            ->title('Imported Article Files')
            ->dated(true)
            ->requiresSlugs(false)
            ->structure(null)
            ->sites(['default'])
            ->searchIndex('imported_article_files')
            ->defaultPublishState(true);

        $collection->save();
    }
}
