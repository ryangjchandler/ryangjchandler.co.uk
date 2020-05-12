<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerDirectives();
    }

    private function registerDirectives()
    {
        Blade::directive('pushonce', function ($expression) {
            [$pushName, $pushSub] = explode(':', trim(substr($expression, 1, -1)));

            $key = '__pushonce_'.str_replace('-', '_', $pushName).'_'.str_replace('-', '_', $pushSub);

            return "<?php if(! isset(\$__env->{$key})): \$__env->{$key} = 1; \$__env->startPush('{$pushName}'); ?>";
        });

        Blade::directive('endpushonce', function () {
            return '<?php $__env->stopPush(); endif; ?>';
        });

        Blade::directive('active', function ($expression) {
            return "<?php echo active_classes({$expression}); ?>";
        });
    }
}
