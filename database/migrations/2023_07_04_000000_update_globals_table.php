<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Statamic\Eloquent\Database\BaseMigration as Migration;
use Statamic\Eloquent\Globals\GlobalSetModel;
use Statamic\Eloquent\Globals\VariablesModel;

return new class extends Migration {
    public function up()
    {
        Schema::create($this->prefix('global_set_variables'), function (Blueprint $table) {
            $table->id();
            $table->string('handle')->index();
            $table->string('locale')->nullable();
            $table->string('origin')->nullable();
            $table->jsonb('data');
            $table->timestamps();
        });

        Schema::table($this->prefix('global_sets'), function (Blueprint $table) {
            $table->jsonb('settings')->after('title')->nullable();
        });

        GlobalSetModel::all()
            ->each(function ($model) {
                $localizations = json_decode($model->localizations);

                foreach ($localizations as $localization) {
                    VariablesModel::create([
                        'handle' => $model->handle,
                        'locale' => $localization->locale,
                        'data' => $localization->data,
                        'origin' => $localization->origin,
                    ]);
                }
            });

        Schema::table($this->prefix('global_sets'), function (Blueprint $table) {
            $table->dropColumn('localizations');
        });
    }

    public function down()
    {
        Schema::table($this->prefix('global_sets'), function (Blueprint $table) {
            $table->dropColumn('settings');
            $table->jsonb('localizations')->after('title')->nullable();
        });

        GlobalSetModel::all()
            ->each(function ($model) {
                $model->localizations = VariablesModel::where('handle', $model->handle)
                    ->get()
                    ->mapWithKeys(function ($variable, $key) {
                        return [
                            $variable->locale = [
                                'locale' => $variable->locale,
                                'data' => $variable->data,
                                'origin' => $variable->origin,
                            ],
                        ];
                    });

                $model->save();
            });
    }
};
